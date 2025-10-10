<?php
require_once 'config/config.php';

echo "<h2>Prueba de URLs</h2>";
echo "<p><strong>BASE_URL:</strong> " . BASE_URL . "</p>";
echo "<p><strong>PUBLIC_URL:</strong> " . PUBLIC_URL . "</p>";

echo "<h3>Enlaces de prueba:</h3>";
echo "<ul>";
echo "<li><a href='" . PUBLIC_URL . "/css/style.css'>CSS File</a></li>";
echo "<li><a href='" . PUBLIC_URL . "/js/main.js'>JS File</a></li>";
echo "<li><a href='https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js'>Chart.js CDN</a></li>";
echo "</ul>";

echo "<h3>Test Chart.js carga:</h3>";
echo "<div id='testChart' style='width: 400px; height: 200px; border: 1px solid #ccc;'>
    <canvas id='myChart'></canvas>
</div>";

echo "<script src='https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js'></script>";
echo "<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Chart type:', typeof Chart);
    
    if (typeof Chart !== 'undefined') {
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Test 1', 'Test 2', 'Test 3'],
                datasets: [{
                    label: 'Datos de Prueba',
                    data: [12, 19, 3],
                    backgroundColor: ['red', 'blue', 'green']
                }]
            }
        });
        document.getElementById('testChart').innerHTML += '<p style=\"color: green;\">✓ Chart.js funciona correctamente</p>';
    } else {
        document.getElementById('testChart').innerHTML = '<p style=\"color: red;\">✗ Chart.js no está disponible</p>';
    }
});
</script>";
?>