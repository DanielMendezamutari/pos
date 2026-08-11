# POS - Instrucciones Generales del Proyecto

## Stack Tecnológico
- **Backend**: PHP plano (sin framework), MySQL mediante PDO.
- **Frontend**: jQuery, Bootstrap 4, DataTables, SweetAlert.
- **Reportes**: FPDF para PDF; reportes Excel/Word generados desde HTML plano.
- **Email**: PHPMailer incluido manualmente en `class/PHPMailer/`.
- **Autenticación**: sesiones PHP con control de acceso por roles.

## Arquitectura
- Cada pantalla es un archivo PHP en la raíz (`*.php`).
- La clase principal es `Login` en `class/class.php`, que hereda de `Db` en `class/classconexion.php`.
- Toda página autenticada inicia con `require_once("class/class.php")` y verifica `$_SESSION['acceso']`.
- Las operaciones CRUD se despachan por POST con el campo `proceso` (`save`, `update`, `agregar`, `procesar`, etc.).
- Los métodos de negocio viven dentro de la clase `Login` en `class/class.php`.

## Convenciones de Código
- **Idioma**: español para nombres de archivos, tablas, campos, variables y textos visibles.
- **Mayúsculas** para valores enumerados y textos de UI: `NATURAL`, `JURIDICO`, `CONTADO`, `CREDITO`, `INGRESO`, `EGRESO`.
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
  $stmt = $this->dbh->prepare("...");
  $stmt->execute(array(...));
  ```
- Plantilla HTML común: preloader, `main-wrapper`, inclusión de `menu.php`, `page-wrapper`, `container-fluid`.
- Botones de acción: `btn btn-danger`, `btn btn-light`, `btn btn-success`.
- Encabezados de tarjetas: `card-header bg-danger` con ícono `fa fa-tasks`.

## Seguridad y Calidad
- NUNCA concatenar variables de usuario directamente en SQL.
- NUNCA confiar ciegamente en `$_GET`/`$_POST`; pasar por `limpiar()` y *prepared statements*.
- Manejar el caso de registros vacíos (`if($reg==""){ ... }`).
- Respetar permisos de rol; no exponer funciones administrativas a cajeros/vendedores.
- No introducir frameworks modernos (Laravel, Symfony, React, Vue) ni Composer.

## Estructura de Archivos Relevante
- `class/class.php`: lógica de negocio y CRUD.
- `class/classconexion.php`: conexión PDO a la base de datos `pos`.
- `class/class.consultas.php`: consultas para autocompletado y búsquedas JSON.
- `funciones.php`: endpoints parciales/ajax para búsquedas y listados.
- `menu.php`: menú lateral y topbar.
- `reportepdf.php` / `reporteexcel.php`: generación de reportes.
- `assets/script/*.js`: lógica JS por módulo (`jspos.js`, `jsventas.js`, etc.).
