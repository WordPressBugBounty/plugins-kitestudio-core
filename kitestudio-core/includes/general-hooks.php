<?php
//
// ─── PRODUCT 360 VIEW ───────────────────────────────────────────────────────────
//
function kite_product_360_view_metabox() {
	if ( kite_opt( 'product_360_view', false ) ) {
		add_meta_box( 'woocommerce-product-360-images', esc_html__( 'Product 360 View Gallery (optional)', 'kitestudio-core' ), 'kite_product_360_view_output', 'product', 'side', 'low' );
	}
}
add_action( 'add_meta_boxes', 'kite_product_360_view_metabox', 50 );

//
// ─── DISABLING VISUAL COMPOSER SELF UPDATER ─────────────────────────────────────
//
function kite_vc_disable_update() {
	if ( function_exists( 'vc_license' ) && function_exists( 'vc_updater' ) && ! vc_license()->isActivated() ) {

		remove_filter( 'upgrader_pre_download', array( vc_updater(), 'preUpgradeFilter' ), 10 );
		remove_filter(
			'pre_set_site_transient_update_plugins',
			array(
				vc_updater()->updateManager(),
				'check_update',
			)
		);
	}
}
add_action( 'admin_init', 'kite_vc_disable_update', 9 );

//
// ─── REMOVE NOTIFICATION AND DEMO LINK IN REDUX ─────────────────────────────────
//
function kite_remove_demo_mode_link() {
	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
		remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks' ), null, 2 );
		remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
		if ( is_admin() && isset( $_GET['page'] ) && $_GET['page'] == 'theme_settings' ) {
			remove_all_actions( 'admin_notices' );
		}
	}
}
add_action( 'init', 'kite_remove_demo_mode_link' );

//
// ─── MODIFY WPBAKERY LIBRARY SCRIPTS TO MATCH OUR LIBRARIES ─────────────────────
//
function kite_deregister_wpbakery_scripts() {
	wp_deregister_script( 'vc_waypoints' );
	wp_deregister_script( 'isotope' );
}
add_action( 'vc_base_register_front_js', 'kite_deregister_wpbakery_scripts' );

function kite_deregister_wpbakery_scripts_on_load_iframe() {
	wp_dequeue_script( 'vc_waypoints' );
}
add_action( 'vc_load_iframe_jscss', 'kite_deregister_wpbakery_scripts_on_load_iframe' );

//
// ─── MODIFY ELEMENTOR LIBRARY SCRIPTS TO MATCH OUR LIBRARIES ────────────────────
//
add_action( 'elementor/editor/after_enqueue_scripts', 'kite_enqueue_assets_in_elementor_editor' );
function kite_enqueue_assets_in_elementor_editor() {
	wp_enqueue_style( 'icomoon', KITE_THEME_ASSETS_URI . '/css/icomoon.min.css', false, KITE_THEME_VERSION );
	wp_enqueue_style( 'kite-admin-style', KITE_THEME_LIB_URI . '/admin/css/style.css', false, KITE_THEME_VERSION );
}

add_action( 'elementor/frontend/after_register_scripts', 'kite_remove_swiper_lib_in_elementor' );
function kite_remove_swiper_lib_in_elementor() {
	wp_deregister_script( 'swiper' );
}

//
// ─── ADD SOCIAL SHARE BUTTONS ───────────────────────────────────────────────────
//
if ( ! function_exists( 'kite_add_social_share_buttons' ) ) {
	function kite_add_social_share_buttons() {
		if ( function_exists( 'kite_social_share' ) ) {
			kite_social_share();
		}
	}
	add_action( 'kite_social_share_buttons', 'kite_add_social_share_buttons' );
}

//
// ─── REMOVE POST CLAUSES FILTER ADDED IN TOP RATED PRODUCT LOOP ─────────────────
//
add_action(
	'kite_top_rated_product_loop',
	function() {
		remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
	}
);

//
// ─── REMOVED METABOX ────────────────────────────────────────────────────────────
//
if ( ! function_exists( 'kite_remove_page_metaboxes' ) ) {
	function kite_remove_page_metaboxes() {
		remove_meta_box( 'snap_to_scroll_meta_box', 'page', 'normal' );
	}
}
add_action( 'admin_menu', 'kite_remove_page_metaboxes', 99 );
add_action( 'add_meta_boxes', 'kite_remove_page_metaboxes', 99 );

