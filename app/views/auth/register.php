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
                            Acepto los <a href="#">términos y condiciones</a>
                        </label>
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

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const curp = document.getElementById('curp').value;
    const phone = document.getElementById('phone').value;
    
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
});
</script>
