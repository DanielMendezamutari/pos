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
    <title>Inventarios Iniciales Diarios (2:00 PM) - Administrador General</title>

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
                        <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-clipboard-check text-warning"></i> Inventarios Iniciales Diarios (2:00 PM)</h5>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item"><a href="auditorias">Auditorías</a></li>
                                <li class="breadcrumb-item active">Conteos Iniciales</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="page-content container-fluid">

                <!-- Alerta Informativa para el Administrador -->
                <div class="alert alert-info py-2 px-3 mb-3 d-flex justify-content-between align-items-center flex-wrap shadow-sm">
                    <div>
                        <i class="fa fa-info-circle fa-lg mr-1 text-primary"></i>
                        <strong>Panel de Control de Inventarios Iniciales:</strong> Aquí puedes monitorear los conteos de apertura a ciegas, descargar actas, corregir cantidades o <strong>desbloquear sucursales</strong> que se hayan equivocado para que repitan su conteo.
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-warning text-dark">
                                <h4 class="card-title text-dark font-weight-bold mb-0"><i class="fa fa-search"></i> Filtros de Búsqueda de Conteos Iniciales</h4>
                            </div>

                            <form class="form form-material" method="post" action="#" name="formhistorialconteo" id="formhistorialconteo">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label font-weight-bold">Sucursal: <small>(Opcional)</small></label>
                                                <select name="codsucursal" id="codsucursal" class="form-control">
                                                    <option value=""> -- TODAS LAS SUCURSALES -- </option>
                                                    <?php
                                                    $sucursal = new Login();
                                                    $listaSucursales = $sucursal->ListarSucursales();
                                                    if (!empty($listaSucursales)) {
                                                        foreach ($listaSucursales as $s) { ?>
                                                            <option value="<?php echo encrypt($s['codsucursal']); ?>">
                                                                <?php echo htmlspecialchars($s['cuitsucursal'] . ": " . $s['nomsucursal']); ?>
                                                            </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label font-weight-bold">Fecha Desde: <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="desde" id="desde" value="<?php echo date("Y-m-d", strtotime("-7 days")); ?>" placeholder="YYYY-MM-DD" autocomplete="off" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label font-weight-bold">Fecha Hasta: <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="hasta" id="hasta" value="<?php echo date("Y-m-d"); ?>" placeholder="YYYY-MM-DD" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right mt-2">
                                        <a href="auditorias" class="btn btn-outline-secondary mr-2"><i class="fa fa-calculator"></i> Ir a Auditoría Diaria</a>
                                        <button type="button" onClick="BuscaHistorialConteosIniciales()" class="btn btn-warning text-dark font-weight-bold shadow-sm"><i class="fa fa-search"></i> Buscar Conteos Iniciales</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-2">
                                <h4 class="card-title text-white mb-0"><i class="fa fa-list"></i> Registro de Inventarios Iniciales por Sucursal</h4>
                            </div>
                            <div class="card-body">
                                <div id="muestra_historial_conteos">
                                    <div class="alert alert-info text-center">Cargando inventarios iniciales...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- MODAL INVENTARIO INICIAL CAJEROS / ADMIN -->
            <div id="myModalConteoInicial" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabelConteo" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-dark">
                            <h4 class="modal-title font-weight-bold" id="myModalLabelConteo"><i class="fa fa-clipboard"></i> Inventario Inicial Diario (2:00 PM)</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                        </div>
                        <div class="modal-body" id="contenido_modal_conteo">
                            <!-- Carga por AJAX -->
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer text-center">
                <i class="fa fa-copyright"></i> <span class="current-year"></span> Sistema POS.
            </footer>
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
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/jscalendario.js"></script>
    <script type="text/javascript" src="assets/script/jsconteo_inicial.js"></script>

    <script>
    $(document).ready(function() {
        BuscaHistorialConteosIniciales();
    });
    </script>

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