//
// ─── PLUGINS HANDLER ────────────────────────────────────────────────────────────
//
function kite_add_recommended_plugins( $plugins ) {
	$plugins_list = array(
		// Wordpress Importer
		array(
			'name'     => 'Wordpress Importer',
			'slug'     => 'wordpress-importer',
			'required' => true,
		),
		// Redux Framework
		array(
			'name'     => 'Redux Framework',
			'slug'     => 'redux-framework',
			'required' => true,
		),
		// woocomerce
		array(
			'name'     => 'WooCommerce',
			'slug'     => 'woocommerce',
			'required' => true,
		),
		// Elementor Plugin
		array(
			'name'             => 'Elementor',
			'slug'             => 'elementor',
			'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'required'         => true,
		),
		// Contact Form 7
		array(
			'name'             => 'Contact Form 7',
			'slug'             => 'contact-form-7',
			'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'required'         => true,
		),
		array(
			'name'     => 'Mailchimp For Wordpress',
			'slug'     => 'mailchimp-for-wp',
			'required' => true,
		),
		// Wishlist
		array(
			'name'     => 'YITH WooCommerce Wishlist',
			'slug'     => 'yith-woocommerce-wishlist',
			'required' => false,
		),
		// Compare
		array(
			'name'               => 'YITH WooCommerce Compare',
			'slug'               => 'yith-woocommerce-compare',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		// WooCommerce Currency Switcher plugin
		array(
			'name'             => 'WooCommerce Currency Switcher',
			'slug'             => 'woocommerce-currency-switcher',
			'required'         => false,
			'force_activation' => false,
		),
	);

	$plugins = array_merge( $plugins, $plugins_list );
	return $plugins;
}
add_filter( 'kite_theme_neccessary_plugins', 'kite_add_recommended_plugins', 1, 5 );

//
// ─── CHANGE PRICE STYLE IN AJAX SEARCH ──────────────────────────────────────────
//
add_action( 'kite_before_ajax_search_items_loop', 'kite_change_price_style_in_ajax_search' );
function kite_change_price_style_in_ajax_search() {
	add_filter( 'woocommerce_format_price_range', 'kite_format_price_range', 1, 3 );
}
add_action( 'kite_after_ajax_search_items_loop', 'kite_revert_back_price_style_after_ajax_search' );
function kite_revert_back_price_style_after_ajax_search() {
	remove_filter( 'woocommerce_format_price_range', 'kite_format_price_range', 1, 3 );
}

// ─── Customizing Wp Title ────────────────────────────────────────────────────

if ( ! function_exists( 'kite_filter_wp_title' ) ) {

	/**
	 * Filter wp_title
	 *
	 * @param string $title
	 * @param string $separator
	 * @return string
	 */
	function kite_filter_wp_title( $title, $separator ) {

		if ( is_feed() ) {
			return $title;
		}
		global $paged, $page;

		if ( is_search() ) {

			$title = sprintf( esc_html__( 'Search results for %s', 'kitestudio-core' ), '"' . get_search_query() . '"' );

			if ( $paged >= 2 ) {
				$title .= " $separator " . sprintf( esc_html__( 'Page %s', 'kitestudio-core' ), $paged );
			}

			$title .= " $separator " . get_bloginfo( 'name', 'display' );

			return $title;

		}

		return $title;

	}
}
add_filter( 'wp_title', 'kite_filter_wp_title', 10, 2 );

// ─── Add Svg File Type To Uploads ────────────────────────────────────────────

if ( ! function_exists( 'kite_mime_types' ) ) {

	/**
	 * Add svg mime type
	 *
	 * @param array $mimes
	 * @return array
	 */
	function kite_mime_types( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
}
add_action( 'upload_mimes', 'kite_mime_types' );

if ( ! function_exists( 'kite_svg_media_thumbnails' ) ) {
	function kite_svg_media_thumbnails( $response, $attachment, $meta ) {
		if ( $response['type'] === 'image' && $response['subtype'] === 'svg+xml' && class_exists( 'SimpleXMLElement' ) ) {
			WP_Filesystem();
			global $wp_filesystem;
			try {
				$path = get_attached_file( $attachment->ID );
				if ( WP_Filesystem( $path ) ) {
					$svg    = new SimpleXMLElement( $wp_filesystem->get_contents( $path ) );
					$src    = $response['url'];
					$width  = (int) $svg['width'];
					$height = (int) $svg['height'];

					// media gallery
					// $response['image'] = compact( 'src', get_intermediate_image_sizes() );
					$response['thumb'] = compact( 'src', 'width', 'height' );

					// media single
					$response['sizes']['thumbnail'] = array(
						'height'      => $height,
						'width'       => $width,
						'url'         => $src,
						'orientation' => $height > $width ? 'portrait' : 'landscape',
					);
				}
			} catch ( Exception $e ) {
			}
		}

		return $response;
	}
}
add_filter( 'wp_prepare_attachment_for_js', 'kite_svg_media_thumbnails', 10, 3 );

// ─── Dokan Plugin Compatibility ──────────────────────────────────────────────

/**
 * Change product seller info
 *
 * @param array $item_data
 * @param array $cart_item
 * @return array $item_data
 */
function kite_dokan_product_seller_info( $item_data, $cart_item ) {
	$vendor = dokan_get_vendor_by_product( $cart_item['product_id'] );

	if ( ! $vendor ) {
		return $item_data;
	}
	$vendorval = $vendor->get_shop_name();
	if ( ! empty( $vendorval ) ) {
		$item_data[] = array(
			'name'  => __( 'Vendor', 'kitestudio-core' ),
			'value' => $vendorval,
		);
	}
	return $item_data;
}

if ( class_exists( 'WeDevs_Dokan' ) ) {
	remove_filter( 'woocommerce_get_item_data', 'dokan_product_seller_info', 10, 2 );
	add_filter( 'woocommerce_get_item_data', 'kite_dokan_product_seller_info', 10, 2 );
}

// ─── Mailchimp Compatibility ─────────────────────────────────────────────────

/**
 * Load mailchimp required scripts
 *
 * @return void
 */
function kite_load_mailchimp_scripts() {
	wp_enqueue_style( 'kite-newsletter' );
	wp_enqueue_script( 'kite-newsletter' );
}
add_action( 'mc4wp_output_form', 'kite_load_mailchimp_scripts' );

// ─── Add Compatiblity With Hpos Feature Of Woocommerce ───────────────────────

/**
 * Add compatiblity with HPOS feature of WooCommerce
 *
 * @return void
 */
function kite_core_compatibility_with_woocommerce_hpos() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', KITE_CORE_DIR . 'kitestudio-core.php', true );
	}
}
add_action( 'before_woocommerce_init', 'kite_core_compatibility_with_woocommerce_hpos' );

// ────────────────────────────────────────────────────────────────────────────────
