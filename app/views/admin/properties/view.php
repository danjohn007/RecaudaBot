<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-house"></i> Detalle del Predio</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/reportes">Reportes</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/reportes/predios">Predios</a></li>
                <li class="breadcrumb-item active">Detalle</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información del Predio</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Clave Catastral:</strong>
                        <p><?php echo htmlspecialchars($property['cadastral_key'] ?? 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Propietario:</strong>
                        <p><?php echo htmlspecialchars($property['owner_name'] ?? 'N/A'); ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-12">
                        <strong>Dirección:</strong>
                        <p><?php echo htmlspecialchars($property['address'] ?? 'N/A'); ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Tipo de Zona:</strong>
                        <p>
                            <?php
                            $zoneTypes = [
                                'residential' => 'Residencial',
                                'commercial' => 'Comercial',
                                'industrial' => 'Industrial',
                                'rural' => 'Rural'
                            ];
                            echo $zoneTypes[$property['zone_type'] ?? ''] ?? 'N/A';
                            ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Estado:</strong>
                        <p>
                            <?php
                            $status = $property['status'] ?? 'active';
                            $statusText = $status === 'suspended' ? 'Suspendido' : 'Activo';
                            $statusClass = $status === 'suspended' ? 'danger' : 'success';
                            ?>
                            <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                        </p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Área de Terreno:</strong>
                        <p><?php echo number_format($property['area_m2'] ?? 0, 2); ?> m²</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Área de Construcción:</strong>
                        <p><?php echo number_format($property['construction_m2'] ?? 0, 2); ?> m²</p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Valor Catastral:</strong>
                        <p class="text-success h5">$<?php echo number_format($property['cadastral_value'] ?? 0, 2); ?></p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?php echo BASE_URL; ?>/admin/reportes/predios" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-tools"></i> Acciones</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo BASE_URL; ?>/admin/predios/editar/<?php echo $property['id']; ?>" 
                       class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Editar Predio
                    </a>
                    <?php if (($property['status'] ?? '') !== 'suspended'): ?>
                    <a href="<?php echo BASE_URL; ?>/admin/predios/suspender/<?php echo $property['id']; ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('¿Está seguro de suspender este predio?');">
                        <i class="bi bi-x-circle"></i> Suspender
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
