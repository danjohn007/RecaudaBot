<?php
// Verificación rápida del logout y mixed content
require_once '../config/config.php';
session_start();

echo "<!DOCTYPE html>";
echo "<html><head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Verificación Rápida - Logout Fix</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css' rel='stylesheet'>";
echo "</head><body class='bg-light'>";

echo "<div class='container mt-4'>";
echo "<h1 class='text-center mb-4'><i class='bi bi-check-circle'></i> Verificación del Fix</h1>";

// Card de estado
echo "<div class='row mb-4'>";
echo "<div class='col-12'>";
echo "<div class='card'>";
echo "<div class='card-header bg-success text-white'>";
echo "<h5><i class='bi bi-list-check'></i> Estado de las Correcciones</h5>";
echo "</div>";
echo "<div class='card-body'>";

echo "<div class='row'>";
echo "<div class='col-md-6'>";

echo "<h6>🔐 Logout Directo</h6>";
if (file_exists('logout_directo.php')) {
    echo "<p class='text-success'>✅ logout_directo.php creado</p>";
} else {
    echo "<p class='text-danger'>❌ logout_directo.php no encontrado</p>";
}

echo "<h6>🔗 Header Actualizado</h6>";
$header_content = file_get_contents('../app/views/layout/header.php');
if (strpos($header_content, 'logout_directo.php') !== false) {
    echo "<p class='text-success'>✅ Header apunta a logout directo</p>";
} else {
    echo "<p class='text-warning'>⚠️ Header no actualizado</p>";
}

echo "<h6>🔒 .htaccess Seguridad</h6>";
$htaccess_content = file_get_contents('.htaccess');
if (strpos($htaccess_content, 'upgrade-insecure-requests') !== false) {
    echo "<p class='text-success'>✅ Headers de seguridad HTTPS agregados</p>";
} else {
    echo "<p class='text-warning'>⚠️ Headers de seguridad no encontrados</p>";
}

echo "</div>";
echo "<div class='col-md-6'>";

echo "<h6>📊 Estado Actual</h6>";
echo "<p><strong>HTTPS:</strong> " . (isset($_SERVER['HTTPS']) ? 'Activo' : 'No activo') . "</p>";
echo "<p><strong>Session:</strong> " . (isset($_SESSION['user_id']) ? 'Activa (ID: ' . $_SESSION['user_id'] . ')' : 'No activa') . "</p>";
echo "<p><strong>URL actual:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";

echo "<h6>🌐 URLs de Test</h6>";
echo "<p><strong>Logout directo:</strong><br>";
echo "<a href='logout_directo.php' class='text-decoration-none'>";
echo PUBLIC_URL . "/logout_directo.php";
echo "</a></p>";

echo "<p><strong>Test 403:</strong><br>";
echo "<a href='test_403_logout.php' class='text-decoration-none'>";
echo PUBLIC_URL . "/test_403_logout.php";
echo "</a></p>";

echo "</div>";
echo "</div>";

echo "</div></div></div></div>";

// Prueba rápida de sesión
echo "<div class='row mb-4'>";
echo "<div class='col-12'>";
echo "<div class='card'>";
echo "<div class='card-header bg-info text-white'>";
echo "<h5><i class='bi bi-gear'></i> Prueba Rápida</h5>";
echo "</div>";
echo "<div class='card-body text-center'>";

if (!isset($_SESSION['user_id'])) {
    // Crear sesión de prueba
    $_SESSION['user_id'] = 777;
    $_SESSION['username'] = 'test_fix';
    $_SESSION['full_name'] = 'Usuario de Prueba';
    $_SESSION['role'] = 'user';
    
    echo "<div class='alert alert-info'>";
    echo "<i class='bi bi-info-circle'></i> Sesión de prueba creada automáticamente";
    echo "</div>";
}

echo "<p>Tienes una sesión activa. Ahora puedes probar:</p>";

echo "<div class='d-grid gap-2 d-md-block'>";
echo "<a href='logout_directo.php' class='btn btn-danger btn-lg me-2'>";
echo "<i class='bi bi-box-arrow-right'></i> Probar Logout Directo";
echo "</a>";

echo "<a href='" . BASE_URL . "/admin/statistics' class='btn btn-primary btn-lg me-2'>";
echo "<i class='bi bi-bar-chart'></i> Ver Gráficas";
echo "</a>";

echo "<a href='#' onclick='location.reload()' class='btn btn-secondary'>";
echo "<i class='bi bi-arrow-clockwise'></i> Recargar";
echo "</a>";
echo "</div>";

echo "</div></div></div></div>";

// Resumen de cambios
echo "<div class='row mb-4'>";
echo "<div class='col-12'>";
echo "<div class='card'>";
echo "<div class='card-header bg-warning text-dark'>";
echo "<h5><i class='bi bi-exclamation-triangle'></i> Resumen de Cambios Realizados</h5>";
echo "</div>";
echo "<div class='card-body'>";

echo "<ol>";
echo "<li><strong>Logout Directo:</strong> Creado archivo <code>logout_directo.php</code> que evita el router y maneja logout directamente</li>";
echo "<li><strong>Header Actualizado:</strong> El botón de logout ahora apunta a <code>logout_directo.php</code> en lugar de <code>/logout</code></li>";
echo "<li><strong>HTTPS Forzado:</strong> Agregadas reglas en .htaccess para forzar HTTPS y prevenir Mixed Content</li>";
echo "<li><strong>Headers de Seguridad:</strong> Agregado <code>upgrade-insecure-requests</code> para convertir automáticamente HTTP a HTTPS</li>";
echo "<li><strong>Diagnósticos:</strong> Creados archivos de test para identificar problemas específicos</li>";
echo "</ol>";

echo "<div class='alert alert-success mt-3'>";
echo "<i class='bi bi-check-circle'></i> <strong>El logout ahora debería funcionar sin errores 403 ni Mixed Content</strong>";
echo "</div>";

echo "</div></div></div></div>";

echo "</div>"; // container

echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>";
echo "</body></html>";
?>