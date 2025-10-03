<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-book"></i> Guías de Trámites</h1>
        <p class="lead">Instrucciones paso a paso para completar tus trámites</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <?php
        $categories = [];
        foreach ($guides as $guide) {
            $categories[$guide['category']][] = $guide;
        }
        ?>
        
        <div class="accordion" id="guidesAccordion">
            <?php foreach ($categories as $category => $categoryGuides): ?>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#category-<?php echo htmlspecialchars($category); ?>">
                        <strong><?php echo ucfirst(str_replace('_', ' ', $category)); ?></strong>
                    </button>
                </h2>
                <div id="category-<?php echo htmlspecialchars($category); ?>" class="accordion-collapse collapse" 
                     data-bs-parent="#guidesAccordion">
                    <div class="accordion-body">
                        <?php foreach ($categoryGuides as $guide): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($guide['title']); ?></h5>
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($guide['content'])); ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
