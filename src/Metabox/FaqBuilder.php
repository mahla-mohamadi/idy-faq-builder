<?php
namespace IdyFaqBuilder\Metabox;

use IdyFaqBuilder\Logger;

class FaqBuilder {
    private static $instance = null;
    private $logger;
    private $post_id;
    private function __construct(Logger $logger) {
        $this->logger = $logger;
        $this->post_id = get_the_ID();
        add_action('add_meta_boxes', [$this, 'add_meta_box'] );
        add_action('save_post',[$this, 'save_faq_data'] );
        add_action('admin_enqueue_scripts',[$this, 'enqueue_faqbuilder_scripts'] );
    }

    public static function init(Logger $logger): void {
        if (null === self::$instance) {
            self::$instance = new self($logger);
        }
    }

    public static function get_instance(): self {
        if (self::$instance === null) {
            throw new \RuntimeException('Metabox class not initialized. Call init() first.');
        }
        return self::$instance;
    }

    private function __clone() {}

    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }

    public function add_meta_box(): void {
        add_meta_box(
            'idechy_faq',
            'سوالات متداول',
            [$this, 'render_meta_box'],
            ['post', 'page'],
            'normal',
            'default'
        );
    }

    public function render_meta_box($post): void {
        wp_nonce_field('idechy_faq_nonce_action', 'idechy_faq_nonce_field');
        $faqs = get_post_meta($post->ID, '_single_mb_single_faq', true);
        
        // Load template
        require IDECHY_FAQ_PATH . 'templates/admin/meta-box.php';
    }

    public function save_faq_data($post_id): void {
        if (!isset($_POST['idechy_faq_nonce_field']) || 
            !wp_verify_nonce($_POST['idechy_faq_nonce_field'], 'idechy_faq_nonce_action')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        $questions = $_POST['faq_question'] ?? [];
        $answers = $_POST['faq_answer'] ?? [];
        $faqs = [];

        foreach ($questions as $index => $question) {
            if (!empty(trim($question))) {
                $faqs[] = [
                    'question' => sanitize_text_field($question),
                    'answer' => wp_kses_post($answers[$index])
                ];
            }
        }

        update_post_meta($post_id, '_single_mb_single_faq', $faqs);
    }
    public function enqueue_faqbuilder_scripts() {
        // Enqueue WordPress color picker scripts
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');

        wp_enqueue_script(
            'idy-faq-admin', 
            IDECHY_FAQ_URL . 'assets/js/main.js', 
            ['jquery', 'jquery-ui-sortable', 'wp-color-picker'], // Add wp-color-picker as dependency
            filemtime(IDECHY_FAQ_PATH . 'assets/js/main.js'), 
            true
        );
        
        wp_enqueue_style('dashicons');
        wp_enqueue_style(
            'idy-faq-admin',
            IDECHY_FAQ_URL . 'assets/css/admin.css',
            [],
            filemtime(IDECHY_FAQ_PATH . 'assets/css/admin.css')
        );
    }
}