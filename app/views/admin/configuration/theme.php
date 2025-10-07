<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-palette"></i> Configuración de Tema y Colores</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/configuraciones">Configuraciones</a></li>
                <li class="breadcrumb-item active">Tema y Colores</li>
            </ol>
        </nav>
    </div>
</div>

<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-palette"></i> Personalización de Colores del Sistema</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/configuraciones/actualizar" id="themeForm">
                    <input type="hidden" name="redirect" value="/admin/configuraciones/tema">
                    
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary"><i class="bi bi-brush"></i> Colores Principales del Sistema</h5>
                            <p class="text-muted">Estos colores se aplican a todo el sistema, incluyendo botones, encabezados y elementos de interfaz.</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="theme_primary_color" class="form-label">
                                <i class="bi bi-circle-fill text-primary"></i> Color Principal
                            </label>
                            <input type="color" class="form-control form-control-color" 
                                   id="theme_primary_color" 
                                   name="settings[theme_primary_color]" 
                                   value="<?php echo htmlspecialchars($settings['theme_primary_color']); ?>"
                                   title="Seleccione el color principal">
                            <small class="text-muted"><?php echo htmlspecialchars($settings['theme_primary_color']); ?></small>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="theme_secondary_color" class="form-label">
                                <i class="bi bi-circle-fill text-secondary"></i> Color Secundario
                            </label>
                            <input type="color" class="form-control form-control-color" 
                                   id="theme_secondary_color" 
                                   name="settings[theme_secondary_color]" 
                                   value="<?php echo htmlspecialchars($settings['theme_secondary_color']); ?>"
                                   title="Seleccione el color secundario">
                            <small class="text-muted"><?php echo htmlspecialchars($settings['theme_secondary_color']); ?></small>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="theme_success_color" class="form-label">
                                <i class="bi bi-circle-fill text-success"></i> Color Éxito
                            </label>
                            <input type="color" class="form-control form-control-color" 
                                   id="theme_success_color" 
                                   name="settings[theme_success_color]" 
                                   value="<?php echo htmlspecialchars($settings['theme_success_color']); ?>"
                                   title="Seleccione el color de éxito">
                            <small class="text-muted"><?php echo htmlspecialchars($settings['theme_success_color']); ?></small>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="theme_danger_color" class="form-label">
                                <i class="bi bi-circle-fill text-danger"></i> Color Peligro
                            </label>
                            <input type="color" class="form-control form-control-color" 
                                   id="theme_danger_color" 
                                   name="settings[theme_danger_color]" 
                                   value="<?php echo htmlspecialchars($settings['theme_danger_color']); ?>"
                                   title="Seleccione el color de peligro">
                            <small class="text-muted"><?php echo htmlspecialchars($settings['theme_danger_color']); ?></small>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="theme_warning_color" class="form-label">
                                <i class="bi bi-circle-fill text-warning"></i> Color Advertencia
                            </label>
                            <input type="color" class="form-control form-control-color" 
                                   id="theme_warning_color" 
                                   name="settings[theme_warning_color]" 
                                   value="<?php echo htmlspecialchars($settings['theme_warning_color']); ?>"
                                   title="Seleccione el color de advertencia">
                            <small class="text-muted"><?php echo htmlspecialchars($settings['theme_warning_color']); ?></small>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="theme_info_color" class="form-label">
                                <i class="bi bi-circle-fill text-info"></i> Color Información
                            </label>
                            <input type="color" class="form-control form-control-color" 
                                   id="theme_info_color" 
                                   name="settings[theme_info_color]" 
                                   value="<?php echo htmlspecialchars($settings['theme_info_color']); ?>"
                                   title="Seleccione el color de información">
                            <small class="text-muted"><?php echo htmlspecialchars($settings['theme_info_color']); ?></small>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="theme_light_color" class="form-label">
                                <i class="bi bi-circle-fill text-light border"></i> Color Claro
                            </label>
                            <input type="color" class="form-control form-control-color" 
                                   id="theme_light_color" 
                                   name="settings[theme_light_color]" 
                                   value="<?php echo htmlspecialchars($settings['theme_light_color']); ?>"
                                   title="Seleccione el color claro">
                            <small class="text-muted"><?php echo htmlspecialchars($settings['theme_light_color']); ?></small>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="theme_dark_color" class="form-label">
                                <i class="bi bi-circle-fill text-dark"></i> Color Oscuro
                            </label>
                            <input type="color" class="form-control form-control-color" 
                                   id="theme_dark_color" 
                                   name="settings[theme_dark_color]" 
                                   value="<?php echo htmlspecialchars($settings['theme_dark_color']); ?>"
                                   title="Seleccione el color oscuro">
                            <small class="text-muted"><?php echo htmlspecialchars($settings['theme_dark_color']); ?></small>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary"><i class="bi bi-chat-dots"></i> Colores del Asistente Virtual / Chat</h5>
                            <p class="text-muted">Personaliza los colores del chatbot y las burbujas de mensajes.</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="theme_chatbot_bg_color" class="form-label">
                                <i class="bi bi-circle-fill"></i> Fondo del Chatbot
                            </label>
                            <input type="color" class="form-control form-control-color" 
                                   id="theme_chatbot_bg_color" 
                                   name="settings[theme_chatbot_bg_color]" 
                                   value="<?php echo htmlspecialchars($settings['theme_chatbot_bg_color']); ?>"
                                   title="Color de fondo del chatbot">
                            <small class="text-muted"><?php echo htmlspecialchars($settings['theme_chatbot_bg_color']); ?></small>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="theme_chatbot_text_color" class="form-label">
                                <i class="bi bi-circle-fill"></i> Texto del Chatbot
                            </label>
                            <input type="color" class="form-control form-control-color" 
                                   id="theme_chatbot_text_color" 
                                   name="settings[theme_chatbot_text_color]" 
                                   value="<?php echo htmlspecialchars($settings['theme_chatbot_text_color']); ?>"
                                   title="Color de texto del chatbot">
                            <small class="text-muted"><?php echo htmlspecialchars($settings['theme_chatbot_text_color']); ?></small>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="theme_chatbot_user_bg_color" class="form-label">
                                <i class="bi bi-circle-fill"></i> Fondo Mensaje Usuario
                            </label>
                            <input type="color" class="form-control form-control-color" 
                                   id="theme_chatbot_user_bg_color" 
                                   name="settings[theme_chatbot_user_bg_color]" 
                                   value="<?php echo htmlspecialchars($settings['theme_chatbot_user_bg_color']); ?>"
                                   title="Color de fondo de mensajes del usuario">
                            <small class="text-muted"><?php echo htmlspecialchars($settings['theme_chatbot_user_bg_color']); ?></small>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="theme_chatbot_user_text_color" class="form-label">
                                <i class="bi bi-circle-fill"></i> Texto Mensaje Usuario
                            </label>
                            <input type="color" class="form-control form-control-color" 
                                   id="theme_chatbot_user_text_color" 
                                   name="settings[theme_chatbot_user_text_color]" 
                                   value="<?php echo htmlspecialchars($settings['theme_chatbot_user_text_color']); ?>"
                                   title="Color de texto de mensajes del usuario">
                            <small class="text-muted"><?php echo htmlspecialchars($settings['theme_chatbot_user_text_color']); ?></small>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-primary"><i class="bi bi-eye"></i> Vista Previa</h5>
                            <p class="text-muted">Previsualización de cómo se verán los colores en el sistema.</p>
                            
                            <div class="preview-container border rounded p-3 bg-light">
                                <button type="button" class="btn btn-primary me-2" id="preview-primary">Principal</button>
                                <button type="button" class="btn btn-secondary me-2" id="preview-secondary">Secundario</button>
                                <button type="button" class="btn btn-success me-2" id="preview-success">Éxito</button>
                                <button type="button" class="btn btn-danger me-2" id="preview-danger">Peligro</button>
                                <button type="button" class="btn btn-warning me-2" id="preview-warning">Advertencia</button>
                                <button type="button" class="btn btn-info me-2" id="preview-info">Información</button>
                                
                                <div class="mt-3">
                                    <div class="card" style="max-width: 400px;">
                                        <div class="card-header text-white" id="preview-chatbot-header">
                                            Asistente Virtual
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-2 p-2 rounded" id="preview-chatbot-bot" style="display: inline-block;">
                                                Hola, ¿en qué puedo ayudarte?
                                            </div>
                                            <div class="mb-2 p-2 rounded text-end" id="preview-chatbot-user" style="display: inline-block; float: right;">
                                                Consultar mi impuesto predial
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save"></i> Guardar Configuración
                            </button>
                            <a href="<?php echo BASE_URL; ?>/admin/configuraciones" class="btn btn-secondary btn-lg">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                            <button type="button" class="btn btn-warning btn-lg" id="resetTheme">
                                <i class="bi bi-arrow-counterclockwise"></i> Restablecer Valores Predeterminados
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Update preview when color changes
document.querySelectorAll('input[type="color"]').forEach(input => {
    input.addEventListener('input', updatePreview);
});

