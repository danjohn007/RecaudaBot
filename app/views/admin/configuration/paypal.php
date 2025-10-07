<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-paypal"></i> Configuración PayPal</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/configuraciones">Configuraciones</a></li>
                <li class="breadcrumb-item active">PayPal</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-gear"></i> Credenciales de PayPal</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/configuraciones/actualizar">
                    <input type="hidden" name="redirect" value="/admin/configuraciones/paypal">
                    
                    <div class="mb-3">
                        <label for="paypal_client_id" class="form-label">Client ID</label>
                        <input type="text" class="form-control" id="paypal_client_id" 
                               name="settings[paypal_client_id]" 
                               value="<?php echo htmlspecialchars($settings['paypal_client_id'] ?? ''); ?>">
                        <small class="text-muted">ID de cliente de PayPal</small>
                    </div>

                    <div class="mb-3">
                        <label for="paypal_secret" class="form-label">Secret</label>
                        <input type="password" class="form-control" id="paypal_secret" 
                               name="settings[paypal_secret]" 
                               value="<?php echo htmlspecialchars($settings['paypal_secret'] ?? ''); ?>">
                        <small class="text-muted">Clave secreta de PayPal</small>
                    </div>

                    <div class="mb-3">
                        <label for="paypal_mode" class="form-label">Modo</label>
                        <select class="form-select" id="paypal_mode" name="settings[paypal_mode]">
                            <option value="sandbox" <?php echo ($settings['paypal_mode'] ?? 'sandbox') === 'sandbox' ? 'selected' : ''; ?>>Sandbox (Pruebas)</option>
                            <option value="live" <?php echo ($settings['paypal_mode'] ?? '') === 'live' ? 'selected' : ''; ?>>Live (Producción)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="paypal_currency" class="form-label">Moneda</label>
                        <input type="text" class="form-control" id="paypal_currency" 
                               name="settings[paypal_currency]" 
                               value="<?php echo htmlspecialchars($settings['paypal_currency'] ?? 'MXN'); ?>">
                        <small class="text-muted">Código de moneda (MXN, USD, etc.)</small>
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

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Ayuda</h6>
            </div>
            <div class="card-body">
                <p class="small">Para obtener tus credenciales de PayPal:</p>
                <ol class="small">
                    <li>Inicia sesión en tu cuenta de PayPal</li>
                    <li>Ve a la sección de desarrolladores</li>
                    <li>Crea una aplicación</li>
                    <li>Copia el Client ID y Secret</li>
                </ol>
                <a href="https://developer.paypal.com" target="_blank" class="btn btn-sm btn-info w-100">
                    <i class="bi bi-box-arrow-up-right"></i> PayPal Developer
                </a>
            </div>
        </div>
    </div>
</div>
