<?php
namespace IdyFaqBuilder;

final class Logger {
    private static $instance = null;
    private $table_name;

    public static function get_instance(): self {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'idy-faq-builder-logs';
    }

    public function log(string $action, string $message): void {
        global $wpdb;
        
        $user_id = get_current_user_id();
        $user_id = $user_id ?: 0; // Default to 0 if no user
        
        $wpdb->insert(
            $this->table_name,
            [
                'log_date' => current_time('mysql'),
                'action' => $action,
                'message' => $message,
                'user_id' => $user_id
            ],
            ['%s', '%s', '%s', '%d']
        );
    }

    public function get_logs(int $limit = 10): array {
        global $wpdb;
        
        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_name} ORDER BY log_date DESC LIMIT %d",
                $limit
            ),
            ARRAY_A
        );
    }

    private function __clone() {}
}