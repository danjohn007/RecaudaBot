<?php
// Script para insertar datos de prueba para las gráficas
session_start();
require_once 'config/config.php';
require_once 'config/database.php';

// Solo para administradores
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<h2>Insertar Datos de Prueba - Solo Administradores</h2>";
    echo "<p>Por favor inicia sesión como administrador para ejecutar este script.</p>";
    exit;
}

try {
    $db = Database::getInstance()->getConnection();
    
    echo "<h2>Insertando Datos de Prueba para Gráficas</h2>";
    
    // Verificar si ya hay pagos
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM payments WHERE status = 'completed'");
    $stmt->execute();
    $existingPayments = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    if ($existingPayments > 0) {
        echo "<p style='color: orange;'>Ya hay $existingPayments pagos en la base de datos.</p>";
        echo "<p>¿Deseas agregar más datos de prueba? <a href='?insert=yes'>Sí, agregar datos</a></p>";
        
        if (!isset($_GET['insert'])) {
            exit;
        }
    }
    
    echo "<p>Insertando datos de prueba...</p>";
    
    // Datos de ejemplo para diferentes tipos de pagos
    $samplePayments = [
        [
            'user_id' => $_SESSION['user_id'], // Usuario actual
            'payment_type' => 'property_tax',
            'reference_id' => 1,
            'amount' => 1500.00,
            'status' => 'completed',
            'payment_method' => 'credit_card',
            'transaction_id' => 'TXN001',
            'paid_at' => date('Y-m-d H:i:s', strtotime('-15 days')),
            'created_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
        ],
        [
            'user_id' => $_SESSION['user_id'],
            'payment_type' => 'traffic_fine',
            'reference_id' => 1,
            'amount' => 500.00,
            'status' => 'completed',
            'payment_method' => 'debit_card',
            'transaction_id' => 'TXN002',
            'paid_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
            'created_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
        ],
        [
            'user_id' => $_SESSION['user_id'],
            'payment_type' => 'civic_fine',
            'reference_id' => 1,
            'amount' => 300.00,
            'status' => 'completed',
            'payment_method' => 'transfer',
            'transaction_id' => 'TXN003',
            'paid_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
            'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
        ],
        [
            'user_id' => $_SESSION['user_id'],
            'payment_type' => 'business_license',
            'reference_id' => 1,
            'amount' => 2000.00,
            'status' => 'completed',
            'payment_method' => 'transfer',
            'transaction_id' => 'TXN004',
            'paid_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
        ],
        [
            'user_id' => $_SESSION['user_id'],
            'payment_type' => 'property_tax',
            'reference_id' => 2,
            'amount' => 1200.00,
            'status' => 'completed',
            'payment_method' => 'credit_card',
            'transaction_id' => 'TXN005',
            'paid_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ],
        [
            'user_id' => $_SESSION['user_id'],
            'payment_type' => 'traffic_fine',
            'reference_id' => 2,
            'amount' => 750.00,
            'status' => 'completed',
            'payment_method' => 'debit_card',
            'transaction_id' => 'TXN006',
            'paid_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]
    ];
    
    // Insertar datos de pagos
    $sql = "INSERT INTO payments (user_id, payment_type, reference_id, amount, status, payment_method, transaction_id, paid_at, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    
    $insertedCount = 0;
    foreach ($samplePayments as $payment) {
        if ($stmt->execute([
            $payment['user_id'],
            $payment['payment_type'],
            $payment['reference_id'],
            $payment['amount'],
            $payment['status'],
            $payment['payment_method'],
            $payment['transaction_id'],
            $payment['paid_at'],
            $payment['created_at']
        ])) {
            $insertedCount++;
        }
    }
    
    echo "<p style='color: green;'>✓ Se insertaron $insertedCount registros de pagos de prueba.</p>";
    
    // Insertar algunos datos para pagos mensuales anteriores (para monthly_trend)
    $monthlyPayments = [];
    for ($i = 5; $i >= 1; $i--) {
        $monthDate = date('Y-m-d H:i:s', strtotime("-$i months"));
        $monthlyPayments[] = [
            'user_id' => $_SESSION['user_id'],
            'payment_type' => 'property_tax',
            'reference_id' => 10 + $i,
            'amount' => rand(800, 2000),
            'status' => 'completed',
            'payment_method' => 'transfer',
            'transaction_id' => 'MONTHLY' . $i,
            'paid_at' => $monthDate,
            'created_at' => $monthDate
        ];
    }
    
    $monthlyInserted = 0;
    foreach ($monthlyPayments as $payment) {
        if ($stmt->execute([
            $payment['user_id'],
            $payment['payment_type'],
            $payment['reference_id'],
            $payment['amount'],
            $payment['status'],
            $payment['payment_method'],
            $payment['transaction_id'],
            $payment['paid_at'],
            $payment['created_at']
        ])) {
            $monthlyInserted++;
        }
    }
    
    echo "<p style='color: green;'>✓ Se insertaron $monthlyInserted registros mensuales para tendencias.</p>";
    
    echo "<h3>Datos insertados exitosamente!</h3>";
    echo "<p>Ahora las gráficas del dashboard deberían mostrar información.</p>";
    echo "<p><a href='" . BASE_URL . "/public/admin' class='btn btn-primary'>Ver Dashboard</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>