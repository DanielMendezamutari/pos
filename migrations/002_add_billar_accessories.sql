-- MIGRACION 002: Accesorios de billar (guantes, tacos, tiza, etc.)
-- Fecha: 2026-08-13

-- Indica si un producto es accesorio de billar para alquiler/venta rapida en POS
ALTER TABLE productos ADD COLUMN esaccesoriobillar VARCHAR(2) NOT NULL DEFAULT 'NO' AFTER preciohora;
