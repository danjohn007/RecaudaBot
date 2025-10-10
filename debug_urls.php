<?php
require_once 'config/config.php';

echo "<h2>Debug de URLs del Sistema</h2>";
echo "<style>
    .debug-box { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .success { color: green; }
    .error { color: red; }
    .warning { color: orange; }
</style>";

echo "<div class='debug-box'>";
echo "<h3>Variables del servidor:</h3>";
echo "<p><strong>HTTP_HOST:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'No definido') . "</p>";
echo "<p><strong>SCRIPT_NAME:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'No definido') . "</p>";
echo "<p><strong>REQUEST_URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'No definido') . "</p>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>URLs Configuradas:</h3>";
echo "<p><strong>BASE_URL:</strong> " . BASE_URL . "</p>";
echo "<p><strong>PUBLIC_URL:</strong> " . PUBLIC_URL . "</p>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>URLs que se generan en el HTML:</h3>";
echo "<p><strong>CSS:</strong> " . PUBLIC_URL . "/css/style.css</p>";
echo "<p><strong>JS:</strong> " . PUBLIC_URL . "/js/main.js</p>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Prueba de acceso a archivos:</h3>";

$cssUrl = PUBLIC_URL . "/css/style.css";
$jsUrl = PUBLIC_URL . "/js/main.js";

echo "<p>Probando CSS: <a href='$cssUrl' target='_blank'>$cssUrl</a></p>";
echo "<p>Probando JS: <a href='$jsUrl' target='_blank'>$jsUrl</a></p>";

// Verificar si los archivos existen localmente
$cssPath = __DIR__ . "/public/css/style.css";
$jsPath = __DIR__ . "/public/js/main.js";

echo "<p>Archivo CSS local existe: " . (file_exists($cssPath) ? "<span class='success'>✓ Sí</span>" : "<span class='error'>✗ No</span>") . "</p>";
echo "<p>Archivo JS local existe: " . (file_exists($jsPath) ? "<span class='success'>✓ Sí</span>" : "<span class='error'>✗ No</span>") . "</p>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Solución Manual:</h3>";
echo "<p>Si los archivos no se cargan correctamente, puedes definir las URLs manualmente editando config.php:</p>";
echo "<pre>";
echo "define('BASE_URL', 'https://recaudabot.digital/daniel/1');\n";
echo "define('PUBLIC_URL', 'https://recaudabot.digital/daniel/1/public');";
echo "</pre>";
echo "</div>";

// Verificar el contenido de las rutas que están causando error
echo "<div class='debug-box'>";
echo "<h3>Análisis del problema 'public/public':</h3>";
echo "<p>El error muestra rutas como '/public/public/css/style.css'</p>";
echo "<p>Esto sugiere que hay una doble concatenación de 'public'</p>";
echo "<p>Posibles causas:</p>";
echo "<ul>";
echo "<li>El .htaccess o configuración del servidor está agregando '/public' automáticamente</li>";
echo "<li>Hay algún middleware que modifica las rutas</li>";
echo "<li>La configuración de PUBLIC_URL está siendo modificada en otro lugar</li>";
echo "</ul>";
echo "</div>";

echo "<p><a href='" . BASE_URL . "/admin/dashboard'>Volver al Dashboard</a></p>";
?>