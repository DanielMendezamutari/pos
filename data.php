<?php
require_once("class/class.php");

header('Content-Type: application/json');

################ RESUMEN GENERAL DEL DIA ########################
if (isset($_GET['DashboardResumenGeneral'])):

$resumen = new Login();
$reg = $resumen->DashboardResumenGeneral();

$data = array();
if (is_array($reg)) {
	foreach ($reg as $row) {
		$data[] = $row;
	}
}

echo json_encode($data);

endif;

################ VENTAS DE HOY POR SUCURSAL ########################
if (isset($_GET['VentasHoyPorSucursal'])):

$ventas = new Login();
$reg = $ventas->VentasHoyPorSucursal();

$data = array();
if (is_array($reg)) {
	foreach ($reg as $row) {
		$data[] = $row;
	}
}

echo json_encode($data);

endif;

################ CAJAS ABIERTAS ########################
if (isset($_GET['CajasAbiertasGeneral'])):

$cajas = new Login();
$reg = $cajas->CajasAbiertasPorSucursal();

$data = array();
if (is_array($reg)) {
	foreach ($reg as $row) {
		$data[] = $row;
	}
}

echo json_encode($data);

endif;

################ STOCK BAJO GENERAL ########################
if (isset($_GET['StockBajoGeneral'])):

$stock = new Login();
$reg = $stock->ProductosStockBajoGeneral();

$data = array();
if (is_array($reg)) {
	foreach ($reg as $row) {
		$data[] = $row;
	}
}

echo json_encode($data);

endif;

################ CREDITOS PENDIENTES GENERAL ########################
if (isset($_GET['CreditosPendientesGeneral'])):

$creditos = new Login();
$reg = $creditos->CreditosPendientesGeneral();

$data = array();
if (is_array($reg)) {
	foreach ($reg as $row) {
		$data[] = $row;
	}
}

echo json_encode($data);

endif;

################ ACCESORIOS DE BILLAR ########################
if (isset($_GET['AccesoriosBillar'])):

$accesorios = new Login();
$reg = $accesorios->ListarAccesoriosBillar();

$data = array();
if (is_array($reg)) {
	foreach ($reg as $row) {
		$data[] = $row;
	}
}

echo json_encode($data);

endif;

################ GRAFICO POR SUCURSALES ########################
if (isset($_GET['ProcesosxSucursales'])):

$grafico = new Login();
$reg = $grafico->GraficoxSucursal();

$data = array();
foreach ($reg as $row) {
	$data[] = $row;
}

echo json_encode($data);

endif;


################ GRAFICO PRODUCTOS MAS VENDIDOS ########################
if (isset($_GET['ProductosVendidos'])):

$prod = new Login();
$p = $prod->ProductosMasVendidos();

$data = array();
if (is_array($p)) {

	foreach ($p as $row) {
		$data[] = $row;
	}
}

echo json_encode($data);

endif;



################ GRAFICO VENTAS POR USUARIOS ########################
if (isset($_GET['VentasxUsuarios'])):

$user = new Login();
$u = $user->VentasxUsuarios();

$data = array();
if (is_array($u)) {

	foreach ($u as $row) {
		$data[] = $row;
	}
}

echo json_encode($data);

endif;
?>