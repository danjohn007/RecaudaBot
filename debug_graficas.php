<?php
session_start();
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

// Solo para administradores
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<h2>Debug de Gráficas - Solo Administradores</h2>";
    echo "<p>Por favor inicia sesión como administrador para ver este debug.</p>";
    echo "<a href='" . BASE_URL . "/auth/login'>Iniciar Sesión</a>";
    exit;
}

echo "<h2>Debug de Gráficas del Dashboard</h2>";
echo "<style>
    pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
    .success { color: green; }
    .error { color: red; }
    .warning { color: orange; }
</style>";

try {
    // Get database connection
    $db = Database::getInstance()->getConnection();
    echo "<p class='success'>✓ Conexión a base de datos exitosa</p>";
    
    echo "<h3>1. Verificando datos en la tabla payments...</h3>";
    
    // Verificar si hay pagos
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM payments");
    $stmt->execute();
    $totalPayments = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    echo "<p>Total de registros en payments: <strong>$totalPayments</strong></p>";
    
    if ($totalPayments == 0) {
        echo "<p class='error'>⚠️ <strong>PROBLEMA IDENTIFICADO:</strong> No hay registros en la tabla payments.</p>";
        echo "<p>Las gráficas no se muestran porque no hay datos que mostrar.</p>";
        
        // Verificar otras tablas
        echo "<h3>2. Verificando datos en otras tablas...</h3>";
        
        $tables = ['traffic_fines', 'civic_fines', 'property_taxes', 'business_licenses'];
        foreach($tables as $table) {
            try {
                $stmt = $db->prepare("SELECT COUNT(*) as count FROM $table");
                $stmt->execute();
                $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                echo "<p>Registros en $table: <strong>$count</strong></p>";
            } catch(Exception $e) {
                echo "<p class='error'>Error al consultar $table: " . $e->getMessage() . "</p>";
            }
        }
        
        echo "<h3>Solución:</h3>";
        echo "<p>Para que las gráficas se muestren necesitas:</p>";
        echo "<ol>";
        echo "<li>Tener algunos registros en las tablas de multas, impuestos o licencias</li>";
        echo "<li>Que algunos de esos registros tengan pagos asociados en la tabla 'payments' con status 'completed'</li>";
        echo "</ol>";
        
    } else {
        echo "<p class='success'>✓ Hay datos en la tabla payments</p>";
        
        // Verificar pagos completados
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM payments WHERE status = 'completed'");
        $stmt->execute();
        $completedPayments = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        echo "<p>Pagos completados: <strong>$completedPayments</strong></p>";
        
        if ($completedPayments == 0) {
            echo "<p class='warning'>⚠️ <strong>PROBLEMA:</strong> No hay pagos con status 'completed'.</p>";
            echo "<p>Las gráficas necesitan pagos completados para mostrar datos.</p>";
        } else {
            echo "<p class='success'>✓ Hay pagos completados</p>";
            
            echo "<h3>2. Probando consulta revenue_by_type...</h3>";
            
            // Probar la consulta de revenue by type
            $stmt = $db->prepare("SELECT payment_type, SUM(amount) as total, COUNT(*) as count
                                  FROM payments 
                                  WHERE status = 'completed'
                                  GROUP BY payment_type");
            $stmt->execute();
            $revenueByType = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<p>Resultado de revenue_by_type:</p>";
            echo "<pre>" . print_r($revenueByType, true) . "</pre>";
            
            if (empty($revenueByType)) {
                echo "<p class='error'>⚠️ La consulta revenue_by_type no devuelve datos</p>";
            } else {
                echo "<p class='success'>✓ Datos de revenue_by_type disponibles</p>";
            }
            
            echo "<h3>3. Probando consulta monthly_trend...</h3>";
            
            // Probar monthly trend
            $monthlyTrend = [];
            for ($i = 5; $i >= 0; $i--) {
                $monthStart = date('Y-m-01', strtotime("-$i months"));
                $monthEnd = date('Y-m-t', strtotime("-$i months"));
                $stmt = $db->prepare("SELECT SUM(amount) as total FROM payments WHERE status = 'completed' AND paid_at BETWEEN ? AND ?");
                $stmt->execute([$monthStart . ' 00:00:00', $monthEnd . ' 23:59:59']);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $monthlyTrend[] = $result['total'] ?? 0;
            }
            
            echo "<p>Resultado de monthly_trend:</p>";
            echo "<pre>" . print_r($monthlyTrend, true) . "</pre>";
            
            // Verificar si Chart.js está disponible
            echo "<h3>4. Verificando JavaScript y Chart.js...</h3>";
            echo "<p>Para verificar si Chart.js está cargando correctamente:</p>";
            echo "<ol>";
            echo "<li>Abre las herramientas de desarrollador en tu navegador (F12)</li>";
            echo "<li>Ve a la pestaña 'Console'</li>";
            echo "<li>Busca errores de JavaScript</li>";
            echo "<li>Verifica si Chart.js está cargado escribiendo: <code>typeof Chart</code></li>";
            echo "</ol>";
            
            echo "<p><strong>Script de prueba:</strong></p>";
            echo "<textarea style='width: 100%; height: 200px;'>";
            echo "// Pega esto en la consola del navegador para probar Chart.js\n";
            echo "console.log('Tipo de Chart:', typeof Chart);\n";
            echo "if (typeof Chart !== 'undefined') {\n";
            echo "    console.log('Chart.js está disponible');\n";
            echo "} else {\n";
            echo "    console.log('Chart.js NO está disponible');\n";
            echo "}\n\n";
            echo "// Verificar si los canvas existen\n";
            echo "console.log('revenueChart:', document.getElementById('revenueChart'));\n";
            echo "console.log('obligationsChart:', document.getElementById('obligationsChart'));\n";
            echo "console.log('trendChart:', document.getElementById('trendChart'));\n";
            echo "</textarea>";
        }
    }
    
} catch (Exception $e) {
    echo "<p class='error'><strong>Error:</strong> " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='" . BASE_URL . "/admin/dashboard'>Volver al Dashboard</a></p>";
?>