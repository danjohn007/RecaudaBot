<?php
// Test de comparación - Login vs Logout
session_start();
require_once __DIR__ . '/../config/config.php';

echo "<!DOCTYPE html><html><head>";
echo "<title>Test Comparativo - Login vs Logout</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css'>";
echo "</head><body class='bg-light'>";

echo "<div class='container mt-4'>";
echo "<h1 class='text-center mb-4'><i class='bi bi-gear'></i> Test Comparativo: Login vs Logout</h1>";

// Estado actual
if (isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-success'>";
    echo "<h4><i class='bi bi-person-check'></i> Usuario Logueado</h4>";
    echo "<strong>Usuario:</strong> " . $_SESSION['username'] . "<br>";
    echo "<strong>ID:</strong> " . $_SESSION['user_id'] . "<br>";
    echo "<strong>Rol:</strong> " . $_SESSION['role'];
    echo "</div>";
} else {
    echo "<div class='alert alert-warning'>";
    echo "<h4><i class='bi bi-person-x'></i> No hay sesión activa</h4>";
    echo "</div>";
}

// Análisis de métodos que funcionan
echo "<div class='card mt-4'>";
echo "<div class='card-body'>";
echo "<h3>📊 Análisis de Métodos que SÍ Funcionan</h3>";

echo "<div class='row'>";
echo "<div class='col-md-6'>";
echo "<h5>✅ Método login() (FUNCIONA):</h5>";
echo "<div class='bg-light p-3 rounded'>";
echo "<code>";
echo "if (\$user) {<br>";
echo "&nbsp;&nbsp;\$_SESSION['user_id'] = \$user['id'];<br>";
echo "&nbsp;&nbsp;// ... más asignaciones ...<br>";
echo "&nbsp;&nbsp;\$this->redirect('/admin'); // ✅ Funciona<br>";
echo "} else {<br>";
echo "&nbsp;&nbsp;\$this->redirect('/login'); // ✅ Funciona<br>";
echo "}";
echo "</code>";
echo "</div>";
echo "</div>";

echo "<div class='col-md-6'>";
echo "<h5>❓ Método logout() (PROBLEMA):</h5>";
echo "<div class='bg-light p-3 rounded'>";
echo "<code>";
echo "// Destruir sesión<br>";
echo "\$_SESSION = array();<br>";
echo "session_destroy();<br>";
echo "<br>";
echo "\$this->redirect('/'); // ❓ No funciona igual";
echo "</code>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "</div></div>";

// Test específico del problema
echo "<div class='card mt-4'>";
echo "<div class='card-body'>";
echo "<h3>🔍 Diagnóstico del Problema</h3>";

echo "<h5>Posibles causas del fallo en logout:</h5>";
echo "<ul>";
echo "<li><strong>Sesión destruida antes de redirect:</strong> El redirect() podría depender de la sesión</li>";
echo "<li><strong>Headers ya enviados:</strong> session_destroy() podría estar enviando headers</li>";
echo "<li><strong>Cookies conflictivas:</strong> setcookie() podría interferir con header('Location:')</li>";
echo "<li><strong>Ruta incorrecta:</strong> '/' podría no estar mapeada correctamente</li>";
echo "</ul>";

echo "<h5>Vamos a probar diferentes enfoques:</h5>";

if (isset($_SESSION['user_id'])) {
    echo "<div class='row mt-3'>";
    
    echo "<div class='col-md-4'>";
    echo "<h6>1. Logout Original (Actual):</h6>";
    echo "<a href='" . BASE_URL . "/logout' class='btn btn-danger w-100'>";
    echo "<i class='bi bi-box-arrow-right'></i> Logout Normal";
    echo "</a>";
    echo "<small class='text-muted'>Usa session_destroy() + redirect('/')</small>";
    echo "</div>";
    
    echo "<div class='col-md-4'>";
    echo "<h6>2. Logout Simple Test:</h6>";
    echo "<a href='test_logout_minimal.php' class='btn btn-warning w-100'>";
    echo "<i class='bi bi-gear'></i> Test Minimal";
    echo "</a>";
    echo "<small class='text-muted'>Solo session_destroy() + redirect</small>";
    echo "</div>";
    
    echo "<div class='col-md-4'>";
    echo "<h6>3. Logout como Login:</h6>";
    echo "<a href='test_logout_like_login.php' class='btn btn-info w-100'>";
    echo "<i class='bi bi-arrow-repeat'></i> Test Like Login";
    echo "</a>";
    echo "<small class='text-muted'>Estructura idéntica al método login</small>";
    echo "</div>";
    
    echo "</div>";
} else {
    echo "<div class='alert alert-info'>";
    echo "<h5>Para hacer las pruebas:</h5>";
    echo "<ol>";
    echo "<li>Primero inicia sesión</li>";
    echo "<li>Luego prueba los diferentes métodos de logout</li>";
    echo "<li>Observa cuál te redirige correctamente</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<a href='" . BASE_URL . "/login' class='btn btn-primary btn-lg'>";
    echo "<i class='bi bi-box-arrow-in-right'></i> Iniciar Sesión para Probar";
    echo "</a>";
}

echo "</div></div>";

// Información técnica
echo "<div class='card mt-4'>";
echo "<div class='card-body'>";
echo "<h3>⚙️ Información Técnica</h3>";

echo "<div class='row'>";
echo "<div class='col-md-6'>";
echo "<h5>Configuración Actual:</h5>";
echo "<ul class='list-unstyled'>";
echo "<li><strong>BASE_URL:</strong> " . BASE_URL . "</li>";
echo "<li><strong>Session ID:</strong> " . session_id() . "</li>";
echo "<li><strong>User Agent:</strong> " . substr($_SERVER['HTTP_USER_AGENT'], 0, 50) . "...</li>";
echo "</ul>";
echo "</div>";

echo "<div class='col-md-6'>";
echo "<h5>Rutas Configuradas:</h5>";
echo "<ul class='list-unstyled'>";
echo "<li>✅ GET /login → AuthController::showLogin</li>";
echo "<li>✅ POST /login → AuthController::login</li>";
echo "<li>❓ GET /logout → AuthController::logout</li>";
echo "<li>✅ GET / → HomeController::index</li>";
echo "</ul>";
echo "</div>";
echo "</div>";

echo "</div></div>";

echo "<div class='text-center mt-4'>";
echo "<a href='" . BASE_URL . "' class='btn btn-outline-primary me-2'>";
echo "<i class='bi bi-house'></i> Página Principal";
echo "</a>";
echo "<a href='analisis_completo.php' class='btn btn-outline-info'>";
echo "<i class='bi bi-search'></i> Análisis Completo";
echo "</a>";
echo "</div>";

echo "</div></body></html>";
?>