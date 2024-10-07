<?php
if ( ! function_exists( 'kite_products' ) ) {
	function kite_products( $atts ) {
		$atts = shortcode_atts(
			array(
				'columns'                      => '1',
				'orderby'                      => 'title',
				'order'                        => 'asc',
				'ids'                          => '',
				'skus'                         => '',
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
				'hover_color'                  => 'c0392b',
				'custom_hover_color'           => '',
				'animation'                    => 'none',
				'delay'                        => '0',
				'product_color_scheme'         => 'light',
				'column_in_mobile'             => '1',
				'tablet_columns'               => '3',
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
			'orderby'             => $atts['orderby'],
			'order'               => $atts['order'],
			'posts_per_page'      => -1,
			'meta_query'          => WC()->query->get_meta_query(),
		);

		if ( ! empty( $atts['skus'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => '_sku',
				'value'   => array_map( 'trim', explode( ',', $atts['skus'] ) ),
				'compare' => 'IN',
			);
		}

		if ( ! empty( $atts['ids'] ) ) {
			$query_args['post__in'] = array_map( 'trim', explode( ',', $atts['ids'] ) );
		}

		if ( $atts['image_size'] == 'custom' && $atts['image_size_width'] != '' && $atts['image_size_height'] != '' ) {
			if ( $atts['image_size_crop'] == 'yes' ) {
				$atts['image_size_crop'] = true;
			} else {
				$atts['image_size_crop'] = false;
			}

			$atts['image_size'] = array( $atts['image_size_width'], $atts['image_size_height'], $atts['image_size_crop'] );
		}

		return kite_product_loop( $query_args, $atts, 'products' );
	}
}
