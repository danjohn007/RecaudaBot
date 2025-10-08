# Guía de Pruebas - RecaudaBot

## 📋 Lista de Verificación para Pruebas

### ✅ 1. Pruebas de Registro de Usuario

#### 1.1 CAPTCHA
- [ ] Abrir `/register`
- [ ] Verificar que aparece un CAPTCHA con suma de 2 números
- [ ] Los números deben ser aleatorios (1-20)
- [ ] El campo de respuesta debe estar vacío
- [ ] Intentar registrar con respuesta incorrecta
- [ ] Verificar mensaje de error
- [ ] Verificar que se genera nuevo CAPTCHA
- [ ] Intentar registrar con respuesta correcta
- [ ] Verificar que permite continuar

#### 1.2 Términos y Condiciones
- [ ] Abrir `/register`
- [ ] Hacer click en "términos y condiciones"
- [ ] Verificar que se abre modal
- [ ] Verificar que el modal tiene 8 secciones
- [ ] Verificar scroll en el modal
- [ ] Cerrar modal con botón "Cerrar"
- [ ] Cerrar modal con X
- [ ] Verificar que checkbox de términos existe

#### 1.3 Validación Completa
```bash
# Caso 1: Registro exitoso
Email: test@example.com
Nombre: Juan Pérez
CURP: PERJ900101HDFRLL01 (18 chars)
Teléfono: 5551234567 (10 dígitos)
Contraseña: Password123
Confirmar: Password123
Términos: ✓
CAPTCHA: [Respuesta correcta]
Resultado esperado: ✅ Registro exitoso

# Caso 2: CAPTCHA incorrecto
CAPTCHA: [Respuesta incorrecta]
Resultado esperado: ❌ Error "Verificación incorrecta"

# Caso 3: Contraseñas no coinciden
Contraseña: Password123
Confirmar: Password456
Resultado esperado: ❌ Error "Contraseñas no coinciden"

# Caso 4: CURP duplicado
CURP: [Ya existente en BD]
Resultado esperado: ❌ Error "CURP ya registrado"
```

---

### ✅ 2. Pruebas de Listado de Predios

#### 2.1 Visualización
- [ ] Login como admin
- [ ] Ir a `/admin/reportes/predios`
- [ ] Verificar que aparecen 4 botones por cada predio:
  - [ ] Ver (ícono: eye, color: info)
  - [ ] Procesar (ícono: check-circle, color: success)
  - [ ] Editar (ícono: pencil, color: warning)
  - [ ] Suspender (ícono: x-circle, color: danger)

#### 2.2 Botón "Ver Detalles"
- [ ] Click en botón "Ver" de un predio
- [ ] Verificar redirección a `/admin/predios/ver/{id}`
- [ ] Verificar que muestra:
  - [ ] Clave catastral
  - [ ] Propietario
  - [ ] Dirección
  - [ ] Tipo de zona
  - [ ] Estado (badge)
  - [ ] Área de terreno
  - [ ] Área de construcción
  - [ ] Valor catastral
- [ ] Verificar botón "Regresar"

#### 2.3 Botón "Procesar"
- [ ] Click en botón "Procesar"
- [ ] Verificar mensaje: "Función de procesamiento en desarrollo"
- [ ] Verificar redirección a listado

#### 2.4 Botón "Editar"
- [ ] Click en botón "Editar"
- [ ] Verificar mensaje: "Función de edición en desarrollo"
- [ ] Verificar redirección a listado

#### 2.5 Botón "Suspender"
- [ ] Click en botón "Suspender"
- [ ] Verificar confirmación JavaScript: "¿Está seguro...?"
- [ ] Cancelar → No debe cambiar nada
- [ ] Click nuevamente y Aceptar
- [ ] Verificar mensaje: "Predio suspendido correctamente"
- [ ] Verificar en BD que status = 'suspended'
- [ ] Verificar que botón "Suspender" desaparece

---

### ✅ 3. Pruebas de Listado de Licencias

#### 3.1 Visualización
- [ ] Ir a `/admin/reportes/licencias`
- [ ] Verificar que aparecen hasta 4 botones por licencia:
  - [ ] Ver (siempre)
  - [ ] Procesar (solo si status='pending')
  - [ ] Editar (siempre)
  - [ ] Suspender (solo si status≠'expired')

