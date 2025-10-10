<?php
// Test específico del botón de logout y su comportamiento
session_start();
require_once __DIR__ . '/../config/config.php';

echo "<!DOCTYPE html><html><head>";
echo "<title>Test Específico - Botón de Logout</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css'>";
echo "</head><body class='bg-light'>";

echo "<div class='container mt-4'>";
echo "<h1 class='text-center mb-4'><i class='bi bi-mouse'></i> Test Específico - Botón de Logout</h1>";

// Estado actual
if (isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-success'>";
    echo "<h4><i class='bi bi-person-check'></i> Usuario Logueado</h4>";
    echo "<strong>Usuario:</strong> " . $_SESSION['username'] . "<br>";
    echo "<strong>ID:</strong> " . $_SESSION['user_id'] . "<br>";
    echo "<strong>Rol:</strong> " . $_SESSION['role'];
    echo "</div>";
    $user_logged = true;
} else {
    echo "<div class='alert alert-warning'>";
    echo "<h4><i class='bi bi-person-x'></i> No hay sesión activa</h4>";
    echo "</div>";
    $user_logged = false;
}

// Análisis del botón de logout
echo "<div class='card mt-4'>";
echo "<div class='card-body'>";
echo "<h3>🔍 Análisis del Botón de Logout</h3>";

echo "<div class='row'>";
echo "<div class='col-md-6'>";
echo "<h5>Botón Original del Header:</h5>";
echo "<div class='bg-light p-3 rounded'>";
echo "<code>";
echo "&lt;a class=\"dropdown-item\" href=\"" . BASE_URL . "/logout\"&gt;<br>";
echo "&nbsp;&nbsp;&lt;i class=\"bi bi-box-arrow-right\"&gt;&lt;/i&gt; Cerrar Sesión<br>";
echo "&lt;/a&gt;";
echo "</code>";
echo "</div>";

echo "<p><strong>URL de destino:</strong> " . BASE_URL . "/logout</p>";
echo "<p><strong>Método:</strong> GET (enlace simple)</p>";
echo "<p><strong>JavaScript:</strong> Ninguno (enlace puro)</p>";
echo "</div>";

echo "<div class='col-md-6'>";
echo "<h5>Reproducción Exacta:</h5>";
if ($user_logged) {
    echo "<a class='dropdown-item btn btn-outline-danger' href='" . BASE_URL . "/logout'>";
    echo "<i class='bi bi-box-arrow-right'></i> Cerrar Sesión (Copia Exacta)";
    echo "</a>";
    echo "<br><br>";
    echo "<small class='text-muted'>Este es exactamente el mismo botón que aparece en el header</small>";
} else {
    echo "<div class='alert alert-info'>";
    echo "No hay sesión activa para probar el botón";
    echo "</div>";
}
echo "</div>";
echo "</div>";

echo "</div></div>";

// Test de la URL de logout
echo "<div class='card mt-4'>";
echo "<div class='card-body'>";
echo "<h3>🌐 Test de la URL de Logout</h3>";

echo "<div class='row'>";
echo "<div class='col-md-4'>";
echo "<h6>1. Test con GET directo:</h6>";
echo "<button onclick='testLogoutGET()' class='btn btn-primary w-100'>";
echo "<i class='bi bi-globe'></i> Test GET /logout";
echo "</button>";
echo "<div id='get-result' class='mt-2'></div>";
echo "</div>";

echo "<div class='col-md-4'>";
echo "<h6>2. Test con POST:</h6>";
echo "<form method='POST' action='" . BASE_URL . "/logout' target='_blank'>";
echo "<button type='submit' class='btn btn-warning w-100'>";
echo "<i class='bi bi-envelope'></i> Test POST /logout";
echo "</button>";
echo "</form>";
echo "<small class='text-muted'>Se abrirá en nueva ventana</small>";
echo "</div>";

echo "<div class='col-md-4'>";
echo "<h6>3. Test con JavaScript:</h6>";
echo "<button onclick='testLogoutJS()' class='btn btn-info w-100'>";
echo "<i class='bi bi-code'></i> Test con JS";
echo "</button>";
echo "<div id='js-result' class='mt-2'></div>";
echo "</div>";
echo "</div>";

echo "</div></div>";

// Comparación con otros enlaces que funcionan
echo "<div class='card mt-4'>";
echo "<div class='card-body'>";
echo "<h3>⚖️ Comparación con Enlaces que SÍ Funcionan</h3>";

