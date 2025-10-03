<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-calendar"></i> Sistema de Citas</h1>
        <p class="lead">Agenda tu cita para trámites presenciales</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center p-4">
                <i class="bi bi-calendar-plus fs-1 text-primary mb-3"></i>
                <h3 class="card-title">Agendar Nueva Cita</h3>
                <p class="card-text">Programa tu visita para realizar trámites presenciales en las oficinas municipales.</p>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo BASE_URL; ?>/citas/agendar" class="btn btn-primary btn-lg">
                        <i class="bi bi-calendar-plus"></i> Agendar Cita
                    </a>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión para Agendar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center p-4">
                <i class="bi bi-calendar-check fs-1 text-success mb-3"></i>
                <h3 class="card-title">Mis Citas</h3>
                <p class="card-text">Consulta el estado de tus citas agendadas, próximas y completadas.</p>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo BASE_URL; ?>/citas/mis-citas" class="btn btn-success btn-lg">
                        <i class="bi bi-list-check"></i> Ver Mis Citas
                    </a>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/login" class="btn btn-success btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información sobre las Citas</h5>
            </div>
            <div class="card-body">
                <h6><strong>Trámites disponibles para citas:</strong></h6>
                <ul>
                    <li>Impuesto Predial</li>
                    <li>Licencia de Funcionamiento - Nuevo</li>
                    <li>Licencia de Funcionamiento - Renovación</li>
                    <li>Multas de Tránsito</li>
                    <li>Multas Cívicas</li>
                    <li>Otros trámites</li>
                </ul>
                
                <h6 class="mt-3"><strong>Horarios de atención:</strong></h6>
                <p>Lunes a Viernes de 8:00 AM a 4:00 PM</p>
                
                <h6 class="mt-3"><strong>Recomendaciones:</strong></h6>
                <ul>
                    <li>Agenda tu cita con al menos un día de anticipación</li>
                    <li>Llega 10 minutos antes de tu hora programada</li>
                    <li>Trae contigo los documentos necesarios para tu trámite</li>
                    <li>Si no puedes asistir, cancela tu cita con anticipación</li>
                </ul>
            </div>
        </div>
    </div>
</div>
