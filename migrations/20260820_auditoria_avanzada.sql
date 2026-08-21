-- Migración para Auditoría Avanzada con Imputación de Responsables y Acciones de Faltantes
-- Fecha: 2026-08-20

ALTER TABLE `detalle_auditorias` 
ADD COLUMN IF NOT EXISTS `accion_diferencia` VARCHAR(50) NOT NULL DEFAULT 'NINGUNA' AFTER `valordiferencia`,
ADD COLUMN IF NOT EXISTS `responsable_diferencia` VARCHAR(255) NULL AFTER `accion_diferencia`,
ADD COLUMN IF NOT EXISTS `motivo_diferencia` TEXT NULL AFTER `responsable_diferencia`;
