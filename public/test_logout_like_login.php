<?php
// Test logout imitando exactamente la estructura del método login
session_start();

// Simular logout con la misma estructura que login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
    
    // Copiar exactamente la estructura del método login
    // En login: se valida usuario, se asigna a session, se hace redirect
    // En logout: se valida session, se limpia session, se hace redirect
    
    if (isset($_SESSION['user_id'])) {
        // Limpiar sesión (equivalente a validar usuario en login)
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        
        // Redirect exactamente como lo hace login
        require_once __DIR__ . '/../config/config.php';
        
        // Use BASE_URL for internal redirects (copiado del método redirect)
        $url = '/';
        if (strpos($url, 'http') !== 0) {
            $url = BASE_URL . $url;
        }
        
        header('Location: ' . $url);
        exit;
        
    } else {
        // No hay sesión (equivalente a credenciales incorrectas en login)
        require_once __DIR__ . '/../config/config.php';
        
        $url = '/login';
        if (strpos($url, 'http') !== 0) {
            $url = BASE_URL . $url;
        }
        
        header('Location: ' . $url);
        exit;
    }
}

// Mostrar formulario si no es POST
require_once __DIR__ . '/../config/config.php';

echo "<!DOCTYPE html><html><head>";
echo "<title>Test Logout Like Login</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "</head><body class='bg-light'>";

echo "<div class='container mt-5'>";
echo "<div class='row justify-content-center'>";
echo "<div class='col-md-6'>";
echo "<div class='card'>";
echo "<div class='card-body'>";

echo "<h3 class='text-center mb-4'>Test: Logout con Estructura de Login</h3>";

if (isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-info'>";
    echo "<h5>Usuario Actual:</h5>";
    echo "<strong>Username:</strong> " . $_SESSION['username'] . "<br>";
    echo "<strong>ID:</strong> " . $_SESSION['user_id'] . "<br>";
    echo "<strong>Rol:</strong> " . $_SESSION['role'];
    echo "</div>";
    
    echo "<p>Este test usa exactamente la misma estructura que el método login() que funciona correctamente.</p>";
    
    echo "<form method='POST'>";
    echo "<input type='hidden' name='action' value='logout'>";
    echo "<button type='submit' class='btn btn-danger btn-lg w-100'>";
    echo "Hacer Logout (Estructura de Login)";
    echo "</button>";
    echo "</form>";
    
} else {
    echo "<div class='alert alert-success'>";
    echo "<h5>✅ Logout Exitoso!</h5>";
    echo "<p>No hay sesión activa. El logout funcionó correctamente.</p>";
    echo "</div>";
    
    echo "<a href='" . BASE_URL . "/login' class='btn btn-primary'>";
    echo "Iniciar Sesión Nuevamente";
    echo "</a>";
}

echo "<div class='mt-4'>";
echo "<h6>Diferencias con logout original:</h6>";
echo "<ul class='small'>";
echo "<li>✅ Usa la misma estructura if/else que login</li>";
echo "<li>✅ Copia exactamente el código del método redirect()</li>";
echo "<li>✅ Maneja el caso de 'no sesión' como login maneja 'credenciales incorrectas'</li>";
echo "<li>✅ exit; inmediato después de header como en otros métodos</li>";
echo "</ul>";
echo "</div>";

echo "</div></div></div></div></div>";
echo "</body></html>";
?>