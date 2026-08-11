<?php
require_once("class/class.php");
if(isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") {

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
    <title></title>
    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/alert.css">
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
                    <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                        <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Ventas por Categoría</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Ventas</li>
                                <li class="breadcrumb-item active">Ventas x Categoría</li>
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
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Categoría</h4>
            </div>
            <form class="form form-material" method="post" action="#" name="ventasxcategorias" id="ventasxcategorias">
            <div class="form-body"><div class="card-body">

    <?php if($_SESSION['acceso'] == "administradorG") { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group has-feedback">
                <label class="control-label">Seleccione Sucursal: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <select style="color:#000;font-weight:bold;" name="codsucursal" id="codsucursal" class="form-control" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $sucursal = new Login(); $sucursal = $sucursal->ListarSucursales();
                if($sucursal != "") for($i=0;$i<sizeof($sucursal);$i++): ?>
                <option value="<?php echo encrypt($sucursal[$i]['codsucursal']); ?>"><?php echo $sucursal[$i]['cuitsucursal'].": ".$sucursal[$i]['nomsucursal']; ?></option>
                <?php endfor; ?>
                </select>
            </div>
        </div>
    </div>
    <?php } else { ?>
    <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
    <?php } ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label class="control-label">Fecha Desde: <span class="symbol required"></span></label>
                <input type="text" class="form-control" name="desde" id="desde" placeholder="Fecha Desde" autocomplete="off" required="" aria-required="true"/>
                <i class="fa fa-calendar form-control-feedback"></i>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label class="control-label">Fecha Hasta: <span class="symbol required"></span></label>
                <input type="text" class="form-control" name="hasta" id="hasta" placeholder="Fecha Hasta" autocomplete="off" required="" aria-required="true"/>
                <i class="fa fa-calendar form-control-feedback"></i>
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="button" onClick="BuscaVentasxCategoria()" class="btn btn-danger"><span class="fa fa-search"></span> Buscar</button>
    </div>

            </div></div>
            </form>
        </div>
    </div>
</div>

<div id="muestra_resultados"></div>

            </div>
            <footer class="footer text-center"><i class="fa fa-copyright"></i> <span class="current-year"></span>.</footer>
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
    <script src="assets/plugins/bower_components/datatables/datatables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/jscalendario.js"></script>
    <script src="assets/script/autocompleto.js"></script>

    <script>
    function BuscaVentasxCategoria() {
        var codsucursal = $("#codsucursal").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        if(codsucursal=="") { swal("Aviso","SELECCIONE SUCURSAL","warning"); return; }
        if(desde=="") { swal("Aviso","INGRESE FECHA DESDE","warning"); return; }
        if(hasta=="") { swal("Aviso","INGRESE FECHA HASTA","warning"); return; }
        $("#muestra_resultados").html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
        $.get("funciones?BuscaVentasxCategoria=si&codsucursal="+codsucursal+"&desde="+desde+"&hasta="+hasta, function(data) {
            $("#muestra_resultados").html(data);
            $("#datatable").DataTable({ "order": [], "language": { "url": "assets/plugins/datatables/Spanish.json" } });
        });
    }
    </script>
</body>
</html>
<?php } else { ?>
    <script>alert('NO TIENES PERMISO PARA ACCEDER A ESTA PAGINA.'); document.location.href='panel'</script>
<?php } } else { ?>
    <script>alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.'); document.location.href='logout'</script>
<?php } ?>
