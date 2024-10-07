<?php
namespace KiteStudioCore;

use Kite_Plugins_Handler;
use RevSlider;
use Kite_Import;
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// include WordPress-importer plugin

class Demo_Installer {

	private $demos             = array();
	private $medias            = array();
	private $media_ids         = array();
	private $theme_data        = array();
	private $wc_placeholder_id = null;

	public function __construct() {
		add_action( 'import_post_meta', [ $this, 'kite_import_post_meta_data' ], 1, 3 );
	}

	/**
	 * Added to http_request_timeout filter to force timeout at 200 seconds during import
	 *
	 * @return int 500
	 */
	public function bump_request_timeout( $val ) {
		return 500;
	}


	public function importer_start() {
		add_filter( 'http_request_timeout', array( $this, 'bump_request_timeout' ) );
		?>
		<div id="kt-importer-box">
			<div class="box-title">
				<h2><?php esc_html_e( 'Importing', 'kitestudio-core' ); ?> </h2>
				<p><strong style="color:#e21010;"><?php esc_html_e( 'Notice! Do not close the browser during importing process', 'kitestudio-core' ); ?></strong></p>
			</div>
		<?php
		$demo_name = '';

		$this->demos = $demos = get_transient( 'kite_demos_list' );
		if ( isset( $_POST ) ) {
			$demo_name = sanitize_file_name( $_POST['demo_name'] );
		}
		if ( $demo_name == '' || ! in_array( $demo_name, array_keys( $this->demos ) ) ) {
			echo '<strong>' . esc_html__( 'Sorry, there has been an error!', 'kitestudio-core' ) . '</strong>';
			echo '<p>' . esc_html__( 'This demo doesn\'t exist.', 'kitestudio-core' ) . '</p>';
			return;

		} else {
			if ( $demos[ $demo_name ]['pro_state'] == 'pro' && ! kite_is_license_verified() ) {
				echo '<p>' . esc_html__( 'Product is not activated. To Import this demo please activate theme first!', 'kitestudio-core' ) . '</p>';
				return;
			}

			if ( ! version_compare( KITE_THEME_VERSION, $demos[ $demo_name ]['min_version'], '>=' ) ) {
				echo '<p>' . sprintf( esc_html__( 'This Demo needs minimum version of %s. To Import this demo please update your theme to latest version!', 'kitestudio-core' ), $demos[ $demo_name ]['min_version'] ) . '</p>';
				return;
			}
		}

		// Get the xml file from directory
		$import_xml_filepath         = $demos[ $demo_name ]['file'];
		$import_json_filepath        = $demos[ $demo_name ]['options'];
		$default_content_xml_filepath = $demos[ $demo_name ]['parent'];

		$files_loader = new Updater();
		$headers      = array( 'headers' => array( 'Content-type' => 'application/xml' ) );

		// default contents xml file
		if ( get_option( 'defaultContent', '' ) != 1 && ! is_file( WP_CONTENT_DIR . '/uploads/' . KITE_THEME_SLUG . '_demo/def_cont.xml' ) ) {

			$response = $files_loader->curl( $default_content_xml_filepath, $headers );
			if ( ! $response['status'] ) {
				echo esc_html__( 'something goes wrong. Error Message : ', 'kitestudio-core' ) . esc_html( $response['message'] );
			} else {
				if ( ! $files_loader->download_files_to_host( '', 'def_cont.xml', $response['body'] ) ) {
					echo esc_html__( "Default Content doesn't download", 'kitestudio-core' );
				}
			}
		}

		// pages xml file
		if ( ! is_file( WP_CONTENT_DIR . '/uploads/' . KITE_THEME_SLUG . '_demo/demo' . $demo_name . '/pages.xml' ) ) {
			$response = $files_loader->curl( $import_xml_filepath, $headers );
			if ( ! $response['status'] ) {
				echo esc_html__( 'something goes wrong. Error Message : ', 'kitestudio-core' ) . esc_html( $response['message'] );
			} else {
				if ( ! $files_loader->download_files_to_host( 'demo' . $demo_name, 'pages.xml', $response['body'] ) ) {
					echo esc_html__( "Demo pages doesn't download", 'kitestudio-core' );
				}
			}
		}

		// options json file
		if ( ! is_file( WP_CONTENT_DIR . '/uploads/' . KITE_THEME_SLUG . '_demo/demo' . $demo_name . '/options.json' ) ) {
			$headers                 = array( 'headers' => array( 'Content-type' => 'application/json' ) );
			$response                = $files_loader->curl( $import_json_filepath, $headers, [ 'demo_options' => true ] );
			if ( ! $response['status'] ) {
				echo esc_html__( 'something goes wrong. Error Message : ', 'kitestudio-core' ) . esc_html( $response['message'] );
			} else {
				if ( ! $files_loader->download_files_to_host( 'demo' . $demo_name, 'options.json', $response['body'] ) ) {
					echo esc_html__( "options file doesn't download", 'kitestudio-core' );
				}
			}
		}

		$import_xml_filepath         = WP_CONTENT_DIR . '/uploads/' . KITE_THEME_SLUG . '_demo/demo' . $demo_name . '/pages.xml';
		$default_content_xml_filepath = WP_CONTENT_DIR . '/uploads/' . KITE_THEME_SLUG . '_demo/def_cont.xml';
		$import_json_filepath        = WP_CONTENT_DIR . '/uploads/' . KITE_THEME_SLUG . '_demo/demo' . $demo_name . '/options.json';

		// Read theme options
		global $wp_filesystem;
		// Initialize the WP filesystem, no more using 'file-put-contents' function
		if ( empty( $wp_filesystem ) ) {
			WP_Filesystem();
		}

		if ( is_file( $import_json_filepath ) ) {
			$theme_options_json = $wp_filesystem->get_contents( $import_json_filepath );

			$this->theme_data = json_decode( $theme_options_json, true );
		} else {
			$this->theme_data = '';
		}

		/* Start the process of importing */
		ob_start();

		echo '<h3>' . esc_html__( 'Importing started', 'kitestudio-core' ) . '</h3>';
		wp_ob_end_flush_all();
		flush();
		// Import data
		$plugins      = Kite_Plugins_Handler::get_instance()->_get_plugins();
		$tgm_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		$required     = array_filter(
			$plugins['all'],
			function( $el ) {
				return $el['required'];
			}
		);
		foreach ( $required as $slug => $plugin ) {
			if ( ! $tgm_instance->plugin_active( $slug ) ) {
				echo '<p><strong>' . esc_html__( 'Demo import process needs all required plugins to be active. please active required plugins in plugins tab.', 'kitestudio-core' ) . '</strong>';
				wp_ob_end_flush_all();
				flush();
				die();
			}
		}

		echo '<p><strong>' . esc_html__( 'Step 1', 'kitestudio-core' ) . '</strong>' . esc_html__( ' : Importing Pages,post,products,menu ... ', 'kitestudio-core' );
		wp_ob_end_flush_all();
		flush();

		// import woocommerce placeholder image
		$this->import_wc_placeholder();

		if ( get_option( 'defaultContent', '' ) != 1 ) {
			$this->kite_import_data( $default_content_xml_filepath );
			update_option( 'defaultContent', 1 );

		}
		$this->kite_import_data( $import_xml_filepath );
		echo esc_html__( ' Done', 'kitestudio-core' ) . '</p>';
		wp_ob_end_flush_all();
		flush();

		// Import revolution slider
		echo '<p><strong>' . esc_html__( 'Step 2', 'kitestudio-core' ) . '</strong>' . esc_html__( ' : Importing Slider... ', 'kitestudio-core' );
		wp_ob_end_flush_all();
		flush();
		$this->kite_import_revslider( $demo_name );
		wp_ob_end_flush_all();
		flush();

		// Change shrotcodes options
		echo '<p><strong>' . esc_html__( 'Step 3', 'kitestudio-core' ) . '</strong>' . esc_html__( ' : Processing Shortcodes ... ', 'kitestudio-core' );
		wp_ob_end_flush_all();
		flush();
		$this->kite_process_shortcodes();
		echo esc_html__( ' Done', 'kitestudio-core' ) . '</p>';
		wp_ob_end_flush_all();
		flush();

		echo '<p><strong>' . esc_html__( 'Step 4', 'kitestudio-core' ) . '</strong>' . esc_html__( ' : Updating Styles ... ', 'kitestudio-core' );
		wp_ob_end_flush_all();
		flush();
		$this->kite_update_elementor_styles();
		echo esc_html__( ' Done', 'kitestudio-core' ) . '</p>';
		wp_ob_end_flush_all();
		flush();

		// Update theme options
		echo '<p><strong>' . esc_html__( 'Step 5', 'kitestudio-core' ) . '</strong>' . esc_html__( ' : Importing Theme options ... ', 'kitestudio-core' );
		wp_ob_end_flush_all();
		flush();
		$this->kite_set_theme_options();
		echo esc_html__( ' Done', 'kitestudio-core' ) . '</p>';
		wp_ob_end_flush_all();
		flush();

		// change some widget options + replace images with placeholders in widgets
		echo '<p><strong>' . esc_html__( 'Step 6', 'kitestudio-core' ) . '</strong>' . esc_html__( ' : Processing Widgets ... ', 'kitestudio-core' );
		wp_ob_end_flush_all();
		flush();
		$this->kite_process_widgets();
		echo esc_html__( ' Done', 'kitestudio-core' ) . '</p>';
		wp_ob_end_flush_all();
		flush();

		// Set Primary Navigation
		echo '<p><strong>' . esc_html__( 'Step 7', 'kitestudio-core' ) . '</strong>' . esc_html__( ' : Processing Menus ... ', 'kitestudio-core' );
		wp_ob_end_flush_all();
		flush();
		$this->kite_set_navigation_menu();
		echo esc_html__( ' Done', 'kitestudio-core' ) . '</p>';
		wp_ob_end_flush_all();
		flush();

		echo '<p><strong>' . esc_html__( 'Step 8', 'kitestudio-core' ) . '</strong>' . esc_html__( ' : Checking imported demo ... ', 'kitestudio-core' );
		wp_ob_end_flush_all();
		flush();
		$this->checking_imported_demo();
		echo esc_html__( ' Done', 'kitestudio-core' ) . '</p>';
		wp_ob_end_flush_all();
		flush();

		echo '<p><strong>' . esc_html__( 'Finished', 'kitestudio-core' ) . '</strong></p>';

		wp_ob_end_flush_all();
		flush();

		?>
		</div>
		<?php
	}

