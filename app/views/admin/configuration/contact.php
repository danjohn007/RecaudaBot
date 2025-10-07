<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-telephone"></i> Información de Contacto</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/configuraciones">Configuraciones</a></li>
                <li class="breadcrumb-item active">Contacto</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-10 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-gear"></i> Teléfonos y Horarios de Atención</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/configuraciones/actualizar">
                    <input type="hidden" name="redirect" value="/admin/configuraciones/contacto">
                    
                    <div class="mb-3">
                        <label for="contact_phone_main" class="form-label">Teléfono Principal</label>
                        <input type="tel" class="form-control" id="contact_phone_main" 
                               name="settings[contact_phone_main]" 
                               value="<?php echo htmlspecialchars($settings['contact_phone_main'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="contact_phone_toll_free" class="form-label">Teléfono Gratuito</label>
                        <input type="tel" class="form-control" id="contact_phone_toll_free" 
                               name="settings[contact_phone_toll_free]" 
                               value="<?php echo htmlspecialchars($settings['contact_phone_toll_free'] ?? '01 800 123 4567'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Correo de Contacto</label>
                        <input type="email" class="form-control" id="contact_email" 
                               name="settings[contact_email]" 
                               value="<?php echo htmlspecialchars($settings['contact_email'] ?? 'info@municipio.gob.mx'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="contact_address" class="form-label">Dirección Física</label>
                        <textarea class="form-control" id="contact_address" 
                                  name="settings[contact_address]" rows="2"><?php echo htmlspecialchars($settings['contact_address'] ?? 'Palacio Municipal, Centro'); ?></textarea>
                    </div>

                    <hr>

                    <h5 class="mb-3">Horarios de Atención</h5>

                    <div class="mb-3">
                        <label for="contact_hours_weekday" class="form-label">Días de Semana (Lunes a Viernes)</label>
                        <input type="text" class="form-control" id="contact_hours_weekday" 
                               name="settings[contact_hours_weekday]" 
                               value="<?php echo htmlspecialchars($settings['contact_hours_weekday'] ?? '8:00 AM - 4:00 PM'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="contact_hours_saturday" class="form-label">Sábados</label>
                        <input type="text" class="form-control" id="contact_hours_saturday" 
                               name="settings[contact_hours_saturday]" 
                               value="<?php echo htmlspecialchars($settings['contact_hours_saturday'] ?? '9:00 AM - 1:00 PM'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="contact_hours_sunday" class="form-label">Domingos</label>
                        <input type="text" class="form-control" id="contact_hours_sunday" 
                               name="settings[contact_hours_sunday]" 
                               value="<?php echo htmlspecialchars($settings['contact_hours_sunday'] ?? 'Cerrado'); ?>">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo BASE_URL; ?>/admin/configuraciones" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-save"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
