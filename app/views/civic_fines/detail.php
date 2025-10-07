<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-file-text"></i> Detalle de Multa Cívica</h1>
        <a href="<?php echo BASE_URL; ?>/multas-civicas/consultar" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Información de la Infracción Cívica</h4>
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
                        <th>Infractor:</th>
                        <td><?php echo htmlspecialchars($fine['citizen_name']); ?></td>
                    </tr>
                    <?php if (!empty($fine['citizen_id'])): ?>
                    <tr>
                        <th>CURP:</th>
                        <td><?php echo htmlspecialchars($fine['citizen_id']); ?></td>
                    </tr>
                    <?php endif; ?>
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
                        <th>Inspector:</th>
                        <td><?php echo htmlspecialchars($fine['inspector_name']); ?> (<?php echo htmlspecialchars($fine['inspector_badge']); ?>)</td>
                    </tr>
                    <?php if (!empty($fine['notes'])): ?>
                    <tr>
                        <th>Notas:</th>
                        <td><?php echo nl2br(htmlspecialchars($fine['notes'])); ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-3 <?php echo $fine['status'] === 'pending' ? 'border-warning' : ''; ?>">
            <div class="card-body">
                <h5>Monto a Pagar</h5>
                <p class="mb-2">Monto Base: <strong>$<?php echo number_format($fine['base_amount'], 2); ?></strong></p>
                <?php if (isset($fine['discount_amount']) && $fine['discount_amount'] > 0): ?>
                <p class="mb-2 text-success">Descuento: <strong>-$<?php echo number_format($fine['discount_amount'], 2); ?></strong></p>
                <?php endif; ?>
                <?php if (isset($fine['interest_amount']) && $fine['interest_amount'] > 0): ?>
                <p class="mb-2 text-danger">Recargos: <strong>+$<?php echo number_format($fine['interest_amount'], 2); ?></strong></p>
                <?php endif; ?>
                <hr>
                <p class="mb-0 fs-4">Total: <strong>$<?php echo number_format($fine['total_amount'], 2); ?></strong></p>
            </div>
        </div>

        <?php if ($fine['status'] === 'pending'): ?>
        <a href="<?php echo BASE_URL; ?>/multas-civicas/pagar/<?php echo $fine['id']; ?>" 
           class="btn btn-primary btn-lg w-100 mb-3">
            <i class="bi bi-credit-card"></i> Pagar Ahora
        </a>
        <?php elseif ($fine['status'] === 'paid'): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> Multa pagada
            <?php if (!empty($fine['paid_date'])): ?>
            <br><small>Fecha de pago: <?php echo date('d/m/Y', strtotime($fine['paid_date'])); ?></small>
            <?php endif; ?>
        </div>
        <?php elseif ($fine['status'] === 'cancelled'): ?>
        <div class="alert alert-secondary">
            <i class="bi bi-x-circle"></i> Multa cancelada
        </div>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Estado de la Multa</h6>
            </div>
            <div class="card-body">
                <?php
                $statusClass = '';
                $statusText = '';
                switch($fine['status']) {
                    case 'pending':
                        $statusClass = 'warning';
                        $statusText = 'Pendiente de Pago';
                        break;
                    case 'paid':
                        $statusClass = 'success';
                        $statusText = 'Pagada';
                        break;
                    case 'cancelled':
                        $statusClass = 'secondary';
                        $statusText = 'Cancelada';
                        break;
                    default:
                        $statusClass = 'secondary';
                        $statusText = ucfirst($fine['status']);
                }
                ?>
                <span class="badge bg-<?php echo $statusClass; ?> fs-6"><?php echo $statusText; ?></span>
            </div>
        </div>
    </div>
</div>
