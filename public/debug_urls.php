<?php
// Enhanced debug script to check URL configuration and routing
require_once __DIR__ . '/../config/config.php';

echo "=== URL CONFIGURATION DEBUG ===\n";
echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'not set') . "\n";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'not set') . "\n";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'not set') . "\n";
echo "DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'not set') . "\n";
echo "PHP_SELF: " . ($_SERVER['PHP_SELF'] ?? 'not set') . "\n";

echo "\n=== ROUTING SIMULATION ===\n";
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

echo "Original URI: " . $uri . "\n";

// Remove query string
if (($pos = strpos($uri, '?')) !== false) {
    $uri = substr($uri, 0, $pos);
}
echo "After removing query: " . $uri . "\n";

// Remove base path - improved detection
$script_name = $_SERVER['SCRIPT_NAME'];
$base_path = dirname($script_name);
echo "Script name: " . $script_name . "\n";
echo "Base path: " . $base_path . "\n";

// Handle different scenarios
if ($base_path === '/' || $base_path === '\\') {
    $base_path = '';
}

// Remove /public from base path if present
$base_path = str_replace('/public', '', $base_path);
echo "Cleaned base path: " . $base_path . "\n";

if (!empty($base_path) && strpos($uri, $base_path) === 0) {
    $uri = substr($uri, strlen($base_path));
}
echo "After removing base path: " . $uri . "\n";

// Handle /public prefix in URI
if (strpos($uri, '/public') === 0) {
    $uri = substr($uri, 7); // Remove '/public'
}
echo "After removing /public: " . $uri . "\n";

// Ensure URI starts with /
if (empty($uri) || $uri[0] !== '/') {
    $uri = '/' . $uri;
}
echo "After ensuring slash: " . $uri . "\n";

// Remove trailing slash (except for root)
if (strlen($uri) > 1 && substr($uri, -1) === '/') {
    $uri = substr($uri, 0, -1);
}
echo "Final processed URI: " . $uri . "\n";

echo "\n=== CONSTANTS ===\n";
echo "BASE_URL: " . BASE_URL . "\n";
echo "PUBLIC_URL: " . PUBLIC_URL . "\n";

echo "\n=== GENERATED URLS ===\n";
echo "CSS: " . PUBLIC_URL . "/css/style.css\n";
echo "JS: " . PUBLIC_URL . "/js/main.js\n";

echo "\n=== FILE CHECKS ===\n";
$css_path = __DIR__ . '/css/style.css';
$js_path = __DIR__ . '/js/main.js';
echo "CSS file exists: " . (file_exists($css_path) ? 'YES' : 'NO') . " - $css_path\n";
echo "JS file exists: " . (file_exists($js_path) ? 'YES' : 'NO') . " - $js_path\n";

echo "\n=== DIRECTORY INFO ===\n";
echo "__DIR__: " . __DIR__ . "\n";
echo "Current working directory: " . getcwd() . "\n";
?>