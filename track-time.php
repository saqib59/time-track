<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link    https://github.com/saqib59
 * @since   1.0.0
 * @package Track_Time
 *
 * @wordpress-plugin
 * Plugin Name:       Track Time
 * Plugin URI:        https://github.com/saqib59/time-track
 * Description:       A WordPress plugin to track time spent on defined pages.
 * Version:           1.0.0
 * Author:            Saqib Ali
 * Author URI:        https://github.com/saqib59/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       track-time
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC') ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('TRACK_TIME_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-track-time-activator.php
 */
function activate_track_time()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-track-time-activator.php';
    Track_Time_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-track-time-deactivator.php
 */
function deactivate_track_time()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-track-time-deactivator.php';
    Track_Time_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_track_time');
register_deactivation_hook(__FILE__, 'deactivate_track_time');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-track-time.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_track_time()
{
    $plugin = new Track_Time();
    $plugin->run();
}
run_track_time();
