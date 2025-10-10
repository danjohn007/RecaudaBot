<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body p-5">
                <h2 class="card-title text-center mb-4">
                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                </h2>

                <form method="POST" action="<?php echo PUBLIC_URL; ?>/login" id="loginForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario o Correo Electrónico</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">
                            Recordarme
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                    </button>
                </form>

                <div class="mt-3 text-center">
                    <a href="#">¿Olvidaste tu contraseña?</a>
                </div>

                <hr class="my-4">

                <div class="text-center">
                    <p>¿No tienes cuenta? <a href="<?php echo PUBLIC_URL; ?>/register">Regístrate aquí</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    
    if (!username || !password) {
        e.preventDefault();
        alert('Por favor, complete todos los campos');
    }
});
</script>
