<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4"><i class="bi bi-credit-card"></i> Procesar Pago</h1>
        
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Resumen del Pago</h4>
            </div>
            <div class="card-body">
                <p><strong>Concepto:</strong> <?php echo htmlspecialchars($description); ?></p>
                <p><strong>Monto a Pagar:</strong> <span class="fs-3 text-success">$<?php echo number_format($amount, 2); ?></span></p>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Selecciona tu Método de Pago</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/pagos/confirmar" id="paymentForm">
                    <input type="hidden" name="payment_type" value="<?php echo htmlspecialchars($type); ?>">
                    <input type="hidden" name="reference_id" value="<?php echo htmlspecialchars($reference_id); ?>">
                    <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">

                    <div class="mb-4">
                        <div class="form-check mb-3 p-3 border rounded">
                            <input class="form-check-input" type="radio" name="payment_method" value="card" id="card" required>
                            <label class="form-check-label w-100" for="card">
                                <i class="bi bi-credit-card fs-4 text-primary"></i>
                                <strong class="ms-2">Tarjeta de Crédito/Débito</strong>
                            </label>
                        </div>

                        <div class="form-check mb-3 p-3 border rounded">
                            <input class="form-check-input" type="radio" name="payment_method" value="spei" id="spei">
                            <label class="form-check-label w-100" for="spei">
                                <i class="bi bi-bank fs-4 text-success"></i>
                                <strong class="ms-2">Transferencia SPEI</strong>
                            </label>
                        </div>

                        <div class="form-check mb-3 p-3 border rounded">
                            <input class="form-check-input" type="radio" name="payment_method" value="oxxo" id="oxxo">
                            <label class="form-check-label w-100" for="oxxo">
                                <i class="bi bi-shop fs-4 text-warning"></i>
                                <strong class="ms-2">OXXO</strong>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-check-circle"></i> Continuar con el Pago
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
