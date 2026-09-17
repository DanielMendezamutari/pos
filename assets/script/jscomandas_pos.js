/**
 * Módulo de Integración de Comandas Móviles para el POS Web (Ribersoft)
 * Gestiona:
 *   1. Notificaciones en vivo de comandas de meseras (polling cada 5 seg).
 *   2. Filtros y totales acumulados por mesa (Mesa 1, Mesa 2, etc.).
 *   3. Panel de Cuenta Acumulada de la Mesa con desglose consolidado y cobro total de la mesa.
 *   4. Pestañas de Comandas Pendientes vs Comandas Ya Cobradas Hoy.
 *   5. Opción de Anular / Descartar comandas de prueba o duplicadas.
 *   6. Carga atómica al carrito del POS (cargar_lote) y apertura infalible de #myModalPago.
 *   7. Gestión de Mesas y Meseras del Turno.
 * 
 * Autor: Ing. Daniel Méndez Amutari
 */

var codsucursalActual = 0;
var idComandasActivasCobro = [];
var audioNotificacion = null;
var ultimaCantidadComandas = 0;
window.comandasPendientesCache = [];
window.comandasCobradasCache = [];
window.filtroMesaActual = 'TODAS';
window.filtroMesaCobradasActual = 'TODAS';

$(document).ready(function() {
    // Obtener codsucursal de la sesión activa
    codsucursalActual = window.CODSUCURSAL_ACTIVA || $("#codsucursal").val() || 2;

    // Inicializar audio sutil de notificación
    try {
        audioNotificacion = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
    } catch(e) {}

    // Keep-alive silencioso de sesión cada 4 minutos para evitar que la sesión de la cajera expire por inactividad
    iniciarKeepAliveSesion();

    // Polling de comandas pendientes cada 5 segundos
    setInterval(consultarComandasPendientes, 5000);
    consultarComandasPendientes();

    // Hook blindado para marcar comandas como cobradas ÚNICAMENTE cuando el POS guarde la venta con éxito
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url && settings.url.indexOf('pos.php') !== -1 && idComandasActivasCobro && idComandasActivasCobro.length > 0) {
            var resp = (xhr.responseText || '').trim();

            // Detectar si la respuesta es de SESIÓN EXPIRADA o NO AUTORIZADO
            var sesionExpirada = (resp.indexOf('EXPIRADO') !== -1 || 
                                  resp.indexOf('INICIAR SESION') !== -1 || 
                                  resp.indexOf('DEBERA DE INICIAR') !== -1 ||
                                  resp.indexOf('logout') !== -1 ||
                                  resp.indexOf('NO TIENES PERMISO') !== -1);

            if (sesionExpirada) {
                // BLINDAJE: NUNCA marcar comanda como cobrada si la sesión expiró
                idComandasActivasCobro = [];
                swal({
                    title: "¡Sesión Expirada!",
                    text: "Tu sesión en el sistema ha caducado por tiempo. La comanda NO se cobró y permanece segura en PENDIENTES. Por favor inicia sesión nuevamente en el POS.",
                    type: "warning",
                    confirmButtonText: "Entendido",
                    closeOnConfirm: true
                });
                consultarComandasPendientes();
                return;
            }

            // BLINDAJE ESTRICTO: Solo marcar como cobrada si la venta fue confirmada explícitamente por el backend
            var esVentaExitosa = (resp.indexOf('REGISTRADA EXITOSAMENTE') !== -1 || 
                                  resp.indexOf('reportepdf') !== -1 || 
                                  resp.indexOf('fa-check-square-o') !== -1);

            if (esVentaExitosa) {
                var comandasParaCobrar = idComandasActivasCobro.slice();
                idComandasActivasCobro = [];
                $.ajax({
                    url: 'api/comandas/cobrar.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        ids: comandasParaCobrar,
                        codventa: $("#codfactura").val() || 'VENTA_POS'
                    }),
                    success: function() {
                        consultarComandasPendientes();
                        if ($("#pills-cobradas").hasClass("active")) {
                            cargarComandasCobradas();
                        }
                    }
                });
            } else {
                // Si hubo un error del 1 al 15 o un fallo de validación, liberar las comandas retenidas
                // para que sigan disponibles en pendientes y no queden bloqueadas
                idComandasActivasCobro = [];
                consultarComandasPendientes();
            }
        }
    });
});

/**
 * Consulta comandas pendientes en la API
 */
