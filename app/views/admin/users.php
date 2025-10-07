<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-people"></i> Gestión de Usuarios</h1>
        <p class="lead">Administra los usuarios del sistema</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-list-ul"></i> Lista de Usuarios</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                                        <td><?php echo htmlspecialchars($user['username'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
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
                                        <td>
                                            <?php
                                            $statusClass = $user['status'] === 'active' ? 'success' : 'secondary';
                                            $statusText = $user['status'] === 'active' ? 'Activo' : ucfirst($user['status']);
                                            ?>
                                            <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/admin/usuarios/editar/<?php echo $user['id']; ?>" 
                                               class="btn btn-sm btn-primary" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No hay usuarios registrados</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
