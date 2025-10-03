<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4"><i class="bi bi-calendar-plus"></i> Agendar Cita</h1>
        
        <div class="card shadow">
            <div class="card-body p-4">
                <form method="POST" action="<?php echo BASE_URL; ?>/citas/agendar">
                    <div class="mb-3">
                        <label for="service_type" class="form-label">Tipo de Trámite</label>
                        <select class="form-select" id="service_type" name="service_type" required>
                            <option value="">Selecciona un tipo de trámite</option>
                            <option value="Impuesto Predial">Impuesto Predial</option>
                            <option value="Licencia de Funcionamiento - Nuevo">Licencia de Funcionamiento - Nuevo</option>
                            <option value="Licencia de Funcionamiento - Renovación">Licencia de Funcionamiento - Renovación</option>
                            <option value="Multas de Tránsito">Multas de Tránsito</option>
                            <option value="Multas Cívicas">Multas Cívicas</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="appointment_date" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="appointment_date" name="appointment_date" 
                                   min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="appointment_time" class="form-label">Hora</label>
                            <select class="form-select" id="appointment_time" name="appointment_time" required>
                                <option value="">Selecciona una hora</option>
                                <option value="08:00:00">08:00 AM</option>
                                <option value="09:00:00">09:00 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="12:00:00">12:00 PM</option>
                                <option value="13:00:00">01:00 PM</option>
                                <option value="14:00:00">02:00 PM</option>
                                <option value="15:00:00">03:00 PM</option>
                                <option value="16:00:00">04:00 PM</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notas Adicionales</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                  placeholder="Describe brevemente el motivo de tu cita..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-check-circle"></i> Agendar Cita
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