echo "<div class='row'>";
echo "<div class='col-md-6'>";
echo "<h5>Enlaces que Funcionan:</h5>";
echo "<ul class='list-group'>";
echo "<li class='list-group-item'>";
echo "<a href='" . BASE_URL . "' class='text-decoration-none'>";
echo "<i class='bi bi-house'></i> Página Principal (" . BASE_URL . ")";
echo "</a>";
echo "</li>";
echo "<li class='list-group-item'>";
echo "<a href='" . BASE_URL . "/login' class='text-decoration-none'>";
echo "<i class='bi bi-box-arrow-in-right'></i> Login (" . BASE_URL . "/login)";
echo "</a>";
echo "</li>";
echo "<li class='list-group-item'>";
echo "<a href='" . BASE_URL . "/register' class='text-decoration-none'>";
echo "<i class='bi bi-person-plus'></i> Registro (" . BASE_URL . "/register)";
echo "</a>";
echo "</li>";
echo "</ul>";
echo "</div>";

echo "<div class='col-md-6'>";
echo "<h5>Enlace Problemático:</h5>";
echo "<ul class='list-group'>";
echo "<li class='list-group-item list-group-item-warning'>";
if ($user_logged) {
    echo "<a href='" . BASE_URL . "/logout' class='text-decoration-none'>";
    echo "<i class='bi bi-box-arrow-right'></i> Logout (" . BASE_URL . "/logout)";
    echo "</a>";
} else {
    echo "<span class='text-muted'>";
    echo "<i class='bi bi-box-arrow-right'></i> Logout (sin sesión para probar)";
    echo "</span>";
}
echo "</li>";
echo "</ul>";

echo "<div class='mt-3'>";
echo "<h6>Diferencias detectadas:</h6>";
echo "<ul class='small'>";
echo "<li>Otros enlaces: GET simple → Éxito</li>";
echo "<li>Logout: GET simple → ¿Problema?</li>";
echo "<li>Logout requiere sesión activa</li>";
echo "<li>Logout hace session_destroy()</li>";
echo "</ul>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "</div></div>";

// Debug del router
if ($user_logged) {
    echo "<div class='card mt-4'>";
    echo "<div class='card-body'>";
    echo "<h3>🛣️ Debug del Router</h3>";
    
    echo "<p>Cuando haces clic en el botón de logout, se hace un GET a <code>" . BASE_URL . "/logout</code></p>";
    echo "<p>El Router debería:</p>";
    echo "<ol>";
    echo "<li>Recibir la petición GET /logout</li>";
    echo "<li>Encontrar la ruta en index.php: <code>\$router->get('/logout', [new AuthController(), 'logout']);</code></li>";
    echo "<li>Ejecutar <code>AuthController::logout()</code></li>";
    echo "<li>El método logout() debería hacer <code>\$this->redirect('/')</code></li>";
    echo "<li>Deberías llegar a la página principal</li>";
    echo "</ol>";
    
    echo "<div class='alert alert-warning'>";
    echo "<h5>🤔 Si no funciona, posibles causas:</h5>";
    echo "<ul>";
    echo "<li>Router no encuentra la ruta /logout</li>";
    echo "<li>AuthController no se carga correctamente</li>";
    echo "<li>session_destroy() interfiere con redirect</li>";
    echo "<li>Algún error en el método redirect()</li>";
    echo "<li>Headers ya enviados por algún output anterior</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "</div></div>";
}

echo "<div class='text-center mt-4'>";
echo "<a href='verificacion_tiempo_real.php' class='btn btn-outline-primary me-2'>";
echo "<i class='bi bi-clock'></i> Verificación Tiempo Real";
echo "</a>";
echo "<a href='test_simulacion_directa.php' class='btn btn-outline-info'>";
echo "<i class='bi bi-gear'></i> Simulación Directa";
echo "</a>";
echo "</div>";

echo "</div>"; // container

echo "<script>
function testLogoutGET() {
    const resultDiv = document.getElementById('get-result');
    resultDiv.innerHTML = '<small class=\"text-info\">Probando GET...</small>';
    
    fetch('" . BASE_URL . "/logout', {
        method: 'GET',
        credentials: 'include',
        redirect: 'manual'
    })
    .then(response => {
        let message = 'Status: ' + response.status;
        if (response.status === 302 || response.status === 301) {
            const location = response.headers.get('Location');
            message += '<br>Redirect a: ' + location;
        }
        resultDiv.innerHTML = '<small class=\"text-success\">' + message + '</small>';
    })
    .catch(error => {
        resultDiv.innerHTML = '<small class=\"text-danger\">Error: ' + error.message + '</small>';
    });
}

function testLogoutJS() {
    const resultDiv = document.getElementById('js-result');
    resultDiv.innerHTML = '<small class=\"text-info\">Probando con JS...</small>';
    
    // Simular clic en enlace
    const testUrl = '" . BASE_URL . "/logout';
    resultDiv.innerHTML = '<small class=\"text-warning\">Redirigiendo a: ' + testUrl + '</small>';
    
    setTimeout(() => {
        window.location.href = testUrl;
    }, 2000);
}
</script>";

echo "</body></html>";
?>