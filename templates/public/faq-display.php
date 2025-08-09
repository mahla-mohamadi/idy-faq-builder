<?php if (!empty($faqs)) : ?>
<div class="idy-faqs-frontend">
    <h3><?php echo esc_html($faq_settings['title']); ?></h3>
    <div class="faq-list">
        <?php foreach ($faqs as $faq) : ?>
            <div class="faq-item">
                <h4 class="faq-question"><?php echo esc_html($faq['question']); ?></h4>
                <div class="faq-answer"><?php echo wp_kses_post($faq['answer']); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>