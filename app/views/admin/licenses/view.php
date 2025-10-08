<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-file-earmark-text"></i> Detalle de la Licencia</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/reportes">Reportes</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/reportes/licencias">Licencias</a></li>
                <li class="breadcrumb-item active">Detalle</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información de la Licencia</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>ID Licencia:</strong>
                        <p><?php echo htmlspecialchars($license['id'] ?? 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Nombre del Negocio:</strong>
                        <p><?php echo htmlspecialchars($license['business_name'] ?? 'N/A'); ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Propietario:</strong>
                        <p><?php echo htmlspecialchars($license['owner_name'] ?? 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Estado:</strong>
                        <p>
                            <?php
                            $statusTexts = [
                                'pending' => 'Pendiente',
                                'approved' => 'Aprobada',
                                'rejected' => 'Rechazada',
                                'expired' => 'Expirada',
                                'suspended' => 'Suspendida'
                            ];
                            $statusClasses = [
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                'expired' => 'secondary',
                                'suspended' => 'dark'
                            ];
                            $status = $license['status'] ?? 'pending';
                            ?>
                            <span class="badge bg-<?php echo $statusClasses[$status] ?? 'secondary'; ?>">
                                <?php echo $statusTexts[$status] ?? ucfirst($status); ?>
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-12">
                        <strong>Dirección del Negocio:</strong>
                        <p><?php echo htmlspecialchars($license['address'] ?? 'N/A'); ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Giro del Negocio:</strong>
                        <p><?php echo htmlspecialchars($license['business_type'] ?? 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Cuota Anual:</strong>
                        <p class="text-success h5">$<?php echo number_format($license['annual_fee'] ?? 0, 2); ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Fecha de Solicitud:</strong>
                        <p>
                            <?php 
                            if (!empty($license['created_at'])) {
                                echo date('d/m/Y H:i', strtotime($license['created_at']));
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Fecha de Vencimiento:</strong>
                        <p>
                            <?php 
                            if (!empty($license['expiry_date'])) {
                                echo date('d/m/Y', strtotime($license['expiry_date']));
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?php echo BASE_URL; ?>/admin/reportes/licencias" class="btn btn-secondary">
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
                    <?php if ($license['status'] === 'pending'): ?>
                    <a href="<?php echo BASE_URL; ?>/admin/licencias/procesar/<?php echo $license['id']; ?>" 
                       class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Procesar Licencia
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo BASE_URL; ?>/admin/licencias/editar/<?php echo $license['id']; ?>" 
                       class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Editar Licencia
                    </a>
                    <?php if ($license['status'] !== 'expired' && $license['status'] !== 'suspended'): ?>
                    <a href="<?php echo BASE_URL; ?>/admin/licencias/suspender/<?php echo $license['id']; ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('¿Está seguro de suspender esta licencia?');">
                        <i class="bi bi-x-circle"></i> Suspender
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