	public function kite_import_data( $import_xml_filepath ) {

		if ( ! class_exists( 'Kite_Import' ) ) {
			require_once KITE_CORE_DIR . 'includes/classes/class-kt-import.php';
		}

		$kite_import = new Kite_Import();

		$kite_import->fetch_attachments = true;

		$kite_import->import( $import_xml_filepath );

		$this->medias    = $kite_import->get_medias();
		$this->media_ids = $kite_import->get_media_ids();

	}

	public function kite_set_theme_options() {

		$media_url = wp_get_attachment_url( $this->media_ids[0] );

		$newsletter_form_id = -1;
		$newsletters        = kite_get_mailchimp_forms();
		foreach ( $newsletters as $id => $newslettername ) {
			if ( ! empty( $id ) ) {
				$newsletter_form_id = $id;
			}
		}
		$this->theme_data['options'] = stripslashes_deep( $this->theme_data['options'] );
		$pro_options                 = strpos( KITE_OPTIONS_KEY, '_lite_' ) ? str_replace( '_Lite', '', KITE_OPTIONS_KEY ) : '';
		foreach ( $this->theme_data['options'] as $key => $option_values ) {
			$option_values = maybe_unserialize( $option_values );
			if ( $key == KITE_OPTIONS_KEY || ( ! empty( $pro_options ) && $key == $pro_options ) ) {
				$options = array();
				if ( ! empty( $option_values ) ) :
					foreach ( $option_values as $optionkey => $option_value ) {
						$option_value          = str_replace( 'KITE_DEMO_IMAGE', $this->medias[0], $option_value );
						$option_value          = str_replace( 'KITE_DEMO_NEWSLETTER_ID', $newsletter_form_id, $option_value );
						$options[ $optionkey ] = $option_value;
					}
					$options['logo']['url']           = KITE_THEME_ASSETS_URI . '/content/img/logo.svg';
					$options['logo-second']['url']    = $options['logo']['url'];
					$options['responsivelogo']['url'] = $options['logo']['url'];
					$options['footerlogo']['url']     = KITE_THEME_ASSETS_URI . '/content/img/footerlogo.png';
					$options['favicon']['url']        = KITE_THEME_ASSETS_URI . '/img/favicon.png';
					$options['login-logo']['url']     = KITE_THEME_ASSETS_URI . '/content/img/logo.svg';

					// change the url and id of imported media used in theme settings
					$media_settings = array(
						'payment_methods_image',
						'popupNewsLetterBackgroundImage',
						'Header_PromoBar_BgImage',
						'preloader-logo',
					);
					foreach ( $media_settings as $setting_id ) {

						if ( empty( $options[ $setting_id ] ) ) {
							continue;
						}

						if ( false != $new_media_id = get_transient( 'kite_impoted_post_' . $options[ $setting_id ]['id'] ) ) {
							$options[ $setting_id ]['id']  = $new_media_id;
							$options[ $setting_id ]['url'] = wp_get_attachment_url( $new_media_id );
						}
					}

					$options['Header_PromoBar_Link'] = '#';

					if ( ! empty( $options['elementor_header_template_id'] ) ) {
						$options['elementor_header_template_id'] = ( false != $header_template_id = get_transient( 'kite_imported_post_' . $options['elementor_header_template_id'] ) ) ? $header_template_id : $options['elementor_header_template_id'];
					}
					if ( ! empty( $options['elementor_footer_template_id'] ) ) {
						$options['elementor_footer_template_id'] = ( false != $footer_template_id = get_transient( 'kite_imported_post_' . $options['elementor_footer_template_id'] ) ) ? $footer_template_id : $options['elementor_footer_template_id'];
					}

					// set mailchimp default form for popup newsletter
					if ( ! empty( $options['popupNewsLetterShortcode'] ) ) {
						$options['popupNewsLetterShortcode'] = '[mc4wp_form id="' . $newsletter_form_id . '"]';
					}

				endif;

				update_option( $key, $options );
			} else {
				if ( $key == 'mc4wp_default_form_id' ) {
					$option_values = str_replace( 'KITE_DEMO_NEWSLETTER_ID', $newsletter_form_id, $option_values );
				} elseif ( $key == 'elementor_active_kit' && ! empty( get_transient( 'kite_imported_post_' . $option_values ) ) ) {
					$option_values = get_transient( 'kite_imported_post_' . $option_values );
				}
				$option_values = is_string( $option_values ) ? str_replace( 'KITE_LOGO_URL', KITE_THEME_ASSETS_URI . '/content/img/logo.svg', $option_values ) : $option_values;
				update_option( $key, $option_values );
			}
		}

		global $wp_rewrite;

		//Write the rule
		$wp_rewrite->set_permalink_structure( '/%postname%/' );

		//Set the option
		update_option( 'rewrite_rules', false );

		//Flush the rules and tell it to write htaccess
		$wp_rewrite->flush_rules( true );

	}

