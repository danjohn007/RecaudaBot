<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-globe"></i> Configuración del Sitio</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/configuraciones">Configuraciones</a></li>
                <li class="breadcrumb-item active">Sitio</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-10 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-gear"></i> Información del Sitio Público</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/configuraciones/actualizar">
                    <input type="hidden" name="redirect" value="/admin/configuraciones/sitio">
                    
                    <div class="mb-3">
                        <label for="site_name" class="form-label">Nombre del Sitio</label>
                        <input type="text" class="form-control" id="site_name" 
                               name="settings[site_name]" 
                               value="<?php echo htmlspecialchars($settings['site_name'] ?? 'RecaudaBot'); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="site_description" class="form-label">Descripción del Sitio</label>
                        <textarea class="form-control" id="site_description" 
                                  name="settings[site_description]" rows="3"><?php echo htmlspecialchars($settings['site_description'] ?? 'Sistema Integral de Recaudación Municipal'); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="site_logo_url" class="form-label">URL del Logo</label>
                        <input type="url" class="form-control" id="site_logo_url" 
                               name="settings[site_logo_url]" 
                               value="<?php echo htmlspecialchars($settings['site_logo_url'] ?? ''); ?>">
                        <small class="text-muted">URL completa del logo (ej: https://ejemplo.com/logo.png)</small>
                    </div>

                    <div class="mb-3">
                        <label for="site_favicon_url" class="form-label">URL del Favicon</label>
                        <input type="url" class="form-control" id="site_favicon_url" 
                               name="settings[site_favicon_url]" 
                               value="<?php echo htmlspecialchars($settings['site_favicon_url'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="site_footer_text" class="form-label">Texto del Pie de Página</label>
                        <textarea class="form-control" id="site_footer_text" 
                                  name="settings[site_footer_text]" rows="2"><?php echo htmlspecialchars($settings['site_footer_text'] ?? 'Municipio. Todos los derechos reservados.'); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo BASE_URL; ?>/admin/configuraciones" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                        <button type="submit" class="btn btn-info">
                            <i class="bi bi-save"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
