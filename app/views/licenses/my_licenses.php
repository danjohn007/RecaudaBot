<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-briefcase"></i> Mis Licencias</h1>
        <p class="lead">Consulta y administra tus licencias de funcionamiento</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="mb-3">
            <a href="<?php echo BASE_URL; ?>/licencias/nueva" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Solicitar Nueva Licencia
            </a>
        </div>
        
        <?php if (empty($licenses)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No tienes licencias registradas. 
                <a href="<?php echo BASE_URL; ?>/licencias/nueva">Solicita tu primera licencia aquí</a>.
            </div>
        <?php else: ?>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre del Negocio</th>
                                    <th>Tipo de Negocio</th>
                                    <th>RFC</th>
                                    <th>Fecha de Solicitud</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($licenses as $license): ?>
                                <tr>
                                    <td>
                                        <i class="bi bi-building"></i> 
                                        <?php echo htmlspecialchars($license['business_name']); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($license['business_type']); ?></td>
                                    <td><?php echo htmlspecialchars($license['rfc']); ?></td>
                                    <td>
                                        <i class="bi bi-calendar3"></i> 
                                        <?php echo isset($license['created_at']) ? date('d/m/Y', strtotime($license['created_at'])) : '-'; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $statusClass = '';
                                        $statusText = '';
                                        switch($license['status']) {
                                            case 'pending':
                                                $statusClass = 'bg-warning';
                                                $statusText = 'Pendiente';
                                                break;
                                            case 'approved':
                                                $statusClass = 'bg-success';
                                                $statusText = 'Aprobada';
                                                break;
                                            case 'rejected':
                                                $statusClass = 'bg-danger';
                                                $statusText = 'Rechazada';
                                                break;
                                            case 'expired':
                                                $statusClass = 'bg-secondary';
                                                $statusText = 'Expirada';
                                                break;
                                            default:
                                                $statusClass = 'bg-secondary';
                                                $statusText = ucfirst($license['status']);
                                        }
                                        ?>
                                        <span class="badge <?php echo $statusClass; ?>">
                                            <?php echo $statusText; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>/licencias/detalle/<?php echo $license['id']; ?>" 
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Ver Detalle
                                        </a>
                                        <?php if ($license['status'] === 'approved' || $license['status'] === 'expired'): ?>
                                            <a href="<?php echo BASE_URL; ?>/licencias/renovar/<?php echo $license['id']; ?>" 
                                               class="btn btn-sm btn-success">
                                                <i class="bi bi-arrow-repeat"></i> Renovar
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

<div class="row mt-4">
    <div class="col-12">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Información Importante</h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Las licencias de funcionamiento tienen una vigencia de 1 año</li>
                    <li>Debes renovar tu licencia antes de su fecha de expiración</li>
                    <li>El tiempo de revisión es de aproximadamente 15 días hábiles</li>
                    <li>Si tu solicitud es rechazada, puedes corregir y volver a solicitar</li>
                </ul>
            </div>
        </div>
    </div>
</div>