function consultarComandasPendientes() {
    if (!codsucursalActual) {
        codsucursalActual = window.CODSUCURSAL_ACTIVA || $("#codsucursal").val() || 2;
    }
    if (!codsucursalActual) return;

    $.ajax({
        url: 'api/comandas/pendientes.php?sucursal=' + codsucursalActual,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res && res.success) {
                var total = res.total_pendientes || 0;
                window.comandasPendientesCache = res.comandas || [];

                $("#badge_comandas_count").text(total);
                $("#tab_badge_pendientes").text(total);

                if (total > 0) {
                    $("#btn_comandas_pendientes").removeClass("btn-dark").addClass("btn-warning pulse-conteo");
                    $("#badge_comandas_count").removeClass("badge-secondary").addClass("badge-danger");

                    if (total > ultimaCantidadComandas && audioNotificacion) {
                        audioNotificacion.play().catch(function(){});
                    }
                } else {
                    $("#btn_comandas_pendientes").removeClass("btn-warning pulse-conteo").addClass("btn-dark");
                    $("#badge_comandas_count").removeClass("badge-danger").addClass("badge-secondary");
                }
                ultimaCantidadComandas = total;

                // Si el modal está visible y la pestaña de pendientes está activa
                if ($("#myModalComandas").is(":visible") && $("#pills-pendientes").hasClass("active")) {
                    renderizarListaComandas(window.comandasPendientesCache);
                }
            }
        }
    });
}

/**
 * Abre el modal de comandas
 */
function abrirModalComandas() {
    $("#myModalComandas").modal("show");
    // Activar pestaña de pendientes por defecto
    $('#pills-pendientes-tab').tab('show');
    consultarComandasPendientes();
}

/**
 * Dibuja las comandas pendientes con filtros por mesa, tarjeta de cuenta acumulada y botón para descartar
 */
