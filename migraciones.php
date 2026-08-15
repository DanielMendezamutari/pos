<?php
require_once("class/class.php");
if(isset($_SESSION['acceso'])) {
if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS") {

$tra = new Login();
$ses = $tra->ExpiraSession();

if(isset($_POST["proceso"]) and limpiar($_POST["proceso"])=="ejecutar")
{
   $reg = $tra->EjecutarMigracionesPendientes();
   exit;
}

$migraciones = $tra->ListarMigracionesPendientes();
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ing. Ruben Chirinos">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title></title>

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
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.js"></script>
<![endif]-->

</head>

<body onLoad="muestraReloj(); getTime();" class="fix-header">

    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-boxed-layout="boxed" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar">

        <?php include('menu.php'); ?>

        <div class="page-wrapper">
            <div class="page-breadcrumb border-bottom">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Actualizaciones</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item"><a href="panel">Principal</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Migraciones</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="page-content container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-danger">
                                <h4 class="card-title text-white"><i class="fa fa-database"></i> Migraciones de Base de Datos</h4>
                            </div>
                            <div class="card-body">

                                <div id="save">
                                    <!-- mensajes de respuesta -->
                                </div>

                                <div class="alert alert-info">
                                    <strong><i class="fa fa-info-circle"></i> Importante:</strong> Antes de ejecutar las actualizaciones, se recomienda realizar un respaldo de la base de datos. Este proceso aplica cambios irreversibles en la estructura de las tablas.
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-12 text-right">
                                        <button type="button" onClick="EjecutarMigraciones()" class="btn btn-danger" id="btn-ejecutar-migraciones"><i class="fa fa-play"></i> Ejecutar Actualizaciones Pendientes</button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead class="bg-danger text-white">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Archivo</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Fecha Ejecución</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($migraciones==""){ ?>
                                            <tr><td colspan="4" class="text-center">NO HAY MIGRACIONES PENDIENTES</td></tr>
                                            <?php } else { 
                                            for($i=0;$i<sizeof($migraciones);$i++){
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i+1; ?></td>
                                                <td><?php echo $migraciones[$i]['archivo']; ?></td>
                                                <td class="text-center">
                                                    <?php if($migraciones[$i]['ejecutada']==1){ ?>
                                                    <span class="badge badge-success">EJECUTADA</span>
                                                    <?php } else { ?>
                                                    <span class="badge badge-warning">PENDIENTE</span>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center"><?php echo $migraciones[$i]['fecha'] == '' ? '-' : date("d-m-Y H:i:s", strtotime($migraciones[$i]['fecha'])); ?></td>
                                            </tr>
                                            <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <footer class="footer text-center">
                <i class="fa fa-copyright"></i> <span class="current-year"></span>.
            </footer>
        </div>
    </div>

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
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>

</body>
</html>

<?php
} else {
?>
<script type="text/javascript">
    window.location="panel";
</script>
<?php
}
} else {
?>
<script type="text/javascript">
    window.location="index";
</script>
<?php
}
?>