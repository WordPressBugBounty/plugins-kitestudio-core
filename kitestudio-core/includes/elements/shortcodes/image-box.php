<?php
/*-----------------------------------------------------------------------------------*/
/*  Image-Box
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_imagebox' ) ) {
	function kite_sc_imagebox( $atts ) {
		extract(
			shortcode_atts(
				array(
					'image_url'                   => '',
					'image_size'                  => 'full',
					'image_size_width'            => '',
					'image_size_height'           => '',
					'image_size_crop'             => '',
					'image_hover'                 => 'enable',
					'image_hover_shadow'          => 'disable',
					'image_hover_color_preset'    => 'c0392b',
					'image_hover_color_custom'    => '',
					'image_animation'             => 'none',
					'image_animation_delay'       => '0',
					'responsive_animation'        => 'disable',
					'title'                       => '',
					'image_title_size'            => '16',
					'font_type'                   => 'default',
					'google_fonts'                => '',
					'title_color'                 => '',
					'subtitle'                    => '',
					'subtitle_fontsize'           => '16',
					'subtitle_color'              => '',
					'image_text_color'            => '',
					'image_text_align'            => 'left',
					'image_text_background_color' => '',
					'image_text_border'           => 'disable',
					'imagebox_content_border'     => 'enable',
					'image_text_border_color'     => '',
					'vccontent'                   => '',
					'content_fontsize'            => '16',
					'url'                         => '',
					'target'                      => '_self',
					'title_custom_font_size'      => '',
					'title_custom_line_height'    => '',
					'subtitle_custom_font_size'   => '',
					'subtitle_custom_line_height' => '',
					'content_custom_font_size'    => '',
					'content_custom_line_height'  => '',
				),
				$atts
			)
		);

		$image_id = '';
		if ( is_numeric( $image_url ) ) {
			$image_id  = $image_url;
			$image_url = wp_get_attachment_image_src( $image_url, $image_size );
		}

		if ( ! function_exists( 'aq_resize' ) && $image_size == 'custom' ) {
			$image_size = 'full';
		}

		if ( $image_size == 'custom' && $image_size_width != '' && $image_size_height != '' ) {
			if ( $image_size_crop == 'yes' ) {
					$image_size_crop = true;
			} else {
				$image_size_crop = false;
			}

				$image_link = aq_resize( $image_url[0], $image_size_width, $image_size_height, $image_size_crop, false, true );
			if ( $image_link ) {
				$image_url = $image_link;
			}
		} else {
			$image_size = esc_attr( $image_size );
		}

		$has_title     = '' != $title;
		$has_url       = '' != $url;
		$has_sub_title = '' != $subtitle;
		$has_style     = '' != $title_color || '' != $subtitle_color || '' != $image_text_color || '' != $image_text_background_color || '' != $image_text_border_color || 'c0392b' != $image_hover_color_preset || 'custom' == $image_title_size || 'custom' == $subtitle_fontsize || 'custom' == $content_fontsize;

		$has_ts_content   = '' != $title || '' != $subtitle || '' != $vccontent;
		$has_vc_content   = '' != $vccontent;
		$content_fs_class = 'fontsize' . $content_fontsize;

		$id    = kite_sc_id( 'imagebox' );
		$class = array();

		$title_font_size    = 'fontsize' . $image_title_size;
		$subtitle_font_size = 'fontsize' . $subtitle_fontsize;

		switch ( $image_text_align ) {
			case 'right':
				$class[] = 'imageboxright';
				break;
			case 'center':
				$class[] = 'imageboxcenter';
				break;
			case 'left':
			default:
				$class[] = 'imageboxleft';
		}

		if ( $image_animation != 'none' ) {

			$class[] = 'shortcodeanimation';

			if ( $responsive_animation != '' ) {
				$class[] = 'no-responsive-animation';
			}
		}

		if ( $image_hover == 'enable' ) {
			$class[] = 'imgboxhover';
		}

		if ( $image_hover_shadow == 'enable' ) {
			$class[] = 'image_hover_shadow';
		}

		if ( $imagebox_content_border == 'disable' ) {

			 $class[] = 'disablecontentborder';

		}

		$google_fonts_inline_style = '';
		if ( $font_type != 'default' && function_exists( 'kite_get_fonts_data' ) ) {
			$google_fonts_data         = kite_get_fonts_data( $google_fonts );
			$google_fonts_inline_style = kite_google_fonts_styles( $google_fonts_data );
			kite_enqueue_google_fonts( $google_fonts_data );
		}

		ob_start();
		$allowed_html = kite_allowed_tags();
		$color        = '';

		$kite_inline_style = '';
		if ( $has_style ) {
			if ( $image_hover == 'enable' ) {

				if ( esc_attr( $image_hover_color_preset ) == 'custom' ) {
					$color = $image_hover_color_custom;
				} else {
					$color = '#' . $image_hover_color_preset;
				}
			}
			if ( $image_title_size == 'custom' && ! empty( $title_custom_font_size ) ) {
				$title_selector     = "#$id.imagebox .content .title";
				$kite_inline_style .= kite_responsive_font_size( $title_selector, $title_custom_font_size, $title_custom_line_height );

			}

			if ( $subtitle_fontsize == 'custom' && ! empty( $subtitle_custom_font_size ) ) {
				$subtitle_selector  = "#$id.imagebox .content .subtitle";
				$kite_inline_style .= kite_responsive_font_size( $subtitle_selector, $subtitle_custom_font_size, $subtitle_custom_line_height );

			}

			if ( $content_fontsize == 'custom' && ! empty( $content_custom_font_size ) ) {
				$content_selector   = "#$id.imagebox .content .text";
				$kite_inline_style .= kite_responsive_font_size( $content_selector, $content_custom_font_size, $content_custom_line_height );

			}
		}//if($has_style)
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		?>

		<?php if ( $has_url ) { ?>

			 <a id="<?php echo esc_attr( $id ); ?>" class="imagebox
							   <?php
								if ( $has_ts_content ) {
									?>
					 textbox textLeftBorder <?php } ?> <?php
						if ( strlen( esc_attr( $subtitle ) ) == 0 ) {
							?>
		  nosubtitle  <?php } ?> <?php echo esc_attr( implode( ' ', $class ) ); ?>"
							  <?php
								if ( strlen( esc_attr( $image_animation ) ) ) {
									?>
		 data-delay="<?php echo esc_attr( $image_animation_delay ); ?>" data-animation="<?php echo esc_attr( $image_animation ); ?>" <?php } ?>  href="<?php echo esc_url( $url ); ?>"
								<?php
								if ( $target != '' ) {
									?>
		target="<?php echo esc_attr( $target ); ?>"<?php } ?>>

		<?php } else { ?>

			 <div id="<?php echo esc_attr( $id ); ?>" class="imagebox
								 <?php
									if ( $has_ts_content ) {
										?>
					 textbox textLeftBorder <?php } ?> <?php
						if ( strlen( esc_attr( $subtitle ) ) == 0 ) {
							?>
		  nosubtitle  <?php } ?> <?php echo esc_attr( implode( ' ', $class ) ); ?>"
							  <?php
								if ( strlen( esc_attr( $image_animation ) ) ) {
									?>
		 data-delay="<?php echo esc_attr( $image_animation_delay ); ?>" data-animation="<?php echo esc_attr( $image_animation ); ?>" <?php } ?> >

		<?php } ?>

		<?php
		if ( isset( $image_url[0] ) && strlen( esc_url( $image_url[0] ) ) ) {
			?>
			<div class="image">

				<?php if ( $image_hover == 'enable' ) { ?>
					<!-- imagebox Hover  -->
					<div class="imagebox-hover"  style="background-color:<?php echo esc_attr( $color ); ?>;"></div>
				<?php } ?>

				<img src="<?php echo esc_url( $image_url[0] ); ?>"
									 <?php
										if ( esc_attr( $title ) ) {
											?>
					 alt="<?php echo esc_attr( $title ); ?>"
											<?php
										} else {
											?>
								 alt="
											<?php
											$image_id = ! empty( $image_id ) ? $image_id : attachment_url_to_postid( $image_url[0] );
											if ( $post_title = get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) {
												echo esc_attr( $post_title );}
											?>
							" <?php } ?>>
			</div>
		<?php } ?>

			 <?php if ( $has_ts_content ) { ?>
				<div class="content" style="
					<?php
					if ( strlen( esc_attr( $image_text_border_color ) ) ) {
						?>
					border:solid 1px <?php echo esc_attr( $image_text_border_color ); ?>;
						<?php
					} if ( strlen( esc_attr( $image_text_background_color ) ) ) {
						?>
					 background-color: <?php echo esc_attr( $image_text_background_color ); ?>;<?php } ?> ">
					<?php if ( $has_title ) { ?>

						<div class="clearfix">
							<div class="title clearfix <?php echo esc_attr( $title_font_size ); ?>"  style="
																  <?php
																	if ( strlen( esc_attr( $title_color ) ) ) {
																		?>
								color:<?php echo esc_attr( $title_color ); ?>; <?php } echo esc_attr( $google_fonts_inline_style ); ?>">

								<?php echo wp_kses( $title, $allowed_html ); ?>

								<?php if ( $has_sub_title ) { ?>
									<!-- subtitle -->
									<span class="subtitle <?php echo esc_attr( $subtitle_font_size ); ?>" style="
																	 <?php
																		if ( strlen( esc_attr( $subtitle_color ) ) ) {
																			?>
										color: <?php echo esc_attr( $subtitle_color ); ?>; <?php } echo esc_attr( $google_fonts_inline_style ); ?> "><?php echo esc_html( $subtitle ); ?></span>
								<?php } ?>

							</div>
						</div>

					<?php } ?>
					<?php if ( $has_vc_content ) { ?>

					<div class="<?php echo esc_attr( $content_fs_class ); ?> text" style="
										   <?php
											if ( strlen( esc_attr( $image_text_color ) ) ) {
												?>
						color: <?php echo esc_attr( $image_text_color ); ?>; <?php } echo esc_attr( $google_fonts_inline_style ); ?>"><?php echo wp_kses( $vccontent, $allowed_html ); ?></div>

					<?php } ?>
				</div>
			<?php } ?>

		<?php if ( $has_url ) { ?>

			 </a>

		<?php } else { ?>

			</div>

		<?php } ?>


		<?php
		return ob_get_clean();
	}
}
