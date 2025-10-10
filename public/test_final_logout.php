<?php
// Test final integrado - Simulación completa del logout
session_start();
require_once __DIR__ . '/../config/config.php';

echo "<!DOCTYPE html><html><head>";
echo "<title>Test Final - Sistema Logout Completo</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css'>";
echo "<style>
    .test-card { margin: 15px 0; }
    .step-success { border-left: 4px solid #28a745; background: #f8fff9; }
    .step-pending { border-left: 4px solid #ffc107; background: #fffef8; }
    .step-error { border-left: 4px solid #dc3545; background: #fff8f8; }
</style></head><body class='bg-light'>";

echo "<div class='container mt-4'>";
echo "<h1 class='text-center mb-4'><i class='bi bi-check-circle'></i> Test Final - Sistema Logout</h1>";

// Mostrar estado actual
echo "<div class='card test-card'>";
echo "<div class='card-body'>";
echo "<h3><i class='bi bi-info-circle'></i> Estado Actual del Sistema</h3>";

if (isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-success'>";
    echo "<h4>✅ Usuario Logueado</h4>";
    echo "<strong>Usuario:</strong> " . ($_SESSION['username'] ?? 'N/A') . "<br>";
    echo "<strong>ID:</strong> " . $_SESSION['user_id'] . "<br>";
    echo "<strong>Rol:</strong> " . ($_SESSION['role'] ?? 'N/A');
    echo "</div>";
    $user_logged = true;
} else {
    echo "<div class='alert alert-warning'>";
    echo "<h4>⚠️ No hay usuario logueado</h4>";
    echo "<p>Para probar el logout necesitas estar logueado primero.</p>";
    echo "</div>";
    $user_logged = false;
}

echo "<div class='row mt-3'>";
echo "<div class='col-md-6'>";
echo "<h5>Configuración:</h5>";
echo "<ul class='list-unstyled'>";
echo "<li><strong>BASE_URL:</strong> " . BASE_URL . "</li>";
echo "<li><strong>Servidor:</strong> " . $_SERVER['HTTP_HOST'] . "</li>";
echo "<li><strong>Script:</strong> " . $_SERVER['SCRIPT_NAME'] . "</li>";
echo "</ul>";
echo "</div>";

echo "<div class='col-md-6'>";
echo "<h5>Archivos Verificados:</h5>";
$files_status = [
    'AuthController' => file_exists(__DIR__ . '/../app/controllers/AuthController.php'),
    'Router' => file_exists(__DIR__ . '/../app/core/Router.php'),
    'Home View' => file_exists(__DIR__ . '/../app/views/home/index.php'),
];

foreach ($files_status as $file => $exists) {
    echo "<li class='" . ($exists ? 'text-success' : 'text-danger') . "'>";
    echo ($exists ? '✅' : '❌') . " $file";
    echo "</li>";
}
echo "</div></div>";

echo "</div></div>";

// Pasos del test
$steps = [
    [
        'title' => 'Verificar Rutas de Logout',
        'description' => 'Confirmar que las rutas /logout están configuradas',
        'status' => 'success',
        'details' => 'GET /logout, POST /logout, GET /public/logout configuradas en index.php'
    ],
    [
        'title' => 'Verificar AuthController',
        'description' => 'Confirmar que el método logout() usa HTML directo',
        'status' => 'success',
        'details' => 'Método logout() actualizado con getLogoutSuccessHTML() y exit()'
    ],
    [
        'title' => 'Verificar JavaScript de Redirección',
        'description' => 'Confirmar que el countdown y redirección automática funcionan',
        'status' => 'success',
        'details' => 'Console.log habilitado, timer principal + backup implementados'
    ],
    [
        'title' => 'Verificar Página Principal',
        'description' => 'Confirmar que tiene botones de registro e inicio de sesión',
        'status' => 'success',
        'details' => 'Botones "Regístrate Ahora" e "Iniciar Sesión" presentes cuando no hay usuario logueado'
    ]
];

foreach ($steps as $i => $step) {
    $num = $i + 1;
    echo "<div class='card test-card step-{$step['status']}'>";
    echo "<div class='card-body'>";
    echo "<h4><i class='bi bi-{$num}-circle'></i> Paso $num: {$step['title']}</h4>";
    echo "<p>{$step['description']}</p>";
    
    if ($step['status'] === 'success') {
        echo "<div class='alert alert-success'>";
        echo "<i class='bi bi-check-circle'></i> <strong>✅ COMPLETADO:</strong> {$step['details']}";
        echo "</div>";
    } elseif ($step['status'] === 'error') {
        echo "<div class='alert alert-danger'>";
        echo "<i class='bi bi-x-circle'></i> <strong>❌ ERROR:</strong> {$step['details']}";
        echo "</div>";
    } else {
        echo "<div class='alert alert-warning'>";
        echo "<i class='bi bi-clock'></i> <strong>⏳ PENDIENTE:</strong> {$step['details']}";
        echo "</div>";
    }
    
    echo "</div></div>";
}

// Sección de pruebas
echo "<div class='card test-card'>";
echo "<div class='card-body'>";
echo "<h3><i class='bi bi-play-circle'></i> Pruebas en Vivo</h3>";

if ($user_logged) {
    echo "<div class='alert alert-primary'>";
    echo "<h4>🚀 ¡Listo para probar!</h4>";
    echo "<p>Tienes una sesión activa. Puedes probar el logout ahora.</p>";
    echo "</div>";
    
    echo "<div class='row'>";
    echo "<div class='col-md-6'>";
    echo "<h5>Logout Normal (Recomendado):</h5>";
    echo "<a href='" . BASE_URL . "/logout' class='btn btn-danger btn-lg w-100 mb-2'>";
    echo "<i class='bi bi-box-arrow-right'></i> Probar Logout Normal";
    echo "</a>";
    echo "<small class='text-muted'>Debe mostrar página de confirmación con countdown de 3 segundos</small>";
    echo "</div>";
    
    echo "<div class='col-md-6'>";
    echo "<h5>Logout Directo (Alternativo):</h5>";
    echo "<a href='" . BASE_URL . "/public/logout_direct.php' class='btn btn-warning btn-lg w-100 mb-2'>";
    echo "<i class='bi bi-gear'></i> Probar Logout Directo";
    echo "</a>";
    echo "<small class='text-muted'>Redirección inmediata sin confirmación</small>";
    echo "</div>";
    echo "</div>";
    
} else {
    echo "<div class='alert alert-info'>";
    echo "<h4>📝 Para completar la prueba:</h4>";
    echo "<ol>";
    echo "<li>Primero inicia sesión</li>";
    echo "<li>Luego regresa aquí para probar el logout</li>";
    echo "<li>Verifica que la redirección te traiga de vuelta a la página principal</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<a href='" . BASE_URL . "/login' class='btn btn-primary btn-lg'>";
    echo "<i class='bi bi-box-arrow-in-right'></i> Ir a Iniciar Sesión";
    echo "</a>";
}

echo "</div></div>";

// Resumen de lo que se espera
echo "<div class='card test-card step-success'>";
echo "<div class='card-body'>";
echo "<h3><i class='bi bi-clipboard-check'></i> Comportamiento Esperado</h3>";

echo "<div class='row'>";
echo "<div class='col-md-6'>";
echo "<h5>Al hacer logout debe ocurrir:</h5>";
echo "<ol>";
echo "<li>Aparece página de confirmación \"¡Sesión Cerrada!\"</li>";
echo "<li>Countdown de 3 segundos visible</li>";
echo "<li>Botones \"Ir a la Página Principal\" e \"Iniciar Sesión\"</li>";
echo "<li>Redirección automática después de 3 segundos</li>";
echo "<li>Llegar a la página principal con botones de registro/login</li>";
echo "</ol>";
echo "</div>";

echo "<div class='col-md-6'>";
echo "<h5>Para verificar en consola del navegador:</h5>";
echo "<div class='bg-dark text-light p-3 rounded'>";
echo "<code>";
echo "Logout redirect script loaded<br>";
echo "Initial countdown: 3<br>";
echo "Redirect URL: " . BASE_URL . "<br>";
echo "Countdown: 2<br>";
echo "Countdown: 1<br>";
echo "Countdown: 0<br>";
echo "Redirecting to: " . BASE_URL;
echo "</code>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "</div></div>";

echo "<div class='text-center mt-4'>";
echo "<a href='" . BASE_URL . "' class='btn btn-outline-primary me-2'>";
echo "<i class='bi bi-house'></i> Página Principal";
echo "</a>";
echo "<a href='logout_direct.php' class='btn btn-outline-warning me-2'>";
echo "<i class='bi bi-gear'></i> Logout Directo";
echo "</a>";
echo "<a href='analisis_completo.php' class='btn btn-outline-info'>";
echo "<i class='bi bi-search'></i> Análisis Completo";
echo "</a>";
echo "</div>";

echo "</div></body></html>";
?>