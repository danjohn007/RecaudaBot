<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-search"></i> Resultados de Búsqueda</h1>
        <p class="lead">Se encontraron múltiples predios</p>
        <a href="<?php echo BASE_URL; ?>/impuesto-predial/consultar" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Nueva Búsqueda
        </a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <?php if (empty($properties)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No se encontraron predios con el término de búsqueda proporcionado.
            </div>
        <?php else: ?>
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-list-ul"></i> Predios Encontrados (<?php echo count($properties); ?>)</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Clave Catastral</th>
                                    <th>Propietario</th>
                                    <th>Dirección</th>
                                    <th>Zona</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($properties as $property): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($property['cadastral_key']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($property['owner_name']); ?></td>
                                    <td><?php echo htmlspecialchars($property['address']); ?></td>
                                    <td>
                                        <?php
                                        $zoneType = '';
                                        switch($property['zone_type']) {
                                            case 'residential':
                                                $zoneType = 'Residencial';
                                                break;
                                            case 'commercial':
                                                $zoneType = 'Comercial';
                                                break;
                                            case 'industrial':
                                                $zoneType = 'Industrial';
                                                break;
                                            case 'rural':
                                                $zoneType = 'Rural';
                                                break;
                                            default:
                                                $zoneType = ucfirst($property['zone_type']);
                                        }
                                        ?>
                                        <?php echo $zoneType; ?>
                                    </td>
                                    <td>
                                        <?php if ($property['status'] === 'active'): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form method="POST" action="<?php echo BASE_URL; ?>/impuesto-predial/buscar" style="display: inline;">
                                            <input type="hidden" name="search" value="<?php echo htmlspecialchars($property['cadastral_key']); ?>">
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i> Ver Detalle
                                            </button>
                                        </form>
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
