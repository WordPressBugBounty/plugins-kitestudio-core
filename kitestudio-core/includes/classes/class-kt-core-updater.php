<?php
namespace KiteStudioCore;

class Updater {

	public $kite_api_url = 'https://api.kitestudio.co/v1'; // base URL to kitestudio api
	public $wp_filesystem;
	public $site_addr;

	/**c
	 * Holds the current instance of the plugins handler
	 *
	 */
	protected static $instance = null;

	/**
	 * Retrieves class instance
	 *
	 * @return Kite_Plugins_Handler
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Constructor
	 */
	public function __construct() {

		$this->set_site_addr();
		global $wp_filesystem;
		if ( $wp_filesystem == null ) {
			WP_Filesystem();
		}
		$this->wp_filesystem = $wp_filesystem;
	}

	/**
	 * Set site address
	 */
	public function set_site_addr() {
		$this->site_addr = urlencode( get_option( 'siteurl' ) );
	}

	/**
	 * General purpose function to query the Envato API.
	 *
	 * @param string $url The url to access, via curl.
	 * @return array|false The results of the curl request.
	 */
	public function curl( $url, $args, $extra_args = []) {

		if ( empty( $url ) ) {
			return false;
		}

		if ( empty( $args ) ) {
			$args = array();
		}

		global $wp_version;
		$args['timeout']   = 1000;
		$args['sslverify'] = false;

		$default_headers = array(
			'user-agent'    => 'WordPress/' . $wp_version . '; ' . get_site_url(),
			'product-slug'  => KITE_THEME_SLUG,
			'product-id'    => KITE_PRODUCT_ID,
			'Cache-Control' => 'no-cache',
		);

		$args['headers'] = isset( $args['headers'] ) ? array_merge( $args['headers'], $default_headers ) : $default_headers;

		$args = apply_filters( 'kite_modify_args_before_send_request', $args );

		$response = wp_remote_get( $url, $args );

		try {
			if ( ! is_wp_error( $response ) ) {
				if ( $response['response']['code'] == 200 ) {
					if ( $args['headers']['Content-type'] == 'application/json' && ! isset( $extra_args['demo_options'] ) ) {
						$json = json_decode( $response['body'], true );
					} else {
						$json = $response['body'];
					}
					$json = array(
						'status' => true,
						'body'   => $json,
					);
				} else {
					$json = array(
						'status'  => false,
						'message' => $response['response']['message'] . '. Error Code : ' . $response['response']['code'],
					);
				}
			} else {
				$json = array(
					'status'  => false,
					'message' => $response->get_error_message() . '<a href="https://support.kitestudio.co/knowledge-base/my-license-is-not-activating-what-can-i-do/">' . esc_html( 'What can I do ?' ) . '</a>',
				);
			}
		} catch ( Exception $e ) {
			$json = array(
				'status'  => false,
				'message' => 'null',
			);
		}

		return $json;
	}

	/**
	 * Download Dummy Data
	 */
	public function download_dummy_data() {

		if ( false == ( $demos = get_transient( 'kite_demos_list' ) ) || ( isset( $_GET['force-check'] ) && $_GET['force-check'] == '1' ) ) {
			$this->wp_filesystem->rmdir( WP_CONTENT_DIR . '/uploads/' . KITE_THEME_SLUG . '_demo', true );
			$site_addr = $this->site_addr;
			// the product id provided by kite
			$url     = apply_filters( 'kite_download_dummy_data_url', $this->kite_api_url . '/dummy/' . KITE_PRODUCT_ID );
			$headers = array(
				'headers' => array(
					'Content-length'   => '0',
					'Content-type'     => 'application/json',
					'Requested-domain' => $site_addr,
				),
			);
			$headers = apply_filters( 'kite_download_dummy_data_headers', $headers );

			$response = $this->curl( $url, $headers );
			if ( $response['status'] ) {
				if ( $response['body']['status'] ) {
					$demos = $response['body']['demos'];
					set_transient( 'kite_demos_list', $demos, 7 * 24 * 60 * 60 );
					return $demos;
				} else {
					echo esc_html( $response['body']['message'] );
					return;
				}
			} else {
				echo esc_html( $response['message'] );
				return;
			}
		} else {

			return $demos;
		}

	}

