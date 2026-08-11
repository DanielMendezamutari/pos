# +===================================================================
# | Generado el 11-04-2024 a las 00:14:58 
# | Servidor: localhost
# | MySQL Version: 5.5.5-10.4.21-MariaDB
# | PHP Version: 8.0.12
# | Base de datos: 'softventas'
# | Tablas: abonoscreditoscompras;  abonoscreditosventas;  arqueocaja;  bancos;  cajas;  clientes;  colores;  combos;  combosxproductos;  compras;  configuracion;  cotizaciones;  creditosxclientes;  departamentos;  detallecompras;  detallecotizaciones;  detallenotas;  detallepedidos;  detallepreventas;  detalletraspasos;  detalleventas;  documentos;  familias;  impuestos;  kardex;  log;  marcas;  mediospagos;  mediospagoxventas;  modelos;  movimientoscajas;  notascredito;  origenes;  pedidos;  presentaciones;  preventas;  productos;  proveedores;  provincias;  subfamilias;  sucursales;  tiposcambio;  tiposmoneda;  traspasos;  usuarios;  ventas
# +-------------------------------------------------------------------
# Si tienen tablas con relacion y no estan en orden dara problemas al recuperar datos. Para evitarlo:
SET FOREIGN_KEY_CHECKS=0; 
SET time_zone = '+00:00';
SET sql_mode = ''; 


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

# | Vaciado de tabla 'abonoscreditoscompras'
# +-------------------------------------
DROP TABLE IF EXISTS `abonoscreditoscompras`;