	public function kite_process_shortcodes() {

		$all_categories_ids = array();
		$all_product_ids    = array();
		$cf7_form_id        = -1;
		$newsleter_form_id  = -1;
		$shop_url           = urlencode( get_permalink( wc_get_page_id( 'shop' ) ) );
		$cats_page_url      = esc_url( get_home_url() );
		$shop_page_url      = get_permalink( wc_get_page_id( 'shop' ) );

		// prepare information for category shortcodes
		$args           = array(
			'taxonomy'     => 'product_cat',
			'orderby'      => 'name',
			'show_count'   => 0,
			'pad_counts'   => 0,
			'hierarchical' => 1,
			'title_li'     => '',
			'hide_empty'   => 0,
		);
		$all_categories = get_categories( $args );

		foreach ( $all_categories as $cat ) {
			if ( $cat->category_parent == 0 ) {
				$all_categories_ids[] = $cat->term_id;
			}
		}

		// Get all product ids
		$args            = array(
			'fields'      => 'ids',
			'post_type'   => array( 'product' ),
			'post_status' => 'publish',
		);
		$all_product_ids = get_posts( $args );

		// prepare information for contact-form-7 shortcode
		$args      = array(
			'numberposts' => -1,
			'post_type'   => 'wpcf7_contact_form',
			'post_status' => 'publish',
		);
		$cf7_forms = get_posts( $args );
		foreach ( $cf7_forms as $form ) {
			if ( $form->post_title == 'ContactUS' || $form->post_title == 'Contact' || $form->post_title == 'ContactUS1' || $form->post_title == 'ContactUS2' ) {
				$cf7_form_id = $form->ID;
			}
		}

		// prepare information for mail-poet newsletter shortcode
		$newsletters = kite_get_mailchimp_forms();
		foreach ( $newsletters as $id => $newslettername ) {
			$newsleter_form_id = $id;
		}

		$args  = array(
			'sort_order'   => 'asc',
			'sort_column'  => 'post_title',
			'hierarchical' => 1,
			'exclude'      => '',
			'include'      => '',
			'meta_key'     => '',
			'meta_value'   => '',
			'authors'      => '',
			'child_of'     => 0,
			'parent'       => -1,
			'exclude_tree' => '',
			'number'       => '',
			'offset'       => 0,
			'post_type'    => 'page',
			'post_status'  => 'publish',
		);
		$pages = get_pages( $args );

		foreach ( $pages as $page ) {
			if ( $page->post_content != '' ) {
				$post_content = $page->post_content;

				// Process WC categories shortcode
				$occurence_number = substr_count( $post_content, 'KITE_DEMO_WC_CAT_ID' );
				$index            = 0;
				for ( $i = 0; $i < $occurence_number; $i++ ) {
					if ( $index >= count( $all_categories_ids ) ) {
						$index = 0;
					}

					$post_content = preg_replace( '/KITE_DEMO_WC_CAT_ID/', $all_categories_ids[ $index ], $post_content, 1 );

					$index++;
				}

				// Process WC products shortcode
				$occurence_number = substr_count( $post_content, 'KITE_DEMO_WC_PRODUCT_ID' );
				$index            = 0;
				for ( $i = 0; $i < $occurence_number; $i++ ) {
					if ( $index >= count( $all_product_ids ) ) {
						$index = 0;
					}

					$post_content = preg_replace( '/KITE_DEMO_WC_PRODUCT_ID/', $all_product_ids[ $index ], $post_content, 1 );

					$index++;
				}

				// Process contact form shortcodes
				if ( $cf7_form_id != -1 ) {
					$post_content = preg_replace( '/KITE_DEMO_CF7_ID/', $cf7_form_id, $post_content );
				}

				// Process contact form shortcodes
				if ( $shop_url ) {

					$post_content = preg_replace( '/KITE_SHOP_URL/', $shop_url, $post_content );
				}
				if ( $cats_page_url ) {

					$post_content = preg_replace( '/KITE_CATS_URL/', $cats_page_url, $post_content );
				}
				if ( $shop_page_url ) {

					$post_content = preg_replace( '/KITE_SHOP_PAGE_URL/', $shop_page_url, $post_content );
				}

				// process newsletter shortcode
				if ( $newsleter_form_id != -1 ) {
					$post_content = preg_replace( '/KITE_DEMO_NEWSLETTER_ID/', $newsleter_form_id, $post_content );
				}

				$new_post = array(
					'ID'           => $page->ID,
					'post_type'    => 'page',
					'post_content' => $post_content,
				);

				wp_update_post( $new_post );
			}
		}
	}

