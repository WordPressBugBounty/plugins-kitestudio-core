<?php
if ( ! function_exists( 'kite_product_loop' ) ) {
	// utility fucntion to handle woocommerce loops used in woocommerce shortcodes
	function kite_product_loop( $query_args, $atts, $loop_name ) {
		global $woocommerce_loop;
		$catalog_mode = kite_opt( 'catalog_mode', false );

		$columns                     = absint( $atts['columns'] );
		$woocommerce_loop['columns'] = $columns;
		$gutter                      = ( $atts['gutter'] == 'no' ? 'no-gutter' : '' );
		$nav_style                   = $atts['nav_style'];
		$carousel_class              = 'no-carousel';
		$carousel                    = 'disable';
		$autoplay                    = $atts['is_autoplay'];
		$style                       = $atts['style'];
		$border                      = $atts['border'];
		$image_size                  = $atts['image_size'];
		$image_size_width            = $atts['image_size_width'];
		$image_size_height           = $atts['image_size_height'];
		$image_size_crop             = $atts['image_size_crop'];
		$hover_image                 = $atts['hover_image'];
		$quickview                   = $atts['quickview'];
		$compare                     = $atts['compare'];
		$hover_price                 = $atts['hover_price'];
		$enterance_animation         = wp_doing_ajax() && ! empty( $atts['load_skeleton_style'] ) ? 'none' : $atts['enterance_animation'];
		$responsive_animation        = $atts['responsive_animation'];
		$layout                      = $atts['layout_mode'];
		$list_style                  = $atts['list_style'];
		$wishlist                    = $atts['wishlist'];
		$badges                      = $atts['badges'];
		$hover_color                 = $atts['hover_color'];
		$custom_hover_color          = $atts['custom_hover_color'];
		$animation                   = $atts['animation'];
		$delay                       = $atts['delay'];
		$countdown_activation        = $atts['countdown_activation'];
		$progressbar_activation      = $atts['progressbar_activation'];
		$body_class                  = $atts['body_class'];
		$product_buttons_style       = $atts['product_buttons_style'];
		$cart_button_style           = $atts['cart_button_style'];
		$request_from                = 'widget';
		$ajax_add_to_cart            = get_option( 'woocommerce_enable_ajax_add_to_cart' );
		$product_rating              = $atts['rating'];
		$responsive_autoplay         = $atts['responsive_autoplay'];
		$hide_buttons                = $atts['hide_buttons'] ?? false;

		$hover_layer = '<div class="hover_layer"></div>';
		if ( isset( $atts['hover_color'] ) ) {
			if ( $atts['hover_color'] != 'custom' && $atts['hover_color'] != '' ) {
				$hover_layer = '<div class="hover_layer" style="background-color:#' . esc_attr( $atts['hover_color'] ) . ';"></div>';
			} else {
				if ( isset( $atts['custom_hover_color'] ) && $atts['custom_hover_color'] != '' ) {
					$hover_layer = '<div class="hover_layer" style="background-color:' . esc_attr( $atts['custom_hover_color'] ) . ';"></div>';
				}
			}
		}

		if ( $image_size == 'custom' && $image_size_width != '' && $image_size_height != '' ) {
			if ( $image_size_crop == 'yes' ) {
				$image_size_crop = true;
			} else {
				$image_size_crop = false;
			}

			$image_size = array( $image_size_width, $image_size_height, $image_size_crop );
		}

		if ( wp_doing_ajax() && is_array( $image_size ) ) {
			$image_size[2] = 'true' == $image_size[2] ? true : $image_size[2];			
		}

		$product_style = '';
		if ( $atts['carousel'] == 'list' ) {

			$product_style = 'listview';
		} else {
			if ( $style == 'modern-buttons-on-hover' ) {
				$product_style = 'modern-buttons-on-hover';
			} elseif ( $style == 'style1' ) {
				$product_style = 'buttonsonhover';
			} elseif ( $style == 'style1-center' ) {
				$product_style = 'buttonsonhover centered';
			} elseif ( $style == 'style2' ) {
				$product_style = 'infoonhover';
			} elseif ( $style == 'style3' ) {
				$product_style = 'infoonclick';
			} elseif ( $style == 'style4' ) {
				$product_style = 'instantshop';
			} elseif ( $style == 'buttonsappearunder' ) {
				$product_style = 'buttonsappearunder';
			}
		}

		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10 );
		if ( $product_rating != 'enable' ) {
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating' );
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 3 );
		} else {
			add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 3 );
		}

		$products_wrap_classes = array(
			'kt-widget-product-loop',
			'column_tablet',
			$product_style,
			'shop-' . esc_attr( $columns ) . 'column',
		);
		if ( $border == 'enable' ) {
			$products_wrap_classes[] = 'with-border';
		}
		if ( isset( $atts['column_in_mobile'] ) && $atts['column_in_mobile'] == '2' ) {
			$products_wrap_classes[] = 'column_res';
		}
		if ( ! empty( $atts['tablet_columns'] ) ) {
			$products_wrap_classes[] = 'shop-tablet-' . $atts['tablet_columns'] . 'column';
		}

		// check if skeleton template exist or not
		$skeleton_with_info_location = locate_template( 'templates/woocommerce/skeleton/skeleton-with-info.php', false, false );

		ob_start();

		if ( ! empty( $atts['load_skeleton_style'] ) && ! wp_doing_ajax() && $skeleton_with_info_location  && !( class_exists( '\Elementor\Plugin' ) && ! is_null( \Elementor\Plugin::$instance->editor ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) ) {
			$classes         = array();
			$shortcode_props = wp_json_encode( $atts );

			if ( $quickview !== 'disable' && kite_opt( 'load_style_when_required', false ) ) {
				wp_enqueue_style( 'kite-quickview' );
			}

			if ( $countdown_activation == 'on' ) {
				wp_enqueue_script( 'kite-countdown' );
			}
			?>
			<div class="products skeleton <?php echo esc_attr( implode( ' ', $products_wrap_classes ) ); ?>" data-shortcode-prop="<?php echo esc_attr( $shortcode_props ); ?>">
			<?php
			if ( $atts['carousel'] == 'list' ) {
				$classes[]      = 'list_view';
				$carousel_class = 'list no-carousel';
				if ( $list_style == 'dark' ) {
					$carousel_class = 'list no-carousel dark';
				}
			}

			if ( $border == 'enable' ) {
				$classes[] = 'with-border';
			}

			if ( $responsive_animation != '' ) {
				$class[] = 'no-responsive-animation';
			}
			if ( isset( $atts['product_color_scheme'] ) && $atts['product_color_scheme'] == 'dark' ) {
				$classes[] = 'dark';
			}

			$num_of_products = $query_args['posts_per_page'];
			if ( $atts['carousel'] == 'enable' ) {
				$num_of_products = $columns;
			}

			if ( $style == 'modern-buttons-on-hover' ) {
				$skeleton_location = $skeleton_with_info_location;
			} elseif ( ( $style == 'style1' || $style == 'style1-center' ) && $atts['carousel'] != 'list' ) {
				$skeleton_location = $skeleton_with_info_location;
			} elseif ( $style == 'style2' && $atts['carousel'] != 'list' ) {
				$skeleton_location = locate_template( 'templates/woocommerce/skeleton/skeleton-without-info.php', false, false );
			} elseif ( $style == 'style3' && $atts['carousel'] != 'list' ) {
				$skeleton_location = locate_template( 'templates/woocommerce/skeleton/skeleton-without-info.php', false, false );
			} elseif ( $style == 'buttonsappearunder' && $atts['carousel'] != 'list' ) {
				$skeleton_location = $skeleton_with_info_location;
			} elseif ( $atts['carousel'] != 'list' ) {
				$skeleton_location = $skeleton_with_info_location;
			} else { // If view mode is list view
				$skeleton_location = locate_template( 'templates/woocommerce/skeleton/skeleton-list-view.php', false, false );
			}

			for ( $i = 0; $i < $num_of_products; $i++ ) {

				include $skeleton_location;
			}

			?>
			</div>
			<?php
			$animation_class = '';
			if ( $animation != 'none' ) {
				$animation_class = ' shortcodeanimation';
			}

			if ( $responsive_animation != '' ) {
				$animation_class .= ' no-responsive-animation';
			}
			return '<div class="woocommerce wc-shortcode ' . esc_attr( $body_class ) . ' ' . esc_attr( $gutter ) . ' ' . ( $enterance_animation != 'default' ? esc_attr( $enterance_animation ) : '' ) . ' ' . esc_attr( $carousel_class . $animation_class . ' ' . $nav_style ) . '"' . ' data-layoutMode="' . esc_attr( $layout ) . '" ' . ( strlen( esc_attr( $animation ) ) ? ' data-delay="' . esc_attr( $delay ) . '" data-animation="' . esc_attr( $animation ) : '' ) . '">' . ob_get_clean() . '</div>';

		} else {
			$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts ) );

			if ( $atts['carousel'] == 'enable' && count( $products->posts ) >= $columns ) {
				$carousel_class = ( $atts['column_in_mobile'] == '2' ) ? 'carousel phone-column-2' : 'carousel';
			}
			if ( $atts['carousel'] == 'list' ) {
				$carousel_class = 'list no-carousel';
				if ( $list_style == 'dark' ) {
					$carousel_class = 'list no-carousel dark';
				}
			}

			if ( $countdown_activation == 'on' ) {
				wp_enqueue_script( 'kite-countdown' );
			}
			
			if ( $products->have_posts() ) :
				?>

				<?php do_action( "woocommerce_shortcode_before_{$loop_name}_loop" ); ?>

				<?php // Use <ul> tag instead of calling woocommerce_product_loop_start(); to detect WC shortcodes ?>
					<div class="products <?php echo esc_attr( implode( ' ', $products_wrap_classes ) ); ?>">
				<?php if ( $atts['carousel'] == 'enable' && count( $products->posts ) >= $columns ) { ?>

							<div class="swiper" data-visibleitems="<?php echo esc_attr( $columns ); ?>">
								<div class="swiper-wrapper">
					<?php
				}

				if ( $style == 'modern-buttons-on-hover' ) {
					$template_location = locate_template( 'templates/woocommerce/product-modern-buttons-on-hover.php', false, false );
				} elseif ( ( $style == 'style1' || $style == 'style1-center' ) && $atts['carousel'] != 'list' ) {
					$template_location = locate_template( 'templates/woocommerce/product-buttons-on-hover.php', false, false );
				} elseif ( $style == 'style2' && $atts['carousel'] != 'list' ) {

					$template_location = locate_template( 'templates/woocommerce/product-info-on-hover.php', false, false );
					// @if PRO
				} elseif ( $style == 'style3' && $atts['carousel'] != 'list' ) {

					$template_location = locate_template( 'templates/woocommerce/product-info-on-click.php', false, false );

				} elseif ( $style == 'buttonsappearunder' && $atts['carousel'] != 'list' ) {

					$template_location = locate_template( 'templates/woocommerce/product-buttons-appear-under.php', false, false );

				} elseif ( $atts['carousel'] != 'list' ) {

					$template_location = locate_template( 'templates/woocommerce/product-instant-shop.php', false, false );

					// @endif
				} else { // If view mode is list view

					$template_location = locate_template( 'templates/woocommerce/product-list-view.php', false, false );

				}

				while ( $products->have_posts() ) :
					$products->the_post();

					global $product,$post;
					$classes = array();
					// @if PRO
					$devices = array( 'desktop', 'tablet', 'mobile' );
					$show_variations_activation = false;
					foreach ( $devices as $key => $device ) {
						if ( isset( $atts[ 'show_card_variations_' . $device ] ) && $atts[ 'show_card_variations_' . $device ] != true && $atts[ 'show_card_variations_' . $device ] !== '1' ) {
							$classes[] = 'kt-variations-off-' . $device;
						} else {
							$show_variations_activation = true;
						}
					}
					// @endif
					if ( $atts['carousel'] == 'list' ) {
						$classes[] = 'list_view';
					}

					$attachment_ids = $product->get_gallery_image_ids();
					if ( count( $attachment_ids ) && $hover_image == 'show' ) {
						$classes[] = 'has-gallery';
					}

					if ( $border == 'enable' ) {
						$classes[] = 'with-border';
					}

					if ( $responsive_animation != '' ) {
						$class[] = 'no-responsive-animation';
					}
					
					if ( isset( $atts['product_color_scheme'] ) && $atts['product_color_scheme'] == 'dark' ) {
						$classes[] = 'dark';
					}

					$classes[]      = ( $product_style == 'modern-buttons-on-hover' && $product_buttons_style == 'vertical' ) ? 'vertical-buttons' : '';
					$classes[]      = ( $product_style == 'modern-buttons-on-hover' && ( $cart_button_style == 'stretched' || $cart_button_style == 'quantity' ) ) ? 'separated-cart' : '';
					if ( $hide_buttons ) {
						$classes[] = 'hide-product-buttons';
					}

					include $template_location;
				endwhile; // end of the loop.
				kite_woocommerce_shop_loop_action();
				?>

					<?php if ( $atts['carousel'] == 'enable' && count( $products->posts ) >= $columns ) { ?>
							</div>
						</div>

						<div class="arrows-button-next"></div>
						<div class="arrows-button-prev"></div>
					<?php } ?>

					</div>
					<?php // Use </ul> tag instead of calling woocommerce_product_loop_end(); to detect WC shortcodes ?>

					<?php do_action( "woocommerce_shortcode_after_{$loop_name}_loop" ); ?>

				<?php
			endif;

			wc_reset_loop();
			wp_reset_postdata();

			$animation_class = '';
			if ( $animation != 'none' ) {
				$animation_class = ' shortcodeanimation';
			}

			if ( $responsive_animation != '' ) {
				$animation_class .= ' no-responsive-animation';
			}

			$body_class = kite_opt( 'remove_responsive_hover_state', false ) ? $body_class . ' responsive-hover-state-off' : $body_class;
			return '<div class="woocommerce wc-shortcode ' . esc_attr( $body_class ) . ' ' . esc_attr( $gutter ) . ' ' . ( $enterance_animation != 'default' ? esc_attr( $enterance_animation ) : '' ) . ' ' . ( $atts['carousel'] == 'enable' && count( $products->posts ) >= $columns ) . ' ' . esc_attr( $carousel_class . $animation_class . ' ' . $nav_style ) . '"' . ' data-layoutMode="' . esc_attr( $layout ) . '" ' . ( $autoplay == 'on' ? 'data-autoplay="on" ' : '' ) . ( $responsive_autoplay == 'on' ? 'data-responsive-autoplay="on"' : '' ) . ( strlen( esc_attr( $animation ) ) ? ' data-delay="' . esc_attr( $delay ) . '" data-animation="' . esc_attr( $animation ) : '' ) . '">' . ob_get_clean() . '</div>';
		}
	}
}

if ( ! function_exists( 'kite_fetch_woocommerce_products_loop' ) ) {
	function kite_fetch_woocommerce_products_loop() {

		if ( empty( $_GET['kite_nonce'] ) || ! wp_verify_nonce( $_GET['kite_nonce'], 'ajax-nonce' ) ) {
			wp_send_json_error(
				array(
					'message' => 'nonce param required.',
				),
				403
			);
		}

		$atts = array();
		if ( is_array( $_GET['atts'] ) ) {
			foreach ( $_GET['atts'] as $key => $value ) {
				$atts[ $key ] = !is_array( $value ) ? sanitize_text_field( $value ) : $value;
			}
		} else {
			$atts = sanitize_text_field( $_GET['atts'] );
		}

		echo kite_woocommerce_products( $atts );
		die();
	}
}

add_action( 'wp_ajax_fetch_woocommerce_products_loop', 'kite_fetch_woocommerce_products_loop' );
add_action( 'wp_ajax_nopriv_fetch_woocommerce_products_loop', 'kite_fetch_woocommerce_products_loop' );
