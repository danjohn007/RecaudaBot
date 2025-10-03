<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-file-text"></i> Detalle de Multa</h1>
        <a href="<?php echo BASE_URL; ?>/multas-transito/consultar" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Información de la Infracción</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">Folio:</th>
                        <td><strong><?php echo htmlspecialchars($fine['folio']); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Fecha y Hora:</th>
                        <td><?php echo date('d/m/Y H:i', strtotime($fine['infraction_date'])); ?></td>
                    </tr>
                    <tr>
                        <th>Placas del Vehículo:</th>
                        <td><?php echo htmlspecialchars($fine['license_plate']); ?></td>
                    </tr>
                    <tr>
                        <th>Conductor:</th>
                        <td><?php echo htmlspecialchars($fine['driver_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Tipo de Infracción:</th>
                        <td><?php echo htmlspecialchars($fine['infraction_type']); ?></td>
                    </tr>
                    <tr>
                        <th>Código:</th>
                        <td><?php echo htmlspecialchars($fine['infraction_code']); ?></td>
                    </tr>
                    <tr>
                        <th>Descripción:</th>
                        <td><?php echo htmlspecialchars($fine['description']); ?></td>
                    </tr>
                    <tr>
                        <th>Ubicación:</th>
                        <td><?php echo htmlspecialchars($fine['location']); ?></td>
                    </tr>
                    <tr>
                        <th>Oficial:</th>
                        <td><?php echo htmlspecialchars($fine['officer_name']); ?> (<?php echo htmlspecialchars($fine['officer_badge']); ?>)</td>
                    </tr>
                </table>
            </div>
        </div>

        <?php if ($fine['has_evidence']): ?>
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-camera"></i> Evidencia Fotográfica</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Las evidencias fotográficas están disponibles para esta infracción.</p>
                <button class="btn btn-info" onclick="alert('Funcionalidad de visualización de evidencias disponible')">
                    <i class="bi bi-image"></i> Ver Evidencias
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-3 <?php echo $fine['status'] === 'pending' ? 'border-warning' : ''; ?>">
            <div class="card-body">
                <h5>Monto a Pagar</h5>
                <p class="mb-2">Monto Base: <strong>$<?php echo number_format($fine['base_amount'], 2); ?></strong></p>
                <?php if ($discount > 0): ?>
                <p class="mb-2 text-success">Descuento: <strong>-$<?php echo number_format($discount, 2); ?></strong></p>
                <hr>
                <p class="mb-0 fs-4">Total: <strong class="text-success">$<?php echo number_format($fine['base_amount'] - $discount, 2); ?></strong></p>
                <small class="text-muted">Descuento válido por pronto pago</small>
                <?php else: ?>
                <hr>
                <p class="mb-0 fs-4">Total: <strong>$<?php echo number_format($fine['total_amount'], 2); ?></strong></p>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($fine['status'] === 'pending'): ?>
        <a href="<?php echo BASE_URL; ?>/multas-transito/pagar/<?php echo $fine['id']; ?>" 
           class="btn btn-primary btn-lg w-100 mb-3">
            <i class="bi bi-credit-card"></i> Pagar Ahora
        </a>
        
        <a href="<?php echo BASE_URL; ?>/multas-transito/impugnar/<?php echo $fine['id']; ?>" 
           class="btn btn-outline-danger w-100">
            <i class="bi bi-shield-x"></i> Impugnar Multa
        </a>
        <?php elseif ($fine['status'] === 'paid'): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> Multa pagada
        </div>
        <?php elseif ($fine['status'] === 'appealed'): ?>
        <div class="alert alert-info">
            <i class="bi bi-hourglass-split"></i> Impugnación en proceso
        </div>
        <?php endif; ?>
    </div>
</div>
