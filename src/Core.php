<?php
namespace MyPlugin;

final class Core {
    private static $instance = null;
    private $logger;
    private $settings;

    public static function get_instance(): self {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->logger = Logger::get_instance();
    }

    public function init(): void {
        // Initialize components
        if (is_admin()) {
            \MyPlugin\Admin\Dashboard::init($this->logger);
            $this->settings = \MyPlugin\Admin\Settings::get_instance();
            $this->settings->init();
        } else {
            \MyPlugin\Public\Frontend::init($this->logger);
        }
    }

    public function create_log_table(): void {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'my_plugin_logs';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            log_date datetime NOT NULL,
            action varchar(100) NOT NULL,
            message text NOT NULL,
            user_id bigint(20) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    public function get_logger(): Logger {
        return $this->logger;
    }

    private function __clone() {}
}