function renderizarListaComandas(comandas) {
    if (!comandas) comandas = window.comandasPendientesCache || [];

    // 1. Calcular totales agrupados por mesa para el resumen
    var mesasResumen = {};
    var totalGeneralPendiente = 0;
    comandas.forEach(function(c) {
        var mesa = (c.nombre_mesa || 'Barra').trim();
        var mTotal = parseFloat(c.total || 0);
        totalGeneralPendiente += mTotal;
        if (!mesasResumen[mesa]) {
            mesasResumen[mesa] = { total: 0, count: 0, meseras: {} };
        }
        mesasResumen[mesa].total += mTotal;
        mesasResumen[mesa].count++;
        if (c.nombre_mesera) {
            mesasResumen[mesa].meseras[c.nombre_mesera] = true;
        }
    });

    // 2. Renderizar botones de filtro por mesa
    var filtrosHtml = '<span class="mr-2 font-12 font-weight-bold text-muted"><i class="fa fa-filter"></i> Mesas Activas:</span>';
    var activeClassTodas = (window.filtroMesaActual === 'TODAS') ? 'btn-primary text-white shadow-sm' : 'btn-outline-secondary';
    filtrosHtml += '<button type="button" class="btn btn-sm ' + activeClassTodas + ' mr-2 mb-1" onclick="filtrarComandasPorMesa(\'TODAS\')">' +
                   '<b>Ver Todas (' + comandas.length + ')</b> <span class="badge badge-light ml-1 font-11">Bs. ' + totalGeneralPendiente.toFixed(2) + '</span>' +
                   '</button>';

    Object.keys(mesasResumen).forEach(function(mNombre) {
        var info = mesasResumen[mNombre];
        var isActive = (window.filtroMesaActual === mNombre);
        var btnCls = isActive ? 'btn-warning text-dark font-weight-bold shadow-sm' : 'btn-outline-dark';
        filtrosHtml += '<button type="button" class="btn btn-sm ' + btnCls + ' mr-2 mb-1" onclick="filtrarComandasPorMesa(\'' + mNombre + '\')">' +
                       '<i class="fa fa-th"></i> <b>' + mNombre + '</b> (' + info.count + ') ' +
                       '<span class="badge badge-warning text-dark font-11 ml-1">Bs. ' + info.total.toFixed(2) + '</span>' +
                       '</button>';
    });

    $("#contenedor_filtros_mesas").html(filtrosHtml);

    // 3. Filtrar comandas según mesa seleccionada
    var comandasFiltradas = comandas;
    if (window.filtroMesaActual !== 'TODAS') {
        comandasFiltradas = comandas.filter(function(c) {
            return (c.nombre_mesa || 'Barra').trim() === window.filtroMesaActual;
        });
    }

    // 4. Renderizar contenido
    var html = '';

    // Si una mesa específica está seleccionada (ej. Mesa 1) y tiene comandas, mostrar TARJETA RESUMEN DE CUENTA
    if (window.filtroMesaActual !== 'TODAS' && comandasFiltradas.length > 0) {
        var infoMesaActiva = mesasResumen[window.filtroMesaActual] || { total: 0, count: comandasFiltradas.length, meseras: {} };
        var listaMeseras = Object.keys(infoMesaActiva.meseras).join(', ') || 'Mesera';

        // Consolidar productos consumidos en la mesa
        var productosConsolidados = {};
        comandasFiltradas.forEach(function(c) {
            (c.items || []).forEach(function(it) {
                var nombre = it.producto || it.nombre || 'Producto';
                var cant = parseFloat(it.cantidad || 1);
                var sub = parseFloat(it.subtotal || (cant * (it.precio || 0)));
                if (!productosConsolidados[nombre]) {
                    productosConsolidados[nombre] = { cantidad: 0, subtotal: 0, precio: it.precio };
                }
                productosConsolidados[nombre].cantidad += cant;
                productosConsolidados[nombre].subtotal += sub;
            });
        });

        var badgesConsolidadosHtml = '';
        Object.keys(productosConsolidados).forEach(function(pNom) {
            var pData = productosConsolidados[pNom];
            badgesConsolidadosHtml += '<span class="badge badge-light border border-secondary text-dark px-2 py-1 mr-2 mb-1 font-12">' +
                                      '<b>' + pData.cantidad + 'x</b> ' + pNom + ' <span class="text-success font-weight-bold ml-1">(Bs. ' + pData.subtotal.toFixed(2) + ')</span>' +
                                      '</span>';
        });

        html += '<div class="card border border-success mb-4 shadow" style="background: #f4fff6; border-left: 6px solid #28a745 !important;">' +
                '  <div class="card-body p-3">' +
                '    <div class="d-flex justify-content-between align-items-center flex-wrap">' +
                '      <div>' +
                '        <h4 class="mb-1 text-dark font-weight-bold">' +
                '          <i class="fa fa-th text-warning"></i> ' + window.filtroMesaActual.toUpperCase() + ' — CUENTA TOTAL ACUMULADA' +
                '        </h4>' +
                '        <span class="badge badge-warning text-dark font-13 mr-2">' +
                '          <i class="fa fa-cutlery"></i> ' + comandasFiltradas.length + ' comanda(s) pendiente(s)' +
                '        </span>' +
                '        <span class="text-muted font-12"><i class="fa fa-user"></i> Mesera(s): <b>' + listaMeseras + '</b></span>' +
                '      </div>' +
                '      <div class="text-right mt-2 mt-md-0">' +
                '        <div class="font-26 font-weight-bold text-success mb-1">Bs. ' + infoMesaActiva.total.toFixed(2) + '</div>' +
                '        <button type="button" class="btn btn-success btn-lg font-weight-bold shadow-sm" onclick="cobrarCuentaCompletaMesa(\'' + window.filtroMesaActual + '\')">' +
                '          <i class="fa fa-calculator"></i> COBRAR CUENTA COMPLETA (' + window.filtroMesaActual + ')' +
                '        </button>' +
                '      </div>' +
                '    </div>' +
                '    <div class="mt-3 pt-2 border-top">' +
                '      <div class="text-muted font-weight-bold font-12 text-uppercase mb-1"><i class="fa fa-shopping-basket"></i> Todo lo que ha consumido esta mesa hasta el momento:</div>' +
                '      <div class="d-flex flex-wrap">' + badgesConsolidadosHtml + '</div>' +
                '    </div>' +
                '  </div>' +
                '</div>' +
                '<h5 class="text-muted font-weight-bold mb-3"><i class="fa fa-list"></i> Detalle de Comandas Individuales de ' + window.filtroMesaActual + ':</h5>';
    }

    if (comandasFiltradas.length === 0) {
        html += '<div class="alert alert-info text-center p-4">' +
                '<i class="fa fa-coffee fa-3x mb-3 text-muted"></i><br>' +
                '<h4>No hay comandas pendientes ' + (window.filtroMesaActual !== 'TODAS' ? 'en ' + window.filtroMesaActual : '') + '</h4>' +
                '<p class="text-muted">Las órdenes que tomen las meseras en sus celulares aparecerán aquí automáticamente.</p>' +
                '</div>';
    } else {
        comandasFiltradas.forEach(function(c) {
            var itemsHtml = '';
            var items = c.items || [];
            items.forEach(function(it) {
                var nombreProd = it.producto || it.nombre || 'Producto';
                itemsHtml += '<tr>' +
                             '<td><b>' + it.cantidad + 'x</b> ' + nombreProd + '</td>' +
                             '<td class="text-right">Bs. ' + parseFloat(it.precio || 0).toFixed(2) + '</td>' +
                             '<td class="text-right font-weight-bold">Bs. ' + parseFloat(it.subtotal || 0).toFixed(2) + '</td>' +
                             '</tr>';
            });

            var tiempoTexto = c.minutos_transcurridos == 0 ? 'Hace un instante' : 'Hace ' + c.minutos_transcurridos + ' min';

            var badgePago = (c.metodo_pago === 'QR')
                ? '<span class="badge badge-info px-2 py-1 font-12 ml-1"><i class="fa fa-qrcode"></i> Cobro QR</span>'
                : '<span class="badge badge-success px-2 py-1 font-12 ml-1"><i class="fa fa-money"></i> Efectivo</span>';

            html += '<div class="card border mb-3 shadow-sm" style="border-left: 5px solid #ffb22b !important;">' +
                    '<div class="card-body p-3">' +
                    '  <div class="d-flex justify-content-between align-items-center mb-2">' +
                    '    <div>' +
                    '      <span class="badge badge-warning text-dark px-2 py-1 font-14"><i class="fa fa-th"></i> ' + (c.nombre_mesa || 'Barra') + '</span>' +
                    '      <span class="badge badge-secondary px-2 py-1 font-12 ml-1"><i class="fa fa-user"></i> Mesera: ' + (c.nombre_mesera || 'Mesera') + '</span>' +
                    '      ' + badgePago +
                    '      <span class="text-muted font-12 ml-2"><i class="fa fa-clock-o"></i> ' + tiempoTexto + ' (' + c.fechahora.substr(11, 5) + ')</span>' +
                    '    </div>' +
                    '    <div>' +
                    '      <span class="font-20 font-weight-bold text-dark mr-3">Bs. ' + parseFloat(c.total).toFixed(2) + '</span>' +
                    '      <button type="button" class="btn btn-success font-weight-bold" onclick="cargarComandaACarrito(' + c.idcomanda + ')">' +
                    '        <i class="fa fa-calculator"></i> COBRAR EN CAJA' +
                    '      </button>' +
                    '      <button type="button" class="btn btn-outline-danger btn-sm font-weight-bold ml-2" onclick="anularComanda(' + c.idcomanda + ')" title="Descartar o anular pedido">' +
                    '        <i class="fa fa-trash-o"></i> Descartar' +
                    '      </button>' +
                    '    </div>' +
                    '  </div>' +
                    '  <div class="table-responsive">' +
                    '    <table class="table table-sm table-striped mb-0">' +
                    '      <tbody>' + itemsHtml + '</tbody>' +
                    '    </table>' +
                    '  </div>' +
                    '</div>' +
                    '</div>';
        });
    }
    $("#contenedor_lista_comandas").html(html);
}

