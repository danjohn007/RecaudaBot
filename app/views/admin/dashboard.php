<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-speedometer2"></i> Dashboard Administrativo</h1>
        <p class="text-muted">Bienvenido, <?php echo htmlspecialchars($_SESSION['full_name']); ?></p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-3 mb-4">
        <div class="card shadow text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Recaudación Total</h6>
                        <h2 class="mb-0">$<?php echo number_format($stats['total_revenue'], 2); ?></h2>
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
                        <h2 class="mb-0">$<?php echo number_format($stats['month_revenue'], 2); ?></h2>
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
                        <h6 class="mb-0">Usuarios</h6>
                        <h2 class="mb-0"><?php echo number_format($stats['total_users']); ?></h2>
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
                        <h6 class="mb-0">Trámites Pendientes</h6>
                        <h2 class="mb-0"><?php echo $stats['pending_licenses']; ?></h2>
                    </div>
                    <i class="bi bi-hourglass-split fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Recaudación por Concepto (Mes Actual)</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-list-check"></i> Resumen</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Impuestos Pendientes</span>
                        <span class="badge bg-warning"><?php echo $stats['pending_taxes']; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Multas Pendientes</span>
                        <span class="badge bg-danger"><?php echo $stats['pending_fines']; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Licencias Pendientes</span>
                        <span class="badge bg-info"><?php echo $stats['pending_licenses']; ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Pagos Pendientes por Concepto</h5>
            </div>
            <div class="card-body">
                <canvas id="obligationsChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-bar-chart-line"></i> Tendencia de Recaudación (Últimos 6 Meses)</h5>
            </div>
            <div class="card-body">
                <canvas id="trendChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-link-45deg"></i> Enlaces Rápidos</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="<?php echo BASE_URL; ?>/admin/usuarios" class="list-group-item list-group-item-action">
                        <i class="bi bi-people"></i> Gestionar Usuarios
                    </a>
                    <a href="<?php echo BASE_URL; ?>/admin/importaciones" class="list-group-item list-group-item-action">
                        <i class="bi bi-upload"></i> Importaciones Masivas
                    </a>
                    <a href="<?php echo BASE_URL; ?>/admin/reportes" class="list-group-item list-group-item-action">
                        <i class="bi bi-file-earmark-bar-graph"></i> Ver Reportes
                    </a>
                    <a href="<?php echo BASE_URL; ?>/admin/estadisticas" class="list-group-item list-group-item-action">
                        <i class="bi bi-graph-up"></i> Estadísticas Detalladas
                    </a>
                    <a href="<?php echo BASE_URL; ?>/admin/configuraciones" class="list-group-item list-group-item-action">
                        <i class="bi bi-gear"></i> Configuraciones del Sistema
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Actividad Reciente</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($stats['recent_activity'])): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($stats['recent_activity'] as $activity): ?>
                            <div class="list-group-item">
                                <?php if ($activity['type'] === 'payment'): ?>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-cash text-success"></i>
                                            <strong><?php echo htmlspecialchars($activity['full_name'] ?? 'Usuario'); ?></strong>
                                            realizó un pago de <strong>$<?php echo number_format($activity['amount'], 2); ?></strong>
                                        </div>
                                        <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($activity['activity_date'])); ?></small>
                                    </div>
                                <?php elseif ($activity['type'] === 'registration'): ?>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-person-plus text-info"></i>
                                            Nuevo usuario: <strong><?php echo htmlspecialchars($activity['full_name']); ?></strong>
                                        </div>
                                        <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($activity['activity_date'])); ?></small>
                                    </div>
                                <?php elseif ($activity['type'] === 'license'): ?>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-file-earmark-text text-warning"></i>
                                            <strong><?php echo htmlspecialchars($activity['full_name'] ?? 'Usuario'); ?></strong>
                                            solicitó licencia para <strong><?php echo htmlspecialchars($activity['business_name']); ?></strong>
                                        </div>
                                        <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($activity['activity_date'])); ?></small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">No hay actividad reciente</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Chart for revenue by type using ApexCharts
