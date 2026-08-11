---
name: pos-nuevas-funciones
description: "Guía paso a paso para implementar nuevas funciones en el POS PHP. Úsala cuando necesites crear un nuevo módulo, pantalla, reporte, carrito o flujo de negocio en el sistema."
argument-hint: "¿Qué nueva función necesitas? Indica nombre, roles involucrados y si requiere reportes."
user-invocable: true
---

# POS - Nuevas Funciones

Este skill te guía para agregar módulos, pantallas, reportes o flujos de negocio nuevos al sistema POS en PHP, respetando su arquitectura y convenciones.

## Cuándo usar este skill

- El usuario pide una pantalla nueva (CRUD, consulta, dashboard).
- Hay que agregar un reporte PDF, Excel o Word.
- Se requiere un nuevo carrito de operaciones (venta, compra, traspaso, etc.).
- Se necesita un nuevo proceso de negocio (aprobaciones, estados, etc.).

## Procedimiento recomendado

### 1. Entender el requerimiento
Pregunta o confirma:
- Nombre del módulo en español.
- Roles que pueden usarlo (`administradorG`, `administradorS`, `secretaria`, `cajero`, `vendedor`).
- ¿Necesita alta/baja/modificación o solo consulta?
- ¿Requiere reporte PDF, Excel o Word?
- ¿Depende de tablas o módulos existentes?

### 2. Encontrar el patrón más parecido
Busca en la raíz del proyecto un archivo similar:
- CRUD simple → `clientes.php`, `proveedores.php`, `bancos.php`, `impuestos.php`.
- CRUD con detalle o carrito → `forventa.php`, `forcompra.php`, `fortraspaso.php`.
- Consulta con filtros → `ventasxfechas.php`, `comprasxproveedor.php`.
- Reporte → `reportepdf.php`, `reporteexcel.php`.

Usa ese archivo como plantilla. Copia la estructura y adapta los nombres.

### 3. Crear o modificar archivos

#### 3.1 Página principal (`<modulo>.php`)
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
- Usar `card-header bg-danger` y clases Bootstrap del proyecto.

#### 3.2 Métodos en `class/class.php`
- Añade métodos dentro de la clase `Login`.
- Usa `self::SetNames()` al inicio si trabajas con texto.
- Para listar:
  ```php
  public function ListarNuevoModulo() {
      self::SetNames();
      $sql = "SELECT * FROM tabla WHERE condicion = ?";
      $stmt = $this->dbh->prepare($sql);
      $stmt->execute(array($valor));
      $num = $stmt->rowCount();
      if($num == 0) {
          echo "";
      } else {
          while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $data[] = $row;
          }
          return $data;
      }
  }
  ```
- Para insertar/actualizar, sanitiza con `limpiar()` y usa `prepare/execute`.

#### 3.3 Script JS (si hay interacción dinámica)
- Si es similar a ventas, crea `assets/script/js<modulo>.js`.
- Inclúyelo en la página o en `detalles_productos.php` si es un detalle modal.
- Reutiliza funciones como `addItem`, `DoAction`, etc., adaptando nombres.

#### 3.4 Menú (`menu.php`)
- Agrega el enlace dentro del bloque correspondiente al rol.
- Ejemplo:
  ```php
  <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") { ?>
  <li><a href="nuevomodulo"><i class="fa fa-circle"></i> Nuevo Módulo</a></li>
  <?php } ?>
  ```

#### 3.5 Reportes (si aplica)
- Para PDF: añade un caso en `reportepdf.php` y una función `TablaListarNuevoModulo()` en `fpdf/pdf.php`.
- Para Excel/Word: añade un caso en `reporteexcel.php` con HTML de tabla.

### 4. Revisar permisos y seguridad
- La página solo debe ser accesible para los roles indicados.
- Los IDs en URLs/forms deben usar `encrypt()` y `decrypt()`.
- Las consultas deben usar *prepared statements*.

### 5. Validar
- Revisa que no haya errores de sintaxis con `php -l archivo.php`.
- Prueba el flujo en navegador.
- Verifica que el menú muestre la opción correctamente.

## Checklist final

- [ ] Página creada en raíz con control de sesión y permisos.
- [ ] Métodos CRUD añadidos a `class/class.php`.
- [ ] Script JS creado o reutilizado si aplica.
- [ ] Menú actualizado con restricción de rol.
- [ ] Reportes PDF/Excel/Word añadidos si aplica.
- [ ] IDs encriptados/desencriptados correctamente.
- [ ] Consultas con *prepared statements*.
- [ ] Textos y nombres de archivo en español.
