---
name: pos-arreglos
description: "Guía para diagnosticar y corregir errores, bugs y problemas de calidad en el POS PHP de forma segura y sin romper pantallas dependientes. Úsala cuando algo no funcione bien, falle una pantalla o reporte un error."
argument-hint: "¿Qué está fallando? Describe el síntoma, la pantalla y el mensaje de error si lo hay."
user-invocable: true
---

# POS - Corrección de Errores

Este skill te guía para diagnosticar y corregir problemas en el sistema POS PHP de forma segura, mínima y protegiendo el sistema contra regresiones.

## Cuándo usar este skill

- Una pantalla muestra un error PHP o MySQL.
- Un botón, modal o formulario no responde como se espera.
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
- Busca el método que maneja el proceso en `class/class.php`, `funciones.php` o `class/class.consultas.php`.
- **Análisis de Impacto Cruzado Obligatorio**:
  - Antes de alterar un método en `class/class.php`, usa `grep_search` para listar todas las pantallas que lo usan.
  - Asegúrate de que cualquier cambio mantenga la compatibilidad con los demás llamadores.

### 3. Diagnóstico por tipo de error

#### Error de conexión o base de datos
- Revisa `class/classconexion.php`: credenciales, nombre de base de datos.
- Verifica que el servidor MySQL esté corriendo.
- Confirma que la tabla/columna exista y tenga los tipos de datos esperados.

#### Error de sintaxis PHP
- Ejecuta `php -l archivo.php` para detectar errores de sintaxis antes de dar por terminado el cambio.
- Revisa paréntesis, llaves, punto y coma y comillas.

#### Error de sesión o permisos
- Verifica que `session_start()` esté presente en `class/class.php`.
- Confirma que `$_SESSION['acceso']` se evalúe correctamente en la cabecera del archivo.
- Asegúrate de que el rol afectado esté contemplado sin comprometer la seguridad.

#### Error de SQL / inyección / Transacciones
- Busca concatenaciones de variables en cadenas SQL y sustitúyelas por *prepared statements*:
  ```php
  $stmt = $this->dbh->prepare("SELECT * FROM tabla WHERE campo = ?");
  $stmt->execute(array(limpiar($valor)));
  ```
- Si la operación altera varias tablas (cabecera/detalle, stock, caja), comprueba que esté envuelta en `$this->dbh->beginTransaction()` / `$this->dbh->commit()`.

#### Error en JavaScript / frontend
- Abre la consola del navegador (F12).
- Busca errores en `assets/script/*.js`.
- Verifica que los selectores jQuery (`#id`, `.clase`) coincidan exactamente con el DOM renderizado.

#### Cálculos incorrectos
- Revisa variables como `ivg`, `desc2`, `montocambio`, `BaseImpIva`.
- Asegúrate de convertir a número con `parseFloat()` en JS o `(float)` en PHP.
- Verifica redondeos y el orden de las operaciones aritméticas.

### 4. Aplicar la corrección
- Cambia solo lo necesario.
- Mantén el estilo y las convenciones del código circundante.
- Si agregas sanitización, hazlo con `limpiar()`.
- Si cambias una consulta, usa *prepared statements*.

### 5. Verificar y Proteger contra Regresiones
- Ejecuta `php -l` sobre todos los archivos modificados.
- Verifica que las pantallas dependientes identificadas en el paso 2 no se hayan visto afectadas.
- Prueba el flujo en el navegador.

## Checklist final

- [ ] Mensaje de error identificado y comprendido.
- [ ] Archivo y método responsables localizados.
- [ ] Impacto cruzado evaluado (ninguna pantalla dependiente rota).
- [ ] Causa raíz determinada y corregida mínimamente.
- [ ] No se agregaron funcionalidades ajenas al bug.
- [ ] Código validado con `php -l`.
- [ ] Integridad transaccional y prepared statements verificados.
- [ ] Flujo probado o explicado al usuario.

## Consejos adicionales

- Si no hay mensaje de error visible, activa temporalmente `error_reporting(E_ALL)` e `ini_set('display_errors', '1')` en `class/class.php`.
- Si un problema está duplicado en varios módulos, corrige la instancia reportada primero y documenta al usuario las demás ocurrencias.
- No borres tablas ni columnas sin respaldar previamente la base de datos.
