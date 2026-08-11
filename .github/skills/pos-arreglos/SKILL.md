---
name: pos-arreglos
description: "Guía para diagnosticar y corregir errores, bugs y problemas de calidad en el POS PHP. Úsala cuando algo no funcione bien, falle una pantalla, arroje un error o tenga comportamiento inesperado."
argument-hint: "¿Qué está fallando? Describe el síntoma, la pantalla y el mensaje de error si lo hay."
user-invocable: true
---

# POS - Corrección de Errores

Este skill te guía para diagnosticar y corregir problemas en el sistema POS PHP de forma segura y mínima.

## Cuándo usar este skill

- Una pantalla muestra un error PHP o MySQL.
- Un botón o formulario no responde como se espera.
- Un reporte no genera o muestra datos incorrectos.
- El usuario indica que "algo no está bien".
- Hay comportamientos extraños en sesiones, permisos o cálculos.

## Procedimiento recomendado

### 1. Recopilar información
Antes de tocar código, confirma:
- ¿Qué pantalla o archivo falla?
- ¿Cuál es el mensaje de error exacto?
- ¿Qué acción lo provoca? (hacer clic, enviar formulario, cargar página).
- ¿Es un error nuevo o empezó después de un cambio?
- ¿Aparece en consola del navegador? (F12 → Consola).

### 2. Localizar el archivo y método involucrado
- Busca el nombre de la pantalla en la raíz (`ventas.php`, `clientes.php`, etc.).
- Busca el método que maneja el proceso con `grep_search`:
  - `RegistrarVentas`, `ActualizarClientes`, `ListarProductos`, etc.
- Si el error menciona una línea de `class/class.php`, revisa ese método.

### 3. Diagnóstico por tipo de error

#### Error de conexión o base de datos
- Revisa `class/classconexion.php`: credenciales, nombre de base de datos.
- Verifica que el servidor MySQL esté corriendo.
- Confirma que la tabla/columna exista.

#### Error de sintaxis PHP
- Ejecuta `php -l archivo.php` para detectar errores de sintaxis.
- Revisa paréntesis, llaves, punto y coma y comillas.

#### Error de sesión o permisos
- Verifica que `session_start()` esté presente en `class/class.php`.
- Confirma que `$_SESSION['acceso']` se evalúe correctamente.
- Asegúrate de que el rol afectado esté incluido en la condición.

#### Error de SQL / inyección
- Busca concatenaciones de `$_GET`, `$_POST` o variables en cadenas SQL.
- Reemplaza por *prepared statements*:
  ```php
  $stmt = $this->dbh->prepare("SELECT * FROM tabla WHERE campo = ?");
  $stmt->execute(array(limpiar($valor)));
  ```

#### Error en JavaScript / frontend
- Abre la consola del navegador (F12).
- Busca errores en `assets/script/*.js`.
- Verifica que los selectores jQuery (`#id`, `.clase`) coincidan con el HTML.

#### Cálculos incorrectos
- Revisa variables como `ivg`, `desc2`, `montocambio`, `BaseImpIva`.
- Asegúrate de convertir a número con `parseFloat()` en JS o `(float)` en PHP.
- Verifica redondeos y el orden de las operaciones.

### 4. Aplicar la corrección
- Cambia solo lo necesario.
- Mantén el estilo y las convenciones del código circundante.
- Si agregas sanitización, hazlo con `limpiar()`.
- Si cambias una consulta, usa *prepared statements*.

### 5. Verificar
- Ejecuta `php -l` sobre los archivos modificados.
- Prueba el flujo en el navegador.
- Si es posible, revisa que otras pantallas similares no se vean afectadas.

## Checklist final

- [ ] Mensaje de error identificado y comprendido.
- [ ] Archivo y método responsables localizados.
- [ ] Causa raíz determinada (no solo el síntoma).
- [ ] Corrección mínima aplicada.
- [ ] No se agregaron funcionalidades ajenas al bug.
- [ ] Código validado con `php -l`.
- [ ] Flujo probado o explicado al usuario.

## Consejos adicionales

- Si no hay mensaje de error visible, activa temporalmente `error_reporting(E_ALL)` e `ini_set('display_errors', '1')` en `class/class.php` (ya está activo por defecto).
- Si un problema parece estar en varios lugares (código duplicado), corrige la instancia reportada primero y avisa al usuario sobre la repetición.
- No borres tablas ni columnas sin respaldar la base de datos.
