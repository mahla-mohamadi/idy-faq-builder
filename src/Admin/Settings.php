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
        add_settings_field(
            'faq_section_title',
            __('FAQ Section Title', 'idy-faq-builder'),
            [$this, 'render_section_title_field'],
            MY_PLUGIN_SLUG . '-settings',
            'main_section'
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
        // Add color picker field
        add_settings_field(
            'faq_primary_color',
            __('Primary Color', 'idy-faq-builder'),
            [$this, 'render_color_field'],
            MY_PLUGIN_SLUG . '-settings',
            'main_section'
        );
        add_settings_field(
            'faq_bg_color',
            __('FAQ Background Color', 'idy-faq-builder'),
            [$this, 'render_bg_color_field'],
            MY_PLUGIN_SLUG . '-settings',
            'main_section'
        );
        // Add template selection field
        add_settings_field(
            'faq_template',
            __('FAQ Display Template', 'idy-faq-builder'),
            [$this, 'render_template_field'],
            MY_PLUGIN_SLUG . '-settings',
            'main_section'
        );
    }
    // Add this new method to render the field:
    public function render_section_title_field(): void {
        $options = get_option($this->option_name);
        $title = $options['faq_section_title'] ?? __('Frequently Asked Questions', 'idy-faq-builder');
        ?>
        <input type="text" 
            name="<?php echo esc_attr($this->option_name); ?>[faq_section_title]" 
            value="<?php echo esc_attr($title); ?>" 
            class="regular-text">
        <?php
    }
    public function render_bg_color_field(): void {
        $options = get_option($this->option_name);
        $color = $options['faq_bg_color'] ?? '#ffffff'; // Default white
        ?>
        <input type="text" 
            name="<?php echo esc_attr($this->option_name); ?>[faq_bg_color]" 
            value="<?php echo esc_attr($color); ?>" 
            class="color-picker">
        <?php
    }
    public function render_color_field(): void {
        $options = get_option($this->option_name);
        $color = $options['faq_primary_color'] ?? '#03b5d2'; // Default color
        ?>
        <input type="text" 
            name="<?php echo esc_attr($this->option_name); ?>[faq_primary_color]" 
            value="<?php echo esc_attr($color); ?>" 
            class="color-picker">
        <?php
    }
    public function render_template_field(): void {
        $options = get_option($this->option_name);
        $selected = $options['faq_template'] ?? 'default';
        ?>
        <select name="<?php echo esc_attr($this->option_name); ?>[faq_template]" class="regular-text">
            <option value="default" <?php selected($selected, 'default'); ?>><?php _e('Default Template', 'idy-faq-builder'); ?></option>
            <option value="style1" <?php selected($selected, 'style1'); ?>><?php _e('Style 1', 'idy-faq-builder'); ?></option>
            <option value="style2" <?php selected($selected, 'style2'); ?>><?php _e('Style 2', 'idy-faq-builder'); ?></option>
            <option value="style3" <?php selected($selected, 'style3'); ?>><?php _e('Style 3', 'idy-faq-builder'); ?></option>
        </select>
        <?php
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
        }
        
        if (isset($input['faq_template'])) {
            $allowed_templates = ['default', 'style1', 'style2', 'style3'];
            $sanitized['faq_template'] = in_array($input['faq_template'], $allowed_templates) 
                ? $input['faq_template'] 
                : 'default';
                
            $this->logger->log(
                'settings_update', 
                sprintf('FAQ template changed to "%s"', $sanitized['faq_template'])
            );
        }
        if (isset($input['faq_section_title'])) {
            $sanitized['faq_section_title'] = sanitize_text_field($input['faq_section_title']);
            
            $this->logger->log(
                'settings_update', 
                sprintf('FAQ section title changed to "%s"', $sanitized['faq_section_title'])
            );
        }
        if (isset($input['faq_primary_color'])) {
            $sanitized['faq_primary_color'] = sanitize_hex_color($input['faq_primary_color']);
            
            $this->logger->log(
                'settings_update', 
                sprintf('FAQ primary color changed to "%s"', $sanitized['faq_primary_color'])
            );
        }
        if (isset($input['faq_bg_color'])) {
            $sanitized['faq_bg_color'] = sanitize_hex_color($input['faq_bg_color']);
            
            $this->logger->log(
                'settings_update', 
                sprintf('FAQ background color changed to "%s"', $sanitized['faq_bg_color'])
            );
        }
        return $sanitized;
    }
    private function __clone() {}
}