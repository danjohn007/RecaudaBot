<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4"><i class="bi bi-search"></i> Consultar Multas Cívicas</h1>
        
        <div class="card shadow">
            <div class="card-body p-4">
                <form method="POST" action="<?php echo BASE_URL; ?>/multas-civicas/buscar">
                    <div class="mb-4">
                        <label for="search" class="form-label">Buscar por:</label>
                        <input type="text" class="form-control form-control-lg" id="search" name="search" 
                               placeholder="Folio de la multa, nombre o identificación" required>
                        <small class="form-text text-muted">
                            Ejemplo: MC-2024-00001 o Roberto Sánchez
                        </small>
                    </div>
                    
                    <button type="submit" class="btn btn-danger btn-lg w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
