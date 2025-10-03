<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-arrow-repeat"></i> Renovar Licencia de Funcionamiento</h1>
        <p class="lead">Renueva tu licencia de funcionamiento</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-building"></i> Información del Negocio</h5>
            </div>
            <div class="card-body">
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
                        <strong>Estado Actual:</strong>
                        <p>
                            <?php
                            $statusClass = '';
                            $statusText = '';
                            switch($license['status']) {
                                case 'approved':
                                    $statusClass = 'success';
                                    $statusText = 'Aprobada';
                                    break;
                                case 'expired':
                                    $statusClass = 'secondary';
                                    $statusText = 'Expirada';
                                    break;
                                default:
                                    $statusClass = 'secondary';
                                    $statusText = ucfirst($license['status']);
                            }
                            ?>
                            <span class="badge bg-<?php echo $statusClass; ?>">
                                <?php echo $statusText; ?>
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-12">
                        <strong>Dirección:</strong>
                        <p><?php echo htmlspecialchars($license['address']); ?></p>
                    </div>
                </div>
                
                <?php if (isset($license['expiry_date']) && $license['expiry_date']): ?>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <i class="bi bi-calendar-x"></i> 
                            <strong>Fecha de Expiración Actual:</strong> 
                            <?php echo date('d/m/Y', strtotime($license['expiry_date'])); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <hr>
                
                <form method="POST" action="<?php echo BASE_URL; ?>/licencias/procesar-renovacion/<?php echo $license['id']; ?>">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> <strong>Información sobre la renovación:</strong>
                        <ul class="mb-0 mt-2">
                            <li>La renovación tendrá una vigencia de 1 año desde la fecha de aprobación</li>
                            <li>El costo de renovación es de $1,500.00 MXN</li>
                            <li>Tiempo de procesamiento: 10 días hábiles aproximadamente</li>
                            <li>Recibirás un correo con las instrucciones de pago una vez procesada tu solicitud</li>
                        </ul>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="confirm_data" required>
                        <label class="form-check-label" for="confirm_data">
                            Confirmo que los datos del negocio son correctos y están actualizados
                        </label>
                    </div>
                    
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="accept_terms" required>
                        <label class="form-check-label" for="accept_terms">
                            Acepto los términos y condiciones para la renovación de licencia
                        </label>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle"></i> Solicitar Renovación
                        </button>
                        <a href="<?php echo BASE_URL; ?>/licencias/detalle/<?php echo $license['id']; ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8 mx-auto">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="bi bi-file-earmark-text"></i> Documentos Requeridos para Renovación</h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Licencia de funcionamiento anterior (copia)</li>
                    <li>Comprobante de domicilio actualizado (no mayor a 3 meses)</li>
                    <li>Comprobante de pago de impuesto predial del año en curso</li>
                    <li>Constancia de no adeudo de servicios municipales</li>
                </ul>
                <p class="mt-2 mb-0"><small class="text-muted">Estos documentos deberán presentarse después de que tu solicitud sea procesada.</small></p>
            </div>
        </div>
    </div>
</div>
