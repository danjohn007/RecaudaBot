<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Conexión - RecaudaBot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="bi bi-gear"></i> Test de Conexión y Configuración</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Load configuration
                        require_once __DIR__ . '/config/config.php';
                        
                        $tests = [];
                        
                        // Test 1: PHP Version
                        $phpVersion = phpversion();
                        $tests[] = [
                            'name' => 'Versión de PHP',
                            'status' => version_compare($phpVersion, '7.4.0', '>='),
                            'message' => "PHP $phpVersion " . (version_compare($phpVersion, '7.4.0', '>=') ? '✓' : '✗ (Se requiere 7.4+)')
                        ];
                        
                        // Test 2: Required Extensions
                        $requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'json', 'openssl'];
                        foreach ($requiredExtensions as $ext) {
                            $tests[] = [
                                'name' => "Extensión: $ext",
                                'status' => extension_loaded($ext),
                                'message' => extension_loaded($ext) ? "$ext está disponible ✓" : "$ext NO está disponible ✗"
                            ];
                        }
                        
                        // Test 3: URL Base Detection
                        $tests[] = [
                            'name' => 'Detección de URL Base',
                            'status' => defined('BASE_URL') && !empty(BASE_URL),
                            'message' => defined('BASE_URL') ? "URL Base: " . BASE_URL . " ✓" : "URL Base no detectada ✗"
                        ];
                        
                        // Test 4: Database Connection
                        $dbStatus = false;
                        $dbMessage = '';
                        try {
                            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
                            $pdo = new PDO($dsn, DB_USER, DB_PASS);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $dbStatus = true;
                            $dbMessage = "Conexión exitosa a la base de datos '" . DB_NAME . "' ✓";
                            
                            // Test database tables
                            $stmt = $pdo->query("SHOW TABLES");
                            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                            $tableCount = count($tables);
                            
                            if ($tableCount > 0) {
                                $dbMessage .= " ($tableCount tablas encontradas)";
                            } else {
                                $dbMessage .= " (⚠ No se encontraron tablas. Ejecuta schema.sql)";
                            }
                        } catch (PDOException $e) {
                            $dbMessage = "Error de conexión: " . $e->getMessage() . " ✗";
                        }
                        
                        $tests[] = [
                            'name' => 'Conexión a Base de Datos',
                            'status' => $dbStatus,
                            'message' => $dbMessage
                        ];
                        
                        // Test 5: Write permissions
                        $uploadPath = defined('UPLOAD_PATH') ? UPLOAD_PATH : __DIR__ . '/public/uploads/';
                        $canWrite = is_writable(dirname($uploadPath));
                        $tests[] = [
                            'name' => 'Permisos de Escritura',
                            'status' => $canWrite,
                            'message' => $canWrite ? "El directorio tiene permisos de escritura ✓" : "Sin permisos de escritura en el directorio ✗"
                        ];
                        
                        // Test 6: .htaccess
                        $htaccessExists = file_exists(__DIR__ . '/.htaccess') && file_exists(__DIR__ . '/public/.htaccess');
                        $tests[] = [
                            'name' => 'Archivos .htaccess',
                            'status' => $htaccessExists,
                            'message' => $htaccessExists ? "Archivos .htaccess presentes ✓" : "Archivos .htaccess faltantes ✗"
                        ];
                        
                        // Display results
                        $allPassed = true;
                        foreach ($tests as $test) {
                            if (!$test['status']) {
                                $allPassed = false;
                            }
                            $badgeClass = $test['status'] ? 'bg-success' : 'bg-danger';
                            $icon = $test['status'] ? 'check-circle' : 'x-circle';
                            
                            echo "<div class='mb-3'>";
                            echo "<div class='d-flex align-items-center'>";
                            echo "<i class='bi bi-$icon me-2 text-" . ($test['status'] ? 'success' : 'danger') . "'></i>";
                            echo "<strong>{$test['name']}:</strong>";
                            echo "</div>";
                            echo "<p class='ms-4 mb-0'>{$test['message']}</p>";
                            echo "</div>";
                        }
                        ?>
                        
                        <hr>
                        
                        <?php if ($allPassed): ?>
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill"></i> 
                                <strong>¡Todo está configurado correctamente!</strong><br>
                                El sistema está listo para ser usado.
                            </div>
                            <a href="<?php echo BASE_URL; ?>" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-arrow-right-circle"></i> Ir al Sistema
                            </a>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle-fill"></i> 
                                <strong>Hay problemas que deben ser resueltos</strong><br>
                                Por favor, revisa la configuración y los requisitos.
                            </div>
                        <?php endif; ?>
                        
                        <div class="mt-4">
                            <h5>Información del Sistema:</h5>
                            <ul class="list-unstyled">
                                <li><strong>Sistema Operativo:</strong> <?php echo PHP_OS; ?></li>
                                <li><strong>Servidor:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Desconocido'; ?></li>
                                <li><strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?></li>
                                <li><strong>Script Path:</strong> <?php echo __DIR__; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="card shadow mt-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Instrucciones de Instalación</h5>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>Asegúrate de que tu servidor cumpla con los requisitos (PHP 7.4+, MySQL 5.7+, mod_rewrite)</li>
                            <li>Crea la base de datos MySQL: <code>CREATE DATABASE recaudabot;</code></li>
                            <li>Importa el esquema: <code>mysql -u root -p recaudabot < assets/sql/schema.sql</code></li>
                            <li>Importa los datos de ejemplo: <code>mysql -u root -p recaudabot < assets/sql/sample_data.sql</code></li>
                            <li>Configura las credenciales de la base de datos en <code>config/config.php</code></li>
                            <li>Verifica que mod_rewrite esté habilitado en Apache</li>
                            <li>Asegúrate de que los archivos .htaccess tengan permisos de lectura</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
