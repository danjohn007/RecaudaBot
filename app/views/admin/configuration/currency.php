<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-currency-dollar"></i> Configuración de Moneda e Impuestos</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/configuraciones">Configuraciones</a></li>
                <li class="breadcrumb-item active">Moneda e Impuestos</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-cash"></i> Configuración de Moneda</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/configuraciones/actualizar">
                    <input type="hidden" name="redirect" value="/admin/configuraciones/moneda">
                    
                    <div class="mb-3">
                        <label for="currency_code" class="form-label">Código de Moneda</label>
                        <select class="form-select" id="currency_code" name="settings[currency_code]">
                            <option value="MXN" <?php echo ($currency_settings['currency_code'] ?? 'MXN') === 'MXN' ? 'selected' : ''; ?>>MXN - Peso Mexicano</option>
                            <option value="USD" <?php echo ($currency_settings['currency_code'] ?? '') === 'USD' ? 'selected' : ''; ?>>USD - Dólar Estadounidense</option>
                            <option value="EUR" <?php echo ($currency_settings['currency_code'] ?? '') === 'EUR' ? 'selected' : ''; ?>>EUR - Euro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="currency_symbol" class="form-label">Símbolo de Moneda</label>
                        <input type="text" class="form-control" id="currency_symbol" 
                               name="settings[currency_symbol]" 
                               value="<?php echo htmlspecialchars($currency_settings['currency_symbol'] ?? '$'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="currency_position" class="form-label">Posición del Símbolo</label>
                        <select class="form-select" id="currency_position" name="settings[currency_position]">
                            <option value="before" <?php echo ($currency_settings['currency_position'] ?? 'before') === 'before' ? 'selected' : ''; ?>>Antes del monto ($100)</option>
                            <option value="after" <?php echo ($currency_settings['currency_position'] ?? '') === 'after' ? 'selected' : ''; ?>>Después del monto (100$)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="currency_decimal_separator" class="form-label">Separador Decimal</label>
                        <select class="form-select" id="currency_decimal_separator" name="settings[currency_decimal_separator]">
                            <option value="." <?php echo ($currency_settings['currency_decimal_separator'] ?? '.') === '.' ? 'selected' : ''; ?>>Punto (.)</option>
                            <option value="," <?php echo ($currency_settings['currency_decimal_separator'] ?? '') === ',' ? 'selected' : ''; ?>>Coma (,)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="currency_thousand_separator" class="form-label">Separador de Miles</label>
                        <select class="form-select" id="currency_thousand_separator" name="settings[currency_thousand_separator]">
                            <option value="," <?php echo ($currency_settings['currency_thousand_separator'] ?? ',') === ',' ? 'selected' : ''; ?>>Coma (,)</option>
                            <option value="." <?php echo ($currency_settings['currency_thousand_separator'] ?? '') === '.' ? 'selected' : ''; ?>>Punto (.)</option>
                            <option value=" " <?php echo ($currency_settings['currency_thousand_separator'] ?? '') === ' ' ? 'selected' : ''; ?>>Espacio ( )</option>
                        </select>
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

    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-percent"></i> Configuración de Impuestos</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/configuraciones/actualizar">
                    <input type="hidden" name="redirect" value="/admin/configuraciones/moneda">
                    
                    <div class="mb-3">
                        <label for="tax_iva_rate" class="form-label">Tasa de IVA (%)</label>
                        <input type="number" step="0.01" class="form-control" id="tax_iva_rate" 
                               name="settings[tax_iva_rate]" 
                               value="<?php echo htmlspecialchars($tax_settings['tax_iva_rate'] ?? '16'); ?>">
                        <small class="form-text text-muted">Tasa de Impuesto al Valor Agregado</small>
                    </div>

                    <div class="mb-3">
                        <label for="tax_property_rate" class="form-label">Tasa de Impuesto Predial (%)</label>
                        <input type="number" step="0.01" class="form-control" id="tax_property_rate" 
                               name="settings[tax_property_rate]" 
                               value="<?php echo htmlspecialchars($tax_settings['tax_property_rate'] ?? '0.5'); ?>">
                        <small class="form-text text-muted">Tasa aplicada al valor catastral</small>
                    </div>

                    <div class="mb-3">
                        <label for="tax_late_payment_interest" class="form-label">Interés por Mora (%)</label>
                        <input type="number" step="0.01" class="form-control" id="tax_late_payment_interest" 
                               name="settings[tax_late_payment_interest]" 
                               value="<?php echo htmlspecialchars($tax_settings['tax_late_payment_interest'] ?? '2'); ?>">
                        <small class="form-text text-muted">Interés mensual por pagos atrasados</small>
                    </div>

                    <div class="mb-3">
                        <label for="tax_early_payment_discount" class="form-label">Descuento por Pronto Pago (%)</label>
                        <input type="number" step="0.01" class="form-control" id="tax_early_payment_discount" 
                               name="settings[tax_early_payment_discount]" 
                               value="<?php echo htmlspecialchars($tax_settings['tax_early_payment_discount'] ?? '10'); ?>">
                        <small class="form-text text-muted">Descuento por pago anticipado</small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
