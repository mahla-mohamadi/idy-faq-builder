<?php
namespace IdyFaqBuilder\Admin;

use IdyFaqBuilder\Logger;

class Dashboard {
    private static $instance = null;
    private $logger;

    public static function init(Logger $logger): void {
        if (null === self::$instance) {
            self::$instance = new self($logger);
        }
        add_action('admin_menu', [self::$instance, 'add_menu']);
    }

    private function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    public function add_menu(): void {
        add_menu_page(
            __('Plugin Dashboard', 'idy-faq-builder'),
            __('My Plugin', 'idy-faq-builder'),
            'manage_options',
            MY_PLUGIN_SLUG,
            [$this, 'render_dashboard'],
            'dashicons-admin-generic',
            20
        );
        
        add_submenu_page(
            MY_PLUGIN_SLUG,
            __('Settings', 'idy-faq-builder'),
            __('Settings', 'idy-faq-builder'),
            'manage_options',
            MY_PLUGIN_SLUG . '-settings',
            [Settings::get_instance(), 'render_settings_page']
        );
        add_action('admin_enqueue_scripts', [$this, 'enqueue_color_picker']);
    }
    public function enqueue_color_picker($hook) {
        if ($hook === 'toplevel_page_idy-faq-builder' || $hook === 'my-plugin_page_idy-faq-builder-settings') {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');
            
            wp_enqueue_script(
                'idy-faq-admin-color-picker',
                IDECHY_FAQ_URL . 'assets/js/admin-color-picker.js',
                ['wp-color-picker'],
                filemtime(IDECHY_FAQ_PATH . 'assets/js/admin-color-picker.js'),
                true
            );
        }
    }
    public function render_dashboard(): void {
        $this->logger->log('dashboard_view', 'Dashboard page accessed');
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Plugin Dashboard', 'idy-faq-builder'); ?></h1>
            <p><?php esc_html_e('Welcome to your plugin dashboard.', 'idy-faq-builder'); ?></p>
        </div>
        <?php
    }

    private function __clone() {}
}