Clone or download the ZIP:
git clone https://github.com/hamedzargar/wp-idy-faq-builder.git

-----------------------------------------------------------------------

Renaming Process:
# 1. Rename main file
mv plugin-name.php your-plugin.php

# 2. Replace text domain (in all files)
find . -type f -exec sed -i 's/idy-faq-builder/your-plugin/g' {} +

# 3. Replace namespace (in all files)
find . -type f -exec sed -i 's/IdyFaqBuilder/YourPlugin/g' {} +

also replace idy-faq-builder-logs with your_plugin_logs

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
\IdyFaqBuilder\Core::get_instance()
    ->get_logger()
    ->log('custom_action', 'Your log message');

-----------------------------------------------------------------------

Add New Settings
Edit src/Admin/Settings.php:

public function register_settings() {
    add_settings_field(
        'new_field',
        __('New Field Label', 'idy-faq-builder'),
        [$this, 'render_new_field'],  // Callback function
        'idy-faq-builder-settings',   // Page slug
        'main_section'                // Section
    );
}

