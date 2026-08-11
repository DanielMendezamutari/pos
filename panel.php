<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="vendedor") {

$tra = new Login();
$ses = $tra->ExpiraSession();

$new = new Login();
$con = $new->ContarRegistros();

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ing. Ruben Chirinos">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title></title>

    <!-- Menu CSS -->
    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Datatables CSS -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- needed css -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
    <!-- color alert -->
    <link rel="stylesheet" type="text/css" href="assets/css/alert.css">

    <!-- script jquery -->
    <script src="assets/script/jquery.min.js"></script> 
    <script type="text/javascript" src="assets/plugins/chart.js/chart.min.js"></script>
    <script type="text/javascript" src="assets/script/graficos.js"></script>
    <!-- script jquery -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body onLoad="muestraReloj()" class="fix-header">
    
   <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <!--<div id="main-wrapper" data-layout="horizontal" data-navbarbg="skin6" data-sidebartype="mini-sidebar" data-boxed-layout="boxed" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar">-->

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-boxed-layout="boxed" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar">

    <!--############################## MODAL PARA VER DETALLE DE VENTA ######################################-->
    <!-- sample modal content -->
    <div id="myModalDetalle" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Detalle de Venta</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                <div class="modal-body">

                    <div id="muestraventamodal"></div> 
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!--############################## MODAL PARA VER DETALLE DE VENTA ######################################-->      

        <!-- INICIO DE MENU -->
        <?php include('menu.php'); ?>
        <!-- FIN DE MENU -->

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb border-bottom">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Dashboard</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item"><a href="panel">Principal</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="page-content container-fluid">
                <!-- ============================================================== -->
                <!-- First Cards Row  -->
                <!-- ============================================================== -->

    <?php if ($_SESSION['acceso'] == "administradorG") { ?> 

    <!-- Row -->
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase">Sucursales</h5>
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <h2 class="mb-0 display-5"><i class="fa fa-bank text-primary"></i></h2>
                        <div class="ml-auto">
                            <h2 class="mb-0 display-6"><span class="font-normal"><?php echo $con[0]['sucursales']; ?></span></h2>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase">Usuarios</h5>
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <h2 class="mb-0 display-5"><i class="fa fa-user text-info"></i></h2>
                        <div class="ml-auto">
                            <h2 class="mb-0 display-6"><span class="font-normal"><?php echo $con[0]['usuarios']; ?></span></h2>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase">Clientes</h5>
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <h2 class="mb-0 display-5"><i class="fa fa-users text-danger"></i></h2>
                        <div class="ml-auto">
                            <h2 class="mb-0 display-6"><span class="font-normal"><?php echo $con[0]['clientes']; ?></span></h2>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase">Proveedores</h5>
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <h2 class="mb-0 display-5"><i class="fa fa-truck text-success"></i></h2>
                        <div class="ml-auto">
                            <h2 class="mb-0 display-6"><span class="font-normal"><?php echo $con[0]['proveedores']; ?></span></h2>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    <!-- ============================================================== -->
    <!-- Grafico por Sucursales -->
    <!-- ============================================================== -->
    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        Gráficos de Sucursales del Año <?php echo date("Y"); ?>
                    </h5>
                    <div id="chart-container">
                        <canvas id="barChart" width="400" height="100"></canvas>
                    </div>
                        <script>
                        $(document).ready(function () {
                            showGraphBarS();
                        });
                        </script>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
    <!-- ============================================================== -->
    <!-- Grafico por Sucursales -->
    <!-- ============================================================== -->

    <?php } elseif ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero") { ?>

    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">

        <!-- Row -->
        <div class="row">

        <!-- .col -->
        <div class="col-md-5">

            <div class="row">

                <div class="col-md-6">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-truck"></i></h2>
                                </div>
                                <div>
                                <a href="proveedores"><h4 class="card-title text-white">Proveedores</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['proveedores']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-user"></i></h2>
                                </div>
                                <div>
                                <a href="clientes"><h4 class="card-title text-white">Clientes</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['clientes']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-cubes"></i></h2>
                                </div>
                                <div>
                                <a href="productos"><h4 class="card-title text-white">Productos</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['productos']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-folder-open"></i></h2>
                                </div>
                                <div>
                                <a href="combos"><h4 class="card-title text-white">Combos</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['combos']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-secondary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-cart-arrow-down"></i></h2>
                                </div>
                                <div>
                                <a href="compras"><h4 class="card-title text-white">Compras</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['compras']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-secondary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-cart-arrow-down"></i></h2>
                                </div>
                                <div>
                                <?php if($con[0]['deudas_compras'] > 0){ ?>
                                <a href="reportepdf?tipo=<?php echo encrypt("CUENTASXPAGAR"); ?>" target="_blank" rel="noopener noreferrer"><h4 class="card-title text-white">Deudas</h4></a>
                                <?php } else { ?>
                                <a href="#"><h4 class="card-title text-white">Deudas</h4></a>
                                <?php } ?>
                                <h4 class="card-subtitle text-white"><?php echo $deuda = ($con[0]['deudas_compras'] == "" ? "0.00" : $con[0]['deudas_compras']); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-calculator"></i></h2>
                                </div>
                                <div>
                                <a href="cotizaciones"><h4 class="card-title text-white">Cotizaciones</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['cotizaciones']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-cart-plus"></i></h2>
                                </div>
                                <div>
                                <a href="ventas"><h4 class="card-title text-white">Ventas</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['ventas']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-danger">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-usd"></i></h2>
                                </div>
                                <div>
                                <h4 class="card-title text-white">Ingresos</h4>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['ingresos']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-danger">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-usd"></i></h2>
                                </div>
                                <div>
                                <h4 class="card-title text-white">Egresos</h4>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['egresos']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
        <!-- /.col -->
        
        <!-- .col -->  
        <div class="col-md-7">

            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title text-uppercase mb-0">
                            Gráfico de Registros
                        </h5>
                        <div id="chart-container">
                            <canvas id="bar-chart" width="800" height="590"></canvas>
                        </div>
                        <script>
                        // Bar chart
                        new Chart(document.getElementById("bar-chart"), {
                        type: 'bar',
                        data: {
                            labels: ["Clientes", "Proveedores", "Productos", "Cotizaciones", "Compras", "Ventas"],
                            datasets: [
                            {
                                label: "Cantidad Nº",
                                backgroundColor: ["#ff7676", "#3e95cd","#3cba9f","#003399","#f0ad4e","#969788"],
                                data: [<?php echo $con[0]['clientes']; ?>,<?php echo $con[0]['proveedores']; ?>,<?php echo $con[0]['productos']; ?>,<?php echo $con[0]['cotizaciones']; ?>,<?php echo $con[0]['compras']; ?>,<?php echo $con[0]['ventas']; ?>]
                            }
                            ]
                        },
                        options: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Cantidad de Registros'
                                }
                            }
                        });
                        </script>
                        </div>
                    </div>
                </div>
            </div>

        </div>
       <!-- /.col -->    
            
        </div>
        <!-- End Row -->

        </div>
    </div>
    <!-- End Row -->

    <?php  
    $compra = new Login();
    $commes = $compra->SumaCompras();

    $cotizacion = new Login();
    $cotmes = $cotizacion->SumaCotizaciones();

    $preventa = new Login();
    $premes = $preventa->SumaPreventas();

    $venta = new Login();
    $venmes = $venta->SumaVentas();
    ?>

    <!-- ============================================================== -->
    <!-- Graficos Individual Compras y Cotizaciones -->
    <!-- ============================================================== -->
    <!-- Row -->
    <div class="row">
        <!-- .col -->
        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        Compras del Año <?php echo date("Y"); ?>
                    </h5>
                    <div id="chart-container">
                    <canvas id="bar-chart1" width="800" height="400"></canvas>
                    </div>
                    <script>
                    // Bar chart
                    new Chart(document.getElementById("bar-chart1"), {
                    type: 'bar',
                    data: {
                    labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
                    datasets: [
                    {
                        label: "Monto Mensual",
                        backgroundColor: ["#ff7676","#3e95cd","#808080","#F38630","#25AECD","#008080","#00FFFF","#3cba9f","#2E64FE","#e8c3b9","#F7BE81","#FA5858"],
                        data: [<?php 

                        if($commes == "") { echo 0; } else {

                            $meses = array(1 => 0, 2=> 0, 3=> 0, 4=> 0, 5=> 0, 6=> 0, 7=> 0, 8=> 0, 9=> 0, 10=> 0, 11=> 0, 12 => 0);
                            foreach($commes as $row) {
                                $mes = $row['mes'];
                                $meses[$mes] = $row['totalmes'];
                            }
                            foreach($meses as $mes) {
                                echo "{$mes},"; } } ?>]
                            }]
                        },
                        options: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Suma de Monto Mensual'
                            }
                        }
                    });
                    </script>
                </div>
            </div>
        </div>
        <!-- .col -->

        <!-- .col -->
        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        Cotizaciones del Año <?php echo date("Y"); ?>  
                    </h5>
                    <div id="chart-container">
                    <canvas id="bar-chart2" width="800" height="400"></canvas>
                    </div>
                    <script>
                    // Bar chart
                    new Chart(document.getElementById("bar-chart2"), {
                    type: 'bar',
                    data: {
                    labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
                    datasets: [
                    {
                        label: "Monto Mensual",
                        backgroundColor: ["#CACFD8","#F2D6C4","#7B82EC","#ff7676","#987DDB","#E8AC9E","#7DA5EA","#8EE1BC","#D3E37D","#E399DA","#F7BE81","#FA5858"],
                        data: [<?php 

                        if($cotmes == "") { echo 0; } else {

                            $meses = array(1 => 0, 2=> 0, 3=> 0, 4=> 0, 5=> 0, 6=> 0, 7=> 0, 8=> 0, 9=> 0, 10=> 0, 11=> 0, 12 => 0);
                            foreach($cotmes as $row) {
                                $mes = $row['mes'];
                                $meses[$mes] = $row['totalmes'];
                            }
                            foreach($meses as $mes) {
                                echo "{$mes},"; } } ?>]
                            }]
                        },
                        options: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Suma de Monto Mensual'
                            }
                        }
                    });
                    </script>
                </div>
            </div>
        </div>
        <!-- .col -->

    </div>
    <!-- End Row -->
    <!-- ============================================================== -->
    <!-- Graficos Individual Compras y Cotizaciones -->
    <!-- ============================================================== -->


    <!-- ============================================================== -->
    <!-- Graficos Individual Preventas y Ventas -->
    <!-- ============================================================== -->
    <!-- Row -->
    <div class="row">
        <!-- .col -->
        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        Preventas del Año <?php echo date("Y"); ?>
                    </h5>
                    <div id="chart-container">
                    <canvas id="bar-chart3" width="800" height="400"></canvas>
                    </div>
                    <script>
                    // Bar chart
                    new Chart(document.getElementById("bar-chart3"), {
                    type: 'bar',
                    data: {
                    labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
                    datasets: [
                    {
                        label: "Monto Mensual",
                        backgroundColor: ["#ff7676","#3e95cd","#808080","#F38630","#25AECD","#008080","#00FFFF","#3cba9f","#2E64FE","#e8c3b9","#F7BE81","#FA5858"],
                        data: [<?php 

                        if($premes == "") { echo 0; } else {

                            $meses = array(1 => 0, 2=> 0, 3=> 0, 4=> 0, 5=> 0, 6=> 0, 7=> 0, 8=> 0, 9=> 0, 10=> 0, 11=> 0, 12 => 0);
                            foreach($premes as $row) {
                                $mes = $row['mes'];
                                $meses[$mes] = $row['totalmes'];
                            }
                            foreach($meses as $mes) {
                                echo "{$mes},"; } } ?>]
                            }]
                        },
                        options: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Suma de Monto Mensual'
                            }
                        }
                    });
                    </script>
                </div>
            </div>
        </div>
        <!-- .col -->

        <!-- .col -->
        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        Ventas del Año <?php echo date("Y"); ?>  
                    </h5>
                    <div id="chart-container">
                    <canvas id="bar-chart4" width="800" height="400"></canvas>
                    </div>
                    <script>
                    // Bar chart
                    new Chart(document.getElementById("bar-chart4"), {
                    type: 'bar',
                    data: {
                    labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
                    datasets: [
                    {
                        label: "Monto Mensual",
                        backgroundColor: ["#CACFD8","#F2D6C4","#7B82EC","#ff7676","#987DDB","#E8AC9E","#7DA5EA","#8EE1BC","#D3E37D","#E399DA","#F7BE81","#FA5858"],
                        data: [<?php 

                        if($venmes == "") { echo 0; } else {

                            $meses = array(1 => 0, 2=> 0, 3=> 0, 4=> 0, 5=> 0, 6=> 0, 7=> 0, 8=> 0, 9=> 0, 10=> 0, 11=> 0, 12 => 0);
                            foreach($venmes as $row) {
                                $mes = $row['mes'];
                                $meses[$mes] = $row['totalmes'];
                            }
                            foreach($meses as $mes) {
                                    echo "{$mes},"; } } ?>]
                            }]
                        },
                        options: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Suma de Monto Mensual'
                            }
                        }
                    });
                    </script>
                </div>
            </div>
        </div>
        <!-- .col -->

    </div>
    <!-- End Row -->
    <!-- ============================================================== -->
    <!-- Graficos Individual Preventas y Ventas -->
    <!-- ============================================================== -->


    <!-- ============================================================== -->
    <!-- Graficos 5 Productos + Vendidos y Total Ventas -->
    <!-- ============================================================== -->
    <!-- Row -->
    <div class="row">
        <!-- .col -->
        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        5 Productos Mas Vendidos del Año <?php echo date("Y"); ?>
                    </h5>
                    <div id="chart-container">
                    <canvas id="DoughnutChart" width="600" height="350"></canvas>
                    </div>
                    <script>
                    $(document).ready(function () {
                        showGraphDoughnutPV();
                    });
                    </script>
                </div>
            </div>
        </div>
        <!-- .col -->

        <!-- .col -->
        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        Total en Ventas del Año <?php echo date("Y"); ?>  
                    </h5>
                    <div id="chart-container">
                    <canvas id="DoughnutChart2" width="600" height="350"></canvas>
                    </div>
                    <script>
                    $(document).ready(function () {
                        showGraphDoughnutVU();
                    });
                    </script>
                </div>
            </div>
        </div>
        <!-- .col -->

    </div>
    <!-- End Row -->
    <!-- ============================================================== -->
    <!-- Graficos 5 Productos + Vendidos y Total Ventas -->
    <!-- ============================================================== -->

    <!-- Row -->
    <div class="row">
       <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas de Hoy <?php echo date("d-m-Y"); ?></h4>
                </div>

                <div class="form-body">
                    <div class="card-body">

                    <div id="ventas"></div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Row -->

    <?php } else { ?>

    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">


            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title text-uppercase mb-0">
                            Gráfico de Registros
                        </h5>
                        <div id="chart-container">
                            <canvas id="bar-chart" width="800" height="400"></canvas>
                        </div>
                        <script>
                        // Bar chart
                        new Chart(document.getElementById("bar-chart"), {
                        type: 'bar',
                        data: {
                            labels: ["Clientes", "Proveedores", "Productos", "Cotizaciones", "Compras", "Ventas"],
                            datasets: [
                            {
                                label: "Cantidad Nº",
                                backgroundColor: ["#ff7676", "#3e95cd","#3cba9f","#003399","#f0ad4e","#969788"],
                                data: [<?php echo $con[0]['clientes']; ?>,<?php echo $con[0]['proveedores']; ?>,<?php echo $con[0]['productos']; ?>,<?php echo $con[0]['cotizaciones']; ?>,<?php echo $con[0]['compras']; ?>,<?php echo $con[0]['ventas']; ?>]
                            }
                            ]
                        },
                        options: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Cantidad de Registros'
                                }
                            }
                        });
                        </script>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Row -->


    <?php } ?> 

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                <i class="fa fa-copyright"></i> <span class="current-year"></span>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
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
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.js"></script>

    <!-- script jquery -->
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <!-- script jquery -->

    <!-- jQuery -->
    <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
    <?php if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero") { ?>
    <script type="text/jscript">
    $('#ventas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
    setTimeout(function() {
    $('#ventas').load("consultas?CargaVentasDiarias=si");
     }, 200);
    </script>
    <?php } ?>


</body>
</html>

<?php } else { ?>   
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER A ESTA PAGINA.\nCONSULTA CON EL ADMINISTRADOR PARA QUE TE DE ACCESO')  
        document.location.href='logout'   
        </script> 
<?php } } else { ?>
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')  
        document.location.href='logout'  
        </script> 
<?php } ?>