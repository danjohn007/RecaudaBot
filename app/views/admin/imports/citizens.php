<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-people"></i> Importar Ciudadanos</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/importaciones">Importaciones</a></li>
                <li class="breadcrumb-item active">Ciudadanos</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-upload"></i> Cargar Archivo de Ciudadanos</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/importaciones/procesar" enctype="multipart/form-data">
                    <input type="hidden" name="import_type" value="citizens">
                    
                    <div class="mb-3">
                        <label for="import_file" class="form-label">Seleccionar Archivo</label>
                        <input type="file" class="form-control" id="import_file" name="import_file" 
                               accept=".csv,.xml,.xlsx,.xls" required>
                        <small class="text-muted">Formatos permitidos: CSV, XML, Excel (.xlsx, .xls)</small>
                    </div>

                    <div class="alert alert-info">
                        <h6><i class="bi bi-info-circle"></i> Campos Requeridos:</h6>
                        <ul class="mb-0">
                            <li><strong>email</strong> - Correo electrónico (único)</li>
                            <li><strong>full_name</strong> - Nombre completo</li>
                            <li><strong>phone</strong> - Teléfono (10 dígitos)</li>
                            <li><strong>curp</strong> - CURP (18 caracteres, opcional)</li>
                            <li><strong>address</strong> - Dirección (opcional)</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo BASE_URL; ?>/admin/importaciones" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                        <button type="submit" class="btn btn-primary">
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
                <a href="<?php echo BASE_URL; ?>/admin/importaciones/plantilla?type=citizens" 
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
                    <li>Los ciudadanos se registran con rol "citizen"</li>
                    <li>La contraseña inicial es "temporal123"</li>
                    <li>Se recomienda que cambien su contraseña al primer acceso</li>
                    <li>Los ciudadanos duplicados serán omitidos</li>
                </ul>
            </div>
        </div>
    </div>
</div>
