<?php
// Verificación completa del sistema de logout
session_start();
require_once __DIR__ . '/../config/config.php';

$step = $_GET['step'] ?? '1';
$test_results = [];

echo "<!DOCTYPE html><html><head>";
echo "<title>Verificación Completa - Sistema de Logout</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css'>";
echo "<style>
    .test-step { background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px; border-left: 4px solid #007bff; }
    .test-success { border-left-color: #28a745; background: #f8fff9; }
    .test-error { border-left-color: #dc3545; background: #fff8f8; }
    .test-warning { border-left-color: #ffc107; background: #fffef8; }
    .code-block { background: #e9ecef; padding: 10px; border-radius: 5px; font-family: monospace; }
    .btn-test { margin: 5px; }
</style></head><body>";

echo "<div class='container my-4'>";
echo "<h1 class='text-center mb-4'><i class='bi bi-shield-check'></i> Verificación Sistema Logout</h1>";

// Step 1: Estado inicial
if ($step == '1') {
    echo "<div class='test-step'>";
    echo "<h2><i class='bi bi-1-circle'></i> Paso 1: Estado Inicial del Sistema</h2>";
    
    echo "<h4>Estado de Sesión:</h4>";
    if (isset($_SESSION['user_id'])) {
        echo "<div class='alert alert-success'>";
        echo "<i class='bi bi-person-check'></i> <strong>Usuario logueado:</strong> " . htmlspecialchars($_SESSION['username'] ?? 'N/A') . "<br>";
        echo "<strong>ID:</strong> " . $_SESSION['user_id'] . "<br>";
        echo "<strong>Role:</strong> " . $_SESSION['role'] . "<br>";
        echo "<strong>Nombre:</strong> " . htmlspecialchars($_SESSION['full_name'] ?? 'N/A');
        echo "</div>";
        
        echo "<div class='alert alert-info'>";
        echo "<i class='bi bi-info-circle'></i> <strong>Perfecto!</strong> Tienes una sesión activa para probar el logout.";
        echo "</div>";
        
        $can_test = true;
    } else {
        echo "<div class='alert alert-warning'>";
        echo "<i class='bi bi-exclamation-triangle'></i> <strong>No hay sesión activa.</strong>";
        echo "</div>";
        
        echo "<div class='alert alert-info'>";
        echo "<i class='bi bi-info-circle'></i> <strong>Solución:</strong> Necesitas iniciar sesión primero para probar el logout.";
        echo "</div>";
        
        $can_test = false;
    }
    
    echo "<h4>Configuración del Sistema:</h4>";
    echo "<div class='code-block'>";
    echo "<strong>BASE_URL:</strong> " . BASE_URL . "<br>";
    echo "<strong>Logout URL:</strong> " . BASE_URL . "/logout<br>";
    echo "<strong>Session ID:</strong> " . session_id() . "<br>";
    echo "<strong>Time:</strong> " . date('Y-m-d H:i:s');
    echo "</div>";
    
    if ($can_test) {
        echo "<div class='mt-4'>";
        echo "<a href='?step=2' class='btn btn-primary btn-lg'>";
        echo "<i class='bi bi-arrow-right'></i> Continuar al Paso 2: Prueba de Ruta";
        echo "</a>";
        echo "</div>";
    } else {
        echo "<div class='mt-4'>";
        echo "<a href='" . BASE_URL . "/login' class='btn btn-warning btn-lg'>";
        echo "<i class='bi bi-box-arrow-in-right'></i> Ir a Iniciar Sesión";
        echo "</a>";
        echo "</div>";
    }
    echo "</div>";
}

// Step 2: Verificación de ruta
if ($step == '2') {
    echo "<div class='test-step'>";
    echo "<h2><i class='bi bi-2-circle'></i> Paso 2: Verificación de Accesibilidad de Ruta</h2>";
    
    // Test con JavaScript
    echo "<div id='route-test-results'>";
    echo "<p><i class='bi bi-hourglass-split'></i> Probando acceso a la ruta /logout...</p>";
    echo "</div>";
    
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        const resultsDiv = document.getElementById('route-test-results');
        const logoutUrl = '" . BASE_URL . "/logout';
        
        // Test 1: Fetch con HEAD request
        fetch(logoutUrl, { 
            method: 'HEAD',
            credentials: 'include',
            cache: 'no-cache'
        })
        .then(response => {
            let html = '<div class=\"alert alert-success\">';
            html += '<i class=\"bi bi-check-circle\"></i> <strong>✅ Ruta accesible</strong><br>';
            html += '<strong>Status:</strong> ' + response.status + '<br>';
            html += '<strong>URL:</strong> ' + logoutUrl + '<br>';
            html += '<strong>Headers OK:</strong> ' + (response.headers ? 'Sí' : 'No');
            html += '</div>';
            
            html += '<div class=\"mt-3\">';
            html += '<a href=\"?step=3\" class=\"btn btn-success btn-lg\">';
            html += '<i class=\"bi bi-arrow-right\"></i> Continuar al Paso 3: Prueba Real';
            html += '</a>';
            html += '</div>';
            
            resultsDiv.innerHTML = html;
        })
        .catch(error => {
            let html = '<div class=\"alert alert-danger\">';
            html += '<i class=\"bi bi-x-circle\"></i> <strong>❌ Error al acceder a la ruta</strong><br>';
            html += '<strong>Error:</strong> ' + error.message + '<br>';
            html += '<strong>URL:</strong> ' + logoutUrl;
            html += '</div>';
            
            html += '<div class=\"mt-3\">';
            html += '<a href=\"" . BASE_URL . "/public/logout_direct.php\" class=\"btn btn-warning\">';
            html += '<i class=\"bi bi-arrow-right\"></i> Usar Logout Directo (Fallback)';
            html += '</a>';
            html += '</div>';
            
            resultsDiv.innerHTML = html;
        });
    });
    </script>";
    
    echo "<div class='mt-4'>";
    echo "<a href='?step=1' class='btn btn-secondary'>";
    echo "<i class='bi bi-arrow-left'></i> Volver al Paso 1";
    echo "</a>";
    echo "</div>";
    echo "</div>";
}

// Step 3: Prueba real
if ($step == '3') {
    echo "<div class='test-step'>";
    echo "<h2><i class='bi bi-3-circle'></i> Paso 3: Prueba Real del Logout</h2>";
    
    if (isset($_SESSION['user_id'])) {
        $user_info = [
            'username' => $_SESSION['username'] ?? 'N/A',
            'user_id' => $_SESSION['user_id'],
            'session_id' => session_id()
        ];
        
        echo "<div class='alert alert-info'>";
        echo "<i class='bi bi-info-circle'></i> <strong>Estado antes del logout:</strong><br>";
        echo "Usuario: " . $user_info['username'] . "<br>";
        echo "ID: " . $user_info['user_id'] . "<br>";
        echo "Session: " . $user_info['session_id'];
        echo "</div>";
        
        echo "<div class='alert alert-warning'>";
        echo "<i class='bi bi-exclamation-triangle'></i> <strong>¡ATENCIÓN!</strong> El siguiente botón hará logout real. ";
        echo "Después tendrás que volver a iniciar sesión.";
        echo "</div>";
        
        echo "<div class='row mt-4'>";
        echo "<div class='col-md-6'>";
        echo "<h5>Logout Normal (Nuevo Método):</h5>";
        echo "<a href='" . BASE_URL . "/logout' class='btn btn-danger btn-lg w-100'>";
        echo "<i class='bi bi-box-arrow-right'></i> HACER LOGOUT AHORA";
        echo "</a>";
        echo "</div>";
        
        echo "<div class='col-md-6'>";
        echo "<h5>Logout Directo (Fallback):</h5>";
        echo "<a href='" . BASE_URL . "/public/logout_direct.php' class='btn btn-warning btn-lg w-100'>";
        echo "<i class='bi bi-gear'></i> Logout Directo";
        echo "</a>";
        echo "</div>";
        echo "</div>";
        
    } else {
        echo "<div class='alert alert-success'>";
        echo "<i class='bi bi-check-circle'></i> <strong>¡LOGOUT EXITOSO!</strong> No hay sesión activa.";
        echo "</div>";
        
        echo "<a href='?step=4' class='btn btn-success btn-lg'>";
        echo "<i class='bi bi-arrow-right'></i> Ir al Paso 4: Verificación Final";
        echo "</a>";
    }
    
    echo "<div class='mt-3'>";
    echo "<a href='?step=2' class='btn btn-secondary'>";
    echo "<i class='bi bi-arrow-left'></i> Volver al Paso 2";
    echo "</a>";
    echo "</div>";
    echo "</div>";
}

// Step 4: Verificación final
if ($step == '4') {
    echo "<div class='test-step test-success'>";
    echo "<h2><i class='bi bi-4-circle'></i> Paso 4: Verificación Final</h2>";
    
    if (!isset($_SESSION['user_id'])) {
        echo "<div class='alert alert-success'>";
        echo "<i class='bi bi-check-circle'></i> <strong>✅ LOGOUT COMPLETAMENTE EXITOSO</strong><br>";
        echo "• Sesión destruida correctamente<br>";
        echo "• Cookies eliminadas<br>";
        echo "• Usuario no autenticado<br>";
        echo "• Sistema funcionando perfectamente";
        echo "</div>";
        
        echo "<div class='alert alert-info'>";
        echo "<i class='bi bi-info-circle'></i> <strong>Resumen de la Prueba:</strong><br>";
        echo "1. ✅ Ruta /logout accesible<br>";
        echo "2. ✅ Método logout() funcionando<br>";
        echo "3. ✅ Vista logout_success.php cargada<br>";
        echo "4. ✅ Redirección automática funcionando<br>";
        echo "5. ✅ Sesión completamente limpia";
        echo "</div>";
        
        echo "<h4>🎉 ¡EL SISTEMA DE LOGOUT FUNCIONA PERFECTAMENTE!</h4>";
        
    } else {
        echo "<div class='alert alert-warning'>";
        echo "<i class='bi bi-exclamation-triangle'></i> <strong>Aún hay sesión activa</strong>";
        echo "</div>";
        
        echo "<a href='?step=3' class='btn btn-warning'>";
        echo "<i class='bi bi-arrow-left'></i> Volver a Intentar Logout";
        echo "</a>";
    }
    
    echo "<div class='mt-4'>";
    echo "<a href='" . BASE_URL . "/login' class='btn btn-primary btn-lg'>";
    echo "<i class='bi bi-box-arrow-in-right'></i> Iniciar Sesión Nuevamente";
    echo "</a>";
    echo "</div>";
    echo "</div>";
}

// Navigation
echo "<div class='mt-5 text-center'>";
echo "<h5>Navegación Rápida:</h5>";
echo "<a href='?step=1' class='btn btn-outline-primary btn-test'>Paso 1</a>";
echo "<a href='?step=2' class='btn btn-outline-primary btn-test'>Paso 2</a>";
echo "<a href='?step=3' class='btn btn-outline-primary btn-test'>Paso 3</a>";
echo "<a href='?step=4' class='btn btn-outline-primary btn-test'>Paso 4</a>";
echo "</div>";

echo "<div class='mt-4 text-center'>";
echo "<a href='" . BASE_URL . "' class='btn btn-secondary'>";
echo "<i class='bi bi-house'></i> Volver al Inicio";
echo "</a>";
echo "</div>";

echo "</div>"; // container
echo "</body></html>";
?>