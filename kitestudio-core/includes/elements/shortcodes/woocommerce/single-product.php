<?php
if ( ! function_exists( 'kite_sc_product' ) ) {
	// single product 1
	function kite_sc_product( $atts ) {
		$atts = shortcode_atts(
			array(
				'id'                           => '',
				'product_id'                   => '',
				'sku'                          => '',
				'style'                        => KITE_DEFAULT_PRODUCT_STYLE,
				'product_buttons_style'        => 'product_buttons_style',
				'cart_button_style'            => 'cart_button_style',
				'columns'                      => '1',
				'border'                       => 'enable',
				'image_size'                   => 'shop_catalog',
				'image_size_width'             => '',
				'image_size_height'            => '',
				'image_size_crop'              => '',
				'hover_image'                  => 'show',
				'countdown_activation'         => '',
				'progressbar_activation'       => '',
				'quickview'                    => 'enable',
				'compare'                      => 'enable',
				'wishlist'                     => 'enable',
				'badges'                       => 'enable',
				'rating'                       => 'enable',
				'hover_price'                  => 'enable',
				'hover_color'                  => 'c0392b',
				'custom_hover_color'           => '',
				'animation'                    => 'none',
				'delay'                        => '0',
				// reset values that not related to single product shortcode
				'carousel'                     => 'disable',
				'layout_mode'                  => 'fitRows',
				'list_style'                   => 'light',
				'enterance_animation'          => 'default',
				'responsive_animation'         => 'disable',
				'is_autoplay'                  => 'off',
				'responsive_autoplay'          => '',
				'nav_style'                    => 'dark',
				'gutter'                       => '',
				'product_color_scheme'         => 'light',
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

		if ( $atts['id'] == '' ) {
			if ( $atts['product_id'] == '' ) {
				return '';
			} else {
				$atts['id'] = $atts['product_id'];
			}
		}

		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => 1,
			'no_found_rows'       => 1,
			'meta_query'          => WC()->query->get_meta_query(),
		);

		if ( $atts['sku'] != '' ) {
			$query_args['meta_query'][] = array(
				'key'     => '_sku',
				'value'   => $atts['sku'],
				'compare' => '=',
			);
		}

		$query_args['p'] = $atts['id'];

		if ( $atts['image_size'] == 'custom' && $atts['image_size_width'] != '' && $atts['image_size_height'] != '' ) {
			if ( $atts['image_size_crop'] == 'yes' ) {
				$atts['image_size_crop'] = true;
			} else {
				$atts['image_size_crop'] = false;
			}

			$atts['image_size'] = array( $atts['image_size_width'], $atts['image_size_height'], $atts['image_size_crop'] );
		}

		return kite_product_loop( $query_args, $atts, 'single_product' );
	}
}
