# Configuración de Agentes para Antigravity en el Sistema POS

Este repositorio cuenta con dos flujos principales especializados para su desarrollo y mantenimiento:

## Skills Disponibles

1. **`pos-arreglos`** (`.agents/skills/pos-arreglos/SKILL.md`):
   - Especialista en diagnóstico y solución de bugs sin efectos secundarios.
   - Aplica análisis de impacto cruzado (búsqueda de métodos compartidos en `class.php` antes de modificar).
   - Valida transaccionalidad e integridad en BD.

2. **`pos-nuevas-funciones`** (`.agents/skills/pos-nuevas-funciones/SKILL.md`):
   - Especialista en crear nuevos módulos, pantallas, carritos, CRUDs y procesos de negocio.
   - Implementa transacciones PDO (`beginTransaction`, `commit`, `rollBack`) y manejo `try/catch`.
   - Genera scripts de migración SQL en `migrations/` o `bd-sql/`.
   - Adapta el patrón visual Bootstrap 4 y la arquitectura nativa del proyecto.
