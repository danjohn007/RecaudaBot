<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-file-earmark-plus"></i> Nueva Licencia de Funcionamiento</h1>
        <p class="lead">Solicita tu licencia de funcionamiento completando el siguiente formulario</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?php echo BASE_URL; ?>/licencias/crear">
                    <div class="mb-3">
                        <label for="business_name" class="form-label">Nombre del Negocio <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="business_name" name="business_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="business_type" class="form-label">Tipo de Negocio <span class="text-danger">*</span></label>
                        <select class="form-select" id="business_type" name="business_type" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="Comercio">Comercio</option>
                            <option value="Servicios">Servicios</option>
                            <option value="Restaurante">Restaurante</option>
                            <option value="Bar/Cantina">Bar/Cantina</option>
                            <option value="Taller">Taller</option>
                            <option value="Oficina">Oficina</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="rfc" class="form-label">RFC <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="rfc" name="rfc" required pattern="[A-ZÑ&]{3,4}\d{6}[A-V1-9][A-Z1-9][0-9A]" placeholder="XAXX010101000">
                        <div class="form-text">Formato: XAXX010101000 (13 caracteres)</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección del Establecimiento <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" required pattern="[0-9]{10}" placeholder="5512345678">
                        <div class="form-text">10 dígitos sin espacios ni guiones</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> <strong>Nota:</strong> Después de enviar tu solicitud, recibirás un correo con las instrucciones para subir los documentos requeridos.
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-send"></i> Enviar Solicitud
                        </button>
                        <a href="<?php echo BASE_URL; ?>/licencias" class="btn btn-outline-secondary">
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
                <h6 class="mb-0"><i class="bi bi-file-earmark-text"></i> Documentos Requeridos</h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Identificación oficial vigente (INE/IFE/Pasaporte)</li>
                    <li>Comprobante de domicilio del negocio (no mayor a 3 meses)</li>
                    <li>RFC del propietario o empresa</li>
                    <li>Planos del local (con medidas y distribución)</li>
                    <li>Constancia de uso de suelo</li>
                    <li>Comprobante de pago de derechos</li>
                </ul>
            </div>
        </div>
    </div>
</div>
