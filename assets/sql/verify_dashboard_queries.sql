-- ============================================================================
-- Script de Verificación de Consultas del Dashboard
-- ============================================================================
-- Este script verifica que las consultas del dashboard funcionen correctamente
-- con los datos de ejemplo en la base de datos.
--
-- Uso:
-- mysql -u usuario -p nombre_base_de_datos < verify_dashboard_queries.sql
-- ============================================================================

SELECT '============================================' AS '';
SELECT 'VERIFICACIÓN DE CONSULTAS DEL DASHBOARD' AS '';
SELECT '============================================' AS '';

-- ============================================================================
-- 1. GRÁFICA DE BARRAS: Recaudación por Concepto (Mes Actual)
-- ============================================================================
SELECT '' AS '';
SELECT '1. RECAUDACIÓN POR CONCEPTO - MES ACTUAL' AS 'Gráfica';
SELECT '-------------------------------------------' AS '';

SELECT 
    CASE payment_type
        WHEN 'property_tax' THEN 'Impuesto Predial'
        WHEN 'business_license' THEN 'Licencias'
        WHEN 'traffic_fine' THEN 'Multas Tránsito'
        WHEN 'civic_fine' THEN 'Multas Cívicas'
        ELSE payment_type
    END AS 'Tipo de Pago',
    COUNT(*) AS 'Cantidad',
    CONCAT('$', FORMAT(SUM(amount), 2)) AS 'Total'
FROM payments 
WHERE status = 'completed'
  AND DATE(paid_at) BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())
GROUP BY payment_type
ORDER BY SUM(amount) DESC;

-- Mostrar mes actual para referencia
SELECT CONCAT('Mes actual: ', DATE_FORMAT(CURDATE(), '%Y-%m')) AS 'Información';

-- ============================================================================
-- 2. GRÁFICA DE DONA: Distribución de Obligaciones Pendientes
-- ============================================================================
SELECT '' AS '';
SELECT '2. OBLIGACIONES PENDIENTES POR TIPO' AS 'Gráfica';
SELECT '--------------------------------------' AS '';

SELECT 'Impuestos Prediales' AS 'Tipo',
       COUNT(*) AS 'Cantidad',
       CONCAT('$', FORMAT(COALESCE(SUM(total_amount), 0), 2)) AS 'Monto Pendiente'
FROM property_taxes 
WHERE status IN ('pending', 'overdue')

UNION ALL

SELECT 'Multas de Tránsito' AS 'Tipo',
       COUNT(*) AS 'Cantidad',
       CONCAT('$', FORMAT(COALESCE(SUM(total_amount), 0), 2)) AS 'Monto Pendiente'
FROM traffic_fines 
WHERE status = 'pending'

UNION ALL

SELECT 'Multas Cívicas' AS 'Tipo',
       COUNT(*) AS 'Cantidad',
       CONCAT('$', FORMAT(COALESCE(SUM(total_amount), 0), 2)) AS 'Monto Pendiente'
FROM civic_fines 
WHERE status = 'pending'

UNION ALL

SELECT 'Licencias' AS 'Tipo',
       COUNT(*) AS 'Cantidad',
       CONCAT('$', FORMAT(COALESCE(SUM(annual_fee), 0), 2)) AS 'Monto Pendiente'
FROM business_licenses 
WHERE status = 'pending';

-- ============================================================================
-- 3. GRÁFICA DE LÍNEA: Tendencia de Recaudación (Últimos 6 Meses)
-- ============================================================================
SELECT '' AS '';
SELECT '3. TENDENCIA DE RECAUDACIÓN - ÚLTIMOS 6 MESES' AS 'Gráfica';
SELECT '------------------------------------------------' AS '';

SELECT 
    DATE_FORMAT(paid_at, '%Y-%m') AS 'Mes',
    COUNT(*) AS 'Pagos',
    CONCAT('$', FORMAT(SUM(amount), 2)) AS 'Recaudación Total'