/**
 * Filtra la vista por una mesa específica
 */
function filtrarComandasPorMesa(nombreMesa) {
    window.filtroMesaActual = nombreMesa;
    renderizarListaComandas(window.comandasPendientesCache);
}

/**
 * Consulta y dibuja las comandas ya cobradas hoy
 */
function cargarComandasCobradas() {
    if (!codsucursalActual) return;
    $("#contenedor_lista_cobradas").html('<div class="text-center p-4"><i class="fa fa-spin fa-spinner fa-2x text-muted"></i> Cargando historial...</div>');

    $.ajax({
        url: 'api/comandas/cobradas.php?sucursal=' + codsucursalActual,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (!res || !res.success) {
                $("#contenedor_lista_cobradas").html('<div class="alert alert-danger text-center">No se pudo cargar el historial.</div>');
                return;
            }

            window.comandasCobradasCache = res.comandas || [];
            $("#tab_badge_cobradas").text(res.total_cobradas || 0);

            renderizarComandasCobradas(window.comandasCobradasCache);
        }
    });
}

/**
 * Dibuja las comandas ya cobradas con filtros por mesa
 */
function renderizarComandasCobradas(cobradas) {
    if (!cobradas) cobradas = window.comandasCobradasCache || [];

    // Calcular resumen por mesa
    var mesasCobradasResumen = {};
    var totalCobradoHoy = 0;
    cobradas.forEach(function(c) {
        var m = (c.nombre_mesa || 'Barra').trim();
        var t = parseFloat(c.total || 0);
        totalCobradoHoy += t;
        if (!mesasCobradasResumen[m]) {
            mesasCobradasResumen[m] = { total: 0, count: 0 };
        }
        mesasCobradasResumen[m].total += t;
        mesasCobradasResumen[m].count++;
    });

    var filtrosHtml = '<span class="mr-2 font-12 font-weight-bold text-muted"><i class="fa fa-filter"></i> Filtrar Cobradas:</span>';
    var activeTodas = (window.filtroMesaCobradasActual === 'TODAS') ? 'btn-success text-white shadow-sm' : 'btn-outline-secondary';
    filtrosHtml += '<button type="button" class="btn btn-sm ' + activeTodas + ' mr-2 mb-1" onclick="filtrarCobradasPorMesa(\'TODAS\')">' +
                   '<b>Ver Todas (' + cobradas.length + ')</b> <span class="badge badge-light ml-1 font-11">Bs. ' + totalCobradoHoy.toFixed(2) + '</span>' +
                   '</button>';

    Object.keys(mesasCobradasResumen).forEach(function(mNombre) {
        var info = mesasCobradasResumen[mNombre];
        var isActive = (window.filtroMesaCobradasActual === mNombre);
        var btnCls = isActive ? 'btn-success text-white font-weight-bold shadow-sm' : 'btn-outline-dark';
        filtrosHtml += '<button type="button" class="btn btn-sm ' + btnCls + ' mr-2 mb-1" onclick="filtrarCobradasPorMesa(\'' + mNombre + '\')">' +
                       '<i class="fa fa-th"></i> <b>' + mNombre + '</b> (' + info.count + ') ' +
                       '<span class="badge badge-success font-11 ml-1">Bs. ' + info.total.toFixed(2) + '</span>' +
                       '</button>';
    });

    var cobradasFiltradas = cobradas;
    if (window.filtroMesaCobradasActual !== 'TODAS') {
        cobradasFiltradas = cobradas.filter(function(c) {
            return (c.nombre_mesa || 'Barra').trim() === window.filtroMesaCobradasActual;
        });
    }

    var html = '<div class="mb-3">' + filtrosHtml + '</div>';

    if (cobradasFiltradas.length === 0) {
        html += '<div class="alert alert-secondary text-center p-4">' +
                '<i class="fa fa-check-circle fa-3x mb-3 text-success"></i><br>' +
                '<h4>No hay comandas cobradas en ' + (window.filtroMesaCobradasActual !== 'TODAS' ? window.filtroMesaCobradasActual : 'este turno') + ' todavía</h4>' +
                '<p class="text-muted">A medida que cobres comandas en caja, aparecerán aquí registradas con su hora y detalle.</p>' +
                '</div>';
    } else {
        cobradasFiltradas.forEach(function(c) {
            var itemsHtml = '';
            var items = c.items || [];
            items.forEach(function(it) {
                var nombreProd = it.producto || it.nombre || 'Producto';
                itemsHtml += '<tr>' +
                             '<td><b>' + it.cantidad + 'x</b> ' + nombreProd + '</td>' +
                             '<td class="text-right">Bs. ' + parseFloat(it.precio || 0).toFixed(2) + '</td>' +
                             '<td class="text-right font-weight-bold">Bs. ' + parseFloat(it.subtotal || 0).toFixed(2) + '</td>' +
                             '</tr>';
            });

            var horaCobro = c.fechacobro ? c.fechacobro.substr(11, 5) : c.fechahora.substr(11, 5);

            html += '<div class="card border mb-3 shadow-sm" style="border-left: 5px solid #28a745 !important;">' +
                    '<div class="card-body p-3">' +
                    '  <div class="d-flex justify-content-between align-items-center mb-2">' +
                    '    <div>' +
                    '      <span class="badge badge-success px-2 py-1 font-14"><i class="fa fa-check"></i> COBRADA</span>' +
                    '      <span class="badge badge-dark px-2 py-1 font-13 ml-1"><i class="fa fa-th"></i> ' + (c.nombre_mesa || 'Barra') + '</span>' +
                    '      <span class="badge badge-secondary px-2 py-1 font-12 ml-1"><i class="fa fa-user"></i> ' + (c.nombre_mesera || 'Mesera') + '</span>' +
                    '      <span class="text-muted font-12 ml-2"><i class="fa fa-clock-o"></i> Cobrado a las ' + horaCobro + '</span>' +
                    '    </div>' +
                    '    <div>' +
                    '      <span class="font-20 font-weight-bold text-success mr-2">Bs. ' + parseFloat(c.total).toFixed(2) + '</span>' +
                    '      <button type="button" class="btn btn-outline-warning btn-sm font-weight-bold ml-1" onclick="reabrirComandaCobrada(' + c.idcomanda + ')" title="Devolver comanda a pendientes si no sumó o fue un cobro accidental">' +
                    '        <i class="fa fa-undo"></i> Devolver a Pendientes' +
                    '      </button>' +
                    '    </div>' +
                    '  </div>' +
                    '  <div class="table-responsive">' +
                    '    <table class="table table-sm table-striped mb-0">' +
                    '      <tbody>' + itemsHtml + '</tbody>' +
                    '    </table>' +
                    '  </div>' +
                    '</div>' +
                    '</div>';
        });
    }

    $("#contenedor_lista_cobradas").html(html);
}

