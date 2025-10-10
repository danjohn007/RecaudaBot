<?php
session_start();
require_once '../config/config.php';

echo "<h2>Debug de Autenticación</h2>";
echo "<style>
    .debug-box { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border: 1px solid #dee2e6; }
    .success { color: green; }
    .error { color: red; }
    .warning { color: orange; }
    pre { background: #e9ecef; padding: 10px; border-radius: 5px; overflow-x: auto; }
</style>";

echo "<div class='debug-box'>";
echo "<h3>Variables de Sesión</h3>";
echo "<pre>";
if (isset($_SESSION['user_id'])) {
    foreach ($_SESSION as $key => $value) {
        echo "$key: " . htmlspecialchars($value) . "\n";
    }
} else {
    echo "No hay sesión activa\n";
}
echo "</pre>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>URLs de Redirección</h3>";
echo "<pre>";
echo "BASE_URL: " . BASE_URL . "\n";
echo "PUBLIC_URL: " . PUBLIC_URL . "\n";
echo "Login URL: " . BASE_URL . "/login\n";
echo "Logout URL: " . BASE_URL . "/logout\n";
echo "Register URL: " . BASE_URL . "/register\n";
echo "</pre>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Test de Rutas de Logout</h3>";
echo "<p><a href='" . BASE_URL . "/logout' target='_blank'>Probar Logout (BASE_URL)</a></p>";
echo "<p><a href='" . BASE_URL . "/public/logout' target='_blank'>Probar Logout (PUBLIC)</a></p>";
echo "</div>";
echo "PUBLIC_URL: " . PUBLIC_URL . "\n";
echo "\nURLs después del login:\n";
echo "Admin: " . PUBLIC_URL . "/admin\n";
echo "Perfil: " . PUBLIC_URL . "/perfil\n";
echo "</pre>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Test de Formulario de Login</h3>";
echo "<form action='" . PUBLIC_URL . "/login' method='POST'>";
echo "<input type='text' name='username' placeholder='Usuario' value='admin' style='margin: 5px; padding: 5px;'><br>";
echo "<input type='password' name='password' placeholder='Contraseña' value='admin123' style='margin: 5px; padding: 5px;'><br>";
echo "<input type='submit' value='Probar Login' style='margin: 5px; padding: 5px;'>";
echo "</form>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Enlaces de Navegación</h3>";
echo "<ul>";
echo "<li><a href='" . PUBLIC_URL . "/'>Inicio</a></li>";
echo "<li><a href='" . PUBLIC_URL . "/login'>Login</a></li>";
echo "<li><a href='" . PUBLIC_URL . "/admin'>Admin</a></li>";
echo "<li><a href='" . PUBLIC_URL . "/logout'>Logout</a></li>";
echo "</ul>";
echo "</div>";

if (isset($_SESSION['user_id'])) {
    echo "<div class='debug-box'>";
    echo "<h3>Estado Actual</h3>";
    echo "<p class='success'>✓ Usuario autenticado como: " . ($_SESSION['full_name'] ?? 'Sin nombre') . "</p>";
    echo "<p>Rol: " . ($_SESSION['role'] ?? 'Sin rol') . "</p>";
    echo "</div>";
}
?>