<?php
/**
 * Plugin Name:     idy faq builder
 * Plugin URI:      https://github.com/yourusername/wp-idy-faq-builder
 * Description:     Professional WordPress plugin skeleton with DB logger
 * Version:         1.0.0
 * Author:          Your Name
 * License:         GPL-2.0+
 * Text Domain:     idy-faq-builder
 * Namespace:       IdyFaqBuilder
 */

defined('ABSPATH') || exit;
if (!defined('IDECHY_FAQ_PATH')) {
    define('IDECHY_FAQ_PATH', plugin_dir_path(__FILE__));
}

if (!defined('IDECHY_FAQ_URL')) {
    define('IDECHY_FAQ_URL', plugin_dir_url(__FILE__));
}
// Define core constants
define('MY_PLUGIN_VERSION', '1.0.0');
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('MY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('MY_PLUGIN_SLUG', 'idy-faq-builder');

// Autoloader via Composer
require_once MY_PLUGIN_PATH . 'vendor/autoload.php';


// Register activation hook
register_activation_hook(__FILE__, function() {
    require_once MY_PLUGIN_PATH . 'src/Core.php';
    $core = \IdyFaqBuilder\Core::get_instance();
    $core->global_activation();
});

// Initialize plugin
add_action('plugins_loaded', function() {
    $core = \IdyFaqBuilder\Core::get_instance();
    $core->init();
    // Create logger table on activation
});