function filtrarCobradasPorMesa(nombreMesa) {
    window.filtroMesaCobradasActual = nombreMesa;
    renderizarComandasCobradas(window.comandasCobradasCache);
}

/**
 * Anula o descarta una comanda pendiente
 */
function anularComanda(idcomanda) {
    swal({
        title: "¿Descartar comanda?",
        text: "¿Estás seguro de que deseas anular esta comanda de la lista de pendientes?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sí, descartar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: 'api/comandas/anular.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    idcomanda: idcomanda,
                    motivo: 'Descartada por cajera en POS'
                }),
                success: function(res) {
                    consultarComandasPendientes();
                }
            });
        }
    });
}

/**
 * Restaura una comanda cobrada/cancelada devolviéndola al estado PENDIENTE
 */
function reabrirComandaCobrada(idcomanda) {
    swal({
        title: "¿Devolver comanda a Pendientes?",
        text: "¿Deseas reabrir esta comanda para que vuelva a la lista de pendientes y pueda cobrarse nuevamente en caja?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f39c12",
        confirmButtonText: "Sí, devolver a pendientes",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: 'api/comandas/reabrir.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ idcomanda: idcomanda }),
                success: function(res) {
                    if (res && res.success) {
                        swal("¡Restaurada!", "La comanda ha vuelto a la lista de pendientes.", "success");
                        consultarComandasPendientes();
                        cargarComandasCobradas();
                        // Activar pestaña de pendientes
                        $('#pills-pendientes-tab').tab('show');
                    } else {
                        swal("Error", (res && res.mensaje) ? res.mensaje : "No se pudo restaurar la comanda.", "error");
                    }
                },
                error: function() {
                    swal("Error", "Error de comunicación al restaurar la comanda.", "error");
                }
            });
        }
    });
}

