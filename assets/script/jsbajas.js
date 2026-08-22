// JS para Módulo de Retiros y Bajas de Mercadería

var debounceTimerBaja = null;

$(document).ready(function () {
    // Inicializar filtro de historial si estamos en bajas.php
    if ($("#tabla_historial_bajas_container").length > 0) {
        BuscarHistorialBajas();
    }
});

// Búsqueda en vivo al escribir en el input
function BuscarProductosEnVivoBaja(texto) {
    clearTimeout(debounceTimerBaja);

    var codsucursal = $("#codsucursal").val();
    if (!codsucursal || codsucursal === "" || codsucursal === "0") {
        swal("Aviso", "Por favor seleccione primero la Sucursal de origen en la parte superior.", "warning");
        $("#contenedor_resultados_busqueda").hide();
        return;
    }

    if (!texto || texto.trim().length === 0) {
        $("#contenedor_resultados_busqueda").slideUp();
        return;
    }

    debounceTimerBaja = setTimeout(function () {
        $("#contenedor_resultados_busqueda").slideDown();
        $("#body_resultados_busqueda").html('<div class="text-center p-3 text-danger"><i class="fa fa-spinner fa-spin fa-2x"></i><p class="mt-1 font-weight-bold">Buscando productos coincidentes...</p></div>');

        $.ajax({
            type: "GET",
            url: "class/busqueda_autocompleto.php",
            data: {
                Busqueda_Productos_Baja: "si",
                term: texto.trim(),
                codsucursal: codsucursal
            },
            dataType: "text",
            success: function (resp) {
                var items = [];
                if (typeof resp === "string") {
                    try {
                        var jsonStart = resp.indexOf('[');
                        var jsonStartObj = resp.indexOf('{');
                        if (jsonStart !== -1 && (jsonStartObj === -1 || jsonStart < jsonStartObj)) {
                            var jsonEnd = resp.lastIndexOf(']');
                            items = JSON.parse(resp.substring(jsonStart, jsonEnd + 1));
                        } else if (jsonStartObj !== -1) {
                            var jsonEnd = resp.lastIndexOf('}');
                            var parsed = JSON.parse(resp.substring(jsonStartObj, jsonEnd + 1));
                            items = parsed.results || [parsed];
                        }
                    } catch (e) {
                        console.error("Error parseando respuesta:", e, resp);
                    }
                } else if (Array.isArray(resp)) {
                    items = resp;
                } else if (resp && resp.results) {
                    items = resp.results;
                }

                if (!items || items.length === 0) {
                    $("#body_resultados_busqueda").html('<div class="text-center p-3 text-muted"><i class="fa fa-info-circle"></i> No se encontraron productos con ese nombre o código en esta sucursal.</div>');
                    return;
                }

                var html = '<table class="table table-hover table-sm table-striped mb-0" style="font-size: 13px;">' +
                    '<thead class="bg-light text-dark font-weight-bold">' +
                        '<tr>' +
                            '<th>Cód.</th>' +
                            '<th>Producto</th>' +
                            '<th class="text-center">Stock Actual</th>' +
                            '<th class="text-right">Costo Unit.</th>' +
                            '<th class="text-center">Acción</th>' +
                        '</tr>' +
                    '</thead>' +
                    '<tbody>';

                $.each(items, function (idx, p) {
                    var jsonStr = JSON.stringify(p).replace(/"/g, '&quot;');
                    var stock = parseFloat(p.existencia) || 0;
                    var costo = parseFloat(p.preciocompra) || 0;
                    var stockBadge = (stock > 0) ? '<span class="badge badge-success font-12">' + stock.toFixed(0) + ' u.</span>' : '<span class="badge badge-danger font-12">0 u.</span>';

                    html += '<tr>' +
                        '<td class="font-weight-bold text-center">' + p.codproducto + '</td>' +
                        '<td class="font-weight-bold">' + p.producto + '</td>' +
                        '<td class="text-center">' + stockBadge + '</td>' +
                        '<td class="text-right font-weight-bold">Bs. ' + costo.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>' +
                        '<td class="text-center">' +
                            '<button type="button" class="btn btn-danger btn-sm font-weight-bold py-1 px-2" onclick="AgregarProductoBaja(' + jsonStr + ')">' +
                                '<i class="fa fa-plus-circle"></i> + Agregar' +
                            '</button>' +
                        '</td>' +
                    '</tr>';
                });

                html += '</tbody></table>';
                $("#body_resultados_busqueda").html(html);
            },
            error: function (xhr, status, err) {
                console.error("Error AJAX bajas:", status, err);
                $("#body_resultados_busqueda").html('<div class="alert alert-danger mb-0 text-center"><i class="fa fa-exclamation-triangle"></i> Error al conectar con el buscador. Puede usar el botón de <b>Catálogo Completo</b>.</div>');
            }
        });
    }, 200);
}

// Abrir Modal de Catálogo Completo
function AbrirCatalogoModalBaja() {
    var codsucursal = $("#codsucursal").val();
    if (!codsucursal || codsucursal === "" || codsucursal === "0") {
        swal("Aviso", "Por favor seleccione primero la Sucursal de origen en la parte superior.", "warning");
        return;
    }

    $("#modal_body_catalogo_baja").html('<div class="text-center p-4 text-danger"><i class="fa fa-spinner fa-spin fa-3x"></i><p class="mt-2 font-weight-bold">Cargando catálogo completo de la sucursal...</p></div>');
    $("#modalCatalogoProductosBaja").modal("show");

    $.get("funciones.php?CargarModalProductosBaja=si&codsucursal=" + encodeURIComponent(codsucursal), function (data) {
        $("#modal_body_catalogo_baja").html(data);
        if ($("#tabla_modal_catalogo_baja").length > 0) {
            $("#tabla_modal_catalogo_baja").DataTable({
                "language": {
                    "url": "assets/script/spanish.json"
                },
                "pageLength": 10
            });
        }
    }).fail(function () {
        $("#modal_body_catalogo_baja").html('<div class="alert alert-danger">Error al cargar catálogo.</div>');
    });
}

function AgregarProductoBajaDesdeModal(prod) {
    AgregarProductoBaja(prod);
    swal({
        title: "¡Agregado!",
        text: prod.producto + " fue agregado a la lista.",
        type: "success",
        timer: 1000,
        showConfirmButton: false
    });
}

// Cambiar sucursal reinicia el carrito para evitar mezclar stock
function CambiarSucursalBaja() {
    $("#contenedor_resultados_busqueda").hide();
    $("#txt_buscar_producto_baja").val("");

    if ($(".fila-baja-item").length > 0) {
        swal({
            title: "¿Cambiar de Sucursal?",
            text: "Se limpiará la lista de productos seleccionados porque pertenecen a otra sucursal.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            confirmButtonText: "Sí, Limpiar y Cambiar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#tabla_detalle_baja tbody").html('<tr id="fila_vacia"><td colspan="7" class="text-center text-muted p-4"><i class="fa fa-shopping-cart fa-2x d-block mb-2 text-muted"></i> Escriba en el buscador o abra el catálogo para agregar productos a la baja</td></tr>');
                CalcularTotalesBaja();
            }
        });
    }
}

