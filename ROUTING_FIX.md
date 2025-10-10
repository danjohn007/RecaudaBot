# Fix para Error 404 en Login y Otras Rutas

## Problema Identificado

El sistema mostraba errores 404 después de intentar iniciar sesión. El problema era causado por el uso incorrecto de `PUBLIC_URL` en lugar de `BASE_URL` para rutas internas, acciones de formularios y redirecciones.

## Causa Raíz

En la configuración del sistema, existen dos constantes importantes:

- **`BASE_URL`**: `https://recaudabot.digital/daniel/recaudabot` - Para rutas, enlaces y formularios
- **`PUBLIC_URL`**: `https://recaudabot.digital/daniel/recaudabot/public` - Solo para recursos estáticos (CSS, JS, imágenes)

El error ocurría porque:
1. Los formularios de login y registro usaban `PUBLIC_URL . '/login'` → `https://recaudabot.digital/daniel/recaudabot/public/login`
2. El método `Controller::redirect()` usaba `PUBLIC_URL` para redirecciones internas
3. El router espera rutas sin `/public` en la URL

Esto causaba que al enviar el formulario de login, la aplicación buscara la ruta `/public/login` en lugar de `/login`, resultando en un error 404.

## Solución Aplicada

### 1. Actualización del Método `redirect()` en Controller
**Archivo**: `app/core/Controller.php`

```php
protected function redirect($url) {
    // Use BASE_URL for internal redirects (routes)
    // PUBLIC_URL is only for static assets (CSS, JS, images)
    if (strpos($url, 'http') !== 0) {
        $url = BASE_URL . $url;  // Cambiado de PUBLIC_URL a BASE_URL
    }
    header('Location: ' . $url);
    exit;
}
```

### 2. Actualización del Formulario de Login
**Archivo**: `app/views/auth/login.php`

```php
<!-- ANTES -->
<form method="POST" action="<?php echo PUBLIC_URL; ?>/login" id="loginForm">

<!-- DESPUÉS -->
<form method="POST" action="<?php echo BASE_URL; ?>/login" id="loginForm">
```

También se actualizó el enlace de registro:
```php
<!-- ANTES -->
<a href="<?php echo PUBLIC_URL; ?>/register">Regístrate aquí</a>

<!-- DESPUÉS -->
<a href="<?php echo BASE_URL; ?>/register">Regístrate aquí</a>
```

### 3. Actualización del Formulario de Registro
**Archivo**: `app/views/auth/register.php`

```php
<!-- ANTES -->
<form method="POST" action="<?php echo PUBLIC_URL; ?>/register" id="registerForm">

<!-- DESPUÉS -->
<form method="POST" action="<?php echo BASE_URL; ?>/register" id="registerForm">
```

Y el enlace de login:
```php
<!-- ANTES -->
<a href="<?php echo PUBLIC_URL; ?>/login">Inicia sesión aquí</a>

<!-- DESPUÉS -->
<a href="<?php echo BASE_URL; ?>/login">Inicia sesión aquí</a>
```

## Uso Correcto de URLs

### BASE_URL (Para rutas y formularios)
```php
// Formularios
<form action="<?php echo BASE_URL; ?>/login" method="POST">

// Enlaces de navegación
<a href="<?php echo BASE_URL; ?>/admin">Dashboard</a>

// Redirecciones en código PHP
$this->redirect('/perfil');  // Usa BASE_URL internamente
```

### PUBLIC_URL (Solo para recursos estáticos)
```php
// CSS
<link href="<?php echo PUBLIC_URL; ?>/css/style.css" rel="stylesheet">

// JavaScript
<script src="<?php echo PUBLIC_URL; ?>/js/main.js"></script>

// Imágenes
<img src="<?php echo PUBLIC_URL; ?>/images/logo.png" alt="Logo">
```

## Verificación

Todos los demás formularios en la aplicación ya estaban usando `BASE_URL` correctamente:
- Formularios de configuración administrativa
- Formularios de reportes
- Formularios de importación
- Formularios de consulta de impuestos y multas
- Formularios de pago

El archivo `app/views/layout/header.php` también usa `BASE_URL` correctamente para todos los enlaces de navegación.

## Resultado

Con estos cambios:
1. ✅ El formulario de login ahora envía datos a la ruta correcta
2. ✅ Las redirecciones funcionan correctamente después del login
3. ✅ Todos los enlaces internos funcionan sin error 404
4. ✅ Los recursos estáticos (CSS, JS) se cargan correctamente
5. ✅ El sistema toma la ruta automáticamente sin configuración manual

## Archivos Modificados

1. `app/core/Controller.php` - Método `redirect()`
2. `app/views/auth/login.php` - Formulario y enlaces
3. `app/views/auth/register.php` - Formulario y enlaces
