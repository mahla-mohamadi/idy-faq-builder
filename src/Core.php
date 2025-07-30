<?php
namespace IdyFaqBuilder;

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
        if (is_admin()) {
            \IdyFaqBuilder\Metabox\FaqBuilder::init($this->logger);
            \IdyFaqBuilder\Admin\Dashboard::init($this->logger);
            $this->settings = \IdyFaqBuilder\Admin\Settings::get_instance();
            $this->settings->init();
        } else {
            \IdyFaqBuilder\Public\Frontend::init($this->logger);
        }
    }

    public function create_log_table(): void {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'idy-faq-builder-logs';
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
    public function global_activation(): void{
        if (!current_user_can('activate_plugins')) {
            return;
        }
        $instance = self::get_instance();
        $instance->create_log_table();
    }
    public function get_logger(): Logger {
        return $this->logger;
    }

    private function __clone() {}
}