	public function kite_import_revslider( $demo_name ) {

		$demos             = $this->demos;
		$import_rev_slider = $demos[ $demo_name ]['revSlider'];

		if ( empty( $import_rev_slider[0] ) && empty( $import_rev_slider[1] ) && empty( $import_rev_slider[2] ) ) {
			 echo ': <strong>' . esc_html__( "This demo doesn't have any slider", 'kitestudio-core' ) . '</strong>' . ' - ' . esc_html__( 'Done', 'kitestudio-core' ) . '</p>';
			 return;
		}

		if ( ! class_exists( 'RevSlider' ) ) {
			echo ': <strong>' . esc_html__( 'Revolution Slider required', 'kitestudio-core' ) . '</strong>' . ' - ' . esc_html__( 'Failed', 'kitestudio-core' ) . '</p>';
			return;
		}

		$files_loader = new Updater();
		$headers      = array( 'headers' => array( 'Content-type' => 'application/zip' ) );

		// pages xml file
		$imported_rev_slider = array();
		foreach ( $import_rev_slider as $key => $revslider_file ) {
			if ( empty( $revslider_file ) ) {
				continue;
			}

			if ( ! is_file( WP_CONTENT_DIR . '/uploads/' . KITE_THEME_SLUG . '_demo/demo' . $demo_name . '/revslider_' . $key . '.zip' ) ) {
				$response = $files_loader->curl( $revslider_file, $headers );
				if ( ! $response['status'] ) {
					continue;
				}

				if ( ! $files_loader->download_files_to_host( 'demo' . $demo_name, 'revslider_' . $key . '.zip', $response['body'] ) ) {
					echo esc_html__( "Slider doesn't download", 'kitestudio-core' );
					continue;
				}
			}

			$imported_rev_slider[] = WP_CONTENT_DIR . '/uploads/' . KITE_THEME_SLUG . '_demo/demo' . $demo_name . '/revslider_' . $key . '.zip';
		}

		if ( empty( $imported_rev_slider ) ) {
			echo ': <strong>' . esc_html__( 'There is no slider to import.', 'kitestudio-core' ) . '</strong>' . ' - ' . esc_html__( 'Failed', 'kitestudio-core' ) . '</p>';
			return;
		}

		# Import revolution Slider
		foreach ( $imported_rev_slider as $key => $revslider ) {
			if ( is_file( $revslider ) ) {
				$slider   = new RevSlider();
				$response = $slider->importSliderFromPost( true, true, $revslider );
			} else {
				echo ': <strong>' . esc_html__( 'Slider Demo File Not Found', 'kitestudio-core' ) . '</strong>' . ' - ' . esc_html__( 'Done', 'kitestudio-core' ) . '</p>';
			}
		}
		echo esc_html__( ' Done', 'kitestudio-core' ) . '</p>';
	}

	public function kite_set_navigation_menu() {

		$locations     = get_registered_nav_menus();
		$new_locations = array();
		$menus         = wp_get_nav_menus();
		$menus_count   = count( $menus );

		for ( $i = 0; $i < $menus_count; $i++ ) {
			if ( $menus[ $i ]->slug == 'widget-menu' ) {
				if ( isset( $locations['footer-nav'] ) ) {
					$new_locations['footer-nav'] = (int) ( $menus[ $i ]->term_id );
				}
			} elseif ( $menus[ $i ]->slug == 'top-bar-menu' ) {
				if ( isset( $locations['topbar-nav'] ) ) {
					$new_locations['topbar-nav'] = (int) ( $menus[ $i ]->term_id );
				}
			} elseif ( $menus[ $i ]->slug == 'main-menu' ) {
				if ( isset( $locations['primary-nav'] ) ) {
					$new_locations['primary-nav'] = (int) ( $menus[ $i ]->term_id );
				}
			} elseif ( $menus[ $i ]->slug == 'category-menu' ) {
				if ( isset( $locations['category-nav'] ) ) {
					$new_locations['category-nav'] = (int) ( $menus[ $i ]->term_id );
				}
			}
		}
		set_theme_mod( 'nav_menu_locations', $new_locations );

	}

