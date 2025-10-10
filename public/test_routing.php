<?php
/**
 * Web-accessible test to verify routing configuration
 */
session_start();
require_once __DIR__ . '/../config/config.php';

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Routing - RecaudaBot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .test-pass { color: green; font-weight: bold; }
        .test-fail { color: red; font-weight: bold; }
        .code-block { background: #f5f5f5; padding: 10px; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">🔧 Test de Configuración de Routing</h1>
        
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">1. Configuración de URLs</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="30%">BASE_URL:</th>
                        <td><code><?php echo BASE_URL; ?></code></td>
                    </tr>
                    <tr>
                        <th>PUBLIC_URL:</th>
                        <td><code><?php echo PUBLIC_URL; ?></code></td>
                    </tr>
                    <tr>
                        <th>HTTP_HOST:</th>
                        <td><code><?php echo $_SERVER['HTTP_HOST'] ?? 'No definido'; ?></code></td>
                    </tr>
                    <tr>
                        <th>REQUEST_URI:</th>
                        <td><code><?php echo $_SERVER['REQUEST_URI'] ?? 'No definido'; ?></code></td>
                    </tr>
                    <tr>
                        <th>SCRIPT_NAME:</th>
                        <td><code><?php echo $_SERVER['SCRIPT_NAME'] ?? 'No definido'; ?></code></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">2. URLs de Ejemplo Correctas</h5>
            </div>
            <div class="card-body">
                <h6>Rutas (usar BASE_URL):</h6>
                <ul>
                    <li>Login: <code><?php echo BASE_URL; ?>/login</code></li>
                    <li>Register: <code><?php echo BASE_URL; ?>/register</code></li>
                    <li>Admin: <code><?php echo BASE_URL; ?>/admin</code></li>
                    <li>Perfil: <code><?php echo BASE_URL; ?>/perfil</code></li>
                </ul>
                
                <h6 class="mt-3">Recursos Estáticos (usar PUBLIC_URL):</h6>
                <ul>
                    <li>CSS: <code><?php echo PUBLIC_URL; ?>/css/style.css</code></li>
                    <li>JS: <code><?php echo PUBLIC_URL; ?>/js/main.js</code></li>
                </ul>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">3. Pruebas de Enlaces</h5>
            </div>
            <div class="card-body">
                <p>Haz clic en los siguientes enlaces para verificar que funcionan:</p>
                <div class="list-group">
                    <a href="<?php echo BASE_URL; ?>/" class="list-group-item list-group-item-action">
                        🏠 Inicio (<?php echo BASE_URL; ?>/)
                    </a>
                    <a href="<?php echo BASE_URL; ?>/login" class="list-group-item list-group-item-action">
                        🔐 Login (<?php echo BASE_URL; ?>/login)
                    </a>
                    <a href="<?php echo BASE_URL; ?>/register" class="list-group-item list-group-item-action">
                        📝 Registro (<?php echo BASE_URL; ?>/register)
                    </a>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-warning">
                <h5 class="mb-0">4. Verificación de Recursos Estáticos</h5>
            </div>
            <div class="card-body">
                <?php
                $cssPath = __DIR__ . '/css/style.css';
                $jsPath = __DIR__ . '/js/main.js';
                ?>
                <p>Archivos locales:</p>
                <ul>
                    <li>
                        CSS: 
                        <?php if (file_exists($cssPath)): ?>
                            <span class="test-pass">✓ Existe</span>
                        <?php else: ?>
                            <span class="test-fail">✗ No existe</span>
                        <?php endif; ?>
                        - <a href="<?php echo PUBLIC_URL; ?>/css/style.css" target="_blank">Probar</a>
                    </li>
                    <li>
                        JS: 
                        <?php if (file_exists($jsPath)): ?>
                            <span class="test-pass">✓ Existe</span>
                        <?php else: ?>
                            <span class="test-fail">✗ No existe</span>
                        <?php endif; ?>
                        - <a href="<?php echo PUBLIC_URL; ?>/js/main.js" target="_blank">Probar</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">5. Prueba de Formulario</h5>
            </div>
            <div class="card-body">
                <p>Este formulario usa <code>BASE_URL</code> en la acción (correcto):</p>
                <form method="POST" action="<?php echo BASE_URL; ?>/login" class="code-block">
                    <div class="mb-3">
                        <label class="form-label">Usuario:</label>
                        <input type="text" class="form-control" name="username" placeholder="Prueba (no enviar)">
                    </div>
                    <code>action="<?php echo BASE_URL; ?>/login"</code>
                </form>
                
                <div class="alert alert-info mt-3">
                    <strong>✓ Correcto:</strong> El formulario apunta a <code><?php echo BASE_URL; ?>/login</code>
                </div>
            </div>
        </div>

        <div class="alert alert-success">
            <h5>✅ Resumen de la Configuración</h5>
            <ul class="mb-0">
                <li><strong>BASE_URL</strong> se usa para rutas, formularios y redirecciones</li>
                <li><strong>PUBLIC_URL</strong> se usa solo para recursos estáticos (CSS, JS, imágenes)</li>
                <li>El router maneja correctamente las rutas sin /public en la URL</li>
            </ul>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo BASE_URL; ?>/" class="btn btn-primary">Volver al Inicio</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
