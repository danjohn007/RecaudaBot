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
    <!-- Revenue Trend Chart -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-line-chart"></i> Tendencia de Recaudación Mensual</h5>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 350px;">
                    <canvas id="monthlyRevenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue by Type Chart -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Recaudación por Tipo</h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <div style="position: relative; width: 100%; max-width: 300px; height: 300px;">
                    <canvas id="revenueByTypeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row of Charts -->
<div class="row mt-4">
    <!-- User Registration Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-people"></i> Registros de Usuarios por Mes</h5>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 280px;">
                    <canvas id="userRegistrationChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="bi bi-speedometer2"></i> Métricas Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border-end">
                            <h3 class="text-primary mb-0"><?php echo number_format($stats['total_payments'] ?? 0); ?></h3>
                            <small class="text-muted">Pagos Totales</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <h3 class="text-success mb-0"><?php echo number_format($stats['this_month_payments'] ?? 0); ?></h3>
                        <small class="text-muted">Pagos Este Mes</small>
                    </div>
                    <div class="col-6">
                        <div class="border-end">
                            <h3 class="text-warning mb-0"><?php echo number_format($stats['pending_count'] ?? 0); ?></h3>
                            <small class="text-muted">Pendientes</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h3 class="text-info mb-0"><?php echo number_format($stats['avg_payment'] ?? 0, 2); ?></h3>
                        <small class="text-muted">Pago Promedio</small>
                    </div>
                </div>
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

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<!-- Custom Styles for Charts -->
<style>
.chart-container {
    position: relative;
    overflow: hidden;
}

.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.card-header {
    border-bottom: 2px solid rgba(255,255,255,0.1);
}

.card-header h5 {
    font-weight: 600;
    letter-spacing: 0.5px;
}

.metrics-item {
    padding: 15px;
    border-radius: 8px;
    background: linear-gradient(145deg, #f8f9fa, #e9ecef);
    margin-bottom: 10px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .chart-container {
        height: 250px !important;
    }
    
    .col-lg-8, .col-lg-6, .col-lg-4 {
        margin-bottom: 20px;
    }
}

/* Animation for chart containers */
.card-body {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Verify Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded!');
        return;
    }

    // Monthly Revenue Chart
    const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart');
    if (monthlyRevenueCtx) {
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
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(13, 110, 253, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    }
                }
            }
        });
    }

    // Revenue by Type Chart
    const revenueByTypeCtx = document.getElementById('revenueByTypeChart');
    if (revenueByTypeCtx) {
        let typeLabels, typeAmounts;
        
        <?php if (!empty($stats['revenue_by_type'])): ?>
        const revenueData = <?php echo json_encode($stats['revenue_by_type']); ?>;
        typeLabels = revenueData.map(item => {
            const types = {
                'property_tax': 'Impuesto Predial',
                'business_license': 'Licencias',
                'traffic_fine': 'Multas Tránsito',
                'civic_fine': 'Multas Cívicas'
            };
            return types[item.payment_type] || item.payment_type;
        });
        typeAmounts = revenueData.map(item => parseFloat(item.total));
        <?php else: ?>
        typeLabels = ['Impuesto Predial', 'Licencias', 'Multas Tránsito', 'Multas Cívicas'];
        typeAmounts = [0, 0, 0, 0];
        <?php endif; ?>

        new Chart(revenueByTypeCtx, {
            type: 'doughnut',
            data: {
                labels: typeLabels,
                datasets: [{
                    data: typeAmounts,
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.8)',
                        'rgba(25, 135, 84, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(111, 66, 193, 0.8)',
                        'rgba(13, 202, 240, 0.8)'
                    ],
                    borderColor: [
                        'rgba(13, 110, 253, 1)',
                        'rgba(25, 135, 84, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(111, 66, 193, 1)',
                        'rgba(13, 202, 240, 1)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map((label, i) => {
                                        const value = data.datasets[0].data[i];
                                        return {
                                            text: label + ': $' + value.toLocaleString(),
                                            fillStyle: data.datasets[0].backgroundColor[i],
                                            strokeStyle: data.datasets[0].borderColor[i],
                                            lineWidth: data.datasets[0].borderWidth,
                                            hidden: false,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return label + ': $' + value.toLocaleString() + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // User Registration Chart
    const userRegistrationCtx = document.getElementById('userRegistrationChart');
    if (userRegistrationCtx) {
        new Chart(userRegistrationCtx, {
            type: 'bar',
            data: {
                labels: ['Mes -5', 'Mes -4', 'Mes -3', 'Mes -2', 'Mes -1', 'Mes Actual'],
                datasets: [{
                    label: 'Nuevos Usuarios',
                    data: <?php echo isset($stats['user_registration_trend']) ? json_encode($stats['user_registration_trend']) : '[0, 0, 0, 0, 0, 0]'; ?>,
                    backgroundColor: 'rgba(13, 202, 240, 0.6)',
                    borderColor: 'rgba(13, 202, 240, 1)',
                    borderWidth: 2,
                    borderRadius: 4,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        },
                        ticks: {
                            stepSize: 5
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
});
</script>
