-- Migración para Registro de Inventario Inicial Diario por Cajeros
-- Fecha: 2026-08-20

CREATE TABLE IF NOT EXISTS `conteo_inicial_diario` (
  `idconteo` INT(11) NOT NULL AUTO_INCREMENT,
  `codsucursal` INT(11) NOT NULL,
  `codusuario` INT(11) NOT NULL,
  `fechaconteo` DATETIME NOT NULL,
  `total_productos` INT(11) NOT NULL DEFAULT 0,
  `observaciones` TEXT NULL,
  PRIMARY KEY (`idconteo`),
  KEY `idx_conteo_sucursal` (`codsucursal`),
  KEY `idx_conteo_fecha` (`fechaconteo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `detalle_conteo_inicial` (
  `iddetalleconteo` INT(11) NOT NULL AUTO_INCREMENT,
  `idconteo` INT(11) NOT NULL,
  `idproducto` INT(11) NOT NULL,
  `codproducto` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` TEXT CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad_fisica` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`iddetalleconteo`),
  KEY `idx_detalle_conteo` (`idconteo`),
  KEY `idx_detalle_producto` (`idproducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
