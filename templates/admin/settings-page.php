<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <form action="options.php" method="post">
        <?php
        settings_fields($this->option_group);
        do_settings_sections($this->settings_page);
        submit_button(__('Save Settings', 'idy-faq-builder'));
        ?>
    </form>
</div>