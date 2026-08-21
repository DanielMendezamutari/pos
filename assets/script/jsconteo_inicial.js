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
