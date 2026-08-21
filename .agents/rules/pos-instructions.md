# POS - Reglas y Convenciones del Proyecto

## Stack Tecnológico
- **Backend**: PHP plano (sin framework), MySQL mediante PDO.
- **Frontend**: jQuery, Bootstrap 4, DataTables, SweetAlert.
- **Reportes**: FPDF para PDF; reportes Excel/Word generados desde HTML plano.
- **Email**: PHPMailer incluido manualmente en `class/PHPMailer/`.
- **Autenticación**: Sesiones PHP con control de acceso por roles (`administradorG`, `administradorS`, `secretaria`, `cajero`, `vendedor`).

## Arquitectura
- Cada pantalla es un archivo PHP en la raíz (`*.php`).
- La clase principal es `Login` en `class/class.php`, que hereda de `Db` en `class/classconexion.php`.
- Toda página autenticada inicia con `require_once("class/class.php")` y verifica `$_SESSION['acceso']`.
- Las operaciones CRUD se despachan por POST con el campo `proceso` (`save`, `update`, `agregar`, `procesar`, `eliminar`, etc.).
- Los métodos de negocio viven dentro de la clase `Login` en `class/class.php`.
- Endpoints auxiliares para AJAX/JSON residen en `funciones.php` y `class/class.consultas.php`.

## Convenciones de Código
- **Idioma**: español para nombres de archivos, tablas, campos, variables y textos visibles.
- **Mayúsculas** para valores enumerados y textos de UI: `NATURAL`, `JURIDICO`, `CONTADO`, `CREDITO`, `INGRESO`, `EGRESO`, `PAGADO`, `PENDIENTE`, `ANULADO`.
- IDs sensibles se encriptan con `encrypt()` y se desencriptan con `decrypt()` al recibirlos por URL o formularios.
- Función de sanitización: `limpiar()` definida en `class/funciones_basicas.php`.
- **Zona horaria fija**: `America/Caracas`; locale `es_VE`.

## Patrones Críticos de Estabilidad y Escalabilidad
1. **Análisis de Impacto Cruzado**: Antes de modificar cualquier método en `class/class.php`, `funciones.php` o `consultas.php`, verificar con `grep_search` todas las llamadas en el proyecto para evitar romper pantallas dependientes.
2. **Transacciones PDO Obligatorias**: Para operaciones con cabecera-detalle o múltiples tablas (ventas, compras, traspasos, arqueos, abonos), usar siempre transacciones con `try/catch`:
   ```php
   try {
       $this->dbh->beginTransaction();
       // ... operaciones SQL ...
       $this->dbh->commit();
   } catch (Exception $e) {
       $this->dbh->rollBack();
       error_log("Error en transacción: " . $e->getMessage());
       return false;
   }
   ```
3. **Prepared Statements**: NUNCA concatenar variables de usuario directamente en SQL.
4. **Migraciones de Base de Datos**: Documentar y guardar siempre el script SQL (`CREATE TABLE` o `ALTER TABLE`) en `migrations/` o `bd-sql/`.
5. **No Frameworks Externos**: No introducir Laravel, Symfony, React, Vue ni Composer.
