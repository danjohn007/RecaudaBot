<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow text-center">
            <div class="card-body py-5">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                <h1 class="mt-4 mb-3">¡Pago Exitoso!</h1>
                <p class="lead">Tu pago ha sido procesado correctamente</p>
                
                <div class="alert alert-success text-start mt-4">
                    <p class="mb-2"><strong>Referencia de Pago:</strong> <?php echo htmlspecialchars($payment['reference_number']); ?></p>
                    <p class="mb-2"><strong>Monto:</strong> $<?php echo number_format($payment['amount'], 2); ?></p>
                    <p class="mb-2"><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($payment['paid_at'])); ?></p>
                    <?php if ($receipt): ?>
                    <p class="mb-0"><strong>Comprobante:</strong> <?php echo htmlspecialchars($receipt['receipt_number']); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($receipt): ?>
                <a href="<?php echo BASE_URL; ?>/comprobantes/descargar/<?php echo $receipt['id']; ?>" 
                   class="btn btn-primary btn-lg mb-2">
                    <i class="bi bi-download"></i> Descargar Comprobante
                </a>
                <?php endif; ?>
                
                <a href="<?php echo BASE_URL; ?>" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-house"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </div>
</div>
