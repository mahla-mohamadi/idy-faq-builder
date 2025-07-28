<?php
/**
 * Plugin Name:     Plugin Skeleton
 * Plugin URI:      https://github.com/yourusername/wp-plugin-skeleton
 * Description:     Professional WordPress plugin skeleton with DB logger
 * Version:         1.0.0
 * Author:          Your Name
 * License:         GPL-2.0+
 * Text Domain:     plugin-skeleton
 * Namespace:       MyPlugin
 */

defined('ABSPATH') || exit;

// Define core constants
define('MY_PLUGIN_VERSION', '1.0.0');
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('MY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('MY_PLUGIN_SLUG', 'plugin-skeleton');

// Autoloader via Composer
require_once MY_PLUGIN_PATH . 'vendor/autoload.php';

// Initialize plugin
add_action('plugins_loaded', function() {
    $core = \MyPlugin\Core::get_instance();
    $core->init();
    
    // Create logger table on activation
    register_activation_hook(__FILE__, [$core, 'create_log_table']);
});