<?php if (!empty($faqs)) : ?>
<?php 
    $colors = get_query_var('faq_colors', [
        'primary' => '#03b5d2',
        'background' => '#ffffff'
    ]);
?>
<main>
    <h1>سوالات</h1>
    <div class="accordion" id="accordion">
        <?php foreach ($faqs as $faq) : ?>
        <div class="accordion-item">
            <div class="accordion-header"><?php echo esc_html($faq['question']); ?></div>
            <div class="accordion-content">
            <p><?php echo wp_kses_post($faq['answer']); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>
<?php endif; ?>