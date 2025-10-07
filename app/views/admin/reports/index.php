<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-file-earmark-bar-graph"></i> Reportes y Análisis</h1>
        <p class="lead">Genera reportes detallados con filtros personalizados y exportación</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-people fs-1 text-primary"></i>
                <h5 class="card-title mt-3">Reporte de Ciudadanos</h5>
                <p class="card-text">Consulta información de ciudadanos registrados con filtros avanzados</p>
                <a href="<?php echo BASE_URL; ?>/admin/reportes/ciudadanos" class="btn btn-primary">
                    <i class="bi bi-file-text"></i> Ver Reporte
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-receipt fs-1 text-warning"></i>
                <h5 class="card-title mt-3">Obligaciones Fiscales</h5>
                <p class="card-text">Reporte de impuestos, multas y trámites municipales</p>
                <a href="<?php echo BASE_URL; ?>/admin/reportes/obligaciones" class="btn btn-warning">
                    <i class="bi bi-file-text"></i> Ver Reporte
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-cash-coin fs-1 text-success"></i>
                <h5 class="card-title mt-3">Reporte de Pagos</h5>
                <p class="card-text">Consulta el histórico de pagos realizados con detalle</p>
                <a href="<?php echo BASE_URL; ?>/admin/reportes/pagos" class="btn btn-success">
                    <i class="bi bi-file-text"></i> Ver Reporte
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-building fs-1 text-info"></i>
                <h5 class="card-title mt-3">Reporte de Predios</h5>
                <p class="card-text">Información catastral y propietarios de predios</p>
                <a href="<?php echo BASE_URL; ?>/admin/reportes/obligaciones?type=property_tax" class="btn btn-info">
                    <i class="bi bi-file-text"></i> Ver Reporte
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-shop fs-1 text-primary"></i>
                <h5 class="card-title mt-3">Licencias de Funcionamiento</h5>
                <p class="card-text">Reporte de licencias comerciales emitidas</p>
                <a href="<?php echo BASE_URL; ?>/admin/reportes/pagos?type=business_license" class="btn btn-primary">
                    <i class="bi bi-file-text"></i> Ver Reporte
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                <h5 class="card-title mt-3">Multas y Sanciones</h5>
                <p class="card-text">Reporte de multas de tránsito y cívicas</p>
                <a href="<?php echo BASE_URL; ?>/admin/reportes/obligaciones?type=traffic_fine" class="btn btn-danger">
                    <i class="bi bi-file-text"></i> Ver Reporte
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Características de los Reportes</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="bi bi-funnel"></i> Filtros Disponibles:</h6>
                        <ul>
                            <li>Rango de fechas</li>
                            <li>Estado (Activo, Pendiente, Pagado, etc.)</li>
                            <li>Tipo de obligación fiscal</li>
                            <li>Búsqueda por nombre o identificador</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-download"></i> Formatos de Exportación:</h6>
                        <ul>
                            <li><strong>CSV</strong> - Compatible con Excel y LibreOffice</li>
                            <li><strong>XML</strong> - Para integración con otros sistemas</li>
                            <li><strong>Excel</strong> - Archivo nativo de Microsoft Excel</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
