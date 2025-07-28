<?php
if (!defined('WP_UNINSTALL_PLUGIN') || !current_user_can('delete_plugins')) {
    exit;
}

global $wpdb;

// Delete settings
delete_option('my_plugin_settings');

// Drop log table
$table_name = $wpdb->prefix . 'my_plugin_logs';
$wpdb->query("DROP TABLE IF EXISTS $table_name");