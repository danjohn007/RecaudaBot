<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-people"></i> Reporte de Ciudadanos</h1>
        <p class="lead">Consulta información de ciudadanos registrados</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros de Búsqueda</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo BASE_URL; ?>/admin/reportes/ciudadanos">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   placeholder="Nombre, email o CURP" 
                                   value="<?php echo htmlspecialchars($filters['search']); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Todos</option>
                                <option value="active" <?php echo $filters['status'] === 'active' ? 'selected' : ''; ?>>Activo</option>
                                <option value="inactive" <?php echo $filters['status'] === 'inactive' ? 'selected' : ''; ?>>Inactivo</option>
                                <option value="suspended" <?php echo $filters['status'] === 'suspended' ? 'selected' : ''; ?>>Suspendido</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date_from" class="form-label">Desde</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="<?php echo htmlspecialchars($filters['date_from']); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date_to" class="form-label">Hasta</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" 
                                   value="<?php echo htmlspecialchars($filters['date_to']); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                            <a href="<?php echo BASE_URL; ?>/admin/reportes/ciudadanos" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Limpiar
                            </a>
                            <a href="<?php echo BASE_URL; ?>/admin/reportes/exportar?type=citizens&format=csv" class="btn btn-success">
                                <i class="bi bi-download"></i> Exportar CSV
                            </a>
                            <a href="<?php echo BASE_URL; ?>/admin/reportes/exportar?type=citizens&format=xml" class="btn btn-info">
                                <i class="bi bi-download"></i> Exportar XML
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-table"></i> Resultados (<?php echo count($citizens); ?> ciudadanos)</h5>
            </div>
            <div class="card-body">
                <?php if (empty($citizens)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No se encontraron ciudadanos con los filtros aplicados.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Nombre Completo</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>CURP</th>
                                    <th>Estado</th>
                                    <th>Registro</th>
                                    <th>Último Acceso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($citizens as $citizen): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($citizen['id']); ?></td>
                                        <td><?php echo htmlspecialchars($citizen['username']); ?></td>
                                        <td><?php echo htmlspecialchars($citizen['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($citizen['email']); ?></td>
                                        <td><?php echo htmlspecialchars($citizen['phone'] ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($citizen['curp'] ?? '-'); ?></td>
                                        <td>
                                            <?php 
                                            $statusClass = [
                                                'active' => 'success',
                                                'inactive' => 'secondary',
                                                'suspended' => 'danger'
                                            ];
                                            $statusLabel = [
                                                'active' => 'Activo',
                                                'inactive' => 'Inactivo',
                                                'suspended' => 'Suspendido'
                                            ];
                                            $status = $citizen['status'] ?? 'active';
                                            ?>
                                            <span class="badge bg-<?php echo $statusClass[$status] ?? 'secondary'; ?>">
                                                <?php echo $statusLabel[$status] ?? $status; ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($citizen['created_at'])); ?></td>
                                        <td><?php echo $citizen['last_login'] ? date('d/m/Y', strtotime($citizen['last_login'])) : 'Nunca'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <a href="<?php echo BASE_URL; ?>/admin/reportes" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver a Reportes
        </a>
    </div>
</div>
