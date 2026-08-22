-- Migración para Módulo de Retiros y Bajas de Mercadería (Consumo Interno / Retiro de Dueña / Mermas)
CREATE TABLE IF NOT EXISTS `bajas_inventario` (
  `idbaja` INT(11) NOT NULL AUTO_INCREMENT,
  `codbaja` VARCHAR(30) NOT NULL,
  `codsucursal` INT(11) NOT NULL,
  `codusuario` INT(11) NOT NULL,
  `fechabaja` DATETIME NOT NULL,
  `tipomotivo` VARCHAR(50) NOT NULL COMMENT 'RETIRO_DUENA, CONSUMO_INTERNO, MERMA, VENCIDO, DEGUSTACION, OTRO',
  `persona_autoriza` VARCHAR(150) NOT NULL,
  `total_items` INT(11) NOT NULL DEFAULT 0,
  `total_costo` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `observaciones` TEXT NULL,
  `statusbaja` VARCHAR(20) NOT NULL DEFAULT 'PROCESADA' COMMENT 'PROCESADA, ANULADA',
  PRIMARY KEY (`idbaja`),
  UNIQUE KEY `idx_codbaja` (`codbaja`),
  KEY `idx_baja_sucursal` (`codsucursal`),
  KEY `idx_baja_fecha` (`fechabaja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `detalle_bajas_inventario` (
  `iddetallebaja` INT(11) NOT NULL AUTO_INCREMENT,
  `idbaja` INT(11) NOT NULL,
  `codbaja` VARCHAR(30) NOT NULL,
  `idproducto` INT(11) NOT NULL,
  `codproducto` VARCHAR(50) NOT NULL,
  `producto` VARCHAR(255) NOT NULL,
  `cantidad` DECIMAL(12,2) NOT NULL,
  `preciocompra` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `precioxpublico` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `subtotal_costo` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`iddetallebaja`),
  KEY `idx_detbaja_idbaja` (`idbaja`),
  KEY `idx_detbaja_producto` (`idproducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