/**
 * Inicia el keep-alive silencioso de la sesión para evitar expiración por inactividad
 */
function iniciarKeepAliveSesion() {
    pingSesionCajera();
    setInterval(pingSesionCajera, 4 * 60 * 1000); // Cada 4 minutos
}

/**
 * Realiza un ping a session_ping.php para refrescar $_SESSION['time']
 */
function pingSesionCajera() {
    $.ajax({
        url: 'session_ping.php',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res && res.activo === false) {
                console.warn('[POS] Sesión no activa detectada por session_ping.');
            }
        },
        error: function() {
            // Silencioso ante pérdidas temporales de conexión
        }
    });
}

/**
 * Carga una comanda individual al carrito del POS y abre #myModalPago de inmediato
 */
function cargarComandaACarrito(idcomanda) {
    var comanda = (window.comandasPendientesCache || []).find(function(item) { return item.idcomanda == idcomanda; });
    if (!comanda) {
        consultarComandasPendientes();
        return;
    }

    ejecutarCargaLote([comanda], comanda.nombre_mesa || 'Barra', comanda.metodo_pago || 'EFECTIVO');
}

/**
 * Carga TODAS las comandas acumuladas de una mesa al carrito del POS y abre #myModalPago
 */
function cobrarCuentaCompletaMesa(nombreMesa) {
    var comandasMesa = (window.comandasPendientesCache || []).filter(function(item) {
        return (item.nombre_mesa || 'Barra').trim() === nombreMesa.trim();
    });

    if (comandasMesa.length === 0) {
        swal("Aviso", "No hay comandas pendientes para " + nombreMesa, "info");
        return;
    }

    // Determinar si alguna prefiere QR
    var metodoSugerido = comandasMesa.some(function(c) { return c.metodo_pago === 'QR'; }) ? 'QR' : 'EFECTIVO';

    ejecutarCargaLote(comandasMesa, nombreMesa, metodoSugerido);
}

/**
 * Ejecuta la carga atómica al carrito del POS vía cargar_lote y abre el modal de cobro nativo
 */
function ejecutarCargaLote(comandasArray, nombreMesa, metodoPago) {
    // 1. Acumular IDs de comandas que se van a cobrar
    idComandasActivasCobro = comandasArray.map(function(c) { return c.idcomanda; });

    // 2. Acumular ítems
    var itemsParaCarrito = [];
    var totalCobro = 0;

    comandasArray.forEach(function(c) {
        totalCobro += parseFloat(c.total || 0);
        var items = c.items || [];
        items.forEach(function(it) {
            var idProd = it.idproducto || it.id || 0;
            var codProd = it.codproducto || it.codigo || '';
            var nomProd = it.producto || it.nombre || 'Producto';
            var cant = parseFloat(it.cantidad || 1);
            var precio = parseFloat(it.precio || 0);
            var tipoDetalle = (it.tipoproducto === 'COMBO' || it.tipo === 'COMBO') ? 2 : 1;
            var tipoProd = it.tipoproducto || it.tipo || 'PRODUCTO';

            itemsParaCarrito.push({
                Id: idProd,
                Codigo: codProd,
                Producto: nomProd,
                Descripcion: '',
                Imei: '',
                Condicion: '',
                Codmarca: 0,
                Marcas: '',
                Codmodelo: 0,
                Modelos: '',
                Codpresentacion: 0,
                Presentacion: '',
                Codcolor: 0,
                Color: '',
                Precio: precio,
                Precio2: precio,
                Descproducto: 0,
                Ivaproducto: '(E)',
                Existencia: 99,
                Precioconiva: precio,
                TipoDetalle: tipoDetalle,
                TipoProducto: tipoProd,
                Cantidad: cant
            });
        });
    });

    // 3. Enviar lote a carritoventa.php
    $.post('carritoventa.php', {
        MiCarrito: JSON.stringify({
            Codigo: 'cargar_lote',
            Items: itemsParaCarrito
        })
    }, function(data) {
        // Redibujar el carrito nativo en pantalla
        renderizarCarritoNativoPOS(data);

        // Actualizar totales nativos del POS
        var totalStr = totalCobro.toFixed(2);
        var totalSep = typeof Separador === 'function' ? Separador(totalStr) : totalStr;

        $("#txtTotal").val(totalStr);
        $("#txtPagado").val(totalStr);
        $("#lbltotal").text(totalSep);
        $("#TextImporte").text(totalSep);
        $("#TextPagado").text(totalSep);
        $("#TextCambio").text('0.00');
        $("#montodevuelto").val('0.00');
        $("#montopagado").val(totalStr);
        $("#buttonpago").attr('disabled', false);

        if ($("#observaciones").length) {
            $("#observaciones").val('COMANDA ' + nombreMesa.toUpperCase());
        }

        // Configurar forma de pago sugerida
        if (metodoPago === 'QR') {
            $("#codmediopago option").each(function() {
                var txt = $(this).text().toUpperCase();
                if (txt.indexOf('QR') !== -1 || txt.indexOf('TRANSFERENCIA') !== -1) {
                    $(this).prop('selected', true);
                }
            });
        } else {
            $("#codmediopago option").each(function() {
                var txt = $(this).text().toUpperCase();
                if (txt.indexOf('EFECTIVO') !== -1) {
                    $(this).prop('selected', true);
                }
            });
        }

        // 4. Cerrar modal de comandas
        $("#myModalComandas").modal("hide");

        // 5. Limpieza de backdrop residual y apertura garantizada de #myModalPago
        setTimeout(function() {
            $(".modal-backdrop").remove();
            $("body").removeClass("modal-open");

            $("#myModalPago").modal({ backdrop: 'static', keyboard: false });
            $("#myModalPago").modal("show");

            setTimeout(function() {
                $("#montopagado").focus().select();
                if (typeof CalculoDevolucion === 'function') {
                    CalculoDevolucion();
                }
            }, 250);
        }, 300);
    }, 'json');
}

