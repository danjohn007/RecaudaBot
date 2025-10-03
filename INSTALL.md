# RecaudaBot - Guía de Instalación Rápida

## 📋 Pre-requisitos

Antes de comenzar, asegúrate de tener:

- PHP 7.4 o superior
- MySQL 5.7 o superior  
- Apache 2.4+ con mod_rewrite habilitado
- Acceso a línea de comandos (terminal)

## 🚀 Instalación en 5 Pasos

### Paso 1: Descargar el Sistema

```bash
git clone https://github.com/danjohn007/RecaudaBot.git
cd RecaudaBot
```

### Paso 2: Crear la Base de Datos

```bash
# Acceder a MySQL
mysql -u root -p

# Crear base de datos
CREATE DATABASE recaudabot CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;

# Importar el esquema
mysql -u root -p recaudabot < assets/sql/schema.sql

# Importar datos de ejemplo
mysql -u root -p recaudabot < assets/sql/sample_data.sql
```

### Paso 3: Configurar Credenciales

Edita `config/config.php` y modifica:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'recaudabot');
define('DB_USER', 'tu_usuario');    // Cambiar
define('DB_PASS', 'tu_password');   // Cambiar
```

### Paso 4: Configurar Apache

**Opción A: Usar directamente en htdocs/www**

```bash
# Copiar a directorio web
cp -r RecaudaBot /var/www/html/

# Dar permisos
chmod -R 755 /var/www/html/RecaudaBot
chmod -R 777 /var/www/html/RecaudaBot/public/uploads
```

Acceder en: `http://localhost/RecaudaBot/`

**Opción B: Configurar VirtualHost (Recomendado)**

Crear archivo `/etc/apache2/sites-available/recaudabot.conf`:

```apache
<VirtualHost *:80>
    ServerName recaudabot.local
    DocumentRoot /ruta/a/RecaudaBot/public

    <Directory /ruta/a/RecaudaBot/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/recaudabot-error.log
    CustomLog ${APACHE_LOG_DIR}/recaudabot-access.log combined
</VirtualHost>
```

Habilitar y reiniciar:

```bash
sudo a2enmod rewrite
sudo a2ensite recaudabot.conf
sudo systemctl restart apache2

# Agregar al archivo hosts
sudo nano /etc/hosts
# Agregar línea: 127.0.0.1 recaudabot.local
```

Acceder en: `http://recaudabot.local/`

### Paso 5: Verificar Instalación

Visita: `http://localhost/RecaudaBot/test_connection.php`

Este archivo verificará:
- ✅ Versión de PHP
- ✅ Extensiones necesarias
- ✅ Conexión a base de datos
- ✅ Detección de URL base
- ✅ Permisos de escritura
- ✅ Archivos .htaccess

Si todo está en verde ✅, ¡el sistema está listo!

## 👤 Acceder al Sistema

Visita: `http://localhost/RecaudaBot/` o `http://recaudabot.local/`

### Usuarios de Prueba

| Usuario | Contraseña | Rol |
|---------|-----------|-----|
| admin | password123 | Administrador |
| jperez | password123 | Ciudadano |
| tesoreria | password123 | Área Municipal |

⚠️ **IMPORTANTE**: Cambia estas contraseñas en producción.

## 🔧 Solución de Problemas Comunes

### Error: "No se puede conectar a la base de datos"
- Verifica las credenciales en `config/config.php`
- Asegúrate de que MySQL esté corriendo
- Verifica que la base de datos exista: `SHOW DATABASES;`

### Error: 404 en todas las rutas
- Verifica que mod_rewrite esté habilitado: `sudo a2enmod rewrite`
- Verifica que los archivos .htaccess existan
- Verifica que AllowOverride esté en "All" en la configuración de Apache

### Error: "Extensión PDO no encontrada"
- Instala las extensiones: `sudo apt-get install php-mysql php-pdo`
- Reinicia Apache: `sudo systemctl restart apache2`

### URLs no funcionan correctamente
- El sistema auto-detecta la URL base
- Si hay problemas, edita manualmente en `config/config.php`:
  ```php
  define('BASE_URL', 'http://localhost/RecaudaBot');
  ```

### Permisos de escritura
```bash
# Dar permisos al directorio de uploads
chmod -R 777 public/uploads
```

## 📚 Próximos Pasos

1. **Explorar el Sistema**
   - Inicia sesión con cualquier usuario de prueba
   - Navega por todos los módulos
   - Prueba crear un nuevo usuario

2. **Revisar la Documentación**
   - Lee el `README.md` completo
   - Revisa la estructura del proyecto
   - Familiarízate con las rutas disponibles

3. **Personalizar**
   - Cambia colores en `public/css/style.css`
   - Modifica el nombre del sistema en `config/config.php`
   - Ajusta configuraciones según tus necesidades

4. **Producción**
   - Cambia todas las contraseñas
   - Configura HTTPS
   - Ajusta error_reporting a 0 en `config/config.php`
   - Configura backups automáticos de la BD
   - Revisa permisos de archivos

## 🎯 Características Principales

- ✅ Impuesto Predial
- ✅ Licencias de Funcionamiento
- ✅ Multas de Tránsito con impugnación
- ✅ Multas Cívicas
- ✅ Pagos en línea (múltiples métodos)
- ✅ Comprobantes digitales
- ✅ Citas en línea
- ✅ Dashboard administrativo
- ✅ Sistema de notificaciones
- ✅ Orientación y ayuda
- ✅ Gestión de usuarios
- ✅ Reportes y exportación

## 💡 Tips

- Usa Chrome DevTools para debug
- Revisa los logs de Apache si hay errores
- El archivo `test_connection.php` es tu amigo
- Los usuarios de prueba tienen datos reales en la BD
- Explora las tablas en MySQL para entender la estructura

## 🆘 Soporte

Si tienes problemas:

1. Revisa `test_connection.php`
2. Consulta el `README.md` completo
3. Abre un issue en GitHub
4. Verifica los logs de Apache: `/var/log/apache2/error.log`

## ✅ Checklist Post-Instalación

- [ ] Base de datos creada e importada
- [ ] Credenciales configuradas
- [ ] Apache configurado y reiniciado
- [ ] test_connection.php muestra todo en verde
- [ ] Puedo iniciar sesión
- [ ] Puedo navegar por todos los módulos
- [ ] Los estilos se cargan correctamente
- [ ] Las URLs amigables funcionan

---

**¡Listo!** Tu sistema RecaudaBot está instalado y funcionando. 🚀

Para más información, consulta el [README.md](README.md)
