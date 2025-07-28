Clone or download the ZIP:
git clone https://github.com/hamedzargar/wp-plugin-skeleton.git

-----------------------------------------------------------------------

Renaming Process:
# 1. Rename main file
mv plugin-name.php your-plugin.php

# 2. Replace text domain (in all files)
find . -type f -exec sed -i 's/plugin-skeleton/your-plugin/g' {} +

# 3. Replace namespace (in all files)
find . -type f -exec sed -i 's/MyPlugin/YourPlugin/g' {} +

also replace my_plugin_logs with your_plugin_logs

Update composer.json
{
    "autoload": {
        "psr-4": {
            "YourPlugin\\": "src/"  // Match your new namespace
        }
    }
}

-----------------------------------------------------------------------

Finally: Install Dependencies
composer install

If renamed after composer install:
composer dump-autoload

-----------------------------------------------------------------------

Add Custom Logs
\MyPlugin\Core::get_instance()
    ->get_logger()
    ->log('custom_action', 'Your log message');

-----------------------------------------------------------------------

Add New Settings
Edit src/Admin/Settings.php:

public function register_settings() {
    add_settings_field(
        'new_field',
        __('New Field Label', 'plugin-skeleton'),
        [$this, 'render_new_field'],  // Callback function
        'plugin-skeleton-settings',   // Page slug
        'main_section'                // Section
    );
}

