# Guía de Instalación de Actualizaciones - RecaudaBot

Esta guía te ayudará a aplicar las actualizaciones más recientes al sistema RecaudaBot.

## 📋 Pre-requisitos

- Acceso al servidor de base de datos MySQL/MariaDB
- Acceso al servidor web (PHP 7.4+)
- Credenciales de administrador del sistema
- Backup reciente de la base de datos (recomendado)

## 🔄 Pasos de Instalación

### 1. Backup de la Base de Datos

**⚠️ IMPORTANTE:** Antes de aplicar cualquier cambio, realiza un backup completo.

```bash
mysqldump -u usuario -p recaudabot > backup_recaudabot_$(date +%Y%m%d_%H%M%S).sql
```

### 2. Aplicar Migración SQL

Conéctate a tu base de datos y ejecuta el script de migración:

```bash
mysql -u usuario -p recaudabot < assets/sql/migration_updates.sql
```

O desde MySQL:
```sql
USE recaudabot;
SOURCE /ruta/completa/a/assets/sql/migration_updates.sql;
```

### 3. Verificar Migraciones

Ejecuta estas consultas para verificar que todo se aplicó correctamente:

```sql
-- Verificar tabla de configuraciones
SELECT COUNT(*) as total_settings FROM system_settings;
-- Debe retornar al menos 40 configuraciones

-- Verificar nuevas tablas
SHOW TABLES LIKE 'import_logs';
SHOW TABLES LIKE 'report_history';

-- Verificar índices
SHOW INDEXES FROM users WHERE Key_name LIKE 'idx_%';
```

### 4. Verificar Archivos

Asegúrate de que todos los nuevos archivos estén en su lugar:

```bash
# Verificar controladores
ls -la app/controllers/ConfigurationController.php
ls -la app/controllers/ImportController.php
ls -la app/controllers/ReportController.php

# Verificar vistas
ls -la app/views/civic_fines/search_results.php
ls -la app/views/property_tax/search_results.php
ls -la app/views/admin/configuration/
ls -la app/views/admin/imports/
ls -la app/views/admin/reports/

# Verificar librería PDF
ls -la app/lib/SimplePDF.php
```

### 5. Configurar Permisos

Asegúrate de que el servidor web tenga los permisos correctos:

```bash
# Permisos para directorios
chmod 755 app/views/admin/configuration
chmod 755 app/views/admin/imports
chmod 755 app/views/admin/reports

# Permisos para archivos PHP
chmod 644 app/controllers/*.php
chmod 644 app/views/**/*.php
```

### 6. Limpiar Caché

Si usas caché de PHP (como OPcache), límpialo:

```bash
# Reiniciar PHP-FPM (ajusta según tu configuración)
sudo systemctl restart php7.4-fpm
# o
sudo systemctl restart php8.0-fpm
```

O desde el servidor web:
```bash
sudo systemctl restart apache2
# o
sudo systemctl restart nginx
```

## ✅ Verificación Post-Instalación

### 1. Acceder al Sistema

1. Abre tu navegador en: `https://tu-dominio.com/admin`
2. Inicia sesión con credenciales de administrador

### 2. Verificar Nuevas Funcionalidades

#### Sidebar
- [ ] El menú lateral debe aparecer al hacer clic en el botón de hamburguesa (☰)
- [ ] El overlay oscuro debe aparecer detrás del sidebar
- [ ] Debe cerrarse al hacer clic fuera o en la X

#### Configuraciones
- [ ] Acceder a `/admin/configuraciones`
- [ ] Verificar que aparecen 8 tarjetas de configuración
- [ ] Entrar a "Configuración PayPal" y probar guardar cambios
- [ ] Verificar mensaje de éxito

#### Importaciones
- [ ] Acceder a `/admin/importaciones`
- [ ] Descargar una plantilla CSV
- [ ] Verificar que tiene el formato correcto

#### Reportes
- [ ] Acceder a `/admin/reportes`
- [ ] Entrar a "Reporte de Ciudadanos"
- [ ] Aplicar algunos filtros
- [ ] Exportar a CSV

