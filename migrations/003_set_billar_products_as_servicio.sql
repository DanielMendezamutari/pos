-- MIGRACION 003: Productos de billar deben ser tratados como servicios
-- Fecha: 2026-08-14

-- Las mesas de billar y accesorios se reportan como VENTA DE SERVICIOS en cierre de caja
-- y no afectan existencias.
UPDATE productos SET tipoproducto = 'SERVICIO'
WHERE tipoproducto != 'SERVICIO'
AND (
    esaccesoriobillar = 'SI'
    OR preciohora > 0
    OR producto LIKE '%MESA BILLAR%'
    OR producto LIKE '%GUANTE BILLAR%'
);