	public function kite_process_widgets() {
		$widget_menus = get_option( 'widget_nav_menu' );

		$args = array(
			'slug' => array( 'widget-menu', 'footer-menu-1' ),
		);
		$menu = wp_get_nav_menus( $args );

		if ( $widget_menus !== false && count( $menu ) > 0 && is_array( $widget_menus ) ) {

			foreach ( $widget_menus as $key => $widget_menu ) {

				// The option already exists, so we just update it.
				if ( isset( $widget_menu['nav_menu'] ) ) {
					$widget_menu['nav_menu'] = (int) ( $menu[0]->term_id );
					$widget_menus[ $key ]    = $widget_menu;
				}
			}
		}
		update_option( 'widget_nav_menu', $widget_menus );

		// Use placeholder images in text widgets
		$text_widgets = get_option( 'widget_text' );
		$media        = wp_get_attachment_image_url( $this->media_ids[1], 'thumbnail' );
		$media_id     = $this->media_ids[1];
		if ( is_array( $text_widgets ) ) {
			foreach ( $text_widgets as $key => $text_widget ) {

				if ( isset( $text_widget['text'] ) ) {
					$text_widget['text']  = str_replace( 'KITE_DEMO_IMAGE_ID', $media_id, $text_widget['text'] );
					$text_widget['text']  = str_replace( 'KITE_DEMO_IMAGE', $media, $text_widget['text'] );
					$text_widgets[ $key ] = $text_widget;
				}
			}
		}

		update_option( 'widget_text', $text_widgets );

		// Use placeholder images in  custom html widget
		$custom_html_widgets = get_option( 'widget_custom_html' );
		$media               = wp_get_attachment_image_url( $this->media_ids[1], 'thumbnail' );
		$media_id            = $this->media_ids[1];
		if ( is_array( $custom_html_widgets ) ) {
			foreach ( $custom_html_widgets as $key => $custom_html_widget ) {

				if ( isset( $custom_html_widget['content'] ) ) {
					$custom_html_widget['content'] = str_replace( 'KITE_DEMO_IMAGE_ID', $media_id, $custom_html_widget['content'] );
					$custom_html_widget['content'] = str_replace( 'KITE_DEMO_IMAGE', $media, $custom_html_widget['content'] );
					$custom_html_widgets[ $key ]   = $custom_html_widget;
				}
			}
		}

		update_option( 'widget_custom_html', $custom_html_widgets );

		// Use placeholder images in media widgets
		$media_image_widgets = get_option( 'widget_media_image' );
		if ( is_array( $media_image_widgets ) ) {
			foreach ( $media_image_widgets as $key => $media_image_widget ) {

				if ( isset( $media_image_widget['url'] ) ) {
					$media_image_widget['url']   = str_replace( 'KITE_DEMO_IMAGE', $media, $media_image_widget['url'] );
					$media_image_widgets[ $key ] = $media_image_widget;
				}
			}
		}

		update_option( 'widget_media_image', $media_image_widgets );

		// Use placeholder images in video widgets
		$kite_video_widgets = get_option( 'widget_Kite_video' );
		if ( is_array( $kite_video_widgets ) ) {
			foreach ( $kite_video_widgets as $key => $video_widget ) {

				if ( isset( $video_widget['video_poster_image'] ) ) {
					$video_widget['video_poster_image'] = str_replace( 'KITE_DEMO_IMAGE', $media, $video_widget['video_poster_image'] );
					$video_widget[ $key ]               = $video_widget;
				}

				if ( isset( $video_widget['video_background_image'] ) ) {
					$video_widget['video_background_image'] = str_replace( 'KITE_DEMO_IMAGE', $media, $video_widget['video_background_image'] );
					$kite_video_widgets[ $key ]             = $video_widget;
				}
			}
		}

		update_option( 'widget_Kite_video', $kite_video_widgets );

		// Use placeholder images in woocommerce_layered_nav widgets
		$layered_nav__widgets = get_option( 'widget_woocommerce_layered_nav' );

		if ( is_array( $layered_nav__widgets ) ) {
			foreach ( $layered_nav__widgets as $key => $layered_nav__widget ) {

				if ( isset( $layered_nav__widget['values'] ) ) {
					foreach ( $layered_nav__widget['values'] as $val_key => $val_val ) {
						$random_image                              = $this->medias[ array_rand( $this->medias ) ];
						$layered_nav__widget['values'][ $val_key ] = str_replace( 'KITE_DEMO_IMAGE', $random_image, $layered_nav__widget['values'][ $val_key ] );

					}

					$layered_nav__widgets[ $key ] = $layered_nav__widget;
				}
			}
		}

		update_option( 'widget_woocommerce_layered_nav', $layered_nav__widgets );

	}

	public function delete_all_pages() {
		$query = new WP_Query(
			array(
				'post_type'      => 'page',
				'posts_per_page' => -1,
				'fields' => 'ids'
			)
		);
		if ( !empty( $query->posts ) ) :
			foreach( $query->posts as $post_id ) {
				wp_delete_post( get_the_ID(), true );
			}
		endif;
	}

	public function kite_update_elementor_styles() {
		if ( class_exists( '\Elementor\Core\Files\CSS\Global_CSS' ) ) {
			delete_option( \Elementor\Core\Files\CSS\Global_CSS::META_KEY );
			$scheme_css_file = \Elementor\Core\Files\CSS\Global_CSS::create( 'global.css' );
			$scheme_css_file->enqueue();
		}
	}

