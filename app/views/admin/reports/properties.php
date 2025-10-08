<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-house"></i> Reporte de Predios</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/reportes">Reportes</a></li>
                <li class="breadcrumb-item active">Predios</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-filter"></i> Filtros de Búsqueda</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo BASE_URL; ?>/admin/reportes/predios">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="cadastral_key" class="form-label">Clave Catastral</label>
                            <input type="text" class="form-control" id="cadastral_key" name="cadastral_key" 
                                   placeholder="Buscar por clave">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="owner_name" class="form-label">Propietario</label>
                            <input type="text" class="form-control" id="owner_name" name="owner_name" 
                                   placeholder="Nombre del propietario">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="property_type" class="form-label">Tipo de Predio</label>
                            <select class="form-select" id="property_type" name="property_type">
                                <option value="">Todos</option>
                                <option value="residential">Residencial</option>
                                <option value="commercial">Comercial</option>
                                <option value="industrial">Industrial</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="min_value" class="form-label">Valor Catastral Mínimo</label>
                            <input type="number" class="form-control" id="min_value" name="min_value" 
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
                            <h3 class="text-primary"><?php echo isset($stats['total_properties']) ? number_format($stats['total_properties']) : '0'; ?></h3>
                            <p class="text-muted mb-0">Total de Predios</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-success">$<?php echo isset($stats['total_assessed_value']) ? number_format($stats['total_assessed_value'], 2) : '0.00'; ?></h3>
                            <p class="text-muted mb-0">Valor Catastral Total</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-info"><?php echo isset($stats['avg_land_area']) ? number_format($stats['avg_land_area'], 2) : '0.00'; ?> m²</h3>
                            <p class="text-muted mb-0">Área Promedio de Terreno</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-warning"><?php echo isset($stats['avg_construction_area']) ? number_format($stats['avg_construction_area'], 2) : '0.00'; ?> m²</h3>
                            <p class="text-muted mb-0">Área Promedio de Construcción</p>
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
                <h5 class="mb-0"><i class="bi bi-table"></i> Listado de Predios</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Clave Catastral</th>
                                <th>Propietario</th>
                                <th>Dirección</th>
                                <th>Tipo</th>
                                <th>Área Terreno (m²)</th>
                                <th>Área Construcción (m²)</th>
                                <th>Valor Catastral</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($properties)): ?>
                                <?php foreach ($properties as $property): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($property['cadastral_key']); ?></td>
                                        <td><?php echo htmlspecialchars($property['owner_name']); ?></td>
                                        <td><?php echo htmlspecialchars($property['address']); ?></td>
                                        <td>
                                            <?php
                                            $typeText = '';
                                            $typeClass = '';
                                            switch($property['zone_type'] ?? '') {
                                                case 'residential':
                                                    $typeText = 'Residencial';
                                                    $typeClass = 'primary';
                                                    break;
                                                case 'commercial':
                                                    $typeText = 'Comercial';
                                                    $typeClass = 'success';
                                                    break;
                                                case 'industrial':
                                                    $typeText = 'Industrial';
                                                    $typeClass = 'warning';
                                                    break;
                                                case 'rural':
                                                    $typeText = 'Rural';
                                                    $typeClass = 'info';
                                                    break;
                                                default:
                                                    $typeText = 'N/A';
                                                    $typeClass = 'secondary';
                                            }
                                            ?>
                                            <span class="badge bg-<?php echo $typeClass; ?>"><?php echo $typeText; ?></span>
                                        </td>
                                        <td><?php echo number_format($property['area_m2'] ?? 0, 2); ?></td>
                                        <td><?php echo number_format($property['construction_m2'] ?? 0, 2); ?></td>
                                        <td>$<?php echo number_format($property['cadastral_value'] ?? 0, 2); ?></td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/admin/predios/ver/<?php echo $property['id']; ?>" 
                                               class="btn btn-sm btn-info" title="Ver Detalles">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/admin/predios/procesar/<?php echo $property['id']; ?>" 
                                               class="btn btn-sm btn-success" title="Procesar">
                                                <i class="bi bi-check-circle"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/admin/predios/editar/<?php echo $property['id']; ?>" 
                                               class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <?php if (($property['status'] ?? '') !== 'suspended'): ?>
                                            <a href="<?php echo BASE_URL; ?>/admin/predios/suspender/<?php echo $property['id']; ?>" 
                                               class="btn btn-sm btn-danger" title="Suspender"
                                               onclick="return confirm('¿Está seguro de suspender este predio?');">
                                                <i class="bi bi-x-circle"></i>
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No se encontraron predios con los filtros aplicados</td>
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
    window.location.href = '<?php echo BASE_URL; ?>/admin/reportes/predios/exportar?format=' + format + '&' + params.toString();
}
</script>
