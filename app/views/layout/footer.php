    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="bi bi-building"></i> RecaudaBot</h5>
                    <p>Sistema Integral de Recaudación Municipal</p>
                    <p class="text-muted">Versión <?php echo APP_VERSION; ?></p>
                </div>
                <div class="col-md-4">
                    <h5>Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>/orientacion/guias" class="text-white-50">Guías de Trámites</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/orientacion/faq" class="text-white-50">Preguntas Frecuentes</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/citas/agendar" class="text-white-50">Agendar Cita</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/orientacion/calculadoras" class="text-white-50">Calculadoras</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <p class="text-white-50">
                        <i class="bi bi-telephone"></i> 01 800 123 4567<br>
                        <i class="bi bi-envelope"></i> info@municipio.gob.mx<br>
                        <i class="bi bi-geo-alt"></i> Palacio Municipal, Centro
                    </p>
                </div>
            </div>
            <hr class="bg-white">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Municipio. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="<?php echo PUBLIC_URL; ?>/js/main.js"></script>
</body>
</html>
