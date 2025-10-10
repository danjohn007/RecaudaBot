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
    pre { background: #e9ecef; padding: 10px; border-radius: 5px; }
</style>";

echo "<div class='debug-box'>";
echo "<h3>Variables del Servidor (Router)</h3>";
echo "<pre>";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'No definido') . "\n";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'No definido') . "\n";
echo "REQUEST_METHOD: " . ($_SERVER['REQUEST_METHOD'] ?? 'No definido') . "\n";
echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'No definido') . "\n";
echo "DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'No definido') . "\n";
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
$uri = $_SERVER['REQUEST_URI'] ?? '';
echo "<p><strong>URI Original:</strong> $uri</p>";

// Simular la lógica del router
if (($pos = strpos($uri, '?')) !== false) {
    $uri = substr($uri, 0, $pos);
}

$script_name = $_SERVER['SCRIPT_NAME'] ?? '';
$base_path = dirname($script_name);

echo "<p><strong>Script Name:</strong> $script_name</p>";
echo "<p><strong>Base Path:</strong> $base_path</p>";

if (strpos($uri, $base_path) === 0) {
    $uri = substr($uri, strlen($base_path));
}

if (empty($uri) || $uri[0] !== '/') {
    $uri = '/' . $uri;
}

echo "<p><strong>URI Procesada:</strong> $uri</p>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Rutas de Prueba</h3>";
echo "<p>Prueba estos enlaces para verificar el enrutamiento:</p>";
echo "<ul>";
echo "<li><a href='" . PUBLIC_URL . "/login'>Login</a> (debería mostrar /login)</li>";
echo "<li><a href='" . PUBLIC_URL . "/admin'>Admin Dashboard</a> (debería mostrar /admin)</li>";
echo "<li><a href='" . PUBLIC_URL . "/'>Inicio</a> (debería mostrar /)</li>";
echo "<li><a href='" . PUBLIC_URL . "/profile'>Perfil</a> (debería mostrar /profile)</li>";
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
echo "<h3>Archivos de Vista</h3>";
echo "<p>Verificando si existen los archivos de vista principales:</p>";
$viewFiles = [
    'auth/login.php',
    'admin/dashboard.php',
    'home/index.php',
    'profile/index.php'
];

foreach ($viewFiles as $file) {
    $fullPath = __DIR__ . '/../app/views/' . $file;
    $exists = file_exists($fullPath);
    $status = $exists ? '<span class="success">✓ Existe</span>' : '<span class="error">✗ No existe</span>';
    echo "<p>$file: $status</p>";
}
echo "</div>";

echo "<p><a href='" . BASE_URL . "'>Volver al Inicio</a></p>";
?>