	/**
	 * Update imported post id to new one where we need
	 *
	 * @return void
	 */
	public function checking_imported_demo() {

		// Update Imported post ids to new one
		$args = array(
			'post_type'      => array(
				'post',
				'page',
				'product',
				'product_variation',
				'elementor_library',
			),
			'posts_per_page' => -1,
			'fields' => 'ids'
		);

		$constants = array(
			'KITE_HOME_PAGE_URL' => str_replace( '/', '\/', get_site_url() ),
			'KITE_BLOG_PAGE_URL' => str_replace( '/', '\/', get_permalink( get_option( 'page_for_posts' ) ) ),
			'KITE_SHOP_PAGE_URL' => str_replace( '/', '\/', get_permalink( wc_get_page_id( 'shop' ) ) ),
			'KITE_UPLOAD_URL'    => str_replace( '/', '\/', wp_get_upload_dir()['baseurl'] ),
		);

        global $wpdb;
        $query = "SELECT option_value FROM {$wpdb->prefix}options WHERE option_name LIKE '%_transient_kite_imported_post_%'";
        $importedIDs = $wpdb->get_results( $query, ARRAY_A );
        if ( ! empty( $importedIDs ) ) {
            $args['post__in'] = wp_list_pluck($importedIDs, 'option_value');
        }

		$query = new \WP_Query( $args );

		if ( !empty( $query->posts ) ) {
			foreach ( $query->posts as $post_ID ) {
				$post_type = get_post_type( $post_ID );

				$elementor_data = get_post_meta( $post_ID, '_elementor_data', true );
				$elementor_data = is_array( $elementor_data ) ? wp_json_encode( $elementor_data ) : $elementor_data;

				if ( ! empty( $elementor_data ) ) {
					
					if ( $post_type != 'post' ) {
						$elementor_data = $this->replace_image_ids( $elementor_data );
					}

					// changing contact form 7 ids
					preg_match_all( '/"form_id":"(\d*)"/', $elementor_data, $form_ids, PREG_SET_ORDER );
					if ( ! empty( $form_ids ) ) {
						foreach ( $form_ids as $key => $form_id ) {
							if ( ! empty( $form_id[1] ) && ! empty( get_transient( 'kite_imported_post_' . $form_id[1] ) ) ) {
								$elementor_data = str_replace( $form_id[0], '"form_id":"' . get_transient( 'kite_imported_post_' . $form_id[1] ) . '"', $elementor_data );
							}
						}
					}

					if ( strpos( $elementor_data, 'kite-woocommerce-hand-picked-products' ) ) {

						preg_match_all( '/{"ids":\[(.+?(?=\]))\]/', $elementor_data, $product_ids, PREG_SET_ORDER );
						if ( ! empty( $product_ids ) ) {
							$product_args    = array(
								'fields'         => 'ids',
								'post_type'      => array( 'product' ),
								'post_status'    => 'publish',
								'posts_per_page' => -1,
							);
							$all_product_ids = get_posts( $product_args );

							foreach ( $product_ids as $product_id ) {
								$ids = explode( ',', $product_id[1] );
								foreach ( $ids as $key => $id ) {
									$ids[ $key ] = '"' . $all_product_ids[ $key ] . '"';
								}
								$new_ids                = implode( ',', $ids );
								$new_product_ids_string = str_replace( $product_id[1], $new_ids, $product_id[0] );

								$elementor_data = str_replace( $product_id[0], $new_product_ids_string, $elementor_data );
							}
						}
					}

					if ( strpos( $elementor_data, 'kite-product-categories' ) ) {

						preg_match_all( '/[^\{]"ids":\[(.+?(?=\]))\]/', $elementor_data, $categories_ids, PREG_SET_ORDER );
						if ( ! empty( $categories_ids ) ) {
							$category_args  = array(
								'taxonomy'     => 'product_cat',
								'orderby'      => 'name',
								'show_count'   => 0,
								'pad_counts'   => 0,
								'hierarchical' => 1,
								'title_li'     => '',
								'hide_empty'   => 0,
							);
							$all_categories = get_categories( $category_args );
							foreach ( $categories_ids as $category_id ) {
								$ids = explode( ',', $category_id[1] );
								foreach ( $ids as $key => $id ) {
									$ids[ $key ] = '"' . $all_categories[0]->term_id . '"';
								}
								$new_ids                   = implode( ',', $ids );
								$new_categories_ids_string = str_replace( $category_id[1], $new_ids, $category_id[0] );

								$elementor_data = str_replace( $category_id[0], $new_categories_ids_string, $elementor_data );
							}
						}
					}

					// finding hotspot product ids
					preg_match_all( '/"product_id":"(\d+)"/', $elementor_data, $hotspot_product_ids, PREG_SET_ORDER );
					if ( ! empty( $hotspot_product_ids ) ) {
						$args            = array(
							'fields'      => 'ids',
							'post_type'   => array( 'product' ),
							'post_status' => 'publish',
						);
						$all_product_ids = get_posts( $args );
						foreach ( $hotspot_product_ids as $product_id ) {
							if ( ! empty( $product_id[1] ) ) {
								$elementor_data = str_replace( $product_id[0], '"product_id":"' . $all_product_ids[ $key ] . '"', $elementor_data );
							}
						}
					}

					// check if page has mailchimp or not
					preg_match_all( '/"mailchimp_form":"(\d+)"/', $elementor_data, $mailchimp_form_id, PREG_SET_ORDER );
					if ( ! empty( $mailchimp_form_id ) ) {
						$newsletter_form_id = -1;
						$newsletters        = kite_get_mailchimp_forms();
						foreach ( $newsletters as $id => $newslettername ) {
							if ( ! empty( $id ) ) {
								$newsletter_form_id = $id;
							}
						}

						if ( ! empty( $mailchimp_form_id[0][1] ) ) {
							$elementor_data = str_replace( $mailchimp_form_id[0][0], '"mailchimp_form":"' . $newsletter_form_id . '"', $elementor_data );
						}
					}

					// Change Constants with desired texts
					foreach ( $constants as $key => $value ) {
						$elementor_data = str_replace( $key, $value, $elementor_data );
					}

					if ( get_post_meta( $post_ID, '_elementor_template_type', true ) == 'footer' ) {
						// finding hotspot product ids
						preg_match_all( '/"menu_slug":"(.+?(?=\"))"/', $elementor_data, $menu_slugs, PREG_SET_ORDER );
						if ( ! empty( $menu_slugs ) ) {
							foreach ( $menu_slugs as $slug ) {
								if ( ! empty( $slug[1] ) ) {
									$elementor_data = str_replace( $slug[0], '"menu_slug":"footer-menu-1"', $elementor_data );
								}
							}
						}
					}

					$elementor_data = wp_slash( $elementor_data );
					update_post_meta( $post_ID, '_elementor_data', $elementor_data );
				}

				if ( $this->wc_placeholder_id && ( 'product' == $post_type || 'product_variation' == $post_type ) ) {
					update_post_meta( $post_ID, '_thumbnail_id', $this->wc_placeholder_id );
					update_post_meta( $post_ID, '_product_image_gallery', get_option( 'kite_product_images_gallery' ) );
				}
			}
		}

		$page_on_front = get_option( 'page_on_front', '' );
		if ( ! empty( $page_on_front ) && false != $imported_page_on_front = get_transient( 'kite_imported_post_' . $page_on_front ) ) {
			update_option( 'page_on_front', $imported_page_on_front );
		}

		// update woocommerce product meta tables
		if ( function_exists( 'wc_update_product_lookup_tables' ) ) {
			wc_update_product_lookup_tables();
		}
	}

