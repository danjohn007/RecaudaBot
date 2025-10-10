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

// URL Configuration - Fixed for hosting environment
// Configuración fija para evitar problemas de detección automática
define('BASE_URL', 'https://recaudabot.digital/daniel/recaudabot');
define('PUBLIC_URL', 'https://recaudabot.digital/daniel/recaudabot/public');

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
