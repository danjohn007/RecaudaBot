<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-person-circle"></i> Mi Perfil</h1>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4 mb-4">
        <div class="card shadow text-center">
            <div class="card-body py-5">
                <i class="bi bi-person-circle fs-1 text-primary mb-3"></i>
                <h3><?php echo htmlspecialchars($user['full_name']); ?></h3>
                <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                <span class="badge bg-primary"><?php echo ucfirst($user['role']); ?></span>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-body">
                <h5><i class="bi bi-shield-check"></i> Seguridad</h5>
                <a href="<?php echo BASE_URL; ?>/perfil/cambiar-password" class="btn btn-outline-primary w-100 mt-2">
                    <i class="bi bi-key"></i> Cambiar Contraseña
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> Información Personal</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/perfil/actualizar">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                   value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                            <small class="text-muted">No se puede cambiar el correo</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($user['phone']); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="curp" class="form-label">CURP</label>
                            <input type="text" class="form-control" id="curp" 
                                   value="<?php echo htmlspecialchars($user['curp']); ?>" disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección</label>
                        <textarea class="form-control" id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Guardar Cambios
                    </button>
                </form>
            </div>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Última Actividad</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">
                    <strong>Último inicio de sesión:</strong> 
                    <?php echo $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'N/A'; ?>
                </p>
                <p class="mb-0">
                    <strong>Cuenta creada:</strong> 
                    <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                </p>
            </div>
        </div>
    </div>
</div>
