<?php

/**
* @link              https://dorko.tv
* @since             1.0.0
* @package           Simple_Membership_Stats
*
* @wordpress-plugin
* Plugin Name:       Simple Membership Stats
* Plugin URI:        https://www.annedorko.com/plugins/simple-membership-stats
* Description:       A simple plugin offering access to member statistics for the Simple Membership plugin.
* Version:           1.0.0
* Author:            Anne Dorko
* Author URI:        https://www.annedorko.com/
* License:           GPL-2.0+
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
* Text Domain:       simple-membership-stats
* Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SIMPLE_MEMBERSHIP_STATS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-membership-stats-activator.php
 */
function activate_simple_membership_stats() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-membership-stats-activator.php';
	Simple_Membership_Stats_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-membership-stats-deactivator.php
 */
function deactivate_simple_membership_stats() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-membership-stats-deactivator.php';
	Simple_Membership_Stats_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_membership_stats' );
register_deactivation_hook( __FILE__, 'deactivate_simple_membership_stats' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-membership-stats.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simple_membership_stats() {

	$plugin = new Simple_Membership_Stats();
	$plugin->run();

}
run_simple_membership_stats();
