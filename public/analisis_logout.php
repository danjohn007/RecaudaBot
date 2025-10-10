<?php
// Análisis específico del problema de logout
session_start();
require_once __DIR__ . '/../config/config.php';

echo "<!DOCTYPE html><html><head><title>Análisis Detallado - Logout Problem</title>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .section { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border: 1px solid #dee2e6; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    .code { background: #e9ecef; padding: 10px; border-radius: 3px; font-family: monospace; }
    .test-link { background: #007bff; color: white; padding: 8px 12px; text-decoration: none; border-radius: 3px; margin: 5px; display: inline-block; }
    .test-link:hover { background: #0056b3; }
</style></head><body>";

echo "<h1>🔍 Análisis Detallado del Problema de Logout</h1>";

echo "<div class='section'>";
echo "<h2>1. Comparación con Rutas que SÍ funcionan</h2>";

// Test otras rutas que funcionan
$working_routes = [
    '/admin' => 'Dashboard Admin',
    '/admin/estadisticas' => 'Estadísticas (que acabamos de arreglar)',
    '/admin/usuarios' => 'Gestión de Usuarios',
    '/perfil' => 'Perfil de Usuario',
    '/login' => 'Página de Login'
];

echo "<h3>Rutas que funcionan correctamente:</h3>";
foreach ($working_routes as $route => $description) {
    $full_url = BASE_URL . $route;
    echo "<p>✅ <strong>$description:</strong> <code>$full_url</code></p>";
}

echo "<h3>Ruta problemática:</h3>";
echo "<p>❌ <strong>Logout:</strong> <code>" . BASE_URL . "/logout</code></p>";
echo "</div>";

echo "<div class='section'>";
echo "<h2>2. Análisis del Router - Paso a Paso</h2>";

// Simular exactamente lo que hace el router para /logout vs otras rutas
$test_routes = ['/admin', '/login', '/logout'];

foreach ($test_routes as $test_route) {
    echo "<h3>Procesando ruta: <code>$test_route</code></h3>";
    
    // Simular REQUEST_URI como si fuera esta ruta
    $simulated_uri = $_SERVER['REQUEST_URI'];
    $base_part = parse_url($simulated_uri, PHP_URL_PATH);
    $simulated_full_uri = str_replace(basename($base_part), '', $base_part) . ltrim($test_route, '/');
    
    echo "<p><strong>URI simulada:</strong> $simulated_full_uri</p>";
    
    // Procesar como lo hace el router
    $uri = $simulated_full_uri;
    
    // Remove query string
    if (($pos = strpos($uri, '?')) !== false) {
        $uri = substr($uri, 0, $pos);
    }
    
    // Remove base path - improved detection
    $script_name = $_SERVER['SCRIPT_NAME'];
    $base_path = dirname($script_name);
    
    if ($base_path === '/' || $base_path === '\\') {
        $base_path = '';
    }
    
    $base_path = str_replace('/public', '', $base_path);
    
    if (!empty($base_path) && strpos($uri, $base_path) === 0) {
        $uri = substr($uri, strlen($base_path));
    }
    
    if (strpos($uri, '/public') === 0) {
        $uri = substr($uri, 7);
    }
    
    if (empty($uri) || $uri[0] !== '/') {
        $uri = '/' . $uri;
    }
    
    if (strlen($uri) > 1 && substr($uri, -1) === '/') {
        $uri = substr($uri, 0, -1);
    }
    
    echo "<p><strong>URI procesada final:</strong> <code>$uri</code></p>";
    
    // Check if would match
    if ($uri === $test_route) {
        echo "<p class='success'>✅ Coincidencia perfecta - Debería funcionar</p>";
    } else {
        echo "<p class='error'>❌ NO coincide - Aquí está el problema</p>";
        echo "<p><strong>Esperado:</strong> <code>$test_route</code></p>";
        echo "<p><strong>Obtenido:</strong> <code>$uri</code></p>";
    }
    echo "<hr>";
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>3. Verificación de Rutas en index.php</h2>";

// Leer y mostrar las rutas definidas
$index_content = file_get_contents(__DIR__ . '/index.php');
$logout_routes = [];
if (preg_match_all('/\$router->get\([\'"]([^\'"]*/logout[^\'"]*)[\'"]/i', $index_content, $matches)) {
    $logout_routes = $matches[1];
}

if (preg_match_all('/\$router->post\([\'"]([^\'"]*/logout[^\'"]*)[\'"]/i', $index_content, $matches)) {
    $logout_routes = array_merge($logout_routes, $matches[1]);
}

echo "<h3>Rutas de logout definidas en index.php:</h3>";
if (!empty($logout_routes)) {
    foreach ($logout_routes as $route) {
        echo "<p>📝 <code>$route</code></p>";
    }
} else {
    echo "<p class='error'>❌ ¡No se encontraron rutas de logout!</p>";
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>4. Comparación con el Servidor Web</h2>";
echo "<p><strong>Teoría:</strong> El servidor web podría estar interceptando específicamente la palabra 'logout'</p>";

echo "<h3>Headers de la petición actual:</h3>";
foreach ($_SERVER as $key => $value) {
    if (strpos($key, 'HTTP_') === 0 || in_array($key, ['REQUEST_METHOD', 'REQUEST_URI', 'SCRIPT_NAME', 'QUERY_STRING'])) {
        echo "<p><strong>$key:</strong> " . htmlspecialchars($value) . "</p>";
    }
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>5. Test Directo de Enlaces</h2>";
echo "<p>Prueba estos enlaces para ver cuál específicamente falla:</p>";

$test_links = [
    BASE_URL . '/admin' => 'Admin (debería funcionar)',
    BASE_URL . '/login' => 'Login (debería funcionar)', 
    BASE_URL . '/logout' => 'Logout (problemático)',
    BASE_URL . '/public/logout' => 'Logout público',
    BASE_URL . '/salir' => 'Test palabra diferente'
];

foreach ($test_links as $url => $desc) {
    echo "<a href='$url' class='test-link' target='_blank'>$desc</a>";
}
echo "</div>";

echo "<div class='section'>";
echo "<h2>6. Información de Sesión Actual</h2>";
if (isset($_SESSION['user_id'])) {
    echo "<p class='success'>✅ Usuario logueado: " . htmlspecialchars($_SESSION['username'] ?? 'N/A') . "</p>";
    echo "<p>ID: " . $_SESSION['user_id'] . "</p>";
    echo "<p>Role: " . $_SESSION['role'] . "</p>";
} else {
    echo "<p class='warning'>⚠️ No hay sesión activa (normal si ya se hizo logout)</p>";
}
echo "</div>";

echo "</body></html>";
?>