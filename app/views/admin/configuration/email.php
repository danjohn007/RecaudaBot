<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-envelope"></i> Configuración de Correo</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/configuraciones">Configuraciones</a></li>
                <li class="breadcrumb-item active">Correo</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-gear"></i> Configuración SMTP</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/configuraciones/actualizar">
                    <input type="hidden" name="redirect" value="/admin/configuraciones/correo">
                    
                    <div class="mb-3">
                        <label for="email_from" class="form-label">Correo Emisor</label>
                        <input type="email" class="form-control" id="email_from" 
                               name="settings[email_from]" 
                               value="<?php echo htmlspecialchars($settings['email_from'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email_from_name" class="form-label">Nombre del Emisor</label>
                        <input type="text" class="form-control" id="email_from_name" 
                               name="settings[email_from_name]" 
                               value="<?php echo htmlspecialchars($settings['email_from_name'] ?? 'RecaudaBot'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email_host" class="form-label">Servidor SMTP</label>
                        <input type="text" class="form-control" id="email_host" 
                               name="settings[email_host]" 
                               value="<?php echo htmlspecialchars($settings['email_host'] ?? ''); ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email_port" class="form-label">Puerto</label>
                            <input type="number" class="form-control" id="email_port" 
                                   name="settings[email_port]" 
                                   value="<?php echo htmlspecialchars($settings['email_port'] ?? '587'); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email_encryption" class="form-label">Encriptación</label>
                            <select class="form-select" id="email_encryption" name="settings[email_encryption]">
                                <option value="tls" <?php echo ($settings['email_encryption'] ?? 'tls') === 'tls' ? 'selected' : ''; ?>>TLS</option>
                                <option value="ssl" <?php echo ($settings['email_encryption'] ?? '') === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email_username" class="form-label">Usuario SMTP</label>
                        <input type="text" class="form-control" id="email_username" 
                               name="settings[email_username]" 
                               value="<?php echo htmlspecialchars($settings['email_username'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email_password" class="form-label">Contraseña SMTP</label>
                        <input type="password" class="form-control" id="email_password" 
                               name="settings[email_password]" 
                               value="<?php echo htmlspecialchars($settings['email_password'] ?? ''); ?>">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo BASE_URL; ?>/admin/configuraciones" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Información</h6>
            </div>
            <div class="card-body">
                <p class="small">Puertos comunes:</p>
                <ul class="small">
                    <li>25 - SMTP no encriptado</li>
                    <li>465 - SMTP con SSL</li>
                    <li>587 - SMTP con TLS (recomendado)</li>
                </ul>
            </div>
        </div>
    </div>
</div>
