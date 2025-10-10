<?php
// Diagnóstico completo del flujo logout
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Capturar toda la información ANTES de tocar la sesión
$debug_info = [];
$debug_info['timestamp'] = date('Y-m-d H:i:s');
$debug_info['request_method'] = $_SERVER['REQUEST_METHOD'];
$debug_info['request_uri'] = $_SERVER['REQUEST_URI'];
$debug_info['script_name'] = $_SERVER['SCRIPT_NAME'];
$debug_info['query_string'] = $_SERVER['QUERY_STRING'] ?? '';

session_start();
require_once __DIR__ . '/../config/config.php';

$debug_info['session_id_initial'] = session_id();
$debug_info['session_data_initial'] = $_SESSION;
$debug_info['base_url'] = BASE_URL;

// Si es una petición al logout, hacer debug completo
if (strpos($_SERVER['REQUEST_URI'], '/logout') !== false && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $debug_info['is_logout_request'] = true;
    
    // Verificar si está autenticado
    $debug_info['is_authenticated'] = isset($_SESSION['user_id']);
    
    if (isset($_SESSION['user_id'])) {
        $debug_info['user_id'] = $_SESSION['user_id'];
        $debug_info['username'] = $_SESSION['username'] ?? null;
    }
    
    // NO EJECUTAR EL LOGOUT REAL, solo diagnosticar
} else {
    $debug_info['is_logout_request'] = false;
}

echo "<!DOCTYPE html><html><head>";
echo "<title>Diagnóstico Completo - Flujo Logout</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css'>";
echo "</head><body class='bg-light'>";

echo "<div class='container mt-4'>";
echo "<h1 class='text-center mb-4'><i class='bi bi-bug'></i> Diagnóstico Completo - Flujo Logout</h1>";

// Mostrar información de debug
echo "<div class='card'>";
echo "<div class='card-body'>";
echo "<h3>📊 Información de Debug Capturada</h3>";
echo "<pre class='bg-dark text-light p-3 rounded'>";
echo json_encode($debug_info, JSON_PRETTY_PRINT);
echo "</pre>";
echo "</div></div>";

// Estado actual de la sesión
echo "<div class='card mt-4'>";
echo "<div class='card-body'>";
echo "<h3>👤 Estado Actual de la Sesión</h3>";

if (isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-success'>";
    echo "<h5>✅ Usuario Logueado</h5>";
    echo "<strong>ID:</strong> " . $_SESSION['user_id'] . "<br>";
    echo "<strong>Username:</strong> " . ($_SESSION['username'] ?? 'N/A') . "<br>";
    echo "<strong>Rol:</strong> " . ($_SESSION['role'] ?? 'N/A') . "<br>";
    echo "<strong>Session ID:</strong> " . session_id();
    echo "</div>";
    
    $can_test = true;
} else {
    echo "<div class='alert alert-warning'>";
    echo "<h5>⚠️ No hay sesión activa</h5>";
    echo "<strong>Session ID:</strong> " . session_id();
    echo "</div>";
    
    $can_test = false;
}

echo "</div></div>";

// Test detallado del router
echo "<div class='card mt-4'>";
echo "<div class='card-body'>";
echo "<h3>🛣️ Test Detallado del Router</h3>";

