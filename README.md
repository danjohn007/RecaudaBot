# RecaudaBot

Sistema Integral de Recaudación Municipal

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://www.php.net/)
[![MySQL Version](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg)](https://getbootstrap.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📋 Descripción

RecaudaBot es un sistema web completo desarrollado en PHP puro (sin frameworks) que permite a los municipios gestionar eficientemente todos sus procesos de recaudación, incluyendo:

- 🏠 **Impuesto Predial**: Consulta y pago de impuestos sobre propiedades
- 🏢 **Licencias de Funcionamiento**: Solicitud, renovación y seguimiento
- 🚗 **Multas de Tránsito**: Consulta, pago e impugnación
- ⚖️ **Multas Cívicas**: Gestión de sanciones del Juzgado Cívico
- 🧾 **Comprobantes Digitales**: Generación de recibos en PDF/XML
- 📅 **Citas**: Sistema de agendamiento para trámites presenciales
- 💰 **Pagos en Línea**: Múltiples métodos de pago (tarjeta, SPEI, OXXO)
- 📊 **Dashboard Administrativo**: Estadísticas y reportes en tiempo real
- 🔐 **Autenticación Segura**: Sistema de roles y permisos

## 🚀 Características

### Módulos Principales

1. **Autenticación y Usuarios**
   - Registro y login con validación
   - Autenticación segura con `password_hash()`
   - Roles: Ciudadano, Administrador, Área Municipal
   - Gestión de perfiles

2. **Impuesto Predial**
   - Búsqueda por clave catastral
   - Cálculo automático de intereses moratorios
   - Descuentos por pronto pago
   - Historial de pagos

3. **Licencias de Funcionamiento**
   - Solicitud en línea
   - Renovación automática
   - Carga de documentos
   - Seguimiento del estado

4. **Multas de Tránsito**
   - Consulta por folio, placas o licencia
   - Visualización de evidencias
   - Sistema de impugnación
   - Descuento por pago voluntario

5. **Multas Cívicas**
   - Consulta por folio o identificación
   - Fundamentos legales
   - Sistema de medios de defensa

6. **Sistema de Pagos**
   - Integración con pasarelas de pago
   - Múltiples métodos: tarjeta, SPEI, OXXO
   - Generación de referencias bancarias
   - Confirmación inmediata

7. **Comprobantes Digitales**
   - Generación automática de recibos
   - Descarga en PDF
   - Historial completo
   - Reenvío por correo

8. **Orientación y Asistencia**
   - Guías paso a paso
   - Preguntas frecuentes
   - Calculadoras de costos
   - Chatbot (interfaz preparada)

9. **Citas**
   - Agendamiento en línea
   - Calendario de disponibilidad
   - Notificaciones automáticas

10. **Dashboard Administrativo**
    - KPIs en tiempo real
    - Gráficas de recaudación
    - Reportes personalizables
    - Exportación a CSV
    - API REST para integraciones

## 🛠️ Tecnologías

- **Backend**: PHP 7.4+ (sin frameworks)
- **Base de Datos**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework CSS**: Bootstrap 5.3
- **Gráficas**: Chart.js
- **Iconos**: Bootstrap Icons
- **Arquitectura**: MVC (Model-View-Controller)
- **Seguridad**: 
  - `password_hash()` y `password_verify()`
  - Prepared Statements (PDO)
  - CSRF protection ready
  - XSS prevention
  - Input validation

## 📦 Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Apache 2.4+ con mod_rewrite habilitado
- Extensiones PHP requeridas:
  - PDO
  - pdo_mysql
  - mbstring
  - json
  - openssl

## 🔧 Instalación

### 1. Clonar el Repositorio

```bash
git clone https://github.com/danjohn007/RecaudaBot.git
cd RecaudaBot
```

### 2. Configurar el Servidor Web

#### Apache

Asegúrate de que `mod_rewrite` esté habilitado:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Configura el VirtualHost o apunta el DocumentRoot a la carpeta `public/`:

```apache
<VirtualHost *:80>
    ServerName recaudabot.local
    DocumentRoot /ruta/a/RecaudaBot/public
    
    <Directory /ruta/a/RecaudaBot/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

O simplemente copia el proyecto a tu `htdocs` o `www`:

```bash
cp -r RecaudaBot /var/www/html/
```

### 3. Crear la Base de Datos

```bash
# Acceder a MySQL
mysql -u root -p

# Crear la base de datos
CREATE DATABASE recaudabot CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

### 4. Importar el Esquema y Datos de Ejemplo

```bash
# Importar esquema (estructura de tablas)
mysql -u root -p recaudabot < assets/sql/schema.sql

# Opción A: Datos de ejemplo básicos (original)
mysql -u root -p recaudabot < assets/sql/sample_data.sql

# Opción B: Datos de ejemplo comprehensivos (RECOMENDADO)
# Incluye 75+ pagos distribuidos en 6 meses para poblar todas las gráficas
mysql -u root -p recaudabot < assets/sql/comprehensive_sample_data.sql
```

> **💡 Recomendación**: Usar `comprehensive_sample_data.sql` para desarrollo y pruebas, ya que incluye datos extensivos que garantizan que todas las gráficas del Dashboard Administrativo y Estadísticas del Sistema muestren información correctamente.
> 
> Ver detalles completos en: [`assets/sql/README_SAMPLE_DATA.md`](assets/sql/README_SAMPLE_DATA.md)

### 5. Configurar las Credenciales

Edita el archivo `config/config.php` y ajusta las credenciales de la base de datos:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'recaudabot');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_password');
```

### 6. Configurar Permisos

```bash
# Dar permisos de escritura al directorio de uploads
chmod -R 755 public/uploads
chown -R www-data:www-data public/uploads

