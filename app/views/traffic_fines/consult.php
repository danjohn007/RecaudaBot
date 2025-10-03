<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4"><i class="bi bi-search"></i> Consultar Multas de Tránsito</h1>
        
        <div class="card shadow">
            <div class="card-body p-4">
                <form method="POST" action="<?php echo BASE_URL; ?>/multas-transito/buscar">
                    <div class="mb-4">
                        <label for="search" class="form-label">Buscar por:</label>
                        <input type="text" class="form-control form-control-lg" id="search" name="search" 
                               placeholder="Folio, placas del vehículo o número de licencia" required>
                        <small class="form-text text-muted">
                            Ejemplo: MT-2024-00001 o ABC-123-XY
                        </small>
                    </div>
                    
                    <button type="submit" class="btn btn-warning btn-lg w-100 text-dark">
                        <i class="bi bi-search"></i> Buscar Multas
                    </button>
                </form>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5><i class="bi bi-currency-dollar text-success"></i> Descuentos</h5>
                        <p class="mb-0 small">Paga dentro de los primeros 15 días y obtén 20% de descuento.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5><i class="bi bi-shield-check text-primary"></i> Impugnación</h5>
                        <p class="mb-0 small">¿No estás de acuerdo? Impugna tu multa en línea.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
