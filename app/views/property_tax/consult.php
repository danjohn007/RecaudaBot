<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4"><i class="bi bi-search"></i> Consultar Impuesto Predial</h1>
        
        <div class="card shadow">
            <div class="card-body p-4">
                <form method="POST" action="<?php echo BASE_URL; ?>/impuesto-predial/buscar">
                    <div class="mb-4">
                        <label for="search" class="form-label">Buscar por:</label>
                        <input type="text" class="form-control form-control-lg" id="search" name="search" 
                               placeholder="Clave catastral, nombre del propietario o dirección" required>
                        <small class="form-text text-muted">
                            Ejemplo: CAT-2024-001-0123 o Juan Pérez
                        </small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </form>
            </div>
        </div>
        
        <div class="alert alert-info mt-4">
            <h5><i class="bi bi-info-circle"></i> ¿Dónde encontrar la clave catastral?</h5>
            <p class="mb-0">La clave catastral se encuentra en:</p>
            <ul>
                <li>Recibo de predial anterior</li>
                <li>Escrituras de la propiedad</li>
                <li>Boleta de valor catastral</li>
            </ul>
        </div>
    </div>
</div>