#### Búsquedas
- [ ] Ir a `/multas-civicas/consultar`
- [ ] Buscar cualquier término
- [ ] Verificar que aparece la página de resultados (no error 404)
- [ ] Hacer lo mismo con `/impuesto-predial/consultar`

#### Registro
- [ ] Ir a `/register`
- [ ] Verificar que NO aparece el campo "Nombre de Usuario"
- [ ] Verificar que el campo "Teléfono" tiene validación de 10 dígitos
- [ ] Probar registrar un usuario nuevo

#### Comprobantes PDF
- [ ] Ir a `/comprobantes`
- [ ] Descargar un comprobante
- [ ] Verificar que se genera un HTML con formato de PDF (no el mensaje de error anterior)

## 🔧 Configuración Inicial

### 1. Configuraciones del Sistema

Accede a `/admin/configuraciones` y configura:

#### Obligatorias:
- **Información de Contacto**: Teléfonos y horarios
- **Sitio Web**: Nombre y descripción

#### Recomendadas:
- **PayPal**: Si vas a procesar pagos en línea
- **Correo Electrónico**: Para enviar notificaciones
- **Cuentas Bancarias**: Para referencia de depósitos

### 2. Probar Importaciones

1. Descarga la plantilla de ciudadanos
2. Agrega 2-3 registros de prueba
3. Importa el archivo
4. Verifica que los ciudadanos se crearon correctamente

## ❌ Solución de Problemas

### Error: Tabla system_settings no existe
```sql
-- Ejecutar manualmente
CREATE TABLE system_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    description VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
```

### Error 500 al acceder a configuraciones
- Verificar permisos de archivos
- Verificar logs de PHP: `tail -f /var/log/php_errors.log`
- Verificar que la clase Database está disponible

### Sidebar no aparece
- Limpiar caché del navegador (Ctrl + Shift + R)
- Verificar que el archivo `public/css/style.css` tiene los estilos del sidebar
- Verificar que JavaScript está cargando correctamente

### Importación falla
- Verificar que el archivo tiene el formato correcto (UTF-8, headers correctos)
- Verificar permisos de upload en PHP: `upload_max_filesize` y `post_max_size`
- Revisar logs de importación en la tabla `import_logs`

### PDF no se genera
- Verificar que el archivo `app/lib/SimplePDF.php` existe
- Verificar que se está incluyendo correctamente en ReceiptController
- Verificar permisos de escritura

## 📊 Monitoreo

Después de la instalación, monitorea:

```sql
-- Registros de importación
SELECT * FROM import_logs ORDER BY created_at DESC LIMIT 10;

-- Reportes generados
SELECT * FROM report_history ORDER BY generated_at DESC LIMIT 10;

-- Configuraciones actualizadas
SELECT setting_key, updated_at 
FROM system_settings 
WHERE updated_at > NOW() - INTERVAL 1 DAY;

-- Nuevos usuarios registrados
SELECT username, email, created_at 
FROM users 
WHERE created_at > NOW() - INTERVAL 1 DAY;
```

## 🔐 Seguridad

### Recomendaciones Post-Instalación

1. **Cambiar Configuraciones de PayPal**
   - Asegúrate de estar en modo "sandbox" hasta probar completamente
   - NO uses credenciales de producción hasta estar seguro

2. **Configuración de Email**
   - Usa contraseñas de aplicación, no contraseñas reales
   - Configura límites de envío

3. **Importaciones**
   - Solo usuarios admin pueden importar
   - Revisar cada archivo antes de importar
   - Los archivos no se guardan, se procesan y eliminan

4. **Reportes**
   - Los reportes pueden contener información sensible
   - Controlar quién tiene acceso

## 📞 Soporte

Si encuentras problemas:

1. Revisa los logs del servidor
2. Verifica que todos los archivos están en su lugar
3. Consulta el CHANGELOG.md para detalles de cambios
4. Contacta al equipo de desarrollo

---

**Última Actualización:** Enero 2024
**Versión:** 1.1.0

¡Instalación completada! El sistema RecaudaBot ahora tiene todas las nuevas funcionalidades activadas.