#### 3.2 Botón "Ver Detalles"
- [ ] Click en botón "Ver" de una licencia
- [ ] Verificar redirección a `/admin/licencias/ver/{id}`
- [ ] Verificar que muestra:
  - [ ] ID de licencia
  - [ ] Nombre del negocio
  - [ ] Propietario
  - [ ] Estado (badge con color)
  - [ ] Dirección del negocio
  - [ ] Giro del negocio
  - [ ] Cuota anual
  - [ ] Fecha de solicitud
  - [ ] Fecha de vencimiento
- [ ] Verificar botón "Regresar"

#### 3.3 Botón "Procesar" (Solo Pending)
- [ ] Buscar licencia con status='pending'
- [ ] Verificar que botón "Procesar" existe
- [ ] Click en botón
- [ ] Verificar mensaje: "Función de procesamiento en desarrollo"
- [ ] Buscar licencia con status='approved'
- [ ] Verificar que botón "Procesar" NO existe

#### 3.4 Botón "Editar"
- [ ] Click en botón "Editar"
- [ ] Verificar mensaje: "Función de edición en desarrollo"
- [ ] Verificar redirección a listado

#### 3.5 Botón "Suspender"
- [ ] Click en botón "Suspender" de licencia no expirada
- [ ] Verificar confirmación JavaScript
- [ ] Aceptar
- [ ] Verificar mensaje: "Licencia suspendida correctamente"
- [ ] Verificar en BD que status = 'suspended'
- [ ] Buscar licencia con status='expired'
- [ ] Verificar que botón "Suspender" NO existe

---

### ✅ 4. Pruebas de Listado de Multas

#### 4.1 Visualización
- [ ] Ir a `/admin/reportes/multas`
- [ ] Verificar que aparecen hasta 4 botones por multa:
  - [ ] Ver Detalles (siempre)
  - [ ] Procesar (solo si status='pending')
  - [ ] Editar (siempre)
  - [ ] Suspender (solo si status='pending')

#### 4.2 Botón "Ver Detalles"
- [ ] Click en botón "Ver"
- [ ] Verificar que redirige a página de detalle correcta
- [ ] Para multa de tránsito: `/multas-transito/detalle/{id}`
- [ ] Para multa cívica: `/multas-civicas/detalle/{id}`

#### 4.3 Botón "Procesar" (Solo Pending)
- [ ] Buscar multa con status='pending'
- [ ] Verificar que botón "Procesar" existe
- [ ] Click en botón
- [ ] Verificar mensaje: "Función de procesamiento en desarrollo"
- [ ] Verificar que incluye parámetro ?type= en URL

#### 4.4 Botón "Editar"
- [ ] Click en botón "Editar"
- [ ] Verificar mensaje: "Función de edición en desarrollo"
- [ ] Verificar que incluye parámetro ?type= en URL

#### 4.5 Botón "Suspender" (Solo Pending)
- [ ] Click en botón "Suspender" de multa pending
- [ ] Verificar confirmación JavaScript
- [ ] Aceptar
- [ ] Verificar mensaje: "Multa suspendida correctamente"
- [ ] Verificar en BD:
  - [ ] Si traffic: traffic_fines.status = 'cancelled'
  - [ ] Si civic: civic_fines.status = 'cancelled'
- [ ] Buscar multa con status='paid'
- [ ] Verificar que botón "Suspender" NO existe

---

### ✅ 5. Pruebas de Dashboard Administrativo

#### 5.1 Tarjetas de Resumen
- [ ] Ir a `/admin`
- [ ] Verificar 4 tarjetas superiores:
  - [ ] Recaudación Total (con valor de BD)
  - [ ] Este Mes (con valor de BD)
  - [ ] Usuarios (con valor de BD)
  - [ ] Trámites Pendientes (con valor de BD)

#### 5.2 Gráfica 1: Recaudación por Concepto
- [ ] Verificar que aparece gráfica de barras
- [ ] Verificar que tiene datos (no vacía)
- [ ] Verificar etiquetas:
  - [ ] Impuesto Predial
  - [ ] Licencias
  - [ ] Multas Tránsito
  - [ ] Multas Cívicas
- [ ] Hover sobre barras → Ver tooltip con monto
- [ ] Comparar con datos de BD (tabla payments)

#### 5.3 Gráfica 2: Pagos Pendientes
- [ ] Verificar que aparece gráfica de dona
- [ ] Verificar que tiene datos (no vacía)
- [ ] Verificar 4 segmentos:
  - [ ] Impuestos Prediales
  - [ ] Multas de Tránsito
  - [ ] Multas Cívicas
  - [ ] Licencias
- [ ] Hover sobre segmentos → Ver tooltip con monto
- [ ] Verificar colores diferentes por tipo

