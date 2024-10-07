<?php

/**
 *
 * @link             http://kitestudio.co/
 * @since             1.0.0
 * @package           kite core
 *
 * @wordpress-plugin
 * Plugin Name:       KiteStudio Core
 * Description:       kitestudio core plugin that adds shortcodes, widgets, post-types, etc. to kitestudio themes
 * Version:           2.8.3
 * Author:            KiteStudio
 * Author URI:        http://kitestudio.co/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kitestudio-core
 * Domain Path:       /languages
 * WC tested up to:   9.0.2
 * Elementor tested up to: 3.22.3
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'KITE_CORE_VER', '2.8.3' );
define( 'KITE_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'KITE_CORE_URL', plugin_dir_url( __FILE__ ) );

if ( isset( $_POST['kt-importer'] ) ) {
	if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
		define( 'WP_LOAD_IMPORTERS', true );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kt-core-activator.php
 */
function activate_kitestudio_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kt-core-activator.php';
	Kite_Core_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kt-core-deactivator.php
 */
function deactivate_kitestudio_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kt-core-deactivator.php';
	Kite_Core_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_kitestudio_core' );
register_deactivation_hook( __FILE__, 'deactivate_kitestudio_core' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-kt-core.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kitestudio_core() {

	$plugin = new Kite_Core();
	$plugin->run();

}
$kite_theme    = wp_get_theme();
$kite_products = array(
	'pinkmart',
	'pinkmart Child',
	'pinkmart lite',
	'pinkmart lite Child',
	'teta',
	'teta Child',
	'teta lite',
	'teta lite Child',
);
if ( in_array( $kite_theme->get( 'Name' ), $kite_products ) ) {
		run_kitestudio_core();
}
