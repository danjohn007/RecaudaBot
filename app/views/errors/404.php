<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-md-6 text-center">
                <i class="bi bi-exclamation-triangle text-warning" style="font-size: 8rem;"></i>
                <h1 class="display-1 fw-bold">404</h1>
                <h2 class="mb-4">Página no encontrada</h2>
                <p class="lead mb-4">Lo sentimos, la página que buscas no existe o ha sido movida.</p>
                <a href="<?php echo BASE_URL ?? '/'; ?>" class="btn btn-primary btn-lg">
                    <i class="bi bi-house"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </div>
</body>
</html>
