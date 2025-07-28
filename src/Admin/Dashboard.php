<?php
namespace MyPlugin\Admin;

use MyPlugin\Logger;

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
            __('Plugin Dashboard', 'plugin-skeleton'),
            __('My Plugin', 'plugin-skeleton'),
            'manage_options',
            MY_PLUGIN_SLUG,
            [$this, 'render_dashboard'],
            'dashicons-admin-generic',
            20
        );
        
        add_submenu_page(
            MY_PLUGIN_SLUG,
            __('Settings', 'plugin-skeleton'),
            __('Settings', 'plugin-skeleton'),
            'manage_options',
            MY_PLUGIN_SLUG . '-settings',
            [Settings::get_instance(), 'render_settings_page']
        );
    }

    public function render_dashboard(): void {
        $this->logger->log('dashboard_view', 'Dashboard page accessed');
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Plugin Dashboard', 'plugin-skeleton'); ?></h1>
            <p><?php esc_html_e('Welcome to your plugin dashboard.', 'plugin-skeleton'); ?></p>
        </div>
        <?php
    }

    private function __clone() {}
}