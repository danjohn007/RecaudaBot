<?php
// Test directo del logout - Simulación exacta del AuthController
session_start();

echo "<!DOCTYPE html><html><head>";
echo "<title>Test Directo - Simulación AuthController Logout</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css'>";
echo "</head><body class='bg-light'>";

echo "<div class='container mt-4'>";
echo "<h1 class='text-center mb-4'><i class='bi bi-gear'></i> Test Directo - Simulación AuthController</h1>";

require_once __DIR__ . '/../config/config.php';

// Simular exactamente el método isAuthenticated() del Controller
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

// Simular exactamente el método redirect() del Controller
function simulateRedirect($url) {
    // Use BASE_URL for internal redirects
    if (strpos($url, 'http') !== 0) {
        $url = BASE_URL . $url;
    }
    return $url; // En lugar de hacer redirect, devolvemos la URL para mostrar
}

echo "<div class='card'>";
echo "<div class='card-body'>";
echo "<h3>🔍 Simulación Paso a Paso del Método logout()</h3>";

echo "<div class='row'>";
echo "<div class='col-md-6'>";
echo "<h5>Estado Inicial:</h5>";

if (isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-info'>";
    echo "<strong>Usuario logueado:</strong><br>";
    echo "ID: " . $_SESSION['user_id'] . "<br>";
    echo "Username: " . ($_SESSION['username'] ?? 'N/A') . "<br>";
    echo "Role: " . ($_SESSION['role'] ?? 'N/A');
    echo "</div>";
} else {
    echo "<div class='alert alert-warning'>";
    echo "No hay sesión activa";
    echo "</div>";
}

echo "</div>";
echo "<div class='col-md-6'>";
echo "<h5>Configuración:</h5>";
echo "<div class='bg-light p-3 rounded'>";
echo "BASE_URL: " . BASE_URL . "<br>";
echo "Session ID: " . session_id() . "<br>";
echo "Time: " . date('H:i:s');
echo "</div>";
echo "</div>";
echo "</div>";

echo "<hr>";

// Simular el flujo exacto del método logout
echo "<h4>📋 Simulación del flujo logout():</h4>";

echo "<div class='bg-light p-4 rounded'>";
echo "<h6>1. Verificación: if (\$this->isAuthenticated())</h6>";

if (isAuthenticated()) {
    echo "<div class='alert alert-success'>✅ isAuthenticated() = TRUE - Continuar con logout</div>";
    
    echo "<h6>2. Obtener user_id para audit log</h6>";
    $user_id = $_SESSION['user_id'] ?? null;
    echo "<div class='alert alert-info'>user_id capturado: " . ($user_id ?? 'null') . "</div>";
    
    echo "<h6>3. Limpiar sesión: \$_SESSION = array()</h6>";
    echo "<div class='alert alert-warning'>⚠️ En test real: \$_SESSION se limpiaría aquí</div>";
    
    echo "<h6>4. Destruir cookie de sesión</h6>";
    echo "<div class='alert alert-warning'>⚠️ En test real: setcookie() con tiempo pasado</div>";
    
    echo "<h6>5. session_destroy()</h6>";
    echo "<div class='alert alert-warning'>⚠️ En test real: session_destroy() se ejecutaría</div>";
    
    echo "<h6>6. Redirección: \$this->redirect('/')</h6>";
    $redirect_url = simulateRedirect('/');
    echo "<div class='alert alert-success'>";
    echo "✅ Redirect URL calculada: <strong>" . $redirect_url . "</strong><br>";
    echo "Debería llevarte a la página principal con botones de login/registro";
    echo "</div>";
    
} else {
    echo "<div class='alert alert-warning'>⚠️ isAuthenticated() = FALSE - Ejecutar else</div>";
    
    echo "<h6>Rama ELSE: \$this->redirect('/login')</h6>";
    $redirect_url = simulateRedirect('/login');
    echo "<div class='alert alert-info'>";
    echo "Redirect URL: <strong>" . $redirect_url . "</strong><br>";
    echo "Te llevaría a la página de login";
    echo "</div>";
}

echo "</div>";

echo "<hr>";

echo "<h4>🧪 Tests Prácticos:</h4>";

if (isAuthenticated()) {
    echo "<div class='row'>";
    echo "<div class='col-md-6'>";
    echo "<h6>Test 1: Logout Real</h6>";
    echo "<a href='" . BASE_URL . "/logout' class='btn btn-danger w-100'>";
    echo "<i class='bi bi-box-arrow-right'></i> Ejecutar Logout Real";
    echo "</a>";
    echo "<small class='text-muted'>Usará el método AuthController::logout()</small>";
    echo "</div>";
    
    echo "<div class='col-md-6'>";
    echo "<h6>Test 2: Logout Manual</h6>";
    echo "<form method='POST' action=''>";
    echo "<input type='hidden' name='manual_logout' value='1'>";
    echo "<button type='submit' class='btn btn-warning w-100'>";
    echo "<i class='bi bi-gear'></i> Logout Manual";
    echo "</button>";
    echo "</form>";
    echo "<small class='text-muted'>Simulación exacta aquí</small>";
    echo "</div>";
    echo "</div>";
} else {
    echo "<div class='alert alert-success'>";
    echo "<h5>✅ Estado Post-Logout Detectado</h5>";
    echo "<p>No hay sesión activa, lo que indica que un logout fue exitoso.</p>";
    echo "</div>";
    
    echo "<a href='" . BASE_URL . "/login' class='btn btn-primary'>";
    echo "<i class='bi bi-box-arrow-in-right'></i> Ir a Login para Probar Nuevamente";
    echo "</a>";
}

// Procesar logout manual si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['manual_logout'])) {
    echo "<div class='alert alert-warning mt-4'>";
    echo "<h5>🔄 Ejecutando Logout Manual...</h5>";
    
    // Simular el logout exacto
    if (isAuthenticated()) {
        $user_id = $_SESSION['user_id'] ?? null;
        
        echo "<p>1. ✅ Usuario autenticado (ID: $user_id)</p>";
        echo "<p>2. 🧹 Limpiando \$_SESSION...</p>";
        
        $_SESSION = array();
        
        echo "<p>3. 🍪 Eliminando cookie de sesión...</p>";
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        echo "<p>4. 💥 Ejecutando session_destroy()...</p>";
        session_destroy();
        
        echo "<p>5. ➡️ Preparando redirección a: " . BASE_URL . "</p>";
        
        echo "<div class='alert alert-success'>";
        echo "<h6>✅ Logout Manual Completado</h6>";
        echo "<p>Redirigiendo en 3 segundos...</p>";
        echo "</div>";
        
        echo "<script>
        setTimeout(function() {
            window.location.href = '" . BASE_URL . "';
        }, 3000);
        </script>";
    }
    echo "</div>";
}

echo "</div></div>";

echo "<div class='mt-4 text-center'>";
echo "<a href='verificacion_tiempo_real.php' class='btn btn-outline-primary me-2'>";
echo "<i class='bi bi-clock'></i> Verificación Tiempo Real";
echo "</a>";
echo "<a href='" . BASE_URL . "' class='btn btn-outline-secondary'>";
echo "<i class='bi bi-house'></i> Página Principal";
echo "</a>";
echo "</div>";

echo "</div></body></html>";
?>