<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG") {

        $tra = new Login();
        $ses = $tra->ExpiraSession();
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Reporte Consolidado de Pérdidas y Faltantes - Administrador General</title>

    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/alert.css">

    <!-- Calendario -->
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body onLoad="muestraReloj()" class="fix-header">

    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar">

        <?php include('menu.php'); ?>

        <div class="page-wrapper">
            <div class="page-breadcrumb border-bottom">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                        <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-chart-line text-danger"></i> Reporte Consolidado de Pérdidas y Faltantes</h5>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item"><a href="panel">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="auditorias">Auditorías</a></li>
                                <li class="breadcrumb-item active">Reporte de Pérdidas</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="page-content container-fluid">

                <!-- Alerta informativa ejecutiva -->
                <div class="alert alert-light border-left-danger shadow-sm py-2 px-3 mb-3 d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <i class="fa fa-info-circle text-danger mr-1"></i>
                        <strong>Informe Ejecutivo de Pérdidas y Salidas:</strong> Separa claramente lo que <strong>retiró la dueña (gym/consumo)</strong>, las <strong>botellas rotas/mermas</strong>, los <strong>errores de conteo ya justificados</strong> y los <strong>faltantes reales en caja sin justificar</strong>.
                    </div>
                    <div>
                        <span class="badge badge-danger p-2 font-12"><i class="fa fa-map-marker"></i> Los Pocitos = Joker Central</span>
                    </div>
                </div>

                <!-- Filtros de Consulta -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center flex-wrap">
                                <h4 class="card-title text-white mb-0"><i class="fa fa-filter"></i> Filtros del Informe para la Dueña</h4>
                                <div>
                                    <a href="#" id="btn_exportar_pdf" target="_blank" rel="noopener noreferrer" class="btn btn-light text-danger btn-sm font-weight-bold shadow-sm mr-1" title="Descargar Informe en PDF Membretado">
                                        <i class="fa fa-file-pdf-o"></i> Descargar PDF
                                    </a>
                                    <a href="#" id="btn_exportar_excel" class="btn btn-light text-success btn-sm font-weight-bold shadow-sm" title="Descargar en Hoja de Cálculo Excel">
                                        <i class="fa fa-file-excel-o"></i> Exportar Excel
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">Sucursal:</label>
                                            <select name="codsucursal_filtro" id="codsucursal_filtro" class="form-control font-weight-bold" onchange="BuscarReportePerdidas()">
                                                <option value=""> -- TODAS LAS SUCURSALES -- </option>
                                                <?php
                                                $listaSucursales = $tra->ListarSucursales();
                                                if (!empty($listaSucursales)) {
                                                    foreach ($listaSucursales as $s) {
                                                        $esPocitos = ($s['codsucursal'] == 2);
                                                ?>
                                                        <option value="<?php echo encrypt($s['codsucursal']); ?>" <?php echo $esPocitos ? 'selected style="font-weight: bold; background-color: #fff3cd;"' : ''; ?>>
                                                            <?php echo htmlspecialchars($s['cuitsucursal'] . ": " . $s['nomsucursal']) . ($esPocitos ? " (Los Pocitos)" : ""); ?>
                                                        </option>
                                                <?php 
                                                    }
                                                } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">Desde Fecha:</label>
                                            <input type="date" class="form-control" name="desde_filtro" id="desde_filtro" value="<?php echo date("Y-m-01"); ?>" onchange="BuscarReportePerdidas()">
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">Hasta Fecha:</label>
                                            <input type="date" class="form-control" name="hasta_filtro" id="hasta_filtro" value="<?php echo date("Y-m-d"); ?>" onchange="BuscarReportePerdidas()">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">Mostrar Específicamente:</label>
                                            <select name="tipo_filtro" id="tipo_filtro" class="form-control font-weight-bold" onchange="BuscarReportePerdidas()">
                                                <option value="TODAS">⚡ Todas las Salidas y Faltantes (Clasificadas)</option>
                                                <option value="FALTANTES_CAJA">🔴 Solo Faltantes en Caja (A Cobrar / Investigar)</option>
                                                <option value="RETIROS_DUENA">🟣 Solo Retiros de la Dueña (Consumo / Gym)</option>
                                                <option value="MERMAS">🟡 Solo Mermas / Botellas Rotas</option>
                                                <option value="ACLARADOS">🟢 Solo Cuadre / Errores Justificados con Motivo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="button" class="btn btn-secondary mr-2" onclick="LimpiarFiltrosPerdidas()"><i class="fa fa-refresh"></i> Reestablecer</button>
                                        <button type="button" class="btn btn-danger font-weight-bold shadow-sm" onclick="BuscarReportePerdidas()"><i class="fa fa-search"></i> Actualizar Informe</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenedor dinámico de resultados AJAX -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-2">
                                <h4 class="card-title text-white mb-0"><i class="fa fa-list"></i> Resultados de la Consulta</h4>
                            </div>
                            <div class="card-body">
                                <div id="muestra_reporte_perdidas">
                                    <!-- Carga por AJAX -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <footer class="footer text-center">
                <i class="fa fa-copyright"></i> <?php echo date('Y'); ?> Sistema POS. Todos los Derechos Reservados.
            </footer>
        </div>
    </div>

    <!-- Modal de Auditoría y Rastreo de Turnos -->
    <div class="modal fade" id="modalRastrearTurnos" tabindex="-1" role="dialog" aria-labelledby="modalRastrearLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title font-weight-bold" id="modalRastrearLabel">
                        <i class="fa fa-search"></i> Rastrear Turnos y Responsables del Faltante
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3" id="contenido_rastreo_turnos">
                    <!-- Cargado vía AJAX -->
                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-secondary btn-sm font-weight-bold" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/script/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app.init.horizontal-fullwidth.js"></script>
    <script src="assets/js/app-style-switcher.js"></script>
    <script src="assets/js/perfect-scrollbar.js"></script>
    <script src="assets/js/sparkline.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/sweetalert-dev.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/plugins/bower_components/datatables/datatables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="assets/script/titulos.js"></script>

    <script>
        window.TIPO_REPORTE_PERDIDAS_ENCRYPT = "<?php echo encrypt('PERDIDASXFECHAS'); ?>";
        window.TIPO_DOCUMENTO_EXCEL_ENCRYPT = "<?php echo encrypt('EXCEL'); ?>";
    </script>
    <script type="text/javascript" src="assets/script/jsreporteperdidas.js"></script>

</body>
</html>
<?php
    } else {
        echo "<script>alert('NO TIENES PERMISO PARA ACCEDER A ESTA PÁGINA.\\nESTE MÓDULO ES EXCLUSIVO DEL ADMINISTRADOR GENERAL'); document.location.href='panel';</script>";
    }
} else {
    echo "<script>alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\\nDEBERÁ DE INICIAR SESIÓN'); document.location.href='logout';</script>";
}
?>
