<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://kitestudio.co/
 * @since      1.0.0
 *
 * @package    Kite_Core
 * @subpackage Kite_Core/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kite_Core
 * @subpackage Kite_Core/admin
 * @author     KiteStudio <info@kitestudio.co>
 */
class Kite_Core_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->load_dashboard();

		if ( ! has_action( 'kite_wc_register_taxonomy_before_import' ) ) {
			add_action( 'kite_wc_register_taxonomy_before_import', array( $this, 'register_WC_taxonomy_before_import' ) );
		}

		KiteStudioCore\Media::get_instance();

	}

	/**
	 * Load Kitestudio admin dashboard
	 */
	public function load_dashboard() {
		KiteStudioCore\Dashboard::get_instance();
	}

	/**
	 * Register the stylesheets for the admin area.
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
		wp_enqueue_style( 'iziModal', plugin_dir_url( __FILE__ ) . 'css/iziModal.min.css', array(), '1.6.0', 'all' );
		wp_enqueue_style( 'iziToast', plugin_dir_url( __FILE__ ) . 'css/iziToast.min.css', array(), '1.4.0', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kt-core-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_register_script( 'iziModal', plugin_dir_url( __FILE__ ) . 'js/iziModal.min.js', array( 'jquery' ), '1.6.0', false );
		wp_register_script( 'iziToast', plugin_dir_url( __FILE__ ) . 'js/iziToast.min.js', array( 'jquery' ), '1.4.0', false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kt-core-admin.js', array( 'jquery', 'iziModal', 'iziToast' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name,
			'kitestudio_vars',
			array(
				// ajax variables
				'ajax_url'        => esc_url( admin_url( 'admin-ajax.php' ) ),
				'install_plugin'  => esc_html__( 'Installing Plugin', 'kitestudio-core' ),
				'activate_plugin' => esc_html__( 'Activating Plugin', 'kitestudio-core' ),
				'update_plugin'   => esc_html__( 'Updating Plugin', 'kitestudio-core' ),
				'fail'            => esc_html__( 'Failed', 'kitestudio-core' ),
				'success'         => esc_html__( 'Succeed', 'kitestudio-core' ),
			)
		);

	}

	/**
	 * enqueue media refresher
	 *
	 * @return void
	 */
	public function enqueue_media_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/media-refresh.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Enqueue scripts in elementor editor screeen
	 *
	 * @return void
	 */
	public function enqueue_elementor_editor_scritps() {
		wp_enqueue_script( 'kt-elementor-editor', plugin_dir_url( __FILE__ ) . 'js/editor.js', array( 'jquery' ), $this->version, false );
	}

	public function register_WC_taxonomy_before_import( $term_domain ) {
		register_taxonomy(
			$term_domain,
			apply_filters( 'woocommerce_taxonomy_objects_' . $term_domain, array( 'product' ) ),
			apply_filters(
				'woocommerce_taxonomy_args_' . $term_domain,
				array(
					'hierarchical' => true,
					'show_ui'      => false,
					'query_var'    => true,
					'rewrite'      => false,
				)
			)
		);
	}

	/**
	 * Load shortcodes
	 *
	 * @since    1.0.0
	 */
	public function load_shortcodes() {

		if ( ! class_exists( 'Kite_Shortcodes' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shortcodes.php';
		}

	}

	public function load_kt_import() {
		/**
		 * The class responsible demo import jobs
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-kt-import.php';
	}

	public function add_banners() {
		$banners = \KiteStudioCore\Updater::get_instance()->get_banners_list();
		if ( ! empty( $banners ) ) {
			foreach ( $banners as $banner ) {
				$start_date   = strtotime( $banner['meta']['start_date'] );
				$end_date     = ! empty( $banner['meta']['end_date'] ) ? strtotime( $banner['meta']['end_date'] ) : '';
				$current_date = strtotime( 'now' );
				if ( $banner['meta']['banner_type'] != 'notice' || $current_date < $start_date || empty( $end_date ) || $end_date < $current_date ) {
					continue;
				}
				?>
				<div class="notice notice-info is-dismissible">
					<a href="<?php echo esc_url( $banner['meta']['link'] ); ?>" target="_blank">
						<img src="<?php echo esc_url( $banner['meta']['featured_image'] ); ?>" alt="">
					</a>
				</div>
				<?php
			}
		}
	}


	/**
	 * Check if latest theme installed or not
	 *
	 * @return void
	 */
	public function check_latest_themes() {
		if ( !defined( 'KITE_THEME_SLUG' ) ) {
			return;
		}

		$update_theme = false;
		$required_theme_version = '1.0.0';
		if ( KITE_THEME_SLUG == 'teta' && version_compare( KITE_THEME_VERSION, '3.0.0', '<' ) ) {
			$update_theme = true;
			$required_theme_version = '3.0.0';
		}

		if ( KITE_THEME_SLUG == 'teta-lite' && version_compare( KITE_THEME_VERSION, '2.6.0', '<' ) ) {
			$update_theme = true;
			$required_theme_version = '2.6.0';
		}
	
		if ( KITE_THEME_SLUG == 'pinkmart' && version_compare( KITE_THEME_VERSION, '4.0.0', '<' ) ) {
			$update_theme = true;
			$required_theme_version = '4.0.0';
		}
	
		if ( $update_theme ) {
		?>
		<div class="notice notice-warning">
			<p>
			<?php echo sprintf( esc_html__( 'To have best experience with this version of kitestudio core, we highly recommend update theme to version %s.', 'kitestudio-core' ), $required_theme_version ); ?>
			</p>
			<a href="<?php echo admin_url( 'update-core.php' );?>" class='button button-primary'><?php echo sprintf( esc_html__( 'Update %s theme', 'kitestudio-core' ), KITE_THEME_MAIN_NAME );?></a>
			<p></p>
		</div>
		<?php
		}
	}
	
}
