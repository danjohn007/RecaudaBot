<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-pencil"></i> Editar Usuario</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/usuarios">Usuarios</a></li>
                <li class="breadcrumb-item active">Editar Usuario</li>
            </ol>
        </nav>
    </div>
</div>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person"></i> Información del Usuario</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/admin/usuarios/editar/<?php echo $user['id']; ?>">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">Rol <span class="text-danger">*</span></label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="citizen" <?php echo $user['role'] === 'citizen' ? 'selected' : ''; ?>>Ciudadano</option>
                            <option value="municipal_area" <?php echo $user['role'] === 'municipal_area' ? 'selected' : ''; ?>>Área Municipal</option>
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> <strong>Nota:</strong> El nombre de usuario, CURP y contraseña no pueden ser modificados desde esta interfaz.
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar Cambios
                        </button>
                        <a href="<?php echo BASE_URL; ?>/admin/usuarios/ver/<?php echo $user['id']; ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información</h5>
            </div>
            <div class="card-body">
                <p><strong>Usuario:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>CURP:</strong> <?php echo htmlspecialchars($user['curp'] ?? 'N/A'); ?></p>
                <p><strong>Estado:</strong> 
                    <?php
                    $statusClass = $user['status'] === 'active' ? 'success' : 'secondary';
                    $statusText = $user['status'] === 'active' ? 'Activo' : 'Inactivo';
                    ?>
                    <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                </p>
                <p><strong>Registrado:</strong> <?php echo date('d/m/Y', strtotime($user['created_at'])); ?></p>
                <hr>
                <p class="text-muted small">
                    <i class="bi bi-lightbulb"></i> 
                    Los cambios realizados aquí afectarán la información del usuario en todo el sistema.
                </p>
            </div>
        </div>
    </div>
</div>
