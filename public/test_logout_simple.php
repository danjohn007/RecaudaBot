<?php
// Test directo del método logout - versión simplificada
session_start();

echo "<!DOCTYPE html><html><head>";
echo "<title>Test Logout Directo</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "</head><body class='bg-light'>";

echo "<div class='container mt-5'>";
echo "<h2 class='text-center'>🧪 Test Logout Directo - Simplificado</h2>";

require_once __DIR__ . '/../config/config.php';

if (isset($_SESSION['user_id'])) {
    $user_info = [
        'username' => $_SESSION['username'] ?? 'N/A',
        'user_id' => $_SESSION['user_id']
    ];
    
    echo "<div class='alert alert-info'>";
    echo "Usuario actual: " . $user_info['username'] . " (ID: " . $user_info['user_id'] . ")";
    echo "</div>";
    
    echo "<form method='POST' action=''>";
    echo "<input type='hidden' name='action' value='logout'>";
    echo "<button type='submit' class='btn btn-danger'>Hacer Logout Simplificado</button>";
    echo "</form>";
} else {
    echo "<div class='alert alert-success'>";
    echo "✅ No hay sesión activa - Logout exitoso";
    echo "</div>";
    
    echo "<a href='" . BASE_URL . "' class='btn btn-primary'>Ir a Página Principal</a>";
}

// Procesar logout si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'logout') {
    echo "<div class='alert alert-warning'>";
    echo "🔄 Procesando logout...";
    echo "</div>";
    
    // Método de logout simplificado
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
    
    echo "<div class='alert alert-success'>";
    echo "✅ Logout completado. Redirigiendo...";
    echo "</div>";
    
    echo "<script>
    setTimeout(function() {
        window.location.href = '" . BASE_URL . "';
    }, 2000);
    </script>";
}

echo "</div></body></html>";
?>