<?php
require_once __DIR__ . '/../config/config.php';

echo "=== DEBUG DE CONFIGURACIÓN ===\n\n";

echo "Variables del servidor:\n";
echo "HTTP_HOST: " . $_SERVER['HTTP_HOST'] . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "\n";

echo "\nConstantes definidas:\n";
echo "BASE_URL: " . BASE_URL . "\n";
echo "PUBLIC_URL: " . PUBLIC_URL . "\n";

echo "\nURLs generadas:\n";
echo "CSS: " . PUBLIC_URL . "/css/style.css\n";
echo "JS: " . PUBLIC_URL . "/js/main.js\n";

echo "\nExistencia de archivos:\n";
$css_file = __DIR__ . '/css/style.css';
$js_file = __DIR__ . '/js/main.js';
echo "CSS existe: " . (file_exists($css_file) ? 'SÍ' : 'NO') . " - $css_file\n";
echo "JS existe: " . (file_exists($js_file) ? 'SÍ' : 'NO') . " - $js_file\n";

echo "\nDirectorio actual: " . __DIR__ . "\n";
echo "Directorio de trabajo: " . getcwd() . "\n";
?>