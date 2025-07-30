<?php
if (!defined('WP_UNINSTALL_PLUGIN') || !current_user_can('delete_plugins')) {
    exit;
}

global $wpdb;

// Delete settings
delete_option('my_plugin_settings');

// Drop log table
$table_name = $wpdb->prefix . 'idy-faq-builder-logs';
$wpdb->query("DROP TABLE IF EXISTS $table_name");