<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                </div>
                
                <h2 class="card-title text-success mb-3">¡Sesión Cerrada!</h2>
                <p class="card-text text-muted mb-4">
                    <?php echo $message ?? 'Has cerrado sesión correctamente. Serás redirigido a la página principal donde puedes registrarte o iniciar sesión.'; ?>
                </p>
                
                <div class="mb-4">
                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                        <span class="visually-hidden">Redirigiendo...</span>
                    </div>
                    <small class="text-muted">Redirigiendo a la página principal en <span id="countdown"><?php echo $redirect_delay ?? 3; ?></span> segundos...</small>
                </div>
                
                <div class="d-grid gap-2">
                    <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">
                        <i class="bi bi-house"></i> Ir a la Página Principal
                    </a>
                    <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline-secondary">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión Nuevamente
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let countdown = <?php echo $redirect_delay ?? 3; ?>;
    const countdownElement = document.getElementById('countdown');
    const redirectUrl = '<?php echo BASE_URL; ?>';
    
    const timer = setInterval(function() {
        countdown--;
        if (countdownElement) {
            countdownElement.textContent = countdown;
        }
        
        if (countdown <= 0) {
            clearInterval(timer);
            window.location.href = redirectUrl;
        }
    }, 1000);
});
</script>

<style>
.card {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}
</style>