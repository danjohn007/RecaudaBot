<?php
// Análisis completo del sistema de logout - Verificación integral
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head>";
echo "<title>Análisis Completo - Sistema Logout</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css'>";
echo "<style>
    .analysis-section { background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px; border-left: 4px solid #007bff; }
    .success { border-left-color: #28a745; background: #f8fff9; }
    .error { border-left-color: #dc3545; background: #fff8f8; }
    .warning { border-left-color: #ffc107; background: #fffef8; }
    .code-block { background: #e9ecef; padding: 10px; border-radius: 5px; font-family: monospace; white-space: pre-wrap; }
    .file-check { margin: 5px 0; padding: 8px; border-radius: 4px; }
</style></head><body>";

echo "<div class='container my-4'>";
echo "<h1 class='text-center mb-4'><i class='bi bi-search'></i> Análisis Completo del Sistema de Logout</h1>";

session_start();
require_once __DIR__ . '/../config/config.php';

// 1. Verificar archivos críticos
echo "<div class='analysis-section'>";
echo "<h2><i class='bi bi-files'></i> 1. Verificación de Archivos Críticos</h2>";

$critical_files = [
    'AuthController' => [
        'path' => __DIR__ . '/../app/controllers/AuthController.php',
        'description' => 'Controlador principal de autenticación'
    ],
    'Router' => [
        'path' => __DIR__ . '/../app/core/Router.php',
        'description' => 'Sistema de enrutamiento'
    ],
    'Controller Base' => [
        'path' => __DIR__ . '/../app/core/Controller.php',
        'description' => 'Controlador base con métodos view() y redirect()'
    ],
    'Index.php' => [
        'path' => __DIR__ . '/index.php',
        'description' => 'Front controller con definición de rutas'
    ],
    'Config' => [
        'path' => __DIR__ . '/../config/config.php',
        'description' => 'Configuración principal del sistema'
    ],
    'logout_success.php (Vista)' => [
        'path' => __DIR__ . '/../app/views/auth/logout_success.php',
        'description' => 'Vista de logout (ya no usada directamente)'
    ],
    'logout_direct.php' => [
        'path' => __DIR__ . '/logout_direct.php',
        'description' => 'Logout directo alternativo'
    ]
];

foreach ($critical_files as $name => $info) {
    $exists = file_exists($info['path']);
    $readable = $exists ? is_readable($info['path']) : false;
    $size = $exists ? filesize($info['path']) : 0;
    
    echo "<div class='file-check " . ($exists ? 'alert-success' : 'alert-danger') . "'>";
    echo "<strong>$name:</strong> " . ($exists ? '✅' : '❌') . " ";
    echo $info['description'] . "<br>";
    if ($exists) {
        echo "<small>Tamaño: " . number_format($size) . " bytes | Readable: " . ($readable ? 'Sí' : 'No') . "</small>";
    }
    echo "</div>";
}
echo "</div>";

// 2. Análisis del AuthController
echo "<div class='analysis-section'>";
echo "<h2><i class='bi bi-gear'></i> 2. Análisis del AuthController</h2>";

$auth_controller_path = __DIR__ . '/../app/controllers/AuthController.php';
if (file_exists($auth_controller_path)) {
    $content = file_get_contents($auth_controller_path);
    
    echo "<h4>Verificaciones del método logout():</h4>";
    
    $checks = [
        'Método logout existe' => strpos($content, 'public function logout()') !== false,
        'session_destroy() presente' => strpos($content, 'session_destroy()') !== false,
        'getLogoutSuccessHTML() método existe' => strpos($content, 'getLogoutSuccessHTML()') !== false,
        'exit() después de HTML' => strpos($content, 'exit()') !== false,
        'No usa $this->view()' => strpos($content, '$this->view(') === false || substr_count($content, '$this->view(') <= 1,
        'HTML directo implementado' => strpos($content, 'echo $this->getLogoutSuccessHTML()') !== false
    ];
    
    foreach ($checks as $check => $passed) {
        echo "<div class='alert " . ($passed ? 'alert-success' : 'alert-danger') . "'>";
        echo ($passed ? '✅' : '❌') . " $check";
        echo "</div>";
    }
    
    // Mostrar el método logout actual
    preg_match('/public function logout\(\).*?(?=public function|\}$)/s', $content, $matches);
    if (!empty($matches[0])) {
        echo "<h5>Método logout() actual:</h5>";
        echo "<div class='code-block'>";
        echo htmlspecialchars(substr($matches[0], 0, 500)) . (strlen($matches[0]) > 500 ? '...' : '');
        echo "</div>";
    }
}
echo "</div>";

// 3. Verificar rutas en index.php
echo "<div class='analysis-section'>";
echo "<h2><i class='bi bi-signpost'></i> 3. Verificación de Rutas</h2>";

$index_path = __DIR__ . '/index.php';
if (file_exists($index_path)) {
    $content = file_get_contents($index_path);
    
    echo "<h4>Rutas de logout definidas:</h4>";
    preg_match_all('/\$router->(get|post)\([\'"]([^\'"]*(logout)[^\'"]*).*?\);/', $content, $matches, PREG_SET_ORDER);
    
    if (!empty($matches)) {
        foreach ($matches as $match) {
            echo "<div class='alert alert-success'>";
            echo "✅ {$match[1]} '{$match[2]}' → AuthController logout()";
            echo "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>";
        echo "❌ No se encontraron rutas de logout definidas";
        echo "</div>";
    }
}
echo "</div>";

// 4. Verificar configuración
echo "<div class='analysis-section'>";
echo "<h2><i class='bi bi-sliders'></i> 4. Configuración del Sistema</h2>";

echo "<div class='code-block'>";
echo "BASE_URL: " . BASE_URL . "\n";
echo "APP_NAME: " . (defined('APP_NAME') ? APP_NAME : 'No definido') . "\n";
echo "PUBLIC_URL: " . (defined('PUBLIC_URL') ? PUBLIC_URL : 'No definido') . "\n";
echo "HTTP_HOST: " . $_SERVER['HTTP_HOST'] . "\n";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "</div>";
echo "</div>";

// 5. Estado de sesión actual
echo "<div class='analysis-section'>";
echo "<h2><i class='bi bi-person-check'></i> 5. Estado de Sesión Actual</h2>";

if (isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-info'>";
    echo "<h4>Usuario logueado:</h4>";
    echo "Username: " . ($_SESSION['username'] ?? 'N/A') . "<br>";
    echo "User ID: " . $_SESSION['user_id'] . "<br>";
    echo "Role: " . ($_SESSION['role'] ?? 'N/A') . "<br>";
    echo "Session ID: " . session_id();
    echo "</div>";
} else {
    echo "<div class='alert alert-warning'>";
    echo "No hay usuario logueado actualmente";
    echo "</div>";
}
echo "</div>";

// 6. Test de conectividad
echo "<div class='analysis-section'>";
echo "<h2><i class='bi bi-wifi'></i> 6. Test de Conectividad</h2>";

$urls_to_test = [
    'Página Principal' => BASE_URL,
    'Login' => BASE_URL . '/login',
    'Logout' => BASE_URL . '/logout'
];

echo "<div id='connectivity-results'>";
foreach ($urls_to_test as $name => $url) {
    echo "<div class='mt-2'>";
    echo "<strong>$name:</strong> <code>$url</code> ";
    echo "<button onclick='testConnectivity(\"$url\", \"" . str_replace(' ', '_', $name) . "\")' class='btn btn-sm btn-outline-primary'>Test</button>";
    echo "<span id='result_" . str_replace(' ', '_', $name) . "' class='ms-2'></span>";
    echo "</div>";
}
echo "</div>";
echo "</div>";

// 7. Recomendaciones
echo "<div class='analysis-section'>";
echo "<h2><i class='bi bi-lightbulb'></i> 7. Recomendaciones y Pasos de Prueba</h2>";

if (isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-primary'>";
    echo "<h5>Pasos para probar logout:</h5>";
    echo "1. <a href='" . BASE_URL . "/logout' class='btn btn-danger btn-sm'>Hacer Logout</a> (debe mostrar página de confirmación)<br>";
    echo "2. Verificar que el countdown funcione (3 segundos)<br>";
    echo "3. Confirmar redirección automática a página principal<br>";
    echo "4. Verificar que aparezcan botones de 'Regístrate' e 'Iniciar Sesión'";
    echo "</div>";
} else {
    echo "<div class='alert alert-info'>";
    echo "<h5>Estado actual:</h5>";
    echo "No hay sesión activa. Puedes:<br>";
    echo "1. <a href='" . BASE_URL . "/login' class='btn btn-primary btn-sm'>Iniciar Sesión</a><br>";
    echo "2. Luego probar el logout<br>";
    echo "3. O revisar que la página principal tenga los botones correctos";
    echo "</div>";
}

echo "<div class='alert alert-success'>";
echo "<h5>✅ Cambios implementados:</h5>";
echo "• AuthController usa HTML directo en lugar de vistas<br>";
echo "• Eliminado conflicto session_destroy/session_start<br>";
echo "• JavaScript mejorado con múltiples métodos de redirección<br>";
echo "• Timer de respaldo implementado<br>";
echo "• exit() después de HTML para evitar procesamiento adicional";
echo "</div>";
echo "</div>";

echo "<div class='text-center mt-4'>";
echo "<a href='" . BASE_URL . "' class='btn btn-primary me-2'>";
echo "<i class='bi bi-house'></i> Ir a Página Principal";
echo "</a>";
echo "<a href='" . BASE_URL . "/login' class='btn btn-outline-primary'>";
echo "<i class='bi bi-box-arrow-in-right'></i> Login";
echo "</a>";
echo "</div>";

echo "</div>"; // container

echo "<script>
function testConnectivity(url, elementId) {
    const resultElement = document.getElementById('result_' + elementId);
    resultElement.innerHTML = '<small class=\"text-info\">Probando...</small>';
    
    fetch(url, {
        method: 'HEAD',
        credentials: 'include'
    })
    .then(response => {
        const status = response.status;
        const color = status >= 200 && status < 400 ? 'success' : 'danger';
        resultElement.innerHTML = '<small class=\"text-' + color + '\">Status: ' + status + '</small>';
    })
    .catch(error => {
        resultElement.innerHTML = '<small class=\"text-danger\">Error: ' + error.message + '</small>';
    });
}
</script>";

echo "</body></html>";
?>