function AgregarProductoBaja(prod) {
    var codsucursal = $("#codsucursal").val();
    if (!codsucursal || codsucursal === "" || codsucursal === "0") {
        swal("Aviso", "Por favor seleccione primero la Sucursal de origen.", "warning");
        return;
    }

    var idproducto = parseInt(prod.idproducto || prod.id);
    var codproducto = prod.codproducto;
    var nombre = prod.producto;
    var existencia = parseFloat(prod.existencia) || 0;
    var preciocompra = parseFloat(prod.preciocompra) || 0;
    var precioxpublico = parseFloat(prod.precioxpublico) || 0;

    // Verificar si ya está en la lista
    if ($("#fila_prod_" + idproducto).length > 0) {
        var $inputCant = $("#cant_" + idproducto);
        var cantActual = parseFloat($inputCant.val()) || 0;
        $inputCant.val(cantActual + 1).trigger('input');
        return;
    }

    $("#fila_vacia").remove();

    var filaHtml = '<tr id="fila_prod_' + idproducto + '" class="fila-baja-item">' +
        '<td class="text-center align-middle">' +
            '<input type="hidden" name="idproducto[]" value="' + idproducto + '">' +
            '<input type="hidden" name="codproducto[]" value="' + codproducto + '">' +
            '<input type="hidden" name="producto[]" value="' + String(nombre).replace(/"/g, '&quot;') + '">' +
            '<input type="hidden" name="preciocompra[]" id="pc_' + idproducto + '" value="' + preciocompra + '">' +
            '<input type="hidden" name="precioxpublico[]" value="' + precioxpublico + '">' +
            '<span class="badge badge-dark font-12">' + codproducto + '</span>' +
        '</td>' +
        '<td class="align-middle font-weight-bold text-dark">' + nombre + '</td>' +
        '<td class="text-center align-middle">' +
            '<span class="badge ' + (existencia > 0 ? 'badge-success' : 'badge-danger') + ' font-12" id="stock_disp_' + idproducto + '">' + existencia.toFixed(0) + ' u.</span>' +
        '</td>' +
        '<td class="text-center align-middle" style="width: 130px;">' +
            '<input type="number" step="1" min="1" max="' + (existencia > 0 ? existencia : 9999) + '" class="form-control form-control-sm text-center font-weight-bold text-danger border-danger input-cant-baja" name="cantidad[]" id="cant_' + idproducto + '" value="1" oninput="CalcularFilaBaja(' + idproducto + ')" style="font-size: 14px;">' +
        '</td>' +
        '<td class="text-right align-middle font-weight-bold">Bs. ' + preciocompra.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>' +
        '<td class="text-right align-middle font-weight-bold text-dark" id="subtotal_' + idproducto + '">Bs. ' + preciocompra.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>' +
        '<td class="text-center align-middle">' +
            '<button type="button" class="btn btn-outline-danger btn-sm" onclick="EliminarFilaBaja(' + idproducto + ')" title="Quitar">' +
                '<i class="fa fa-trash"></i>' +
            '</button>' +
        '</td>' +
    '</tr>';

    $("#tabla_detalle_baja tbody").append(filaHtml);
    CalcularTotalesBaja();
}

function CalcularFilaBaja(idproducto) {
    var cant = parseFloat($("#cant_" + idproducto).val()) || 0;
    var pc = parseFloat($("#pc_" + idproducto).val()) || 0;
    var subtotal = cant * pc;

    $("#subtotal_" + idproducto).text("Bs. " + subtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    CalcularTotalesBaja();
}

function EliminarFilaBaja(idproducto) {
    $("#fila_prod_" + idproducto).remove();
    if ($("#tabla_detalle_baja tbody tr").length === 0) {
        $("#tabla_detalle_baja tbody").html('<tr id="fila_vacia"><td colspan="7" class="text-center text-muted p-4"><i class="fa fa-shopping-cart fa-2x d-block mb-2 text-muted"></i> Escriba en el buscador o abra el catálogo para agregar productos a la baja</td></tr>');
    }
    CalcularTotalesBaja();
}

function CalcularTotalesBaja() {
    var totalItems = 0;
    var totalCosto = 0;

    $(".fila-baja-item").each(function () {
        var idprod = $(this).attr("id").replace("fila_prod_", "");
        var cant = parseFloat($("#cant_" + idprod).val()) || 0;
        var pc = parseFloat($("#pc_" + idprod).val()) || 0;

        totalItems += cant;
        totalCosto += (cant * pc);
    });

    $("#txt_total_items").text(totalItems.toFixed(0) + " u.");
    $("#txt_total_costo").text("Bs. " + totalCosto.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
}

function GuardarBaja() {
    var codsucursal = $("#codsucursal").val();
    var tipomotivo = $("#tipomotivo").val();
    var persona = $("#persona_autoriza").val();

    if (!codsucursal || codsucursal === "" || codsucursal === "0") {
        swal("Aviso", "Por favor seleccione la Sucursal de origen.", "warning");
        return;
    }

    if (!tipomotivo || tipomotivo === "") {
        swal("Aviso", "Por favor seleccione el Motivo / Tipo de Retiro.", "warning");
        return;
    }

    if (!persona || persona.trim() === "") {
        swal("Aviso", "Por favor indique quién autoriza o retira el producto (Ej: Dueña María).", "warning");
        return;
    }

    var numItems = $(".fila-baja-item").length;
    if (numItems === 0) {
        swal("Aviso", "Debe agregar al menos un producto a la lista de retiro/baja.", "warning");
        return;
    }

    swal({
        title: "¿Confirmar Retiro / Baja de Mercadería?",
        text: "Se descontarán las cantidades físicas del stock de la sucursal y quedará registrado como salida justificada.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sí, Procesar Salida",
        cancelButtonText: "Revisar",
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        var formData = $("#formguardarbaja").serialize();
        var $btn = $("#btn_guardar_baja");
        $btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Procesando...');

        $.ajax({
            type: "POST",
            url: "funciones.php?GuardarBajaInventario=si",
            data: formData,
            dataType: "json",
            timeout: 60000,
            success: function (resp) {
                $btn.prop("disabled", false).html('<i class="fa fa-save"></i> PROCESAR Y GUARDAR RETIRO');
                if (resp && resp.status === 1) {
                    var pdfUrl = "reportepdf?idbaja=" + resp.idbaja + "&tipo=" + encodeURIComponent(window.TIPO_BAJA_ENCRYPT || "");
                    
                    swal({
                        title: "¡Retiro Procesado!",
                        text: resp.msg + " Folio: " + resp.codbaja + ". ¿Deseas abrir el Comprobante Oficial en PDF?",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#28a745",
                        confirmButtonText: "📄 Abrir Comprobante PDF",
                        cancelButtonText: "Ir al Historial",
                        closeOnConfirm: true
                    }, function (isConfirm) {
                        if (isConfirm) {
                            window.open(pdfUrl, '_blank');
                        }
                        window.location.href = "bajas.php";
                    });
                } else {
                    swal("Error", resp ? resp.msg : "Ocurrió un error al procesar la baja.", "error");
                }
            },
            error: function () {
                $btn.prop("disabled", false).html('<i class="fa fa-save"></i> PROCESAR Y GUARDAR RETIRO');
                swal("Error de Conexión", "No se pudo comunicar con el servidor.", "error");
            }
        });
    });
}

function BuscarHistorialBajas() {
    var codsucursal = $("#codsucursal_filtro").val() || "";
    var desde = $("#desde_filtro").val() || "";
    var hasta = $("#hasta_filtro").val() || "";

    $("#tabla_historial_bajas_container").html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x text-danger"></i><p class="mt-2 font-weight-bold">Cargando historial de retiros...</p></div>');

    var url = "funciones.php?BuscaBajasInventario=si&codsucursal=" + encodeURIComponent(codsucursal) + "&desde=" + encodeURIComponent(desde) + "&hasta=" + encodeURIComponent(hasta);

    $.get(url, function (data) {
        $("#tabla_historial_bajas_container").html(data);
        if ($("#tabla_bajas_historial").length > 0) {
            $("#tabla_bajas_historial").DataTable({
                "language": {
                    "url": "assets/script/spanish.json"
                },
                "order": [[0, "desc"]]
            });
        }
    }).fail(function () {
        $("#tabla_historial_bajas_container").html('<div class="alert alert-danger text-center">Error al conectar con el servidor.</div>');
    });
}

function VerDetalleBaja(idbaja) {
    $("#modal_body_detalle_baja").html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x text-danger"></i> Cargando...</div>');
    $("#modalDetalleBaja").modal("show");

    $.get("funciones.php?VerDetalleBajaInventario=si&idbaja=" + encodeURIComponent(idbaja), function (data) {
        $("#modal_body_detalle_baja").html(data);
        $("#btn_pdf_modal_baja").attr("href", "reportepdf?idbaja=" + encodeURIComponent(idbaja) + "&tipo=" + encodeURIComponent(window.TIPO_BAJA_ENCRYPT || ""));
    });
}

function AnularBaja(idbaja, codbaja) {
    swal({
        title: "¿Anular Retiro / Baja " + codbaja + "?",
        text: "Las existencias descontadas serán REINCORPORADAS automáticamente al stock de la sucursal.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sí, Anular y Devolver Stock",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        $.ajax({
            type: "POST",
            url: "funciones.php?AnularBajaInventario=si",
            data: { idbaja: idbaja },
            dataType: "json",
            success: function (resp) {
                if (resp && resp.status === 1) {
                    swal("¡Anulado!", resp.msg, "success");
                    BuscarHistorialBajas();
                } else {
                    swal("Error", resp ? resp.msg : "No se pudo anular.", "error");
                }
            },
            error: function () {
                swal("Error", "Error de comunicación con el servidor.", "error");
            }
        });
    });
}
