-- MIGRACION 001: Soporte para sucursales de billar y productos tipo servicio/alquiler
-- Fecha: 2026-08-13

-- Indica si una sucursal es de billar (SI/NO)
ALTER TABLE sucursales ADD COLUMN esbillar VARCHAR(2) NOT NULL DEFAULT 'NO' AFTER estado;

-- Tipo de producto: PRODUCTO, SERVICIO, ALQUILER
ALTER TABLE productos ADD COLUMN tipoproducto VARCHAR(20) NOT NULL DEFAULT 'PRODUCTO' AFTER condicion;

-- Precio por hora para productos tipo SERVICIO (mesas de billar)
ALTER TABLE productos ADD COLUMN preciohora DECIMAL(12,2) NOT NULL DEFAULT '0.00' AFTER precioxpublico;

-- Tabla para control de mesas de billar en el POS
CREATE TABLE IF NOT EXISTS mesasbillar (
  codmesa int(11) NOT NULL AUTO_INCREMENT,
  nromesa varchar(10) NOT NULL,
  codsucursal int(11) NOT NULL,
  estado int(2) NOT NULL DEFAULT 1,
  horainicio datetime DEFAULT NULL,
  codventa varchar(30) DEFAULT NULL,
  PRIMARY KEY (codmesa),
  KEY codsucursal (codsucursal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabla de registro de migraciones ejecutadas
CREATE TABLE IF NOT EXISTS migraciones_ejecutadas (
  id int(11) NOT NULL AUTO_INCREMENT,
  archivo varchar(100) NOT NULL,
  fecha datetime NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY archivo (archivo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
