<?php
require_once("class/class.php");
$tra = new Login();
$tipo = decrypt($_GET['tipo']);
switch($tipo)
{
	
case 'STATUSUSUARIOS':
$tra->StatusUsuarios();
exit;
break;

case 'USUARIOS':
$tra->EliminarUsuarios();
exit;
break;

case 'PROVINCIAS':
$tra->EliminarProvincias();
exit;
break;

case 'DEPARTAMENTOS':
$tra->EliminarDepartamentos();
exit;
break;

case 'DOCUMENTOS':
$tra->EliminarDocumentos();
exit;
break;

case 'TIPOMONEDA':
$tra->EliminarTipoMoneda();
exit;
break;

case 'TIPOCAMBIO':
$tra->EliminarTipoCambio();
exit;
break;

case 'MEDIOSPAGOS':
$tra->EliminarMediosPagos();
exit;
break;

case 'IMPUESTOS':
$tra->EliminarImpuestos();
exit;
break;

case 'BANCOS':
$tra->EliminarBancos();
exit;
break;

case 'FAMILIAS':
$tra->EliminarFamilias();
exit;
break;

case 'SUBFAMILIAS':
$tra->EliminarSubfamilias();
exit;
break;

case 'MARCAS':
$tra->EliminarMarcas();
exit;
break;

case 'MODELOS':
$tra->EliminarModelos();
exit;
break;

case 'PRESENTACIONES':
$tra->EliminarPresentaciones();
exit;
break;

case 'COLORES':
$tra->EliminarColores();
exit;
break;

case 'ORIGENES':
$tra->EliminarOrigenes();
exit;
break;

case 'STATUSSUCURSALES':
$tra->StatusSucursales();
exit;
break;

case 'SUCURSALES':
$tra->EliminarSucursales();
exit;
break;

case 'CLIENTES':
$tra->EliminarClientes();
exit;
break;

case 'PROVEEDORES':
$tra->EliminarProveedores();
exit;
break;

case 'PEDIDOS':
$tra->EliminarPedidos();
exit;
break;

case 'DETALLESPEDIDOS':
$tra->EliminarDetallesPedidos();
exit;
break;

case 'PRODUCTOS':
$tra->EliminarProductos();
exit;
break;

case 'COMBOS':
$tra->EliminarCombos();
exit;
break;

case 'ELIMINADETALLECOMBO':
$tra->EliminarDetalleCombo();
exit;
break;

case 'TRASPASOS':
$tra->EliminarTraspasos();
exit;
break;

case 'DETALLETRASPASO':
$tra->EliminarDetallesTraspasos();
exit;
break;

case 'COMPRAS':
$tra->EliminarCompras();
exit;
break;

case 'PAGARFACTURA':
$tra->PagarCompras();
exit;
break;

case 'DETALLESCOMPRAS':
$tra->EliminarDetallesCompras();
exit;
break;

case 'COTIZACIONES':
$tra->EliminarCotizaciones();
exit;
break;

case 'DETALLESCOTIZACIONES':
$tra->EliminarDetallesCotizaciones();
exit;
break;

case 'PREVENTAS':
$tra->EliminarPreventas();
exit;
break;

case 'DETALLESPREVENTAS':
$tra->EliminarDetallesPreventas();
exit;
break;

case 'CAJAS':
$tra->EliminarCajas();
exit;
break;

case 'MOVIMIENTOS':
$tra->EliminarMovimientos();
exit;
break;

case 'VENTAS':
$tra->EliminarVentas();
exit;
break;

case 'DETALLESVENTAS':
$tra->EliminarDetallesVentas();
exit;
break;

}
?>