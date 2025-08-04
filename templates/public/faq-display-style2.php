<?php if (!empty($faqs)) : ?>
<?php 
    $colors = get_query_var('faq_colors', [
        'primary' => '#03b5d2',
        'background' => '#ffffff'
    ]);
?>
<style>
  .faqTemplateParent{
    background-color: #17FFFF;
  } 
  .accordion-content{
      background-color: #F5DEB3;
  }
</style>
<div class="faqTemplateParent">
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
</div>
<?php endif; ?>