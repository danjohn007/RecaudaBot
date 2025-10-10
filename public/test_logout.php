<?php
// Enhanced logout test
session_start();
require_once __DIR__ . '/../config/config.php';

echo "<!DOCTYPE html>";
echo "<html><head><title>Test Logout Enhanced</title>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .test-box { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border: 1px solid #dee2e6; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .button { background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin: 5px; display: inline-block; }
    .button.danger { background: #dc3545; }
</style>";
echo "</head><body>";
echo "<h1>Test de Logout Mejorado</h1>";

echo "<div class='test-box'>";
echo "<h2>Estado Actual de Sesión:</h2>";
if (isset($_SESSION['user_id'])) {
    echo "<p class='success'>✓ Usuario logueado: " . htmlspecialchars($_SESSION['username'] ?? 'N/A') . "</p>";
    echo "<p>ID: " . ($_SESSION['user_id'] ?? 'N/A') . "</p>";
    echo "<p>Role: " . ($_SESSION['role'] ?? 'N/A') . "</p>";
    echo "<p>Full Name: " . htmlspecialchars($_SESSION['full_name'] ?? 'N/A') . "</p>";
} else {
    echo "<p class='error'>✗ No hay sesión activa</p>";
}
echo "</div>";

echo "<div class='test-box'>";
echo "<h2>Configuración de URLs:</h2>";
echo "<p><strong>BASE_URL:</strong> " . BASE_URL . "</p>";
echo "<p><strong>PUBLIC_URL:</strong> " . PUBLIC_URL . "</p>";
echo "<p><strong>REQUEST_URI:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p><strong>SCRIPT_NAME:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "</div>";

echo "<div class='test-box'>";
echo "<h2>Pruebas de Logout:</h2>";
echo "<p><a href='" . BASE_URL . "/logout' class='button danger'>Logout Normal: " . BASE_URL . "/logout</a></p>";
echo "<p><a href='" . BASE_URL . "/public/logout' class='button danger'>Logout Public: " . BASE_URL . "/public/logout</a></p>";
echo "<p><a href='" . BASE_URL . "/public/logout_direct.php' class='button danger'>Logout Directo</a></p>";
echo "</div>";

// Manual logout test
if (isset($_GET['manual_logout'])) {
    echo "<div class='test-box'>";
    echo "<h2>Ejecutando Logout Manual:</h2>";
    try {
        // Clear session
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        session_start();
        $_SESSION['success'] = 'Logout manual exitoso';
        
        echo "<p class='success'>✓ Logout manual ejecutado correctamente</p>";
        echo "<p><a href='?' class='button'>Recargar página para verificar</a></p>";
        
    } catch (Exception $e) {
        echo "<p class='error'>✗ Error en logout manual: " . $e->getMessage() . "</p>";
    }
    echo "</div>";
}

echo "<div class='test-box'>";
echo "<h2>Acciones de Prueba:</h2>";
echo "<p><a href='?manual_logout=1' class='button danger'>Ejecutar Logout Manual</a></p>";
echo "<p><a href='" . BASE_URL . "/login' class='button'>Ir a Login</a></p>";
echo "<p><a href='" . BASE_URL . "' class='button'>Ir al Inicio</a></p>";
echo "</div>";

echo "<div class='test-box'>";
echo "<h2>JavaScript Test:</h2>";
echo "<button onclick='testLogoutJS()' class='button danger'>Test Logout con JS</button>";
echo "<script>
function testLogoutJS() {
    console.log('Testing logout with JavaScript');
    const baseUrl = '" . BASE_URL . "';
    
    fetch(baseUrl + '/logout', {
        method: 'GET',
        credentials: 'include'
    }).then(response => {
        console.log('Response status:', response.status);
        if (response.ok) {
            alert('Logout exitoso, redirigiendo...');
            window.location.href = baseUrl;
        } else {
            alert('Error en logout, probando método alternativo...');
            window.location.href = baseUrl + '/public/logout_direct.php';
        }
    }).catch(error => {
        console.error('Error:', error);
        alert('Error de conexión, usando logout directo...');
        window.location.href = baseUrl + '/public/logout_direct.php';
    });
}
</script>";
echo "</div>";

echo "</body></html>";
?>