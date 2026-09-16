-- Migración para soporte de método de pago en comandas de meseras
ALTER TABLE `comandas_meseras` ADD COLUMN `metodo_pago` VARCHAR(20) NOT NULL DEFAULT 'EFECTIVO' AFTER `total`;
