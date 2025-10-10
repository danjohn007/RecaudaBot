<?php
/**
 * Direct logout handler - Solución definitiva para error 403
 * Maneja tanto GET como POST requests
 */
session_start();

// Log the logout attempt
error_log("Logout attempt - Session ID: " . session_id() . " - User: " . ($_SESSION['username'] ?? 'unknown'));

// Clear all session data
$_SESSION = array();

// Destroy session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy session
session_destroy();

// Start new session for flash message
session_start();
$_SESSION['success'] = 'Sesión cerrada correctamente';

// Determine base URL for redirect
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$script_dir = dirname($_SERVER['SCRIPT_NAME']);

// Remove /public from path if present
$base_path = str_replace('/public', '', $script_dir);
if ($base_path === '' || $base_path === '/') {
    $base_path = '';
}

$redirect_url = $protocol . $host . $base_path . '/';

// Add cache prevention headers
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Redirect to home
header('Location: ' . $redirect_url);
exit();
?>