<?php
// Test directo del logout para diagnosticar el 403
require_once '../config/config.php';

// Iniciar sesión para el test
session_start();

echo "<!DOCTYPE html>";
echo "<html><head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Diagnóstico 403 - Logout</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css' rel='stylesheet'>";
echo "</head><body class='bg-light'>";

echo "<div class='container mt-4'>";
echo "<h1 class='text-center mb-4'><i class='bi bi-bug'></i> Diagnóstico Error 403 - Logout</h1>";

// Información del sistema
echo "<div class='row mb-4'>";
echo "<div class='col-12'>";
echo "<div class='card'>";
echo "<div class='card-header bg-info text-white'>";
echo "<h5><i class='bi bi-info-circle'></i> Información del Sistema</h5>";
echo "</div>";
echo "<div class='card-body'>";

echo "<p><strong>BASE_URL:</strong> " . BASE_URL . "</p>";
echo "<p><strong>Logout URL:</strong> " . BASE_URL . "/logout</p>";
echo "<p><strong>Método HTTP:</strong> " . $_SERVER['REQUEST_METHOD'] . "</p>";
echo "<p><strong>URL actual:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p><strong>HTTPS:</strong> " . (isset($_SERVER['HTTPS']) ? 'Sí' : 'No') . "</p>";

// Estado de la sesión
echo "<h6 class='mt-3'>Estado de la Sesión:</h6>";
echo "<p><strong>Session Status:</strong> " . session_status() . "</p>";
echo "<p><strong>Session ID:</strong> " . session_id() . "</p>";
echo "<p><strong>User ID en sesión:</strong> " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'No definido') . "</p>";

echo "</div></div></div></div>";

// Test 1: Comprobar si el router puede manejar /logout
echo "<div class='row mb-4'>";
echo "<div class='col-12'>";
echo "<div class='card'>";
echo "<div class='card-header bg-warning text-dark'>";
echo "<h5><i class='bi bi-1-circle'></i> Test 1: Router y Rutas</h5>";
echo "</div>";
echo "<div class='card-body'>";

// Simular el comportamiento del router
try {
    echo "<p><strong>Simulando router...</strong></p>";
    
    // Incluir el router para ver si hay errores
    require_once '../app/core/Router.php';
    $router = new Router();
    
    echo "<p class='text-success'>✅ Router cargado correctamente</p>";
    
    // Comprobar si AuthController existe
    if (file_exists('../app/controllers/AuthController.php')) {
        echo "<p class='text-success'>✅ AuthController.php existe</p>";
        
        require_once '../app/controllers/AuthController.php';
        $authController = new AuthController();
        
        if (method_exists($authController, 'logout')) {
            echo "<p class='text-success'>✅ Método logout() existe en AuthController</p>";
        } else {
            echo "<p class='text-danger'>❌ Método logout() NO existe en AuthController</p>";
        }
    } else {
        echo "<p class='text-danger'>❌ AuthController.php NO existe</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='text-danger'>❌ Error en router: " . $e->getMessage() . "</p>";
}

echo "</div></div></div></div>";

// Test 2: Test directo del método logout
echo "<div class='row mb-4'>";
echo "<div class='col-12'>";
echo "<div class='card'>";
echo "<div class='card-header bg-danger text-white'>";
echo "<h5><i class='bi bi-2-circle'></i> Test 2: Método Logout Directo</h5>";
echo "</div>";
echo "<div class='card-body'>";

try {
    echo "<p><strong>Probando método logout directamente...</strong></p>";
    
    // Crear sesión de prueba
    $_SESSION['user_id'] = 999;
    $_SESSION['username'] = 'test_user';
    echo "<p>📝 Sesión de prueba creada: user_id=999</p>";
    
    // AQUÍ ES DONDE VAMOS A PROBAR EL LOGOUT
    echo "<p><strong>⚠️ Antes de logout:</strong></p>";
    echo "<p>Session ID: " . session_id() . "</p>";
    echo "<p>User ID: " . $_SESSION['user_id'] . "</p>";
    
    echo "<hr>";
    echo "<p><strong>🚀 Simulando logout...</strong></p>";
    
    // En lugar de llamar al logout completo, vamos a hacer los pasos uno por uno
    echo "<p>1. Limpiando sesión...</p>";
    $_SESSION = array();
    echo "<p class='text-success'>✅ $_SESSION limpiado</p>";
    
    echo "<p>2. Destruyendo cookie de sesión...</p>";
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
        echo "<p class='text-success'>✅ Cookie de sesión destruida</p>";
    }
    
    echo "<p>3. Destruyendo sesión...</p>";
    session_destroy();
    echo "<p class='text-success'>✅ Sesión destruida</p>";
    
    echo "<p class='text-success'><strong>✅ Logout simulado exitoso</strong></p>";
    
} catch (Exception $e) {
    echo "<p class='text-danger'>❌ Error en logout: " . $e->getMessage() . "</p>";
}

echo "</div></div></div></div>";

// Test 3: Verificar permisos y .htaccess
echo "<div class='row mb-4'>";
echo "<div class='col-12'>";
echo "<div class='card'>";
echo "<div class='card-header bg-secondary text-white'>";
echo "<h5><i class='bi bi-3-circle'></i> Test 3: Permisos y Configuración</h5>";
echo "</div>";
echo "<div class='card-body'>";

echo "<p><strong>Verificando configuración del servidor...</strong></p>";

// Verificar .htaccess
if (file_exists('../.htaccess')) {
    echo "<p class='text-success'>✅ .htaccess existe en raíz</p>";
} else {
    echo "<p class='text-warning'>⚠️ .htaccess NO encontrado en raíz</p>";
}

if (file_exists('.htaccess')) {
    echo "<p class='text-success'>✅ .htaccess existe en public/</p>";
    echo "<p>Contenido del .htaccess en public/:</p>";
    echo "<pre>" . htmlspecialchars(file_get_contents('.htaccess')) . "</pre>";
} else {
    echo "<p class='text-warning'>⚠️ .htaccess NO encontrado en public/</p>";
}

// Headers de respuesta
echo "<p><strong>Headers HTTP actuales:</strong></p>";
echo "<pre>";
foreach (headers_list() as $header) {
    echo htmlspecialchars($header) . "\n";
}
echo "</pre>";

echo "</div></div></div></div>";

// Botón para probar logout real
echo "<div class='row mb-4'>";
echo "<div class='col-12 text-center'>";
echo "<div class='card'>";
echo "<div class='card-header bg-primary text-white'>";
echo "<h5><i class='bi bi-play-circle'></i> Test Real de Logout</h5>";
echo "</div>";
echo "<div class='card-body'>";

// Recrear sesión para el test real
session_start();
$_SESSION['user_id'] = 888;
$_SESSION['username'] = 'test_logout';

echo "<p>Sesión recreada para test: user_id=888</p>";
echo "<p><strong>⚠️ Este botón hará logout REAL:</strong></p>";

echo "<a href='" . BASE_URL . "/logout' class='btn btn-danger btn-lg me-3'>";
echo "<i class='bi bi-box-arrow-right'></i> LOGOUT REAL";
echo "</a>";

echo "<a href='#' onclick='location.reload()' class='btn btn-secondary'>";
echo "<i class='bi bi-arrow-clockwise'></i> Recargar Diagnóstico";
echo "</a>";

echo "</div></div></div></div>";

echo "</div>"; // container

echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>";
echo "</body></html>";
?>