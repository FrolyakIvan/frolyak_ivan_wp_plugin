<?php
/**
 * Plugin Name: Frolyak Ivan WP Plugin
 * Description: Fetches data from external API and shows a HTML table of users when a custom-endpoint is visited.
 * Version: 1.0.0
 * Author: Ivan Frolyak Ostrovskyy
 * License: MIT
 */

namespace Frolyak\FrolyakIvanWpPlugin;

// If Composer is used, autoload classes<
if (is_readable(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}


define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_DIR', plugin_dir_path(__FILE__));

$init = new FrolyakIvanWpPlugin();

register_activation_hook(__FILE__, [$init, 'activate']);
register_deactivation_hook(__FILE__, [$init, 'deactivate']);