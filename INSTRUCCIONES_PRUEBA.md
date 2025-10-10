# 🧪 Instrucciones de Prueba - Corrección de Routing

Este documento proporciona instrucciones detalladas para verificar que la corrección del error 404 funciona correctamente.

## 📋 Pre-requisitos

- Acceso a la URL del sistema: `https://recaudabot.digital/daniel/recaudabot`
- Navegador web moderno (Chrome, Firefox, Safari, Edge)
- Credenciales de usuario para pruebas de login

---

## 🔍 Prueba 1: Verificación de Configuración

### Paso 1: Acceder a la página de prueba
1. Abre tu navegador
2. Visita: `https://recaudabot.digital/daniel/recaudabot/public/test_routing.php`
3. Verifica que la página cargue correctamente

### Qué Verificar:
- ✅ **BASE_URL** debe ser: `https://recaudabot.digital/daniel/recaudabot`
- ✅ **PUBLIC_URL** debe ser: `https://recaudabot.digital/daniel/recaudabot/public`
- ✅ Los enlaces de prueba deben funcionar (no 404)
- ✅ Los recursos CSS y JS deben existir

### Resultado Esperado:
```
✓ BASE_URL configurado correctamente
✓ PUBLIC_URL configurado correctamente
✓ Todos los enlaces funcionan
✓ Recursos estáticos cargando correctamente
```

---

## 🔐 Prueba 2: Flujo de Login Completo

### Paso 1: Acceder a la página de login
1. Visita: `https://recaudabot.digital/daniel/recaudabot/login`
2. Verifica que la página cargue sin error 404
3. Debes ver el formulario de login con:
   - Campo de usuario/email
   - Campo de contraseña
   - Botón "Iniciar Sesión"

### Paso 2: Inspeccionar el formulario (Opcional)
1. Presiona F12 para abrir las herramientas de desarrollador
2. En la pestaña "Elements" o "Inspector", busca el elemento `<form>`
3. Verifica que el atributo `action` sea:
   ```html
   action="https://recaudabot.digital/daniel/recaudabot/login"
   ```
   **No debe incluir `/public`**

### Paso 3: Intentar iniciar sesión
1. Ingresa un usuario válido o de prueba
2. Ingresa la contraseña
3. Haz clic en "Iniciar Sesión"

### Resultado Esperado:
- ✅ El formulario se envía correctamente (no error 404)
- ✅ Si las credenciales son correctas, eres redirigido a:
  - `/admin` (si eres administrador)
  - `/perfil` (si eres usuario regular)
- ✅ Si las credenciales son incorrectas, ves un mensaje de error pero NO un 404

### ❌ Resultado Incorrecto (Antes de la corrección):
- ❌ Error 404: Página no encontrada
- ❌ URL en el navegador: `https://recaudabot.digital/daniel/recaudabot/public/login`

---

## 📝 Prueba 3: Flujo de Registro

### Paso 1: Acceder a la página de registro
1. Visita: `https://recaudabot.digital/daniel/recaudabot/register`
2. Verifica que la página cargue sin error 404

### Paso 2: Verificar enlaces
1. Haz clic en el enlace "¿Ya tienes cuenta? Inicia sesión aquí"
2. Debes ser redirigido a `/login` (sin error 404)

### Paso 3: Intentar registrarse (Opcional)
1. Llena todos los campos del formulario
2. Acepta los términos y condiciones
3. Completa el CAPTCHA
4. Haz clic en "Registrarse"

### Resultado Esperado:
- ✅ El formulario se envía correctamente (no error 404)
- ✅ Si el registro es exitoso, eres redirigido a `/login`
- ✅ Ves un mensaje de éxito: "Registro exitoso. Por favor, inicie sesión."

---

## 🔄 Prueba 4: Navegación General

### Enlaces a Probar:
Haz clic en cada uno de estos enlaces del menú de navegación:

1. **Logo "RecaudaBot"**
   - Debe llevar a: `/` (página de inicio)
   - ✅ No debe mostrar error 404

2. **Impuesto Predial**
   - Debe llevar a: `/impuesto-predial`
   - ✅ No debe mostrar error 404

3. **Licencias**
   - Debe llevar a: `/licencias`
   - ✅ No debe mostrar error 404

4. **Multas Tránsito**
   - Debe llevar a: `/multas-transito`
   - ✅ No debe mostrar error 404

5. **Multas Cívicas**
   - Debe llevar a: `/multas-civicas`
   - ✅ No debe mostrar error 404

6. **Orientación**
   - Debe llevar a: `/orientacion`
   - ✅ No debe mostrar error 404

### Resultado Esperado:
- ✅ Todos los enlaces funcionan correctamente
- ✅ Ninguna página muestra error 404
- ✅ Las URLs no incluyen `/public` en la ruta

