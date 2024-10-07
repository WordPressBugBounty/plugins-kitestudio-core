<?php
/*-----------------------------------------------------------------------------------*/
/*  Icon-Box-Circle
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_iconbox_circle' ) ) {
	function kite_sc_iconbox_circle( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'title'                => '',
					'title_font_type'      => 'default',
					'title_google_fonts'   => '',
					'title_color'          => '',
					'icon_animation'       => 'none',
					'icon_animation_delay' => '0',
					'responsive_animation' => 'disable',
					'icon'                 => 'keyboard-o',
					'icon_color'           => '',
					'icon_border'          => 'circle',
					'icon_border_color'    => '',
					'icon_background_fill' => 'fillbackground',
					'icon_position'        => 'top',
					'url'                  => '',
					'whole_box_link'       => 'disable',
					'content_text'         => '',
					'content_font_type'    => 'default',
					'content_google_fonts' => '',
					'content_color'        => '',
					'elementor_link_title' => '',
				),
				$atts
			)
		);
		wp_enqueue_style( 'kite-iconbox-top' );
		$has_title = '' != $title;

		$id    = kite_sc_id( 'iconbox' );
		$class = array( 'iconbox' );

		if ( strlen( $icon_position ) ) {

			$class[] = 'iconbox-top';

		}

		if ( $icon_animation != 'none' ) {

			$class[] = ' shortcodeanimation';

			if ( $responsive_animation != '' ) {
				$class[] = 'no-responsive-animation';
			}
		}

		if ( strlen( $icon_border ) ) {

			$class[] = " $icon_border";

		}

		if ( strlen( $icon_background_fill ) ) {

			$class[] = " $icon_background_fill";

		}
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
		if ( $url && function_exists( 'vc_build_link' ) && $whole_box_link == 'enable' && $elementor_link_title == '' ) {
			$class[] = 'whole_link_enable';
		} elseif ( $url && $elementor_link_title && $whole_box_link == 'enable' ) {
			$class[] = 'whole_link_enable';
		}

		ob_start();
		$allowed_html = kite_allowed_tags();

		?>

		<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( implode( ' ', $class ) ); ?>"
							<?php
							if ( strlen( $icon_animation ) ) {
								?>
			 data-delay="<?php echo esc_attr( $icon_animation_delay ); ?>" data-animation="<?php echo esc_attr( $icon_animation ); ?>" <?php } ?>>
			<div class="icon">
				<span class="glyph <?php echo esc_attr( $icon ); ?>" style="
												   <?php
													if ( strlen( esc_attr( $icon_color ) ) ) {
														?>
					color: <?php echo esc_attr( $icon_color ); ?>;
														<?php
													} if ( strlen( esc_attr( $icon_border_color ) ) ) {
														?>
					 border-color: <?php echo esc_attr( $icon_border_color ); ?>;background-color: <?php echo esc_attr( $icon_border_color ); ?>;<?php } ?>"></span>
			</div>
			<div class="content-wrap">
				<?php if ( $has_title ) { ?>
				<h3 class="title" style="
					<?php
					if ( strlen( esc_attr( $title_color ) ) ) {
						?>
					 color: <?php echo esc_attr( $title_color ); ?>;<?php } ?> <?php echo esc_attr( $title_google_fonts_inline_style ); ?>" ><?php echo esc_html( $title ); ?></h3>
				<?php } ?>

				<!-- iconbox content -->
				<?php if ( strlen( esc_attr( $content_text ) ) ) { ?>

					<div class="content" style="
					<?php
					if ( strlen( esc_attr( $content_color ) ) ) {
						?>
						color: <?php echo esc_attr( $content_color ); ?>;<?php } ?> <?php echo esc_attr( $content_google_fonts_inline_style ); ?>" >
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
								target="<?php echo esc_attr( $link['target'] ); ?>"
													<?php
												} if ( strlen( esc_attr( $content_color ) ) ) {
													?>
								 style="color: <?php echo esc_attr( $content_color ); ?>;" <?php } ?>>[ <?php echo esc_html( $link['title'] ); ?> ]</a>
						</div>

						<?php
					}
				} elseif ( $url && $elementor_link_title ) {
					$link['url']    = $url;
					$link['title']  = $elementor_link_title;
					$link['target'] = '_blank';
					if ( strlen( $link['url'] ) ) {
						?>

						<div class="more-link">
							<a href="<?php echo esc_url( $link['url'] ); ?>"
												<?php
												if ( $link['target'] != '' ) {
													?>
								target="<?php echo esc_attr( $link['target'] ); ?>"
													<?php
												} if ( strlen( esc_attr( $content_color ) ) ) {
													?>
								 style="color: <?php echo esc_attr( $content_color ); ?>;" <?php } ?>>[ <?php echo esc_html( $link['title'] ); ?> ]</a>
						</div>

						<?php
					}
				}
				?>

			</div>
		</div>

		<?php
		return ob_get_clean();
	}
}
