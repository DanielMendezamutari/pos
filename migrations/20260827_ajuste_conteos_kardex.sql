-- Migración para el soporte de Ajustes y Cuadre de Inventario desde Conteos Iniciales Diarios
-- Fecha: 2026-08-27

-- 1. Añadir columnas de estado de ajuste a detalle_conteo_inicial
ALTER TABLE `detalle_conteo_inicial` 
ADD COLUMN IF NOT EXISTS `ajustado` TINYINT(1) NOT NULL DEFAULT 0 AFTER `cantidad_fisica`,
ADD COLUMN IF NOT EXISTS `fecha_ajuste` DATETIME NULL AFTER `ajustado`,
ADD COLUMN IF NOT EXISTS `motivo_ajuste` TEXT NULL AFTER `fecha_ajuste`,
ADD COLUMN IF NOT EXISTS `usuario_ajuste` VARCHAR(100) NULL AFTER `motivo_ajuste`;

-- 2. Índice para consultas rápidas de estado de ajuste
CREATE INDEX IF NOT EXISTS `idx_detalle_ajustado` ON `detalle_conteo_inicial` (`ajustado`);
