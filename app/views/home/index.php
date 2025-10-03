<div class="row">
    <div class="col-12">
        <div class="jumbotron bg-light p-5 rounded">
            <h1 class="display-4"><i class="bi bi-building"></i> Bienvenido a RecaudaBot</h1>
            <p class="lead">Sistema Integral de Recaudación Municipal</p>
            <hr class="my-4">
            <p>Gestiona tus obligaciones fiscales y trámites municipales de manera fácil, rápida y segura desde cualquier lugar.</p>
            <?php if (!$isLoggedIn): ?>
            <a class="btn btn-primary btn-lg" href="<?php echo BASE_URL; ?>/register" role="button">
                <i class="bi bi-person-plus"></i> Regístrate Ahora
            </a>
            <a class="btn btn-outline-primary btn-lg" href="<?php echo BASE_URL; ?>/login" role="button">
                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h3 class="card-title"><i class="bi bi-house text-primary"></i> Impuesto Predial</h3>
                <p class="card-text">Consulta y paga tu impuesto predial. Visualiza avalúos, periodos vencidos y obtén descuentos por pronto pago.</p>
                <a href="<?php echo BASE_URL; ?>/impuesto-predial/consultar" class="btn btn-primary">
                    <i class="bi bi-search"></i> Consultar
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h3 class="card-title"><i class="bi bi-briefcase text-success"></i> Licencias de Funcionamiento</h3>
                <p class="card-text">Solicita o renueva tu licencia de funcionamiento. Sube documentos y da seguimiento en tiempo real.</p>
                <a href="<?php echo BASE_URL; ?>/licencias" class="btn btn-success">
                    <i class="bi bi-file-earmark-text"></i> Tramitar
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h3 class="card-title"><i class="bi bi-car-front text-warning"></i> Multas de Tránsito</h3>
                <p class="card-text">Consulta multas por placa, licencia o folio. Visualiza evidencias y aprovecha descuentos por pago voluntario.</p>
                <a href="<?php echo BASE_URL; ?>/multas-transito/consultar" class="btn btn-warning">
                    <i class="bi bi-search"></i> Consultar
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h3 class="card-title"><i class="bi bi-exclamation-triangle text-danger"></i> Multas Cívicas</h3>
                <p class="card-text">Consulta sanciones del Juzgado Cívico. Visualiza fundamentos legales y presenta medios de defensa.</p>
                <a href="<?php echo BASE_URL; ?>/multas-civicas/consultar" class="btn btn-danger">
                    <i class="bi bi-search"></i> Consultar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <h2 class="text-center mb-4">Servicios Adicionales</h2>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-receipt fs-1 text-info"></i>
                <h5 class="card-title mt-3">Comprobantes Digitales</h5>
                <p class="card-text">Descarga tus comprobantes de pago en PDF y XML</p>
                <?php if ($isLoggedIn): ?>
                <a href="<?php echo BASE_URL; ?>/comprobantes" class="btn btn-info">Ver Comprobantes</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-calendar fs-1 text-primary"></i>
                <h5 class="card-title mt-3">Agendar Cita</h5>
                <p class="card-text">Programa tu visita para trámites presenciales</p>
                <?php if ($isLoggedIn): ?>
                <a href="<?php echo BASE_URL; ?>/citas/agendar" class="btn btn-primary">Agendar</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-question-circle fs-1 text-success"></i>
                <h5 class="card-title mt-3">Orientación y Ayuda</h5>
                <p class="card-text">Guías, FAQ y asistente virtual disponible 24/7</p>
                <a href="<?php echo BASE_URL; ?>/orientacion" class="btn btn-success">Obtener Ayuda</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5 bg-light p-4 rounded">
    <div class="col-12">
        <h3 class="text-center mb-4"><i class="bi bi-shield-check"></i> Características del Sistema</h3>
    </div>
    <div class="col-md-3 text-center">
        <i class="bi bi-lock fs-2 text-primary"></i>
        <h5>Seguro</h5>
        <p class="text-muted">Autenticación segura y encriptación de datos</p>
    </div>
    <div class="col-md-3 text-center">
        <i class="bi bi-clock fs-2 text-success"></i>
        <h5>24/7</h5>
        <p class="text-muted">Disponible las 24 horas del día</p>
    </div>
    <div class="col-md-3 text-center">
        <i class="bi bi-phone fs-2 text-info"></i>
        <h5>Responsive</h5>
        <p class="text-muted">Acceso desde cualquier dispositivo</p>
    </div>
    <div class="col-md-3 text-center">
        <i class="bi bi-lightning fs-2 text-warning"></i>
        <h5>Rápido</h5>
        <p class="text-muted">Pagos y trámites en minutos</p>
    </div>
</div>
