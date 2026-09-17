<?php
if ((isset($_SERVER['PATH_INFO']) && strpos($_SERVER['PATH_INFO'], 'meseras') !== false) || 
    (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'panel.php/meseras') !== false)) {
    $base = (strpos($_SERVER['REQUEST_URI'], '/pos/') !== false) ? '/pos/meseras/' : '/meseras/';
    header("Location: " . $base);
    exit;
}
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="vendedor") {

$tra = new Login();
$ses = $tra->ExpiraSession();

$new = new Login();
$con = $new->ContarRegistros();

$dash = new Login();
$resumen = $dash->DashboardResumenGeneral();

$ventashoysuc = new Login();
$ventashoy = $ventashoysuc->VentasHoyPorSucursal();

$cajasabiertas = new Login();
$cajas = $cajasabiertas->CajasAbiertasPorSucursal();

$stockbajogen = new Login();
$stockbajo = $stockbajogen->ProductosStockBajoGeneral();

$creditosgen = new Login();
$creditos = $creditosgen->CreditosPendientesGeneral();

require_once("class/class.dashboard_control.php");
$ctrlService = new DashboardControlService();
$kpisInventario = $ctrlService->obtenerKpisInventarioHoy();
$semaforoCajas = $ctrlService->obtenerSemaforoCajasAbiertas();
$ultimosConteos = $ctrlService->obtenerUltimosConteos(6);

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

    <!--############################## MODAL PARA VER DETALLE DE CONTEO INICIAL ######################################-->
    <div id="myModalConteoInicial" class="modal fade" role="dialog" aria-labelledby="myModalLabelConteo" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h4 class="modal-title font-weight-bold" id="myModalLabelConteo"><i class="fa fa-clipboard"></i> Detalle de Inventario Inicial / Relevo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                <div class="modal-body" id="contenido_modal_conteo">
                    <!-- Carga por AJAX -->
                </div>
            </div>
        </div>
    </div>
    <!--############################## MODAL PARA VER DETALLE DE CONTEO INICIAL ######################################-->

    <!--############################## MODAL FALTANTES PENDIENTES DE DÍAS ANTERIORES ######################################-->
    <div id="myModalFaltantesAnteriores" class="modal fade" role="dialog" aria-labelledby="myModalLabelFaltantesAnt" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h4 class="modal-title font-weight-bold" id="myModalLabelFaltantesAnt"><i class="fa fa-history"></i> Faltantes Pendientes de Días Anteriores (Histórico por Cuadrar)</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                <div class="modal-body p-0" id="contenido_modal_faltantes_anteriores">
                    <!-- Carga por AJAX -->
                </div>
            </div>
        </div>
    </div>
    <!--############################## MODAL FALTANTES PENDIENTES DE DÍAS ANTERIORES ######################################-->

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
                <!-- Dashboard Administrador General -->
                <!-- ============================================================== -->

    <?php if ($_SESSION['acceso'] == "administradorG") { ?> 

    <!-- Row KPIs del Día -->
    <div class="row" id="kpi-resumen">
        <div class="col-md-6 col-lg-3">
            <div class="card border-top border-success">
                <div class="card-body">
                    <h5 class="card-title text-uppercase text-success">Ventas Hoy</h5>
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <h2 class="mb-0 display-5"><i class="fa fa-cart-plus text-success"></i></h2>
                        <div class="ml-auto text-right">
                            <h2 class="mb-0 display-6"><span class="font-normal" id="kpi-ventas-monto"><?php echo $resumen[0]['ventashoy']; ?></span></h2>
                            <small class="text-muted"><span id="kpi-ventas-cant"><?php echo $resumen[0]['nventashoy']; ?></span> ventas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-top border-info">
                <div class="card-body">
                    <h5 class="card-title text-uppercase text-info">Compras Hoy</h5>
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <h2 class="mb-0 display-5"><i class="fa fa-cart-arrow-down text-info"></i></h2>
                        <div class="ml-auto text-right">
                            <h2 class="mb-0 display-6"><span class="font-normal" id="kpi-compras-monto"><?php echo $resumen[0]['comprashoy']; ?></span></h2>
                            <small class="text-muted"><span id="kpi-compras-cant"><?php echo $resumen[0]['ncomprashoy']; ?></span> compras</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-top border-warning">
                <div class="card-body">
                    <h5 class="card-title text-uppercase text-warning">Créditos por Cobrar</h5>
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <h2 class="mb-0 display-5"><i class="fa fa-money text-warning"></i></h2>
                        <div class="ml-auto">
                            <h2 class="mb-0 display-6"><span class="font-normal" id="kpi-credito-ventas"><?php echo $resumen[0]['creditoventaspendiente']; ?></span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-top border-danger">
                <div class="card-body">
                    <h5 class="card-title text-uppercase text-danger">Créditos por Pagar</h5>
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <h2 class="mb-0 display-5"><i class="fa fa-credit-card text-danger"></i></h2>
                        <div class="ml-auto">
                            <h2 class="mb-0 display-6"><span class="font-normal" id="kpi-credito-compras"><?php echo $resumen[0]['creditocompraspendiente']; ?></span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    <!-- Row KPIs de Control Antirrobo y Relevos de Turno -->
    <div class="row" id="kpi-inventario-control">
        <div class="col-md-6 col-lg-3">
            <div class="card border-top <?php echo ($kpisInventario['unidades_faltantes_pendientes'] > 0 ? 'border-danger' : 'border-success'); ?>">
                <div class="card-body">
                    <h5 class="card-title text-uppercase <?php echo ($kpisInventario['unidades_faltantes_pendientes'] > 0 ? 'text-danger font-weight-bold' : 'text-success font-weight-bold'); ?>">
                        <i class="fa fa-shield"></i> Faltantes de Hoy (<?php echo date('d/m/Y'); ?>)
                    </h5>
                    <div class="d-flex align-items-center mb-2 mt-2">
                        <h2 class="mb-0 display-5"><i class="fa <?php echo ($kpisInventario['unidades_faltantes_pendientes'] > 0 ? 'fa-exclamation-circle text-danger' : 'fa-check-circle text-success'); ?>"></i></h2>
                        <div class="ml-auto text-right">
                            <h2 class="mb-0 display-6">
                                <span class="font-normal <?php echo ($kpisInventario['unidades_faltantes_pendientes'] > 0 ? 'text-danger font-weight-bold' : 'text-success font-weight-bold'); ?>" id="kpi-inv-faltantes-uds">
                                    <?php echo ($kpisInventario['unidades_faltantes_pendientes'] > 0 ? '-' . number_format($kpisInventario['unidades_faltantes_pendientes'], 0) : '0'); ?>
                                </span> <small style="font-size: 15px;">uds</small>
                            </h2>
                            <small class="<?php echo ($kpisInventario['unidades_faltantes_pendientes'] > 0 ? 'text-danger font-weight-bold' : 'text-success font-weight-bold'); ?>" id="kpi-inv-faltantes-monto">
                                <?php if ($kpisInventario['unidades_faltantes_pendientes'] > 0) { ?>
                                    Est. -Bs. <?php echo number_format($kpisInventario['costo_faltante_pendiente'], 2, '.', ','); ?> pendiente
                                <?php } else { ?>
                                    <?php echo ($kpisInventario['unidades_cuadradas_total'] > 0 ? '✓ ' . number_format($kpisInventario['unidades_cuadradas_total'], 0) . ' uds Cuadradas/Ajustadas' : '100% Cuadrado'); ?>
                                <?php } ?>
                            </small>
                            <?php if ($kpisInventario['unidades_faltantes_pendientes'] > 0 && $kpisInventario['unidades_cuadradas_total'] > 0) { ?>
                                <br><small class="text-info font-weight-bold"><i class="fa fa-check"></i> <?php echo number_format($kpisInventario['unidades_cuadradas_total'], 0); ?> uds ya cuadradas</small>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="mt-2 border-top pt-2 text-right">
                        <button type="button" class="btn btn-xs btn-outline-danger font-weight-bold" id="btn_faltantes_anteriores" onclick="AbrirModalFaltantesAnteriores()" title="Ver faltantes de días anteriores para revisar y cuadrar">
                            <i class="fa fa-history"></i> Faltantes Días Anteriores (<?php echo number_format($kpisInventario['dias_anteriores_faltantes_uds'], 0); ?> uds)
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-top <?php echo ($kpisInventario['cajas_sin_conteo'] > 0 ? 'border-warning' : 'border-info'); ?>">
                <div class="card-body">
                    <h5 class="card-title text-uppercase <?php echo ($kpisInventario['cajas_sin_conteo'] > 0 ? 'text-warning font-weight-bold' : 'text-info'); ?>">
                        <i class="fa fa-clock-o"></i> Relevos de Turno
                    </h5>
                    <div class="d-flex align-items-center mb-2 mt-3">
                        <h2 class="mb-0 display-5"><i class="fa fa-users <?php echo ($kpisInventario['cajas_sin_conteo'] > 0 ? 'text-warning' : 'text-info'); ?>"></i></h2>
                        <div class="ml-auto text-right">
                            <h2 class="mb-0 display-6"><span class="font-normal" id="kpi-inv-total-conteos"><?php echo $kpisInventario['total_conteos_hoy']; ?></span> <small style="font-size: 15px;">conteos</small></h2>
                            <small class="<?php echo ($kpisInventario['cajas_sin_conteo'] > 0 ? 'badge badge-warning text-dark font-weight-bold' : 'text-muted'); ?>" id="kpi-inv-cajas-alerta">
                                <?php if ($kpisInventario['cajas_sin_conteo'] > 0) { ?>
                                    ⚠️ <?php echo $kpisInventario['cajas_sin_conteo']; ?> caja(s) sin contar
                                <?php } else { ?>
                                    Cajas al día
                                <?php } ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-top <?php echo ($kpisInventario['conteos_con_pendientes'] > 0 ? 'border-warning' : 'border-primary'); ?>">
                <div class="card-body">
                    <h5 class="card-title text-uppercase text-primary">
                        <i class="fa fa-balance-scale"></i> Turnos Cuadrados
                    </h5>
                    <div class="d-flex align-items-center mb-2 mt-3">
                        <h2 class="mb-0 display-5"><i class="fa fa-thumbs-up text-primary"></i></h2>
                        <div class="ml-auto text-right">
                            <h2 class="mb-0 display-6"><span class="font-normal" id="kpi-inv-cuadrados"><?php echo $kpisInventario['conteos_cuadrados_totales']; ?></span> <small style="font-size: 15px;">/ <?php echo $kpisInventario['total_conteos_hoy']; ?></small></h2>
                            <small class="text-muted" id="kpi-inv-diferencias">
                                <?php if ($kpisInventario['conteos_con_pendientes'] > 0) { ?>
                                    <span class="text-danger font-weight-bold"><?php echo $kpisInventario['conteos_con_pendientes']; ?> con faltante activo</span>
                                <?php } else { ?>
                                    <span class="text-success font-weight-bold"><i class="fa fa-check"></i> Todos resueltos</span>
                                <?php } ?>
                                <?php if ($kpisInventario['conteos_resueltos'] > 0) { ?>
                                    <br><small class="text-info font-weight-bold">(<?php echo $kpisInventario['conteos_resueltos']; ?> cuadrados por ajuste/compra)</small>
                                <?php } ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-top border-dark">
                <div class="card-body">
                    <h5 class="card-title text-uppercase text-dark">
                        <i class="fa fa-shield"></i> Control de Pérdidas
                    </h5>
                    <div class="d-flex align-items-center mb-2 mt-3">
                        <h2 class="mb-0 display-5"><i class="fa fa-search text-dark"></i></h2>
                        <div class="ml-auto text-right">
                            <a href="conteosiniciales" class="btn btn-xs btn-outline-dark mb-1 font-weight-bold"><i class="fa fa-clipboard"></i> Historial Conteos</a>
                            <br>
                            <a href="perdidasxfechas" class="btn btn-xs btn-outline-danger font-weight-bold"><i class="fa fa-file-text-o"></i> Auditoría Pérdidas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    <!-- Row Gráfico + Tabla Ventas Hoy por Sucursal -->
    <div class="row">
        <div class="col-md-7 col-lg-8">
            <div class="card">
                <div class="card-header bg-danger">
                    <h4 class="card-title text-white"><i class="fa fa-bar-chart"></i> Ventas de Hoy por Sucursal</h4>
                </div>
                <div class="card-body">
                    <div id="chart-container">
                        <canvas id="barChartVentasHoy" width="400" height="150"></canvas>
                    </div>
                    <script>
                    $(document).ready(function () {
                        showGraphVentasHoySucursal();
                        // Actualizar dashboard cada 5 minutos
                        setInterval(function(){
                            updateDashboardKPIs();
                            showGraphVentasHoySucursal();
                        }, 300000);
                    });
                    </script>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-lg-4">
            <div class="card">
                <div class="card-header bg-danger">
                    <h4 class="card-title text-white"><i class="fa fa-list"></i> Detalle por Sucursal</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">Sucursal</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($ventashoy==""){ ?>
                                <tr><td colspan="3" class="text-center">NO HAY VENTAS DE HOY</td></tr>
                                <?php } else { 
                                $totalventashoy = 0;
                                for($i=0;$i<sizeof($ventashoy);$i++){
                                    $totalventashoy += $ventashoy[$i]['total'];
                                ?>
                                <tr>
                                    <td><?php echo $ventashoy[$i]['nomsucursal']; ?></td>
                                    <td class="text-center"><?php echo $ventashoy[$i]['cantidad']; ?></td>
                                    <td class="text-right"><?php echo number_format($ventashoy[$i]['total'], 2, '.', ','); ?></td>
                                </tr>
                                <?php } ?>
                                <tr class="bg-light font-weight-bold">
                                    <td>TOTAL</td>
                                    <td class="text-center">-</td>
                                    <td class="text-right"><?php echo number_format($totalventashoy, 2, '.', ','); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    <!-- Row Cajas Operativas (Semáforo de Relevo) + Novedades de Inventario Inicial -->
    <div class="row">
        <!-- Semáforo de Cajas Abiertas y Relevos -->
        <div class="col-md-12 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-danger d-flex align-items-center justify-content-between">
                    <h4 class="card-title text-white mb-0"><i class="fa fa-desktop"></i> Monitoreo de Cajas y Relevos de Turno</h4>
                    <span class="badge badge-light font-weight-bold">Semáforo en Vivo</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">Sucursal</th>
                                    <th class="text-center">Caja / Turno</th>
                                    <th class="text-center">Cajero</th>
                                    <th class="text-center">Apertura</th>
                                    <th class="text-center">Estado Relevo</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($semaforoCajas)){ ?>
                                <tr><td colspan="6" class="text-center py-3 text-muted">NO HAY CAJAS OPERATIVAS ABIERTAS</td></tr>
                                <?php } else { foreach($semaforoCajas as $sc){ ?>
                                <tr>
                                    <td class="align-middle font-weight-bold"><?php echo $sc['nomsucursal']; ?></td>
                                    <td class="text-center align-middle">
                                        <span class="font-medium"><?php echo $sc['nomcaja']; ?></span>
                                        <?php if (!empty($sc['turno'])) { ?>
                                            <br><small class="text-muted">(<?php echo $sc['turno']; ?>)</small>
                                        <?php } ?>
                                    </td>
                                    <td class="align-middle"><?php echo $sc['cajero']; ?></td>
                                    <td class="text-center align-middle">
                                        <small><?php echo date("H:i", strtotime($sc['fechaapertura'])); ?></small>
                                        <br><small class="text-muted"><?php echo $sc['minutos_abierta']; ?> min</small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge <?php echo $sc['badge_clase']; ?> p-1 font-weight-bold">
                                            <?php if ($sc['estado_semaforo'] == 'VERDE') { ?>
                                                <i class="fa fa-check"></i> CUADRADO
                                            <?php } elseif ($sc['estado_semaforo'] == 'AZUL') { ?>
                                                <i class="fa fa-check-circle"></i> CUADRADO / AJUSTADO
                                            <?php } elseif ($sc['estado_semaforo'] == 'ROJO') { ?>
                                                <i class="fa fa-exclamation-triangle"></i> FALTANTE (-<?php echo number_format($sc['unidades_faltantes'], 0); ?>)
                                            <?php } else { ?>
                                                <i class="fa fa-clock-o"></i> SIN CONTEO
                                            <?php } ?>
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if (!empty($sc['idconteo'])) { ?>
                                            <button type="button" class="btn btn-xs btn-outline-info" title="Ver detalle del conteo inicial" onclick="AbrirModalConteoInicial('<?php echo $sc['idconteo']; ?>', '<?php echo $sc['codsucursal']; ?>', '<?php echo $sc['codarqueo']; ?>', '<?php echo $sc['codcaja']; ?>', '<?php echo $sc['turno']; ?>')">
                                                <i class="fa fa-eye"></i> Conteo
                                            </button>
                                        <?php } else { ?>
                                            <span class="text-warning font-weight-bold" title="Cajero aún no registra inventario inicial">⚠️ Pendiente</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Novedades de Inventario Inicial por Turno -->
        <div class="col-md-12 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-dark d-flex align-items-center justify-content-between">
                    <h4 class="card-title text-white mb-0"><i class="fa fa-history"></i> Novedades en Relevos</h4>
                    <a href="conteosiniciales" class="badge badge-warning text-dark font-weight-bold">Ver Todos</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Turno / Sucursal</th>
                                    <th>Cajero</th>
                                    <th class="text-center">Resultado</th>
                                    <th class="text-center">Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($ultimosConteos)){ ?>
                                <tr><td colspan="4" class="text-center py-3 text-muted">NO HAY CONTEOS RECIENTES</td></tr>
                                <?php } else { foreach($ultimosConteos as $uc){ ?>
                                <tr>
                                    <td class="align-middle">
                                        <span class="font-weight-bold"><?php echo !empty($uc['turno']) ? $uc['turno'] : $uc['nomcaja']; ?></span>
                                        <br><small class="text-muted"><?php echo $uc['nomsucursal']; ?> (<?php echo date("d/m H:i", strtotime($uc['fechaconteo'])); ?>)</small>
                                    </td>
                                    <td class="align-middle">
                                        <small class="font-weight-bold"><?php echo $uc['usuario_conteo']; ?></small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge <?php echo $uc['badge_clase']; ?> font-weight-bold">
                                            <i class="fa <?php echo $uc['icono']; ?>"></i> <?php echo $uc['texto_resultado']; ?>
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-xs btn-outline-dark" onclick="AbrirModalConteoInicial('<?php echo $uc['idconteo']; ?>', '<?php echo $uc['codsucursal']; ?>')">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    <!-- Row Productos con Stock Bajo -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header bg-danger">
                    <h4 class="card-title text-white"><i class="fa fa-cubes"></i> Productos con Stock Bajo</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">Producto</th>
                                    <th class="text-center">Sucursal</th>
                                    <th class="text-center">Existencia</th>
                                    <th class="text-center">Stock Mínimo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($stockbajo==""){ ?>
                                <tr><td colspan="4" class="text-center">NO HAY PRODUCTOS CON STOCK BAJO</td></tr>
                                <?php } else { for($i=0;$i<sizeof($stockbajo);$i++){ ?>
                                <tr>
                                    <td><?php echo $stockbajo[$i]['producto']; ?></td>
                                    <td><?php echo $stockbajo[$i]['nomsucursal']; ?></td>
                                    <td class="text-center text-danger font-weight-bold"><?php echo $stockbajo[$i]['existencia']; ?></td>
                                    <td class="text-center"><?php echo $stockbajo[$i]['stockminimo']; ?></td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    <!-- Row Créditos Pendientes -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header bg-danger">
                    <h4 class="card-title text-white"><i class="fa fa-bell"></i> Créditos Pendientes</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Código</th>
                                    <th class="text-center">Cliente / Proveedor</th>
                                    <th class="text-center">Sucursal</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Vencimiento</th>
                                    <th class="text-center">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($creditos==""){ ?>
                                <tr><td colspan="7" class="text-center">NO HAY CRÉDITOS PENDIENTES</td></tr>
                                <?php } else { for($i=0;$i<sizeof($creditos);$i++){ ?>
                                <tr>
                                    <td>
                                        <?php if($creditos[$i]['tipo'] == 'DEUDA CLIENTE'){ ?>
                                        <span class="badge badge-warning">POR COBRAR</span>
                                        <?php } else { ?>
                                        <span class="badge badge-danger">POR PAGAR</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center"><?php echo $creditos[$i]['codigo']; ?></td>
                                    <td><?php echo $creditos[$i]['tercero']; ?></td>
                                    <td><?php echo $creditos[$i]['nomsucursal']; ?></td>
                                    <td class="text-center"><?php echo $creditos[$i]['fecha']; ?></td>
                                    <td class="text-center"><?php echo $creditos[$i]['vencimiento']; ?></td>
                                    <td class="text-right"><?php echo number_format($creditos[$i]['monto'], 2, '.', ','); ?></td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    <!-- ============================================================== -->
    <!-- Grafico Anual por Sucursales -->
    <!-- ============================================================== -->
    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header bg-danger">
                    <h4 class="card-title text-white"><i class="fa fa-line-chart"></i> Gráfico Anual por Sucursales</h4>
                </div>
                <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        Comparativo de Sucursales del Año <?php echo date("Y"); ?>
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
    <!-- Grafico Anual por Sucursales -->
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
    <script src="assets/js/sweetalert-dev.js"></script>
    <script type="text/javascript" src="assets/script/jsconteo_inicial.js"></script>
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