/**
 * Redibuja la tabla `#carrito tbody` con los ítems cargados
 */
function renderizarCarritoNativoPOS(items) {
    if (!Array.isArray(items)) return;
    var $tbody = $("#carrito tbody");
    $tbody.html("");

    if (items.length === 0) {
        $tbody.html("<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'><td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td></tr>");
        return;
    }

    items.forEach(function(item) {
        var cant = parseFloat(item.cantidad) || 1;
        var pVenta = parseFloat(item.precio2 || item.precio || 0);
        var sub = cant * pVenta;
        var pVentaStr = pVenta.toFixed(2);
        var subStr = sub.toFixed(2);
        var nomProd = (item.producto || 'Producto').replace(/'/g, "\\'");

        var pId = item.id || 0;
        var pCod = item.txtCodigo || '';
        var pTipoDet = item.tipodetalle || 1;

        var btnMinus = '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:5px 0px 0px 5px;" onclick="addItem(' + pId + ',\'' + pCod + '\',\'-1\',\'' + nomProd + '\',\'\',\'\',\'\',\'0\',\'*****\',\'0\',\'****\',\'0\',\'*****\',\'0\',\'*****\',\'' + pVentaStr + '\',\'' + pVentaStr + '\',\'0\',\'(E)\',\'99\',\'' + pVentaStr + '\',\'' + pTipoDet + '\',\'-\')"><span class="fa fa-minus"></span></button>';
        var btnPlus = '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' + pId + ',\'' + pCod + '\',\'+1\',\'' + nomProd + '\',\'\',\'\',\'\',\'0\',\'*****\',\'0\',\'****\',\'0\',\'*****\',\'0\',\'*****\',\'' + pVentaStr + '\',\'' + pVentaStr + '\',\'0\',\'(E)\',\'99\',\'' + pVentaStr + '\',\'' + pTipoDet + '\',\'+\')"><span class="fa fa-plus"></span></button>';
        var btnTrash = '<button class="btn btn-dark btn-sm" style="cursor:pointer;border-radius:5px;" onclick="addItem(' + pId + ',\'' + pCod + '\',\'0\',\'' + nomProd + '\',\'\',\'\',\'\',\'0\',\'*****\',\'0\',\'****\',\'0\',\'*****\',\'0\',\'*****\',\'' + pVentaStr + '\',\'' + pVentaStr + '\',\'0\',\'(E)\',\'99\',\'' + pVentaStr + '\',\'' + pTipoDet + '\',\'=\')"><span class="fa fa-trash-o"></span></button>';

        var fila = "<tr class='warning-element' style='border-left: 3px solid #28a745 !important; background: #f9fff9;' align='center'>" +
                   "<td>" + btnMinus + "<input type='text' class='bold text-center' style='width:45px;height:28px;' value='" + cant + "' readonly>" + btnPlus + "</td>" +
                   "<td class='text-left'><h6><strong>" + item.producto + "</strong></h6><small class='badge badge-light border text-muted'>" + (item.tipoproducto || 'PRODUCTO') + "</small></td>" +
                   "<td><strong>" + (typeof Separador === 'function' ? Separador(pVentaStr) : pVentaStr) + "</strong></td>" +
                   "<td><strong>" + (typeof Separador === 'function' ? Separador(subStr) : subStr) + "</strong></td>" +
                   "<td>" + btnTrash + "</td>" +
                   "</tr>";
        $tbody.append(fila);
    });
}

/**
 * ==============================================================
 * GESTIÓN DE MESAS Y SECTORES
 * ==============================================================
 */
function abrirModalGestionMesas() {
    $("#myModalGestionMesas").modal("show");
    cargarMesasEnModal();
}

function cargarMesasEnModal() {
    $.ajax({
        url: 'api/mesas/administrar.php?sucursal=' + codsucursalActual,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (!res || !res.success) return;
            var html = '';
            res.mesas.forEach(function(m) {
                var btnColor = m.estado == 1 ? 'btn-success' : 'btn-secondary';
                var btnText = m.estado == 1 ? 'Activa' : 'Inactiva';
                var nuevoEstado = m.estado == 1 ? 0 : 1;

                html += '<tr>' +
                        '  <td class="font-weight-bold font-14">' + m.nromesa + '</td>' +
                        '  <td><span class="badge ' + (m.estado == 1 ? 'badge-success' : 'badge-danger') + '">' + (m.estado == 1 ? 'Disponible' : 'Desactivada') + '</span></td>' +
                        '  <td class="text-right">' +
                        '    <button class="btn btn-sm ' + btnColor + '" onclick="cambiarEstadoMesa(' + m.codmesa + ', ' + nuevoEstado + ')">' +
                        '      <i class="fa fa-power-off"></i> ' + btnText +
                        '    </button>' +
                        '  </td>' +
                        '</tr>';
            });
            $("#tabla_mesas_body").html(html);
        }
    });
}

