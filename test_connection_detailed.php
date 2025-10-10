<?php
// Test de conexión detallado
require_once 'config/config.php';

echo "<h2>Prueba de Conexión a Base de Datos</h2>";
echo "<strong>Configuración actual:</strong><br>";
echo "Host: " . DB_HOST . "<br>";
echo "Database: " . DB_NAME . "<br>";
echo "User: " . DB_USER . "<br>";
echo "Charset: " . DB_CHARSET . "<br><br>";

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    echo "DSN: $dsn<br><br>";
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<span style='color: green;'>✓ Conexión exitosa!</span><br><br>";
    
    // Verificar tablas principales
    $tables = ['users', 'payments', 'traffic_fines', 'civic_fines', 'property_tax'];
    echo "<strong>Verificando tablas:</strong><br>";
    
    foreach($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
            $result = $stmt->fetch();
            echo "✓ Tabla '$table': {$result['count']} registros<br>";
        } catch(Exception $e) {
            echo "✗ Error en tabla '$table': " . $e->getMessage() . "<br>";
        }
    }
    
    // Probar las consultas específicas del dashboard
    echo "<br><strong>Probando consultas del dashboard:</strong><br>";
    
    // Revenue by type
    try {
        $stmt = $pdo->prepare("
            SELECT 'traffic_fines' as type, COALESCE(SUM(amount), 0) as total 
            FROM payments p 
            JOIN traffic_fines tf ON p.reference_id = tf.id 
            WHERE p.reference_type = 'traffic_fine' AND p.status = 'completed'
            UNION ALL
            SELECT 'civic_fines' as type, COALESCE(SUM(amount), 0) as total 
            FROM payments p 
            JOIN civic_fines cf ON p.reference_id = cf.id 
            WHERE p.reference_type = 'civic_fine' AND p.status = 'completed'
            UNION ALL
            SELECT 'property_tax' as type, COALESCE(SUM(amount), 0) as total 
            FROM payments p 
            JOIN property_tax pt ON p.reference_id = pt.id 
            WHERE p.reference_type = 'property_tax' AND p.status = 'completed'
        ");
        $stmt->execute();
        $revenue_data = $stmt->fetchAll();
        
        echo "✓ Consulta de ingresos por tipo exitosa:<br>";
        foreach($revenue_data as $row) {
            echo "&nbsp;&nbsp;- {$row['type']}: $" . number_format($row['total'], 2) . "<br>";
        }
    } catch(Exception $e) {
        echo "✗ Error en consulta de ingresos: " . $e->getMessage() . "<br>";
    }
    
    // Monthly revenue
    try {
        $stmt = $pdo->prepare("
            SELECT 
                DATE_FORMAT(payment_date, '%Y-%m') as month,
                COALESCE(SUM(amount), 0) as total
            FROM payments 
            WHERE status = 'completed' 
            AND payment_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
            GROUP BY DATE_FORMAT(payment_date, '%Y-%m')
            ORDER BY month ASC
        ");
        $stmt->execute();
        $monthly_data = $stmt->fetchAll();
        
        echo "<br>✓ Consulta de ingresos mensuales exitosa:<br>";
        foreach($monthly_data as $row) {
            echo "&nbsp;&nbsp;- {$row['month']}: $" . number_format($row['total'], 2) . "<br>";
        }
    } catch(Exception $e) {
        echo "✗ Error en consulta mensual: " . $e->getMessage() . "<br>";
    }
    
} catch(PDOException $e) {
    echo "<span style='color: red;'>✗ Error de conexión: " . $e->getMessage() . "</span><br>";
    echo "<br><strong>Posibles soluciones:</strong><br>";
    echo "1. Verifica que el servidor de base de datos esté funcionando<br>";
    echo "2. Confirma que las credenciales sean correctas<br>";
    echo "3. Si la BD está en un servidor remoto, cambia 'localhost' por la IP/dominio del servidor<br>";
    echo "4. Verifica que el puerto MySQL esté abierto (generalmente 3306)<br>";
}
?>