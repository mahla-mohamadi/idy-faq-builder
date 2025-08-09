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
<!-- <style>
  .faqTemplateParent{
    background-color: #17FFFF;
  } 
  .accordion-content{
      background-color: #F5DEB3;
  }
</style> -->
<div class="faqTemplateParent">
    <h2><?php echo esc_html($title); ?></h2>
    <div class="accordion" id="accordion">
        <?php foreach ($faqs as $faq) : ?>
            <div class="accordion-item">
                <div class="accordion-header">
                    <span><?php echo esc_html($faq['question']); ?></span>
                    <svg width="18" height="18" viewBox="2 2 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m15.583 4-6.587 6.587a2.013 2.013 0 0 0 0 2.826L15.583 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="accordion-content">
                <p><?php echo wp_kses_post($faq['answer']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>