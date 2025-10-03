<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-list-ul"></i> Resultados de Búsqueda</h1>
        <p class="text-muted">Búsqueda: "<?php echo htmlspecialchars($searchTerm); ?>"</p>
        <a href="<?php echo BASE_URL; ?>/multas-transito/consultar" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Nueva Búsqueda
        </a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <?php if (empty($fines)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No se encontraron multas con los criterios de búsqueda.
            </div>
        <?php else: ?>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Fecha</th>
                                    <th>Placas</th>
                                    <th>Infracción</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($fines as $fine): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($fine['folio']); ?></strong></td>
                                    <td><?php echo date('d/m/Y', strtotime($fine['infraction_date'])); ?></td>
                                    <td><?php echo htmlspecialchars($fine['license_plate']); ?></td>
                                    <td><?php echo htmlspecialchars($fine['infraction_type']); ?></td>
                                    <td><strong>$<?php echo number_format($fine['total_amount'], 2); ?></strong></td>
                                    <td>
                                        <?php
                                        $badges = [
                                            'paid' => 'success',
                                            'pending' => 'warning',
                                            'appealed' => 'info',
                                            'cancelled' => 'secondary',
                                            'overdue' => 'danger'
                                        ];
                                        $badge = $badges[$fine['status']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo $badge; ?>">
                                            <?php echo ucfirst($fine['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>/multas-transito/detalle/<?php echo $fine['id']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> Ver Detalle
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
