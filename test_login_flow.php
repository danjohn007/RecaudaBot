<?php
// Test completo del flujo de login
session_start(); // Iniciar sesión antes de cualquier output
require_once 'config/config.php';
require_once 'config/database.php';

echo "<h1>Test del Flujo de Login - RecaudaBot</h1>";

echo "<h2>1. Configuración de URLs</h2>";
echo "BASE_URL: " . BASE_URL . "<br>";
echo "PUBLIC_URL: " . PUBLIC_URL . "<br>";

echo "<h2>2. Estructura de Rutas</h2>";
echo "URL actual: " . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'CLI Mode') . "<br>";
echo "Script actual: " . $_SERVER['SCRIPT_NAME'] . "<br>";

echo "<h2>3. Links de Prueba</h2>";
echo '<a href="' . PUBLIC_URL . '/login">→ Ir a Login</a><br>';
echo '<a href="' . PUBLIC_URL . '/register">→ Ir a Registro</a><br>';
echo '<a href="' . PUBLIC_URL . '/admin/dashboard">→ Ir a Dashboard Admin</a><br>';

echo "<h2>4. Test de Sesión</h2>";
if (isset($_SESSION['user_id'])) {
    echo "Usuario logueado: ID " . $_SESSION['user_id'] . "<br>";
    echo "Rol: " . (isset($_SESSION['role']) ? $_SESSION['role'] : 'No definido') . "<br>";
    echo '<a href="' . PUBLIC_URL . '/logout">→ Cerrar Sesión</a><br>';
} else {
    echo "No hay sesión activa<br>";
}

echo "<h2>5. Test de Base de Datos</h2>";
try {
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "✓ Conexión a base de datos exitosa<br>";
    
    // Verificar si existe un usuario admin
    $stmt = $pdo->prepare("SELECT id, name, email, role FROM users WHERE role = 'admin' LIMIT 1");
    $stmt->execute();
    $admin = $stmt->fetch();
    
    if ($admin) {
        echo "✓ Usuario admin encontrado: " . $admin['email'] . "<br>";
    } else {
        echo "⚠ No se encontró usuario admin<br>";
    }
    
} catch (Exception $e) {
    echo "✗ Error de base de datos: " . $e->getMessage() . "<br>";
}

echo "<h2>6. Test de Archivos Críticos</h2>";
$critical_files = [
    'app/core/Router.php',
    'app/controllers/AuthController.php',
    'app/views/auth/login.php',
    'app/views/admin/dashboard.php'
];

foreach ($critical_files as $file) {
    if (file_exists($file)) {
        echo "✓ " . $file . "<br>";
    } else {
        echo "✗ " . $file . " (No encontrado)<br>";
    }
}

echo "<h2>7. Instrucciones de Uso</h2>";
echo "<p>Para probar el sistema:</p>";
echo "<ol>";
echo "<li>Accede a: <strong>" . PUBLIC_URL . "</strong></li>";
echo "<li>Ve a Login: <strong>" . PUBLIC_URL . "/login</strong></li>";
echo "<li>Si no tienes usuario admin, ve a Registro primero</li>";
echo "<li>Después del login exitoso, deberías ir automáticamente al dashboard</li>";
echo "</ol>";

?>