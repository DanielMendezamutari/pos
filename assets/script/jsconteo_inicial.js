// JavaScript para Gestión del Inventario Inicial Diario de Cajeros (2:00 PM)

function AbrirModalConteoInicial(idconteo) {
    idconteo = idconteo || "";
    $("#contenido_modal_conteo").html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x text-warning"></i><p class="mt-2 font-weight-bold">Cargando inventario inicial...</p></div>');
    $("#myModalConteoInicial").modal("show");

    var url = "funciones.php?CargaModalConteoInicial=si" + (idconteo !== "" ? "&idconteo=" + idconteo : "");
    $.get(url, function (data) {
        $("#contenido_modal_conteo").html(data);
        setTimeout(function() {
            var $primerInput = $("#tabla_captura_conteo tbody input.input-conteo-cajero:first");
            if ($primerInput.length > 0) {
                $primerInput.focus().select();
            }
        }, 400);
    }).fail(function () {
        $("#contenido_modal_conteo").html('<div class="alert alert-danger text-center">Error al conectar con el servidor.</div>');
    });
}

function FiltrarProductosConteo() {
    var query = $("#buscador_producto_conteo").val().toLowerCase();
    $("#tabla_captura_conteo tbody tr.fila-producto-conteo").each(function () {
        var texto = $(this).text().toLowerCase();
        if (texto.indexOf(query) > -1) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}

function GuardarConteoInicialCajero() {
    var $form = $("#form_conteo_inicial_cajero");
    var totalInputs = $form.find("input.input-conteo-cajero").length;

    if (totalInputs === 0) {
        swal("Aviso", "No hay productos para registrar.", "warning");
        return;
    }

    swal({
        title: "¿Confirmar Inventario Inicial?",
        text: "Se registrarán las cantidades físicas contadas para iniciar el turno de la tarde.",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#ffc107",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sí, Guardar",
        cancelButtonText: "Revisar",
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        var formData = $form.serialize();
        $.ajax({
            type: "POST",
            url: "funciones.php?GuardarConteoInicialCajero=si",
            data: formData,
            dataType: "json",
            success: function (resp) {
                if (resp && resp.status === 1) {
                    var tipoCrypt = window.TIPO_CONTEO_INICIAL || "";
                    var pdfUrl = "reportepdf?idconteo=" + resp.idconteo + "&tipo=" + encodeURIComponent(tipoCrypt);
                    
                    // Actualizar el contenedor del botón en la barra superior a verde
                    if ($("#contenedor_boton_conteo").length > 0) {
                        $("#contenedor_boton_conteo").html(
                            '<button type="button" class="btn btn-success font-weight-bold shadow-sm mr-1" onclick="AbrirModalConteoInicial()"><i class="fa fa-check-circle"></i> ✅ INVENTARIO INICIAL REGISTRADO (' + resp.horaconteo + ')</button>' +
                            '<a href="' + pdfUrl + '" target="_blank" class="btn btn-light font-weight-bold" title="Descargar Comprobante PDF para WhatsApp"><i class="fa fa-file-pdf-o text-danger"></i> PDF WhatsApp</a>'
                        );
                    }

                    $("#myModalConteoInicial").modal("hide");

                    swal({
                        title: "¡Inventario Inicial Guardado!",
                        text: "Se ha registrado con éxito a las " + resp.horaconteo + ". ¿Deseas abrir el Comprobante PDF para enviarlo a WhatsApp?",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#28a745",
                        confirmButtonText: "📄 Abrir PDF para WhatsApp",
                        cancelButtonText: "Listo / Continuar Venta",
                        closeOnConfirm: true
                    }, function (isConfirm) {
                        if (isConfirm) {
                            window.open(pdfUrl, '_blank');
                        }
                    });
                } else {
                    swal("Error", resp ? resp.msg : "Ocurrió un error al guardar.", "error");
                }
            },
            error: function () {
                swal("Error", "Error de comunicación con el servidor.", "error");
            }
        });
    });
}

function DesbloquearConteoInicial(idconteo, nomsucursal) {
    if (!idconteo) {
        swal("Aviso", "No se especificó el folio del conteo.", "warning");
        return;
    }
    nomsucursal = nomsucursal || "esta sucursal";

    swal({
        title: "¿Desbloquear Inventario Inicial?",
        text: "Se eliminará el conteo actual de " + nomsucursal + " para que el cajero pueda ingresar y realizar el conteo inicial a ciegas nuevamente.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sí, Desbloquear",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        $.ajax({
            type: "POST",
            url: "funciones.php?DesbloquearConteoInicialAdmin=si",
            data: { idconteo: idconteo },
            dataType: "json",
            success: function (resp) {
                if (resp && resp.status === 1) {
                    // Si estamos en POS / forventa, restaurar el botón amarillo
                    if ($("#contenedor_boton_conteo").length > 0) {
                        $("#contenedor_boton_conteo").html(
                            '<button type="button" class="btn btn-warning text-dark font-weight-bold shadow-sm blink-btn" onclick="AbrirModalConteoInicial()"><i class="fa fa-exclamation-triangle"></i> ⚠️ REALIZAR INVENTARIO INICIAL A CIEGAS (2:00 PM)</button>'
                        );
                    }
                    $("#myModalConteoInicial").modal("hide");

                    swal({
                        title: "¡Desbloqueado con Éxito!",
                        text: resp.msg,
                        type: "success",
                        confirmButtonText: "Aceptar"
                    }, function () {
                        if (typeof BuscaHistorialConteosIniciales === "function" && $("#muestra_historial_conteos").length > 0) {
                            BuscaHistorialConteosIniciales();
                        }
                        if (typeof CargarProductosAuditoria === "function" && $("#codsucursal").val() && $("#contenedor_auditoria").length > 0) {
                            CargarProductosAuditoria();
                        }
                    });
                } else {
                    swal("Error", resp ? resp.msg : "No se pudo desbloquear el inventario.", "error");
                }
            },
            error: function () {
                swal("Error", "Error de comunicación con el servidor.", "error");
            }
        });
    });
}

function BuscaHistorialConteosIniciales() {
    var codsucursal = $("#codsucursal").val();
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();

    $("#muestra_historial_conteos").html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x text-warning"></i><p class="mt-2 font-weight-bold">Cargando inventarios iniciales...</p></div>');

    var url = "funciones.php?BuscaHistorialConteosIniciales=si&codsucursal=" + encodeURIComponent(codsucursal || "") + "&desde=" + encodeURIComponent(desde || "") + "&hasta=" + encodeURIComponent(hasta || "");

    $.get(url, function (data) {
        $("#muestra_historial_conteos").html(data);
        $("#tabla_historial_conteos").DataTable({
            "order": [[0, "desc"]],
            "language": {
                "url": "assets/plugins/datatables/Spanish.json"
            }
        });
    });
}

function HabilitarEdicionConteoAdmin() {
    $(".vista-lectura-conteo").hide();
    $(".vista-edicion-conteo").show();
    $("#seccion_edicion_admin_conteo").slideDown();
    $("#btn_habilitar_edicion_conteo").hide();
    $("#btn_guardar_edicion_conteo").show();
    $("#btn_cancelar_edicion_conteo").show();
}

function CancelarEdicionConteoAdmin() {
    $(".vista-edicion-conteo").hide();
    $(".vista-lectura-conteo").show();
    $("#seccion_edicion_admin_conteo").slideUp();
    $("#btn_guardar_edicion_conteo").hide();
    $("#btn_cancelar_edicion_conteo").hide();
    $("#btn_habilitar_edicion_conteo").show();
}

function GuardarEdicionConteoAdmin() {
    var $form = $("#form_edicion_conteo_admin");
    var justificacion = $("#justificacion_edicion_conteo").val().trim();

    if (justificacion === "") {
        swal("Justificación Requerida", "Por favor indique el motivo de la corrección de cantidades.", "warning");
        $("#justificacion_edicion_conteo").focus();
        return;
    }

    swal({
        title: "¿Guardar Correcciones?",
        text: "Se actualizarán las cantidades físicas contadas en el inventario inicial.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sí, Actualizar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        $.ajax({
            type: "POST",
            url: "funciones.php?ActualizarConteoInicialAdmin=si",
            data: $form.serialize(),
            dataType: "json",
            success: function (resp) {
                if (resp && resp.status === 1) {
                    swal({
                        title: "¡Actualizado!",
                        text: resp.msg,
                        type: "success",
                        confirmButtonText: "Aceptar"
                    }, function () {
                        var idc = $form.find('input[name="idconteo"]').val();
                        AbrirModalConteoInicial(idc);
                        if (typeof CargarProductosAuditoria === "function" && $("#codsucursal").val()) {
                            CargarProductosAuditoria();
                        }
                    });
                } else {
                    swal("Error", resp ? resp.msg : "No se pudo actualizar el conteo.", "error");
                }
            },
            error: function () {
                swal("Error", "Error de comunicación con el servidor.", "error");
            }
        });
    });
}
