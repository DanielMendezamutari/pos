-- Migración: Inventario Inicial por Turno / Cajero al Ingresar (Relevo de Turnos)
-- Fecha: 2026-09-03
-- Objetivo: Permitir que cada cajero que entra a trabajar registre su propio inventario inicial al ingresar a su turno, asociándolo a su sesión de caja (arqueo).

ALTER TABLE `conteo_inicial_diario` 
ADD COLUMN IF NOT EXISTS `codarqueo` INT(11) NULL DEFAULT NULL AFTER `codusuario`,
ADD COLUMN IF NOT EXISTS `codcaja` INT(11) NULL DEFAULT NULL AFTER `codarqueo`,
ADD COLUMN IF NOT EXISTS `turno` VARCHAR(100) NULL DEFAULT NULL AFTER `codcaja`,
ADD KEY IF NOT EXISTS `idx_conteo_arqueo` (`codarqueo`),
ADD KEY IF NOT EXISTS `idx_conteo_caja` (`codcaja`);
