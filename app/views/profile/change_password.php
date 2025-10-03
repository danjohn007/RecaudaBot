<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4"><i class="bi bi-key"></i> Cambiar Contraseña</h1>
        
        <div class="card shadow">
            <div class="card-body p-4">
                <form method="POST" action="<?php echo BASE_URL; ?>/perfil/cambiar-password" id="changePasswordForm">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <small class="text-muted">Mínimo 8 caracteres</small>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle"></i> Cambiar Contraseña
                    </button>

                    <a href="<?php echo BASE_URL; ?>/perfil" class="btn btn-secondary w-100 mt-2">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        alert('Las contraseñas no coinciden');
        return;
    }
    
    if (newPassword.length < 8) {
        e.preventDefault();
        alert('La contraseña debe tener al menos 8 caracteres');
        return;
    }
});
</script>
