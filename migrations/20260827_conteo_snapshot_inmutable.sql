-- Migración: Snapshot Inmutable para Conteos Iniciales Diarios
-- Fecha: 2026-08-27
-- Objetivo: Congelar el stock del sistema y la diferencia al momento exacto del conteo para evitar falsos sobrantes/faltantes por ventas posteriores.

ALTER TABLE `detalle_conteo_inicial` 
ADD COLUMN IF NOT EXISTS `stock_sistema` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `cantidad_fisica`,
ADD COLUMN IF NOT EXISTS `diferencia` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `stock_sistema`;

-- Inicializar registros históricos existentes que tengan stock_sistema en 0
UPDATE `detalle_conteo_inicial` dci
INNER JOIN `conteo_inicial_diario` cid ON dci.idconteo = cid.idconteo
INNER JOIN `productos` p ON (dci.idproducto = p.idproducto AND p.codsucursal = cid.codsucursal)
SET dci.stock_sistema = p.existencia,
    dci.diferencia = (dci.cantidad_fisica - p.existencia)
WHERE dci.stock_sistema = 0.00 AND dci.diferencia = 0.00;
