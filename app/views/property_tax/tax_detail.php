<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-receipt"></i> Detalle del Impuesto Predial</h1>
        <a href="<?php echo BASE_URL; ?>/impuesto-predial/consultar" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-building"></i> Información del Predio</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Clave Catastral:</th>
                        <td><strong><?php echo htmlspecialchars($tax['cadastral_key']); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Propietario:</th>
                        <td><?php echo htmlspecialchars($tax['owner_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Dirección:</th>
                        <td><?php echo htmlspecialchars($tax['address']); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="bi bi-cash"></i> Detalle del Impuesto</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Año:</th>
                        <td><strong><?php echo $tax['year']; ?></strong></td>
                    </tr>
                    <tr>
                        <th>Periodo:</th>
                        <td><?php echo $tax['period']; ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de Vencimiento:</th>
                        <td><?php echo date('d/m/Y', strtotime($tax['due_date'])); ?></td>
                    </tr>
                    <tr>
                        <th>Monto Base:</th>
                        <td>$<?php echo number_format($tax['base_amount'], 2); ?></td>
                    </tr>
                    <?php if ($tax['discount_amount'] > 0): ?>
                    <tr>
                        <th>Descuento:</th>
                        <td class="text-success">-$<?php echo number_format($tax['discount_amount'], 2); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if ($tax['interest_amount'] > 0): ?>
                    <tr>
                        <th>Recargos:</th>
                        <td class="text-danger">+$<?php echo number_format($tax['interest_amount'], 2); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th><h5>Total a Pagar:</h5></th>
                        <td><h5 class="text-primary"><strong>$<?php echo number_format($tax['total_amount'], 2); ?></strong></h5></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-3 <?php echo $tax['status'] === 'pending' || $tax['status'] === 'overdue' ? 'border-warning' : ''; ?>">
            <div class="card-body text-center">
                <h5>Estado del Impuesto</h5>
                <?php
                $statusClass = '';
                $statusText = '';
                switch($tax['status']) {
                    case 'pending':
                        $statusClass = 'warning';
                        $statusText = 'Pendiente';
                        break;
                    case 'paid':
                        $statusClass = 'success';
                        $statusText = 'Pagado';
                        break;
                    case 'overdue':
                        $statusClass = 'danger';
                        $statusText = 'Vencido';
                        break;
                    case 'cancelled':
                        $statusClass = 'secondary';
                        $statusText = 'Cancelado';
                        break;
                    default:
                        $statusClass = 'secondary';
                        $statusText = ucfirst($tax['status']);
                }
                ?>
                <span class="badge bg-<?php echo $statusClass; ?> fs-5 p-3"><?php echo $statusText; ?></span>
                
                <?php if ($tax['status'] === 'paid' && !empty($tax['paid_date'])): ?>
                    <p class="mt-3 mb-0 small text-muted">
                        Pagado el: <?php echo date('d/m/Y', strtotime($tax['paid_date'])); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($tax['status'] === 'pending' || $tax['status'] === 'overdue'): ?>
        <a href="<?php echo BASE_URL; ?>/impuesto-predial/pagar/<?php echo $tax['id']; ?>" 
           class="btn btn-primary btn-lg w-100 mb-3">
            <i class="bi bi-credit-card"></i> Pagar Ahora
        </a>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Información</h6>
            </div>
            <div class="card-body">
                <p class="small mb-2">
                    <i class="bi bi-check-circle"></i> Paga antes de la fecha de vencimiento para evitar recargos.
                </p>
                <p class="small mb-2">
                    <i class="bi bi-clock"></i> Los pagos se reflejan en un plazo de 24 a 48 horas.
                </p>
                <p class="small mb-0">
                    <i class="bi bi-receipt"></i> Recibirás tu comprobante por correo electrónico.
                </p>
            </div>
        </div>
    </div>
</div>
