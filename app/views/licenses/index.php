<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-briefcase"></i> Licencias de Funcionamiento</h1>
        <p class="lead">Solicita o renueva tu licencia de funcionamiento de manera fácil y rápida</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3>¿Qué es una Licencia de Funcionamiento?</h3>
                <p>Es el permiso que otorga el municipio para que un establecimiento comercial, industrial o de servicios pueda operar legalmente.</p>
                
                <h4 class="mt-4">Requisitos:</h4>
                <ul>
                    <li>Identificación oficial vigente</li>
                    <li>Comprobante de domicilio del negocio</li>
                    <li>RFC</li>
                    <li>Planos del local</li>
                    <li>Constancia de uso de suelo</li>
                    <li>Pago de derechos</li>
                </ul>
                
                <h4 class="mt-4">Proceso:</h4>
                <ol>
                    <li>Completa la solicitud en línea</li>
                    <li>Sube los documentos requeridos</li>
                    <li>Realiza el pago correspondiente</li>
                    <li>Espera la revisión (15 días hábiles aprox.)</li>
                    <li>Recibe tu licencia aprobada</li>
                </ol>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow bg-success text-white mb-3">
            <div class="card-body text-center p-4">
                <i class="bi bi-file-earmark-plus fs-1 mb-3"></i>
                <h4>Nueva Licencia</h4>
                <p>Solicita tu primera licencia</p>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?php echo BASE_URL; ?>/licencias/nueva" class="btn btn-light btn-lg w-100">
                    <i class="bi bi-plus-circle"></i> Solicitar
                </a>
                <?php else: ?>
                <a href="<?php echo BASE_URL; ?>/login" class="btn btn-light btn-lg w-100">
                    Iniciar Sesión
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card shadow bg-primary text-white">
            <div class="card-body text-center p-4">
                <i class="bi bi-arrow-repeat fs-1 mb-3"></i>
                <h4>Renovar Licencia</h4>
                <p>Renueva tu licencia existente</p>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?php echo BASE_URL; ?>/licencias/mis-licencias" class="btn btn-light btn-lg w-100">
                    <i class="bi bi-list"></i> Mis Licencias
                </a>
                <?php else: ?>
                <a href="<?php echo BASE_URL; ?>/login" class="btn btn-light btn-lg w-100">
                    Iniciar Sesión
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
