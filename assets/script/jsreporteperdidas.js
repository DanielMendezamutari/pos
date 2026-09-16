// JS para Módulo de Reporte de Pérdidas y Faltantes de Inventario por Fechas

$(document).ready(function () {
    // Si estamos en la página de reporte de pérdidas, cargar búsqueda inicial
    if ($("#muestra_reporte_perdidas").length > 0) {
        BuscarReportePerdidas();
    }
});

function BuscarReportePerdidas() {
    var codsucursal = $("#codsucursal_filtro").val() || "";
    var desde = $("#desde_filtro").val() || "";
    var hasta = $("#hasta_filtro").val() || "";
    var tipofiltro = $("#tipo_filtro").val() || "TODAS";
    var vista = $("#vista_filtro").val() || "DETALLE";

    // Actualizar enlaces de los botones de descarga de PDF y Excel
    ActualizarBotonesExportacion(codsucursal, desde, hasta, tipofiltro, vista);

    $("#muestra_reporte_perdidas").html(
        '<div class="text-center p-5">' +
        '<i class="fa fa-spinner fa-spin fa-3x text-danger"></i>' +
        '<p class="mt-2 font-weight-bold text-dark font-14">Consolidando pérdidas, faltantes y mermas del período...</p>' +
        '</div>'
    );

    var url = "funciones.php?BuscarReportePerdidas=si" +
        "&codsucursal=" + encodeURIComponent(codsucursal) +
        "&desde=" + encodeURIComponent(desde) +
        "&hasta=" + encodeURIComponent(hasta) +
        "&tipofiltro=" + encodeURIComponent(tipofiltro) +
        "&vista=" + encodeURIComponent(vista);

    $.get(url, function (data) {
        $("#muestra_reporte_perdidas").html(data);

        if ($("#tabla_reporte_perdidas").length > 0) {
            $("#tabla_reporte_perdidas").DataTable({
                "language": {
                    "url": "assets/script/spanish.json"
                },
                "pageLength": 25,
                "order": []
            });
        }
    }).fail(function () {
        $("#muestra_reporte_perdidas").html(
            '<div class="alert alert-danger text-center p-4">' +
            '<i class="fa fa-exclamation-triangle fa-2x"></i>' +
            '<p class="mt-2 font-weight-bold">Error al conectar con el servidor para obtener el reporte.</p>' +
            '</div>'
        );
    });
}

function ActualizarBotonesExportacion(codsucursal, desde, hasta, tipofiltro, vista) {
    var paramPdf = "reportepdf?tipo=" + encodeURIComponent(window.TIPO_REPORTE_PERDIDAS_ENCRYPT || "") +
        "&codsucursal=" + encodeURIComponent(codsucursal) +
        "&desde=" + encodeURIComponent(desde) +
        "&hasta=" + encodeURIComponent(hasta) +
        "&tipofiltro=" + encodeURIComponent(tipofiltro) +
        "&vista=" + encodeURIComponent(vista);

    var paramExcel = "reporteexcel?tipo=" + encodeURIComponent(window.TIPO_REPORTE_PERDIDAS_ENCRYPT || "") +
        "&documento=" + encodeURIComponent(window.TIPO_DOCUMENTO_EXCEL_ENCRYPT || "") +
        "&codsucursal=" + encodeURIComponent(codsucursal) +
        "&desde=" + encodeURIComponent(desde) +
        "&hasta=" + encodeURIComponent(hasta) +
        "&tipofiltro=" + encodeURIComponent(tipofiltro) +
        "&vista=" + encodeURIComponent(vista);

    $("#btn_exportar_pdf").attr("href", paramPdf);
    $("#btn_exportar_excel").attr("href", paramExcel);
}

function LimpiarFiltrosPerdidas() {
    $("#codsucursal_filtro").val("");
    $("#tipo_filtro").val("TODAS");
    BuscarReportePerdidas();
}

function RastrearTurnosFaltante(codproducto, codsucursal, fecha, producto, cant) {
    $("#modalRastrearTurnos").modal("show");
    $("#contenido_rastreo_turnos").html(
        '<div class="text-center p-5">' +
        '<i class="fa fa-spinner fa-spin fa-3x text-danger"></i>' +
        '<p class="mt-2 font-weight-bold text-dark font-14">Rastreando turnos, arqueos y notas de cierre para ' + producto + '...</p>' +
        '</div>'
    );

    var url = "funciones.php?RastrearTurnosFaltante=si" +
        "&codproducto=" + encodeURIComponent(codproducto) +
        "&codsucursal=" + encodeURIComponent(codsucursal) +
        "&fecha=" + encodeURIComponent(fecha) +
        "&producto=" + encodeURIComponent(producto) +
        "&cant=" + encodeURIComponent(cant);

    $.get(url, function (htmlData) {
        $("#contenido_rastreo_turnos").html(htmlData);
    }).fail(function () {
        $("#contenido_rastreo_turnos").html(
            '<div class="alert alert-danger text-center p-3 font-weight-bold">' +
            '<i class="fa fa-exclamation-triangle"></i> Error al consultar la trazabilidad de turnos.' +
            '</div>'
        );
    });
}
