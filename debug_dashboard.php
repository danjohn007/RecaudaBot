<?php
// Archivo temporal para depurar el dashboard
session_start();
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'app/core/Model.php';

// Load models
require_once 'app/models/User.php';
require_once 'app/models/Payment.php';
require_once 'app/models/PropertyTax.php';
require_once 'app/models/TrafficFine.php';
require_once 'app/models/CivicFine.php';
require_once 'app/models/BusinessLicense.php';

// Create model instances
$paymentModel = new Payment();
$userModel = new User();

// Get data like in AdminController
$today = date('Y-m-d');
$thisMonth = date('Y-m-01');
$thisYear = date('Y-01-01');

echo "<h1>Debug Dashboard Data</h1>";

// Test database connection
try {
    $db = Database::getInstance()->getConnection();
    echo "<p>✅ Database connection successful</p>";
} catch (Exception $e) {
    echo "<p>❌ Database connection failed: " . $e->getMessage() . "</p>";
    exit;
}

// Test revenue by type
echo "<h2>Revenue by Type (Current Month)</h2>";
$revenueByType = $paymentModel->getRevenueByType($thisMonth, date('Y-m-t'));
echo "<pre>";
var_dump($revenueByType);
echo "</pre>";

// Test total revenue
echo "<h2>Total Revenue</h2>";
$totalRevenue = $paymentModel->getTotalRevenue();
echo "<p>Total Revenue: $" . number_format($totalRevenue, 2) . "</p>";

$monthRevenue = $paymentModel->getTotalRevenue($thisMonth, date('Y-m-t'));
echo "<p>Month Revenue: $" . number_format($monthRevenue, 2) . "</p>";

// Test payments table
echo "<h2>Payments Table Sample</h2>";
$stmt = $db->prepare("SELECT * FROM payments LIMIT 5");
$stmt->execute();
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
var_dump($payments);
echo "</pre>";

// Check payment types
echo "<h2>Available Payment Types</h2>";
$stmt = $db->prepare("SELECT DISTINCT payment_type FROM payments");
$stmt->execute();
$paymentTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
var_dump($paymentTypes);
echo "</pre>";

// Check completed payments
echo "<h2>Completed Payments Count</h2>";
$stmt = $db->prepare("SELECT COUNT(*) as count FROM payments WHERE status = 'completed'");
$stmt->execute();
$completedCount = $stmt->fetch(PDO::FETCH_ASSOC);
echo "<p>Completed payments count: " . $completedCount['count'] . "</p>";

// Monthly trend test
echo "<h2>Monthly Trend Test</h2>";
$monthlyTrend = [];
for ($i = 5; $i >= 0; $i--) {
    $monthStart = date('Y-m-01', strtotime("-$i months"));
    $monthEnd = date('Y-m-t', strtotime("-$i months"));
    $monthRevenue = $paymentModel->getTotalRevenue($monthStart, $monthEnd);
    $monthlyTrend[] = $monthRevenue;
    echo "<p>Month -$i ($monthStart to $monthEnd): $" . number_format($monthRevenue, 2) . "</p>";
}

echo "<h2>Monthly Trend Array for JavaScript</h2>";
echo "<pre>" . json_encode($monthlyTrend, JSON_PRETTY_PRINT) . "</pre>";
?>