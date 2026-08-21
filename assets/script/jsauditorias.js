// JS para Módulo de Auditoría de Productos
function CargarProductosAuditoria() {
    var codsucursal = $("#codsucursal").val();
    var fechadesde  = $("#fechadesde").val();
    var fechahasta  = $("#fechahasta").val();
    var codfamilia  = $("#codfamilia").val();

    if (!codsucursal || codsucursal === "") {
        swal("Aviso", "Por favor seleccione una sucursal.", "warning");
        return;
    }
    if (!fechadesde || fechadesde === "") {
        swal("Aviso", "Por favor ingrese la fecha y hora inicial.", "warning");
        return;
    }
    if (!fechahasta || fechahasta === "") {
        swal("Aviso", "Por favor ingrese la fecha y hora final.", "warning");
        return;
    }

    $("#contenedor_auditoria").html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x text-danger"></i><p class="mt-2 font-weight-bold">Cargando productos y procesando ventas del periodo...</p></div>');

    var url = "funciones.php?BuscaProductosAuditoria=si&codsucursal=" + encodeURIComponent(codsucursal) + "&fechadesde=" + encodeURIComponent(fechadesde) + "&fechahasta=" + encodeURIComponent(fechahasta) + "&codfamilia=" + encodeURIComponent(codfamilia || "");

    $.get(url, function (data) {
        $("#contenedor_auditoria").html(data);
        // Inicializar cálculos en todas las filas
        $(".fila-auditoria").each(function () {
            var idx = $(this).data("index");
            CalcularFila(idx);
        });
    }).fail(function () {
        $("#contenedor_auditoria").html('<div class="alert alert-danger text-center">Error al conectar con el servidor.</div>');
    });
}

