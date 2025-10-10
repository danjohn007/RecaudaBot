# Solución al Error 403 en Cerrar Sesión

## Problema
Al intentar cerrar sesión, aparecía el error **403 FORBIDDEN** y la vista no se encontraba.

## Causa del Problema
El formulario de "Cerrar Sesión" en `app/views/layout/header.php` estaba intentando acceder directamente al archivo `public/logout_direct.php`:

```php
<form method="POST" action="<?php echo PUBLIC_URL; ?>/logout_direct.php">
```

Esto causaba el error 403 porque:
1. El acceso directo a archivos PHP (`/logout_direct.php`) puede ser bloqueado por configuración del servidor
2. No seguía el patrón de enrutamiento de la aplicación (no pasa por el router)
3. Puede tener problemas de permisos o configuración .htaccess

**Nota**: Aunque `PUBLIC_URL` y `BASE_URL` son iguales (definidos en config.php), el problema real era el acceso directo al archivo `/logout_direct.php` en lugar de usar la ruta del router.

## Solución Implementada

Se modificó el formulario para usar la ruta del router en lugar de acceso directo al archivo:

```php
<form method="POST" action="<?php echo BASE_URL; ?>/logout">
```

### ¿Por qué funciona esta solución?

1. **Usa el Router**: La petición ahora pasa por `public/index.php` que es el front controller
2. **Rutas Configuradas**: El router ya tiene las rutas de logout configuradas:
   - `GET /logout`
   - `POST /logout` 
   - `GET /public/logout` (alternativa)
3. **Método Correcto**: El `AuthController::logout()` maneja correctamente la sesión
4. **No hay acceso directo**: Evita problemas de permisos de archivo

## Archivo Modificado

- **Archivo**: `app/views/layout/header.php`
- **Línea**: 178
- **Cambio**: `PUBLIC_URL/logout_direct.php` → `BASE_URL/logout`

## Verificación

✅ Header.php usa BASE_URL/logout correctamente
✅ Header.php ya no usa logout_direct.php  
✅ El formulario usa método POST a BASE_URL/logout
✅ Ruta POST /logout está definida en el router
✅ AuthController::logout() destruye la sesión correctamente
✅ Se establece mensaje de éxito "Sesión cerrada correctamente"

## Cómo Probar

1. Inicia sesión en la aplicación
2. Haz clic en tu nombre de usuario (arriba a la derecha)
3. Selecciona "Cerrar Sesión" del menú desplegable
4. Deberías ser redirigido a la página principal
5. Verás el mensaje: "Sesión cerrada correctamente"
6. **No debe aparecer error 403**

## Flujo Correcto Ahora

```
Usuario hace clic en "Cerrar Sesión"
    ↓
Formulario POST a BASE_URL/logout
    ↓
Router (public/index.php) captura la petición
    ↓
Router ejecuta AuthController::logout()
    ↓
AuthController limpia la sesión
    ↓
Redirección a página principal con mensaje de éxito
```

## Notas Adicionales

- El archivo `public/logout_direct.php` sigue existiendo pero **ya no se usa en la aplicación principal**
- Sólo se referencia en archivos de prueba (`test_logout.php`, `logout_test.html`)
- Se puede eliminar si no se necesita para pruebas o debugging
- La solución actual es más robusta y sigue los patrones MVC de la aplicación
- La ruta alternativa `GET /public/logout` también está disponible si se necesita