# | Estructura de la tabla 'abonoscreditoscompras'
# +-------------------------------------
CREATE TABLE `abonoscreditoscompras` (
  `idabono` int(11) NOT NULL AUTO_INCREMENT,
  `codabono` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcompra` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montoabono` decimal(12,2) NOT NULL,
  `formaabono` int(11) NOT NULL,
  `codbanco` int(11) NOT NULL,
  `comprobante` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaabono` datetime NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`idabono`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'abonoscreditoscompras'
# +-------------------------------------

# | Vaciado de tabla 'abonoscreditosventas'
# +-------------------------------------
DROP TABLE IF EXISTS `abonoscreditosventas`;


# | Estructura de la tabla 'abonoscreditosventas'
# +-------------------------------------
CREATE TABLE `abonoscreditosventas` (
  `codabono` int(11) NOT NULL AUTO_INCREMENT,
  `codarqueo` int(11) NOT NULL,
  `codcaja` int(11) NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montoabono` decimal(12,2) NOT NULL,
  `formaabono` int(11) NOT NULL,
  `fechaabono` datetime NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codabono`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'abonoscreditosventas'
# +-------------------------------------

# | Vaciado de tabla 'arqueocaja'
# +-------------------------------------
DROP TABLE IF EXISTS `arqueocaja`;


# | Estructura de la tabla 'arqueocaja'
# +-------------------------------------
CREATE TABLE `arqueocaja` (
  `codarqueo` int(11) NOT NULL AUTO_INCREMENT,
  `codcaja` int(11) NOT NULL,
  `montoinicial` decimal(12,2) NOT NULL,
  `ingresos` decimal(12,2) NOT NULL,
  `ingresos2` decimal(12,2) NOT NULL,
  `egresos` decimal(12,2) NOT NULL,
  `creditos` decimal(12,2) NOT NULL,
  `abonos` decimal(12,2) NOT NULL,
  `efectivocaja` decimal(12,2) NOT NULL,
  `dineroefectivo` decimal(12,2) NOT NULL,
  `diferencia` decimal(12,2) NOT NULL,
  `comentarios` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaapertura` datetime NOT NULL,
  `fechacierre` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `statusarqueo` int(2) NOT NULL,
  PRIMARY KEY (`codarqueo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'arqueocaja'
# +-------------------------------------

# | Vaciado de tabla 'bancos'
# +-------------------------------------
DROP TABLE IF EXISTS `bancos`;


# | Estructura de la tabla 'bancos'
# +-------------------------------------
CREATE TABLE `bancos` (
  `codbanco` int(11) NOT NULL AUTO_INCREMENT,
  `nombanco` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codbanco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'bancos'
# +-------------------------------------

# | Vaciado de tabla 'cajas'
# +-------------------------------------
DROP TABLE IF EXISTS `cajas`;


# | Estructura de la tabla 'cajas'
# +-------------------------------------
CREATE TABLE `cajas` (
  `codcaja` int(11) NOT NULL AUTO_INCREMENT,
  `nrocaja` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nomcaja` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codcaja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'cajas'
# +-------------------------------------

# | Vaciado de tabla 'clientes'
# +-------------------------------------
DROP TABLE IF EXISTS `clientes`;


# | Estructura de la tabla 'clientes'
# +-------------------------------------
CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipocliente` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documcliente` int(11) NOT NULL,
  `dnicliente` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomcliente` varchar(90) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `razoncliente` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `girocliente` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tlfcliente` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_provincia` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `direccliente` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `emailcliente` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `limitecredito` float(12,2) NOT NULL,
  `fechaingreso` date NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'clientes'
# +-------------------------------------

# | Vaciado de tabla 'colores'
# +-------------------------------------
DROP TABLE IF EXISTS `colores`;


# | Estructura de la tabla 'colores'
# +-------------------------------------
CREATE TABLE `colores` (
  `codcolor` int(11) NOT NULL AUTO_INCREMENT,
  `nomcolor` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codcolor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'colores'
# +-------------------------------------

# | Vaciado de tabla 'combos'
# +-------------------------------------
DROP TABLE IF EXISTS `combos`;


# | Estructura de la tabla 'combos'
# +-------------------------------------
CREATE TABLE `combos` (
  `idcombo` int(11) NOT NULL AUTO_INCREMENT,
  `codcombo` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nomcombo` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codfamilia` int(11) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `existencia` int(5) NOT NULL,
  `stockminimo` int(5) NOT NULL,
  `stockmaximo` int(5) NOT NULL,
  `ivacombo` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `desccombo` decimal(12,2) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`idcombo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'combos'
# +-------------------------------------

# | Vaciado de tabla 'combosxproductos'
# +-------------------------------------
DROP TABLE IF EXISTS `combosxproductos`;


# | Estructura de la tabla 'combosxproductos'
# +-------------------------------------
CREATE TABLE `combosxproductos` (
  `iddetallecombo` int(11) NOT NULL AUTO_INCREMENT,
  `codcombo` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` decimal(12,2) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`iddetallecombo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'combosxproductos'
# +-------------------------------------

# | Vaciado de tabla 'compras'
# +-------------------------------------
DROP TABLE IF EXISTS `compras`;


# | Estructura de la tabla 'compras'
# +-------------------------------------
CREATE TABLE `compras` (
  `idcompra` int(11) NOT NULL AUTO_INCREMENT,
  `codcompra` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codfactura` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `gastoenvio` decimal(12,2) NOT NULL,
  `creditopagado` decimal(12,2) NOT NULL,
  `tipocompra` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `formacompra` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechavencecredito` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechapagado` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `statuscompra` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaemision` date NOT NULL,
  `fecharecepcion` date NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`idcompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'compras'
# +-------------------------------------

# | Vaciado de tabla 'configuracion'
# +-------------------------------------
DROP TABLE IF EXISTS `configuracion`;


# | Estructura de la tabla 'configuracion'
# +-------------------------------------
CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `documsucursal` int(11) NOT NULL,
  `cuit` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomsucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tlfsucursal` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `correosucursal` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_provincia` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `direcsucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `documencargado` int(11) NOT NULL,
  `dniencargado` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomencargado` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'configuracion'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `configuracion` (`id`, `documsucursal`, `cuit`, `nomsucursal`, `tlfsucursal`, `correosucursal`, `id_provincia`, `id_departamento`, `direcsucursal`, `documencargado`, `dniencargado`, `nomencargado`) VALUES 
      ('1', '1', '20180816853', 'GESTIÓN DE VENTAS E INVENTARIO', '(0416) 9987584', 'MOTOGRUPO@GMAIL.COM', '4', '333', 'AVENIDA LOS CAUDILLOS 742', '11', '18081685', 'RUBEN DARIO CHIRINOS RODRIGUEZ');
COMMIT;

# | Vaciado de tabla 'cotizaciones'
# +-------------------------------------
DROP TABLE IF EXISTS `cotizaciones`;


# | Estructura de la tabla 'cotizaciones'
# +-------------------------------------
CREATE TABLE `cotizaciones` (
  `idcotizacion` int(11) NOT NULL AUTO_INCREMENT,
  `codcotizacion` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipodocumento` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codfactura` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `totalpago2` decimal(12,2) NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechacotizacion` datetime NOT NULL,
  `procesada` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`idcotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'cotizaciones'
# +-------------------------------------

# | Vaciado de tabla 'creditosxclientes'
# +-------------------------------------
DROP TABLE IF EXISTS `creditosxclientes`;


# | Estructura de la tabla 'creditosxclientes'
# +-------------------------------------
CREATE TABLE `creditosxclientes` (
  `codcredito` int(11) NOT NULL AUTO_INCREMENT,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montocredito` decimal(12,2) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codcredito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'creditosxclientes'
# +-------------------------------------

# | Vaciado de tabla 'departamentos'
# +-------------------------------------
DROP TABLE IF EXISTS `departamentos`;


# | Estructura de la tabla 'departamentos'
# +-------------------------------------
CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL AUTO_INCREMENT,
  `departamento` varchar(255) CHARACTER SET latin1 NOT NULL,
  `id_provincia` int(11) NOT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'departamentos'
# +-------------------------------------

# | Vaciado de tabla 'detallecompras'
# +-------------------------------------
DROP TABLE IF EXISTS `detallecompras`;


# | Estructura de la tabla 'detallecompras'
# +-------------------------------------
CREATE TABLE `detallecompras` (
  `coddetallecompra` int(11) NOT NULL AUTO_INCREMENT,
  `codcompra` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imei` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `condicion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codmodelo` int(11) NOT NULL,
  `codpresentacion` int(11) NOT NULL,
  `codcolor` int(11) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioxmayor` decimal(12,2) NOT NULL,
  `precioxmenor` decimal(12,2) NOT NULL,
  `precioxpublico` decimal(12,2) NOT NULL,
  `cantcompra` decimal(12,2) NOT NULL,
  `ivaproducto` decimal(12,2) NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `descfactura` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentoc` decimal(12,2) NOT NULL,
  `subtotalimpuestos` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `lote` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaelaboracion` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaoptimo` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechamedio` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaminimo` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `stockoptimo` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `stockmedio` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `stockminimo` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`coddetallecompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'detallecompras'
# +-------------------------------------

# | Vaciado de tabla 'detallecotizaciones'
# +-------------------------------------
DROP TABLE IF EXISTS `detallecotizaciones`;


# | Estructura de la tabla 'detallecotizaciones'
# +-------------------------------------
CREATE TABLE `detallecotizaciones` (
  `coddetallecotizacion` int(11) NOT NULL AUTO_INCREMENT,
  `codcotizacion` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imei` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `condicion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codmodelo` int(11) NOT NULL,
  `codpresentacion` int(11) NOT NULL,
  `codcolor` int(11) NOT NULL,
  `cantcotizacion` decimal(12,2) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaproducto` decimal(12,2) NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentov` decimal(12,2) NOT NULL,
  `subtotalimpuestos` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `valorneto2` decimal(12,2) NOT NULL,
  `tipodetalle` int(2) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`coddetallecotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'detallecotizaciones'
# +-------------------------------------

# | Vaciado de tabla 'detallenotas'
# +-------------------------------------
DROP TABLE IF EXISTS `detallenotas`;


# | Estructura de la tabla 'detallenotas'
# +-------------------------------------
CREATE TABLE `detallenotas` (
  `coddetallenota` int(11) NOT NULL AUTO_INCREMENT,
  `codnota` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imei` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `condicion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codmodelo` int(11) NOT NULL,
  `codpresentacion` int(11) NOT NULL,
  `codcolor` int(11) NOT NULL,
  `cantventa` decimal(12,2) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaproducto` decimal(12,2) NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentov` decimal(12,2) NOT NULL,
  `subtotalimpuestos` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `tipodetalle` int(2) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`coddetallenota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'detallenotas'
# +-------------------------------------

# | Vaciado de tabla 'detallepedidos'
# +-------------------------------------
DROP TABLE IF EXISTS `detallepedidos`;


# | Estructura de la tabla 'detallepedidos'
# +-------------------------------------
CREATE TABLE `detallepedidos` (
  `coddetallepedido` int(11) NOT NULL AUTO_INCREMENT,
  `codpedido` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imei` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `condicion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codmodelo` int(11) NOT NULL,
  `codpresentacion` int(11) NOT NULL,
  `codcolor` int(11) NOT NULL,
  `cantidad` decimal(12,2) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioxmayor` decimal(12,2) NOT NULL,
  `precioxmenor` decimal(12,2) NOT NULL,
  `precioxpublico` decimal(12,2) NOT NULL,
  `ivaproducto` decimal(12,2) NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `descfactura` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentoc` decimal(12,2) NOT NULL,
  `subtotalimpuestos` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`coddetallepedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'detallepedidos'
# +-------------------------------------

# | Vaciado de tabla 'detallepreventas'
# +-------------------------------------
DROP TABLE IF EXISTS `detallepreventas`;


# | Estructura de la tabla 'detallepreventas'
# +-------------------------------------
CREATE TABLE `detallepreventas` (
  `coddetallepreventa` int(11) NOT NULL AUTO_INCREMENT,
  `codpreventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imei` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `condicion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codmodelo` int(11) NOT NULL,
  `codpresentacion` int(11) NOT NULL,
  `codcolor` int(11) NOT NULL,
  `cantpreventa` decimal(12,2) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaproducto` decimal(12,2) NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentov` decimal(12,2) NOT NULL,
  `subtotalimpuestos` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `valorneto2` decimal(12,2) NOT NULL,
  `tipodetalle` int(2) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`coddetallepreventa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'detallepreventas'
# +-------------------------------------

# | Vaciado de tabla 'detalletraspasos'
# +-------------------------------------
DROP TABLE IF EXISTS `detalletraspasos`;


# | Estructura de la tabla 'detalletraspasos'
# +-------------------------------------
CREATE TABLE `detalletraspasos` (
  `coddetalletraspaso` int(11) NOT NULL AUTO_INCREMENT,
  `codtraspaso` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imei` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `condicion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codmodelo` int(11) NOT NULL,
  `codpresentacion` int(11) NOT NULL,
  `codcolor` int(11) NOT NULL,
  `cantidad` decimal(12,2) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaproducto` decimal(12,2) NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentov` decimal(12,2) NOT NULL,
  `subtotalimpuestos` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `valorneto2` decimal(12,2) NOT NULL,
  `tipodetalle` int(2) NOT NULL,
  `codsucursal` int(1) NOT NULL,
  PRIMARY KEY (`coddetalletraspaso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'detalletraspasos'
# +-------------------------------------

# | Vaciado de tabla 'detalleventas'
# +-------------------------------------
DROP TABLE IF EXISTS `detalleventas`;


# | Estructura de la tabla 'detalleventas'
# +-------------------------------------
CREATE TABLE `detalleventas` (
  `coddetalleventa` int(11) NOT NULL AUTO_INCREMENT,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imei` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `condicion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codmodelo` int(11) NOT NULL,
  `codpresentacion` int(11) NOT NULL,
  `codcolor` int(11) NOT NULL,
  `cantventa` decimal(12,2) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaproducto` decimal(12,2) NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentov` decimal(12,2) NOT NULL,
  `subtotalimpuestos` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `valorneto2` decimal(12,2) NOT NULL,
  `tipodetalle` int(2) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`coddetalleventa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'detalleventas'
# +-------------------------------------

# | Vaciado de tabla 'documentos'
# +-------------------------------------
DROP TABLE IF EXISTS `documentos`;


# | Estructura de la tabla 'documentos'
# +-------------------------------------
CREATE TABLE `documentos` (
  `coddocumento` int(11) NOT NULL AUTO_INCREMENT,
  `documento` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`coddocumento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'documentos'
# +-------------------------------------

# | Vaciado de tabla 'familias'
# +-------------------------------------
DROP TABLE IF EXISTS `familias`;


# | Estructura de la tabla 'familias'
# +-------------------------------------
CREATE TABLE `familias` (
  `codfamilia` int(11) NOT NULL AUTO_INCREMENT,
  `nomfamilia` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codfamilia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'familias'
# +-------------------------------------

# | Vaciado de tabla 'impuestos'
# +-------------------------------------
DROP TABLE IF EXISTS `impuestos`;


# | Estructura de la tabla 'impuestos'
# +-------------------------------------
CREATE TABLE `impuestos` (
  `codimpuesto` int(11) NOT NULL AUTO_INCREMENT,
  `nomimpuesto` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `valorimpuesto` decimal(12,2) NOT NULL,
  `statusimpuesto` int(2) NOT NULL,
  `fechaimpuesto` date NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codimpuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'impuestos'
# +-------------------------------------

# | Vaciado de tabla 'kardex'
# +-------------------------------------
DROP TABLE IF EXISTS `kardex`;


# | Estructura de la tabla 'kardex'
# +-------------------------------------
CREATE TABLE `kardex` (
  `codkardex` int(11) NOT NULL AUTO_INCREMENT,
  `codproceso` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codresponsable` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `movimiento` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `entradas` decimal(12,2) NOT NULL,
  `salidas` decimal(12,2) NOT NULL,
  `devolucion` decimal(12,2) NOT NULL,
  `stockactual` decimal(12,2) NOT NULL,
  `ivaproducto` decimal(12,2) NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `documento` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechakardex` date NOT NULL,
  `tipokardex` int(2) NOT NULL,
  `procedimiento` int(2) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  PRIMARY KEY (`codkardex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'kardex'
# +-------------------------------------

# | Vaciado de tabla 'log'
# +-------------------------------------
DROP TABLE IF EXISTS `log`;


# | Estructura de la tabla 'log'
# +-------------------------------------
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tiempo` datetime DEFAULT NULL,
  `detalles` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `paginas` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'log'
# +-------------------------------------

# | Vaciado de tabla 'marcas'
# +-------------------------------------
DROP TABLE IF EXISTS `marcas`;


# | Estructura de la tabla 'marcas'
# +-------------------------------------
CREATE TABLE `marcas` (
  `codmarca` int(11) NOT NULL AUTO_INCREMENT,
  `nommarca` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codmarca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'marcas'
# +-------------------------------------

# | Vaciado de tabla 'mediospagos'
# +-------------------------------------
DROP TABLE IF EXISTS `mediospagos`;


# | Estructura de la tabla 'mediospagos'
# +-------------------------------------
CREATE TABLE `mediospagos` (
  `codmediopago` int(11) NOT NULL AUTO_INCREMENT,
  `mediopago` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codmediopago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'mediospagos'
# +-------------------------------------

# | Vaciado de tabla 'mediospagoxventas'
# +-------------------------------------
DROP TABLE IF EXISTS `mediospagoxventas`;


# | Estructura de la tabla 'mediospagoxventas'
# +-------------------------------------
CREATE TABLE `mediospagoxventas` (
  `idpago` int(11) NOT NULL AUTO_INCREMENT,
  `codarqueo` int(11) NOT NULL,
  `codcaja` int(11) NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmediopago` int(11) NOT NULL,
  `montopagado` decimal(12,2) NOT NULL,
  `montodevuelto` decimal(12,2) NOT NULL,
  PRIMARY KEY (`idpago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'mediospagoxventas'
# +-------------------------------------

# | Vaciado de tabla 'modelos'
# +-------------------------------------
DROP TABLE IF EXISTS `modelos`;


# | Estructura de la tabla 'modelos'
# +-------------------------------------
CREATE TABLE `modelos` (
  `codmodelo` int(11) NOT NULL AUTO_INCREMENT,
  `nommodelo` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codmodelo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'modelos'
# +-------------------------------------

# | Vaciado de tabla 'movimientoscajas'
# +-------------------------------------
DROP TABLE IF EXISTS `movimientoscajas`;


# | Estructura de la tabla 'movimientoscajas'
# +-------------------------------------
CREATE TABLE `movimientoscajas` (
  `codmovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codarqueo` int(11) NOT NULL,
  `codcaja` int(11) NOT NULL,
  `tipomovimiento` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmediopago` int(11) NOT NULL,
  `montomovimiento` decimal(12,2) NOT NULL,
  `descripcionmovimiento` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechamovimiento` datetime NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codmovimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'movimientoscajas'
# +-------------------------------------

# | Vaciado de tabla 'notascredito'
# +-------------------------------------
DROP TABLE IF EXISTS `notascredito`;


# | Estructura de la tabla 'notascredito'
# +-------------------------------------
CREATE TABLE `notascredito` (
  `idnota` int(11) NOT NULL AUTO_INCREMENT,
  `codcaja` int(11) NOT NULL,
  `codnota` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codfactura` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipodocumento` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `facturaventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `fechanota` datetime NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`idnota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'notascredito'
# +-------------------------------------

# | Vaciado de tabla 'origenes'
# +-------------------------------------
DROP TABLE IF EXISTS `origenes`;


# | Estructura de la tabla 'origenes'
# +-------------------------------------
CREATE TABLE `origenes` (
  `codorigen` int(11) NOT NULL AUTO_INCREMENT,
  `nomorigen` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codorigen`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'origenes'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `origenes` (`codorigen`, `nomorigen`, `codsucursal`) VALUES 
      ('1', 'JAPONES', '1'), 
      ('2', 'KOREANO', '1'), 
      ('3', 'CHINO', '1'), 
      ('4', 'TAIWANES', '1'), 
      ('5', 'AMERICANO', '1'), 
      ('6', 'BRASILE?O', '1'), 
      ('7', 'INDIO', '1'), 
      ('8', 'CHILENO', '1'), 
      ('9', 'FRANCES', '1');
COMMIT;

# | Vaciado de tabla 'pedidos'
# +-------------------------------------
DROP TABLE IF EXISTS `pedidos`;


# | Estructura de la tabla 'pedidos'
# +-------------------------------------
CREATE TABLE `pedidos` (
  `idpedido` int(11) NOT NULL AUTO_INCREMENT,
  `codpedido` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codfactura` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechapedido` datetime NOT NULL,
  `procesada` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`idpedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'pedidos'
# +-------------------------------------

# | Vaciado de tabla 'presentaciones'
# +-------------------------------------
DROP TABLE IF EXISTS `presentaciones`;


# | Estructura de la tabla 'presentaciones'
# +-------------------------------------
CREATE TABLE `presentaciones` (
  `codpresentacion` int(11) NOT NULL AUTO_INCREMENT,
  `nompresentacion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codpresentacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'presentaciones'
# +-------------------------------------

# | Vaciado de tabla 'preventas'
# +-------------------------------------
DROP TABLE IF EXISTS `preventas`;


# | Estructura de la tabla 'preventas'
# +-------------------------------------
CREATE TABLE `preventas` (
  `idpreventa` int(11) NOT NULL AUTO_INCREMENT,
  `codpreventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codfactura` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `totalpago2` decimal(12,2) NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechapreventa` datetime NOT NULL,
  `procesada` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`idpreventa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'preventas'
# +-------------------------------------

# | Vaciado de tabla 'productos'
# +-------------------------------------
DROP TABLE IF EXISTS `productos`;


# | Estructura de la tabla 'productos'
# +-------------------------------------
CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL AUTO_INCREMENT,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imei` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `condicion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fabricante` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codfamilia` int(11) NOT NULL,
  `codsubfamilia` int(11) NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codmodelo` int(11) NOT NULL,
  `codpresentacion` int(11) NOT NULL,
  `codcolor` int(11) NOT NULL,
  `codorigen` int(11) NOT NULL,
  `year` varchar(4) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nroparte` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `lote` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `peso` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioxmayor` decimal(12,2) NOT NULL,
  `precioxmenor` decimal(12,2) NOT NULL,
  `precioxpublico` decimal(12,2) NOT NULL,
  `existencia` decimal(12,2) NOT NULL,
  `stockoptimo` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `stockmedio` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `stockminimo` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `codigobarra` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaelaboracion` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaoptimo` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechamedio` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaminimo` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `stockteorico` decimal(12,2) NOT NULL,
  `motivoajuste` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`idproducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'productos'
# +-------------------------------------

# | Vaciado de tabla 'proveedores'
# +-------------------------------------
DROP TABLE IF EXISTS `proveedores`;


# | Estructura de la tabla 'proveedores'
# +-------------------------------------
CREATE TABLE `proveedores` (
  `idproveedor` int(11) NOT NULL AUTO_INCREMENT,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documproveedor` int(11) NOT NULL,
  `cuitproveedor` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nomproveedor` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tlfproveedor` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `direcproveedor` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `emailproveedor` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `vendedor` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tlfvendedor` varchar(20) CHARACTER SET utf32 COLLATE utf32_spanish_ci NOT NULL,
  `fechaingreso` date NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`idproveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'proveedores'
# +-------------------------------------

# | Vaciado de tabla 'provincias'
# +-------------------------------------
DROP TABLE IF EXISTS `provincias`;


# | Estructura de la tabla 'provincias'
# +-------------------------------------
CREATE TABLE `provincias` (
  `id_provincia` int(10) NOT NULL AUTO_INCREMENT,
  `provincia` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id_provincia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'provincias'
# +-------------------------------------

# | Vaciado de tabla 'subfamilias'
# +-------------------------------------
DROP TABLE IF EXISTS `subfamilias`;


# | Estructura de la tabla 'subfamilias'
# +-------------------------------------
CREATE TABLE `subfamilias` (
  `codsubfamilia` int(11) NOT NULL AUTO_INCREMENT,
  `nomsubfamilia` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codfamilia` int(11) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codsubfamilia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'subfamilias'
# +-------------------------------------

# | Vaciado de tabla 'sucursales'
# +-------------------------------------
DROP TABLE IF EXISTS `sucursales`;


# | Estructura de la tabla 'sucursales'
# +-------------------------------------
CREATE TABLE `sucursales` (
  `codsucursal` int(11) NOT NULL AUTO_INCREMENT,
  `documsucursal` int(11) NOT NULL,
  `cuitsucursal` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomsucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_provincia` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `direcsucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `correosucursal` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tlfsucursal` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `inicioticket` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `iniciofactura` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `inicioguia` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `inicionotaventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `inicionotacredito` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nroactividadsucursal` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaautorsucursal` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `llevacontabilidad` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documencargado` int(11) NOT NULL,
  `dniencargado` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomencargado` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tlfencargado` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descsucursal` decimal(12,2) NOT NULL,
  `porcentaje` decimal(12,2) NOT NULL,
  `codmoneda` int(11) NOT NULL,
  `codmoneda2` int(11) NOT NULL,
  `membrete` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(2) NOT NULL,
  PRIMARY KEY (`codsucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'sucursales'
# +-------------------------------------

# | Vaciado de tabla 'tiposcambio'
# +-------------------------------------
DROP TABLE IF EXISTS `tiposcambio`;


# | Estructura de la tabla 'tiposcambio'
# +-------------------------------------
CREATE TABLE `tiposcambio` (
  `codcambio` int(11) NOT NULL AUTO_INCREMENT,
  `descripcioncambio` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montocambio` decimal(12,3) NOT NULL,
  `codmoneda` int(11) NOT NULL,
  `fechacambio` date NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codcambio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'tiposcambio'
# +-------------------------------------

# | Vaciado de tabla 'tiposmoneda'
# +-------------------------------------
DROP TABLE IF EXISTS `tiposmoneda`;


# | Estructura de la tabla 'tiposmoneda'
# +-------------------------------------
CREATE TABLE `tiposmoneda` (
  `codmoneda` int(11) NOT NULL AUTO_INCREMENT,
  `moneda` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `siglas` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `simbolo` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`codmoneda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'tiposmoneda'
# +-------------------------------------

# | Vaciado de tabla 'traspasos'
# +-------------------------------------
DROP TABLE IF EXISTS `traspasos`;


# | Estructura de la tabla 'traspasos'
# +-------------------------------------
CREATE TABLE `traspasos` (
  `idtraspaso` int(11) NOT NULL AUTO_INCREMENT,
  `codtraspaso` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codfactura` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `numero_tracking` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombres_responsable` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `sucursal_envia` int(11) NOT NULL,
  `sucursal_recibe` int(11) NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `totalpago2` decimal(12,2) NOT NULL,
  `fechatraspaso` datetime NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `estado_traspaso` int(2) NOT NULL,
  `fecha_enviado` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `persona_recibe` int(11) NOT NULL,
  `fecha_recibe` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `observaciones_recibido` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `agregar_stock` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idtraspaso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'traspasos'
# +-------------------------------------

# | Vaciado de tabla 'usuarios'
# +-------------------------------------
DROP TABLE IF EXISTS `usuarios`;


# | Estructura de la tabla 'usuarios'
# +-------------------------------------
CREATE TABLE `usuarios` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `sexo` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nivel` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status` int(2) NOT NULL,
  `comision` decimal(12,2) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'usuarios'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `usuarios` (`codigo`, `dni`, `nombres`, `sexo`, `direccion`, `telefono`, `email`, `usuario`, `password`, `nivel`, `status`, `comision`, `codsucursal`) VALUES 
      ('1', '123456789', 'ADMINISTRADOR GENERAL', 'MASCULINO', 'OOOOOOOOOOOOOOO', ' 9999999', 'ADMIN@GMAIL.COM', 'ADMINGENERAL', '$2y$10$wzG2HWJu.PGk0pWbEpdLbOS3Vn5TbrPjFwDdtyjMYnwv4epkEI0OC', 'ADMINISTRADOR(A) GENERAL', '1', '0.00', '0');
COMMIT;

# | Vaciado de tabla 'ventas'
# +-------------------------------------
DROP TABLE IF EXISTS `ventas`;


# | Estructura de la tabla 'ventas'
# +-------------------------------------
CREATE TABLE `ventas` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `tipodocumento` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codarqueo` int(11) NOT NULL,
  `codcaja` int(11) NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codfactura` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codserie` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codautorizacion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `totalpago2` decimal(12,2) NOT NULL,
  `creditopagado` decimal(12,2) NOT NULL,
  `tipopago` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `formapago` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montopagado` decimal(12,2) NOT NULL,
  `montodevuelto` decimal(12,2) NOT NULL,
  `fechavencecredito` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechapagado` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `statusventa` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaventa` datetime NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `notacredito` int(2) NOT NULL,
  `codigo` int(11) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  PRIMARY KEY (`idventa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
# | Carga de datos de la tabla 'ventas'
# +-------------------------------------


