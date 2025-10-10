<?php
session_start();
require_once __DIR__ . '/../config/config.php';

echo "<!DOCTYPE html><html><head>";
echo "<title>Prueba Rápida de Logout</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css'>";
echo "</head><body class='bg-light'>";

echo "<div class='container mt-5'>";
echo "<div class='row justify-content-center'>";
echo "<div class='col-md-8'>";
echo "<div class='card'>";
echo "<div class='card-body'>";

echo "<h2 class='text-center mb-4'><i class='bi bi-door-open'></i> Prueba Rápida de Logout</h2>";

if (isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-info'>";
    echo "<h4><i class='bi bi-person-check'></i> Estado: Usuario Logueado</h4>";
    echo "<strong>Usuario:</strong> " . htmlspecialchars($_SESSION['username'] ?? 'N/A') . "<br>";
    echo "<strong>Nombre:</strong> " . htmlspecialchars($_SESSION['full_name'] ?? 'N/A') . "<br>";
    echo "<strong>Role:</strong> " . $_SESSION['role'] . "<br>";
    echo "</div>";
    
    echo "<h4>Opciones de Logout:</h4>";
    echo "<div class='row mt-3'>";
    
    echo "<div class='col-md-6 mb-3'>";
    echo "<div class='card border-primary'>";
    echo "<div class='card-body text-center'>";
    echo "<h5 class='card-title text-primary'>Método Nuevo (Recomendado)</h5>";
    echo "<p class='card-text'>Usa el nuevo sistema de logout con vista de confirmación</p>";
    echo "<a href='" . BASE_URL . "/logout' class='btn btn-primary btn-lg w-100'>";
    echo "<i class='bi bi-box-arrow-right'></i> Logout Normal";
    echo "</a>";
    echo "</div></div></div>";
    
    echo "<div class='col-md-6 mb-3'>";
    echo "<div class='card border-warning'>";
    echo "<div class='card-body text-center'>";
    echo "<h5 class='card-title text-warning'>Método Directo</h5>";
    echo "<p class='card-text'>Redirección directa sin vista de confirmación</p>";
    echo "<a href='" . BASE_URL . "/public/logout_direct.php' class='btn btn-warning btn-lg w-100'>";
    echo "<i class='bi bi-gear'></i> Logout Directo";
    echo "</a>";
    echo "</div></div></div>";
    
    echo "</div>";
    
} else {
    echo "<div class='alert alert-success'>";
    echo "<h4><i class='bi bi-check-circle'></i> Estado: No hay sesión activa</h4>";
    echo "<p>El logout funcionó correctamente o no hay usuario logueado.</p>";
    echo "</div>";
    
    echo "<div class='alert alert-info'>";
    echo "<h4><i class='bi bi-info-circle'></i> Verificar redirección:</h4>";
    echo "<p>Si acabas de hacer logout, verifica que llegaste a la página principal con las opciones de registro e inicio de sesión.</p>";
    echo "</div>";
}

echo "<div class='text-center mt-4'>";
echo "<h5>URLs de Navegación:</h5>";
echo "<a href='" . BASE_URL . "' class='btn btn-outline-primary me-2'>";
echo "<i class='bi bi-house'></i> Página Principal";
echo "</a>";
echo "<a href='" . BASE_URL . "/login' class='btn btn-outline-secondary me-2'>";
echo "<i class='bi bi-box-arrow-in-right'></i> Iniciar Sesión";
echo "</a>";
echo "<a href='" . BASE_URL . "/register' class='btn btn-outline-success'>";
echo "<i class='bi bi-person-plus'></i> Registrarse";
echo "</a>";
echo "</div>";

echo "<div class='mt-4 text-center'>";
echo "<small class='text-muted'>";
echo "Página Principal: " . BASE_URL . "<br>";
echo "Timestamp: " . date('Y-m-d H:i:s');
echo "</small>";
echo "</div>";

echo "</div></div></div></div></div>";
echo "</body></html>";
?>