function CalcularFila(i) {
    var inicial = parseFloat($("#inicial_cuaderno_" + i).val()) || 0;
    var compras = parseFloat($("#entradas_compras_" + i).val()) || 0;
    var trasp_in = parseFloat($("#entradas_traspasos_" + i).val()) || 0;
    var ventas = parseFloat($("#salidas_ventas_" + i).val()) || 0;
    var trasp_out = parseFloat($("#salidas_traspasos_" + i).val()) || 0;
    var precio = parseFloat($("#precioventa_" + i).val()) || 0;

    // Stock Teórico = Inicial + Compras + Traspasos Entrada - Ventas - Traspasos Salida
    var teorico = (inicial + compras + trasp_in) - (ventas + trasp_out);
    $("#stock_teorico_" + i).val(teorico.toFixed(2));
    $("#badge_teorico_" + i).text(teorico.toFixed(2));

    var fisico = parseFloat($("#fisico_final_" + i).val()) || 0;
    var diferencia = fisico - teorico;

    $("#diferencia_" + i).val(diferencia.toFixed(2));

    var $badgeDif = $("#badge_diferencia_" + i);
    $badgeDif.removeClass("badge-success badge-danger badge-info");

    if (diferencia === 0) {
        $badgeDif.addClass("badge-success").text("0.00");
        $("#box_gestion_" + i).hide();
        $("#lbl_ok_" + i).show();
    } else if (diferencia < 0) {
        $badgeDif.addClass("badge-danger").text(diferencia.toFixed(2));
        $("#box_gestion_" + i).show();
        $("#lbl_ok_" + i).hide();
    } else {
        $badgeDif.addClass("badge-info").text("+" + diferencia.toFixed(2));
        $("#box_gestion_" + i).hide();
        $("#lbl_ok_" + i).show();
    }

    var valorDif = diferencia * precio;
    $("#valordiferencia_" + i).val(valorDif.toFixed(2));

    var $spanValor = $("#span_valor_" + i);
    if (valorDif === 0) {
        $spanValor.removeClass("text-danger text-info").addClass("text-dark").text("$ 0.00");
    } else if (valorDif < 0) {
        $spanValor.removeClass("text-dark text-info").addClass("text-danger").text("-$ " + Math.abs(valorDif).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    } else {
        $spanValor.removeClass("text-dark text-danger").addClass("text-info").text("+$ " + Math.abs(valorDif).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    }

    CalcularTotalesResumen();
}

function CalcularTotalesResumen() {
    var totalFaltantes = 0;
    var totalSobrantes = 0;
    var montoFaltante = 0;

    $(".fila-auditoria").each(function () {
        var idx = $(this).data("index");
        var dif = parseFloat($("#diferencia_" + idx).val()) || 0;
        var valorDif = parseFloat($("#valordiferencia_" + idx).val()) || 0;

        if (dif < 0) {
            totalFaltantes += Math.abs(dif);
            montoFaltante += Math.abs(valorDif);
        } else if (dif > 0) {
            totalSobrantes += dif;
        }
    });

    $("#lbl_total_faltantes").text(totalFaltantes.toFixed(2));
    $("#lbl_total_sobrantes").text(totalSobrantes.toFixed(2));
    $("#lbl_monto_faltante").text("$ " + montoFaltante.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
}

function CopiarTeoricoAFisico() {
    swal({
        title: "¿Copiar Stock Teórico a Físico?",
        text: "Esto colocará el valor del stock teórico en la columna de conteo físico para todos los productos.",
        type: "info",
        showCancelButton: true,
        confirmButtonClass: "btn-primary",
        confirmButtonText: "Sí, copiar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: true
    }, function () {
        $(".fila-auditoria").each(function () {
            var idx = $(this).data("index");
            var teorico = parseFloat($("#stock_teorico_" + idx).val()) || 0;
            $("#fisico_final_" + idx).val(teorico);
            CalcularFila(idx);
        });
    });
}

function LimpiarCuaderno() {
    swal({
        title: "¿Limpiar conteo de cuaderno?",
        text: "Se pondrá en 0 el valor de la columna Inicial Cuaderno.",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Sí, limpiar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: true
    }, function () {
        $(".input-cuaderno").val(0);
        $(".fila-auditoria").each(function () {
            var idx = $(this).data("index");
            CalcularFila(idx);
        });
    });
}

function VerDesgloseCajas(idproducto, nomproducto) {
    var codsucursal = $("#codsucursal").val();
    var fechadesde  = $("#fechadesde").val();
    var fechahasta  = $("#fechahasta").val();

    $("#tituloModalDesglose").html('<i class="fa fa-desktop"></i> Desglose de Ventas por Caja - <strong>' + nomproducto + '</strong>');
    $("#contenidoDesgloseCajas").html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x text-danger"></i><p class="mt-2 font-weight-bold">Consultando cajas y cajeros...</p></div>');
    $("#modalDesgloseCajas").modal("show");

    var url = "funciones.php?DesgloseVentasCajas=si&idproducto=" + idproducto + "&codsucursal=" + encodeURIComponent(codsucursal) + "&fechadesde=" + encodeURIComponent(fechadesde) + "&fechahasta=" + encodeURIComponent(fechahasta);

    $.get(url, function (data) {
        $("#contenidoDesgloseCajas").html(data);
    }).fail(function () {
        $("#contenidoDesgloseCajas").html('<div class="alert alert-danger text-center">Error al consultar el desglose de cajas.</div>');
    });
}

function GuardarAuditoria() {
    var items = [];
    $(".fila-auditoria").each(function () {
        var idx = $(this).data("index");
        var idprod = $(this).find('input[name="idproducto[]"]').val();
        if (idprod) {
            items.push({
                idproducto: idprod,
                codproducto: $(this).find('input[name="codproducto[]"]').val() || '',
                producto: $(this).find('input[name="producto[]"]').val() || '',
                preciocompra: $(this).find('input[name="preciocompra[]"]').val() || 0,
                precioventa: $(this).find('input[name="precioventa[]"]').val() || 0,
                inicial_cuaderno: $("#inicial_cuaderno_" + idx).val() || 0,
                entradas_compras: $("#entradas_compras_" + idx).val() || 0,
                entradas_traspasos: $("#entradas_traspasos_" + idx).val() || 0,
                salidas_ventas: $("#salidas_ventas_" + idx).val() || 0,
                salidas_traspasos: $("#salidas_traspasos_" + idx).val() || 0,
                stock_teorico: $("#stock_teorico_" + idx).val() || 0,
                fisico_final: $("#fisico_final_" + idx).val() || 0,
                diferencia: $("#diferencia_" + idx).val() || 0,
                valordiferencia: $("#valordiferencia_" + idx).val() || 0,
                accion_diferencia: $("#accion_diferencia_" + idx).val() || 'NINGUNA',
                responsable_diferencia: $("#responsable_diferencia_" + idx).val() || '',
                motivo_diferencia: $("#motivo_diferencia_" + idx).val() || ''
            });
        }
    });

    if (items.length === 0) {
        swal("Error", "No hay productos en la tabla para auditar.", "error");
        return;
    }

    swal({
        title: "¿Confirmar Registro de Auditoría?",
        text: "Se guardará el resultado de la auditoría (" + items.length + " productos) en el historial de la sucursal.",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Sí, Guardar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false
    }, function () {
        var form = $("#formguardarauditoria");
        var postData = {
            proceso: "save_auditoria",
            codsucursal: form.find('input[name="codsucursal"]').val(),
            fechadesde: form.find('input[name="fechadesde"]').val(),
            fechahasta: form.find('input[name="fechahasta"]').val(),
            observaciones: $("#observaciones").val() || '',
            detalles_json: JSON.stringify(items)
        };

        $.ajax({
            type: "POST",
            url: "auditorias.php",
            data: postData,
            success: function (response) {
                var res = response.trim();
                if (res === "3") {
                    swal({
                        title: "¡Auditoría Guardada!",
                        text: "La auditoría de " + items.length + " productos se ha registrado exitosamente.",
                        type: "success",
                        confirmButtonText: "Aceptar"
                    }, function () {
                        CargarProductosAuditoria();
                    });
                } else if (res === "1") {
                    swal("Error", "Faltan campos obligatorios para registrar la auditoría.", "error");
                } else if (res === "2") {
                    swal("Error", "No hay productos en la tabla para auditar.", "error");
                } else {
                    swal("Error", "Ocurrió un problema al guardar la auditoría. Intente de nuevo.", "error");
                }
            },
            error: function () {
                swal("Error", "No se pudo conectar con el servidor.", "error");
            }
        });
    });
}

function BuscaHistorialAuditorias() {
    var codsucursal = $("#codsucursal").val();
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();

    if (!desde || desde === "") {
        swal("Aviso", "Por favor ingrese la fecha inicial de búsqueda.", "warning");
        return;
    }
    if (!hasta || hasta === "") {
        swal("Aviso", "Por favor ingrese la fecha final de búsqueda.", "warning");
        return;
    }

    $("#muestra_historial_auditorias").html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x text-danger"></i></div>');

    var url = "funciones.php?BuscaHistorialAuditorias=si&codsucursal=" + encodeURIComponent(codsucursal || "") + "&desde=" + encodeURIComponent(desde) + "&hasta=" + encodeURIComponent(hasta);

    $.get(url, function (data) {
        $("#muestra_historial_auditorias").html(data);
        $("#tabla_historial_auditorias").DataTable({
            "order": [[0, "desc"]],
            "language": {
                "url": "assets/plugins/datatables/Spanish.json"
            }
        });
    });
}
