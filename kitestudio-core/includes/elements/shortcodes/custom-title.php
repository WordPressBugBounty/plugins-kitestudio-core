<?php
/*-----------------------------------------------------------------------------------*/
/*  Custom Title
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_customTitle' ) ) {
	function kite_sc_customTitle( $atts ) {
		extract(
			shortcode_atts(
				array(
					'title'                  => '',
					'font_type'              => 'default',
					'google_fonts'           => '',
					'title_color'            => '',
					'title_fontsize'         => '2',
					'hoverline_color'        => '',
					'title_background_style' => 'iconbackground',
					'bg_title'               => '',
					'bg_title_font_size'     => '',
					'bg_title_color'         => '',
					'bg_icon_color'          => '',
					'icon'                   => '',
					'shape_fill_color'       => '',
					'shape_border_color'     => '',
					'letter_spacing'         => '0',
					'style'                  => 'line',
					'title_animation'        => 'none',
					'title_animation_delay'  => '0',
					'responsive_animation'   => 'disable',
				),
				$atts
			)
		);

		if ( ! empty( $bg_title_font_size ) ) {
			$classs[] = 'bgTitleHasFontSize';
		}

		$id = kite_sc_id( 'custom-title' );

		switch ( $letter_spacing ) {
			case '0':
				$class[] = 'letterspacing0';
				break;
			case '1':
				$class[] = 'letterspacing1';
				break;
			case '2':
				$class[] = 'letterspacing2';
				break;
			case '3':
				$class[] = 'letterspacing3';
				break;
			default:
				$class[] = 'letterspacing4';

		}

		switch ( $title_background_style ) {
			case 'iconbackground':
				$class[] = 'iconbackgroundstyle';
				break;
			case 'shapebackground':
				$class[] = 'shapebackgroundstyle';
				break;
			case 'textbackground':
				$class[] = 'textbackgroundstyle';
				break;
		}

		if ( $title_animation != 'none' ) {

			$class[] = 'shortcodeanimation';

			if ( $responsive_animation != '' ) {
				$class[] = 'no-responsive-animation';
			}
		}
		if ( $title_background_style == 'iconbackground' ) {
			$line_height = ( intval( esc_attr( $title_fontsize ) * 3 ) ) . 'vmax';
			$font_size   = ( intval( esc_attr( $title_fontsize ) * 3 ) ) . 'vw';
		} elseif ( $title_background_style == 'textbackground' ) {
			$line_height = ( esc_attr( $bg_title_font_size ) ) . 'vmax';
			$font_size   = ( esc_attr( $bg_title_font_size ) ) . 'vw';
		} elseif ( $title_background_style == 'shapebackground' ) {
			$line_height = ( esc_attr( $title_fontsize ) ) . 'vmax';
			$width       = ( esc_attr( $title_fontsize ) ) . 'vw';
		}

		$google_fonts_inline_style = '';

		if ( $font_type != 'default' && function_exists( 'kite_get_fonts_data' ) ) {
			$google_fonts_data         = kite_get_fonts_data( $google_fonts );
			$google_fonts_inline_style = kite_google_fonts_styles( $google_fonts_data );
			kite_enqueue_google_fonts( $google_fonts_data );
		}

		ob_start();
		$allowed_html = kite_allowed_tags();
		?>
		<?php
		$font_style        = 'calc(' . esc_attr( $title_fontsize ) . 'vw + ' . esc_attr( $title_fontsize - 18 ) . ' * ((100vw - 979px) / 960))!important';
		$kite_inline_style = '';
		if ( strlen( esc_attr( $shape_border_color ) ) && $style == 'triangle' ) {
			$kite_inline_style .= "#$id.custom-title .shape-container .shape-line:after{border-color:$shape_border_color;}";
			$kite_inline_style .= "#$id.custom-title .shape-container .shape-line:before{border-color:$shape_border_color;}";
		}
		$kite_inline_style .= '@media (max-width:979px) {';
		$kite_inline_style .= "#$id.custom-title .title{font-size:$font_style;}";
		if ( $title_background_style == 'shapebackground' ) {
			$kite_inline_style .= "#$id.custom-title .shape-container{width:$font_style;height:$font_style;}";
		}
		$kite_inline_style .= '}';
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		?>

		<div id="<?php echo esc_attr( $id ); ?>" class="custom-title <?php echo esc_attr( implode( ' ', $class ) ); ?>"
							<?php
							if ( strlen( esc_attr( $title_animation ) ) ) {
								?>
			 data-delay="<?php echo esc_attr( $title_animation_delay ); ?>" data-animation="<?php echo esc_attr( $title_animation ); ?>" <?php } ?> style="line-height:<?php echo esc_attr( $line_height ); ?>">
			<?php if ( strlen( $title ) ) { ?>


			<div class="title" style="
				<?php
				if ( strlen( $title_color ) ) {
					?>
				color: <?php echo esc_attr( $title_color ); ?>; <?php }  echo esc_attr( $google_fonts_inline_style ); ?>
								  <?php
									if ( ! empty( $title_fontsize ) ) {
										echo 'font-size:' . esc_attr( $title_fontsize ) . 'vw';}
									?>
		">
				<span>
					<?php echo wp_kses( $title, $allowed_html ); ?>
				</span>


				<?php if ( $title_background_style == 'shapebackground' ) { ?>


					<div class="shape-container <?php echo esc_attr( $style ); ?> " style="height:<?php echo esc_attr( $width ); ?>; width:<?php echo esc_attr( $width ); ?>">

						<?php
						if ( $style == 'line' ) {
							?>
								<div class="back-line"
								<?php
								if ( strlen( $title_color ) ) {
									?>
									 style="background-color: <?php echo esc_attr( $title_color ); ?>;" <?php } ?>></div>
								<div class="hover-line"
								<?php
								if ( strlen( $hoverline_color ) ) {
									?>
									 style="background-color: <?php echo esc_attr( $hoverline_color ); ?>;" <?php } ?>></div>
							<?php
						} elseif ( $style == 'triangle' ) {
							?>
								<div class="shape-line"
								<?php
								if ( strlen( $shape_border_color ) ) {
									?>
									 style="border-color: <?php echo esc_attr( $shape_border_color ); ?>;" <?php } ?>></div>
								<div class="shape-fill"
								<?php
								if ( strlen( $shape_fill_color ) ) {
									?>
									 style="border-bottom-color: <?php echo esc_attr( $shape_fill_color ); ?>;" <?php } ?>></div>

							<?php
						} else {
							?>
								<div class="shape-line" style="
								<?php
								if ( strlen( $shape_fill_color ) && $style != 'triangle' ) {
									?>
									 background-color: <?php echo esc_attr( $shape_fill_color ); ?>; <?php } ?> <?php
										if ( strlen( $shape_border_color ) ) {
											?>
		 border-color: <?php echo esc_attr( $shape_border_color ); ?>; <?php } ?>"></div>
							<?php
						}
						?>

					</div>

				<?php } ?>

			</div>

				<?php
				if ( $title_background_style == 'textbackground' ) {
					$style  = strlen( $bg_title_color ) ? 'color:' . $bg_title_color . ';' : '';
					$style .= $google_fonts_inline_style . ';';
					$style .= 'font-size:' . $font_size . ';';
					?>

				<span class="textbackground"  style="<?php echo esc_attr( $style ); ?>"> <?php echo esc_html( $bg_title ); ?> </span>

				<?php } elseif ( $title_background_style == 'iconbackground' ) { ?>

				<span class="iconbackground" style="font-size:<?php echo esc_attr( $font_size ); ?>">
					<span class="glyph <?php echo esc_attr( $icon ); ?>"
												  <?php
													if ( strlen( $bg_icon_color ) ) {
														?>
						 style="color: <?php echo esc_attr( $bg_icon_color ); ?>;" <?php } ?>></span>
				</span>

				<?php } ?>

			<?php } ?>
		</div>

		<?php
		return ob_get_clean();
	}
}
