-- Migración: Modo Entrenamiento / Pruebas para Cajeros y Arqueos
-- Permite marcar arqueos y ventas como sesiones de práctica sin alterar stock ni contabilidad real.

ALTER TABLE `arqueocaja` 
ADD COLUMN IF NOT EXISTS `es_entrenamiento` TINYINT(1) NOT NULL DEFAULT 0 
COMMENT '0=Turno Operativo Real, 1=Sesión de Prueba/Capacitación' 
AFTER `statusarqueo`;

ALTER TABLE `ventas` 
ADD COLUMN IF NOT EXISTS `es_entrenamiento` TINYINT(1) NOT NULL DEFAULT 0 
COMMENT '0=Venta Real, 1=Venta de Prueba/Entrenamiento' 
AFTER `statusventa`;
