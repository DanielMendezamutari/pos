// JavaScript para Gestión del Inventario Inicial Diario de Cajeros (2:00 PM)

// Desactivar restricción de foco de Bootstrap para permitir escribir libremente en inputs de SweetAlert sobre modales
$(document).ready(function () {
    if ($.fn.modal && $.fn.modal.Constructor) {
        if ($.fn.modal.Constructor.prototype._enforceFocus) {
            $.fn.modal.Constructor.prototype._enforceFocus = function () {};
        }
        if ($.fn.modal.Constructor.prototype.enforceFocus) {
            $.fn.modal.Constructor.prototype.enforceFocus = function () {};
        }
    }
    $(document).off('focusin.bs.modal');
});

function AbrirModalConteoInicial(idconteo, codsucursal) {
    idconteo = idconteo || "";
    codsucursal = codsucursal || ($("#codsucursal").length > 0 ? $("#codsucursal").val() : "") || "";
    $("#contenido_modal_conteo").html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x text-warning"></i><p class="mt-2 font-weight-bold">Cargando inventario inicial...</p></div>');
    $("#myModalConteoInicial").removeAttr("tabindex");
    $("#myModalConteoInicial").modal("show");

    var url = "funciones.php?CargaModalConteoInicial=si" + (idconteo !== "" ? "&idconteo=" + encodeURIComponent(idconteo) : "") + (codsucursal !== "" ? "&codsucursal=" + encodeURIComponent(codsucursal) : "");
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
        var $btnGuardar = $("#btn_guardar_conteo");
        $btnGuardar.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Guardando...');

        $.ajax({
            type: "POST",
            url: "funciones.php?GuardarConteoInicialCajero=si",
            data: formData,
            dataType: "json",
            timeout: 60000,
            success: function (resp) {
                $btnGuardar.prop("disabled", false).html('<i class="fa fa-save"></i> GUARDAR Y ENVIAR INVENTARIO INICIAL');
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
                        text: resp.msg || ("Se ha registrado con éxito a las " + resp.horaconteo + ". ¿Deseas abrir el Comprobante PDF para enviarlo a WhatsApp?"),
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
            error: function (xhr, status, error) {
                $btnGuardar.prop("disabled", false).html('<i class="fa fa-save"></i> GUARDAR Y ENVIAR INVENTARIO INICIAL');
                swal("Aviso de Conexión", "El servidor tardó en responder o expiró la sesión por inactividad. Si ya se guardó, puedes revisar en el panel o refrescar la página con F5.", "warning");
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

function FiltrarTablaDiagnostico(tipo, btn) {
    if (btn) {
        $("#grupo_filtros_tabla_conteo button").removeClass("active btn-dark btn-danger btn-info btn-success");
        $("#grupo_filtros_tabla_conteo button").each(function () {
            var $b = $(this);
            if ($b.text().indexOf("Todos") > -1) $b.addClass("btn-outline-dark");
            else if ($b.text().indexOf("Faltantes") > -1) $b.addClass("btn-outline-danger");
            else if ($b.text().indexOf("Sobrantes") > -1) $b.addClass("btn-outline-info");
            else if ($b.text().indexOf("Cuadran") > -1) $b.addClass("btn-outline-success");
        });
        var $activeBtn = $(btn);
        $activeBtn.removeClass("btn-outline-dark btn-outline-danger btn-outline-info btn-outline-success").addClass("active");
        if (tipo === "todos") $activeBtn.addClass("btn-dark");
        else if (tipo === "faltante") $activeBtn.addClass("btn-danger");
        else if (tipo === "sobrante") $activeBtn.addClass("btn-info");
        else if (tipo === "cuadra") $activeBtn.addClass("btn-success");
    }

    $("#tabla_modal_conteo tbody tr.fila-detalle-conteo").each(function () {
        var diag = $(this).data("diagnostico");
        if (tipo === "todos" || diag === tipo) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}

function AjustarDiscrepanciaIndividual(iddetalleconteo, tipo, nombreProd, diferencia, idconteo) {
    if (!iddetalleconteo) {
        swal("Aviso", "Identificador de producto inválido.", "warning");
        return;
    }

    // Desactivar bloqueo de foco de modales
    $(".modal").removeAttr("tabindex");
    $(document).off('focusin.bs.modal');

    var esSobrante = (tipo === "sobrante" || diferencia > 0);
    var titulo = esSobrante ? "➕ ¿Cuadrar Sobrante en Sistema?" : "➖ ¿Ajustar Faltante en Sistema?";
    var texto = esSobrante 
        ? "Se sumarán +" + Math.abs(diferencia) + " unidades al stock del sistema de: " + nombreProd + " y se registrará la Entrada en Kardex.\n\nIndique el motivo (opcional):"
        : "Se descontarán " + Math.abs(diferencia) + " unidades del stock del sistema de: " + nombreProd + " y se registrará la Salida en Kardex.\n\nIndique el motivo (opcional):";

    swal({
        title: titulo,
        text: texto,
        type: "input",
        showCancelButton: true,
        confirmButtonColor: esSobrante ? "#17a2b8" : "#dc3545",
        cancelButtonColor: "#6c757d",
        confirmButtonText: esSobrante ? "Sí, Cuadrar (+)" : "Sí, Descontar (-)",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        inputPlaceholder: "Ej: Mercadería ingresada sin registrar / Conteo validado...",
        showLoaderOnConfirm: true
    }, function (motivo) {
        if (motivo === false) return false;

        $.ajax({
            type: "POST",
            url: "funciones.php?AjustarDiscrepanciaConteoIndividual=si",
            data: {
                iddetalleconteo: iddetalleconteo,
                motivo: motivo || (esSobrante ? "Cuadre de sobrante en conteo físico" : "Cuadre de faltante en conteo físico")
            },
            dataType: "json",
            success: function (resp) {
                if (resp && resp.status === 1) {
                    swal({
                        title: "¡Inventario Cuadrado!",
                        text: resp.msg,
                        type: "success",
                        confirmButtonText: "Aceptar"
                    }, function () {
                        if (idconteo) {
                            AbrirModalConteoInicial(idconteo);
                        }
                        if (typeof BuscaHistorialConteosIniciales === "function" && $("#muestra_historial_conteos").length > 0) {
                            BuscaHistorialConteosIniciales();
                        }
                        if (typeof CargarProductosAuditoria === "function" && $("#codsucursal").val()) {
                            CargarProductosAuditoria();
                        }
                    });
                } else {
                    swal("Error", resp ? resp.msg : "No se pudo realizar el ajuste.", "error");
                }
            },
            error: function () {
                swal("Error", "Error de comunicación con el servidor.", "error");
            }
        });
    });

    setTimeout(function () {
        var $swalInput = $(".sweet-alert input:visible");
        if ($swalInput.length > 0) {
            $swalInput.focus();
        }
    }, 200);
}

function AjustarTodosSobrantesModal(idconteo, countSobrantes, totalUnidades) {
    if (!idconteo) {
        swal("Aviso", "Identificador de conteo no proporcionado.", "warning");
        return;
    }

    // Desactivar bloqueo de foco de modales
    $(".modal").removeAttr("tabindex");
    $(document).off('focusin.bs.modal');

    swal({
        title: "⚡ ¿Cuadrar TODOS los Sobrantes?",
        text: "Se ingresarán al stock del sistema +" + totalUnidades + " unidades distribuidas en " + countSobrantes + " productos con sobrante y se generarán sus movimientos de Entrada en Kardex.\n\nIndique el motivo general:",
        type: "input",
        showCancelButton: true,
        confirmButtonColor: "#17a2b8",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sí, Cuadrar Todos los Sobrantes",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        inputPlaceholder: "Ej: Cuadre de excedentes verificado por Administración...",
        showLoaderOnConfirm: true
    }, function (motivo) {
        if (motivo === false) return false;

        $.ajax({
            type: "POST",
            url: "funciones.php?AjustarTodosSobrantesConteo=si",
            data: {
                idconteo: idconteo,
                motivo: motivo || "Cuadre masivo de sobrantes de conteo inicial"
            },
            dataType: "json",
            success: function (resp) {
                if (resp && resp.status === 1) {
                    swal({
                        title: "¡Sobrantes Cuadrados!",
                        text: resp.msg,
                        type: "success",
                        confirmButtonText: "Aceptar"
                    }, function () {
                        AbrirModalConteoInicial(idconteo);
                        if (typeof BuscaHistorialConteosIniciales === "function" && $("#muestra_historial_conteos").length > 0) {
                            BuscaHistorialConteosIniciales();
                        }
                    });
                } else {
                    swal("Error", resp ? resp.msg : "No se pudo procesar el ajuste.", "error");
                }
            },
            error: function () {
                swal("Error", "Error de comunicación con el servidor.", "error");
            }
        });
    });

    setTimeout(function () {
        var $swalInput = $(".sweet-alert input:visible");
        if ($swalInput.length > 0) {
            $swalInput.focus();
        }
    }, 200);
}

function AjustarTodoConteoModal(idconteo, totalDiscrepancias) {
    if (!idconteo) {
        swal("Aviso", "Identificador de conteo no proporcionado.", "warning");
        return;
    }

    // Desactivar bloqueo de foco de modales
    $(".modal").removeAttr("tabindex");
    $(document).off('focusin.bs.modal');

    swal({
        title: "🔄 ¿Cuadrar TODO el Inventario al Conteo Físico?",
        text: "Se sincronizarán todas las discrepancias (" + totalDiscrepancias + " productos: sobrantes y faltantes) para que el stock del sistema quede idéntico al físico.\n\nIndique la justificación de la auditoría:",
        type: "input",
        showCancelButton: true,
        confirmButtonColor: "#343a40",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sí, Sincronizar Todo el Conteo",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        inputPlaceholder: "Ej: Ajuste general por auditoría física diaria...",
        showLoaderOnConfirm: true
    }, function (motivo) {
        if (motivo === false) return false;

        $.ajax({
            type: "POST",
            url: "funciones.php?AjustarTodoConteoDiscrepancias=si",
            data: {
                idconteo: idconteo,
                motivo: motivo || "Sincronización total de inventario con conteo físico"
            },
            dataType: "json",
            success: function (resp) {
                if (resp && resp.status === 1) {
                    swal({
                        title: "¡Inventario Totalmente Sincronizado!",
                        text: resp.msg,
                        type: "success",
                        confirmButtonText: "Aceptar"
                    }, function () {
                        AbrirModalConteoInicial(idconteo);
                        if (typeof BuscaHistorialConteosIniciales === "function" && $("#muestra_historial_conteos").length > 0) {
                            BuscaHistorialConteosIniciales();
                        }
                    });
                } else {
                    swal("Error", resp ? resp.msg : "No se pudo procesar la sincronización.", "error");
                }
            },
            error: function () {
                swal("Error", "Error de comunicación con el servidor.", "error");
            }
        });
    });

    setTimeout(function () {
        var $swalInput = $(".sweet-alert input:visible");
        if ($swalInput.length > 0) {
            $swalInput.focus();
        }
    }, 200);
}
