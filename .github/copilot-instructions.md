# POS - Instrucciones Generales del Proyecto

## Stack Tecnológico
- **Backend**: PHP plano (sin framework), MySQL mediante PDO.
- **Frontend**: jQuery, Bootstrap 4, DataTables, SweetAlert.
- **Reportes**: FPDF para PDF; reportes Excel/Word generados desde HTML plano.
- **Email**: PHPMailer incluido manualmente en `class/PHPMailer/`.
- **Autenticación**: sesiones PHP con control de acceso por roles (`administradorG`, `administradorS`, `secretaria`, `cajero`, `vendedor`).

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

## Patrones a Mantener
- Control de permisos al inicio de cada página según el rol:
  ```php
  if ($_SESSION["acceso"]=="administradorG" || $_SESSION["acceso"]=="administradorS" || ...) { ... }
  ```
- Uso de *prepared statements* con PDO en `class/class.php`:
  ```php
  $stmt = $this->dbh->prepare("SELECT * FROM tabla WHERE campo = ?");
  $stmt->execute(array($valor));
  ```
- **Transacciones PDO Obligatorias**: Para operaciones con cabecera-detalle o múltiples tablas (ventas, compras, traspasos, arqueos, abonos), usar siempre transacciones con `try/catch`:
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
- Plantilla HTML común: preloader, `main-wrapper`, inclusión de `menu.php`, `page-wrapper`, `container-fluid`.
- Botones de acción: `btn btn-danger`, `btn btn-light`, `btn btn-success`, `btn btn-info`.
- Encabezados de tarjetas: `card-header bg-danger` con ícono representativo (ej: `fa fa-tasks`).

## Seguridad, Calidad y Escalabilidad
- **Análisis de Impacto Cruzado**: Antes de modificar cualquier método existente en `class/class.php`, `funciones.php` o `consultas.php`, verificar todos los archivos que lo invocan para no romper pantallas dependientes.
- **Transaccionalidad e Integridad**: Nunca realizar operaciones compuestas de inventario o caja sin transacciones PDO.
- **Migraciones de Base de Datos**: Si un cambio requiere nuevas tablas, columnas o índices, documentar y guardar el script SQL en la carpeta `migrations/` o `bd-sql/`.
- **Sanitización y Validación**: NUNCA concatenar variables de usuario directamente en SQL. Sanitizar con `limpiar()` y validar reglas de negocio (estados, stock, cajas abiertas) antes de persistir.
- **Manejo de registros vacíos**: Manejar siempre casos donde no existan registros (`if($reg==""){ ... }`).
- **Control de Roles Estricto**: Respetar permisos de rol; no exponer funciones administrativas a cajeros/vendedores.
- **No Frameworks Externos**: No introducir frameworks modernos (Laravel, Symfony, React, Vue) ni Composer para mantener la coherencia del sistema existente.

## Estructura de Archivos Relevante
- `class/class.php`: lógica central de negocio y métodos CRUD.
- `class/classconexion.php`: conexión PDO a la base de datos `pos`.
- `class/class.consultas.php`: consultas para autocompletado y búsquedas JSON.
- `funciones.php`: endpoints parciales/ajax para búsquedas y listados.
- `menu.php`: menú lateral y topbar con filtrado por rol.
- `reportepdf.php` / `reporteexcel.php`: generación y descarga de reportes.
- `assets/script/*.js`: lógica frontend en JS/jQuery por módulo (`jspos.js`, `jsventas.js`, etc.).
- `migrations/` / `bd-sql/`: scripts de base de datos y migraciones.
