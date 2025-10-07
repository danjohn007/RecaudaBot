# Guía de Pruebas - RecaudaBot Fixes

## Cómo Probar las Correcciones

### 1. Prueba de Registro de Usuario con Username Duplicado

**Antes del fix:**
```
❌ Error: Fatal error: PDOException: SQLSTATE[23000]: 
   Integrity constraint violation: 1062 Duplicate entry 'admin' for key 'username'
```

**Después del fix:**
```
✅ Usuario registrado exitosamente con username único
   - Primer usuario: admin@test.com → username: admin
   - Segundo usuario: admin@test2.com → username: admin1
   - Tercer usuario: admin@test3.com → username: admin2
```

**Pasos para probar:**
1. Ir a `/register`
2. Registrar usuario con email: `admin@example.com`
3. Verificar que se crea usuario con username: `admin`
4. Registrar otro usuario con email: `admin@test.com`
5. Verificar que se crea usuario con username: `admin1` (no hay error)
6. Iniciar sesión con ambos usuarios para confirmar funcionamiento

---

### 2. Prueba de Vistas de Administración

**Antes del fix:**
```
❌ Error: require_once(...admin/users.php): Failed to open stream: 
   No such file or directory
❌ Error: require_once(...admin/reports.php): Failed to open stream: 
   No such file or directory
❌ Error: require_once(...admin/statistics.php): Failed to open stream: 
   No such file or directory
```

**Después del fix:**
```
✅ Todas las vistas de administración cargan correctamente
```

**Pasos para probar:**
1. Iniciar sesión como administrador
2. Ir a `/admin/usuarios`
   - ✅ Debe mostrar tabla con lista de usuarios
   - ✅ Debe mostrar columnas: ID, Usuario, Nombre, Email, Rol, Estado, Fecha
3. Ir a `/admin/reportes`
   - ✅ Debe mostrar 6 tarjetas con tipos de reportes
   - ✅ Reportes: Ciudadanos, Obligaciones, Pagos, Predios, Licencias, Multas
4. Ir a `/admin/estadisticas`
   - ✅ Debe mostrar 4 tarjetas de resumen
   - ✅ Debe mostrar secciones para gráficos
   - ✅ Debe mostrar tablas de estadísticas

---

### 3. Prueba de Multas Cívicas - Campo Infractor

**Antes del fix:**
```
❌ Warning: Undefined array key "infractor_name" in 
   .../civic_fines/search_results.php on line 40
❌ Deprecated: htmlspecialchars(): Passing null to parameter #1
```

**Después del fix:**
```
✅ El campo "Infractor" muestra el nombre correctamente
```

**Pasos para probar:**
1. Ir a `/multas-civicas/consultar`
2. Buscar una multa cívica existente (por folio o nombre)
3. En los resultados de búsqueda:
   - ✅ Columna "Infractor" debe mostrar el nombre sin errores
   - ✅ No debe haber warnings en los logs
4. Hacer clic en "Ver" detalle de una multa
5. En la página de detalle:
   - ✅ Campo "Infractor" debe mostrar el nombre correctamente
   - ✅ Campo "CURP" debe mostrar el ID del ciudadano (si existe)
   - ✅ No debe haber errores ni warnings

**SQL para verificar datos de prueba:**
```sql
-- Ver estructura de la tabla
SHOW COLUMNS FROM civic_fines;

-- Ver datos de ejemplo
SELECT id, folio, citizen_name, citizen_id, status 
FROM civic_fines 
LIMIT 5;

-- Verificar que citizen_name tiene datos
SELECT COUNT(*) as total, 
       SUM(CASE WHEN citizen_name IS NOT NULL THEN 1 ELSE 0 END) as con_nombre
FROM civic_fines;
```

---

### 4. Prueba de Eliminación de Sidebar Duplicado

**Antes del fix:**
```
❌ Dos menús visibles:
   - Sidebar izquierdo (duplicado)
   - Navbar superior derecho (correcto)
```

**Después del fix:**
```
✅ Un solo menú visible:
   - Navbar superior responsive
   - Funciona correctamente en desktop y móvil
```

**Pasos para probar:**

