<?php
/**
 * Configuration file for RecaudaBot
 * Auto-detects URL base and database settings
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'recaudab_colon');
define('DB_USER', 'recaudab_colon');
define('DB_PASS', 'Danjohn007!');
define('DB_CHARSET', 'utf8mb4');

// URL Configuration - Auto-detect with fallback
// Configuración automática con respaldo para el hosting
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';

// Auto-detect the correct base path
if (isset($_SERVER['SCRIPT_NAME'])) {
    $script_dir = dirname($_SERVER['SCRIPT_NAME']);
    if (strpos($script_dir, '/public') !== false) {
        // Remove /public from the path to get the base
        $base_path = str_replace('/public', '', $script_dir);
    } else {
        $base_path = $script_dir;
    }
} else {
    // Fallback for hosting environment
    $base_path = '/daniel/recaudabot';
}

// Clean up the path
$base_path = rtrim($base_path, '/');
if (empty($base_path)) {
    $base_path = '';
}

define('BASE_URL', $protocol . $host . $base_path);
define('PUBLIC_URL', BASE_URL . '/public');

// Application Settings
define('APP_NAME', 'RecaudaBot');
define('APP_VERSION', '1.0.0');
define('TIMEZONE', 'America/Mexico_City');

// Session Configuration
define('SESSION_LIFETIME', 7200); // 2 hours
define('SESSION_NAME', 'RECAUDABOT_SESSION');

// Security
define('HASH_ALGO', PASSWORD_BCRYPT);
define('HASH_COST', 12);

// File Upload
define('MAX_FILE_SIZE', 5242880); // 5MB
define('UPLOAD_PATH', __DIR__ . '/../public/uploads/');
define('ALLOWED_EXTENSIONS', ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx']);

// Pagination
define('ITEMS_PER_PAGE', 20);

// Email Configuration
define('SMTP_HOST', 'localhost');
define('SMTP_PORT', 587);
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('FROM_EMAIL', 'noreply@municipio.gob.mx');
define('FROM_NAME', 'RecaudaBot');

// Payment Gateway (Example)
define('PAYMENT_GATEWAY_KEY', 'your_key_here');
define('PAYMENT_GATEWAY_SECRET', 'your_secret_here');

// Timezone
date_default_timezone_set(TIMEZONE);

// Error Reporting (change to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
