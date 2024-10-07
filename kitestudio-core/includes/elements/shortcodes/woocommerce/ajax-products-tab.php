<?php
if ( ! function_exists( 'kite_ajax_products_tab' ) ) {
	function kite_ajax_products_tab( $atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'heading_title'		 => '',
				'heading_subtitle'		 => '',
				'position'           => 'top',
				'alignment'          => 'center',
				'style'              => 'dark',
				'shape'              => 'left',
				'active_tab_color'   => '',
				'deactive_tab_color' => '',
			),
			$atts
		);

		$classes   = array();
		$classes[] = 'vc_tta-style-' . trim( esc_attr( $atts['style'] ) );
		$classes[] = 'vc_tta-tabs-position-' . trim( esc_attr( $atts['position'] ) );
		$classes[] = 'vc_tta-o-shape-group vc_tta-shape-' . trim( esc_attr( $atts['shape'] ) );
		$classes[] = 'vc_tta-controls-align-' . trim( esc_attr( $atts['alignment'] ) );

		$tabs = array();
		preg_match_all( '/' . get_shortcode_regex() . '/', $content, $tabs );

		if ( empty( $tabs ) ) {
			return;
		}

		// Get Tab List Titles and Icons from content
		$tab_titles = array();
		$tab_icons  = array();
		foreach ( $tabs[0] as $key => $tab ) {

			$title      = array();
			$icon       = array();
			$icon_check = array();

			preg_match_all( '/tab_title=".+?(?=")"/', $tab, $title );
			if ( ! empty( $title[0] ) ) {
				$exploded_title     = explode( '"', $title[0][0] );
				$tab_titles[ $key ] = $exploded_title[1];
			} else {
				$tab_titles[ $key ] = esc_html__( 'Tab', 'kitestudio-core' ) . ' ' . ( $key + 1 );
			}

			preg_match_all( '/tab_icon_check=".+?(?=")"/', $tab, $icon_check );
			preg_match_all( '/tab_icon=".+?(?=")"/', $tab, $icon );
			$tab_icons[ $key ] = '';
			if ( ! empty( $icon_check[0] ) ) {
				$exploded_icon_check = explode( '"', $icon_check[0][0] );
				if ( $exploded_icon_check[1] == 'enable' ) {
					$exploded_icon = explode( '"', $icon[0][0] );
					if ( ! empty( $exploded_icon[1] ) ) {
						$tab_icons[ $key ] = $exploded_icon[1];
					}
				}
			}
		}

		if ( ! function_exists( 'kite_generate_tab_list' ) ) {
			function kite_generate_tab_list( $output, $tabs, $tab_titles, $tab_icons, $heading_title, $heading_subtitle ) {
				$output     .= '<div class="vc_tta-tabs-container">';
				if ( !empty( $heading_title ) ) {
					$output .= '<h2>' . esc_html( $heading_title ) . '</h2>';
				}

				if ( !empty( $heading_subtitle ) ) {
					$output .= '<span class="subtitle">' . $heading_subtitle . '</span>';
				}
					$output .= '<ul class="vc_tta-tabs-list">';
				foreach ( $tab_titles as $key => $title ) {
					$output .= "<li class='vc_tta-tab " . ( ( $key == 0 ) ? 'vc_active' : '' ) . "' data-shortcode-prop='" . kite_extract_woocommerce_shortcode_attributes( $tabs[0][ $key ] ) . "' data-tab-id='" . $key . "'><a>";
					if ( ! empty( $tab_icons[ $key ] ) ) {
						if ( ! strpos( $tab_icons[ $key ], 'icon ' ) ) {
							$tab_icons[ $key ] = 'icon ' . $tab_icons[ $key ];
						}
							$output .= '<span class="vc_tta-icon ' . $tab_icons[ $key ] . '"></span>';
					}
							$output .= '<span class="vc_tta-title-text">' . $title . '</span>';
							$output .= '</a></li>';
				}
					$output .= '</ul>';
					$output .= '</div>';
					return $output;
			}
		}

		$first_tab = do_shortcode( $tabs[0][0] );
		$id        = kite_sc_id( 'ajax_products_tab' );
		ob_start();
		if ( ! empty( esc_attr( $atts['active_tab_color'] ) ) || ! empty( esc_attr( $atts['deactive_tab_color'] ) ) ) {
			$kite_inline_style = '';
			if ( ! empty( esc_attr( $atts['active_tab_color'] ) ) ) {
				$kite_inline_style .= '#' . $id . '.ajax_products_tab ul.vc_tta-tabs-list li.vc_active span {color:' . esc_attr( $atts['active_tab_color'] ) . ' !important;} #' . $id . '.ajax_products_tab ul.vc_tta-tabs-list li.vc_active {border-top-color:' . esc_attr( $atts['active_tab_color'] ) . ' !important;border-bottom-color:' . esc_attr( $atts['active_tab_color'] ) . ' !important;}';
			}
			if ( ! empty( esc_attr( $atts['deactive_tab_color'] ) ) ) {
				$kite_inline_style .= '#' . $id . '.ajax_products_tab ul.vc_tta-tabs-list li span {color:' . esc_attr( $atts['deactive_tab_color'] ) . ';}';
			}
			wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		}
		$output      = '<div id=' . $id . ' class="vc_tta-container ajax_products_tab" >';
			$output .= '<div class="vc_general vc_tta vc_tta-tabs ' . esc_attr( implode( ' ', $classes ) ) . '">';

		if ( in_array( $atts['position'], [ 'top', 'left', 'right' ] ) ) {
			$output = kite_generate_tab_list( $output, $tabs, $tab_titles, $tab_icons, $atts['heading_title'], $atts['heading_subtitle'] );
		}
				$output             .= '<div class="vc_tta-panels-container">';
					$output         .= '<div class="vc_tta-panels" style="">';
						$output     .= '<span class="wc-loading hide"></span>';
						$output     .= '<div class="vc_tta-panel vc_active_show show vc_active" data-tab-id="0">';
							$output .= $first_tab;
						$output     .= '</div>';
					$output         .= '</div>';
				$output             .= '</div>';
		if ( $atts['position'] == 'bottom' ) {
			$output = kite_generate_tab_list( $output, $tabs, $tab_titles, $tab_icons, $atts['heading_title'], $atts['heading_subtitle'] );
		}
			$output .= '</div>';
		$output     .= '</div>';

		echo wp_kses_post( $output );
		return ob_get_clean();
	}
}

