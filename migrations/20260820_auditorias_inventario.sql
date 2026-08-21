-- Migración para el Módulo de Auditoría Diaria de Productos
-- Fecha: 2026-08-20

CREATE TABLE IF NOT EXISTS `auditorias_inventario` (
  `idauditoria` INT(11) NOT NULL AUTO_INCREMENT,
  `codsucursal` INT(11) NOT NULL,
  `fechadesde` DATETIME NOT NULL,
  `fechahasta` DATETIME NOT NULL,
  `fecharegistro` DATETIME NOT NULL,
  `codusuario` INT(11) NOT NULL,
  `total_productos` INT(11) NOT NULL DEFAULT 0,
  `total_faltantes` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `total_sobrantes` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `monto_faltante` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `observaciones` TEXT NULL,
  PRIMARY KEY (`idauditoria`),
  KEY `idx_auditoria_sucursal` (`codsucursal`),
  KEY `idx_auditoria_fechas` (`fechadesde`, `fechahasta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `detalle_auditorias` (
  `iddetalleauditoria` INT(11) NOT NULL AUTO_INCREMENT,
  `idauditoria` INT(11) NOT NULL,
  `idproducto` INT(11) NOT NULL,
  `codproducto` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` TEXT CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `inicial_cuaderno` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `entradas_compras` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `entradas_traspasos` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `salidas_ventas` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `salidas_traspasos` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `stock_teorico` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `fisico_final` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `diferencia` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `preciocompra` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `precioventa` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `valordiferencia` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`iddetalleauditoria`),
  KEY `idx_detalle_auditoria` (`idauditoria`),
  KEY `idx_detalle_producto` (`idproducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