FROM payments 
WHERE status = 'completed'
  AND DATE(paid_at) >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 5 MONTH)
GROUP BY DATE_FORMAT(paid_at, '%Y-%m')
ORDER BY DATE_FORMAT(paid_at, '%Y-%m');

-- ============================================================================
-- 4. ESTADÍSTICAS: Pagos por Tipo (Todos los Tiempos)
-- ============================================================================
SELECT '' AS '';
SELECT '4. ESTADÍSTICAS DE PAGOS POR TIPO' AS 'Tabla';
SELECT '-----------------------------------' AS '';

SELECT 
    CASE payment_type
        WHEN 'property_tax' THEN 'Impuesto Predial'
        WHEN 'business_license' THEN 'Licencias'
        WHEN 'traffic_fine' THEN 'Multas de Tránsito'
        WHEN 'civic_fine' THEN 'Multas Cívicas'
        ELSE payment_type
    END AS 'Tipo de Pago',
    COUNT(*) AS 'Total Pagos',
    CONCAT('$', FORMAT(SUM(amount), 2)) AS 'Monto Total'
FROM payments 
WHERE status = 'completed'
GROUP BY payment_type
ORDER BY SUM(amount) DESC;

-- ============================================================================
-- 5. RESUMEN GENERAL
-- ============================================================================
SELECT '' AS '';
SELECT '5. RESUMEN GENERAL DEL SISTEMA' AS 'Resumen';
SELECT '-------------------------------' AS '';

SELECT 
    'Recaudación Total' AS 'Métrica',
    CONCAT('$', FORMAT(SUM(amount), 2)) AS 'Valor'
FROM payments 
WHERE status = 'completed'

UNION ALL

SELECT 
    'Recaudación Mes Actual' AS 'Métrica',
    CONCAT('$', FORMAT(SUM(amount), 2)) AS 'Valor'
FROM payments 
WHERE status = 'completed'
  AND DATE(paid_at) BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())

UNION ALL

SELECT 
    'Total Usuarios' AS 'Métrica',
    COUNT(*) AS 'Valor'
FROM users

UNION ALL

SELECT 
    'Transacciones Hoy' AS 'Métrica',
    COUNT(*) AS 'Valor'
FROM payments 
WHERE DATE(paid_at) = CURDATE() 
  AND status = 'completed';

-- ============================================================================
-- 6. VERIFICACIÓN DE DATOS EN TABLAS
-- ============================================================================
SELECT '' AS '';
SELECT '6. VERIFICACIÓN DE DATOS EN TABLAS' AS 'Verificación';
SELECT '-------------------------------------' AS '';

SELECT 'payments' AS 'Tabla',
       COUNT(*) AS 'Total Registros',
       SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS 'Completados',
       SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS 'Pendientes'
FROM payments

UNION ALL

SELECT 'property_taxes' AS 'Tabla',
       COUNT(*) AS 'Total Registros',
       SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) AS 'Pagados',
       SUM(CASE WHEN status IN ('pending', 'overdue') THEN 1 ELSE 0 END) AS 'Pendientes'
FROM property_taxes

UNION ALL

SELECT 'traffic_fines' AS 'Tabla',
       COUNT(*) AS 'Total Registros',
       SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) AS 'Pagados',
       SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS 'Pendientes'
FROM traffic_fines

UNION ALL

SELECT 'civic_fines' AS 'Tabla',
       COUNT(*) AS 'Total Registros',
       SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) AS 'Pagados',
       SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS 'Pendientes'
FROM civic_fines

UNION ALL

SELECT 'business_licenses' AS 'Tabla',
       COUNT(*) AS 'Total Registros',
       SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS 'Aprobadas',
       SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS 'Pendientes'
FROM business_licenses;

SELECT '' AS '';
SELECT '============================================' AS '';
SELECT 'VERIFICACIÓN COMPLETADA' AS '';
SELECT '============================================' AS '';
