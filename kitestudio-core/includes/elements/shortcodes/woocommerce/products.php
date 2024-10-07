<?php
if ( ! function_exists( 'kite_woocommerce_products' ) ) {
	function kite_woocommerce_products( $atts ) {
		$atts = shortcode_atts(
			array(
				'tab_title'                    => '',
				'tab_icon_check'               => '',
				'tab_icon'                     => '',
				'product_type'                 => 'top_rated',
				'per_page'                     => '12',
				'columns'                      => '1',
				'tablet_columns'               => '3',
				'orderby'                      => 'date',
				'order'                        => 'desc',
				'category'                     => '',  // Slugs
				'tags'                         => '',
				'enterance_animation'          => 'fadein',
				'responsive_animation'         => 'disable',
				'layout_mode'                  => 'masonry',
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
				'list_style'                   => 'light',
				'product_color_scheme'         => 'light',
				'column_in_mobile'             => '1',
				'body_class'                   => '',
				'show_card_variations_desktop' => true,
				'show_card_variations_tablet'  => true,
				'show_card_variations_mobile'  => true,
				'load_skeleton_style'          => false,
				'hide_buttons'				   => ''
			),
			$atts
		);

		if ( ! kite_woocommerce_installed() ) {
			return;
		}

		$tax  = '';
		$term = '';
		if ( $atts['tags'] != '' ) {
			$tax  = 'product_tag';
			$term = $atts['tags'];
		}
		if ( $atts['category'] != '' ) {
			$tax  = 'product_cat';
			$term = $atts['category'];
		}

		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $atts['per_page'],
			'orderby'             => $atts['orderby'],
			'order'               => $atts['order'],
		);

		if ( $atts['product_type'] == 'featured' ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
				),
			);
		} elseif ( $atts['product_type'] == 'top_rated' || $atts['product_type'] == 'recent' ) {
			$query_args['meta_query'] = WC()->query->get_meta_query();
		} elseif ( $atts['product_type'] == 'best_selling' ) {
			$query_args['meta_key'] = 'total_sales'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			$query_args['orderby']  = 'meta_value_num';
		} elseif ( $atts['product_type'] == 'sale' ) {
			$query_args['meta_query'] = WC()->query->get_meta_query();
			$query_args['post__in']   = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
		} elseif ( $atts['product_type'] == 'deal' ) {
			$today                    = time();
			$query_args['meta_query'] = array(
				'relation' => 'AND',
				array(
					'key'     => '_sale_price_dates_from',
					'value'   => '',
					'compare' => '!=',
				),
				array(
					'key'     => '_sale_price_dates_from',
					'value'   => $today,
					'compare' => '<=',
				),
				array(
					'key'     => '_sale_price_dates_to',
					'value'   => '',
					'compare' => '!=',
				),
				array(
					'key'     => '_sale_price_dates_to',
					'value'   => $today,
					'compare' => '>=',
				),
			);
		}
		if ( $atts['category'] != '' && $atts['tags'] != '' ) {
			$query_args['tax_query'] = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => array_map( 'sanitize_title', explode( ',', $atts['category'] ) ), // display products of the specific categories.
					'operator' => 'IN',
				),
				array(
					'taxonomy' => 'product_tag',
					'field'    => 'slug',
					'terms'    => array_map( 'sanitize_title', explode( ',', $atts['tags'] ) ), // display products of the specific tags.
					'operator' => 'IN',
				),
			);

			if ( $atts['product_type'] == 'featured' ) {
				$query_args['tax_query'] = array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
					),
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => array_map( 'sanitize_title', explode( ',', $atts['category'] ) ), // display products of the specific categories.
						'operator' => 'IN',
					),
					array(
						'taxonomy' => 'product_tag',
						'field'    => 'slug',
						'terms'    => array_map( 'sanitize_title', explode( ',', $atts['tags'] ) ), // display products of the specific tags.
						'operator' => 'IN',
					),
				);
			}
		} elseif ( $tax != '' ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => $tax,
					'field'    => 'slug',
					'terms'    => array_map( 'sanitize_title', explode( ',', $term ) ), // display products of the specific categories or tags.
					'operator' => 'IN',
				),
			);

			if ( $atts['product_type'] == 'featured' ) {
				$query_args['tax_query'] = array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
					),
					array(
						'taxonomy' => $tax,
						'field'    => 'slug',
						'terms'    => array_map( 'sanitize_title', explode( ',', $term ) ), // display products of the specific categories or tags.
						'operator' => 'IN',
					),
				);
			}
		}

		if ( get_option( 'woocommerce_hide_out_of_stock_items', '' ) == 'yes' ) {
			$query_args['meta_query'][] = [
				'key'       => '_stock_status',
				'value'     => 'outofstock',
				'compare'   => 'NOT IN'
			];
		}

		if ( $atts['image_size'] == 'custom' && $atts['image_size_width'] != '' && $atts['image_size_height'] != '' ) {
			if ( $atts['image_size_crop'] == 'yes' ) {
				$atts['image_size_crop'] = true;
			} else {
				$atts['image_size_crop'] = false;
			}

			$atts['image_size'] = array( $atts['image_size_width'], $atts['image_size_height'], $atts['image_size_crop'] );
		}

		if ( $atts['product_type'] == 'featured' ) {
			return kite_product_loop( $query_args, $atts, 'featured_products' );
		}

		if ( $atts['product_type'] == 'top_rated' ) {
			add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
			$return = kite_product_loop( $query_args, $atts, 'top_rated_products' );
			do_action( 'kite_top_rated_product_loop' );
			return $return;
		}

		if ( $atts['product_type'] == 'best_selling' ) {
			return kite_product_loop( $query_args, $atts, 'best_selling_products' );
		}

		if ( $atts['product_type'] == 'sale' ) {
			return kite_product_loop( $query_args, $atts, 'sale_products' );
		}

		if ( $atts['product_type'] == 'recent' ) {
			return kite_product_loop( $query_args, $atts, 'recent_products' );
		}

		if ( $atts['product_type'] == 'deal' ) {
			return kite_product_loop( $query_args, $atts, 'deal_products' );
		}
	}
}
