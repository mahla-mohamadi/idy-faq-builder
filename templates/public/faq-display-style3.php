<?php if (!empty($faqs)) : ?>
<?php 
    $settings = get_query_var('faq_settings', [
        'title' => __('Frequently Asked Questions', 'idy-faq-builder'),
        'colors' => [
            'primary' => '#03b5d2',
            'background' => '#ffffff'
        ]
    ]);
    extract($settings);
?>
<div class="faqTemplateParent">
    <h2><?php echo esc_html($title); ?></h2>
    <div class="accordion" id="accordion">
        <?php foreach ($faqs as $faq) : ?>
        <div class="accordion-item">
            <div class="accordion-header">
                <span><?php echo esc_html($faq['question']); ?></span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m7.467 10.333 3.777 3.778a1.135 1.135 0 0 0 1.606 0l3.683-3.778" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 21.5a9.5 9.5 0 1 0 0-19 9.5 9.5 0 0 0 0 19" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="accordion-content">
                <p><?php echo wp_kses_post($faq['answer']); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>