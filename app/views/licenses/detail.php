<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-file-earmark-text"></i> Detalle de Licencia</h1>
        <p class="lead">Información completa de tu licencia de funcionamiento</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-building"></i> Información del Negocio</h5>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nombre del Negocio:</strong>
                        <p><?php echo htmlspecialchars($license['business_name']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tipo de Negocio:</strong>
                        <p><?php echo htmlspecialchars($license['business_type']); ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>RFC:</strong>
                        <p><?php echo htmlspecialchars($license['rfc']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Teléfono:</strong>
                        <p><?php echo htmlspecialchars($license['phone']); ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-12">
                        <strong>Dirección:</strong>
                        <p><?php echo htmlspecialchars($license['address']); ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-12">
                        <strong>Correo Electrónico:</strong>
                        <p><?php echo htmlspecialchars($license['email']); ?></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <strong>Fecha de Solicitud:</strong>
                        <p><?php echo isset($license['created_at']) ? date('d/m/Y', strtotime($license['created_at'])) : '-'; ?></p>
                    </div>
                    <div class="col-md-4">
                        <strong>Fecha de Emisión:</strong>
                        <p><?php echo isset($license['issue_date']) && $license['issue_date'] ? date('d/m/Y', strtotime($license['issue_date'])) : 'Pendiente'; ?></p>
                    </div>
                    <div class="col-md-4">
                        <strong>Fecha de Expiración:</strong>
                        <p><?php echo isset($license['expiry_date']) && $license['expiry_date'] ? date('d/m/Y', strtotime($license['expiry_date'])) : 'Pendiente'; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Estado</h5>
            </div>
            <div class="card-body text-center">
                <?php
                $statusClass = '';
                $statusText = '';
                $statusIcon = '';
                switch($license['status']) {
                    case 'pending':
                        $statusClass = 'warning';
                        $statusText = 'Pendiente de Revisión';
                        $statusIcon = 'clock-history';
                        break;
                    case 'approved':
                        $statusClass = 'success';
                        $statusText = 'Aprobada';
                        $statusIcon = 'check-circle';
                        break;
                    case 'rejected':
                        $statusClass = 'danger';
                        $statusText = 'Rechazada';
                        $statusIcon = 'x-circle';
                        break;
                    case 'expired':
                        $statusClass = 'secondary';
                        $statusText = 'Expirada';
                        $statusIcon = 'exclamation-triangle';
                        break;
                    default:
                        $statusClass = 'secondary';
                        $statusText = ucfirst($license['status']);
                        $statusIcon = 'file-earmark';
                }
                ?>
                <i class="bi bi-<?php echo $statusIcon; ?> fs-1 text-<?php echo $statusClass; ?> mb-3"></i>
                <h4 class="text-<?php echo $statusClass; ?>"><?php echo $statusText; ?></h4>
                
                <div class="mt-4 d-grid gap-2">
                    <?php if ($license['status'] === 'approved' || $license['status'] === 'expired'): ?>
                        <a href="<?php echo BASE_URL; ?>/licencias/renovar/<?php echo $license['id']; ?>" class="btn btn-success">
                            <i class="bi bi-arrow-repeat"></i> Renovar Licencia
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?php echo BASE_URL; ?>/licencias/mis-licencias" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Volver a Mis Licencias
                    </a>
                </div>
            </div>
        </div>
        
        <?php if ($license['status'] === 'pending'): ?>
        <div class="card border-info">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Información</h6>
                <p class="card-text small mb-0">
                    Tu solicitud está en proceso de revisión. Te notificaremos por correo electrónico cuando haya una actualización.
                </p>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($license['status'] === 'rejected'): ?>
        <div class="card border-danger">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-exclamation-triangle"></i> Motivo del Rechazo</h6>
                <p class="card-text small mb-0">
                    <?php echo isset($license['rejection_reason']) ? htmlspecialchars($license['rejection_reason']) : 'Contacta con la oficina para más información.'; ?>
                </p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