#### 5.4 Gráfica 3: Tendencia de Recaudación
- [ ] Verificar que aparece gráfica de línea
- [ ] Verificar 6 puntos de datos (últimos 6 meses)
- [ ] Verificar etiquetas en eje X:
  - [ ] Mes -5, Mes -4, Mes -3, Mes -2, Mes -1, Mes Actual
- [ ] Hover sobre línea → Ver tooltip con monto
- [ ] Comparar con datos de BD (últimos 6 meses)

#### 5.5 Actividad Reciente
- [ ] Verificar sección "Actividad Reciente"
- [ ] Verificar que muestra hasta 10 actividades
- [ ] Verificar tipos de actividad:
  - [ ] Pagos (ícono: cash, color: verde)
  - [ ] Registros (ícono: person-plus, color: azul)
  - [ ] Licencias (ícono: file-text, color: amarillo)
- [ ] Verificar formato de fecha: dd/mm/YYYY HH:mm

---

### ✅ 6. Pruebas de Estadísticas del Sistema

#### 6.1 Tarjetas de Resumen
- [ ] Ir a `/admin/estadisticas`
- [ ] Verificar 4 tarjetas:
  - [ ] Recaudación Total
  - [ ] Este Mes
  - [ ] Usuarios Activos
  - [ ] Transacciones Hoy (NUEVO)

#### 6.2 Gráfica 1: Recaudación por Mes
- [ ] Verificar gráfica de línea
- [ ] Verificar 6 puntos de datos
- [ ] Verificar que coincide con datos de BD

#### 6.3 Gráfica 2: Recaudación por Tipo
- [ ] Verificar gráfica de dona
- [ ] Verificar 4 segmentos con datos reales
- [ ] Comparar con tabla "Top 5 Tipos de Pago"

#### 6.4 Gráfica 3: Registro de Usuarios (ACTUALIZADA)
- [ ] Verificar gráfica de barras
- [ ] Verificar 6 barras (últimos 6 meses)
- [ ] Verificar que YA NO tiene datos hardcodeados
- [ ] Comparar manualmente con BD:
```sql
SELECT COUNT(*) FROM users 
WHERE role = 'citizen' 
AND MONTH(created_at) = [mes] 
AND YEAR(created_at) = [año]
```

#### 6.5 Tabla: Top 5 Tipos de Pago (ACTUALIZADA)
- [ ] Verificar tabla con 5 filas
- [ ] Verificar columnas: Tipo, Cantidad, Monto Total
- [ ] Verificar datos para:
  - [ ] Impuesto Predial
  - [ ] Multas de Tránsito
  - [ ] Multas Cívicas
  - [ ] Licencias
  - [ ] Otros
- [ ] Comparar con datos reales de BD (tabla payments)

#### 6.6 Tabla: Pagos Pendientes (ACTUALIZADA)
- [ ] Verificar tabla con 3 filas
- [ ] Verificar datos para:
  - [ ] Impuesto Predial (property_taxes)
  - [ ] Multas de Tránsito (traffic_fines)
  - [ ] Multas Cívicas (civic_fines)
- [ ] Comparar con datos reales de BD

---

### ✅ 7. Pruebas de Base de Datos

#### 7.1 Verificar Estructura
```sql
-- Verificar tablas existen
SHOW TABLES LIKE 'properties';
SHOW TABLES LIKE 'business_licenses';
SHOW TABLES LIKE 'traffic_fines';
SHOW TABLES LIKE 'civic_fines';
SHOW TABLES LIKE 'payments';
SHOW TABLES LIKE 'users';
```

#### 7.2 Verificar Datos de Prueba
```sql
-- Debe haber al menos algunos registros
SELECT COUNT(*) FROM properties;      -- > 0
SELECT COUNT(*) FROM business_licenses; -- > 0
SELECT COUNT(*) FROM traffic_fines;    -- > 0
SELECT COUNT(*) FROM civic_fines;      -- > 0
SELECT COUNT(*) FROM payments;         -- > 0
SELECT COUNT(*) FROM users WHERE role = 'citizen'; -- > 0
```

#### 7.3 Verificar Operaciones de Suspensión
```sql
-- Después de suspender un predio
SELECT status FROM properties WHERE id = [id_suspendido];
-- Debe retornar: 'suspended'

-- Después de suspender una licencia
SELECT status FROM business_licenses WHERE id = [id_suspendido];
-- Debe retornar: 'suspended'

-- Después de suspender una multa de tránsito
SELECT status FROM traffic_fines WHERE id = [id_suspendido];
-- Debe retornar: 'cancelled'

-- Después de suspender una multa cívica
SELECT status FROM civic_fines WHERE id = [id_suspendido];
-- Debe retornar: 'cancelled'
```

