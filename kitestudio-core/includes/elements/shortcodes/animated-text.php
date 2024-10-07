<?php
/*-----------------------------------------------------------------------------------*/
/*  Animated Text
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_animated_text' ) ) {
	function kite_sc_animated_text( $atts ) {
		extract(
			shortcode_atts(
				array(
					'image_url'              => '',
					'title'                  => '',
					'title_front_color'      => '#ffffff',
					'title_back_color'       => '#272727',
					'animatedtext_font_size' => '30',
					'animatedtext_style'     => 'with_image',
					'font_type'              => 'default',
					'google_fonts'           => '',
					'animatedtext_speed'     => '8',
				),
				$atts
			)
		);
		$image_url = wp_get_attachment_url( $image_url );
		$id        = kite_sc_id( 'animatedtext' );

		// let us show the animation even if there is no image
		if ( $image_url ) {
			$text_height  = 'auto';
			$image_output = '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $title ) . '">';// echo image tag if this is of type with image
		} else {
			$text_height  = ( intval( $animatedtext_font_size ) * 1.5 ) . 'vw';
			$image_output = '';
		}
		$animation_duration = strlen( $title ) * intval( esc_attr( $animatedtext_speed ) );// Duration of cycling

		$google_fonts_inline_style = '';
		if ( $font_type != 'default' && function_exists( 'kite_get_fonts_data' ) ) {
			$google_fonts_data         = kite_get_fonts_data( $google_fonts );
			$google_fonts_inline_style = kite_google_fonts_styles( $google_fonts_data );
			kite_enqueue_google_fonts( $google_fonts_data );
		}
		$kite_inline_style  = "#$id .firsttitle {color:$title_front_color;}";
		$kite_inline_style .= "#$id .secondtitle {color:$title_back_color;}";
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		ob_start();
		?>
		<div class="animatedtext_content" style="height:<?php echo esc_attr( $text_height ); ?>;">
		<div id="<?php echo esc_attr( $id ); ?>" class="animatedtext">
		   <div class="image">
			   <?php
				// sanitization performed in above lines!
				echo wp_kses( $image_output, kite_allowed_html() );
				?>
		   </div>
		   <span class="slideshowcontent" style="font-size:<?php echo esc_attr( $animatedtext_font_size ) . 'vw'; ?>;">
			   <span class="firsttitle" style="animation-duration:<?php echo esc_attr( $animation_duration ) . 's'; ?>; <?php echo esc_attr( $google_fonts_inline_style ); ?>">
				   <span class="immediate"><?php echo esc_html( $title ); ?><?php echo esc_html( $title ); ?><?php echo esc_html( $title ); ?><?php echo esc_html( $title ); ?></span>
				   <span class="immediate"><?php echo esc_html( $title ); ?><?php echo esc_html( $title ); ?><?php echo esc_html( $title ); ?><?php echo esc_html( $title ); ?></span>
			   </span>
		   </span>
		</div>
		<span class="secondtitle" style="animation-duration:<?php echo esc_attr( $animation_duration ) . 's'; ?>; font-size:<?php echo esc_attr( $animatedtext_font_size ) . 'vw'; ?>; <?php echo esc_attr( $google_fonts_inline_style ); ?>">
			 <span class="immediate"><?php echo esc_html( $title ); ?><?php echo esc_html( $title ); ?><?php echo esc_html( $title ); ?><?php echo esc_html( $title ); ?></span>
			 <span class="immediate"><?php echo esc_html( $title ); ?><?php echo esc_html( $title ); ?><?php echo esc_html( $title ); ?><?php echo esc_html( $title ); ?></span>
		</span>
		</div>
		<?php
		return ob_get_clean();
	}
}
