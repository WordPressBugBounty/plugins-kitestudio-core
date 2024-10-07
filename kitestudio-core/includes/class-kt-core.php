<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link      http://kitestudio.co/
 * @since      1.0.0
 *
 * @package    Kite_Core
 * @subpackage Kite_Core/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Kite_Core
 * @subpackage Kite_Core/includes
 * @author     KiteStudio <help.kitestudio@gmail.com>
 */
class Kite_Core {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Kite_Core_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'kitestudio-core';
		$this->version     = KITE_CORE_VER;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Kite_Core_Loader. Orchestrates the hooks of the plugin.
	 * - Kite_Core_i18n. Defines internationalization functionality.
	 * - Kite_Core_Admin. Defines all hooks for the admin area.
	 * - Kite_Core_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-kt-core-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-kt-core-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-kt-core-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-kt-core-public.php';

		/**
		 * This class is responsible for providing color functionalities
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-kt-core-color-handler.php';

		/**
		 * This class is responsible for registering widgets
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-kt-register-widgets.php';

		/**
		 * This class is responsible for registering custom post types
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-kt-register-post-type.php';

		/**
		 * This class is responsible for update and downloading dummy datas
		 *
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-kt-core-updater.php';

		/**
		 * This class is responsible for generating Dashboard
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-kt-core-dashboard.php';

		/**
		 * This class is responsible for generating Dashboard
		 * 
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-kt-core-remote.php';

		/**
		 * This class is responsible for generating Dashboard
		 * 
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-kt-core-media.php';

		/**
		 * This class is responsible for Installing Demos
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-kt-demo-installer.php';

		/**
		 * This class is responsible for handling woocommerce functionalities
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-kt-woocommerce.php';

		/**
		 * This class is responsible for handling instagram requests
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-kt-instagram-api.php';

		/**
		 * This class is responsible for registering widgets
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-kt-element-id-generator.php';

		/**
		 * This file is responsible for handling deprecated functions or constants
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/deprecated.php';

		/**
		 * This file is responsible for adding functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions.php';

		/**
		 * This file is responsible for adding general hooks
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/general-hooks.php';

		/**
		 * aq resizer plugin
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/aq_resizer.php';

		/**
		 * Plugins Compatibility
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/compatibility/compatibility.php';

		$this->loader = Kite_Core_Loader::get_instance();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Kite_Core_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Kite_Core_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Kite_Core_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'load_kt_import' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_enqueue_media', $plugin_admin, 'enqueue_media_scripts' );
		$this->loader->add_action( 'elementor/editor/after_enqueue_scripts', $plugin_admin, 'enqueue_elementor_editor_scritps' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'add_banners' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'check_latest_themes');

		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'load_shortcodes' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Kite_Core_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'load_dependencies' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Kite_Core_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
