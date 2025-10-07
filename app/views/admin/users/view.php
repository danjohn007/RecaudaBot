<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-person-circle"></i> Detalle del Usuario</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/admin/usuarios">Usuarios</a></li>
                <li class="breadcrumb-item active">Ver Usuario</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person"></i> Información del Usuario</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="30%">ID</th>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                        </tr>
                        <tr>
                            <th>Nombre de Usuario</th>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                        </tr>
                        <tr>
                            <th>Nombre Completo</th>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                        </tr>
                        <tr>
                            <th>Teléfono</th>
                            <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <th>CURP</th>
                            <td><?php echo htmlspecialchars($user['curp'] ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <th>Rol</th>
                            <td>
                                <?php
                                $roleClass = '';
                                $roleText = '';
                                switch($user['role']) {
                                    case 'admin':
                                        $roleClass = 'danger';
                                        $roleText = 'Administrador';
                                        break;
                                    case 'municipal_area':
                                        $roleClass = 'warning';
                                        $roleText = 'Área Municipal';
                                        break;
                                    default:
                                        $roleClass = 'primary';
                                        $roleText = 'Ciudadano';
                                }
                                ?>
                                <span class="badge bg-<?php echo $roleClass; ?>"><?php echo $roleText; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Estado</th>
                            <td>
                                <?php
                                $statusClass = $user['status'] === 'active' ? 'success' : 'secondary';
                                $statusText = $user['status'] === 'active' ? 'Activo' : 'Inactivo';
                                ?>
                                <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha de Registro</th>
                            <td><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></td>
                        </tr>
                        <tr>
                            <th>Último Acceso</th>
                            <td><?php echo $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Nunca'; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="bi bi-gear"></i> Acciones</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo BASE_URL; ?>/admin/usuarios/editar/<?php echo $user['id']; ?>" 
                       class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Editar Usuario
                    </a>
                    
                    <?php if ($user['status'] === 'active'): ?>
                    <a href="<?php echo BASE_URL; ?>/admin/usuarios/desactivar/<?php echo $user['id']; ?>" 
                       class="btn btn-warning"
                       onclick="return confirm('¿Desea desactivar este usuario?')">
                        <i class="bi bi-lock"></i> Desactivar Usuario
                    </a>
                    <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/admin/usuarios/activar/<?php echo $user['id']; ?>" 
                       class="btn btn-success">
                        <i class="bi bi-unlock"></i> Activar Usuario
                    </a>
                    <?php endif; ?>
                    
                    <a href="<?php echo BASE_URL; ?>/admin/usuarios/eliminar/<?php echo $user['id']; ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('¿Está seguro de eliminar este usuario? Esta acción no se puede deshacer.')">
                        <i class="bi bi-trash"></i> Eliminar Usuario
                    </a>
                    
                    <a href="<?php echo BASE_URL; ?>/admin/usuarios" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver a la Lista
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
