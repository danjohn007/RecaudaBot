<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-receipt"></i> Reporte de Obligaciones Fiscales</h1>
        <p class="lead">Consulta impuestos, multas y trámites municipales</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros de Búsqueda</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo BASE_URL; ?>/admin/reportes/obligaciones">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="type" class="form-label">Tipo de Obligación</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">Todos</option>
                                <option value="property_tax" <?php echo $filters['type'] === 'property_tax' ? 'selected' : ''; ?>>Impuesto Predial</option>
                                <option value="traffic_fine" <?php echo $filters['type'] === 'traffic_fine' ? 'selected' : ''; ?>>Multa Tránsito</option>
                                <option value="civic_fine" <?php echo $filters['type'] === 'civic_fine' ? 'selected' : ''; ?>>Multa Cívica</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Todos</option>
                                <option value="pending" <?php echo $filters['status'] === 'pending' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="paid" <?php echo $filters['status'] === 'paid' ? 'selected' : ''; ?>>Pagado</option>
                                <option value="overdue" <?php echo $filters['status'] === 'overdue' ? 'selected' : ''; ?>>Vencido</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date_from" class="form-label">Desde</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="<?php echo htmlspecialchars($filters['date_from']); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
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
                            <a href="<?php echo BASE_URL; ?>/admin/reportes/obligaciones" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Limpiar
                            </a>
                            <a href="<?php echo BASE_URL; ?>/admin/reportes/exportar?type=obligations&format=csv" class="btn btn-success">
                                <i class="bi bi-download"></i> Exportar CSV
                            </a>
                            <a href="<?php echo BASE_URL; ?>/admin/reportes/exportar?type=obligations&format=xml" class="btn btn-info">
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
                <h5 class="mb-0"><i class="bi bi-table"></i> Resultados (<?php echo count($obligations); ?> obligaciones)</h5>
            </div>
            <div class="card-body">
                <?php if (empty($obligations)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No se encontraron obligaciones con los filtros aplicados.
                    </div>
                <?php else: ?>
                    <?php
                    $totalAmount = 0;
                    $totalPending = 0;
                    foreach ($obligations as $obligation) {
                        $totalAmount += $obligation['total_amount'];
                        if ($obligation['status'] === 'pending') {
                            $totalPending += $obligation['total_amount'];
                        }
                    }
                    ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <strong>Total General:</strong> $<?php echo number_format($totalAmount, 2); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-warning">
                                <strong>Total Pendiente:</strong> $<?php echo number_format($totalPending, 2); ?>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>ID</th>
                                    <th>Referencia</th>
                                    <th>Ciudadano</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Fecha Pago</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($obligations as $obligation): ?>
                                    <tr>
                                        <td>
                                            <?php 
                                            $typeLabels = [
                                                'property_tax' => '<span class="badge bg-info">Predial</span>',
                                                'traffic_fine' => '<span class="badge bg-warning">Tránsito</span>',
                                                'civic_fine' => '<span class="badge bg-danger">Cívica</span>'
                                            ];
                                            echo $typeLabels[$obligation['type']] ?? $obligation['type'];
                                            ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($obligation['id']); ?></td>
                                        <td><?php echo htmlspecialchars($obligation['reference']); ?></td>
                                        <td><?php echo htmlspecialchars($obligation['citizen']); ?></td>
                                        <td>$<?php echo number_format($obligation['total_amount'], 2); ?></td>
                                        <td>
                                            <?php 
                                            $statusClass = [
                                                'pending' => 'warning',
                                                'paid' => 'success',
                                                'overdue' => 'danger',
                                                'appealed' => 'info',
                                                'cancelled' => 'secondary'
                                            ];
                                            $statusLabel = [
                                                'pending' => 'Pendiente',
                                                'paid' => 'Pagado',
                                                'overdue' => 'Vencido',
                                                'appealed' => 'Apelado',
                                                'cancelled' => 'Cancelado'
                                            ];
                                            $status = $obligation['status'] ?? 'pending';
                                            ?>
                                            <span class="badge bg-<?php echo $statusClass[$status] ?? 'secondary'; ?>">
                                                <?php echo $statusLabel[$status] ?? $status; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $obligation['due_date'] ? date('d/m/Y', strtotime($obligation['due_date'])) : 'N/A'; ?></td>
                                        <td><?php echo $obligation['paid_date'] ? date('d/m/Y', strtotime($obligation['paid_date'])) : '-'; ?></td>
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
