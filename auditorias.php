<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG") {

        $tra = new Login();
        $ses = $tra->ExpiraSession();

        if (isset($_POST["proceso"]) && $_POST["proceso"] == "save_auditoria") {
            $reg = $tra->RegistrarAuditoria();
            exit;
        }
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Auditoría Diaria de Productos - Administrador General</title>

    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/alert.css">

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
                    <div class="col-lg-4 col-md-5 col-xs-12 align-self-center">
                        <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-clipboard-check"></i> Auditoría Diaria de Productos</h5>
                    </div>
                    <div class="col-lg-8 col-md-7 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Inventario</li>
                                <li class="breadcrumb-item active">Auditoría Diaria</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="page-content container-fluid">

                <!-- Filtros Principales -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-danger">
                                <h4 class="card-title text-white mb-0"><i class="fa fa-sliders"></i> Parámetros del Turno a Auditar</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">1. Seleccione Sucursal: <span class="text-danger">*</span></label>
                                            <select name="codsucursal" id="codsucursal" class="form-control" required>
                                                <option value=""> -- SELECCIONE SUCURSAL -- </option>
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

                                    <?php
                                    $defaultDesde = date("Y-m-d") . " 14:00";
                                    $defaultHasta = date("Y-m-d", strtotime("+1 day")) . " 04:00";
                                    ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">2. Fecha y Hora Inicio: <span class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control" name="fechadesde" id="fechadesde" value="<?php echo str_replace(' ', 'T', $defaultDesde); ?>" required>
                                            <small class="text-muted">Inicio de turno tarde (Ej: 2:00 PM)</small>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">3. Fecha y Hora Fin: <span class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control" name="fechahasta" id="fechahasta" value="<?php echo str_replace(' ', 'T', $defaultHasta); ?>" required>
                                            <small class="text-muted">Cierre nocturno (Ej: 3:00 / 4:00 AM)</small>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">4. Familia / Categoría: <small>(Opcional)</small></label>
                                            <select name="codfamilia" id="codfamilia" class="form-control">
                                                <option value=""> -- TODAS LAS FAMILIAS -- </option>
                                                <?php
                                                $fam = new Login();
                                                $listaFamilias = $fam->ListarFamilias();
                                                if (!empty($listaFamilias)) {
                                                    foreach ($listaFamilias as $f) { ?>
                                                        <option value="<?php echo encrypt($f['codfamilia']); ?>">
                                                            <?php echo htmlspecialchars($f['nomfamilia']); ?>
                                                        </option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right mt-2">
                                    <a href="auditoriasxfechas" class="btn btn-outline-secondary mr-2"><i class="fa fa-history"></i> Ver Historial de Auditorías</a>
                                    <button type="button" onClick="CargarProductosAuditoria()" class="btn btn-danger font-weight-bold"><i class="fa fa-search"></i> Cargar Productos para Auditar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenedor donde se carga la tabla de auditoría -->
                <div id="contenedor_auditoria"></div>

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
    <script type="text/javascript" src="assets/script/jsauditorias.js"></script>
    <script type="text/javascript" src="assets/script/jsconteo_inicial.js"></script>

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