	public function download_files_to_host( $path = '', $file_name = '', $file_contents = '' ) {
		if ( $file_name == '' || $file_contents == '' ) {
			return false;
		}

		$demo_path = WP_CONTENT_DIR . '/uploads/' . KITE_THEME_SLUG . '_demo/' . $path . '/';
		if ( ! file_exists( $demo_path ) ) {
			wp_mkdir_p( $demo_path );
		}

		if ( file_exists( $demo_path . $file_name ) ) {
			return true;
		}

		if ( ! $this->wp_filesystem->put_contents( $demo_path . $file_name, $file_contents, FS_CHMOD_FILE ) ) {
			return false;
		} else {
			return true;
		}
	}

	public function kite_notice( $message, $status ) {
		echo '<div class="notice notice-' . esc_attr( $status ) . ' is-dismissible "><p>';
		echo wp_kses( $message, kite_allowed_html() );
		echo '</p></div>';
	}

	/**
	 * Getting Template Library Info
	 */
	public function get_templates_library() {
		if ( false == ( $templates = get_transient( 'kite_template_library_data' ) ) || ( isset( $_GET['force-check'] ) && $_GET['force-check'] == '1' ) ) {
			$this->wp_filesystem->rmdir( WP_CONTENT_DIR . '/uploads/' . KITE_THEME_SLUG . '_demo/template-library', true );
			$site_addr = $this->site_addr;

			$url     = apply_filters( 'kite_download_template_library_data_url', $this->kite_api_url . '/template-builder' );
			$headers = array(
				'headers' => array(
					'Content-length' => '0',
					'Content-type'   => 'application/json',
				),
			);
			$headers = apply_filters( 'kite_download_dummy_data_headers', $headers );

			$response = $this->curl( $url, $headers );
			if ( $response['status'] ) {
				set_transient( 'kite_template_library_data', $response['body']['templates'], 7 * 24 * 60 * 60 );
				return $response['body']['templates'];
			} else {
				echo esc_html( $response['message'] );
				return;
			}
		} else {

			return $templates;
		}
	}

	/**
	 * Getting Banners List
	 */
	public function get_banners_list() {
		if ( false == ( $banners = get_transient( 'kite_banners_list' ) ) || ( isset( $_GET['force-check'] ) && $_GET['force-check'] == '1' ) ) {

			$url     = $this->kite_api_url . '/banners';
			$headers = array(
				'headers' => array(
					'Content-length' => '0',
					'Content-type'   => 'application/json',
				),
			);
			$headers = apply_filters( 'kite_download_dummy_data_headers', $headers );

			$response = $this->curl( $url, $headers );
			if ( $response['status'] ) {
				set_transient( 'kite_banners_list', $response['body']['banners'], 2 * 24 * 60 * 60 );
				return $response['body']['banners'];
			} else {
				return;
			}
		} else {

			return $banners;
		}
	}

	/**
	 * generate support page
	 */
	public function support_page() {
		$this->header_page_section();
		?>
		<div class='kt-support-page'>
			<h1><?php esc_html_e( 'Help and Support', 'kitestudio-core' ); ?></h1>
			<p>
			<?php
			esc_html_e(
				'This theme comes with 6 months item support from purchase date (with the option to extend this period).
                This license allows you to use this theme on a single website. Please purchase an additional license to
                use this theme on another website.',
				'kitestudio-core'
			);
			?>
				</p>
			<p><?php echo sprintf( esc_html__( 'Item Support can be accessed from %s and includes: ', 'kitestudio-core' ), '<a href = "https://support.kitestudio.co" target = "_blank" > https:// support.kitestudio.co </a>' ); ?></p>
			<ul class="kt-supports-item">
				<li><?php esc_html_e( 'Availability of the author to answer questions', 'kitestudio-core' ); ?></li>
				<li><?php esc_html_e( 'Answering technical questions about item features', 'kitestudio-core' ); ?></li>
				<li><?php esc_html_e( 'Assistance with reported bugs and issues', 'kitestudio-core' ); ?></li>
				<li><?php esc_html_e( 'Help with bundled 3rd party plugins', 'kitestudio-core' ); ?></li>
			</ul>
			<p><?php echo sprintf( esc_html__( 'More details about item support can be found in the ThemeForest %s.', 'kitestudio-core' ), '<a href="http://themeforest.net/page/item_support_policy" target="_blank">Item Support Policy</a>' ); ?></p>
		</div>
		<?php
		$this->footer_page_section();
	}
}

?>
