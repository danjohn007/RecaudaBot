<?php
// Logout directo sin router - para evitar el 403
require_once '../config/config.php';
require_once '../app/models/AuditLog.php';

// Iniciar sesión
session_start();

// Log del intento
error_log("Logout directo - IP: " . $_SERVER['REMOTE_ADDR'] . " - Time: " . date('Y-m-d H:i:s'));

// Variables para auditoría
$user_id = $_SESSION['user_id'] ?? null;

try {
    // Log de auditoría si hay usuario
    if ($user_id) {
        $auditLog = new AuditLog();
        $auditLog->log($user_id, 'logout_direct');
    }
    
    // Limpiar sesión
    $_SESSION = array();
    
    // Destruir cookie de sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destruir sesión
    session_destroy();
    
    // Limpiar cookies adicionales
    setcookie('user_session', '', time() - 3600, '/');
    setcookie('remember_token', '', time() - 3600, '/');
    
    // Headers de seguridad
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
} catch (Exception $e) {
    error_log("Error en logout directo: " . $e->getMessage());
}

// Página de logout con redirección
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrando sesión...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .logout-card { 
            box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1);
            border: none;
            border-radius: 15px;
        }
        .spinner-border { animation: spin 1s linear infinite; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeIn 0.8s ease-out; }
    </style>
</head>
<body class="d-flex align-items-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card logout-card fade-in">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="bi bi-box-arrow-right text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h2 class="card-title mb-3">Cerrando sesión...</h2>
                    
                    <div class="mb-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cerrando sesión...</span>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-4">
                        Tu sesión se ha cerrado correctamente.<br>
                        Serás redirigido en <span id="countdown">3</span> segundos...
                    </p>
                    
                    <div class="d-grid gap-2">
                        <a href="<?php echo BASE_URL; ?>/" class="btn btn-primary">
                            <i class="bi bi-house"></i> Ir al inicio ahora
                        </a>
                        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline-secondary">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión nuevamente
                        </a>
                    </div>
                    
                    <div class="mt-4 p-3 bg-light rounded">
                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i> Sesión cerrada de forma segura
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
    countdownElement.textContent = countdown;
    countdown--;
    
    if (countdown < 0) {
        // Limpiar storage del navegador
        if (typeof(Storage) !== "undefined") {
            localStorage.clear();
            sessionStorage.clear();
        }
        
        // Limpiar cookies del lado del cliente
        document.cookie.split(";").forEach(function(c) { 
            document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); 
        });
        
        // Redireccionar
        window.location.replace('<?php echo BASE_URL; ?>/');
    }
}

// Iniciar countdown
const interval = setInterval(updateCountdown, 1000);

// Redirección de emergencia si algo falla
setTimeout(function() {
    window.location.href = '<?php echo BASE_URL; ?>/';
}, 5000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>