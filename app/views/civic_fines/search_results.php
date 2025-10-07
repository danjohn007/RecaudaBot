<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-search"></i> Resultados de Búsqueda</h1>
        <p class="lead">Resultados para: <strong><?php echo htmlspecialchars($searchTerm); ?></strong></p>
        <a href="<?php echo BASE_URL; ?>/multas-civicas/consultar" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Nueva Búsqueda
        </a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <?php if (empty($fines)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No se encontraron multas cívicas con el término de búsqueda proporcionado.
            </div>
        <?php else: ?>
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-list-ul"></i> Multas Cívicas Encontradas (<?php echo count($fines); ?>)</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Folio</th>
                                    <th>Infractor</th>
                                    <th>Tipo de Infracción</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($fines as $fine): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($fine['folio']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($fine['citizen_name']); ?></td>
                                    <td><?php echo htmlspecialchars($fine['infraction_type']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($fine['infraction_date'])); ?></td>
                                    <td class="fw-bold">$<?php echo number_format($fine['total_amount'], 2); ?></td>
                                    <td>
                                        <?php
                                        $statusClass = '';
                                        $statusText = '';
                                        switch($fine['status']) {
                                            case 'pending':
                                                $statusClass = 'warning';
                                                $statusText = 'Pendiente';
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
                                        <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                    </td>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>/multas-civicas/detalle/<?php echo $fine['id']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                        <?php if ($fine['status'] === 'pending'): ?>
                                        <a href="<?php echo BASE_URL; ?>/multas-civicas/pagar/<?php echo $fine['id']; ?>" 
                                           class="btn btn-sm btn-success">
                                            <i class="bi bi-credit-card"></i> Pagar
                                        </a>
                                        <?php endif; ?>
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
