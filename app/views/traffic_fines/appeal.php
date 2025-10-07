<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-file-earmark-text"></i> Impugnar Multa de Tránsito</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/multas-transito">Multas de Tránsito</a></li>
                <li class="breadcrumb-item active">Impugnar</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Formulario de Impugnación</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="bi bi-info-circle"></i> Información de la Multa</h6>
                    <p class="mb-1"><strong>Folio:</strong> <?php echo htmlspecialchars($fine['folio'] ?? 'N/A'); ?></p>
                    <p class="mb-1"><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($fine['infraction_date'] ?? 'now')); ?></p>
                    <p class="mb-1"><strong>Infracción:</strong> <?php echo htmlspecialchars($fine['infraction_type'] ?? 'N/A'); ?></p>
                    <p class="mb-0"><strong>Monto:</strong> $<?php echo number_format($fine['total_amount'] ?? 0, 2); ?></p>
                </div>

                <form method="POST" action="<?php echo BASE_URL; ?>/multas-transito/impugnar/<?php echo $fine['id']; ?>/enviar">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Motivo de la Impugnación <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reason" name="reason" rows="5" required
                                  placeholder="Explique detalladamente por qué considera que la multa es incorrecta o injusta..."></textarea>
                        <small class="text-muted">Proporcione toda la información relevante que respalde su impugnación.</small>
                    </div>

                    <div class="mb-3">
                        <label for="evidence_description" class="form-label">Descripción de Evidencias</label>
                        <textarea class="form-control" id="evidence_description" name="evidence_description" rows="3"
                                  placeholder="Describa las evidencias que respaldan su impugnación (fotos, videos, documentos, testigos, etc.)"></textarea>
                        <small class="text-muted">Opcional: Describa las pruebas que pueden demostrar su caso.</small>
                    </div>

                    <div class="alert alert-warning">
                        <h6><i class="bi bi-exclamation-triangle"></i> Importante</h6>
                        <ul class="mb-0 small">
                            <li>La impugnación será revisada por la autoridad competente</li>
                            <li>El proceso puede tomar hasta 30 días hábiles</li>
                            <li>Se le notificará la resolución por correo electrónico</li>
                            <li>Durante la revisión, el pago de la multa quedará suspendido</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo BASE_URL; ?>/multas-transito/detalle/<?php echo $fine['id']; ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-send"></i> Enviar Impugnación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-question-circle"></i> Preguntas Frecuentes</h6>
            </div>
            <div class="card-body">
                <h6 class="small"><strong>¿Qué es una impugnación?</strong></h6>
                <p class="small">Es un recurso legal que permite al ciudadano cuestionar una multa que considera incorrecta.</p>

                <h6 class="small mt-3"><strong>¿Cuándo puedo impugnar?</strong></h6>
                <p class="small">Puede impugnar dentro de los 15 días hábiles siguientes a la fecha de notificación.</p>

                <h6 class="small mt-3"><strong>¿Qué evidencias debo presentar?</strong></h6>
                <p class="small">Fotografías, videos, documentos oficiales, testimonios o cualquier prueba que respalde su caso.</p>

                <h6 class="small mt-3"><strong>¿Debo pagar mientras se revisa?</strong></h6>
                <p class="small mb-0">No, el pago queda suspendido hasta que se emita una resolución.</p>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-telephone"></i> Contacto</h6>
            </div>
            <div class="card-body">
                <p class="small mb-2"><strong>Horario de Atención:</strong></p>
                <p class="small mb-2">Lunes a Viernes: 8:00 AM - 4:00 PM</p>
                <p class="small mb-2"><strong>Teléfono:</strong> (XXX) XXX-XXXX</p>
                <p class="small mb-0"><strong>Email:</strong> multas@municipio.gob.mx</p>
            </div>
        </div>
    </div>
</div>
