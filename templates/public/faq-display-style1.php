<?php if (!empty($faqs)) : ?>
<?php 
    $colors = get_query_var('faq_colors', [
        'primary' => '#03b5d2',
        'background' => '#ffffff'
    ]);
?>
<style>
  main{
    background-color:#f9f9f9 ;
  }
    .accordion-item.active .svg{
      color: <?php echo esc_attr($primary_color); ?>;
      border: 1px solid <?php echo esc_attr($primary_color); ?>;

    }
      .accordion-header:hover {
      color: <?php echo esc_attr($primary_color); ?>;
    }
    .accordion-item.active .accordion-header{
      color: <?php echo esc_attr($primary_color); ?>;
    }
     .accordion-item.active .line{
      border-bottom: 1px solid <?php echo esc_attr($primary_color); ?>;
      color: <?php echo esc_attr($primary_color); ?>;

    }
</style>
<main>
 <h1>سوالات</h1>
    <div class="accordion" id="accordion">
        <?php foreach ($faqs as $faq) : ?>
            <div class="accordion-item">
                <div class="line">
                    <div class="accordion-header"><?php echo esc_html($faq['question']); ?></div>
                <div class="svg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                </div>
                </div>
                <div class="accordion-content">
                    <p><?php echo wp_kses_post($faq['answer']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php endif; ?>