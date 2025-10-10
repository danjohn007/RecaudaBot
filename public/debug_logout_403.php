<?php
// Análisis profundo del problema de redirección 403
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head>";
echo "<title>Análisis Profundo - Error 403 Logout</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<style>
    .debug-section { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007bff; }
    .error { border-left-color: #dc3545; background: #fff5f5; }
    .success { border-left-color: #28a745; background: #f8fff9; }
    .warning { border-left-color: #ffc107; background: #fffef8; }
    .code { background: #e9ecef; padding: 8px; border-radius: 3px; font-family: monospace; }
</style></head><body>";

echo "<div class='container mt-4'>";
echo "<h1 class='text-center mb-4'>🔍 Análisis Profundo - Error 403 Logout</h1>";

// 1. Estado del sistema
echo "<div class='debug-section'>";
echo "<h3>1. Estado Actual del Sistema</h3>";

session_start();
require_once __DIR__ . '/../config/config.php';

if (isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-info'>";
    echo "<strong>✅ Usuario logueado:</strong> " . $_SESSION['username'] . " (ID: " . $_SESSION['user_id'] . ")";
    echo "</div>";
} else {
    echo "<div class='alert alert-warning'>";
    echo "<strong>⚠️ No hay sesión activa</strong>";
    echo "</div>";
}

echo "<div class='code'>";
echo "<strong>BASE_URL:</strong> " . BASE_URL . "<br>";
echo "<strong>PUBLIC_URL:</strong> " . (defined('PUBLIC_URL') ? PUBLIC_URL : 'No definido') . "<br>";
echo "<strong>DOCUMENT_ROOT:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>REQUEST_URI:</strong> " . $_SERVER['REQUEST_URI'] . "<br>";
echo "<strong>SCRIPT_NAME:</strong> " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "<strong>HTTP_HOST:</strong> " . $_SERVER['HTTP_HOST'] . "<br>";
echo "</div>";
echo "</div>";

// 2. Verificar rutas y archivos
echo "<div class='debug-section'>";
echo "<h3>2. Verificación de Rutas y Archivos</h3>";

$routes_to_check = [
    'AuthController' => __DIR__ . '/../app/controllers/AuthController.php',
    'Router' => __DIR__ . '/../app/core/Router.php',
    'logout_success.php' => __DIR__ . '/../app/views/auth/logout_success.php',
    '.htaccess root' => __DIR__ . '/../.htaccess',
    '.htaccess public' => __DIR__ . '/.htaccess'
];

foreach ($routes_to_check as $name => $path) {
    if (file_exists($path)) {
        echo "<div class='alert alert-success'>";
        echo "✅ <strong>$name:</strong> Existe - " . $path;
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger'>";
        echo "❌ <strong>$name:</strong> NO EXISTE - " . $path;
        echo "</div>";
    }
}
echo "</div>";

// 3. Análisis del .htaccess
echo "<div class='debug-section'>";
echo "<h3>3. Análisis de .htaccess</h3>";

$htaccess_public = __DIR__ . '/.htaccess';
if (file_exists($htaccess_public)) {
    echo "<h5>.htaccess en /public:</h5>";
    echo "<pre class='code'>";
    echo htmlspecialchars(file_get_contents($htaccess_public));
    echo "</pre>";
} else {
    echo "<div class='alert alert-warning'>";
    echo "⚠️ No hay .htaccess en /public";
    echo "</div>";
}

$htaccess_root = __DIR__ . '/../.htaccess';
if (file_exists($htaccess_root)) {
    echo "<h5>.htaccess en raíz:</h5>";
    echo "<pre class='code'>";
    echo htmlspecialchars(file_get_contents($htaccess_root));
    echo "</pre>";
}
echo "</div>";

// 4. Test de URL de logout
echo "<div class='debug-section'>";
echo "<h3>4. Test de URLs de Logout</h3>";

$logout_urls = [
    'Logout normal' => BASE_URL . '/logout',
    'Logout directo' => BASE_URL . '/public/logout_direct.php',
    'Index.php directo' => BASE_URL . '/public/index.php/logout',
];

foreach ($logout_urls as $name => $url) {
    echo "<div class='mt-2'>";
    echo "<strong>$name:</strong> <code>$url</code><br>";
    echo "<a href='$url' class='btn btn-sm btn-outline-primary me-2'>Probar</a>";
    echo "<button onclick='testUrl(\"$url\", \"$name\")' class='btn btn-sm btn-outline-info'>Test Ajax</button>";
    echo "<div id='result_" . md5($name) . "' class='mt-1'></div>";
    echo "</div>";
}
echo "</div>";

// 5. Router debug
echo "<div class='debug-section'>";
echo "<h3>5. Debug del Router</h3>";

echo "<p>Vamos a simular cómo el Router procesa la URL '/logout':</p>";

// Simular el procesamiento del router
$uri = '/logout';
echo "<div class='code'>";
echo "<strong>URI a procesar:</strong> $uri<br>";

// Leer el router
$router_file = __DIR__ . '/../app/core/Router.php';
if (file_exists($router_file)) {
    echo "<strong>Router existe:</strong> ✅<br>";
    
    // Buscar el patrón de logout en el router
    $router_content = file_get_contents($router_file);
    if (strpos($router_content, 'logout') !== false) {
        echo "<strong>Contiene 'logout':</strong> ✅<br>";
    } else {
        echo "<strong>Contiene 'logout':</strong> ❌<br>";
    }
} else {
    echo "<strong>Router existe:</strong> ❌<br>";
}
echo "</div>";
echo "</div>";

// 6. Verificar permisos
echo "<div class='debug-section'>";
echo "<h3>6. Verificación de Permisos</h3>";

$files_to_check = [
    __DIR__ . '/../app/controllers/AuthController.php',
    __DIR__ . '/../app/views/auth/logout_success.php',
    __DIR__ . '/../public/index.php'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        $perms = fileperms($file);
        $perms_str = substr(sprintf('%o', $perms), -4);
        echo "<div class='code'>";
        echo basename($file) . ": " . $perms_str . " ";
        if (is_readable($file)) echo "✅ Readable ";
        if (is_writable($file)) echo "✅ Writable ";
        echo "</div>";
    }
}
echo "</div>";

// 7. Test directo de AuthController
echo "<div class='debug-section'>";
echo "<h3>7. Test Directo de AuthController</h3>";

try {
    require_once __DIR__ . '/../app/controllers/AuthController.php';
    echo "<div class='alert alert-success'>";
    echo "✅ AuthController cargado correctamente";
    echo "</div>";
    
    if (class_exists('AuthController')) {
        echo "<div class='alert alert-success'>";
        echo "✅ Clase AuthController existe";
        echo "</div>";
        
        if (method_exists('AuthController', 'logout')) {
            echo "<div class='alert alert-success'>";
            echo "✅ Método logout() existe en AuthController";
            echo "</div>";
        } else {
            echo "<div class='alert alert-danger'>";
            echo "❌ Método logout() NO existe en AuthController";
            echo "</div>";
        }
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>";
    echo "❌ Error cargando AuthController: " . $e->getMessage();
    echo "</div>";
}
echo "</div>";

// JavaScript para tests
echo "<script>
function testUrl(url, name) {
    const resultDiv = document.getElementById('result_' + btoa(name).replace(/[^a-zA-Z0-9]/g, ''));
    resultDiv.innerHTML = '<small class=\"text-info\">Probando...</small>';
    
    fetch(url, {
        method: 'GET',
        credentials: 'include',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        resultDiv.innerHTML = '<small class=\"text-' + (response.ok ? 'success' : 'danger') + '\">Status: ' + response.status + ' ' + response.statusText + '</small>';
    })
    .catch(error => {
        resultDiv.innerHTML = '<small class=\"text-danger\">Error: ' + error.message + '</small>';
    });
}
</script>";

echo "</div>"; // container
echo "</body></html>";
?>