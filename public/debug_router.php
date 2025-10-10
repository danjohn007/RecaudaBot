<?php
// Debug del Router y rutas
session_start();
require_once '../config/config.php';

echo "<h2>Debug del Sistema de Rutas</h2>";
echo "<style>
    .debug-box { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border: 1px solid #dee2e6; }
    .success { color: green; }
    .error { color: red; }
    .warning { color: orange; }
    pre { background: #e9ecef; padding: 10px; border-radius: 5px; overflow-x: auto; }
</style>";

echo "<div class='debug-box'>";
echo "<h3>Variables del Servidor (Router)</h3>";
echo "<pre>";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'No definido') . "\n";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'No definido') . "\n";
echo "REQUEST_METHOD: " . ($_SERVER['REQUEST_METHOD'] ?? 'No definido') . "\n";
echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'No definido') . "\n";
echo "DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'No definido') . "\n";
echo "PHP_SELF: " . ($_SERVER['PHP_SELF'] ?? 'No definido') . "\n";
echo "</pre>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Configuración de URLs</h3>";
echo "<pre>";
echo "BASE_URL: " . BASE_URL . "\n";
echo "PUBLIC_URL: " . PUBLIC_URL . "\n";
echo "</pre>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Simulación del Router</h3>";
$original_uri = $_SERVER['REQUEST_URI'] ?? '';
$uri = $original_uri;

echo "<p><strong>URI Original:</strong> $uri</p>";

// Simular la lógica del router
if (($pos = strpos($uri, '?')) !== false) {
    $uri = substr($uri, 0, $pos);
}

$script_name = $_SERVER['SCRIPT_NAME'] ?? '';
$script_dir = dirname($script_name);

echo "<p><strong>Script Name:</strong> $script_name</p>";
echo "<p><strong>Script Dir:</strong> $script_dir</p>";

if (strpos($uri, $script_dir) === 0) {
    $uri = substr($uri, strlen($script_dir));
}

if (empty($uri) || $uri[0] !== '/') {
    $uri = '/' . $uri;
}

// Remove trailing slash (except for root)
if (strlen($uri) > 1 && substr($uri, -1) === '/') {
    $uri = substr($uri, 0, -1);
}

echo "<p><strong>URI Procesada Final:</strong> <span class='success'>$uri</span></p>";

// Mostrar qué ruta coincidiría
$routes = [
    '/' => 'HomeController::index',
    '/login' => 'AuthController::showLogin',
    '/admin' => 'AdminController::dashboard',
    '/register' => 'AuthController::showRegister',
    '/profile' => 'ProfileController::index'
];

$matched = false;
foreach ($routes as $route => $controller) {
    if ($route === $uri) {
        echo "<p><strong class='success'>✓ Ruta coincidente:</strong> $route → $controller</p>";
        $matched = true;
        break;
    }
}

if (!$matched) {
    echo "<p><strong class='error'>✗ No hay coincidencia de ruta para:</strong> $uri</p>";
    echo "<p><strong>Rutas disponibles:</strong></p>";
    echo "<ul>";
    foreach ($routes as $route => $controller) {
        echo "<li>$route</li>";
    }
    echo "</ul>";
}
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Test directo de rutas</h3>";
echo "<p>Haz clic en estos enlaces para probar el enrutamiento:</p>";
echo "<ul>";
echo "<li><a href='" . PUBLIC_URL . "/' target='_blank'>Inicio (/)</a></li>";
echo "<li><a href='" . PUBLIC_URL . "/login' target='_blank'>Login (/login)</a></li>";
echo "<li><a href='" . PUBLIC_URL . "/register' target='_blank'>Registro (/register)</a></li>";
echo "<li><a href='" . PUBLIC_URL . "/admin' target='_blank'>Admin (/admin)</a></li>";
echo "</ul>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Estado de la Sesión</h3>";
echo "<pre>";
if (isset($_SESSION['user_id'])) {
    echo "Usuario logueado: " . ($_SESSION['full_name'] ?? 'Sin nombre') . "\n";
    echo "Rol: " . ($_SESSION['role'] ?? 'Sin rol') . "\n";
    echo "User ID: " . $_SESSION['user_id'] . "\n";
} else {
    echo "No hay sesión activa\n";
}
echo "</pre>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Test del archivo index.php</h3>";
$indexPath = __DIR__ . '/index.php';
if (file_exists($indexPath)) {
    echo "<p class='success'>✓ index.php existe en: $indexPath</p>";
    echo "<p>Tamaño: " . filesize($indexPath) . " bytes</p>";
} else {
    echo "<p class='error'>✗ index.php no encontrado en: $indexPath</p>";
}
echo "</div>";

echo "<p><a href='" . PUBLIC_URL . "'>Ir al Inicio</a></p>";
?>