function guardarNuevaMesa() {
    var nombre = $("#input_nombre_mesa").val().trim();
    if (!nombre) {
        swal("Aviso", "Ingresa el nombre de la mesa o sector", "warning");
        return;
    }

    $.ajax({
        url: 'api/mesas/administrar.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            nromesa: nombre,
            codsucursal: codsucursalActual,
            estado: 1
        }),
        success: function(res) {
            if (res && res.success) {
                $("#input_nombre_mesa").val('');
                cargarMesasEnModal();
                swal("Éxito", res.mensaje, "success");
            }
        }
    });
}

function cambiarEstadoMesa(codmesa, nuevoEstado) {
    $.ajax({
        url: 'api/mesas/administrar.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            accion: 'estado',
            codmesa: codmesa,
            estado: nuevoEstado
        }),
        success: function() {
            cargarMesasEnModal();
        }
    });
}

/**
 * ==============================================================
 * GESTIÓN DE MESERAS Y ASIGNACIÓN DE PIN
 * ==============================================================
 */
function abrirModalGestionMeseras() {
    $("#myModalGestionMeseras").modal("show");
    cargarMeserasEnModal();
}

function cargarMeserasEnModal() {
    $.ajax({
        url: 'api/meseras/administrar.php?sucursal=' + codsucursalActual,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (!res || !res.success) return;
            var html = '';
            res.meseras.forEach(function(m) {
                html += '<tr>' +
                        '  <td class="font-weight-bold font-14"><i class="fa fa-user text-primary"></i> ' + m.nombre + '</td>' +
                        '  <td><span class="badge badge-warning font-14 px-2 py-1 font-weight-bold text-dark"><i class="fa fa-lock"></i> ' + m.pin + '</span></td>' +
                        '  <td><span class="badge ' + (m.estado == 1 ? 'badge-success' : 'badge-danger') + '">' + (m.estado == 1 ? 'En Turno' : 'Inactiva') + '</span></td>' +
                        '  <td class="text-right">' +
                        '    <button class="btn btn-sm btn-info" onclick="editarMesera(' + m.idmesera + ', \'' + m.nombre + '\', \'' + m.pin + '\')">' +
                        '      <i class="fa fa-pencil"></i> Cambiar PIN' +
                        '    </button>' +
                        '  </td>' +
                        '</tr>';
            });
            $("#tabla_meseras_body").html(html);
        }
    });
}

function guardarNuevaMesera() {
    var idmesera = $("#input_id_mesera").val();
    var nombre = $("#input_nombre_mesera").val().trim();
    var pin = $("#input_pin_mesera").val().trim();

    if (!nombre || pin.length !== 4) {
        swal("Aviso", "Nombre requerido y el PIN debe tener 4 dígitos exactos.", "warning");
        return;
    }

    $.ajax({
        url: 'api/meseras/administrar.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            idmesera: idmesera || null,
            nombre: nombre,
            pin: pin,
            codsucursal: codsucursalActual,
            estado: 1
        }),
        success: function(res) {
            if (res && res.success) {
                $("#input_id_mesera").val('');
                $("#input_nombre_mesera").val('');
                $("#input_pin_mesera").val('');
                $("#btn_guardar_mesera").text('Registrar Mesera');
                cargarMeserasEnModal();
                swal("Éxito", res.mensaje, "success");
            } else {
                swal("Error", res.mensaje || "No se pudo guardar", "error");
            }
        }
    });
}

function editarMesera(id, nombre, pin) {
    $("#input_id_mesera").val(id);
    $("#input_nombre_mesera").val(nombre);
    $("#input_pin_mesera").val(pin);
    $("#btn_guardar_mesera").html('<i class="fa fa-save"></i> Guardar Cambios');
}
