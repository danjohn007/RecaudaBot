<?php
// Logout ultra simple - sin dependencias
session_start();

// Log básico
$user_id = $_SESSION['user_id'] ?? 'unknown';
error_log("Simple logout - User: $user_id - " . date('Y-m-d H:i:s'));

// Limpiar todo
$_SESSION = array();

// Destruir cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Destruir sesión
session_destroy();

// Headers
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Definir URLs de forma más segura
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$path = dirname($_SERVER['REQUEST_URI']);
$path = rtrim($path, '/');

// URLs específicas
$base_url = $protocol . $host . $path;
$login_url = $base_url . '/login';
$home_url = $protocol . $host; // Root del dominio para evitar 403
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión Cerrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .logout-card { box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1); border: none; border-radius: 15px; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        .countdown { font-weight: bold; color: #0d6efd; }
    </style>
</head>
<body class="d-flex align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card logout-card fade-in">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="card-title mb-3">¡Sesión Cerrada!</h2>
                    <p class="text-muted mb-3">Tu sesión se ha cerrado correctamente.</p>
                    <p class="text-muted mb-4">
                        Serás redirigido al login en <span id="countdown" class="countdown">3</span> segundos...
                    </p>
                    <div class="d-grid gap-2">
                        <a href="<?php echo $login_url; ?>" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Ir al Login Ahora
                        </a>
                        <a href="<?php echo $home_url; ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-house"></i> Ir al Sitio Principal
                        </a>
                    </div>
                    
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i> Logout realizado de forma segura
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Contador regresivo
let countdown = 3;
const countdownElement = document.getElementById('countdown');

function updateCountdown() {
    if (countdownElement) {
        countdownElement.textContent = countdown;
    }
    countdown--;
    
    if (countdown < 0) {
        // Intentar redirección a login
        try {
            window.location.replace('<?php echo $login_url; ?>');
        } catch (e) {
            console.log('Error en redirección a login, intentando página principal...');
            window.location.replace('<?php echo $home_url; ?>');
        }
    }
}

// Iniciar countdown
const interval = setInterval(updateCountdown, 1000);

// Redirección de emergencia múltiple
setTimeout(function() {
    console.log('Redirección de emergencia a login...');
    try {
        window.location.href = '<?php echo $login_url; ?>';
    } catch (e) {
        console.log('Error en login, redirigiendo a home...');
        window.location.href = '<?php echo $home_url; ?>';
    }
}, 4000);

// Limpiar storage como medida adicional
if (typeof(Storage) !== "undefined") {
    localStorage.clear();
    sessionStorage.clear();
}

// Limpiar cookies adicionales
document.cookie.split(";").forEach(function(c) { 
    document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); 
});

console.log('Logout simple completado - Redirigiendo a login...');
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>