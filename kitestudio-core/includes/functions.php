<?php
/* -------------------------------------------------------------------------- */
/*                        Check woocommerce activation                        */
/* -------------------------------------------------------------------------- */
if ( ! function_exists( 'kite_woocommerce_installed' ) ) {
	function kite_woocommerce_installed() {
		return class_exists( 'WooCommerce' );
	}
}

function kite_get_product_cards_style() {
	return apply_filters(
		'kite_product_cards_style',
		array(
			'style1'        => esc_html__( 'Buttons on hover', 'kitestudio-core' ),
			'style1-center' => esc_html__( 'Buttons on hover - centered title', 'kitestudio-core' ),
			'style2'        => esc_html__( 'Info on hover', 'kitestudio-core' ),
		)
	);
}

/**
 * Check if page has blog sidebar or not
 *
 * @return bool
 */
function kite_has_page_blog_sidebar( $post = '' ) {
	if ( empty( $post ) ) {
		global $post;
	}

	if ( ! $post ) {
		return false;
	}

	$check_sidebar    = get_post_meta( $post->ID, 'blog-sidebar', true );
	$check_sidebar_pos = get_post_meta( $post->ID, 'blog-sidebar-position', true );

	if ( $check_sidebar == 1 ) {
		$sidebar = $check_sidebar_pos;
	} elseif ( $check_sidebar == 2 ) {
		$sidebar = 'no-sidebar';
	} else {
		$sidebar = kite_opt( 'blog-sidebar-position', 'main-sidebar' );
	}
	if ( ( ( $sidebar == 'main-sidebar' ) || ( $sidebar == 'left-sidebar' ) ) && ! is_active_sidebar( 'main-sidebar' ) ) {
		$sidebar = 'no-sidebar';
	}

	if ( is_singular( 'product' ) && is_active_sidebar( 'woocommerce-product-sidebar' ) ) {
		$product_detail_style           = ( kite_get_meta( 'product_detail_style_inherit' ) == '1' ) ? kite_get_meta( 'product_detail_style' ) : kite_opt( 'product-detail-style', 'pd_classic' );
		$product_detail_gallery_sidebar = ( kite_get_meta( 'product_detail_style_inherit' ) == '1' ) ? kite_get_meta( 'product_detail_gallery_sidebar' ) : kite_opt( 'product_detail_gallery_sidebar' );

		if ( ( $product_detail_style == 'pd_classic_sidebar' ) || ( ( $product_detail_style == 'pd_col_gallery' ) && ( $product_detail_gallery_sidebar != 1 ) ) ) {
			return true;
		}
	}

	return ( get_post_meta( $post->ID, 'page-type-switch', true ) == 'blog-section' && ( $sidebar == 'main-sidebar' || $sidebar == 'left-sidebar' ) ) ? true : false;
}


if ( ! function_exists( 'kite_yith_wishlist_compare' ) ) {
	function kite_yith_wishlist_compare() {
		remove_action( 'woocommerce_after_add_to_cart_button', 'kite_summery_add_compare_link', 35 );
		add_action( 'quick_view_product_summary', 'kite_summery_add_compare_link', 16 );
		remove_filter( 'yith_wcwl_positions', 'kite_yith_wooWishlist_button' );
		add_action( 'quick_view_product_summary', 'yith_add_loop_wishlist', 16 );
	}
}
/**
 * check if product license is verified or not
 *
 * @return void
 */
function kite_is_license_verified() {
	return get_option( strtolower( KITE_THEME_SLUG ) . '_license_verified', false ) && ! empty( get_option( 'kite_token_' . KITE_PRODUCT_ID, '' ) );
}

function kite_load_elementor_font_awesome() {

	if ( kite_opt('disable_elementor_font_awesome', false) ) {
		return;
	}
	foreach( [ 'solid', 'regular', 'brands' ] as $style ) { 
		wp_enqueue_style( 'elementor-icons-fa-' . $style ); 
	}
}