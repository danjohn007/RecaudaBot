# Datos de Ejemplo Comprehensivos - RecaudaBot

## 📋 Descripción

Este archivo contiene datos de ejemplo extensivos para el sistema RecaudaBot, diseñados específicamente para garantizar que todas las gráficas del **Dashboard Administrativo** y **Estadísticas del Sistema** muestren información correctamente.

## 📁 Archivos

### `comprehensive_sample_data.sql`
Archivo SQL principal con datos comprehensivos para todos los módulos del sistema.

**Contenido generado:**
- ✅ **17 usuarios** (1 admin, 1 área municipal, 15 ciudadanos)
  - Distribuidos en los últimos 6 meses para gráfica de registro de usuarios
  - Password para todos: `password123`

- ✅ **10 propiedades** con diferentes características
  - Residenciales y comerciales
  - Con valores catastrales variados

- ✅ **60 impuestos prediales**
  - Distribuidos en 6 meses
  - Estados: pagado (70%), pendiente (20%), vencido (10%)
  - Con descuentos e intereses aplicados

- ✅ **23 multas de tránsito**
  - Distribuidas en 6 meses (3-5 por mes)
  - Estados: pagado (60%), pendiente (40%)
  - Varios tipos de infracciones

- ✅ **16 multas cívicas**
  - Distribuidas en 6 meses (2-3 por mes)
  - Estados: pagado (50%), pendiente (50%)
  - Diferentes tipos de faltas

- ✅ **8 licencias de funcionamiento**
  - Estados: aprobadas (70%), pendientes (20%), rechazadas (10%)
  - Diferentes tipos de negocios

- ✅ **75+ pagos completados**
  - Distribuidos en los últimos 6 meses
  - Todos los tipos de pago (impuestos, multas, licencias)
  - Diferentes métodos de pago (tarjeta, SPEI, OXXO, efectivo)

## 🎯 Propósito

Este conjunto de datos garantiza que las siguientes gráficas funcionen correctamente:

### Dashboard Administrativo (`/admin`)
1. **Gráfica de Barras**: Recaudación por Concepto (mes actual)
2. **Gráfica de Dona**: Distribución de Obligaciones Pendientes
3. **Gráfica de Línea**: Tendencia de Recaudación (últimos 6 meses)

### Estadísticas del Sistema (`/admin/estadisticas`)
1. **Gráfica de Línea**: Registro de Usuarios (últimos 6 meses)
2. **Tablas de Resumen**: Contadores por tipo de pago
3. **Tablas de Pendientes**: Montos y cantidades pendientes

## 🚀 Instalación

### Opción 1: Instalación Completa (Recomendada para desarrollo/pruebas)

```bash
# 1. Crear la base de datos y tablas
mysql -u root -p < assets/sql/schema.sql

# 2. Cargar los datos de ejemplo comprehensivos
mysql -u root -p recaudabot < assets/sql/comprehensive_sample_data.sql
```

### Opción 2: Desde MySQL Workbench o phpMyAdmin

1. Abrir MySQL Workbench o phpMyAdmin
2. Seleccionar la base de datos `recaudabot`
3. Ejecutar el archivo `comprehensive_sample_data.sql`

### Opción 3: Línea por línea

```sql
USE recaudabot;
SOURCE /ruta/completa/assets/sql/comprehensive_sample_data.sql;
```

## ⚠️ ADVERTENCIAS

### IMPORTANTE: Este script ELIMINA todos los datos existentes

El script incluye comandos `TRUNCATE TABLE` que borran todos los datos de las siguientes tablas:
- users
- properties
- property_taxes
- traffic_fines
- civic_fines
- business_licenses
- payments
- receipts
- appointments
- notifications
- audit_log

**NO ejecutar este script en un ambiente de producción con datos reales.**

### Recomendaciones

1. ✅ Usar SOLO en ambientes de desarrollo/pruebas
2. ✅ Hacer backup antes de ejecutar si tiene datos importantes
3. ✅ Revisar el script antes de ejecutar
4. ❌ NUNCA ejecutar en producción

## 👤 Usuarios de Prueba

Después de cargar los datos, puede iniciar sesión con:

### Administrador
- **Usuario**: `admin`
- **Email**: `admin@municipio.gob.mx`
- **Password**: `password123`
- **Rol**: Administrador

### Área Municipal
- **Usuario**: `tesoreria`
- **Email**: `tesoreria@municipio.gob.mx`
- **Password**: `password123`
- **Rol**: Área Municipal

### Ciudadanos (ejemplos)
- **Usuario**: `jperez` / **Email**: `jperez@email.com` / **Password**: `password123`
- **Usuario**: `mlopez` / **Email**: `mlopez@email.com` / **Password**: `password123`
- **Usuario**: `cgonzalez` / **Email**: `cgonzalez@email.com` / **Password**: `password123`

## 📊 Verificación

Después de cargar los datos, puede verificar con estas consultas:

```sql
-- Ver resumen de datos cargados
SELECT 'Users' AS Table_Name, COUNT(*) AS Total FROM users
UNION ALL
SELECT 'Properties', COUNT(*) FROM properties
UNION ALL
SELECT 'Property Taxes', COUNT(*) FROM property_taxes
UNION ALL
SELECT 'Traffic Fines', COUNT(*) FROM traffic_fines
UNION ALL
SELECT 'Civic Fines', COUNT(*) FROM civic_fines
UNION ALL
SELECT 'Business Licenses', COUNT(*) FROM business_licenses
UNION ALL
SELECT 'Payments', COUNT(*) FROM payments;

-- Ver recaudación total
SELECT 
    SUM(amount) AS Total_Revenue,
    COUNT(*) AS Total_Payments
FROM payments 
WHERE status = 'completed';

-- Ver distribución de pagos por tipo
SELECT 
    payment_type,
    COUNT(*) AS Count,
    SUM(amount) AS Total_Amount
FROM payments 
WHERE status = 'completed'
GROUP BY payment_type;
```

## 🔄 Regenerar los Datos

Si necesita regenerar los datos con diferentes valores aleatorios:

```bash
# Ejecutar el script Python generador
python3 /tmp/generate_sql.py

# Luego importar el SQL generado
mysql -u root -p recaudabot < assets/sql/comprehensive_sample_data.sql
```

## 📝 Notas Adicionales

- Los datos son generados aleatoriamente pero siguiendo patrones realistas
- Las fechas están distribuidas en los últimos 6 meses
- Los montos están en rangos razonables para cada tipo de pago
- Los estados (pagado/pendiente/vencido) siguen distribuciones realistas
- Todos los datos relacionales (foreign keys) son consistentes

## 🆘 Soporte

Si las gráficas aún aparecen vacías después de cargar estos datos:

1. Verificar que los datos se cargaron correctamente (usar consultas de verificación)
2. Verificar los logs de PHP para errores
3. Verificar la conexión a la base de datos en `config/database.php`
4. Limpiar caché del navegador
5. Revisar la consola del navegador para errores JavaScript

## 📅 Fecha de Generación

Los datos fueron generados considerando fechas relativas a la fecha actual del sistema, por lo que las gráficas de tendencia mostrarán información de los últimos 6 meses desde la fecha de ejecución del script.

---

**Última actualización**: Octubre 2024
**Versión**: 1.0
