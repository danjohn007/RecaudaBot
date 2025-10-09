# 📋 Referencia Rápida - Dashboard y Estadísticas

## 🎯 Solución Implementada

Las gráficas del Dashboard ahora obtienen datos **directamente de las tablas fuente** en lugar de depender de la tabla `payments`.

---

## 📊 Tablas Fuente y Mapeo

### Property Taxes (Impuestos Prediales)

```sql
Tabla: property_taxes
Monto: total_amount
Estado pagado: status = 'paid'
Estado pendiente: status IN ('pending', 'overdue')
Fecha: paid_date
```

### Traffic Fines (Multas de Tránsito)

```sql
Tabla: traffic_fines
Monto: total_amount
Estado pagado: status = 'paid'
Estado pendiente: status = 'pending'
Fecha: paid_date
```

### Civic Fines (Multas Cívicas)

```sql
Tabla: civic_fines
Monto: total_amount
Estado pagado: status = 'paid'
Estado pendiente: status = 'pending'
Fecha: paid_date
```

### Business Licenses (Licencias de Funcionamiento)

```sql
Tabla: business_licenses
Monto: annual_fee
Estado pagado: status = 'approved'
Estado pendiente: status = 'pending'
Fecha: issue_date
```

---

## 🔧 Archivos Modificados

### 1. app/models/Payment.php

**Métodos modificados:**
- `getTotalRevenue($startDate = null, $endDate = null)`
- `getRevenueByType($startDate = null, $endDate = null)`

**Cambio principal:**
- Consulta directa a tablas fuente (property_taxes, traffic_fines, civic_fines, business_licenses)
- Suma de montos de cada tabla según su estado

### 2. app/controllers/AdminController.php

**Método modificado:**
- `getStatistics()` (líneas 110-130 aprox.)

**Cambios principales:**
- Consultas a tablas fuente en lugar de payments
- Agregados campos `pending_traffic_fine_amount` y `pending_civic_fine_amount`

---

## 📈 Variables de Estadísticas

El método `getStatistics()` retorna un array con estas claves:

### Recaudación

```php
'total_revenue'       // Suma total de todas las fuentes
'month_revenue'       // Recaudación del mes actual
'year_revenue'        // Recaudación del año actual
'revenue_by_type'     // Array con recaudación por tipo
'monthly_trend'       // Array con últimos 6 meses
```

### Por Tipo (Completados)

```php
'property_tax_count'   // Cantidad de impuestos pagados
'property_tax_amount'  // Monto de impuestos pagados
'traffic_fine_count'   // Cantidad de multas tránsito pagadas
'traffic_fine_amount'  // Monto de multas tránsito pagadas
'civic_fine_count'     // Cantidad de multas cívicas pagadas
'civic_fine_amount'    // Monto de multas cívicas pagadas
'license_count'        // Cantidad de licencias aprobadas
'license_amount'       // Monto de licencias aprobadas
```

### Pendientes

```php
'pending_taxes'                   // Cantidad de impuestos pendientes
'pending_taxes_amount'            // Monto de impuestos pendientes
'pending_property_tax_count'      // Cantidad detallada
'pending_property_tax_amount'     // Monto detallado

'pending_traffic_fines'           // Cantidad de multas tránsito pendientes
'pending_traffic_fines_amount'    // Monto de multas tránsito pendientes
'pending_traffic_fine_count'      // Cantidad detallada
'pending_traffic_fine_amount'     // Monto detallado

'pending_civic_fines'             // Cantidad de multas cívicas pendientes
'pending_civic_fines_amount'      // Monto de multas cívicas pendientes
'pending_civic_fine_count'        // Cantidad detallada
'pending_civic_fine_amount'       // Monto detallado

'pending_licenses'                // Cantidad de licencias pendientes
'pending_licenses_amount'         // Monto de licencias pendientes
```

---

## 🧪 SQL de Verificación

### Verificar Recaudación Total

```sql
-- Property taxes
SELECT COALESCE(SUM(total_amount), 0) FROM property_taxes WHERE status = 'paid';

-- Traffic fines
SELECT COALESCE(SUM(total_amount), 0) FROM traffic_fines WHERE status = 'paid';

-- Civic fines
SELECT COALESCE(SUM(total_amount), 0) FROM civic_fines WHERE status = 'paid';

-- Business licenses
SELECT COALESCE(SUM(annual_fee), 0) FROM business_licenses WHERE status = 'approved';
```

### Verificar Pendientes

```sql
-- Pending property taxes
SELECT COUNT(*), COALESCE(SUM(total_amount), 0) 
FROM property_taxes 
WHERE status IN ('pending', 'overdue');

-- Pending traffic fines
SELECT COUNT(*), COALESCE(SUM(total_amount), 0) 
FROM traffic_fines 
WHERE status = 'pending';

-- Pending civic fines
SELECT COUNT(*), COALESCE(SUM(total_amount), 0) 
FROM civic_fines 
WHERE status = 'pending';

-- Pending licenses
SELECT COUNT(*), COALESCE(SUM(annual_fee), 0) 
FROM business_licenses 
WHERE status = 'pending';
```

