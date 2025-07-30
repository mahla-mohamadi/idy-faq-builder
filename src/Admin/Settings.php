<?php
namespace IdyFaqBuilder\Admin;

use IdyFaqBuilder\Logger;

final class Settings {
    private static $instance = null;
    private $logger;
    private $option_name = 'my_plugin_settings';

    public static function get_instance(): self {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->logger = \IdyFaqBuilder\Core::get_instance()->get_logger();
    }

    public function init(): void {
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_settings(): void {
        register_setting(
            'my_plugin_settings_group',
            $this->option_name,
            [$this, 'sanitize_settings']
        );

        add_settings_section(
            'main_section',
            __('Main Settings', 'idy-faq-builder'),
            [$this, 'render_section_header'],
            MY_PLUGIN_SLUG . '-settings'
        );

        add_settings_field(
            'example_text',
            __('Example Text', 'idy-faq-builder'),
            [$this, 'render_text_field'],
            MY_PLUGIN_SLUG . '-settings',
            'main_section'
        );
    }

    public function render_settings_page(): void {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Get recent logs
        $logs = $this->logger->get_logs(5);
        
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <form method="post" action="options.php">
                <?php
                settings_fields('my_plugin_settings_group');
                do_settings_sections(MY_PLUGIN_SLUG . '-settings');
                submit_button(__('Save Settings', 'idy-faq-builder'));
                ?>
            </form>
            
            <div class="my-plugin-logs">
                <h2><?php esc_html_e('Recent Activity', 'idy-faq-builder'); ?></h2>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Date', 'idy-faq-builder'); ?></th>
                            <th><?php esc_html_e('Action', 'idy-faq-builder'); ?></th>
                            <th><?php esc_html_e('Message', 'idy-faq-builder'); ?></th>
                            <th><?php esc_html_e('User', 'idy-faq-builder'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?php echo esc_html($log['log_date']); ?></td>
                            <td><?php echo esc_html($log['action']); ?></td>
                            <td><?php echo esc_html($log['message']); ?></td>
                            <td>
                                <?php 
                                $user = get_user_by('id', $log['user_id']);
                                echo $user ? esc_html($user->display_name) : __('System', 'idy-faq-builder');
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

    public function render_section_header(): void {
        echo '<p>' . esc_html__('Configure the basic settings.', 'idy-faq-builder') . '</p>';
    }

    public function render_text_field(): void {
        $options = get_option($this->option_name);
        $value = $options['example_text'] ?? '';
        ?>
        <input type="text" 
               name="<?php echo esc_attr($this->option_name); ?>[example_text]" 
               value="<?php echo esc_attr($value); ?>" 
               class="regular-text">
        <?php
    }

    public function sanitize_settings(array $input): array {
        $sanitized = [];
        
        if (isset($input['example_text'])) {
            $sanitized['example_text'] = sanitize_text_field($input['example_text']);
            
            // Log the setting change
            $this->logger->log(
                'settings_update', 
                sprintf('Setting changed from "%s" to "%s"', 
                    get_option($this->option_name)['example_text'] ?? '',
                    $sanitized['example_text']
                )
            );
        }
        
        return $sanitized;
    }

    private function __clone() {}
}