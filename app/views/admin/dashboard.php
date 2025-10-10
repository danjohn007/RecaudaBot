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

<!-- Cargar Chart.js con verificación completa -->
<script>
// Función para cargar Chart.js dinámicamente si no está disponible
function loadChartJS() {
    return new Promise((resolve, reject) => {
        if (typeof Chart !== 'undefined') {
            resolve();
            return;
        }
        
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js';
        script.onload = () => {
            console.log('Chart.js cargado exitosamente');
            resolve();
        };
        script.onerror = () => {
            console.error('Error al cargar Chart.js');
            reject();
        };
        document.head.appendChild(script);
    });
}

// Función principal para inicializar las gráficas
async function initializeCharts() {
    try {
        // Asegurar que Chart.js esté cargado
        await loadChartJS();
        
        console.log('Inicializando gráficas...');
        console.log('Chart disponible:', typeof Chart);

        // Chart for revenue by type
        <?php if (!empty($stats['revenue_by_type'])): ?>
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            console.log('Creando gráfica de ingresos por tipo...');
            const revenueData = <?php echo json_encode($stats['revenue_by_type']); ?>;
            console.log('Datos de ingresos:', revenueData);

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

            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Recaudación ($)',
                        data: amounts,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(255, 99, 132, 0.5)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            console.log('✓ Gráfica de ingresos creada');
        } else {
            console.error('Canvas revenueChart no encontrado');
        }
        <?php else: ?>
        console.log('No hay datos de revenue_by_type para mostrar');
        // Crear gráfica vacía como placeholder
        const revenueCtxEmpty = document.getElementById('revenueChart');
        if (revenueCtxEmpty) {
            new Chart(revenueCtxEmpty, {
                type: 'bar',
                data: {
                    labels: ['Sin datos'],
                    datasets: [{
                        label: 'Recaudación ($)',
                        data: [0],
                        backgroundColor: ['rgba(200, 200, 200, 0.5)'],
                        borderColor: ['rgba(200, 200, 200, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'No hay datos disponibles'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        <?php endif; ?>

        // Chart for pending obligations distribution (Pie Chart)
        const obligationsCtx = document.getElementById('obligationsChart');
        if (obligationsCtx) {
            console.log('Creando gráfica de obligaciones pendientes...');
            new Chart(obligationsCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Impuestos Prediales', 'Multas de Tránsito', 'Multas Cívicas', 'Licencias'],
                    datasets: [{
                        label: 'Monto Pendiente ($)',
                        data: [
                            <?php echo isset($stats['pending_taxes_amount']) ? $stats['pending_taxes_amount'] : 0; ?>,
                            <?php echo isset($stats['pending_traffic_fines_amount']) ? $stats['pending_traffic_fines_amount'] : 0; ?>,
                            <?php echo isset($stats['pending_civic_fines_amount']) ? $stats['pending_civic_fines_amount'] : 0; ?>,
                            <?php echo isset($stats['pending_licenses_amount']) ? $stats['pending_licenses_amount'] : 0; ?>
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(75, 192, 192, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += '$' + context.parsed.toLocaleString('es-MX', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
            console.log('✓ Gráfica de obligaciones creada');
        } else {
            console.error('Canvas obligationsChart no encontrado');
        }

        // Chart for revenue trend (Line Chart)
        const trendCtx = document.getElementById('trendChart');
        if (trendCtx) {
            console.log('Creando gráfica de tendencias...');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: ['Mes -5', 'Mes -4', 'Mes -3', 'Mes -2', 'Mes -1', 'Mes Actual'],
                    datasets: [{
                        label: 'Recaudación Total ($)',
                        data: <?php echo isset($stats['monthly_trend']) ? json_encode($stats['monthly_trend']) : '[0, 0, 0, 0, 0, ' . ($stats['month_revenue'] ?? 0) . ']'; ?>,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
            console.log('✓ Gráfica de tendencias creada');
        } else {
            console.error('Canvas trendChart no encontrado');
        }

        console.log('✓ Todas las gráficas inicializadas correctamente');
        
    } catch (error) {
        console.error('Error al inicializar gráficas:', error);
        
        // Mostrar mensaje de error en las gráficas
        const canvases = ['revenueChart', 'obligationsChart', 'trendChart'];
        canvases.forEach(canvasId => {
            const canvas = document.getElementById(canvasId);
            if (canvas) {
                const parent = canvas.parentElement;
                parent.innerHTML = '<div class="alert alert-warning">Error al cargar la gráfica. <button onclick="initializeCharts()" class="btn btn-sm btn-primary">Reintentar</button></div>';
            }
        });
    }
}

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeCharts);
} else {
    initializeCharts();
}
</script>
