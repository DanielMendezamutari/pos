<?php
// PDF binary output — errors must never reach the response stream
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ob_start();
require_once 'fpdf/pdf.php';
require_once 'fpdf/barcode.php';
require_once 'class/class.php';

$casos = [
  'PROVINCIAS'               => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarProvincias',
    'output'  => ['Listado de Provincias.pdf', 'I'],
  ],
  'DEPARTAMENTOS'                => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarDepartamentos',
    'output'  => ['Listado de Departamentos.pdf', 'I'],
  ],
  'DOCUMENTOS'             => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarDocumentos',
    'output'  => ['Listado de Tipos de Documentos.pdf', 'I'],
  ],
  'TIPOMONEDA'             => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarTiposMonedas',
    'output'  => ['Listado de Tipos de Moneda.pdf', 'I'],
  ],
  'TIPOCAMBIO'             => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarTiposCambio',
    'output'  => ['Listado de Tipos de Cambio.pdf', 'I'],
  ],
  'MEDIOSPAGOS'            => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarMediosPagos',
    'output'  => ['Listado de Medios de Pago.pdf', 'I'],
  ],
  'IMPUESTOS'              => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarImpuestos',
    'output'  => ['Listado de Impuestos.pdf', 'I'],
  ],
  'BANCOS'            => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarBancos',
    'output'  => ['Listado de Bancos.pdf', 'I'],
  ],
  'FAMILIAS'               => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarFamilias',
    'output'  => ['Listado de Familias.pdf', 'I'],
  ],
  'SUBFAMILIAS'            => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarSubfamilias',
    'output'  => ['Listado de Sub-Familias.pdf', 'I'],
  ],
  'MARCAS'                 => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarMarcas',
    'output'  => ['Listado de Marcas.pdf', 'I'],
  ],
  'MODELOS'                => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarModelos',
    'output'  => ['Listado de Modelos.pdf', 'I'],
  ],
  'PRESENTACIONES'         => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarPresentaciones',
    'output'  => ['Listado de Presentaciones.pdf', 'I'],
  ],
  'COLORES'                => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarColores',
    'output'  => ['Listado de Colores.pdf', 'I'],
  ],
  'ORIGENES'               => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarOrigenes',
    'output'  => ['Listado de Origenes.pdf', 'I'],
  ],
  'SUCURSALES'             => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarSucursales',
    'output'  => ['Listado de Sucursales.pdf', 'I'],
  ],
  'USUARIOS'               => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarUsuarios',
    'output'  => ['Listado de Usuarios.pdf', 'I'],
  ],
  'LOGS'                   => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarLogs',
    'output'  => ['Listado Logs de Acceso.pdf', 'I'],
  ],
  'CLIENTES'               => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarClientes',
    'output'  => ['Listado de Clientes.pdf', 'I'],
  ],
  'CLIENTESXCREDITOS'               => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarClientesxCreditos',
    'output'  => ['Listado de Creditos Activos de Clientes.pdf', 'I'],
  ],
  'PROVEEDORES'             => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProveedores',
    'output'  => ['Listado de Proveedores.pdf', 'I'],
  ],
  'FACTURAPEDIDO'          => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'FacturaPedido',
    'output'  => ['Factura de Pedido.pdf', 'I'],
  ],
  'PEDIDOS'                => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'ListarPedidos',
    'output'  => ['Listado de Pedidos.pdf', 'I'],
  ],
  'PEDIDOSXPROVEEDOR'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarPedidosxProveedor',
    'output'  => ['Listado de Pedidos x Proveedor.pdf', 'I'],
  ],
  'PEDIDOSXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarPedidosxFechas',
    'output'  => ['Listado de Pedidos x Fechas.pdf', 'I'],
  ],
  'PRODUCTOS'              => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductos',
    'output'  => ['Listado de Productos.pdf', 'I'],
  ],
  'STOCKOPTIMO'            => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosOptimo',
    'output'  => ['Listado de Productos en Stock Optimo.pdf', 'I'],
  ],
  'STOCKMEDIO'             => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosMedio',
    'output'  => ['Listado de Productos en Stock Medio.pdf', 'I'],
  ],
  'STOCKMINIMO'            => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosMinimo',
    'output'  => ['Listado de Productos en Stock Minimo.pdf', 'I'],
  ],
  'FECHASOPTIMO'            => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosFechasOptimo',
    'output'  => ['Listado de Productos en Fechas Optimo.pdf', 'I'],
  ],
  'FECHASMEDIO'             => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosFechasMedio',
    'output'  => ['Listado de Productos en Fechas Medio.pdf', 'I'],
  ],
  'FECHASMINIMO'            => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosFechasMinimo',
    'output'  => ['Listado de Productos en Fechas Minimo.pdf', 'I'],
  ],
  'CODIGOBARRAS'           => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarCodigoBarras',
    'output'  => ['Listado de Codigo de Barras.pdf', 'I'],
  ],
  'PRODUCTOSXSUCURSALES'   => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosxSucursal',
    'output'  => ['Listado de Productos.pdf', 'I'],
  ],
  'PRODUCTOSXMONEDA'       => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosxMoneda',
    'output'  => ['Listado de Productos por Moneda.pdf', 'I'],
  ],
  'KARDEXPRODUCTO'        => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarKardexProducto',
    'output'  => ['Listado de Kardex de Producto.pdf', 'I'],
  ],
  'KARDEXPRODUCTOSVALORIZADO'       => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarKardexProductosValorizado',
    'output'  => ['Listado de Kardex Productos Valorizado.pdf', 'I'],
  ],
  'PRODUCTOSVALORIZADOXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosValorizadoxFechas',
    'output'  => ['Listado de Productos Valorizado por Fechas.pdf', 'I'],
  ],
  'PRODUCTOSVENDIDOSXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosVendidosxFechas',
    'output'  => ['Listado de Productos Vendidos por Fechas.pdf', 'I'],
  ],

  'COMBOS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCombos',
    'output'  => ['Listado de Combos.pdf', 'I'],
  ],
  'COMBOSMINIMO'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCombosMinimo',
    'output'  => ['Listado de Combos en Stock Minimo.pdf', 'I'],
  ],
  'COMBOSMAXIMO'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCombosMaximo',
    'output'  => ['Listado de Combos en Stock Maximo.pdf', 'I'],
  ],
  'COMBOSXMONEDA'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCombosxMoneda',
    'output'  => ['Listado de Combos por Moneda.pdf', 'I'],
  ],
  'KARDEXCOMBO'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarKardexCombo',
    'output'  => ['Listado de Kardex de Combo.pdf', 'I'],
  ],
  'KARDEXCOMBOSVALORIZADO'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarKardexCombosValorizado',
    'output'  => ['Listado de Kardex Combos Valorizado.pdf', 'I'],
  ],
  'COMBOSVALORIZADOXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCombosValorizadoxFechas',
    'output'  => ['Listado de Combos Valorizado por Fechas.pdf', 'I'],
  ],
  'COMBOSVENDIDOSXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCombosVendidosxFechas',
    'output'  => ['Listado de Combos Vendidos por Fechas.pdf', 'I'],
  ],
  'FACTURATRASPASO'        => [
    'medidas' => ['P', 'mm', 'A4'],
    //'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'FacturaTraspaso',
    'output'  => ['Factura de Traspasos.pdf', 'I'],
  ],
  'TRASPASOS'              => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarTraspasos',
    'output'  => ['Listado de Traspasos.pdf', 'I'],
  ],
  'TRASPASOSXSUCURSAL'     => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarTraspasosxSucursal',
    'output'  => ['Listado de Traspasos por Sucursal.pdf', 'I'],
  ],
  'TRASPASOSXFECHAS'       => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarTraspasosxFechas',
    'output'  => ['Listado de Traspasos por Fechas.pdf', 'I'],
  ],
  'DETALLESTRASPASOSXFECHAS'       => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesTraspasosxFechas',
    'output'  => ['Listado de Detalles Traspasos por Fechas.pdf', 'I'],
  ],
  'FACTURACOMPRA'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'FacturaCompra',
    'output'  => ['Factura de Compra.pdf', 'I'],
  ],
  'COMPRAS'                => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCompras',
    'output'  => ['Listado de Compras.pdf', 'I'],
  ],
  'CUENTASXPAGAR'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCuentasxPagar',
    'output'  => ['Listado de Cuentas por Pagar.pdf', 'I'],
  ],
  'COMPRASXPROVEEDOR'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarComprasxProveedor',
    'output'  => ['Listado de Compras por Proveedor.pdf', 'I'],
  ],
  'COMPRASXFECHAS'         => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarComprasxFechas',
    'output'  => ['Listado de Compras por Fechas.pdf', 'I'],
  ],
  'TICKETCOMPRA'           => [
    'medidas'        => ['P', 'mm', 'ticketcredito'],
    'func'           => 'TicketCreditoCompra',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Abonos.pdf', 'I'],
  ],
  'ABONOSCREDITOSCOMPRASXFECHAS'     => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarAbonosCreditosComprasxFechas',
    'output'  => ['Listado de Abonos Compras a Creditos por Fechas.pdf', 'I'],
  ],
  'CREDITOSCOMPRASXPROVEEDOR'     => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditosComprasxProveedor',
    'output'  => ['Listado de Creditos por Proveedor.pdf', 'I'],
  ],
  'CREDITOSCOMPRASXFECHAS' => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditosComprasxFechas',
    'output'  => ['Listado de Creditos de Compras por Fechas.pdf', 'I'],
  ],
  'DETALLESCREDITOSCOMPRASXPROVEEDOR'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesCreditosComprasxProveedor',
    'output'  => ['Listado Detalles Compras a Creditos por Proveedor.pdf', 'I'],
  ],
  'DETALLESCREDITOSCOMPRASXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesCreditosComprasxFechas',
    'output'  => ['Listado Detalles Compras a Creditos por Fechas.pdf', 'I'],
  ],
  'TICKETCOTIZACION'      => [
    'medidas'        => ['P', 'mm', 'ticket'],
    'func'           => 'TicketCotizacion',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Cotizacion.pdf', 'I'],
  ],
  'FACTURACOTIZACION'      => [
    'medidas'        => ['P', 'mm', 'A4'],
    'func'           => 'FacturaCotizacion',
    'setPrintFooter' => 'true',
    'output'         => ['Factura de Cotizacion.pdf', 'I'],
  ],
  'COTIZACIONES'           => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCotizaciones',
    'output'  => ['Listado de Cotizaciones.pdf', 'I'],
  ],
  'COTIZACIONESXFECHAS'    => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCotizacionesxFechas',
    'output'  => ['Listado de Cotizaciones.pdf', 'I'],
  ],
  'DETALLESCOTIZACIONESXFECHAS'     => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesCotizacionesxFechas',
    'output'  => ['Listado de Detalles Cotizados por Fechas.pdf', 'I'],
  ],
  'DETALLESCOTIZACIONESXVENDEDOR'  => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesCotizacionesxVendedor',
    'output'  => ['Listado de Detalles Cotizados por Vendedor.pdf', 'I'],
  ],
  'TICKETPREVENTA'         => [
    'medidas'        => ['P', 'mm', 'ticket'],
    'func'           => 'TicketPreventa',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Preventa.pdf', 'I'],
  ],
  'PREVENTAS'              => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarPreventas',
    'output'  => ['Listado de Preventas.pdf', 'I'],
  ],
  'CLIENTESXPREVENTAS'       => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'ClientesxPreventas',
    'output'  => ['Listado de Preventas a Clientes.pdf', 'I'],
  ],
  'PREVENTASXFECHAS'       => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarPreventasxFechas',
    'output'  => ['Listado de Preventas.pdf', 'I'],
  ],
  'DETALLESPREVENTASXFECHAS'     => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesPreventasxFechas',
    'output'  => ['Listado de Detalles Preventas por Fechas.pdf', 'I'],
  ],
  'DETALLESPREVENTASXVENDEDOR'     => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesPreventasxVendedor',
    'output'  => ['Listado de Detalles Preventas por Vendedor.pdf', 'I'],
  ],
  'GUIAPREVENTAXFECHAS'    => [
    'medidas'        => ['P', 'mm', 'A4'],
    //'medidas' => array('L', 'mm', 'LEGAL'),
    'func'           => 'GuiaPreventaxFechas',
    'setPrintFooter' => 'true',
    'output'         => ['Guia de Remision.pdf', 'I'],
  ],
  'CAJAS'                  => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarCajas',
    'output'  => ['Listado de Cajas.pdf', 'I'],
  ],
  'ARQUEOS'                => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarArqueos',
    'output'  => ['Listado de Arqueos de Cajas.pdf', 'I'],
  ],
  'TICKETCIERRE'           => [
    'medidas'        => ['P', 'mm', 'cierre'],
    'func'           => 'TicketCierre',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Cierre.pdf', 'I'],
  ],
  'TICKETMOVIMIENTO'           => [
    'medidas'        => ['P', 'mm', 'movimiento'],
    'func'           => 'TicketMovimiento',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Movimiento.pdf', 'I'],
  ],
  'MOVIMIENTOS'            => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarMovimientos',
    'output'  => ['Listado de Movimientos en Caja.pdf', 'I'],
  ],
  'ARQUEOSXFECHAS'         => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarArqueosxFechas',
    'output'  => ['Listado de Arqueos por Fechas.pdf', 'I'],
  ],
  'MOVIMIENTOSXFECHAS'     => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarMovimientosxFechas',
    'output'  => ['Listado de Movimientos por Fechas.pdf', 'I'],
  ],
  'GANANCIASXFECHAS'         => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarGananciasxFechas',
    'output'  => ['Listado de Ganancias por Fechas.pdf', 'I'],
  ],
  'NOTA DE VENTA'                 => [
    'medidas'        => ['P', 'mm', 'ticket'],
    'func'           => 'NotaVenta',
    'setPrintFooter' => 'true',
    'output'         => ['Nota de Venta.pdf', 'I'],
  ],
  'FACTURA'                => [
    'medidas'        => ['P', 'mm', 'A4'],
    //'medidas'        => ['P', 'mm', 'mitad'],
    'func'           => 'FacturaVenta',
    'setPrintFooter' => 'true',
    'output'         => ['Factura de Venta.pdf', 'I'],
  ],
  'BOLETA'                => [
    'medidas'        => ['P', 'mm', 'A4'],
    //'medidas'        => ['P', 'mm', 'mitad'],
    'func'           => 'BoletaVenta',
    'setPrintFooter' => 'true',
    'output'         => ['Boleta de Venta.pdf', 'I'],
  ],
  'GUIA'                => [
    'medidas'        => ['L', 'mm', 'LEGAL'],
    //'medidas'        => ['P', 'mm', 'ticket'],
    'func'           => 'GuiaVenta',
    'setPrintFooter' => 'true',
    'output'         => ['Guia de Remision.pdf', 'I'],
  ],
  'VENTAS'                 => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentas',
    'output'  => ['Listado de Ventas.pdf', 'I'],
  ],
  'VENTASDIARIAS'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentasDiarias',
    'output'  => ['Listado de Ventas del Dia.pdf', 'I'],
  ],
  'VENTASXCAJAS'           => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentasxCajas',
    'output'  => ['Listado de Ventas por Cajas.pdf', 'I'],
  ],
  'VENTASXFECHAS'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentasxFechas',
    'output'  => ['Listado de Ventas por Fechas.pdf', 'I'],
  ],
  'VENTASXCLIENTES'        => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentasxClientes',
    'output'  => ['Listado de Ventas por Clientes.pdf', 'I'],
  ],
  'VENTASXCONDICIONES'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentasxCondiciones',
    'output'  => ['Listado de Ventas por Formas de Pago.pdf', 'I'],
  ],
  'COMISIONXVENTAS'        => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarComisionxVentas',
    'output'  => ['Listado de Comisión por Ventas.pdf', 'I'],
  ],
  'VENTASGENERAL'          => [
    'medidas'        => ['L', 'mm', 'LEGAL'],
    'func'           => 'TicketVentasGeneral',
    'setPrintFooter' => 'true',
    'output'         => ['Ventas General.pdf', 'I'],
  ],
  'DETALLESVENTASXFECHAS'          => [
    'medidas'        => ['L', 'mm', 'LEGAL'],
    'func'           => 'TablaListarDetallesVentasxFechas',
    'output'         => ['Listado de Detalles Ventas por Fechas.pdf', 'I'],
  ],
  'DETALLESVENTASXVENDEDOR'          => [
    'medidas'        => ['L', 'mm', 'LEGAL'],
    'func'           => 'TablaListarDetallesVentasxVendedor',
    'output'         => ['Listado de Detalles Ventas por Vendedor.pdf', 'I'],
  ],
  'TICKETCREDITO'          => [
    'medidas'        => ['P', 'mm', 'ticketcredito'],
    'func'           => 'TicketCredito',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Abonos.pdf', 'I'],
  ],
  'CREDITOS'               => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditos',
    'output'  => ['Listado Ventas a Creditos.pdf', 'I'],
  ],
  'ABONOSCREDITOSVENTASXCAJAS'        => [
    'medidas' => ['L', 'mm', 'LETTER'],
    'func'    => 'TablaListarAbonosCreditosVentasxCajas',
    'output'  => ['Listado de Abonos Ventas a Creditos por Cajas.pdf', 'I'],
  ],
  'CREDITOSVENTASXFECHAS'        => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditosVentasxFechas',
    'output'  => ['Listado Ventas a Creditos por Fechas.pdf', 'I'],
  ],
  'CREDITOSVENTASXCLIENTES'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditosVentasxClientes',
    'output'  => ['Listado Ventas a Creditos por Clientes.pdf', 'I'],
  ],
  'DETALLESCREDITOSVENTASXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesCreditosVentasxFechas',
    'output'  => ['Listado Detalles Ventas a Creditos por Fechas.pdf', 'I'],
  ],
  'DETALLESCREDITOSVENTASXCLIENTE'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesCreditosVentasxClientes',
    'output'  => ['Listado Detalles Ventas a Creditos por Clientes.pdf', 'I'],
  ],
  'NOTACREDITO'            => [
    'medidas'        => ['P', 'mm', 'A4'],
    //'medidas'        => ['P', 'mm', 'mitad'],
    'func'           => 'NotaCredito',
    'setPrintFooter' => 'true',
    'output'         => ['Nota de Credito.pdf', 'I'],
  ],
  'NOTASCREDITO'           => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarNotasCredito',
    'output'  => ['Listado de Notas de Creditos.pdf', 'I'],
  ],
  'NOTASCREDITOXCAJAS'   => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarNotasxCajas',
    'output'  => ['Listado de Notas de Creditos x Cajas.pdf', 'I'],
  ],
  'NOTASCREDITOXFECHAS'    => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarNotasxFechas',
    'output'  => ['Listado de Notas de Creditos x Fechas.pdf', 'I'],
  ],
  'NOTASCREDITOXCLIENTE'   => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarNotasxClientes',
    'output'  => ['Listado de Notas de Creditos x Clientes.pdf', 'I'],
  ],
  'AUDITORIAPRODUCTOS'     => [
    'medidas' => ['L', 'mm', 'A4'],
    'func'    => 'TablaAuditoriaProductos',
    'output'  => ['Reporte de Auditoria de Productos.pdf', 'I'],
  ],
  'CONTEOINICIAL'          => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaConteoInicialProductos',
    'output'  => ['Comprobante de Inventario Inicial.pdf', 'I'],
  ],
  'DISCREPANCIAS_CONTEO'   => [
    'medidas' => ['L', 'mm', 'A4'],
    'func'    => 'TablaAuditoriaAperturaDiscrepancias',
    'output'  => ['Informe de Discrepancias Inventario Inicial.pdf', 'I'],
  ],
  'BAJAINVENTARIO'         => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaBajaInventario',
    'output'  => ['Comprobante de Baja de Inventario.pdf', 'I'],
  ],
];

$tipo = decrypt($_GET['tipo']);
if (!isset($casos[$tipo])) {
  // Invalid report type — silently discard any buffered output and stop
  ob_end_clean();
  header('HTTP/1.0 404 Not Found');
  exit;
}

$caso_data = $casos[$tipo];
$pdf       = new PDF(
  $caso_data['medidas'][0],
  $caso_data['medidas'][1],
  $caso_data['medidas'][2]
);
if (in_array($tipo, ['TICKET', 'FACTURA', 'TICKETPREVENTA', 'TICKETCREDITO'])) {
  $pdf->AutoPrint();
} 
$pdf->AddPage();
$pdf->{$caso_data['func']}();
// Discard any captured warnings/notices before sending the PDF binary
ob_end_clean();
$pdf->Output($caso_data['output'][0], $caso_data['output'][1]);