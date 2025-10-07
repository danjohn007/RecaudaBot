<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-cash-coin"></i> Reporte de Pagos</h1>
        <p class="lead">Consulta el histórico de pagos realizados</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros de Búsqueda</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo BASE_URL; ?>/admin/reportes/pagos">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   placeholder="Nombre, email o ID transacción" 
                                   value="<?php echo htmlspecialchars($filters['search']); ?>">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="type" class="form-label">Tipo de Pago</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">Todos</option>
                                <option value="property_tax" <?php echo $filters['type'] === 'property_tax' ? 'selected' : ''; ?>>Impuesto Predial</option>
                                <option value="business_license" <?php echo $filters['type'] === 'business_license' ? 'selected' : ''; ?>>Licencia</option>
                                <option value="traffic_fine" <?php echo $filters['type'] === 'traffic_fine' ? 'selected' : ''; ?>>Multa Tránsito</option>
                                <option value="civic_fine" <?php echo $filters['type'] === 'civic_fine' ? 'selected' : ''; ?>>Multa Cívica</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Todos</option>
                                <option value="completed" <?php echo $filters['status'] === 'completed' ? 'selected' : ''; ?>>Completado</option>
                                <option value="pending" <?php echo $filters['status'] === 'pending' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="failed" <?php echo $filters['status'] === 'failed' ? 'selected' : ''; ?>>Fallido</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="date_from" class="form-label">Desde</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="<?php echo htmlspecialchars($filters['date_from']); ?>">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="date_to" class="form-label">Hasta</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" 
                                   value="<?php echo htmlspecialchars($filters['date_to']); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                            <a href="<?php echo BASE_URL; ?>/admin/reportes/pagos" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Limpiar
                            </a>
                            <a href="<?php echo BASE_URL; ?>/admin/reportes/exportar?type=payments&format=csv" class="btn btn-success">
                                <i class="bi bi-download"></i> Exportar CSV
                            </a>
                            <a href="<?php echo BASE_URL; ?>/admin/reportes/exportar?type=payments&format=xml" class="btn btn-info">
                                <i class="bi bi-download"></i> Exportar XML
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-table"></i> Resultados (<?php echo count($payments); ?> pagos)</h5>
            </div>
            <div class="card-body">
                <?php if (empty($payments)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No se encontraron pagos con los filtros aplicados.
                    </div>
                <?php else: ?>
                    <?php
                    $totalAmount = 0;
                    foreach ($payments as $payment) {
                        $totalAmount += $payment['amount'];
                    }
                    ?>
                    <div class="alert alert-success mb-3">
                        <strong>Total:</strong> $<?php echo number_format($totalAmount, 2); ?>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ciudadano</th>
                                    <th>Email</th>
                                    <th>Tipo de Pago</th>
                                    <th>Referencia</th>
                                    <th>Monto</th>
                                    <th>Método</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>ID Transacción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments as $payment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($payment['id']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['full_name'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($payment['email'] ?? 'N/A'); ?></td>
                                        <td>
                                            <?php 
                                            $typeLabels = [
                                                'property_tax' => 'Impuesto Predial',
                                                'business_license' => 'Licencia',
                                                'traffic_fine' => 'Multa Tránsito',
                                                'civic_fine' => 'Multa Cívica',
                                                'other' => 'Otro'
                                            ];
                                            echo $typeLabels[$payment['payment_type']] ?? $payment['payment_type'];
                                            ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($payment['reference_id']); ?></td>
                                        <td>$<?php echo number_format($payment['amount'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($payment['payment_method'] ?? 'N/A'); ?></td>
                                        <td>
                                            <?php 
                                            $statusClass = [
                                                'completed' => 'success',
                                                'pending' => 'warning',
                                                'failed' => 'danger'
                                            ];
                                            $statusLabel = [
                                                'completed' => 'Completado',
                                                'pending' => 'Pendiente',
                                                'failed' => 'Fallido'
                                            ];
                                            $status = $payment['status'] ?? 'pending';
                                            ?>
                                            <span class="badge bg-<?php echo $statusClass[$status] ?? 'secondary'; ?>">
                                                <?php echo $statusLabel[$status] ?? $status; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $payment['paid_at'] ? date('d/m/Y H:i', strtotime($payment['paid_at'])) : 'N/A'; ?></td>
                                        <td><small><?php echo htmlspecialchars($payment['transaction_id'] ?? 'N/A'); ?></small></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <a href="<?php echo BASE_URL; ?>/admin/reportes" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver a Reportes
        </a>
    </div>
</div>
