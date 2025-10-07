<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-file-text"></i> Términos y Condiciones</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/configuraciones">Configuraciones</a></li>
                <li class="breadcrumb-item active">Términos y Condiciones</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> Configuración de Términos y Condiciones</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/configuraciones/actualizar">
                    <input type="hidden" name="redirect" value="/admin/configuraciones/terminos">
                    
                    <div class="mb-3">
                        <label for="terms_and_conditions" class="form-label">Términos y Condiciones del Servicio</label>
                        <textarea class="form-control" id="terms_and_conditions" 
                                  name="settings[terms_and_conditions]" rows="15"><?php echo htmlspecialchars($terms); ?></textarea>
                        <small class="form-text text-muted">Ingrese los términos y condiciones que los usuarios deben aceptar al registrarse y utilizar el sistema.</small>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Nota:</strong> Los términos y condiciones se mostrarán a los usuarios durante el registro y en la sección de información del sistema.
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo BASE_URL; ?>/admin/configuraciones" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Optional: Add rich text editor if needed
// Example with simple formatting buttons
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('terms_and_conditions');
    
    // Add auto-resize
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }
});
</script>
