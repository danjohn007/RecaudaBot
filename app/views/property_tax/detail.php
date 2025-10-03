<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-house"></i> Detalle del Predio</h1>
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
                        <td><strong><?php echo htmlspecialchars($property['cadastral_key']); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Propietario:</th>
                        <td><?php echo htmlspecialchars($property['owner_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Dirección:</th>
                        <td><?php echo htmlspecialchars($property['address']); ?></td>
                    </tr>
                    <tr>
                        <th>Superficie de Terreno:</th>
                        <td><?php echo number_format($property['area_m2'], 2); ?> m²</td>
                    </tr>
                    <tr>
                        <th>Superficie Construida:</th>
                        <td><?php echo number_format($property['construction_m2'], 2); ?> m²</td>
                    </tr>
                    <tr>
                        <th>Valor Catastral:</th>
                        <td><strong>$<?php echo number_format($property['cadastral_value'], 2); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Tipo de Zona:</th>
                        <td><?php echo ucfirst($property['zone_type']); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="bi bi-list-check"></i> Historial de Pagos</h4>
            </div>
            <div class="card-body">
                <?php if (empty($taxes)): ?>
                    <p class="text-muted">No hay registros de impuesto para este predio.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Año</th>
                                    <th>Periodo</th>
                                    <th>Monto Base</th>
                                    <th>Descuento</th>
                                    <th>Intereses</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($taxes as $tax): ?>
                                <tr>
                                    <td><?php echo $tax['year']; ?></td>
                                    <td><?php echo $tax['period']; ?></td>
                                    <td>$<?php echo number_format($tax['base_amount'], 2); ?></td>
                                    <td class="text-success">-$<?php echo number_format($tax['discount_amount'], 2); ?></td>
                                    <td class="text-danger">+$<?php echo number_format($tax['interest_amount'], 2); ?></td>
                                    <td><strong>$<?php echo number_format($tax['total_amount'], 2); ?></strong></td>
                                    <td>
                                        <?php
                                        $badges = [
                                            'paid' => 'success',
                                            'pending' => 'warning',
                                            'overdue' => 'danger',
                                            'cancelled' => 'secondary'
                                        ];
                                        $badge = $badges[$tax['status']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo $badge; ?>">
                                            <?php echo ucfirst($tax['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($tax['status'] === 'pending' || $tax['status'] === 'overdue'): ?>
                                        <a href="<?php echo BASE_URL; ?>/impuesto-predial/pagar/<?php echo $tax['id']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-credit-card"></i> Pagar
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow bg-warning text-dark mb-3">
            <div class="card-body">
                <h5><i class="bi bi-exclamation-triangle"></i> Resumen</h5>
                <?php
                $totalPending = 0;
                $totalOverdue = 0;
                foreach ($taxes as $tax) {
                    if ($tax['status'] === 'pending') {
                        $totalPending += $tax['total_amount'];
                    } elseif ($tax['status'] === 'overdue') {
                        $totalOverdue += $tax['total_amount'];
                    }
                }
                ?>
                <p class="mb-2">Adeudo Pendiente: <strong>$<?php echo number_format($totalPending, 2); ?></strong></p>
                <p class="mb-2">Adeudo Vencido: <strong class="text-danger">$<?php echo number_format($totalOverdue, 2); ?></strong></p>
                <hr>
                <p class="mb-0 fs-5">Total a Pagar: <strong>$<?php echo number_format($totalPending + $totalOverdue, 2); ?></strong></p>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <h5><i class="bi bi-info-circle"></i> Información</h5>
                <p class="small mb-0">Si tienes dudas sobre tu adeudo, puedes:</p>
                <ul class="small mt-2">
                    <li>Agendar una cita presencial</li>
                    <li>Llamar al 01 800 123 4567</li>
                    <li>Usar nuestro chatbot de ayuda</li>
                </ul>
            </div>
        </div>
    </div>
</div>
