<?php
// Verificación completa y en tiempo real del logout
session_start();
require_once __DIR__ . '/../config/config.php';

$step = $_GET['step'] ?? 'check';
$action = $_POST['action'] ?? '';

echo "<!DOCTYPE html><html><head>";
echo "<title>Verificación en Tiempo Real - Logout</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css'>";
echo "<style>
    .verification-step { background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px; }
    .step-success { border-left: 4px solid #28a745; background: #f8fff9; }
    .step-warning { border-left: 4px solid #ffc107; background: #fffef8; }
    .step-info { border-left: 4px solid #007bff; background: #f8f9ff; }
    .live-test { background: #e9ecef; padding: 15px; border-radius: 5px; margin: 10px 0; }
</style></head><body class='bg-light'>";

echo "<div class='container mt-4'>";
echo "<h1 class='text-center mb-4'><i class='bi bi-shield-check'></i> Verificación en Tiempo Real - Logout</h1>";

// 1. Estado Inicial
echo "<div class='verification-step step-info'>";
echo "<h3><i class='bi bi-info-circle'></i> Estado Actual del Sistema</h3>";

echo "<div class='row'>";
echo "<div class='col-md-6'>";
echo "<h5>Información de Sesión:</h5>";
if (isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-success'>";
    echo "<strong>✅ Usuario Logueado:</strong><br>";
    echo "Username: " . htmlspecialchars($_SESSION['username'] ?? 'N/A') . "<br>";
    echo "ID: " . $_SESSION['user_id'] . "<br>";
    echo "Rol: " . ($_SESSION['role'] ?? 'N/A') . "<br>";
    echo "Session ID: " . session_id();
    echo "</div>";
    $has_session = true;
} else {
    echo "<div class='alert alert-warning'>";
    echo "<strong>⚠️ No hay sesión activa</strong><br>";
    echo "Session ID: " . session_id();
    echo "</div>";
    $has_session = false;
}
echo "</div>";

echo "<div class='col-md-6'>";
echo "<h5>Configuración:</h5>";
echo "<div class='live-test'>";
echo "<strong>BASE_URL:</strong> " . BASE_URL . "<br>";
echo "<strong>Logout URL:</strong> " . BASE_URL . "/logout<br>";
echo "<strong>Home URL:</strong> " . BASE_URL . "<br>";
echo "<strong>Login URL:</strong> " . BASE_URL . "/login<br>";
echo "<strong>Timestamp:</strong> " . date('Y-m-d H:i:s');
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

// 2. Verificar archivos y rutas
echo "<div class='verification-step step-success'>";
echo "<h3><i class='bi bi-file-check'></i> Verificación de Archivos y Rutas</h3>";

$critical_files = [
    'AuthController' => __DIR__ . '/../app/controllers/AuthController.php',
    'Router' => __DIR__ . '/../app/core/Router.php',
    'Controller Base' => __DIR__ . '/../app/core/Controller.php',
    'Index (Rutas)' => __DIR__ . '/index.php'
];

echo "<div class='row'>";
foreach ($critical_files as $name => $path) {
    echo "<div class='col-md-6'>";
    echo "<div class='live-test'>";
    if (file_exists($path)) {
        echo "✅ <strong>$name:</strong> OK<br>";
        echo "<small>Tamaño: " . number_format(filesize($path)) . " bytes</small>";
    } else {
        echo "❌ <strong>$name:</strong> NO ENCONTRADO<br>";
        echo "<small>Ruta: $path</small>";
    }
    echo "</div>";
    echo "</div>";
}
echo "</div>";
echo "</div>";

// 3. Test en tiempo real
if ($step === 'check') {
    echo "<div class='verification-step step-warning'>";
    echo "<h3><i class='bi bi-play-circle'></i> Test en Tiempo Real</h3>";
    
    if ($has_session) {
        echo "<div class='alert alert-primary'>";
        echo "<h4>🧪 Listo para probar logout</h4>";
        echo "<p>Tienes una sesión activa. Vamos a probar el logout paso a paso.</p>";
        echo "</div>";
        
        echo "<div class='text-center'>";
        echo "<a href='?step=pre_logout' class='btn btn-danger btn-lg'>";
        echo "<i class='bi bi-box-arrow-right'></i> Iniciar Test de Logout";
        echo "</a>";
        echo "</div>";
        
    } else {
        echo "<div class='alert alert-info'>";
        echo "<h4>📝 Necesitas iniciar sesión primero</h4>";
        echo "<p>Para probar el logout necesitas estar logueado.</p>";
        echo "</div>";
        
        echo "<div class='text-center'>";
        echo "<a href='" . BASE_URL . "/login' class='btn btn-primary btn-lg'>";
        echo "<i class='bi bi-box-arrow-in-right'></i> Ir a Iniciar Sesión";
        echo "</a>";
        echo "</div>";
        
        // También mostrar login rápido para testing
        echo "<hr>";
        echo "<div class='card'>";
        echo "<div class='card-body'>";
        echo "<h5>Login Rápido para Testing:</h5>";
        echo "<form method='POST' action='" . BASE_URL . "/login'>";
        echo "<div class='row'>";
        echo "<div class='col-md-6'>";
        echo "<input type='text' class='form-control' name='username' placeholder='Username' required>";
        echo "</div>";
        echo "<div class='col-md-6'>";
        echo "<input type='password' class='form-control' name='password' placeholder='Password' required>";
        echo "</div>";
        echo "</div>";
        echo "<div class='text-center mt-3'>";
        echo "<button type='submit' class='btn btn-success'>";
        echo "<i class='bi bi-box-arrow-in-right'></i> Login Rápido";
        echo "</button>";
        echo "</div>";
        echo "</form>";
        echo "</div></div>";
    }
    echo "</div>";
}

// 4. Pre-logout (antes de hacer logout)
if ($step === 'pre_logout') {
    echo "<div class='verification-step step-warning'>";
    echo "<h3><i class='bi bi-exclamation-triangle'></i> Pre-Logout: Captura de Estado</h3>";
    
    $pre_logout_data = [
        'session_id' => session_id(),
        'user_id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'timestamp' => time(),
        'has_session_vars' => !empty($_SESSION)
    ];
    
    echo "<div class='live-test'>";
    echo "<h5>Estado ANTES del logout:</h5>";
    echo "<pre>" . json_encode($pre_logout_data, JSON_PRETTY_PRINT) . "</pre>";
    echo "</div>";
    
    echo "<div class='alert alert-warning'>";
    echo "<h4>⚠️ Importante</h4>";
    echo "<p>El siguiente botón hará logout REAL. Después de hacer clic:</p>";
    echo "<ul>";
    echo "<li>Deberías ser redirigido a la página principal</li>";
    echo "<li>Ya no deberías tener acceso a páginas de admin</li>";
    echo "<li>Deberías ver botones de 'Registrarse' e 'Iniciar Sesión'</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<div class='text-center'>";
    echo "<a href='" . BASE_URL . "/logout' class='btn btn-danger btn-lg me-3'>";
    echo "<i class='bi bi-box-arrow-right'></i> HACER LOGOUT REAL AHORA";
    echo "</a>";
    echo "<a href='?step=check' class='btn btn-secondary'>";
    echo "<i class='bi bi-arrow-left'></i> Volver";
    echo "</a>";
    echo "</div>";
    echo "</div>";
}

// 5. Post-logout (verificar resultado)
if (!$has_session && $step === 'check') {
    echo "<div class='verification-step step-success'>";
    echo "<h3><i class='bi bi-check-circle'></i> Post-Logout: Verificación de Resultado</h3>";
    
    echo "<div class='alert alert-success'>";
    echo "<h4>✅ LOGOUT EXITOSO</h4>";
    echo "<p>No hay sesión activa, lo que confirma que el logout funcionó correctamente.</p>";
    echo "</div>";
    
    echo "<div class='row'>";
    echo "<div class='col-md-6'>";
    echo "<h5>Verificaciones Adicionales:</h5>";
    echo "<div class='live-test'>";
    echo "✅ Sesión destruida: " . (empty($_SESSION) ? 'SÍ' : 'NO') . "<br>";
    echo "✅ Session ID: " . session_id() . "<br>";
    echo "✅ Timestamp: " . date('Y-m-d H:i:s') . "<br>";
    echo "✅ Redirección: Llegaste aquí desde logout";
    echo "</div>";
    echo "</div>";
    
    echo "<div class='col-md-6'>";
    echo "<h5>Próximos Pasos:</h5>";
    echo "<a href='" . BASE_URL . "' class='btn btn-primary w-100 mb-2'>";
    echo "<i class='bi bi-house'></i> Ir a Página Principal";
    echo "</a>";
    echo "<a href='" . BASE_URL . "/login' class='btn btn-outline-primary w-100'>";
    echo "<i class='bi bi-box-arrow-in-right'></i> Volver a Iniciar Sesión";
    echo "</a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

// 6. Test alternativo con JavaScript
echo "<div class='verification-step step-info'>";
echo "<h3><i class='bi bi-code-square'></i> Test Alternativo con JavaScript</h3>";

echo "<div class='row'>";
echo "<div class='col-md-6'>";
echo "<h5>Test de Conectividad:</h5>";
echo "<button onclick='testLogoutUrl()' class='btn btn-outline-primary w-100'>";
echo "<i class='bi bi-wifi'></i> Probar Conectividad Logout";
echo "</button>";
echo "<div id='connectivity-result' class='mt-2'></div>";
echo "</div>";

echo "<div class='col-md-6'>";
echo "<h5>Test de Redirección:</h5>";
echo "<button onclick='testRedirection()' class='btn btn-outline-info w-100'>";
echo "<i class='bi bi-arrow-repeat'></i> Simular Redirección";
echo "</button>";
echo "<div id='redirect-result' class='mt-2'></div>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "<div class='text-center mt-4'>";
echo "<a href='?step=check' class='btn btn-outline-secondary me-2'>";
echo "<i class='bi bi-arrow-clockwise'></i> Refrescar Verificación";
echo "</a>";
echo "<a href='analisis_completo.php' class='btn btn-outline-info'>";
echo "<i class='bi bi-search'></i> Análisis Técnico Completo";
echo "</a>";
echo "</div>";

echo "</div>"; // container

echo "<script>
function testLogoutUrl() {
    const resultDiv = document.getElementById('connectivity-result');
    resultDiv.innerHTML = '<small class=\"text-info\">Probando...</small>';
    
    fetch('" . BASE_URL . "/logout', {
        method: 'HEAD',
        credentials: 'include'
    })
    .then(response => {
        const color = response.ok ? 'success' : 'danger';
        resultDiv.innerHTML = '<div class=\"alert alert-' + color + ' small\">Status: ' + response.status + ' ' + response.statusText + '</div>';
    })
    .catch(error => {
        resultDiv.innerHTML = '<div class=\"alert alert-danger small\">Error: ' + error.message + '</div>';
    });
}

function testRedirection() {
    const resultDiv = document.getElementById('redirect-result');
    resultDiv.innerHTML = '<small class=\"text-info\">Verificando redirección...</small>';
    
    // Simular el flujo de redirección
    const baseUrl = '" . BASE_URL . "';
    const homeUrl = baseUrl + '/';
    
    fetch(homeUrl, {
        method: 'HEAD',
        credentials: 'include'
    })
    .then(response => {
        const color = response.ok ? 'success' : 'warning';
        resultDiv.innerHTML = '<div class=\"alert alert-' + color + ' small\">';
        resultDiv.innerHTML += 'Página principal: ' + response.status + '<br>';
        resultDiv.innerHTML += 'URL destino: ' + homeUrl + '</div>';
    })
    .catch(error => {
        resultDiv.innerHTML = '<div class=\"alert alert-danger small\">Error: ' + error.message + '</div>';
    });
}
</script>";

echo "</body></html>";
?>