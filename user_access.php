<?php

/**
 *
 * Plugin Name:       用户访问服务
 * Plugin URI:
 * Description:       统计用户浏览记录
 * Version:           1.0.0
 * Author:            l3n641
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('PLUGIN_USER_ACCESS_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_custom_plugin()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-plugin-activator.php';
    Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_custom_plugin()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-plugin-deactivator.php';
    Plugin_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_custom_plugin');
register_deactivation_hook(__FILE__, 'deactivate_custom_plugin');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin()
{

    $api_domain = "";
    $plugin = new PluginUserAccess($api_domain);
    $plugin->run();

}

run_plugin();
