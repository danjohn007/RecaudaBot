<?php
// Logout extremo - limpieza total y redirección directa
session_start();

// Log
error_log("Logout extremo - " . date('Y-m-d H:i:s'));

// Destruir completamente la sesión
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}
session_destroy();

// Headers extremos
header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
header('Clear-Site-Data: "cache", "cookies", "storage"');

// Load config to get BASE_URL
require_once __DIR__ . '/../config/config.php';

// Redirect to login page
header("Location: " . BASE_URL . "/login");
exit();
?>