<?php if (!empty($stats['revenue_by_type'])): ?>
const revenueData = <?php echo json_encode($stats['revenue_by_type']); ?>;

const labels = revenueData.map(item => {
    const types = {
        'property_tax': 'Impuesto Predial',
        'business_license': 'Licencias',
        'traffic_fine': 'Multas Tránsito',
        'civic_fine': 'Multas Cívicas'
    };
    return types[item.payment_type] || item.payment_type;
});

const amounts = revenueData.map(item => parseFloat(item.total));

const revenueChartOptions = {
    series: [{
        name: 'Recaudación',
        data: amounts
    }],
    chart: {
        type: 'bar',
        height: 300,
        toolbar: {
            show: false
        }
    },
    colors: ['#36A2EB', '#4BC0C0', '#FFCE56', '#FF6384'],
    plotOptions: {
        bar: {
            columnWidth: '60%',
            distributed: true
        }
    },
    dataLabels: {
        enabled: false
    },
    legend: {
        show: false
    },
    xaxis: {
        categories: labels
    },
    yaxis: {
        title: {
            text: 'Monto ($)'
        },
        labels: {
            formatter: function (value) {
                return '$' + value.toLocaleString('es-MX', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            }
        }
    },
    tooltip: {
        y: {
            formatter: function (value) {
                return '$' + value.toLocaleString('es-MX', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            }
        }
    }
};

const revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueChartOptions);
revenueChart.render();
<?php endif; ?>

// Chart for pending obligations distribution (Donut Chart) using ApexCharts
const obligationsChartOptions = {
    series: [
        <?php echo isset($stats['pending_taxes_amount']) ? $stats['pending_taxes_amount'] : 0; ?>,
        <?php echo isset($stats['pending_traffic_fines_amount']) ? $stats['pending_traffic_fines_amount'] : 0; ?>,
        <?php echo isset($stats['pending_civic_fines_amount']) ? $stats['pending_civic_fines_amount'] : 0; ?>,
        <?php echo isset($stats['pending_licenses_amount']) ? $stats['pending_licenses_amount'] : 0; ?>
    ],
    chart: {
        type: 'donut',
        height: 250
    },
    labels: ['Impuestos Prediales', 'Multas de Tránsito', 'Multas Cívicas', 'Licencias'],
    colors: ['#36A2EB', '#FFCE56', '#FF6384', '#4BC0C0'],
    legend: {
        position: 'bottom'
    },
    dataLabels: {
        enabled: true,
        formatter: function (val, opts) {
            return val.toFixed(1) + '%';
        }
    },
    tooltip: {
        y: {
            formatter: function (value) {
                return '$' + value.toLocaleString('es-MX', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            }
        }
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};

const obligationsChart = new ApexCharts(document.querySelector("#obligationsChart"), obligationsChartOptions);
obligationsChart.render();

// Chart for revenue trend (Line Chart) using ApexCharts
const trendChartOptions = {
    series: [{
        name: 'Recaudación Total',
        data: <?php echo isset($stats['monthly_trend']) ? json_encode($stats['monthly_trend']) : '[0, 0, 0, 0, 0, ' . ($stats['month_revenue'] ?? 0) . ']'; ?>
    }],
    chart: {
        type: 'area',
        height: 250,
        toolbar: {
            show: false
        }
    },
    colors: ['#4BC0C0'],
    stroke: {
        curve: 'smooth',
        width: 2
    },
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.4,
            opacityTo: 0.1,
            stops: [0, 90, 100]
        }
    },
    dataLabels: {
        enabled: false
    },
    xaxis: {
        categories: ['Mes -5', 'Mes -4', 'Mes -3', 'Mes -2', 'Mes -1', 'Mes Actual']
    },
    yaxis: {
        title: {
            text: 'Recaudación ($)'
        },
        labels: {
            formatter: function (value) {
                return '$' + value.toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0});
            }
        }
    },
    tooltip: {
        y: {
            formatter: function (value) {
                return '$' + value.toLocaleString('es-MX', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            }
        }
    }
};

const trendChart = new ApexCharts(document.querySelector("#trendChart"), trendChartOptions);
trendChart.render();
</script>