**Desktop:**
1. Abrir el sitio en navegador desktop
2. ✅ Verificar que NO hay sidebar a la izquierda
3. ✅ Verificar que el navbar superior está presente
4. ✅ Verificar que todos los enlaces funcionan
5. ✅ Verificar que el dropdown de usuario funciona

**Móvil/Responsive:**
1. Cambiar a vista móvil (< 992px de ancho)
2. ✅ Verificar que aparece el botón hamburguesa (☰)
3. ✅ Hacer clic en el botón hamburguesa
4. ✅ Verificar que el menú se despliega correctamente
5. ✅ Verificar que todos los enlaces están presentes
6. ✅ Verificar que se puede cerrar el menú

**Elementos que NO deben estar presentes:**
- ❌ No debe haber sidebar fijo en la izquierda
- ❌ No debe haber botón "×" para cerrar sidebar
- ❌ No debe haber overlay oscuro al hacer clic en toggle

---

## Checklist de Validación Completa

### Funcionalidad General
- [ ] El sitio carga sin errores en consola del navegador
- [ ] No hay errores PHP en los logs del servidor
- [ ] La navegación funciona correctamente
- [ ] El responsive design funciona en diferentes tamaños

### Registro y Autenticación
- [ ] Registro de nuevo usuario funciona
- [ ] No hay error de username duplicado
- [ ] Login funciona correctamente
- [ ] Logout funciona correctamente

### Panel de Administración
- [ ] Dashboard admin carga sin errores
- [ ] Vista de usuarios carga y muestra datos
- [ ] Vista de reportes carga sin errores
- [ ] Vista de estadísticas carga sin errores

### Multas Cívicas
- [ ] Búsqueda de multas funciona
- [ ] Resultados muestran nombre del infractor
- [ ] Detalle de multa muestra todos los campos
- [ ] No hay warnings de campos indefinidos

### Layout y UI
- [ ] No hay sidebar duplicado a la izquierda
- [ ] Navbar superior funciona correctamente
- [ ] Menú responsive funciona en móvil
- [ ] Flash messages se muestran correctamente

---

## Notas para el Desarrollador

### Archivos a revisar si hay problemas:

1. **Errores de username:**
   - `app/controllers/AuthController.php` (líneas 82-91)
   - `app/models/User.php` (método existsByUsername)

2. **Vistas de admin faltantes:**
   - `app/views/admin/users.php`
   - `app/views/admin/reports.php`
   - `app/views/admin/statistics.php`

3. **Campos de civic_fines:**
   - `app/views/civic_fines/search_results.php` (línea 40)
   - `app/views/civic_fines/detail.php` (líneas 28, 33)

4. **Sidebar duplicado:**
   - `app/views/layout/header.php` (sidebar eliminado)
   - `app/views/layout/footer.php` (JS eliminado)

### Logs a verificar:
```bash
# PHP error log
tail -f /var/log/php/error.log

# Apache/Nginx error log
tail -f /var/log/apache2/error.log
# o
tail -f /var/log/nginx/error.log

# Buscar errores específicos
grep -i "duplicate entry" /var/log/php/error.log
grep -i "undefined array key" /var/log/php/error.log
grep -i "failed to open stream" /var/log/php/error.log
```

### Base de datos:
```sql
-- Verificar usuarios con username duplicado (no debería haber)
SELECT username, COUNT(*) as count 
FROM users 
GROUP BY username 
HAVING count > 1;

-- Verificar estructura de civic_fines
DESCRIBE civic_fines;

-- Verificar que existen los campos correctos
SELECT COLUMN_NAME 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'civic_fines' 
  AND COLUMN_NAME IN ('citizen_name', 'citizen_id', 'infractor_name');
```

---

## Soporte

Si encuentras algún problema después de aplicar estos fixes:

1. Revisa los logs de PHP y del servidor web
2. Verifica que todos los archivos fueron actualizados correctamente
3. Limpia la caché del navegador (Ctrl+F5)
4. Verifica que no hay sesiones antiguas activas
5. Consulta `FIX_NOTES.md` para más detalles técnicos

**Contacto:** Consulta el README.md o CHANGELOG.md para información de soporte.
