<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body p-5">
                <h2 class="card-title text-center mb-4">
                    <i class="bi bi-person-plus"></i> Registrarse
                </h2>

                <form method="POST" action="<?php echo BASE_URL; ?>/register" id="registerForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico *</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo $_SESSION['old']['email'] ?? ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="full_name" class="form-label">Nombre Completo *</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="<?php echo $_SESSION['old']['full_name'] ?? ''; ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="curp" class="form-label">CURP *</label>
                            <input type="text" class="form-control" id="curp" name="curp" 
                                   maxlength="18" value="<?php echo $_SESSION['old']['curp'] ?? ''; ?>" required>
                            <small class="text-muted">18 caracteres</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Teléfono *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   maxlength="10" pattern="[0-9]{10}"
                                   value="<?php echo $_SESSION['old']['phone'] ?? ''; ?>" required>
                            <small class="text-muted">10 dígitos</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección</label>
                        <textarea class="form-control" id="address" name="address" rows="2"><?php echo $_SESSION['old']['address'] ?? ''; ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Contraseña *</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <small class="text-muted">Mínimo 8 caracteres</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Contraseña *</label>
                            <input type="password" class="form-control" id="confirm_password" required>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">términos y condiciones</a>
                        </label>
                    </div>

                    <!-- CAPTCHA -->
                    <div class="mb-3">
                        <label class="form-label">Verificación de Seguridad *</label>
                        <div class="card bg-light">
                            <div class="card-body">
                                <p class="mb-2">¿Cuánto es <strong><span id="captcha_num1"></span> + <span id="captcha_num2"></span></strong>?</p>
                                <input type="number" class="form-control" id="captcha_answer" name="captcha_answer" required placeholder="Ingrese el resultado">
                                <input type="hidden" id="captcha_sum" name="captcha_sum">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-person-plus"></i> Registrarse
                    </button>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p>¿Ya tienes cuenta? <a href="<?php echo BASE_URL; ?>/login">Inicia sesión aquí</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php unset($_SESSION['old']); ?>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Términos y Condiciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <h6>1. Aceptación de Términos</h6>
                <p>Al registrarse en RecaudaBot, usted acepta cumplir con estos términos y condiciones de uso.</p>
                
                <h6>2. Uso del Servicio</h6>
                <p>RecaudaBot es una plataforma para la gestión de trámites municipales incluyendo impuestos prediales, licencias de funcionamiento, y multas de tránsito y cívicas.</p>
                
                <h6>3. Responsabilidad del Usuario</h6>
                <p>El usuario es responsable de:</p>
                <ul>
                    <li>Mantener la confidencialidad de su cuenta y contraseña</li>
                    <li>Proporcionar información veraz y actualizada</li>
                    <li>Cumplir con las obligaciones fiscales y administrativas</li>
                    <li>Notificar cualquier uso no autorizado de su cuenta</li>
                </ul>
                
                <h6>4. Privacidad de Datos</h6>
                <p>Sus datos personales serán tratados conforme a la Ley de Protección de Datos Personales. La información proporcionada será utilizada únicamente para fines administrativos y de recaudación municipal.</p>
                
                <h6>5. Pagos y Transacciones</h6>
                <p>Los pagos realizados a través de la plataforma son procesados de manera segura. El municipio no se hace responsable por errores en la información proporcionada por el usuario al realizar pagos.</p>
                
                <h6>6. Modificaciones</h6>
                <p>El municipio se reserva el derecho de modificar estos términos en cualquier momento. Los cambios serán notificados a través de la plataforma.</p>
                
                <h6>7. Limitación de Responsabilidad</h6>
                <p>El municipio no será responsable por interrupciones del servicio, errores técnicos o pérdida de información, salvo en casos de negligencia comprobada.</p>
                
                <h6>8. Ley Aplicable</h6>
                <p>Estos términos se rigen por las leyes de México y la jurisdicción local del municipio.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
// Generate CAPTCHA
function generateCaptcha() {
    const num1 = Math.floor(Math.random() * 20) + 1;
    const num2 = Math.floor(Math.random() * 20) + 1;
    const sum = num1 + num2;
    
    document.getElementById('captcha_num1').textContent = num1;
    document.getElementById('captcha_num2').textContent = num2;
    document.getElementById('captcha_sum').value = sum;
}

// Initialize CAPTCHA on page load
generateCaptcha();

document.getElementById('registerForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const curp = document.getElementById('curp').value;
    const phone = document.getElementById('phone').value;
    const captchaAnswer = parseInt(document.getElementById('captcha_answer').value);
    const captchaSum = parseInt(document.getElementById('captcha_sum').value);
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Las contraseñas no coinciden');
        return;
    }
    
    if (password.length < 8) {
        e.preventDefault();
        alert('La contraseña debe tener al menos 8 caracteres');
        return;
    }
    
    if (curp.length !== 18) {
        e.preventDefault();
        alert('El CURP debe tener 18 caracteres');
        return;
    }
    
    if (!/^\d{10}$/.test(phone)) {
        e.preventDefault();
        alert('El teléfono debe tener exactamente 10 dígitos numéricos');
        return;
    }
    
    if (captchaAnswer !== captchaSum) {
        e.preventDefault();
        alert('La respuesta del CAPTCHA es incorrecta. Por favor intente nuevamente.');
        generateCaptcha(); // Generate new CAPTCHA
        document.getElementById('captcha_answer').value = '';
        return;
    }
});
</script>
