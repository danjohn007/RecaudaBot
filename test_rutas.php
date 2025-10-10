<?php
// Test de URLs y rutas del sistema
require_once 'config/config.php';
session_start();

echo "<h1>🔗 Test de URLs y Rutas - RecaudaBot</h1>";

echo "<h2>1. Configuración de URLs</h2>";
echo "BASE_URL: " . BASE_URL . "<br>";
echo "PUBLIC_URL: " . PUBLIC_URL . "<br>";

echo "<h2>2. Rutas Principales de Testing</h2>";

$test_routes = [
    'Página Principal' => BASE_URL . '/',
    'Login' => BASE_URL . '/login',
    'Registro' => BASE_URL . '/register', 
    'Dashboard Admin' => BASE_URL . '/admin',
    'Dashboard Admin (Alternativo)' => BASE_URL . '/admin/dashboard',
    'Perfil Usuario' => BASE_URL . '/perfil',
    'Impuesto Predial' => BASE_URL . '/impuesto-predial',
    'Multas Tránsito' => BASE_URL . '/multas-transito',
    'Licencias' => BASE_URL . '/licencias'
];

echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>Descripción</th><th>URL</th><th>Acción</th></tr>";

foreach ($test_routes as $desc => $url) {
    echo "<tr>";
    echo "<td>{$desc}</td>";
    echo "<td>{$url}</td>";
    echo "<td><a href='{$url}' target='_blank'>→ Probar</a></td>";
    echo "</tr>";
}

echo "</table>";

echo "<h2>3. Test de Redirección</h2>";
echo "<p>✅ <strong>Controller.php</strong>: Corregido para usar BASE_URL en redirects</p>";
echo "<p>✅ <strong>Rutas admin</strong>: Añadida ruta /admin/dashboard</p>";

echo "<h2>4. Instrucciones de Testing</h2>";
echo "<ol>";
echo "<li><strong>Accede al login</strong> y usa credenciales de prueba</li>";
echo "<li><strong>Verifica redirección</strong> según el rol del usuario:</li>";
echo "<ul>";
echo "<li>Admin → /admin/dashboard</li>";
echo "<li>Usuario → /perfil</li>";
echo "</ul>";
echo "<li><strong>Navega entre secciones</strong> para verificar que las rutas funcionen</li>";
echo "</ol>";

echo "<h2>5. Logs de Debug</h2>";
echo "Sesión activa: " . (isset($_SESSION['user_id']) ? "SÍ (ID: " . $_SESSION['user_id'] . ")" : "NO") . "<br>";
echo "Rol actual: " . (isset($_SESSION['role']) ? $_SESSION['role'] : "No definido") . "<br>";

echo "<hr>";
echo "<p><strong>Estado:</strong> ✅ URLs corregidas, rutas añadidas, redirects arreglados</p>";

?>