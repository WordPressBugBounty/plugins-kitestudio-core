<?php
/*-----------------------------------------------------------------------------------*/
/*  Icon-Box-custom ( creative iconbox )
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_iconbox_custom' ) ) {
	function kite_sc_iconbox_custom( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'title'                  => '',
					'title_font_type'        => 'default',
					'title_google_fonts'     => '',
					'title_color'            => '',
					'icon'                   => 'keyboard-o',
					'bg_hover_color'         => '#d02d48',
					'icon_color'             => '#d02d48',
					'hover_style'            => 'style1',
					'bg_color'               => 'fff',
					'border_color'           => '252525',
					'text_color_hover_state' => '',
					'image'                  => '',
					'url'                    => '',
					'whole_box_link'         => 'disable',
					'content_text'           => '',
					'content_font_type'      => 'default',
					'content_google_fonts'   => '',
					'elementor_link_title'   => '',
					'new_tab'                => false,
				),
				$atts
			)
		);
		wp_enqueue_style( 'kite-custom-iconbox' );

		$id    = kite_sc_id( 'iconbox' );
		$class = array( 'custom-iconbox', $hover_style );

		if ( is_numeric( $image ) ) {
			$class[] = 'hasimagebackground';
		}

		if ( $url && $whole_box_link == 'enable' ) {
			$class[] = 'whole_link_enable';
		}

		ob_start();
		$allowed_html = kite_allowed_tags();

		$color = $bg_hover_color;

		$title_google_fonts_inline_style   = '';
		$content_google_fonts_inline_style = '';

		if ( $title_font_type != 'default' && function_exists( 'kite_get_fonts_data' ) ) {
			$title_google_fonts_data         = kite_get_fonts_data( $title_google_fonts );
			$title_google_fonts_inline_style = kite_google_fonts_styles( $title_google_fonts_data );
			kite_enqueue_google_fonts( $title_google_fonts_data );
		}

		if ( $content_font_type != 'default' && function_exists( 'kite_get_fonts_data' ) ) {
			$content_google_fonts_data         = kite_get_fonts_data( $content_google_fonts );
			$content_google_fonts_inline_style = kite_google_fonts_styles( $content_google_fonts_data );
			kite_enqueue_google_fonts( $content_google_fonts_data );
		}
		$kite_inline_style = '';
		if ( is_numeric( $image ) ) {
			$image_url = wp_get_attachment_url( $image );

			$kite_inline_style .= ".custom-iconbox#$id .hover-content{background: url($image_url);}";
		}

		if ( strlen( esc_attr( $color ) ) ) {

			$kite_inline_style .= "#$id .overlay:before{background-color:$color;}";
		}
		if ( strlen( $title_color ) ) {
			$kite_inline_style .= "#$id .icon-container h3.title {color:$title_color;}";
		}

		if ( strlen( $bg_color ) ) {
			$kite_inline_style .= "#$id {background-color:$bg_color;}";
		}
		if ( strlen( $icon_color ) ) {
			$kite_inline_style .= "#$id .icon-container .glyph{color:$icon_color;}";
		}
		if ( strlen( $border_color ) ) {
			$kite_inline_style .= "#$id .icon-container{border-color:$border_color;}";
		}
		if ( ! empty( $text_color_hover_state ) ) {
			$kite_inline_style .= "#$id .hover-content .title,#$id .hover-content .content-wrap .content,#$id .hover-content .content-wrap .more-link a {color:$text_color_hover_state;}";
			$kite_inline_style .= "#$id .hover-content .content-wrap .more-link a:before {background-color:$text_color_hover_state;}";
		}
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		?>
	<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( implode( ' ', $class ) ); ?>" >
			<div class="icon">
				<div class="icon-container">
					<span class="glyph <?php echo esc_attr( $icon ); ?>"></span>
					<?php if ( $title != '' ) { ?>
					<h3 class="title" style="<?php echo esc_attr( $title_google_fonts_inline_style ); ?>" ><?php echo esc_html( $title ); ?></h3>
					<?php } ?>
				</div>
			</div>
			<div class="hover-content">
				<span class="overlay"></span>
				<div class="icon">
					<span class="glyph <?php echo esc_attr( $icon ); ?>"></span>
				</div>
				<?php if ( $title != '' ) { ?>
					<h3 class="title" style="<?php echo esc_attr( $title_google_fonts_inline_style ); ?>"><?php echo esc_html( $title ); ?></h3>
				<?php } ?>

				<!-- iconbox content -->
				<div class="content-wrap">
					<?php if ( strlen( $content_text ) ) { ?>

						<div class="content" style="<?php echo esc_attr( $content_google_fonts_inline_style ); ?>">
							<?php echo wp_kses( $content_text, $allowed_html ); ?>
						</div>

					<?php } ?>


					<!-- icon box read more button -->
				<?php
				if ( $url && function_exists( 'vc_build_link' ) && $elementor_link_title == '' ) {

						$link = vc_build_link( $atts['url'] );
					if ( strlen( $link['url'] ) ) {
						?>

						<div class="more-link">
							<a href="<?php echo esc_url( $link['url'] ); ?>"
												<?php
												if ( $link['target'] != '' ) {
													?>
								target="<?php echo esc_attr( $link['target'] ); ?>"<?php } ?>><?php echo esc_html( $link['title'] ); ?></a>
						</div>

						<?php
					}
				} elseif ( $url ) {
					$link['url']    = $url;
					$link['title']  = $elementor_link_title;
					$link['target'] = ( $new_tab ) ? '_blank' : '_self';
					if ( strlen( $link['url'] ) ) {
						?>

						<div class="more-link">
							<a href="<?php echo esc_url( $link['url'] ); ?>"
												<?php
												if ( $link['target'] != '' ) {
													?>
								target="<?php echo esc_attr( $link['target'] ); ?>"<?php } ?>><?php echo esc_html( $link['title'] ); ?></a>
						</div>

						<?php
					}
				}
				?>

				</div>
			</div>
		</div>

		<?php
		return ob_get_clean();
	}
}
