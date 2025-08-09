<?php
namespace IdyFaqBuilder\Public;

use IdyFaqBuilder\Logger;

class Frontend {
    private static $instance = null;
    private $logger;

    public static function init(Logger $logger): void {
        if (null === self::$instance) {
            self::$instance = new self($logger);
        }
    }

    private function __construct(Logger $logger) {
        $this->logger = $logger;
        add_action('the_content', [$this, 'display_faqs'], 20);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        $this->logger->log('SYSTEM', 'Frontend Initialized');
    }

    // Modify the display_faqs() method:
    public function display_faqs($content) {
        if (!is_singular() || !in_the_loop() || !is_main_query()) {
            return $content;
        }

        $faqs = get_post_meta(get_the_ID(), '_single_mb_single_faq', true);
        
        if (empty($faqs)) {
            return $content;
        }

        // Get all settings
        $options = get_option('my_plugin_settings', []);
        $settings = [
            'title' => $options['faq_section_title'] ?? __('Frequently Asked Questions', 'idy-faq-builder'),
            'colors' => [
                'primary' => $options['faq_primary_color'] ?? '#03b5d2',
                'background' => $options['faq_bg_color'] ?? '#ffffff'
            ],
            'template' => $options['faq_template'] ?? 'default'
        ];
        
        // Pass settings to template
        set_query_var('faq_settings', $settings);
        
        // Buffer the template output
        ob_start();
        include $this->get_template_path($settings['template']);
        return $content . ob_get_clean();
    }
    private function enqueue_template_styles($template) {
        if (!is_singular()) return;

        $style_handle = 'idy-faq-frontend-' . $template;
        $style_file = 'assets/css/frontend-' . $template . '.css';
        
        wp_enqueue_style(
            $style_handle,
            IDECHY_FAQ_URL . $style_file,
            [],
            filemtime(IDECHY_FAQ_PATH . $style_file)
        );
    }
    private function get_template_path($template) {
        $template_file = 'faq-display-' . $template . '.php';
        $template_path = IDECHY_FAQ_PATH . 'templates/public/' . $template_file;
        
        // Fallback to default if template file doesn't exist
        if (!file_exists($template_path)) {
            $template_file = 'faq-display.php';
        }
        
        return IDECHY_FAQ_PATH . 'templates/public/' . $template_file;
    }
    public function enqueue_styles() {
        if (is_singular()) {
            // Get all settings at once
            $options = get_option('my_plugin_settings', []);
            $template = $options['faq_template'] ?? 'default';
            $primary_color = $options['faq_primary_color'] ?? '#03b5d2';
            $bg_color = $options['faq_bg_color'] ?? '#ffffff';
            
            $this->enqueue_template_assets($template, $primary_color, $bg_color);
        }
    }
    private function enqueue_template_assets($template, $primary_color, $bg_color) {
        // Enqueue CSS
        $css_handle = 'idy-faq-frontend-' . $template;
        $css_file = 'assets/css/frontend-' . $template . '.css';
        
        // Fallback to default if template-specific file doesn't exist
        if (!file_exists(IDECHY_FAQ_PATH . $css_file)) {
            $css_file = 'assets/css/frontend.css';
        }
        
        if (file_exists(IDECHY_FAQ_PATH . $css_file)) {
            wp_enqueue_style(
                $css_handle,
                IDECHY_FAQ_URL . $css_file,
                [],
                filemtime(IDECHY_FAQ_PATH . $css_file)
            );
            
            // Dynamic CSS with both colors
            $dynamic_css = "
                .faqTemplateParent {
                    background-color: {$bg_color};
                }
                .accordion-item.active .svg,
                .accordion-header:hover,
                .accordion-item.active .accordion-header,
                .accordion-item.active .line {
                    color: {$primary_color};
                    border-color: {$primary_color};
                }
            ";
            
            wp_add_inline_style($css_handle, $dynamic_css);
        }
        
        // Enqueue JS
        $js_handle = 'idy-faq-frontend-js-' . $template;
        $js_file = 'assets/js/script-' . $template . '.js';
        
        if (!file_exists(IDECHY_FAQ_PATH . $js_file)) {
            $js_file = 'assets/js/script.js';
        }
        
        if (file_exists(IDECHY_FAQ_PATH . $js_file)) {
            wp_enqueue_script(
                $js_handle,
                IDECHY_FAQ_URL . $js_file,
                ['jquery'],
                filemtime(IDECHY_FAQ_PATH . $js_file),
                true
            );
        }
    }
    private function __clone() {}
}