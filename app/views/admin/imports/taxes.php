<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-receipt"></i> Importar Impuestos</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/importaciones">Importaciones</a></li>
                <li class="breadcrumb-item active">Impuestos</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-upload"></i> Cargar Archivo de Impuestos</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/importaciones/procesar" enctype="multipart/form-data">
                    <input type="hidden" name="import_type" value="taxes">
                    
                    <div class="mb-3">
                        <label for="import_file" class="form-label">Seleccionar Archivo</label>
                        <input type="file" class="form-control" id="import_file" name="import_file" 
                               accept=".csv,.xml,.xlsx,.xls" required>
                        <small class="text-muted">Formatos permitidos: CSV, XML, Excel (.xlsx, .xls)</small>
                    </div>

                    <div class="alert alert-info">
                        <h6><i class="bi bi-info-circle"></i> Campos Requeridos:</h6>
                        <ul class="mb-0">
                            <li><strong>property_id</strong> - ID del predio</li>
                            <li><strong>year</strong> - Año del impuesto (4 dígitos)</li>
                            <li><strong>period</strong> - Periodo (Q1, Q2, Q3, Q4 o anual)</li>
                            <li><strong>base_amount</strong> - Monto base</li>
                            <li><strong>total_amount</strong> - Monto total</li>
                            <li><strong>due_date</strong> - Fecha límite (YYYY-MM-DD)</li>
                            <li><strong>status</strong> - Estado (pending, paid, overdue)</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo BASE_URL; ?>/admin/importaciones" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                        <button type="submit" class="btn btn-info">
                            <i class="bi bi-upload"></i> Importar Datos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-download"></i> Plantilla</h6>
            </div>
            <div class="card-body">
                <p class="small">Descarga la plantilla CSV con el formato correcto:</p>
                <a href="<?php echo BASE_URL; ?>/admin/importaciones/plantilla?type=taxes" 
                   class="btn btn-success w-100">
                    <i class="bi bi-download"></i> Descargar Plantilla
                </a>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Notas</h6>
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li>El property_id debe existir en la base de datos</li>
                    <li>Los montos deben ser números positivos</li>
                    <li>La fecha límite debe estar en formato YYYY-MM-DD</li>
                    <li>Los registros duplicados serán omitidos</li>
                </ul>
            </div>
        </div>
    </div>
</div>
