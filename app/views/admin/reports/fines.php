<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-exclamation-triangle"></i> Reporte de Multas y Sanciones</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/reportes">Reportes</a></li>
                <li class="breadcrumb-item active">Multas y Sanciones</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="bi bi-filter"></i> Filtros de Búsqueda</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo BASE_URL; ?>/admin/reportes/multas">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="folio" class="form-label">Folio</label>
                            <input type="text" class="form-control" id="folio" name="folio" 
                                   placeholder="Buscar por folio">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="fine_type" class="form-label">Tipo de Multa</label>
                            <select class="form-select" id="fine_type" name="fine_type">
                                <option value="">Todas</option>
                                <option value="traffic">Multas de Tránsito</option>
                                <option value="civic">Multas Cívicas</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Todos</option>
                                <option value="pending">Pendiente</option>
                                <option value="paid">Pagada</option>
                                <option value="appealed">Impugnada</option>
                                <option value="cancelled">Cancelada</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="date_from" class="form-label">Fecha Desde</label>
                            <input type="date" class="form-control" id="date_from" name="date_from">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="date_to" class="form-label">Fecha Hasta</label>
                            <input type="date" class="form-control" id="date_to" name="date_to">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="infraction_type" class="form-label">Tipo de Infracción</label>
                            <input type="text" class="form-control" id="infraction_type" name="infraction_type" 
                                   placeholder="Ej: Exceso de velocidad">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="min_amount" class="form-label">Monto Mínimo</label>
                            <input type="number" class="form-control" id="min_amount" name="min_amount" 
                                   placeholder="0.00" step="0.01">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="max_amount" class="form-label">Monto Máximo</label>
                            <input type="number" class="form-control" id="max_amount" name="max_amount" 
                                   placeholder="0.00" step="0.01">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                        <div>
                            <button type="button" class="btn btn-success" onclick="exportReport('excel')">
                                <i class="bi bi-file-earmark-excel"></i> Exportar Excel
                            </button>
                            <button type="button" class="btn btn-danger" onclick="exportReport('pdf')">
                                <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
                            </button>
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
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Estadísticas Generales</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-primary"><?php echo isset($stats['total_fines']) ? number_format($stats['total_fines']) : '0'; ?></h3>
                            <p class="text-muted mb-0">Total de Multas</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-warning"><?php echo isset($stats['pending_fines']) ? number_format($stats['pending_fines']) : '0'; ?></h3>
                            <p class="text-muted mb-0">Multas Pendientes</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-success"><?php echo isset($stats['paid_fines']) ? number_format($stats['paid_fines']) : '0'; ?></h3>
                            <p class="text-muted mb-0">Multas Pagadas</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-info">$<?php echo isset($stats['total_amount']) ? number_format($stats['total_amount'], 2) : '0.00'; ?></h3>
                            <p class="text-muted mb-0">Monto Total</p>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="text-center">
                            <h4 class="text-danger"><?php echo isset($stats['traffic_fines']) ? number_format($stats['traffic_fines']) : '0'; ?></h4>
                            <p class="text-muted mb-0">Multas de Tránsito</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <h4 class="text-warning"><?php echo isset($stats['civic_fines']) ? number_format($stats['civic_fines']) : '0'; ?></h4>
                            <p class="text-muted mb-0">Multas Cívicas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-table"></i> Listado de Multas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Tipo</th>
                                <th>Fecha Infracción</th>
                                <th>Infracción</th>
                                <th>Infractor</th>
                                <th>Monto Base</th>
                                <th>Monto Total</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($fines)): ?>
                                <?php foreach ($fines as $fine): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($fine['folio']); ?></td>
                                        <td>
                                            <?php if ($fine['fine_type'] === 'traffic'): ?>
                                                <span class="badge bg-danger">Tránsito</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Cívica</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($fine['infraction_date'])); ?></td>
                                        <td><?php echo htmlspecialchars($fine['infraction_type']); ?></td>
                                        <td><?php echo htmlspecialchars($fine['infractor_name'] ?? 'N/A'); ?></td>
                                        <td>$<?php echo number_format($fine['base_amount'], 2); ?></td>
                                        <td>$<?php echo number_format($fine['total_amount'], 2); ?></td>
                                        <td>
                                            <?php
                                            $statusText = '';
                                            $statusClass = '';
                                            switch($fine['status']) {
                                                case 'pending':
                                                    $statusText = 'Pendiente';
                                                    $statusClass = 'warning';
                                                    break;
                                                case 'paid':
                                                    $statusText = 'Pagada';
                                                    $statusClass = 'success';
                                                    break;
                                                case 'appealed':
                                                    $statusText = 'Impugnada';
                                                    $statusClass = 'info';
                                                    break;
                                                case 'cancelled':
                                                    $statusText = 'Cancelada';
                                                    $statusClass = 'secondary';
                                                    break;
                                                default:
                                                    $statusText = ucfirst($fine['status']);
                                                    $statusClass = 'primary';
                                            }
                                            ?>
                                            <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                        </td>
                                        <td>
                                            <?php 
                                            $detailUrl = $fine['fine_type'] === 'traffic' 
                                                ? '/multas-transito/detalle/' 
                                                : '/multas-civicas/detalle/';
                                            ?>
                                            <a href="<?php echo BASE_URL . $detailUrl . $fine['id']; ?>" 
                                               class="btn btn-sm btn-info" title="Ver Detalles">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <?php if ($fine['status'] === 'pending'): ?>
                                            <a href="<?php echo BASE_URL; ?>/admin/multas/procesar/<?php echo $fine['id']; ?>?type=<?php echo $fine['fine_type']; ?>" 
                                               class="btn btn-sm btn-success" title="Procesar">
                                                <i class="bi bi-check-circle"></i>
                                            </a>
                                            <?php endif; ?>
                                            <a href="<?php echo BASE_URL; ?>/admin/multas/editar/<?php echo $fine['id']; ?>?type=<?php echo $fine['fine_type']; ?>" 
                                               class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <?php if ($fine['status'] === 'pending'): ?>
                                            <a href="<?php echo BASE_URL; ?>/admin/multas/suspender/<?php echo $fine['id']; ?>?type=<?php echo $fine['fine_type']; ?>" 
                                               class="btn btn-sm btn-danger" title="Suspender"
                                               onclick="return confirm('¿Está seguro de suspender esta multa?');">
                                                <i class="bi bi-x-circle"></i>
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">No se encontraron multas con los filtros aplicados</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function exportReport(format) {
    const form = document.querySelector('form');
    const params = new URLSearchParams(new FormData(form));
    window.location.href = '<?php echo BASE_URL; ?>/admin/reportes/multas/exportar?format=' + format + '&' + params.toString();
}
</script>
