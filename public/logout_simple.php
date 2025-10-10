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

// Definir BASE_URL si no existe
if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['REQUEST_URI']);
    $path = rtrim($path, '/');
    define('BASE_URL', $protocol . $host . $path);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión Cerrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .logout-card { box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1); border: none; border-radius: 15px; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeIn 0.8s ease-out; }
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
                    <p class="text-muted mb-4">Tu sesión se ha cerrado correctamente.</p>
                    <div class="d-grid gap-2">
                        <a href="<?php echo BASE_URL; ?>/" class="btn btn-primary">
                            <i class="bi bi-house"></i> Ir al Inicio
                        </a>
                        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline-secondary">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-redirect después de 3 segundos
setTimeout(function() {
    window.location.replace('<?php echo BASE_URL; ?>/');
}, 3000);
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>