if ( ! function_exists( 'kite_extract_woocommerce_shortcode_attributes' ) ) {
	function kite_extract_woocommerce_shortcode_attributes( $woocommerce_shortcode ) {
		$defaults                   = array(
			'tab_title'                    => '',
			'tab_icon_check'               => '',
			'tab_icon'                     => '',
			'product_type'                 => 'top_rated',
			'per_page'                     => '12',
			'columns'                      => '1',
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
			'hover_price'                  => 'enable',
			'hover_color'                  => 'c0392b',
			'custom_hover_color'           => '',
			'animation'                    => 'none',
			'delay'                        => '0',
			'list_style'                   => 'light',
			'product_color_scheme'         => 'light',
			'column_in_mobile'             => '1',
			'tablet_columns'               => '3',
			'body_class'                   => '',
			'show_card_variations_desktop' => true,
			'show_card_variations_tablet'  => true,
			'show_card_variations_mobile'  => true,
		);
		$founded_attributes         = array();
		$woocommerce_shortcode_atts = shortcode_parse_atts( $woocommerce_shortcode );
		foreach ( $defaults as $key => $value ) {
			if ( ! array_key_exists( $key, $woocommerce_shortcode_atts ) ) {
				continue;
			}
			if ( $woocommerce_shortcode_atts[ $key ] != $value ) {
				$founded_attributes[ $key ] = $woocommerce_shortcode_atts[ $key ];
			}
		}

		return wp_json_encode( $founded_attributes );
	}
}

if ( ! function_exists( 'kite_fetch_woocommerce_shortcode_dom' ) ) {
	function kite_fetch_woocommerce_shortcode_dom() {

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

		echo '<div class="vc_tta-panel vc_active_show show vc_active" data-tab-id="' . esc_attr( $_GET['tab_id'] ) . '">' . kite_woocommerce_products( $atts ) . '</div>';
		die();
	}
}

add_action( 'wp_ajax_fetch_woocommerce_shortcode_dom', 'kite_fetch_woocommerce_shortcode_dom' );
add_action( 'wp_ajax_nopriv_fetch_woocommerce_shortcode_dom', 'kite_fetch_woocommerce_shortcode_dom' );
