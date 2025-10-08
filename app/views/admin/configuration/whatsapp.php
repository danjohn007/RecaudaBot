<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-whatsapp"></i> Configuración de WhatsApp</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/configuraciones">Configuraciones</a></li>
                <li class="breadcrumb-item active">WhatsApp</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-chat-dots"></i> Configuración del Chatbot</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/configuraciones/actualizar">
                    <input type="hidden" name="redirect" value="/admin/configuraciones/whatsapp">
                    
                    <div class="mb-3">
                        <label for="whatsapp_enabled" class="form-label">Estado del Chatbot</label>
                        <select class="form-select" id="whatsapp_enabled" name="settings[whatsapp_enabled]">
                            <option value="1" <?php echo ($settings['whatsapp_enabled'] ?? '1') === '1' ? 'selected' : ''; ?>>Activado</option>
                            <option value="0" <?php echo ($settings['whatsapp_enabled'] ?? '') === '0' ? 'selected' : ''; ?>>Desactivado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp_phone" class="form-label">Número de WhatsApp</label>
                        <input type="text" class="form-control" id="whatsapp_phone" 
                               name="settings[whatsapp_phone]" 
                               value="<?php echo htmlspecialchars($settings['whatsapp_phone'] ?? ''); ?>"
                               placeholder="+52 1234567890">
                        <small class="form-text text-muted">Incluya el código de país (ejemplo: +52 para México)</small>
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp_api_key" class="form-label">API Key</label>
                        <input type="text" class="form-control" id="whatsapp_api_key" 
                               name="settings[whatsapp_api_key]" 
                               value="<?php echo htmlspecialchars($settings['whatsapp_api_key'] ?? ''); ?>">
                        <small class="form-text text-muted">Clave de API proporcionada por su proveedor de WhatsApp Business API</small>
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp_api_url" class="form-label">URL de API</label>
                        <input type="url" class="form-control" id="whatsapp_api_url" 
                               name="settings[whatsapp_api_url]" 
                               value="<?php echo htmlspecialchars($settings['whatsapp_api_url'] ?? ''); ?>"
                               placeholder="https://api.whatsapp.com/send">
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp_webhook_url" class="form-label">Webhook URL</label>
                        <input type="url" class="form-control" id="whatsapp_webhook_url" 
                               name="settings[whatsapp_webhook_url]" 
                               value="<?php echo htmlspecialchars($settings['whatsapp_webhook_url'] ?? ''); ?>"
                               placeholder="<?php echo BASE_URL; ?>/api/whatsapp/webhook">
                        <small class="form-text text-muted">URL para recibir mensajes entrantes</small>
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp_welcome_message" class="form-label">Mensaje de Bienvenida</label>
                        <textarea class="form-control" id="whatsapp_welcome_message" 
                                  name="settings[whatsapp_welcome_message]" rows="4"><?php echo htmlspecialchars($settings['whatsapp_welcome_message'] ?? 'Hola! Soy RecaudaBot, tu asistente virtual para trámites municipales. ¿En qué puedo ayudarte hoy?'); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp_business_hours" class="form-label">Horario de Atención</label>
                        <input type="text" class="form-control" id="whatsapp_business_hours" 
                               name="settings[whatsapp_business_hours]" 
                               value="<?php echo htmlspecialchars($settings['whatsapp_business_hours'] ?? 'Lunes a Viernes de 8:00 AM a 6:00 PM'); ?>">
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="whatsapp_auto_reply" 
                               name="settings[whatsapp_auto_reply]" value="1"
                               <?php echo ($settings['whatsapp_auto_reply'] ?? '1') === '1' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="whatsapp_auto_reply">
                            Habilitar respuestas automáticas
                        </label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo BASE_URL; ?>/admin/configuraciones" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Información</h6>
            </div>
            <div class="card-body">
                <h6>Características del Chatbot:</h6>
                <ul class="small">
                    <li>Consulta de saldo de obligaciones</li>
                    <li>Generación de líneas de captura</li>
                    <li>Confirmación de pagos</li>
                    <li>Información de trámites</li>
                    <li>Recordatorios de vencimientos</li>
                </ul>
                
                <div class="alert alert-warning small mt-3">
                    <i class="bi bi-exclamation-triangle"></i> 
                    Requiere una cuenta de WhatsApp Business API
                </div>
            </div>
        </div>
    </div>
</div>
