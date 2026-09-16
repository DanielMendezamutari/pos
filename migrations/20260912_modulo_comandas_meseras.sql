-- Migración: Módulo de Comandas Móviles y Meseras para Joker Billar & Bar
-- Fecha: 2026-09-12
-- Autor: Ing. Daniel Méndez Amutari

-- 1. Actualizar tabla mesasbillar si ya existe
CREATE TABLE IF NOT EXISTS `mesasbillar` (
  `codmesa` int(11) NOT NULL AUTO_INCREMENT,
  `nromesa` varchar(50) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `horainicio` varchar(25) DEFAULT NULL,
  `codventa` varchar(30) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`codmesa`),
  KEY `idx_mesas_sucursal` (`codsucursal`, `estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Modificar tipo de nromesa a varchar(50)
ALTER TABLE `mesasbillar` MODIFY COLUMN `nromesa` VARCHAR(50) NOT NULL;

-- Agregar columna orden si no existe
ALTER TABLE `mesasbillar` ADD COLUMN IF NOT EXISTS `orden` INT(11) NOT NULL DEFAULT 0;


-- Insertar mesas iniciales para las 4 sucursales si está vacía
INSERT INTO `mesasbillar` (`nromesa`, `codsucursal`, `estado`)
SELECT * FROM (
    -- Sucursal 1 (Mega)
    SELECT 'Mesa 1' as nromesa, 1 as codsucursal, 1 as estado UNION ALL
    SELECT 'Mesa 2', 1, 1 UNION ALL
    SELECT 'Mesa 3', 1, 1 UNION ALL
    SELECT 'Mesa 4', 1, 1 UNION ALL
    SELECT 'Mesa 5', 1, 1 UNION ALL
    SELECT 'Mesa 6', 1, 1 UNION ALL
    SELECT 'Barra', 1, 1 UNION ALL
    -- Sucursal 2 (Central)
    SELECT 'Mesa 1', 2, 1 UNION ALL
    SELECT 'Mesa 2', 2, 1 UNION ALL
    SELECT 'Mesa 3', 2, 1 UNION ALL
    SELECT 'Barra', 2, 1 UNION ALL
    -- Sucursal 3 (Ultra)
    SELECT 'Mesa 1', 3, 1 UNION ALL
    SELECT 'Mesa 2', 3, 1 UNION ALL
    SELECT 'Mesa 3', 3, 1 UNION ALL
    SELECT 'Mesa 4', 3, 1 UNION ALL
    SELECT 'Mesa 5', 3, 1 UNION ALL
    SELECT 'Mesa 6', 3, 1 UNION ALL
    SELECT 'Mesa 7', 3, 1 UNION ALL
    SELECT 'Mesa 8', 3, 1 UNION ALL
    SELECT 'Barra', 3, 1 UNION ALL
    -- Sucursal 4 (Express)
    SELECT 'Mesa 1', 4, 1 UNION ALL
    SELECT 'Mesa 2', 4, 1 UNION ALL
    SELECT 'Mesa 3', 4, 1 UNION ALL
    SELECT 'Barra', 4, 1
) AS tmp
WHERE NOT EXISTS (SELECT 1 FROM `mesasbillar` LIMIT 1);

-- 2. Tabla para Meseras del Turno y sus PINs
CREATE TABLE IF NOT EXISTS `meseras_turno` (
  `idmesera` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `pin` varchar(10) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecharegistro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idmesera`),
  KEY `idx_meseras_sucursal` (`codsucursal`, `estado`, `pin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertar meseras de prueba iniciales
INSERT INTO `meseras_turno` (`nombre`, `pin`, `codsucursal`, `estado`)
SELECT * FROM (
    SELECT 'Yessica' as nombre, '1234' as pin, 3 as codsucursal, 1 as estado UNION ALL
    SELECT 'María', '4321', 3, 1 UNION ALL
    SELECT 'Mesera Mega', '1111', 1, 1 UNION ALL
    SELECT 'Mesera Central', '2222', 2, 1 UNION ALL
    SELECT 'Mesera Express', '3333', 4, 1
) AS tmp_m
WHERE NOT EXISTS (SELECT 1 FROM `meseras_turno` LIMIT 1);

-- 3. Tabla para Comandas Móviles emitidas por las Meseras
CREATE TABLE IF NOT EXISTS `comandas_meseras` (
  `idcomanda` int(11) NOT NULL AUTO_INCREMENT,
  `idmesera` int(11) NOT NULL,
  `nombre_mesera` varchar(100) NOT NULL,
  `codmesa` int(11) NOT NULL,
  `nombre_mesa` varchar(50) NOT NULL,
  `codsucursal` int(11) NOT NULL,
  `codarqueo` int(11) NOT NULL,
  `items_json` longtext NOT NULL,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `estado` enum('PENDIENTE','COBRADA','CANCELADA') NOT NULL DEFAULT 'PENDIENTE',
  `codventa` varchar(30) DEFAULT NULL,
  `fechahora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechacobro` datetime DEFAULT NULL,
  PRIMARY KEY (`idcomanda`),
  KEY `idx_comandas_arqueo` (`codarqueo`, `estado`),
  KEY `idx_comandas_mesera` (`idmesera`, `codarqueo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
