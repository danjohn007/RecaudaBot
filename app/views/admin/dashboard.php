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
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Actividad Reciente</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Últimos movimientos del sistema...</p>
            </div>
        </div>
    </div>
</div>

<script>
// Chart for revenue by type
<?php if (!empty($stats['revenue_by_type'])): ?>
const ctx = document.getElementById('revenueChart');
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

new Chart(ctx, {
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
<?php endif; ?>
</script>
