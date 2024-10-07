<?php
if ( ! function_exists( 'kite_product_categories' ) ) {
	// Product categories
	function kite_product_categories( $atts ) {
		global $woocommerce_loop;

		$atts = shortcode_atts(
			array(
				'number'                  => null,
				'orderby'                 => 'name',
				'order'                   => 'ASC',
				'carousel'                => 'disable',
				'columns'                 => '1',
				'nav_style'               => 'light',
				'show_image'              => 1,
				'product-category-styles' => 'style-1',
				'font_type'               => 'default',
				'google_fonts'            => '',
				'font_size'               => '16',
				'carouselClass'           => '',
				'is_autoplay'             => 'off',
				'image_size'              => 'shop_catalog',
				'image_size_width'        => '',
				'image_size_height'       => '',
				'image_size_crop'         => '',
				'hide_empty'              => 1,
				'parent'                  => '',
				'ids'                     => '',
				'border'                  => '',
				'gutter'                  => '',
				'count'                   => '',
				'description'             => 'enable',
				'hover_color'             => 'c0392b',
				'custom_hover_color'      => '',
				'style'                   => '#333',
				'hover_animation'         => 'enable',
				'enterance_animation'     => 'fadein',
				'responsive_animation'    => 'disable',
				'hover_text_color'        => '#333',
				'elementor'               => '',
				'body_class'              => '',
			),
			$atts
		);

		extract( $atts );
		if ( ! kite_woocommerce_installed() ) {
			return;
		}
		ob_start();

		$google_fonts_inline_style = '';

		if ( $font_type != 'default' && $elementor == '' && function_exists( 'kite_get_fonts_data' ) ) {
			$google_fonts_data         = kite_get_fonts_data( $google_fonts );
			$google_fonts_inline_style = kite_google_fonts_styles( $google_fonts_data );
			kite_enqueue_google_fonts( $google_fonts_data );
		}

		$product_category_styles = $atts['product-category-styles'];
		$nav_style               = $atts['nav_style'];
		$carousel_class          = 'no-carousel';
		$carousel                = $atts['carousel'];
		$autoplay                = $atts['is_autoplay'];
		$id                      = kite_sc_id( 'wc_shortcode_category_setting' );

		if ( $carousel == 'enable' ) {
			$carousel_class = 'carousel';
		}
		if ( $carousel == 'list' ) {
			$carousel_class = 'list no-carousel';
		}
		$gutter = ( $gutter == 'no' ? 'no-gutter' : '' );

		if ( isset( $ids ) ) {
			$ids = explode( ',', $ids );
			$ids = array_map( 'trim', $ids );
		} else {
			$ids = array();
		}

		$hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;
		// get terms and workaround WP bug with parents/pad counts
		$args = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'include'    => $ids,
			'pad_counts' => true,
			'child_of'   => $parent,
		);

		$product_categories = get_terms( 'product_cat', $args );

		if ( is_wp_error( $product_categories ) ) {
			return;
		}

		if ( '' !== $parent ) {
			$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );
		}

		if ( $hide_empty ) {
			foreach ( $product_categories as $key => $category ) {
				if ( $category->count == 0 ) {
					unset( $product_categories[ $key ] );
				}
			}
		}

		if ( $number ) {
			$product_categories = array_slice( $product_categories, 0, $number );
		}

		$columns                     = absint( $columns );
		$woocommerce_loop['columns'] = $columns;

		$class = array();
		if ( $enterance_animation != 'default' ) {
			$class[] = 'shortcodeanimation ';

			if ( $responsive_animation != '' ) {
				$class[] = 'no-responsive-animation';
			}
		}
		if ( $show_image != 1 && $carousel == 'list' ) {
			$class[] = 'no-image ';
		}

		$color = 'c0392b';
		if ( isset( $hover_color ) ) {
			if ( $hover_color != 'custom' ) {
				$color = '#' . $hover_color;
			} else {
				if ( isset( $custom_hover_color ) ) {
					$color = $custom_hover_color;
				}
			}
		}
		if ( $carousel == 'list' ) {
			$image_size = 'shop_thumbnail';
		}

		if ( $image_size == 'custom' && $image_size_width != '' && $image_size_height != '' ) {
			if ( $image_size_crop == 'yes' ) {
				$image_size_crop = true;
			} else {
				$image_size_crop = false;
			}

			$image_size = array( $image_size_width, $image_size_height, $image_size_crop );
		} else {
			$image_size = esc_attr( $image_size );
		}

		// Reset loop/columns globals when starting a new loop
		$woocommerce_loop['loop'] = $woocommerce_loop['column'] = '';

		$category_style = '';
		if ( $product_categories ) {

			// Use <ul> tag instead of calling woocommerce_product_loop_start(); to detect WC shortcodes
			?>
				<div class="products <?php echo 'shop-' . esc_attr( $columns ) . 'column'; ?>">
				<?php if ( $atts['carousel'] == 'enable' ) { ?>
					<div class="swiper" data-visibleitems="<?php echo esc_attr( $columns ); ?>">
						<div class="swiper-wrapper">
							<?php } ?>


				<?php
				$hover_color = $color;
				$font_family = $google_fonts_inline_style;
				foreach ( $product_categories as $category ) {

					include locate_template( 'woocommerce/content-product-cat.php', false, false );

				}
				if ( $product_category_styles == 'style-2' ) {
					$category_style = 'style2';
				} elseif ( $product_category_styles == 'style-3' ) {
					$category_style = 'style3';
				}
				?>
				<?php if ( $carousel == 'enable' ) { ?>
					</div>
					</div>
					<div class="arrows-button-next"></div>
					<div class="arrows-button-prev"></div>
				<?php } ?>
				</div>
				<?php
				// Use </ul> tag instead of calling woocommerce_product_loop_end(); to detect WC shortcodes
		}

		wc_reset_loop();

		if ( ( $carousel == 'enable' ) || ( $atts['enterance_animation'] != 'default' ) ) {
			$body_class .= ' wc-shortcode';
		}

		return '<div class="woocommerce wc-categories ' . esc_attr( $body_class ) . ' ' . ( $atts['enterance_animation'] != 'default' ? esc_attr( $enterance_animation ) : '' ) . ' ' . esc_attr( $carousel_class ) . ' ' . esc_attr( $category_style ) . ' ' . esc_attr( $nav_style ) . ' ' . esc_attr( $gutter . ' ' . implode( ' ', $class ) ) . ' ' . ( $hover_animation == 'enable' ? '' : 'nohoveranimation' ) . '"  ' . ( $autoplay == 'on' ? 'data-autoplay="on"' : '' ) . ( strlen( esc_attr( $enterance_animation ) ) ? 'data-animation="' . esc_attr( $enterance_animation ) : '' ) . '">' . ob_get_clean() . '</div>';
	}
}
