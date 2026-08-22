<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION["acceso"] == "administradorG" || $_SESSION["acceso"] == "administradorS") {

        $tra = new Login();
        $ses = $tra->ExpiraSession();
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Historial de Retiros y Bajas de Mercadería</title>
    <!-- DataTables CSS -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- Sweet-Alert -->
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <!-- animation CSS -->
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- needed css -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
</head>

<body onLoad="muestraReloj(); getTime();" class="fix-header">
    
    <!-- Preloader -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <!-- Modal Ver Detalle de Baja -->
    <div class="modal fade" id="modalDetalleBaja" tabindex="-1" role="dialog" aria-labelledby="modalDetalleBajaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title font-weight-bold" id="modalDetalleBajaLabel"><i class="fa fa-info-circle"></i> Detalle de Salida / Baja de Inventario</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_body_detalle_baja">
                    <!-- Contenido dinámico AJAX -->
                </div>
                <div class="modal-footer bg-light">
                    <a href="#" id="btn_pdf_modal_baja" target="_blank" class="btn btn-danger font-weight-bold"><i class="fa fa-file-pdf-o"></i> Imprimir PDF</a>
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-boxed-layout="boxed" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar"> 
      
        <!-- INICIO DE MENU -->
        <?php include('menu.php'); ?>
        <!-- FIN DE MENU -->

        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb and right sidebar toggle -->
            <div class="page-breadcrumb border-bottom">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                        <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-list text-danger"></i> Historial de Retiros y Bajas de Mercadería</h5>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item"><a href="panel">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Bajas de Inventario</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Container fluid  -->
            <div class="page-content container-fluid">
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                                <h4 class="card-title text-white mb-0"><i class="fa fa-search"></i> Filtros de Búsqueda</h4>
                                <a href="forbaja" class="btn btn-warning font-weight-bold shadow-sm"><i class="fa fa-plus-circle"></i> + Nuevo Retiro / Baja</a>
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                                    <?php if ($_SESSION['acceso'] == "administradorG") { ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">Sucursal:</label>
                                            <select class="form-control" name="codsucursal_filtro" id="codsucursal_filtro" onchange="BuscarHistorialBajas()">
                                                <option value="">-- Todas las Sucursales --</option>
                                                <?php
                                                $sucursales = $tra->ListarSucursales();
                                                foreach ($sucursales as $s) {
                                                ?>
                                                    <option value="<?php echo encrypt($s['codsucursal']); ?>"><?php echo htmlspecialchars($s['nomsucursal']); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                        <input type="hidden" name="codsucursal_filtro" id="codsucursal_filtro" value="<?php echo encrypt($_SESSION['codsucursal']); ?>">
                                    <?php } ?>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">Desde Fecha:</label>
                                            <input type="date" class="form-control" name="desde_filtro" id="desde_filtro" value="<?php echo date('Y-m-01'); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">Hasta Fecha:</label>
                                            <input type="date" class="form-control" name="hasta_filtro" id="hasta_filtro" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3 d-flex align-items-end mb-3">
                                        <button type="button" class="btn btn-dark btn-block font-weight-bold" onclick="BuscarHistorialBajas()">
                                            <i class="fa fa-search"></i> Buscar Retiros
                                        </button>
                                    </div>
                                </div>

                                <hr>

                                <div id="tabla_historial_bajas_container">
                                    <!-- Carga dinámica AJAX -->
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

    <!-- All Jquery -->
    <script src="assets/script/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <!-- apps -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app.init.horizontal-fullwidth.js"></script>
    <script src="assets/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/js/perfect-scrollbar.js"></script>
    <script src="assets/js/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!--Sweet-Alert -->
    <script src="assets/js/sweetalert-dev.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.js"></script>
    <!-- DataTables -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>

    <script>
        window.TIPO_BAJA_ENCRYPT = "<?php echo encrypt('BAJAINVENTARIO'); ?>";
    </script>
    <script src="assets/script/jsbajas.js"></script>

</body>
</html>
<?php
    } else {
        header("Location: panel.php");
    }
} else {
    header("Location: logout.php");
}
?>
