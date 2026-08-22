<?php
include('class.consultas.php');
include_once('funciones_basicas.php');

if (isset($_GET['Busqueda_Marcas'])):

$filtro = $_GET["term"];
$Json = new Json;
$marca = $Json->BuscaMarcas($filtro);
echo json_encode($marca);

endif;

if (isset($_GET['Busqueda_Modelos'])):

$filtro = $_GET["term"];
$Json = new Json;
$modelo  = $Json->BuscaModelos($filtro);
echo  json_encode($modelo);

endif;





if (isset($_GET['Busqueda_Clientes'])):

$filtro = $_GET["term"];
$Json = new Json;
$clientes = $Json->BuscaClientes($filtro);
echo json_encode($clientes);

endif;

if (isset($_GET['Busqueda_Clientes_Sucursal'])):

$filtro  = $_GET["term"];
$filtro2 = decrypt($_GET["term2"]);
$Json = new Json;
$clientes = $Json->BuscaClientesxSucursal($filtro,$filtro2);
echo json_encode($clientes);

endif;



if (isset($_GET['Busqueda_Productos'])):

$filtro = $_GET["term"];
$Json = new Json;
$productos  = $Json->BuscaProductos($filtro);
echo json_encode($productos);

endif;

if (isset($_GET['Busqueda_Producto_Barcode']) or isset($_POST['barcode'])):

$filtro = $_POST["barcode"];
$Json = new Json;
$producto = $Json->BuscaProductoBarCode($filtro);
echo json_encode($producto);

endif;

if (isset($_GET['Busqueda_Productos_Sucursal'])):

$filtro  = $_GET["term"];
$filtro2 = decrypt($_GET["term2"]);
$Json = new Json;
$productos = $Json->BuscaProductosxSucursal($filtro,$filtro2);
echo json_encode($productos);

endif;

if (isset($_GET['Busqueda_Producto_Compra'])):

$filtro = $_GET["term"];
$filtro2 = "";
if (isset($_GET["term2"]) && !empty($_GET["term2"])) {
	$filtro2 = is_numeric(decrypt($_GET["term2"])) ? decrypt($_GET["term2"]) : (is_numeric($_GET["term2"]) ? $_GET["term2"] : "");
} elseif (isset($_SESSION["codsucursal"])) {
	$filtro2 = $_SESSION["codsucursal"];
}
$Json = new Json;
$producto = $Json->BuscaProductosCompra($filtro, $filtro2);
echo json_encode($producto);

endif;






if (isset($_GET['Busqueda_Combos'])):

$filtro = $_GET["term"];
$Json = new Json;
$combos  = $Json->BuscaCombos($filtro);
echo json_encode($combos);

endif;

if (isset($_GET['Busqueda_Combos_Sucursal'])):

$filtro  = $_GET["term"];
$filtro2 = decrypt($_GET["term2"]);
$Json = new Json;
$combos = $Json->BuscaCombosxSucursal($filtro,$filtro2);
echo json_encode($combos);

endif;






if (isset($_GET['Busqueda_Facturas'])):

$filtro = $_GET["term"];
$filtro2 = decrypt($_GET["term2"]);
$Json = new Json;
$facturas = $Json->BuscaFacturas($filtro,$filtro2);
echo json_encode($facturas);

endif;

?>  