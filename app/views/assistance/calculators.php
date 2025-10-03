<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-calculator"></i> Calculadoras y Simuladores</h1>
        <p class="lead">Simula costos de trámites y pagos municipales</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-house"></i> Calculadora de Impuesto Predial</h5>
            </div>
            <div class="card-body">
                <p>Calcula el impuesto predial estimado según el valor catastral de tu propiedad.</p>
                <form id="propertyTaxCalc" class="mt-3">
                    <div class="mb-3">
                        <label for="cadastralValue" class="form-label">Valor Catastral (MXN)</label>
                        <input type="number" class="form-control" id="cadastralValue" placeholder="Ej: 500000" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Calcular</button>
                </form>
                <div id="propertyTaxResult" class="alert alert-info mt-3" style="display: none;">
                    <strong>Impuesto Anual Estimado:</strong> <span id="propertyTaxAmount"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> Calculadora de Licencia de Funcionamiento</h5>
            </div>
            <div class="card-body">
                <p>Estima el costo de tu licencia de funcionamiento según el tipo de negocio.</p>
                <form id="licenseCalc" class="mt-3">
                    <div class="mb-3">
                        <label for="businessType" class="form-label">Tipo de Negocio</label>
                        <select class="form-select" id="businessType" required>
                            <option value="">Seleccionar...</option>
                            <option value="small">Pequeño Comercio (hasta 50 m²)</option>
                            <option value="medium">Comercio Mediano (51-200 m²)</option>
                            <option value="large">Comercio Grande (más de 200 m²)</option>
                            <option value="restaurant">Restaurante/Bar</option>
                            <option value="service">Servicios Profesionales</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Calcular</button>
                </form>
                <div id="licenseResult" class="alert alert-info mt-3" style="display: none;">
                    <strong>Costo Estimado:</strong> <span id="licenseAmount"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-car-front"></i> Calculadora de Multas de Tránsito</h5>
            </div>
            <div class="card-body">
                <p>Calcula el descuento por pago anticipado de multas de tránsito.</p>
                <form id="fineCalc" class="mt-3">
                    <div class="mb-3">
                        <label for="fineAmount" class="form-label">Monto de la Multa (MXN)</label>
                        <input type="number" class="form-control" id="fineAmount" placeholder="Ej: 1000" required>
                    </div>
                    <div class="mb-3">
                        <label for="paymentDays" class="form-label">Días transcurridos desde la infracción</label>
                        <input type="number" class="form-control" id="paymentDays" placeholder="Ej: 5" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Calcular</button>
                </form>
                <div id="fineResult" class="alert alert-info mt-3" style="display: none;">
                    <strong>Descuento aplicable:</strong> <span id="fineDiscount"></span><br>
                    <strong>Monto a pagar:</strong> <span id="fineToPay"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Calculadora de Recargos</h5>
            </div>
            <div class="card-body">
                <p>Calcula recargos por pago extemporáneo de obligaciones fiscales.</p>
                <form id="surchargeCalc" class="mt-3">
                    <div class="mb-3">
                        <label for="baseAmount" class="form-label">Monto Base (MXN)</label>
                        <input type="number" class="form-control" id="baseAmount" placeholder="Ej: 2000" required>
                    </div>
                    <div class="mb-3">
                        <label for="delayMonths" class="form-label">Meses de retraso</label>
                        <input type="number" class="form-control" id="delayMonths" placeholder="Ej: 3" required>
                    </div>
                    <button type="submit" class="btn btn-info">Calcular</button>
                </form>
                <div id="surchargeResult" class="alert alert-info mt-3" style="display: none;">
                    <strong>Recargos:</strong> <span id="surchargeAmount"></span><br>
                    <strong>Total a pagar:</strong> <span id="totalWithSurcharge"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> <strong>Nota:</strong> Los cálculos mostrados son estimaciones. 
            Los montos exactos pueden variar según regulaciones municipales vigentes, descuentos especiales, y otros factores.
            Para información precisa, consulta directamente en las oficinas municipales o verifica tus datos en el sistema.
        </div>
    </div>
</div>

<script>
// Property Tax Calculator
document.getElementById('propertyTaxCalc').addEventListener('submit', function(e) {
    e.preventDefault();
    const value = parseFloat(document.getElementById('cadastralValue').value);
    // Simple calculation: 0.2% of cadastral value
    const tax = value * 0.002;
    document.getElementById('propertyTaxAmount').textContent = '$' + tax.toFixed(2) + ' MXN';
    document.getElementById('propertyTaxResult').style.display = 'block';
});

// License Calculator
document.getElementById('licenseCalc').addEventListener('submit', function(e) {
    e.preventDefault();
    const type = document.getElementById('businessType').value;
    const costs = {
        'small': 2500,
        'medium': 5000,
        'large': 10000,
        'restaurant': 8000,
        'service': 3500
    };
    const cost = costs[type] || 0;
    document.getElementById('licenseAmount').textContent = '$' + cost.toFixed(2) + ' MXN';
    document.getElementById('licenseResult').style.display = 'block';
});

// Fine Calculator
document.getElementById('fineCalc').addEventListener('submit', function(e) {
    e.preventDefault();
    const amount = parseFloat(document.getElementById('fineAmount').value);
    const days = parseInt(document.getElementById('paymentDays').value);
    
    let discount = 0;
    if (days <= 5) {
        discount = 0.5; // 50% discount
    } else if (days <= 15) {
        discount = 0.3; // 30% discount
    } else if (days <= 30) {
        discount = 0.15; // 15% discount
    }
    
    const toPay = amount * (1 - discount);
    document.getElementById('fineDiscount').textContent = (discount * 100) + '%';
    document.getElementById('fineToPay').textContent = '$' + toPay.toFixed(2) + ' MXN';
    document.getElementById('fineResult').style.display = 'block';
});

// Surcharge Calculator
document.getElementById('surchargeCalc').addEventListener('submit', function(e) {
    e.preventDefault();
    const base = parseFloat(document.getElementById('baseAmount').value);
    const months = parseInt(document.getElementById('delayMonths').value);
    
    // 2% monthly surcharge
    const surcharge = base * 0.02 * months;
    const total = base + surcharge;
    
    document.getElementById('surchargeAmount').textContent = '$' + surcharge.toFixed(2) + ' MXN';
    document.getElementById('totalWithSurcharge').textContent = '$' + total.toFixed(2) + ' MXN';
    document.getElementById('surchargeResult').style.display = 'block';
});
</script>
