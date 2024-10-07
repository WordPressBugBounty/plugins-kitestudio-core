<?php
if ( ! function_exists( 'kite_product_attribute' ) ) {
	function kite_product_attribute( $atts ) {
		$atts = shortcode_atts(
			array(
				'per_page'                     => '12',
				'columns'                      => '4',
				'tablet_columns'               => '3',
				'orderby'                      => 'date',
				'order'                        => 'desc',
				'attribute'                    => '',
				'filter'                       => '',
				'enterance_animation'          => 'fadein',
				'responsive_animation'         => 'disable',
				'layout_mode'                  => 'masonry',
				'list_style'                   => 'light',
				'carousel'                     => 'disable',
				'countdown_activation'         => '',
				'progressbar_activation'       => '',
				'is_autoplay'                  => '',
				'responsive_autoplay'          => '',
				'nav_style'                    => '',
				'gutter'                       => '',
				'style'                        => KITE_DEFAULT_PRODUCT_STYLE,
				'product_buttons_style'        => 'product_buttons_style',
				'cart_button_style'            => 'cart_button_style',
				'border'                       => 'enable',
				'image_size'                   => 'shop_catalog',
				'image_size_width'             => '',
				'image_size_height'            => '',
				'image_size_crop'              => '',
				'hover_image'                  => 'show',
				'quickview'                    => 'enable',
				'wishlist'                     => 'enable',
				'compare'                      => 'enable',
				'badges'                       => 'enable',
				'rating'                       => 'enable',
				'hover_price'                  => 'enable',
				'hover_color'                  => '',
				'custom_hover_color'           => '',
				'animation'                    => 'none',
				'delay'                        => '0',
				'body_class'                   => '',
				'show_card_variations_desktop' => true,
				'show_card_variations_tablet'  => true,
				'show_card_variations_mobile'  => true,
				'hide_buttons'				   => ''
			),
			$atts
		);

		if ( ! kite_woocommerce_installed() ) {
			return;
		}

		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $atts['per_page'],
			'orderby'             => $atts['orderby'],
			'order'               => $atts['order'],
			'meta_query'          => WC()->query->get_meta_query(),
			'tax_query'           => array(
				array(
					'taxonomy' => strstr( $atts['attribute'], 'pa_' ) ? sanitize_title( $atts['attribute'] ) : 'pa_' . sanitize_title( $atts['attribute'] ),
					'terms'    => array_map( 'sanitize_title', explode( ',', $atts['filter'] ) ),
					'field'    => 'slug',
				),
			),
		);

		if ( get_option( 'woocommerce_hide_out_of_stock_items', '' ) == 'yes' ) {
			$query_args['meta_query'][] = [
				'key'       => '_stock_status',
				'value'     => 'outofstock',
				'compare'   => 'NOT IN'
			];
		}

		return kite_product_loop( $query_args, $atts, 'product_attribute' );
	}
}
