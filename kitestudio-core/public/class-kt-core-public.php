<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://kitestudio.co/
 * @since      1.0.0
 *
 * @package    Kite_Core
 * @subpackage Kite_Core/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kite_Core
 * @subpackage Kite_Core/public
 * @author     KiteStudio <help.kitestudio@gmail.com>
 */
class Kite_Core_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		// Use shortcodes in text widgets.
		add_filter( 'widget_text', 'do_shortcode' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kite_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kite_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kt-core-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kite_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kite_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kt-core-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Load Dependencies
	 *
	 * @return void
	 *
	 * @since 1.7.0
	 */
	public function load_dependencies() {

		//todo: check constant prefix => pinkmart compatibility => remove these lines
		$prefix        = defined( 'KITE_THEME_MAIN_NAME' ) ? 'KITE_' : 'KITEST_';
		$theme_version = constant( $prefix . 'THEME_VERSION' );
		$theme_slug = strtolower( constant( $prefix . 'THEME_MAIN_NAME' ) );
		if ( $theme_slug == 'pinkmart' && version_compare( $theme_version, '3.0.5', '>=' ) || $theme_slug == 'teta' || $theme_slug == 'tienda' ) {

			// add woocommerce funcationalities
			Kite_Woocommerce::get_instance();

			/**
			 * This file is responsible for adding widgets
			 */
			require_once KITE_CORE_DIR . 'includes/elements/functions.php';

			/**
			 * This file is responsible for adding elementor widgets
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/elementor/functions.php';
		}
	}
}


