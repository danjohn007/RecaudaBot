<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-upload"></i> Importaciones Masivas</h1>
        <p class="lead">Importa datos de ciudadanos, propiedades, obligaciones fiscales y pagos desde archivos CSV, XML o Excel</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-people fs-1 text-primary"></i>
                <h5 class="card-title mt-3">Importar Ciudadanos</h5>
                <p class="card-text">Carga masiva de ciudadanos con sus datos personales</p>
                <a href="<?php echo BASE_URL; ?>/admin/importaciones/ciudadanos" class="btn btn-primary">
                    <i class="bi bi-upload"></i> Importar
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-house fs-1 text-success"></i>
                <h5 class="card-title mt-3">Importar Predios</h5>
                <p class="card-text">Carga masiva de predios con información catastral</p>
                <a href="<?php echo BASE_URL; ?>/admin/importaciones/predios" class="btn btn-success">
                    <i class="bi bi-upload"></i> Importar
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-receipt fs-1 text-info"></i>
                <h5 class="card-title mt-3">Importar Impuestos</h5>
                <p class="card-text">Carga masiva de impuestos prediales</p>
                <a href="<?php echo BASE_URL; ?>/admin/importaciones/impuestos" class="btn btn-info">
                    <i class="bi bi-upload"></i> Importar
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-exclamation-triangle fs-1 text-warning"></i>
                <h5 class="card-title mt-3">Importar Multas</h5>
                <p class="card-text">Carga masiva de multas de tránsito y cívicas</p>
                <a href="<?php echo BASE_URL; ?>/admin/importaciones/multas" class="btn btn-warning">
                    <i class="bi bi-upload"></i> Importar
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="bi bi-cash-coin fs-1 text-success"></i>
                <h5 class="card-title mt-3">Importar Pagos</h5>
                <p class="card-text">Carga masiva de pagos y comprobantes</p>
                <a href="<?php echo BASE_URL; ?>/admin/importaciones/pagos" class="btn btn-success">
                    <i class="bi bi-upload"></i> Importar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Instrucciones</h5>
            </div>
            <div class="card-body">
                <h6>Formatos Soportados:</h6>
                <ul>
                    <li><strong>CSV</strong> - Archivo de valores separados por comas (recomendado)</li>
                    <li><strong>XML</strong> - Archivo de marcado extensible</li>
                    <li><strong>Excel</strong> - Archivos .xlsx o .xls (convertir a CSV para mejor compatibilidad)</li>
                </ul>

                <h6 class="mt-3">Pasos para Importar:</h6>
                <ol>
                    <li>Descarga la plantilla del tipo de importación que necesitas</li>
                    <li>Llena la plantilla con los datos correspondientes</li>
                    <li>Guarda el archivo en formato CSV</li>
                    <li>Selecciona el archivo y haz clic en "Importar"</li>
                    <li>Verifica los resultados de la importación</li>
                </ol>

                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle"></i> 
                    <strong>Importante:</strong> Asegúrate de que los datos sean correctos antes de importar. 
                    Las importaciones masivas no se pueden deshacer fácilmente.
                </div>
            </div>
        </div>
    </div>
</div>
