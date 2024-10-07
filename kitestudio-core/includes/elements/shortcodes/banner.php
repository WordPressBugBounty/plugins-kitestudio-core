<?php
/*-----------------------------------------------------------------------------------*/
/*  Banner
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_banner' ) ) {
	function kite_sc_banner( $atts ) {
		extract(
			shortcode_atts(
				array(

					'image_url'                   => '',
					'heading'                     => '',
					'heading_size'                => '16',
					'heading_color'               => '',
					'heading_font_type'           => 'default',
					'heading_google_fonts'        => '',
					'title'                       => '',
					'title_size'                  => '16',
					'title_color'                 => '',
					'subtitle'                    => '',
					'subtitle_size'               => '16',
					'font_type'                   => 'default',
					'sub_font_type'               => 'default',
					'google_fonts'                => '',
					'sub_google_fonts'            => '',
					'subtitle_color'              => '',
					'alignment'                   => 'top_left',
					'image_size'                  => 'full',
					'size'                        => 'default',
					'image_size_width'            => '',
					'image_size_height'           => '',
					'image_size_crop'             => '',
					'hover'                       => 'enable',
					'hover_color_preset'          => 'd02d48',
					'hover_color'                 => '',
					'hover_zoom'                  => 'disable',
					'url'                         => '',
					'new_tab'                     => false,
					'url_title'                   => '',
					'link_color'                  => '',
					'link_bg_color'               => '',
					'button_style'                => 'link',
					'show_button'                 => '',
					'animation'                   => 'none',
					'responsive_animation'        => 'disable',
					'delay'                       => '0',
					'badge'                       => 'disable',
					'badge_content'               => '',
					'badge_bg_color'              => '',
					'badge_content_color'         => '',
					'badge_position'              => 'top left',
					'heading_custom_font_size'    => '',
					'heading_custom_line_height'  => '',
					'title_custom_font_size'      => '',
					'title_custom_line_height'    => '',
					'subtitle_custom_font_size'   => '',
					'subtitle_custom_line_height' => '',
					'content_margin_top'          => '',
					'content_margin_bottom'       => '',
					'content_margin_left'         => '',
					'content_margin_right'        => '',
					'res_content_margin_top'      => '',
					'res_content_margin_bottom'   => '',
					'res_content_margin_left'     => '',
					'res_content_margin_right'    => '',
					'link_size'                   => '16',
					'link_font_type'              => 'default',
					'link_google_fonts'           => '',
					'link_custom_font_size'       => '',
					'link_custom_line_height'     => '',

				),
				$atts
			)
		);
		$image_srcset = '';
		$image_id     = '';
		if ( is_numeric( $image_url ) ) {
			$image_id = $image_url;
			if ( ! kite_opt( 'is_lazy_load_enable', true ) ) {
				$image_srcset = wp_get_attachment_image_srcset( $image_url, $image_size );
			}
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

		$id    = kite_sc_id( 'banner' );
		$class = array();

		$class[] = 'fontsize' . $title_size;

		if ( $animation != 'none' ) {

			$class[] = 'shortcodeanimation';

			if ( $responsive_animation != '' ) {
				$class[] = 'no-responsive-animation';
			}
		}
		if ( ! $image_url ) {
				$class[] = 'no-image';
		}
		$class[] = $alignment;

		$google_fonts_inline_style         = '';
		$sub_google_fonts_inline_style     = '';
		$heading_google_fonts_inline_style = '';
		$link_google_fonts_inline_style    = '';

		if ( function_exists( 'kite_get_fonts_data' ) ) {
			if ( $font_type != 'default' ) {
				$google_fonts_data         = kite_get_fonts_data( $google_fonts );
				$google_fonts_inline_style = kite_google_fonts_styles( $google_fonts_data );
				kite_enqueue_google_fonts( $google_fonts_data );
			}
			if ( $sub_font_type != 'default' ) {
				$sub_google_fonts_data         = kite_get_fonts_data( $sub_google_fonts );
				$sub_google_fonts_inline_style = kite_google_fonts_styles( $sub_google_fonts_data );
				kite_enqueue_google_fonts( $sub_google_fonts_data );
			}
			if ( $heading_font_type != 'default' ) {
				$heading_google_fonts_data         = kite_get_fonts_data( $heading_google_fonts );
				$heading_google_fonts_inline_style = kite_google_fonts_styles( $heading_google_fonts_data );
				kite_enqueue_google_fonts( $heading_google_fonts_data );
			}
			if ( $link_font_type != 'default' ) {
				$link_google_fonts_data         = kite_get_fonts_data( $link_google_fonts );
				$link_google_fonts_inline_style = kite_google_fonts_styles( $link_google_fonts_data );
				kite_enqueue_google_fonts( $link_google_fonts_data );
			}
		}
		if ( function_exists( 'vc_build_link' ) && $url && empty( $url_title ) ) {
			$link = vc_build_link( $url );
			if ( ! empty( esc_attr( $link['title'] ) ) && ! empty( $link['url'] ) ) {
				$class[] = 'has_button';
				if ( $show_button == 'enable' ) {
					$class[] = 'show_button';
				}
			}
		} else {
			$link['title'] = $url_title;
			$link['url']   = $url;
			if ( ! empty( esc_attr( $link['title'] ) ) && ! empty( $link['url'] ) ) {
				$class[] = 'has_button';
				if ( $show_button == 'enable' ) {
					$class[] = 'show_button';
				}
			}
		}

		if ( $heading_size != 'custom' ) {
			$heading_font_size = 'fontsize' . $heading_size;
		} else {
			$heading_font_size = '';
		}

		if ( $title_size != 'custom' ) {
			$title_font_size = 'fontsize' . $title_size;
		} else {
			$title_font_size = '';
		}

		if ( $subtitle_size != 'custom' ) {
			$subtitle_font_size = 'fontsize' . $subtitle_size;
		} else {
			$subtitle_font_size = '';
		}

		if ( $link_size != 'custom' && $button_style != 'fill' ) {
			$link_font_size = 'fontsize' . $link_size;
		} else {
			$link_font_size = '';
		}
		$bsize = array();
		switch ( $size ) {
			case 'small':
				$bsize[] = 'button-small';
				break;
			case 'standard':
				$bsize[] = 'button-medium';
				break;
			case 'default':
				$bsize[] = 'button-default';
				break;
			case 'large':
				$bsize[] = 'button-large';
				break;
		}
		$buttonclass = '';
		if ( $button_style == 'fill' ) {
			$buttonclass = 'kt_button style2 text ' . implode( ' ', $bsize ) . ' ';
		}

		$has_style = '' != $title_color || '' != $subtitle_color || 'enable' == $hover || in_array( 'has_button', $class ) || $title_size == 'custom' || $heading_size == 'custom' || $link_size == 'custom' || 'custom' == $subtitle_size;
		ob_start();
		$allowed_html      = kite_allowed_tags();
		$kite_inline_style = '';
		if ( $has_style ) {
			if ( strlen( esc_attr( $link_color ) ) ) {
				$kite_inline_style .= "#$id.banner a span{color:$link_color;}";
			}
			$color = '';
			if ( ( $hover == 'enable' ) && ( ! empty( $hover_color ) ) ) {
				/*
				 if($hover_color_preset == 'custom')
				{
					$color = $hover_color;
				}
				else
				{ */
					$color = $hover_color;
				// }

				$kite_inline_style .= "#$id:hover .hover{background-color:$color;} ";
			}
			if ( in_array( 'has_button', $class ) ) {
				$acc                = kite_opt( 'style-accent-color', '#5956e9' );
				$kite_inline_style .= '#' . $id . ".banner a.link:hover span{color: $acc !important;}";

				$kite_inline_style .= '#' . $id . ".banner a.link:hover span.txt:after {border-bottom-color : $acc;}";
				if ( ! empty( $link_color ) ) {
					$kite_inline_style .= '#' . $id . ".banner a.link span:after {border-bottom-color: $link_color;}";
				}
				$kite_inline_style .= '#' . $id . '.banner a.fill {';

				if ( ! empty( $link_bg_color ) ) {
					$kite_inline_style .= "background-color: $link_bg_color;border-color: $link_bg_color;";
				}
				$kite_inline_style .= '}';
				$kite_inline_style .= '#' . $id . ".banner a.fill:hover {background-color: $acc;border-color:$acc;}";

			}
			?>
			<?php
			// heading custom font sizes
			$heading_selector   = "#$id.banner .content .heading";
			$kite_inline_style .= kite_responsive_font_size( $heading_selector, $heading_custom_font_size, $heading_custom_line_height );

			// title custom font sizes
			$title_selector     = "#$id.banner .content .title";
			$kite_inline_style .= kite_responsive_font_size( $title_selector, $title_custom_font_size, $title_custom_line_height );

			// subtitle custom font sizes
			$subtitle_selector  = "#$id.banner .content .subtitle";
			$kite_inline_style .= kite_responsive_font_size( $subtitle_selector, $subtitle_custom_font_size, $subtitle_custom_line_height );

			$link_selector      = "#$id.banner a";
			$kite_inline_style .= kite_responsive_font_size( $link_selector, $link_custom_font_size, $link_custom_line_height );

			$kite_inline_style     .= '@media (min-width:1025px) {';
				$kite_inline_style .= '#' . $id . '.banner .content{';
			if ( $content_margin_top != '' ) {
				$kite_inline_style .= "margin-top: $content_margin_top" . 'px;';
			}
			if ( $content_margin_bottom != '' ) {
				$kite_inline_style .= "margin-bottom: $content_margin_bottom" . 'px;';
			}
			if ( $content_margin_left != '' ) {
				$kite_inline_style .= "margin-left: $content_margin_left" . 'px;';
			}
			if ( $content_margin_right != '' ) {
				$kite_inline_style .= "margin-right: $content_margin_right" . 'px;';
			}
				$kite_inline_style .= '}';
			$kite_inline_style     .= '}';
			$kite_inline_style     .= '@media (max-width:1024px) {';
				$kite_inline_style .= '#' . $id . '.banner .content{';
			if ( $res_content_margin_top != '' ) {
				$kite_inline_style .= "margin-top: $res_content_margin_top" . 'px;';
			}
			if ( $res_content_margin_bottom != '' ) {
				$kite_inline_style .= "margin-bottom: $res_content_margin_bottom" . 'px;';
			}
			if ( $res_content_margin_left != '' ) {
				$kite_inline_style .= "margin-left: $res_content_margin_left" . 'px;';
			}
			if ( $res_content_margin_right != '' ) {
				$kite_inline_style .= "margin-right: $res_content_margin_right" . 'px;';
			}
				$kite_inline_style .= '}';
			$kite_inline_style     .= '}';

		}//End of if
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );

		$width  = ( $image_size == 'custom' && $image_size_width != '' && $image_size_height != '' ) ? $image_size_width : $image_url[1];
		$height = ( $image_size == 'custom' && $image_size_width != '' && $image_size_height != '' ) ? $image_size_height : $image_url[2];
		if ( kite_opt( 'is_lazy_load_enable', true ) ) {
			$lazy_load_class  = 'lazy-load lazy-load-on-load';
			$image_src_attrib = 'src="data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D\'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg\'%20viewBox%3D\'0%200%20' . esc_attr( $width ) . '%20' . esc_attr( $height ) . '\'%2F%3E" data-src="' . esc_url( $image_url[0] ) . '"';
		} else {
			$lazy_load_class  = '';
			$image_src_attrib = 'src="' . esc_url( $image_url[0] ) . '"';
			if ( ! empty( $image_srcset ) ) {
				$image_src_attrib .= ' srcset="' . esc_attr( $image_srcset ) . '"';
			}
		}

		?>

		<div id="<?php echo esc_attr( $id ); ?>" class="banner  <?php echo implode( ' ', $class ); ?> <?php
		if ( $hover_zoom != 'disable' ) {
			echo 'zoom';}
		?>
		"
		<?php
		if ( wp_is_mobile() ) {
			?>
			  style="background-image:url('<?php echo esc_url( $image_url[0] ); ?> ');" <?php } ?> <?php
				if ( strlen( esc_attr( $animation ) ) ) {
					?>
			 data-delay="<?php echo esc_attr( $delay ); ?>" data-animation="<?php echo esc_attr( $animation ); ?>" <?php } ?>>
			<?php if ( isset( $image_url[0] ) && strlen( esc_url( $image_url[0] ) ) ) { ?>
				<div class="image <?php echo esc_attr( $lazy_load_class ); ?>">

					<?php if ( $hover == 'enable' ) { ?>
						<!-- imagebox Hover  -->
						<div class="hover"></div>
					<?php } ?>
					<?php
					$image_id = ! empty( $image_id ) ? $image_id : attachment_url_to_postid( $image_url[0] );
					echo '<img ' . $image_src_attrib . ' width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '"' . ' alt="' . esc_attr( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) . '">';
					?>
				</div>
				<?php
			}
			?>
			<div class="content-container">
				<?php if ( $badge == 'enable' && ! empty( $badge_content ) ) { ?>
					<div class="badge <?php echo esc_attr( $badge_position ); ?>" style="
												 <?php
													if ( ! empty( $badge_bg_color ) ) {
														echo 'background-color:' . esc_attr( $badge_bg_color ) . ';';}
													?>
					<?php
					if ( ! empty( $badge_content_color ) ) {
						echo 'color:' . esc_attr( $badge_content_color ) . ';';}
					?>
	"><span><?php echo wp_kses_post( $badge_content ); ?></span></div>
				<?php } ?>
				<div class="content">
							<?php if ( $heading != '' ) { ?>
							<span class="heading clearfix <?php echo esc_attr( $heading_font_size ); ?>" style="
																	 <?php
																		echo esc_attr( $heading_google_fonts_inline_style ); if ( strlen( esc_attr( $heading_color ) ) ) {
																			?>
								  color: <?php echo esc_attr( $heading_color ); ?>; <?php } ?>">
								<?php echo wp_kses( $heading, $allowed_html ); ?>
							</span>
							<?php } ?>
							<?php if ( $title != '' ) { ?>
							<span class="title clearfix <?php echo esc_attr( $title_font_size ); ?>" style="
																   <?php
																	echo esc_attr( $google_fonts_inline_style ); if ( strlen( esc_attr( $title_color ) ) ) {
																		?>
								  color: <?php echo esc_attr( $title_color ); ?>; <?php } ?>">
								<?php echo wp_kses( $title, $allowed_html ); ?>
							</span>
							<?php } ?>
							<?php if ( $subtitle != '' ) { ?>
								<span class="subtitle <?php echo esc_attr( $subtitle_font_size ); ?>" style="
																 <?php
																	echo esc_attr( $sub_google_fonts_inline_style ); if ( strlen( esc_attr( $subtitle_color ) ) ) {
																		?>
									color: <?php echo esc_attr( $subtitle_color ); ?>; <?php } ?>">
								<?php
								echo wp_kses( $subtitle, $allowed_html );
								?>
								</span>
								<?php
							}

							?>

						<?php

						if ( $url && function_exists( 'vc_build_link' ) && empty( $url_title ) ) {

							$link = vc_build_link( $atts['url'] );
							if ( strlen( $link['url'] ) ) {
								?>

							<a class="
								<?php
								echo esc_attr( $buttonclass );
								echo esc_attr( $button_style );
								?>
								<?php echo esc_attr( $link_font_size ); ?>" href="<?php echo esc_url( $link['url'] ); ?>"
								<?php
								if ( $link['target'] != '' ) {
									?>
		target="<?php echo esc_attr( $link['target'] ); ?>"
									<?php
								} else {
									?>
								target="_self" <?php } ?> style ="
								<?php
								if ( strlen( esc_attr( $link_color ) ) ) {
									?>
			color: <?php echo esc_attr( $link_color ); ?>;
									<?php
									if ( $button_style == 'link' ) {
										?>
		 border-color: <?php echo esc_attr( $link_color ); ?>;<?php } ?> <?php
								} if ( empty( esc_attr( $link['title'] ) ) ) {
										   echo 'display:none;';}
								?>
	"><span class="txt" style="<?php echo esc_attr( $link_google_fonts_inline_style ); ?>"><?php echo esc_html( $link['title'] ); ?></span></a>

								<?php
							}
						} else {
							if ( $url ) {
								$link['url'] = $url;
								if ( $new_tab ) {
									$link['target'] = '_blank';
								} else {
									$link['target'] = '_self';
								}
								$link['title'] = $url_title;
								if ( strlen( $link['url'] ) ) {
									if ( empty( $url_title ) ) {
										$buttonclass  = '';
										$button_style = 'link';
									}

									?>

								<a class="
									<?php
									echo esc_attr( $buttonclass );
									echo esc_attr( $button_style );
									?>
									<?php echo esc_attr( $link_font_size ); ?>" href="<?php echo esc_url( $link['url'] ); ?>"
									<?php
									if ( $link['target'] != '' ) {
										?>
		target="<?php echo esc_attr( $link['target'] ); ?>"<?php } ?> style ="
									<?php
									if ( strlen( esc_attr( $link_color ) ) ) {
										?>
			color: <?php echo esc_attr( $link_color ); ?>;
										<?php
										if ( $button_style == 'link' ) {
											?>
		 border-color: <?php echo esc_attr( $link_color ); ?>;
											<?php
										}
									} if ( empty( esc_attr( $link['title'] ) ) ) {
										echo 'display:none;';}
									?>
		"><span class="txt" style="<?php echo esc_attr( $link_google_fonts_inline_style ); ?>"><?php echo esc_html( $link['title'] ); ?></span></a>

									<?php
								}
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