---

## 🎨 Gráficas del Dashboard

### /admin (Dashboard Administrativo)

1. **Gráfica de Barras**: Recaudación por Concepto (mes actual)
   - Usa: `$stats['revenue_by_type']`
   - Muestra: Impuesto Predial, Multas Tránsito, Multas Cívicas, Licencias

2. **Gráfica de Dona**: Pagos Pendientes por Concepto
   - Usa: `$stats['pending_taxes_amount']`, `$stats['pending_traffic_fines_amount']`, etc.
   - Muestra: Distribución de montos pendientes

3. **Gráfica de Línea**: Tendencia de Recaudación (últimos 6 meses)
   - Usa: `$stats['monthly_trend']`
   - Muestra: Evolución mensual de recaudación

### /admin/estadisticas (Estadísticas del Sistema)

1. **Gráfica de Línea**: Recaudación por Mes
   - Usa: `$stats['monthly_trend']`

2. **Gráfica de Dona**: Recaudación por Tipo
   - Usa: `$stats['revenue_by_type']`

3. **Gráfica de Barras**: Registro de Usuarios
   - Usa: `$stats['user_registration_trend']`

4. **Tabla**: Top 5 Tipos de Pago
   - Usa: Valores individuales como `$stats['property_tax_count']`

5. **Tabla**: Pagos Pendientes
   - Usa: Valores pendientes como `$stats['pending_property_tax_count']`

---

## ⚡ Comandos Útiles

### Verificar Sintaxis PHP

```bash
php -l app/models/Payment.php
php -l app/controllers/AdminController.php
```

### Cargar Datos de Ejemplo

```bash
mysql -u root -p recaudabot < assets/sql/schema.sql
mysql -u root -p recaudabot < assets/sql/comprehensive_sample_data.sql
```

### Verificar Datos en DB

```bash
mysql -u root -p recaudabot -e "SELECT COUNT(*) FROM property_taxes WHERE status = 'paid'"
mysql -u root -p recaudabot -e "SELECT COUNT(*) FROM traffic_fines WHERE status = 'paid'"
mysql -u root -p recaudabot -e "SELECT COUNT(*) FROM civic_fines WHERE status = 'paid'"
mysql -u root -p recaudabot -e "SELECT COUNT(*) FROM business_licenses WHERE status = 'approved'"
```

---

## 🐛 Troubleshooting

### Gráficas siguen vacías

1. Verificar que hay datos en las tablas fuente:
   ```sql
   SELECT 'property_taxes' as tabla, COUNT(*) as registros FROM property_taxes WHERE status = 'paid'
   UNION ALL
   SELECT 'traffic_fines', COUNT(*) FROM traffic_fines WHERE status = 'paid'
   UNION ALL
   SELECT 'civic_fines', COUNT(*) FROM civic_fines WHERE status = 'paid'
   UNION ALL
   SELECT 'business_licenses', COUNT(*) FROM business_licenses WHERE status = 'approved';
   ```

2. Verificar conexión a BD en `config/config.php`

3. Revisar errores PHP en `/var/log/apache2/error.log` o logs del servidor

### Error de sintaxis SQL

1. Verificar nombres de columnas en schema.sql
2. Verificar estados en las tablas
3. Probar queries directamente en MySQL

### Montos incorrectos

1. Verificar columnas de monto:
   - `total_amount` para taxes y fines
   - `annual_fee` para licenses

2. Verificar estados:
   - `paid` para taxes y fines
   - `approved` para licenses

---

## 📚 Documentación Relacionada

- `DASHBOARD_GRAPHS_FIX.md` - Documentación completa del fix
- `QUERY_COMPARISON.md` - Comparación de queries antes/después
- `SOLUCION_GRAFICAS_DASHBOARD.md` - Documentación original
- `assets/sql/schema.sql` - Esquema de base de datos
- `assets/sql/comprehensive_sample_data.sql` - Datos de ejemplo

---

## 🔗 Enlaces Rápidos en el Código

**Payment Model:**
- Líneas 29-83: `getTotalRevenue()`
- Líneas 85-167: `getRevenueByType()`

**Admin Controller:**
- Líneas 34-212: `getStatistics()`
- Líneas 110-128: Estadísticas por tipo (modificado)

**Dashboard View:**
- `app/views/admin/dashboard.php`
- Líneas 204-342: Código JavaScript de gráficas

**Statistics View:**
- `app/views/admin/statistics.php`
- Líneas 190-306: Código JavaScript de gráficas
