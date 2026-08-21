---
name: pos-nuevas-funciones
description: "Guía paso a paso para implementar nuevas funciones, módulos y flujos en el POS PHP con lógica robusta y escalable. Úsala cuando necesites crear un nuevo módulo, pantalla, reporte, carrito o proceso de negocio."
argument-hint: "¿Qué nueva función necesitas? Indica nombre, roles involucrados y si requiere reportes o cambios en BD."
user-invocable: true
---

# POS - Nuevas Funciones

Este skill te guía para agregar módulos, pantallas, reportes o flujos de negocio nuevos al sistema POS en PHP, garantizando una implementación amplia, lógica sólida, integridad transaccional y respeto a las convenciones existentes.

## Cuándo usar este skill

- El usuario pide una pantalla o funcionalidad nueva (CRUD, consulta, dashboard).
- Hay que agregar un reporte PDF, Excel o Word.
- Se requiere un nuevo carrito de operaciones (venta, compra, traspaso, etc.).
- Se necesita un nuevo proceso o regla de negocio (garantías, comisiones, estados, etc.).

## Procedimiento recomendado

### 1. Entender el requerimiento y Reglas de Negocio
Pregunta o confirma:
- Nombre del módulo en español.
- Roles que pueden usarlo (`administradorG`, `administradorS`, `secretaria`, `cajero`, `vendedor`).
- Reglas de negocio críticas: validación de existencias, estado de cajas, estados de documentos (PENDIENTE, PAGADO, ANULADO), duplicidades.
- ¿Requiere reporte PDF, Excel o Word?
- ¿Requiere nuevas tablas o alterar tablas existentes?

### 2. Diseño de Base de Datos y Migración SQL (si aplica)
- Si se necesitan nuevas tablas o columnas, diseña respetando tipos de datos consistentes (`VARCHAR`, `INT`, `DECIMAL(12,2)` para dinero).
- **Crear siempre el script SQL** en la carpeta `migrations/` o `bd-sql/` (ej: `migrations/YYYYMMDD_nuevo_modulo.sql`) con el `CREATE TABLE` o `ALTER TABLE` correspondiente.

### 3. Encontrar el patrón más parecido
Busca en la raíz del proyecto un archivo similar:
- CRUD simple → `clientes.php`, `proveedores.php`, `bancos.php`, `impuestos.php`.
- CRUD con detalle o carrito → `forventa.php`, `forcompra.php`, `fortraspaso.php`.
- Consulta con filtros → `ventasxfechas.php`, `comprasxproveedor.php`.
- Reporte → `reportepdf.php`, `reporteexcel.php`.

Usa ese archivo como plantilla, adaptando nombres y flujos.

### 4. Crear o modificar archivos

#### 4.1 Página principal (`<modulo>.php`)
- Incluir `require_once("class/class.php")`.
- Verificar `$_SESSION['acceso']` con los roles permitidos.
- Llamar a `$tra->ExpiraSession()`.
- Despachar POST con campo `proceso`:
  ```php
  if(isset($_POST["proceso"]) and $_POST["proceso"]=="save") {
      $reg = $tra->RegistrarNuevoModulo();
      exit;
  }
  ```
- Mantener la estructura HTML común: preloader, `main-wrapper`, `menu.php`, `page-wrapper`, `container-fluid`.
- Usar `card-header bg-danger` y componentes Bootstrap 4 del proyecto.

#### 4.2 Métodos en `class/class.php` con Transaccionalidad
- Añade métodos dentro de la clase `Login`.
- Usa `self::SetNames()` al inicio si trabajas con texto.
- Para operaciones compuestas (cabecera-detalle, stock, caja), usa **Transacciones PDO**:
  ```php
  public function RegistrarNuevoModulo() {
      self::SetNames();
      if(empty($_POST["campo_obligatorio"])) {
          echo "1"; // o código de validación correspondiente
          exit;
      }
      try {
          $this->dbh->beginTransaction();
          
          $sql = "INSERT INTO tabla (campo1, campo2) VALUES (?, ?)";
          $stmt = $this->dbh->prepare($sql);
          $stmt->execute(array(limpiar($_POST["campo1"]), limpiar($_POST["campo2"])));
          
          // ... inserción de detalles / actualización de stock / movimientos ...
          
          $this->dbh->commit();
          echo "2"; // Éxito
      } catch (Exception $e) {
          $this->dbh->rollBack();
          error_log("Error en RegistrarNuevoModulo: " . $e->getMessage());
          echo "3"; // Error
      }
  }
  ```

#### 4.3 Script JS (`assets/script/js<modulo>.js`)
- Si hay interacción dinámica o modales, crea su archivo JS correspondiente.
- Maneja las alertas con SweetAlert y los eventos AJAX estandarizados.

#### 4.4 Menú (`menu.php`)
- Agrega el enlace dentro del bloque correspondiente al rol:
  ```php
  <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") { ?>
  <li><a href="nuevomodulo"><i class="fa fa-circle"></i> Nuevo Módulo</a></li>
  <?php } ?>
  ```

#### 4.5 Reportes (si aplica)
- Para PDF: añade el `case` en `reportepdf.php` y la función de tabla en `fpdf/pdf.php`.
- Para Excel/Word: añade el `case` en `reporteexcel.php`.

### 5. Revisar Permisos, Seguridad y Escalabilidad
- Página solo accesible para roles indicados.
- IDs encriptados en URL/formulario con `encrypt()` y desencriptados con `decrypt()`.
- Consultas PDO con *prepared statements* y sanitización con `limpiar()`.

### 6. Validar
- Revisa sintaxis PHP con `php -l archivo.php`.
- Ejecuta o provee el script de migración SQL.
- Verifica el menú y prueba el flujo integral en navegador.

## Checklist final

- [ ] Requerimiento y reglas de negocio clarificadas.
- [ ] Script SQL de migración creado en `migrations/` o `bd-sql/` si hubo cambios en BD.
- [ ] Página creada en raíz con control de sesión y roles.
- [ ] Métodos CRUD en `class/class.php` con transacciones PDO (`try/catch`).
- [ ] Validaciones de reglas de negocio antes de persistir.
- [ ] Script JS creado o actualizado con SweetAlert.
- [ ] Menú actualizado con restricción de roles.
- [ ] Reportes PDF/Excel añadidos si aplica.
- [ ] IDs encriptados/desencriptados (`encrypt`/`decrypt`).
- [ ] Sintaxis verificada con `php -l`.