---

### ✅ 8. Pruebas de Seguridad

#### 8.1 Control de Acceso
- [ ] Cerrar sesión
- [ ] Intentar acceder a `/admin/predios/ver/1`
- [ ] Debe redirigir a login
- [ ] Intentar acceder a `/admin/reportes/predios`
- [ ] Debe redirigir a login
- [ ] Login como ciudadano (no admin)
- [ ] Intentar acceder a rutas admin
- [ ] Debe mostrar error de permisos

#### 8.2 SQL Injection
```
# Intentar en campos de búsqueda:
' OR '1'='1
1'; DROP TABLE users; --
<script>alert('xss')</script>

Resultado esperado: ❌ Datos escapados correctamente
```

#### 8.3 XSS Prevention
```html
# Crear predio con nombre:
<script>alert('XSS')</script>

# Ver detalle del predio
Resultado esperado: ✅ Texto escapado, no ejecuta JavaScript
```

#### 8.4 CAPTCHA Bypass
- [ ] Intentar enviar formulario sin CAPTCHA
- [ ] Resultado esperado: ❌ Error "Verificación incorrecta"
- [ ] Intentar modificar valor hidden del CAPTCHA
- [ ] Enviar formulario
- [ ] Resultado esperado: ❌ Error "Verificación incorrecta"

---

### ✅ 9. Pruebas de Compatibilidad

#### 9.1 Navegadores
- [ ] Chrome (última versión)
- [ ] Firefox (última versión)
- [ ] Safari (si disponible)
- [ ] Edge (si disponible)

#### 9.2 Dispositivos
- [ ] Desktop (1920x1080)
- [ ] Tablet (768x1024)
- [ ] Móvil (375x667)

#### 9.3 Funcionalidades Responsive
- [ ] Modal de términos en móvil
- [ ] CAPTCHA legible en móvil
- [ ] Botones de acciones en móvil
- [ ] Gráficas adaptables
- [ ] Tablas con scroll horizontal

---

### ✅ 10. Pruebas de Rendimiento

#### 10.1 Carga de Páginas
- [ ] Dashboard: < 2 segundos
- [ ] Estadísticas: < 3 segundos
- [ ] Listados: < 2 segundos
- [ ] Detalles: < 1 segundo

#### 10.2 Consultas a BD
```sql
-- Verificar que consultas no son lentas
EXPLAIN SELECT ... FROM payments ...;
EXPLAIN SELECT ... FROM properties ...;

-- Verificar índices
SHOW INDEX FROM payments;
SHOW INDEX FROM properties;
```

---

## 📊 Checklist de Validación Final

### Funcionalidad Completa:
- [ ] ✅ Todos los botones de acciones funcionan
- [ ] ✅ Todas las gráficas muestran datos de BD
- [ ] ✅ CAPTCHA funciona en cliente y servidor
- [ ] ✅ Términos y condiciones visibles
- [ ] ✅ Operaciones de suspensión funcionan
- [ ] ✅ Vistas de detalle muestran información completa

### Seguridad:
- [ ] ✅ Control de acceso implementado
- [ ] ✅ Validación servidor en registro
- [ ] ✅ Prepared statements en consultas
- [ ] ✅ Escape de HTML en salidas
- [ ] ✅ Confirmaciones en acciones destructivas

### UX/UI:
- [ ] ✅ Diseño responsive
- [ ] ✅ Mensajes claros de error/éxito
- [ ] ✅ Iconos apropiados por acción
- [ ] ✅ Colores por tipo de estado
- [ ] ✅ Tooltips en botones

### Documentación:
- [ ] ✅ IMPLEMENTATION_COMPLETE.md
- [ ] ✅ VISUAL_CHANGES_SUMMARY.md
- [ ] ✅ TESTING_GUIDE.md (este archivo)
- [ ] ✅ Comentarios en código

---

## 🐛 Reporte de Bugs

Si encuentra algún problema durante las pruebas, documentarlo así:

```
**Bug #1**
Ubicación: /admin/predios/ver/123
Descripción: [Descripción del problema]
Pasos para reproducir:
1. [Paso 1]
2. [Paso 2]
3. [Paso 3]
Resultado esperado: [Lo que debería pasar]
Resultado actual: [Lo que pasa]
Severidad: Alta/Media/Baja
```

---

*Guía de pruebas completa*
*Versión: 1.0*
*Fecha: $(date +"%Y-%m-%d")*
