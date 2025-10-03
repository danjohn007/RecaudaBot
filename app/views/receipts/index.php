<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-receipt"></i> Mis Comprobantes</h1>
        <p class="lead">Historial de comprobantes de pago</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <?php if (empty($receipts)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No tienes comprobantes registrados aún.
            </div>
        <?php else: ?>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Fecha</th>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($receipts as $receipt): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($receipt['receipt_number']); ?></strong></td>
                                    <td><?php echo date('d/m/Y', strtotime($receipt['issued_at'])); ?></td>
                                    <td><?php echo ucfirst(str_replace('_', ' ', $receipt['payment']['payment_type'])); ?></td>
                                    <td><strong>$<?php echo number_format($receipt['payment']['amount'], 2); ?></strong></td>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>/comprobantes/descargar/<?php echo $receipt['id']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-download"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