// Verificar que el router esté configurado
$router_file = __DIR__ . '/index.php';
if (file_exists($router_file)) {
    $router_content = file_get_contents($router_file);
    
    echo "<h5>Verificación de Rutas en index.php:</h5>";
    
    if (strpos($router_content, "get('/logout'") !== false) {
        echo "<div class='alert alert-success'>";
        echo "✅ Ruta GET /logout encontrada en index.php";
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger'>";
        echo "❌ Ruta GET /logout NO encontrada en index.php";
        echo "</div>";
    }
    
    if (strpos($router_content, 'AuthController') !== false) {
        echo "<div class='alert alert-success'>";
        echo "✅ AuthController referenciado en index.php";
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger'>";
        echo "❌ AuthController NO referenciado en index.php";
        echo "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>";
    echo "❌ Archivo index.php no encontrado";
    echo "</div>";
}

echo "</div></div>";

// Test del AuthController
echo "<div class='card mt-4'>";
echo "<div class='card-body'>";
echo "<h3>🎛️ Test del AuthController</h3>";

$auth_file = __DIR__ . '/../app/controllers/AuthController.php';
if (file_exists($auth_file)) {
    echo "<div class='alert alert-success'>";
    echo "✅ AuthController.php existe";
    echo "</div>";
    
    $auth_content = file_get_contents($auth_file);
    
    if (strpos($auth_content, 'public function logout()') !== false) {
        echo "<div class='alert alert-success'>";
        echo "✅ Método logout() encontrado en AuthController";
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger'>";
        echo "❌ Método logout() NO encontrado en AuthController";
        echo "</div>";
    }
    
    if (strpos($auth_content, '$this->redirect') !== false) {
        echo "<div class='alert alert-success'>";
        echo "✅ Método redirect() usado en AuthController";
        echo "</div>";
    } else {
        echo "<div class='alert alert-warning'>";
        echo "⚠️ Método redirect() NO encontrado en AuthController";
        echo "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>";
    echo "❌ AuthController.php no encontrado";
    echo "</div>";
}

echo "</div></div>";

// Test práctico
if ($can_test) {
    echo "<div class='card mt-4'>";
    echo "<div class='card-body'>";
    echo "<h3>🧪 Test Práctico</h3>";
    
    echo "<div class='alert alert-primary'>";
    echo "<h5>Opciones de Test:</h5>";
    echo "<p>Puedes probar diferentes métodos para identificar dónde está el problema:</p>";
    echo "</div>";
    
    echo "<div class='row'>";
    
    echo "<div class='col-md-4'>";
    echo "<h6>1. Logout Original:</h6>";
    echo "<a href='" . BASE_URL . "/logout' class='btn btn-danger w-100 mb-2'>";
    echo "<i class='bi bi-box-arrow-right'></i> Logout Normal";
    echo "</a>";
    echo "<small class='text-muted'>El botón que no funciona</small>";
    echo "</div>";
    
    echo "<div class='col-md-4'>";
    echo "<h6>2. Test con Parámetros:</h6>";
    echo "<a href='" . BASE_URL . "/logout?debug=1' class='btn btn-warning w-100 mb-2'>";
    echo "<i class='bi bi-gear'></i> Logout + Debug";
    echo "</a>";
    echo "<small class='text-muted'>Con parámetro de debug</small>";
    echo "</div>";
    
    echo "<div class='col-md-4'>";
    echo "<h6>3. Test Directo:</h6>";
    echo "<a href='logout_test_directo.php' class='btn btn-info w-100 mb-2'>";
    echo "<i class='bi bi-tools'></i> Test Directo";
    echo "</a>";
    echo "<small class='text-muted'>Bypass del router</small>";
    echo "</div>";
    
    echo "</div>";
    
    echo "</div></div>";
}

// Información adicional
echo "<div class='card mt-4'>";
echo "<div class='card-body'>";
echo "<h3>ℹ️ Información Adicional</h3>";

echo "<div class='row'>";
echo "<div class='col-md-6'>";
echo "<h5>Variables del Servidor:</h5>";
echo "<div class='bg-light p-3 rounded small'>";
echo "<strong>HTTP_HOST:</strong> " . $_SERVER['HTTP_HOST'] . "<br>";
echo "<strong>REQUEST_URI:</strong> " . $_SERVER['REQUEST_URI'] . "<br>";
echo "<strong>SCRIPT_NAME:</strong> " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "<strong>REQUEST_METHOD:</strong> " . $_SERVER['REQUEST_METHOD'] . "<br>";
echo "<strong>HTTPS:</strong> " . (isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : 'No') . "<br>";
echo "</div>";
echo "</div>";

echo "<div class='col-md-6'>";
echo "<h5>Headers de Respuesta:</h5>";
echo "<div class='bg-light p-3 rounded small'>";
$headers = headers_list();
if (empty($headers)) {
    echo "No hay headers enviados aún<br>";
} else {
    foreach ($headers as $header) {
        echo htmlspecialchars($header) . "<br>";
    }
}
echo "</div>";
echo "</div>";
echo "</div>";

echo "</div></div>";

echo "<div class='text-center mt-4'>";
echo "<a href='test_boton_logout.php' class='btn btn-outline-primary me-2'>";
echo "<i class='bi bi-mouse'></i> Test Botón";
echo "</a>";
echo "<a href='verificacion_tiempo_real.php' class='btn btn-outline-info'>";
echo "<i class='bi bi-clock'></i> Verificación Tiempo Real";
echo "</a>";
echo "</div>";

echo "</div></body></html>";
?>