function updatePreview() {
    // Update buttons
    document.getElementById('preview-primary').style.backgroundColor = document.getElementById('theme_primary_color').value;
    document.getElementById('preview-secondary').style.backgroundColor = document.getElementById('theme_secondary_color').value;
    document.getElementById('preview-success').style.backgroundColor = document.getElementById('theme_success_color').value;
    document.getElementById('preview-danger').style.backgroundColor = document.getElementById('theme_danger_color').value;
    document.getElementById('preview-warning').style.backgroundColor = document.getElementById('theme_warning_color').value;
    document.getElementById('preview-info').style.backgroundColor = document.getElementById('theme_info_color').value;
    
    // Update chatbot preview
    const chatHeader = document.getElementById('preview-chatbot-header');
    const chatBot = document.getElementById('preview-chatbot-bot');
    const chatUser = document.getElementById('preview-chatbot-user');
    
    chatHeader.style.backgroundColor = document.getElementById('theme_chatbot_bg_color').value;
    chatHeader.style.color = document.getElementById('theme_chatbot_text_color').value;
    
    chatBot.style.backgroundColor = document.getElementById('theme_chatbot_bg_color').value;
    chatBot.style.color = document.getElementById('theme_chatbot_text_color').value;
    
    chatUser.style.backgroundColor = document.getElementById('theme_chatbot_user_bg_color').value;
    chatUser.style.color = document.getElementById('theme_chatbot_user_text_color').value;
    
    // Update small text displays
    document.querySelectorAll('input[type="color"]').forEach(input => {
        const small = input.nextElementSibling;
        if (small && small.tagName === 'SMALL') {
            small.textContent = input.value;
        }
    });
}

// Reset to default values
document.getElementById('resetTheme').addEventListener('click', function() {
    if (confirm('¿Está seguro de restablecer los colores a los valores predeterminados?')) {
        document.getElementById('theme_primary_color').value = '#0d6efd';
        document.getElementById('theme_secondary_color').value = '#6c757d';
        document.getElementById('theme_success_color').value = '#198754';
        document.getElementById('theme_danger_color').value = '#dc3545';
        document.getElementById('theme_warning_color').value = '#ffc107';
        document.getElementById('theme_info_color').value = '#0dcaf0';
        document.getElementById('theme_light_color').value = '#f8f9fa';
        document.getElementById('theme_dark_color').value = '#212529';
        document.getElementById('theme_chatbot_bg_color').value = '#0d6efd';
        document.getElementById('theme_chatbot_text_color').value = '#ffffff';
        document.getElementById('theme_chatbot_user_bg_color').value = '#e9ecef';
        document.getElementById('theme_chatbot_user_text_color').value = '#212529';
        updatePreview();
    }
});

// Initialize preview on load
updatePreview();
</script>
