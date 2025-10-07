<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-bank"></i> Cuentas Bancarias</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/configuraciones">Configuraciones</a></li>
                <li class="breadcrumb-item active">Cuentas Bancarias</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-credit-card"></i> Información de Cuentas Bancarias</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/configuraciones/actualizar">
                    <input type="hidden" name="redirect" value="/admin/configuraciones/cuentas-bancarias">
                    
                    <h6 class="mb-3">Cuenta Principal</h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="bank_name_1" class="form-label">Nombre del Banco</label>
                            <input type="text" class="form-control" id="bank_name_1" 
                                   name="settings[bank_name_1]" 
                                   value="<?php echo htmlspecialchars($settings['bank_name_1'] ?? ''); ?>"
                                   placeholder="Ejemplo: BBVA Bancomer">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="bank_account_number_1" class="form-label">Número de Cuenta</label>
                            <input type="text" class="form-control" id="bank_account_number_1" 
                                   name="settings[bank_account_number_1]" 
                                   value="<?php echo htmlspecialchars($settings['bank_account_number_1'] ?? ''); ?>"
                                   placeholder="1234567890">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="bank_clabe_1" class="form-label">CLABE Interbancaria</label>
                            <input type="text" class="form-control" id="bank_clabe_1" 
                                   name="settings[bank_clabe_1]" 
                                   value="<?php echo htmlspecialchars($settings['bank_clabe_1'] ?? ''); ?>"
                                   placeholder="012345678901234567" maxlength="18">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="bank_holder_1" class="form-label">Titular de la Cuenta</label>
                            <input type="text" class="form-control" id="bank_holder_1" 
                                   name="settings[bank_holder_1]" 
                                   value="<?php echo htmlspecialchars($settings['bank_holder_1'] ?? ''); ?>"
                                   placeholder="Gobierno Municipal">
                        </div>
                    </div>

                    <hr class="my-4">
                    
                    <h6 class="mb-3">Cuenta Secundaria (Opcional)</h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="bank_name_2" class="form-label">Nombre del Banco</label>
                            <input type="text" class="form-control" id="bank_name_2" 
                                   name="settings[bank_name_2]" 
                                   value="<?php echo htmlspecialchars($settings['bank_name_2'] ?? ''); ?>"
                                   placeholder="Ejemplo: Santander">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="bank_account_number_2" class="form-label">Número de Cuenta</label>
                            <input type="text" class="form-control" id="bank_account_number_2" 
                                   name="settings[bank_account_number_2]" 
                                   value="<?php echo htmlspecialchars($settings['bank_account_number_2'] ?? ''); ?>"
                                   placeholder="1234567890">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="bank_clabe_2" class="form-label">CLABE Interbancaria</label>
                            <input type="text" class="form-control" id="bank_clabe_2" 
                                   name="settings[bank_clabe_2]" 
                                   value="<?php echo htmlspecialchars($settings['bank_clabe_2'] ?? ''); ?>"
                                   placeholder="012345678901234567" maxlength="18">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="bank_holder_2" class="form-label">Titular de la Cuenta</label>
                            <input type="text" class="form-control" id="bank_holder_2" 
                                   name="settings[bank_holder_2]" 
                                   value="<?php echo htmlspecialchars($settings['bank_holder_2'] ?? ''); ?>"
                                   placeholder="Gobierno Municipal">
                        </div>
                    </div>

                    <hr class="my-4">
                    
                    <h6 class="mb-3">Referencia Bancaria</h6>
                    
                    <div class="mb-3">
                        <label for="bank_reference_prefix" class="form-label">Prefijo de Referencia</label>
                        <input type="text" class="form-control" id="bank_reference_prefix" 
                               name="settings[bank_reference_prefix]" 
                               value="<?php echo htmlspecialchars($settings['bank_reference_prefix'] ?? 'MUN'); ?>"
                               placeholder="MUN">
                        <small class="form-text text-muted">Prefijo para generar referencias de pago únicas</small>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Nota:</strong> Esta información se mostrará a los ciudadanos al generar fichas de pago para depósito bancario.
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
