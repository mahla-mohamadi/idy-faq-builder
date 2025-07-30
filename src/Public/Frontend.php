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

    public function display_faqs($content) {
        if (!is_singular() || !in_the_loop() || !is_main_query()) {
            return $content;
        }

        $faqs = get_post_meta(get_the_ID(), '_single_mb_single_faq', true);
        
        if (empty($faqs)) {
            return $content;
        }

        // Buffer the template output
        ob_start();
        include IDECHY_FAQ_PATH . 'templates/public/faq-display.php';
        return $content . ob_get_clean();
    }

    public function enqueue_styles() {
        if (is_singular()) {
            wp_enqueue_style(
                'idy-faq-frontend',
                IDECHY_FAQ_URL . 'assets/css/frontend.css',
                [],
                filemtime(IDECHY_FAQ_PATH . 'assets/css/frontend.css')
            );
        }
    }

    private function __clone() {}
}