	/**
	 * Import WC Placeholder
	 *
	 * @return void
	 */
	public function import_wc_placeholder() {

		// $filename should be the path to a file in the upload directory.
		$filename = KITE_THEME_LIB . '/admin/dummydata/img/placeholders/Product.jpg';

		if ( ! file_exists( $filename ) ) {
			return;
		}

		// Check the type of file. We'll use this as the 'post_mime_type'.
		$filetype = wp_check_filetype( basename( $filename ), null );

		// Get the path to the upload directory.
		$wp_upload_dir = wp_upload_dir();

		if ( wp_mkdir_p( $wp_upload_dir['path'] ) ) {
			$file = $wp_upload_dir['path'] . '/' . basename( $filename );
		} else {
			$file = $wp_upload_dir['basedir'] . '/' . basename( $filename );
		}

		copy( $filename, $file );

		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		);

		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $file );

		if ( ! is_wp_error( $attach_id ) ) {
			// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
			require_once ABSPATH . 'wp-admin/includes/image.php';

			// Generate the metadata for the attachment, and update the database record.
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
			wp_update_attachment_metadata( $attach_id, $attach_data );

			$this->wc_placeholder_id = $attach_id;
			update_option( 'woocommerce_placeholder_image', $attach_id );
		}

	}

	//
	// ─── IMPROVE DEMO IMPORTER WHILE IMPORTING METABOXES ────────────────────────────
	//
	public function kite_import_post_meta_data( $post_id, $key, $value ) {

		if ( $key == '_elementor_data' ) {

			$all_categories_ids = array();
			$all_product_ids    = array();
			$cf7_form_id        = -1;
			$cats_page_url      = esc_url( get_home_url() );

			if ( strpos( $value, 'KITE_DEMO_NEWSLETTER_ID' ) ) {

				// get imported newsletter id in def content
				$newsletter_form_id = -1;
				$newsletters        = kite_get_mailchimp_forms();
				foreach ( $newsletters as $id => $newslettername ) {
					if ( ! empty( $id ) ) {
						$newsletter_form_id = $id;
					}
				}

				// Proccess Newsletter id
				if ( $newsletter_form_id != -1 ) {
					$value = str_replace( 'KITE_DEMO_NEWSLETTER_ID', $newsletter_form_id, $value );
				}
			}

			// Process WC categories shortcode
			$occurence_number = substr_count( $value, 'KITE_DEMO_WC_CAT_ID' );
			$index            = 0;
			if ( $occurence_number ) {

				// get imported categories ids in def content
				$args           = array(
					'taxonomy'     => 'product_cat',
					'orderby'      => 'name',
					'show_count'   => 0,
					'pad_counts'   => 0,
					'hierarchical' => 1,
					'title_li'     => '',
					'hide_empty'   => 0,
				);
				$all_categories = get_categories( $args );

				foreach ( $all_categories as $cat ) {
					if ( $cat->category_parent == 0 ) {
						$all_categories_ids[] = $cat->term_id;
					}
				}

				for ( $i = 0; $i < $occurence_number; $i++ ) {
					if ( $index >= count( $all_categories_ids ) ) {
						$index = 0;
					}

					$value = preg_replace( '/KITE_DEMO_WC_CAT_ID/', $all_categories_ids[ $index ], $value, 1 );

					$index++;
				}
			}

			$occurence_number = substr_count( $value, 'KITE_DEMO_WC_PRODUCT_ID' );
			$index            = 0;
			if ( $occurence_number ) {
				// Process WC products shortcode
				// Get all product ids
				$args            = array(
					'fields'      => 'ids',
					'post_type'   => array( 'product' ),
					'post_status' => 'publish',
				);
				$all_product_ids = get_posts( $args );

				for ( $i = 0; $i < $occurence_number; $i++ ) {
					if ( $index >= count( $all_product_ids ) ) {
						$index = 0;
					}

					$value = preg_replace( '/KITE_DEMO_WC_PRODUCT_ID/', $all_product_ids[ $index ], $value, 1 );

					$index++;
				}
			}

			if ( strpos( $value, 'KITE_DEMO_CF7_ID' ) ) {
				// prepare information for contact-form-7 shortcode
				$args      = array(
					'numberposts' => -1,
					'post_type'   => 'wpcf7_contact_form',
					'post_status' => 'publish',
				);
				$cf7_forms = get_posts( $args );
				foreach ( $cf7_forms as $form ) {
					if ( $form->post_title == 'ContactUS' || $form->post_title == 'Contact' || $form->post_title == 'ContactUS1' || $form->post_title == 'ContactUS2' ) {
						$cf7_form_id = $form->ID;
						break;
					}
				}

				// Process contact form shortcodes
				if ( $cf7_form_id != -1 ) {
					$value = preg_replace( '/KITE_DEMO_CF7_ID/', $cf7_form_id, $value );
				}
			}

			if ( $cats_page_url ) {

				$value = preg_replace( '/KITE_CATS_URL/', $cats_page_url, $value );
			}

			if ( strpos( $value, '"product_cats":"custom"' ) ) {
				$value = str_replace( '"product_cats":"custom"', '"product_cats":"all"', $value );
			}

			if ( strpos( $value, '"product_tags":"custom"' ) ) {
				$value = str_replace( '"product_tags":"custom"', '"product_cats":"all"', $value );
			}

			if ( strpos( $value, '"product_type":"sale"' ) ) {
				$value = str_replace( '"product_type":"sale"', '"product_type":"recent"', $value );
			}

			if ( strpos( $value, '"product_type":"deal"' ) ) {
				$value = str_replace( '"product_type":"deal"', '"product_type":"recent"', $value );
			}

			if ( strpos( $value, '"product_type":"top_rated"' ) ) {
				$value = str_replace( '"product_type":"top_rated"', '"product_type":"recent"', $value );
			}

			if ( strpos( $value, '"product_type":"featured"' ) ) {
				$value = str_replace( '"product_type":"featured"', '"product_type":"recent"', $value );
			}

			if ( strpos( $value, '"product_type":"best_selling"' ) ) {
				$value = str_replace( '"product_type":"best_selling"', '"product_type":"recent"', $value );
			}

			if ( get_post_type( $post_id ) == 'post' ) {
				$value = $this->replace_image_ids( $value, true );
			}

			if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '2.9.10', '<' ) ) {
				update_post_meta( $post_id, wp_slash( $key ), $value );
			} else {
				update_post_meta( $post_id, wp_slash( $key ), wp_slash_strings_only( $value ) );
			}
		}

		if ( $key == 'page_bg_image' ) {
			if ( strpos( $value, 'http://pinkmart' ) === 0 ) {
				$value = str_replace( 'http://pinkmart', site_url(), $value );
				update_post_meta( $post_id, $key, $value );
			}
		}

		if ( is_string( $value ) && strpos( $value, 'http://kite-home' ) === 0 ) {
			$value = str_replace( 'http://kite-home', site_url(), $value );
			update_post_meta( $post_id, $key, $value );
		}

		if ( $key == 'gallery' ) {
			$galleries = maybe_unserialize( $value );
			if ( ! empty( $galleries ) ) {
				foreach ( $galleries as $key => $gallery ) {
					$galleries[ $key ] = str_replace( 'KITE_UPLOAD_URL', wp_get_upload_dir()['baseurl'], $gallery );
				}
			}
			$value = maybe_serialize( $galleries );
			update_post_meta( $post_id, $key, $value );
		}

		if ( $key == 'header-template' ) {
			$new_header_template_id = get_transient( 'kite_imported_post_' . $value );
			if ( ! empty( $new_header_template_id ) ) {
				update_post_meta( $post_id, 'header-template', $new_header_template_id );
			}
		}

		if ( $key == 'footer-template' ) {
			$new_footer_template_id = get_transient( 'kite_imported_post_' . $value );
			if ( ! empty( $new_footer_template_id ) ) {
				update_post_meta( $post_id, 'footer-template', $new_footer_template_id );
			}
		}

		if ( ! is_array( $value ) && stripos( $value, 'KITE_UPLOAD_URL' ) === 0 ) {
			$value = str_ireplace( 'KITE_UPLOAD_URL', wp_get_upload_dir()['baseurl'], $value );
			update_post_meta( $post_id, $key, $value );
		}

		if ( $key == '_thumbnail_id' && get_post_type( $post_id ) == 'post' ) {

			update_post_meta( $post_id, '_thumbnail_id', explode( ',', get_option( 'kite_product_images_gallery', '' ) )[0] );
		}
	}

	/**
	 * replace image ids inside elementor data with the imported ones
	 *
	 * @param string $elementor_data
	 * @param boolean $dummy_image
	 * @return string
	 */
	public function replace_image_ids( $elementor_data, $dummy_image = false ) {
		
		$dummy_ids = $dummy_image ? explode( ',', get_option( 'kite_product_images_gallery', '' ) ) : [];
		// changing attachment ids
		preg_match_all( '/"url":"http*.+?(?=})/', $elementor_data, $found_images, PREG_SET_ORDER );
		if ( ! empty( $found_images ) ) {
			foreach ( $found_images as $key => $image ) {

				preg_match_all( '/(?:"id":")(.*?)(?:")/', $image[0], $id, PREG_SET_ORDER );
				if ( empty( $id[0][1] ) ) {
					preg_match_all( '/(?:"id":)(\d*)/', $image[0], $id, PREG_SET_ORDER );
				}

				if ( ! empty( $id[0][1] ) ) {

					// Replacing old id with the new imported one
					$new_id = $dummy_image ? $dummy_ids[0] : get_transient( 'kite_imported_post_' . $id[0][1] );
					if ( empty( $new_id ) ) {
						continue;
					}

					$new_image_info = $image[0];

					$new_image_info = str_replace( $id[0][1], $new_id, $new_image_info );

					// Replacing old url with the new imported one
					preg_match_all( '/(?:"url":")(.*?)(?:")/', $image[0], $url, PREG_SET_ORDER );
					if ( ! empty( $url[0][1] ) ) {
						$new_image_url  = wp_get_attachment_url( $new_id );
						$new_image_info = str_replace( $url[0][1], str_replace( '/', '\/', $new_image_url ), $new_image_info );
					}
					$elementor_data = str_replace( $image[0], $new_image_info, $elementor_data );
				}
			}
		}

		preg_match_all( '/"id":(\d+),"url":"(.+?(?="))"/', $elementor_data, $found_images, PREG_SET_ORDER );
		if ( ! empty( $found_images ) ) {
			foreach ( $found_images as $key => $image ) {

				// $image[0] => the whole string
				// $image[1] => image id
				// $image[2] => image url
				if ( ! empty( $image[1] ) ) {
					
					// Replacing old id with the new imported one
					$new_id = $dummy_image ? $dummy_ids[0] : get_transient( 'kite_imported_post_' . $image[1] );
					if ( empty( $new_id ) ) {
						continue;
					}

					$new_image_url          = wp_get_attachment_url( $new_id );
					$new_image_url          = str_replace( '/', '\/', $new_image_url );
					$new_found_image_string = '"id":' . $new_id . ',"url":"' . $new_image_url . '"';

					$elementor_data = str_replace( $image[0], $new_found_image_string, $elementor_data );
				}
			}
		}

		preg_match_all( '/"id":"(\d+)","url":"(.+?(?="))"/', $elementor_data, $found_images, PREG_SET_ORDER );
		if ( ! empty( $found_images ) ) {
			foreach ( $found_images as $key => $image ) {

				// $image[0] => the whole string
				// $image[1] => image id
				// $image[2] => image url
				if ( ! empty( $image[1] ) ) {
					
					// Replacing old id with the new imported one
					$new_id = $dummy_image ? $dummy_ids[0] : get_transient( 'kite_imported_post_' . $image[1] );
					if ( empty( $new_id ) ) {
						continue;
					}

					$new_image_url          = wp_get_attachment_url( $new_id );
					$new_image_url          = str_replace( '/', '\/', $new_image_url );
					$new_found_image_string = '"id":' . $new_id . ',"url":"' . $new_image_url . '"';

					$elementor_data = str_replace( $image[0], $new_found_image_string, $elementor_data );
				}
			}
		}

		return $elementor_data;
	}

}

?>
