<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-graph-up"></i> Estadísticas del Sistema</h1>
        <p class="lead">Análisis y métricas del sistema de recaudación</p>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mt-4">
    <div class="col-md-3 mb-4">
        <div class="card shadow text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Recaudación Total</h6>
                        <h2 class="mb-0">$<?php echo number_format($stats['total_revenue'] ?? 0, 2); ?></h2>
                    </div>
                    <i class="bi bi-cash-stack fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card shadow text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Este Mes</h6>
                        <h2 class="mb-0">$<?php echo number_format($stats['month_revenue'] ?? 0, 2); ?></h2>
                    </div>
                    <i class="bi bi-calendar-check fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card shadow text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Usuarios Activos</h6>
                        <h2 class="mb-0"><?php echo number_format($stats['total_users'] ?? 0); ?></h2>
                    </div>
                    <i class="bi bi-people fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card shadow text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Transacciones Hoy</h6>
                        <h2 class="mb-0"><?php echo number_format($stats['today_transactions'] ?? 0); ?></h2>
                    </div>
                    <i class="bi bi-receipt fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Recaudación por Mes</h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Recaudación por Tipo</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueByTypeChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Tendencias de Registro de Usuarios</h5>
            </div>
            <div class="card-body">
                <canvas id="userRegistrationChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Table -->
<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-list-ol"></i> Top 5 Tipos de Pago</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Monto Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Impuesto Predial</td>
                            <td><?php echo number_format($stats['property_tax_count'] ?? 0); ?></td>
                            <td>$<?php echo number_format($stats['property_tax_amount'] ?? 0, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Multas de Tránsito</td>
                            <td><?php echo number_format($stats['traffic_fine_count'] ?? 0); ?></td>
                            <td>$<?php echo number_format($stats['traffic_fine_amount'] ?? 0, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Multas Cívicas</td>
                            <td><?php echo number_format($stats['civic_fine_count'] ?? 0); ?></td>
                            <td>$<?php echo number_format($stats['civic_fine_amount'] ?? 0, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Licencias</td>
                            <td><?php echo number_format($stats['license_count'] ?? 0); ?></td>
                            <td>$<?php echo number_format($stats['license_amount'] ?? 0, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Otros</td>
                            <td><?php echo number_format($stats['other_count'] ?? 0); ?></td>
                            <td>$<?php echo number_format($stats['other_amount'] ?? 0, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Pagos Pendientes</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Monto Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Impuesto Predial</td>
                            <td><?php echo number_format($stats['pending_property_tax_count'] ?? 0); ?></td>
                            <td>$<?php echo number_format($stats['pending_property_tax_amount'] ?? 0, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Multas de Tránsito</td>
                            <td><?php echo number_format($stats['pending_traffic_fine_count'] ?? 0); ?></td>
                            <td>$<?php echo number_format($stats['pending_traffic_fine_amount'] ?? 0, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Multas Cívicas</td>
                            <td><?php echo number_format($stats['pending_civic_fine_count'] ?? 0); ?></td>
                            <td>$<?php echo number_format($stats['pending_civic_fine_amount'] ?? 0, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Monthly Revenue Chart
const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart');
new Chart(monthlyRevenueCtx, {
    type: 'line',
    data: {
        labels: ['Mes -5', 'Mes -4', 'Mes -3', 'Mes -2', 'Mes -1', 'Mes Actual'],
        datasets: [{
            label: 'Recaudación ($)',
            data: <?php echo isset($stats['monthly_trend']) ? json_encode($stats['monthly_trend']) : '[0, 0, 0, 0, 0, 0]'; ?>,
            borderColor: 'rgba(13, 110, 253, 1)',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Revenue by Type Chart
const revenueByTypeCtx = document.getElementById('revenueByTypeChart');
<?php if (!empty($stats['revenue_by_type'])): ?>
const revenueData = <?php echo json_encode($stats['revenue_by_type']); ?>;
const typeLabels = revenueData.map(item => {
    const types = {
        'property_tax': 'Impuesto Predial',
        'business_license': 'Licencias',
        'traffic_fine': 'Multas Tránsito',
        'civic_fine': 'Multas Cívicas'
    };
    return types[item.payment_type] || item.payment_type;
});
const typeAmounts = revenueData.map(item => parseFloat(item.total));
<?php else: ?>
const typeLabels = ['Impuesto Predial', 'Licencias', 'Multas Tránsito', 'Multas Cívicas'];
const typeAmounts = [0, 0, 0, 0];
<?php endif; ?>

new Chart(revenueByTypeCtx, {
    type: 'doughnut',
    data: {
        labels: typeLabels,
        datasets: [{
            data: typeAmounts,
            backgroundColor: [
                'rgba(13, 110, 253, 0.7)',
                'rgba(25, 135, 84, 0.7)',
                'rgba(255, 193, 7, 0.7)',
                'rgba(220, 53, 69, 0.7)'
            ],
            borderColor: [
                'rgba(13, 110, 253, 1)',
                'rgba(25, 135, 84, 1)',
                'rgba(255, 193, 7, 1)',
                'rgba(220, 53, 69, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// User Registration Chart
const userRegistrationCtx = document.getElementById('userRegistrationChart');
new Chart(userRegistrationCtx, {
    type: 'bar',
    data: {
        labels: ['Mes -5', 'Mes -4', 'Mes -3', 'Mes -2', 'Mes -1', 'Mes Actual'],
        datasets: [{
            label: 'Nuevos Usuarios',
            data: <?php echo isset($stats['user_registration_trend']) ? json_encode($stats['user_registration_trend']) : '[0, 0, 0, 0, 0, 0]'; ?>,
            backgroundColor: 'rgba(13, 202, 240, 0.5)',
            borderColor: 'rgba(13, 202, 240, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 5
                }
            }
        }
    }
});
</script>
