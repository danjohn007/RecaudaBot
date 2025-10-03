<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-question-circle"></i> Preguntas Frecuentes</h1>
        <p class="lead">Encuentra respuestas rápidas a las preguntas más comunes</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <?php
        $categories = [];
        foreach ($faqs as $faq) {
            $categories[$faq['category']][] = $faq;
        }
        ?>
        
        <?php foreach ($categories as $category => $categoryFaqs): ?>
        <h3 class="mt-4 mb-3"><?php echo ucfirst(str_replace('_', ' ', $category)); ?></h3>
        <div class="accordion mb-4" id="faq-<?php echo htmlspecialchars($category); ?>">
            <?php foreach ($categoryFaqs as $index => $faq): ?>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#faq-<?php echo htmlspecialchars($category); ?>-<?php echo $index; ?>">
                        <?php echo htmlspecialchars($faq['question']); ?>
                    </button>
                </h2>
                <div id="faq-<?php echo htmlspecialchars($category); ?>-<?php echo $index; ?>" 
                     class="accordion-collapse collapse" data-bs-parent="#faq-<?php echo htmlspecialchars($category); ?>">
                    <div class="accordion-body">
                        <?php echo nl2br(htmlspecialchars($faq['answer'])); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