---

## 🎨 Prueba 5: Recursos Estáticos

### Verificar que CSS y JavaScript cargan correctamente:

1. Abre cualquier página del sistema
2. Presiona F12 para abrir las herramientas de desarrollador
3. Ve a la pestaña "Network" o "Red"
4. Recarga la página (Ctrl+R o Cmd+R)
5. Verifica que estos recursos carguen con código 200:
   - `public/css/style.css` - ✅ 200 OK
   - `public/js/main.js` - ✅ 200 OK
   - Bootstrap CSS (CDN) - ✅ 200 OK
   - Bootstrap JS (CDN) - ✅ 200 OK

### Resultado Esperado:
- ✅ Todos los recursos CSS y JS cargan correctamente
- ✅ La página se ve con estilos apropiados
- ✅ Los menús desplegables funcionan (JavaScript activo)

---

## 🔧 Prueba 6: Redirecciones (Para Usuarios Logueados)

### Si tienes una sesión activa:

1. Intenta acceder a: `/login`
   - ✅ Debes ser redirigido automáticamente a `/perfil`
   - ✅ No error 404

2. Intenta acceder a: `/register`
   - ✅ Debes ser redirigido automáticamente a `/perfil`
   - ✅ No error 404

3. Intenta acceder a: `/perfil` (siendo usuario regular)
   - ✅ Debes ver tu página de perfil
   - ✅ No error 404

4. Intenta acceder a: `/admin` (siendo administrador)
   - ✅ Debes ver el dashboard administrativo
   - ✅ No error 404

### Resultado Esperado:
- ✅ Todas las redirecciones funcionan correctamente
- ✅ No hay errores 404 en el proceso

---

## 📊 Checklist de Verificación

Marca cada item después de probarlo:

### Configuración Básica
- [ ] Página de test (`/public/test_routing.php`) carga correctamente
- [ ] BASE_URL está configurado correctamente
- [ ] PUBLIC_URL está configurado correctamente

### Funcionalidad de Login
- [ ] Página de login (`/login`) carga sin error 404
- [ ] Formulario de login apunta a la URL correcta (sin `/public`)
- [ ] Login con credenciales correctas funciona
- [ ] Login con credenciales incorrectas muestra error (no 404)
- [ ] Redirección post-login funciona

### Funcionalidad de Registro
- [ ] Página de registro (`/register`) carga sin error 404
- [ ] Formulario de registro apunta a la URL correcta (sin `/public`)
- [ ] Registro funciona correctamente
- [ ] Enlace a login desde registro funciona

### Navegación
- [ ] Todos los enlaces del menú funcionan
- [ ] No hay errores 404 al navegar
- [ ] Las URLs no incluyen `/public` (excepto para recursos estáticos)

### Recursos Estáticos
- [ ] CSS carga correctamente
- [ ] JavaScript carga correctamente
- [ ] Las páginas se ven con estilos apropiados
- [ ] Los componentes interactivos funcionan

---

## 🆘 Solución de Problemas

### Si aún ves error 404:

1. **Verifica que los archivos estén actualizados:**
   ```bash
   git pull origin main
   ```

2. **Limpia la caché del navegador:**
   - Chrome: Ctrl+Shift+Delete
   - Firefox: Ctrl+Shift+Delete
   - Safari: Cmd+Option+E

3. **Verifica la configuración de URLs:**
   - Visita `/public/test_routing.php`
   - Asegúrate de que BASE_URL no incluya `/public`

4. **Verifica que el .htaccess esté actualizado:**
   - Revisa que `.htaccess` no tenga rutas hardcoded
   - Asegúrate de que el servidor lee el `.htaccess`

5. **Contacta al equipo de desarrollo:**
   - Proporciona la URL exacta donde ves el error 404
   - Incluye capturas de pantalla si es posible

---

## ✅ Criterios de Éxito

La corrección es exitosa si:

1. ✅ Puedes iniciar sesión sin recibir error 404
2. ✅ Puedes registrarte sin recibir error 404
3. ✅ Todos los enlaces de navegación funcionan
4. ✅ Las redirecciones post-login funcionan
5. ✅ Los recursos CSS y JS cargan correctamente
6. ✅ Las URLs internas no incluyen `/public` en la ruta
7. ✅ El sistema funciona en cualquier estructura de carpetas

---

## 📞 Soporte

Si encuentras algún problema durante las pruebas, por favor documenta:
- URL exacta donde ocurre el error
- Pasos para reproducir el problema
- Captura de pantalla del error
- Mensajes en la consola del navegador (F12 > Console)

Esto ayudará a identificar y resolver cualquier problema restante.
