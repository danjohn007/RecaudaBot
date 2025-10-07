<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-file-earmark-text"></i> Reporte de Licencias de Funcionamiento</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/reportes">Reportes</a></li>
                <li class="breadcrumb-item active">Licencias</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-filter"></i> Filtros de Búsqueda</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo BASE_URL; ?>/admin/reportes/licencias">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="business_name" class="form-label">Nombre del Negocio</label>
                            <input type="text" class="form-control" id="business_name" name="business_name" 
                                   placeholder="Buscar por nombre">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="owner_name" class="form-label">Propietario</label>
                            <input type="text" class="form-control" id="owner_name" name="owner_name" 
                                   placeholder="Nombre del propietario">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Todos</option>
                                <option value="pending">Pendiente</option>
                                <option value="approved">Aprobada</option>
                                <option value="rejected">Rechazada</option>
                                <option value="expired">Expirada</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="year" class="form-label">Año</label>
                            <select class="form-select" id="year" name="year">
                                <option value="">Todos</option>
                                <?php 
                                $currentYear = date('Y');
                                for ($i = $currentYear; $i >= $currentYear - 5; $i--): 
                                ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
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
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Estadísticas Generales</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-primary"><?php echo isset($stats['total_licenses']) ? number_format($stats['total_licenses']) : '0'; ?></h3>
                            <p class="text-muted mb-0">Total de Licencias</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-success"><?php echo isset($stats['approved_licenses']) ? number_format($stats['approved_licenses']) : '0'; ?></h3>
                            <p class="text-muted mb-0">Licencias Aprobadas</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-warning"><?php echo isset($stats['pending_licenses']) ? number_format($stats['pending_licenses']) : '0'; ?></h3>
                            <p class="text-muted mb-0">Licencias Pendientes</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-danger"><?php echo isset($stats['expired_licenses']) ? number_format($stats['expired_licenses']) : '0'; ?></h3>
                            <p class="text-muted mb-0">Licencias Expiradas</p>
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
                <h5 class="mb-0"><i class="bi bi-table"></i> Listado de Licencias</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Negocio</th>
                                <th>Propietario</th>
                                <th>Dirección</th>
                                <th>Giro</th>
                                <th>Fecha Solicitud</th>
                                <th>Fecha Vencimiento</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($licenses)): ?>
                                <?php foreach ($licenses as $license): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($license['id']); ?></td>
                                        <td><?php echo htmlspecialchars($license['business_name']); ?></td>
                                        <td><?php echo htmlspecialchars($license['owner_name']); ?></td>
                                        <td><?php echo htmlspecialchars($license['business_address']); ?></td>
                                        <td><?php echo htmlspecialchars($license['business_activity']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($license['application_date'])); ?></td>
                                        <td>
                                            <?php 
                                            if ($license['expiry_date']) {
                                                echo date('d/m/Y', strtotime($license['expiry_date']));
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $statusText = '';
                                            $statusClass = '';
                                            switch($license['status']) {
                                                case 'pending':
                                                    $statusText = 'Pendiente';
                                                    $statusClass = 'warning';
                                                    break;
                                                case 'approved':
                                                    $statusText = 'Aprobada';
                                                    $statusClass = 'success';
                                                    break;
                                                case 'rejected':
                                                    $statusText = 'Rechazada';
                                                    $statusClass = 'danger';
                                                    break;
                                                case 'expired':
                                                    $statusText = 'Expirada';
                                                    $statusClass = 'secondary';
                                                    break;
                                                default:
                                                    $statusText = ucfirst($license['status']);
                                                    $statusClass = 'info';
                                            }
                                            ?>
                                            <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                        </td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/admin/licencias/ver/<?php echo $license['id']; ?>" 
                                               class="btn btn-sm btn-info" title="Ver Detalles">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/admin/licencias/documentos/<?php echo $license['id']; ?>" 
                                               class="btn btn-sm btn-secondary" title="Ver Documentos">
                                                <i class="bi bi-file-earmark"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">No se encontraron licencias con los filtros aplicados</td>
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
    window.location.href = '<?php echo BASE_URL; ?>/admin/reportes/licencias/exportar?format=' + format + '&' + params.toString();
}
</script>
