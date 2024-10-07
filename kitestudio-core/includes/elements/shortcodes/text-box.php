<?php
/*-----------------------------------------------------------------------------------*/
/*  Text-Box
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_textbox' ) ) {
	function kite_sc_textbox( $atts, $content ) {
		extract(
			shortcode_atts(
				array(
					'content_align'              => 'left',
					'content_size'               => '100',
					'custom_color_check'         => '',
					'text_content_color'         => '',
					'typing_animation_check'     => '',
					'type_speed'                 => 'very_slow',
					'loop_animation_check'       => '',
					'content_fontsize'           => '16',
					'content_font_type'          => 'default',
					'content_google_fonts'       => '',
					'text_animation'             => 'none',
					'text_animation_delay'       => '0',
					'responsive_animation'       => 'disable',
					'content_custom_font_size'   => '',
					'content_custom_line_height' => '',
				),
				$atts
			)
		);

		$has_content = '' != $content;
		$has_style   = '' != $text_content_color || 'custom' == $content_fontsize || '100' != $content_size;

		$id               = kite_sc_id( 'textbox' );
		$class            = array();
		$content_fs_class = 'fontsize' . $content_fontsize;
		$type             = array();
		$loop             = '0';
		if ( strlen( esc_attr( $loop_animation_check ) ) ) {
			$loop = '1';
		}
		switch ( $type_speed ) {
			case 'very_slow':
				$type = array(
					'type'  => 140,
					'delay' => 7500,
					'back'  => 20,
				);
				break;
			case 'slow':
				$type = array(
					'type'  => 100,
					'delay' => 5000,
					'back'  => 15,
				);
				break;
			case 'normal':
				$type = array(
					'type'  => 60,
					'delay' => 3000,
					'back'  => 10,
				);
				break;
			case 'fast':
				$type = array(
					'type'  => 30,
					'delay' => 2500,
					'back'  => 0,
				);
				break;
			case 'very_fast':
			default:
				$type = array(
					'type'  => 0,
					'delay' => 1500,
					'back'  => 0,
				);
				break;
		}
		$type_speed = $type['type'];
		$back_delay = $type['delay'];
		$back_speed = $type['back'];

		switch ( $content_align ) {
			case 'right':
				$class[] = 'textboxright';
				break;
			case 'center':
				$class[] = 'textboxcenter';
				break;
			case 'left':
			default:
				$class[] = 'textboxleft';

		}

		if ( $text_animation != 'none' ) {

			$class[] = 'shortcodeanimation';
			if ( $responsive_animation != '' ) {
				$class[] = 'no-responsive-animation';
			}
		}

		$content_google_fonts_inline_style = '';
		if ( $content_font_type != 'default' && function_exists( 'kite_get_fonts_data' ) ) {
			$google_fonts_data                 = kite_get_fonts_data( $content_google_fonts );
			$content_google_fonts_inline_style = kite_google_fonts_styles( $google_fonts_data );
			kite_enqueue_google_fonts( $google_fonts_data );
		}

		ob_start();

		$kite_inline_style = '';
		if ( $has_style ) {
			if ( $content_size != '100' ) {
				$kite_inline_style .= '#' . esc_attr( $id ) . ' .text {width:' . $content_size . '%;}';
			}

			if ( $content_fontsize == 'custom' && ! empty( $content_custom_font_size ) ) {
				$content_selector   = "#$id.textbox .text";
				$kite_inline_style .= kite_responsive_font_size( $content_selector, $content_custom_font_size, $content_custom_line_height );
			}

			if ( $custom_color_check == 'enable' ) {
				$kite_inline_style .= '.textbox h1,.textbox h2,.textbox h3,.textbox h4,.textbox h5,.textbox h6, .textbox span:not(#txtbox),.textbox blockquote,.textbox p { color: inherit !important;}';
			}
		}//End of if
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		?>

		<div id="<?php echo esc_attr( $id ); ?>" class="textbox <?php echo esc_attr( implode( ' ', $class ) ); ?>"
							<?php
							if ( strlen( esc_attr( $text_animation ) ) ) {
								?>
			 data-delay="<?php echo esc_attr( $text_animation_delay ); ?>" data-animation="<?php echo esc_attr( $text_animation ); ?>" <?php } ?> <?php
				if ( strlen( esc_attr( $typing_animation_check ) ) ) {
					?>
		 data-animation-txt="true" data-loop="<?php echo ( esc_attr( $loop ) ); ?>" data-speed = "<?php echo esc_attr( $type_speed ); ?>" data-backspeed ="<?php echo esc_attr( $back_speed ); ?>"<?php } ?> >

			<?php
			if ( $has_content ) {
				if ( strlen( esc_attr( $typing_animation_check ) ) ) {
					?>
				<div class="text">
					<span id="txtbox" class="<?php echo esc_attr( $content_fs_class ); ?> txt" style="
														<?php
														if ( strlen( esc_attr( $text_content_color ) ) ) {
															?>
						color: <?php echo esc_attr( $text_content_color ); ?>; <?php } echo esc_attr( $content_google_fonts_inline_style ); ?>" data-text='<?php echo strip_tags( $content ) . ' ^3000'; ?>'>
					</span>
					</div>
					<?php
				} else {
					?>
					<div class="<?php echo esc_attr( $content_fs_class ); ?> text" style="
										   <?php
											if ( strlen( esc_attr( $text_content_color ) ) ) {
												?>
						color: <?php echo esc_attr( $text_content_color ); ?>; <?php } echo esc_attr( $content_google_fonts_inline_style ); ?>"><?php echo wp_kses_post( $content ); ?></div>
				<?php } ?>
			<?php } ?>

		</div>

		<?php
		return ob_get_clean();
	}
}
