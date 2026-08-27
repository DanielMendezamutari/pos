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

#### 4.2 Arquitectura y Principios SOLID en Clases PHP
Al implementar nueva lógica, aplica los **Principios SOLID** adaptados al entorno PHP del proyecto para garantizar código escalable y mantenible:

- **S - Responsabilidad Única (Single Responsibility Principle):**
  - **No sobrecargar clases existentes**: En lugar de seguir agregando todos los métodos a la clase monolítica `Login` en `class.php`, crea clases de dominio dedicadas (ej. `class/class.<modulo>.php` o clases con propósito único como `VentaService`, `InventarioRepository`, `FacturacionHelper`).
  - Cada método debe resolver una sola tarea (validar, calcular o persistir).
- **O - Abierto / Cerrado (Open/Closed Principle):**
  - Diseña componentes que puedan extenderse sin modificar el código base probado (ej. soporte para nuevos tipos de pago, nuevos comprobantes o formatos de exportación mediante estrategias o controladores independientes).
- **L - Sustitución de Liskov (Liskov Substitution Principle):**
  - Si creas clases hijas o implementaciones alternativas, asegura que cumplan estrictamente los contratos, tipos de parámetros y tipos de retorno esperados sin alterar el comportamiento del llamador.
- **I - Segregación de Interfaces (Interface Segregation Principle):**
  - Evita clases o interfaces sobrecargadas con métodos innecesarios para el consumidor. Define contratos o clases base pequeñas y especializadas.
- **D - Inversión de Dependencias (Dependency Inversion Principle):**
  - Desacopla la lógica de negocio recibiendo dependencias necesarias (como la conexión PDO `$dbh` o configuraciones) en lugar de instanciarlas rígidamente dentro de cada método o depender ciegamente del estado global.

##### Ejemplo de Implementación Modular con Transacciones PDO:
```php
class ModuloService {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function registrar($datos) {
        if (empty($datos["campo_obligatorio"])) {
            return ["status" => 1, "mensaje" => "Campo obligatorio vacío"];
        }

        try {
            $this->dbh->beginTransaction();

            $sql = "INSERT INTO tabla (campo1, campo2) VALUES (?, ?)";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([limpiar($datos["campo1"]), limpiar($datos["campo2"])]);

            // Inserciones de detalle o actualizaciones relacionadas...

            $this->dbh->commit();
            return ["status" => 2, "mensaje" => "Registrado exitosamente"];
        } catch (Exception $e) {
            $this->dbh->rollBack();
            error_log("Error en ModuloService::registrar: " . $e->getMessage());
            return ["status" => 3, "mensaje" => "Error interno al registrar"];
        }
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
- Respeto estricto a los principios SOLID (evitar acoplamiento y clases dios).

### 6. Validar
- Revisa sintaxis PHP con `php -l archivo.php`.
- Ejecuta o provee el script de migración SQL.
- Verifica el menú y prueba el flujo integral en navegador.

## Checklist final

- [ ] Requerimiento y reglas de negocio clarificadas.
- [ ] Principios SOLID evaluados (responsabilidad única, clases/servicios desacoplados).
- [ ] Script SQL de migración creado en `migrations/` o `bd-sql/` si hubo cambios en BD.
- [ ] Página creada en raíz con control de sesión y roles.
- [ ] Métodos con transacciones PDO (`try/catch`) y consultas preparadas.
- [ ] Validaciones de reglas de negocio antes de persistir.
- [ ] Script JS creado o actualizado con SweetAlert.
- [ ] Menú actualizado con restricción de roles.
- [ ] Reportes PDF/Excel añadidos si aplica.
- [ ] IDs encriptados/desencriptados (`encrypt`/`decrypt`).
- [ ] Sintaxis verificada con `php -l`.