# Asegurar que .htaccess es legible
chmod 644 .htaccess public/.htaccess
```

### 7. Verificar la Instalación

Accede al archivo de prueba para verificar que todo esté configurado correctamente:

```
http://localhost/RecaudaBot/test_connection.php
```

O si configuraste un VirtualHost:

```
http://recaudabot.local/test_connection.php
```

Este archivo verificará:
- ✅ Versión de PHP
- ✅ Extensiones necesarias
- ✅ Conexión a la base de datos
- ✅ Detección de URL base
- ✅ Permisos de escritura
- ✅ Archivos .htaccess

### 8. Acceder al Sistema

Una vez verificado, accede al sistema:

```
http://localhost/RecaudaBot/
```

O:

```
http://recaudabot.local/
```

## 👤 Usuarios de Prueba

El sistema incluye usuarios de prueba con diferentes roles:

| Usuario | Contraseña | Rol | Descripción |
|---------|-----------|-----|-------------|
| `admin` | `password123` | Administrador | Acceso completo al sistema |
| `jperez` | `password123` | Ciudadano | Usuario normal |
| `mlopez` | `password123` | Ciudadano | Usuario normal |
| `tesoreria` | `password123` | Área Municipal | Personal municipal |
| `cgonzalez` | `password123` | Ciudadano | Usuario normal |

⚠️ **IMPORTANTE**: Cambia estas contraseñas en producción.

## 📂 Estructura del Proyecto

```
RecaudaBot/
├── app/
│   ├── controllers/     # Controladores (lógica de negocio)
│   ├── core/           # Clases base (Router, Controller, Model)
│   ├── models/         # Modelos (interacción con BD)
│   └── views/          # Vistas (HTML/PHP)
│       ├── layout/     # Header y Footer
│       ├── home/       # Página de inicio
│       ├── auth/       # Login y registro
│       ├── property_tax/   # Impuesto predial
│       ├── licenses/   # Licencias
│       ├── traffic_fines/  # Multas de tránsito
│       ├── civic_fines/    # Multas cívicas
│       ├── receipts/   # Comprobantes
│       ├── assistance/ # Orientación
│       ├── payments/   # Pagos
│       ├── appointments/   # Citas
│       ├── admin/      # Administración
│       └── profile/    # Perfil de usuario
├── assets/
│   └── sql/           # Scripts SQL
│       ├── schema.sql      # Estructura de BD
│       └── sample_data.sql # Datos de ejemplo
├── config/
│   ├── config.php     # Configuración general
│   └── database.php   # Clase de conexión BD
├── public/
│   ├── css/           # Archivos CSS
│   ├── js/            # Archivos JavaScript
│   ├── img/           # Imágenes
│   ├── uploads/       # Archivos subidos
│   ├── .htaccess      # Reescritura de URLs
│   └── index.php      # Front Controller
├── .htaccess          # Redirección a public/
├── test_connection.php # Verificación de instalación
└── README.md          # Este archivo
```

## 🔒 Seguridad

- ✅ Contraseñas hasheadas con `password_hash()` (bcrypt)
- ✅ Prepared Statements para prevenir SQL Injection
- ✅ Validación de entrada en cliente y servidor
- ✅ Sesiones seguras con configuración personalizada
- ✅ Headers de seguridad en .htaccess
- ✅ Protección contra XSS
- ✅ Registro de auditoría (audit_log)
- ✅ Control de acceso basado en roles

## 📊 Base de Datos

El sistema incluye 15+ tablas principales:

- `users` - Usuarios del sistema
- `properties` - Predios/propiedades
- `property_taxes` - Impuestos prediales
- `business_licenses` - Licencias de funcionamiento
- `license_documents` - Documentos de licencias
- `traffic_fines` - Multas de tránsito
- `fine_evidence` - Evidencias de multas
- `fine_appeals` - Impugnaciones
- `civic_fines` - Multas cívicas
- `payments` - Pagos realizados
- `receipts` - Comprobantes generados
- `appointments` - Citas agendadas
- `notifications` - Notificaciones
- `audit_log` - Registro de auditoría
- `system_settings` - Configuración del sistema
- `help_guides` - Guías de ayuda
- `faq` - Preguntas frecuentes

## 🌐 URLs Amigables

El sistema utiliza URLs amigables gracias a mod_rewrite:

```
http://dominio/impuesto-predial/consultar
http://dominio/licencias/nueva
http://dominio/multas-transito/detalle/1
http://dominio/comprobantes
http://dominio/admin/dashboard
```

## 🎨 Personalización

### Cambiar Colores

Edita `public/css/style.css`:

```css
:root {
    --primary-color: #0d6efd;
    --secondary-color: #6c757d;
    /* ... */
}
```

### Configurar Nombre del Sistema

Edita `config/config.php`:

```php
define('APP_NAME', 'Tu Nombre Aquí');
define('APP_VERSION', '1.0.0');
```

### Ajustar Configuraciones

Todas las configuraciones están en `config/config.php`:
- Zona horaria
- Duración de sesión
- Tamaño máximo de archivos
- Configuración de email
- API keys de pasarelas de pago

## 📈 Funcionalidades Futuras

- [ ] Integración con WhatsApp API
- [ ] Notificaciones SMS
- [ ] Chatbot con IA
- [ ] App móvil
- [ ] Facturación electrónica (CFDI 4.0)
- [ ] Reportes avanzados con gráficas interactivas
- [ ] Integración con más pasarelas de pago
- [ ] Sistema de tickets de soporte
- [ ] Calendario de eventos municipales

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 👨‍💻 Autor

**RecaudaBot Team**

- GitHub: [@danjohn007](https://github.com/danjohn007)

## 📞 Soporte

Si tienes problemas o preguntas:

1. Revisa el archivo `test_connection.php` para diagnóstico
2. Consulta las guías en `/orientacion/guias`
3. Revisa las FAQ en `/orientacion/faq`
4. Abre un issue en GitHub

## ⚠️ Notas Importantes

- Este es un sistema de ejemplo/demostración
- Para producción, implementa HTTPS obligatorio
- Configura backups automáticos de la base de datos
- Cambia todas las contraseñas por defecto
- Revisa y ajusta los permisos de archivos
- Configura un sistema de logs robusto
- Implementa rate limiting para APIs
- Considera usar Redis para sesiones en producción

## 🎯 Roadmap

### v1.0 (Actual)
- ✅ Sistema completo MVC
- ✅ 11 módulos funcionales
- ✅ Dashboard administrativo
- ✅ Sistema de pagos
- ✅ Comprobantes digitales

### v1.1 (Próximamente)
- 📱 Integración WhatsApp
- 🤖 Chatbot funcional
- 📊 Reportes avanzados
- 🔔 Notificaciones push

### v2.0 (Futuro)
- 📱 App móvil nativa
- 🧾 CFDI 4.0 completo
- 🔐 2FA avanzado
- 🌍 Multi-idioma

---

**¡Gracias por usar RecaudaBot!** 🚀

Para más información, visita: [GitHub Repository](https://github.com/danjohn007/RecaudaBot)
