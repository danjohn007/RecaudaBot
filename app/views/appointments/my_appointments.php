<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-calendar-check"></i> Mis Citas</h1>
        <p class="lead">Consulta y administra tus citas agendadas</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="mb-3">
            <a href="<?php echo BASE_URL; ?>/citas/agendar" class="btn btn-primary">
                <i class="bi bi-calendar-plus"></i> Agendar Nueva Cita
            </a>
        </div>
        
        <?php if (empty($appointments)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No tienes citas agendadas. 
                <a href="<?php echo BASE_URL; ?>/citas/agendar">Agenda tu primera cita aquí</a>.
            </div>
        <?php else: ?>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Tipo de Trámite</th>
                                    <th>Estado</th>
                                    <th>Notas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td>
                                        <i class="bi bi-calendar3"></i> 
                                        <?php echo date('d/m/Y', strtotime($appointment['appointment_date'])); ?>
                                    </td>
                                    <td>
                                        <i class="bi bi-clock"></i>
                                        <?php 
                                        $time = date('H:i', strtotime($appointment['appointment_time']));
                                        echo $time;
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($appointment['service_type']); ?></td>
                                    <td>
                                        <?php
                                        $statusClass = '';
                                        $statusText = '';
                                        switch($appointment['status']) {
                                            case 'scheduled':
                                                $statusClass = 'bg-primary';
                                                $statusText = 'Agendada';
                                                break;
                                            case 'completed':
                                                $statusClass = 'bg-success';
                                                $statusText = 'Completada';
                                                break;
                                            case 'cancelled':
                                                $statusClass = 'bg-danger';
                                                $statusText = 'Cancelada';
                                                break;
                                            default:
                                                $statusClass = 'bg-secondary';
                                                $statusText = ucfirst($appointment['status']);
                                        }
                                        ?>
                                        <span class="badge <?php echo $statusClass; ?>">
                                            <?php echo $statusText; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (!empty($appointment['notes'])): ?>
                                            <small><?php echo htmlspecialchars(substr($appointment['notes'], 0, 50)); ?></small>
                                            <?php if (strlen($appointment['notes']) > 50): ?>
                                                <span data-bs-toggle="tooltip" title="<?php echo htmlspecialchars($appointment['notes']); ?>">...</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <small class="text-muted">Sin notas</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($appointment['status'] === 'scheduled'): ?>
                                            <a href="<?php echo BASE_URL; ?>/citas/cancelar/<?php echo $appointment['id']; ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('¿Estás seguro de que deseas cancelar esta cita?');">
                                                <i class="bi bi-x-circle"></i> Cancelar
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
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
                    <li>Llega 10 minutos antes de tu hora programada</li>
                    <li>Si no puedes asistir, cancela tu cita con anticipación</li>
                    <li>Trae contigo los documentos necesarios para tu trámite</li>
                    <li>Las citas canceladas no se pueden reactivar, debes agendar una nueva</li>
                </ul>
            </div>
        </div>
    </div>
</div>
