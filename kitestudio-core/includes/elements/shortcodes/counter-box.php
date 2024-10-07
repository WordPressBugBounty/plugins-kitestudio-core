<?php
/*-----------------------------------------------------------------------------------*/
/*  Counter Box
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_conterbox' ) ) {
	function kite_sc_conterbox( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'counter_number'          => '500',
					'counter_number_color'    => '',
					'counter_text_color'      => '',
					'counter_animation'       => 'none',
					'counter_text'            => esc_html__( 'Description', 'kitestudio-core' ),
					'counter_text2'           => '',
					'counter_animation_delay' => '1000',
					'responsive_animation'    => 'disable',
				),
				$atts
			)
		);

		$counter_number = intval( $counter_number );
		$id             = kite_sc_id( 'conterbox' );

		$class = array( 'counterbox' );

		if ( $counter_animation != 'none' ) {

			$class[] = 'shortcodeanimation';

			if ( $responsive_animation != '' ) {
				$class[] = 'no-responsive-animation';
			}
		}
		$kite_inline_style = '';
		if ( strlen( esc_attr( $counter_number_color ) ) ) {
			$kite_inline_style .= "#$id .counterboxnumber {color:" . esc_attr( $counter_number_color ) . ';}';
		}
		if ( strlen( esc_attr( $counter_text_color ) ) ) {
			$kite_inline_style .= "#$id .counterboxdetails,#$id .counterboxdetails2 {color:" . esc_attr( $counter_text_color ) . ';}';
		}
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		ob_start();

		?>

		<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( implode( ' ', $class ) ); ?>"
							<?php
							if ( strlen( esc_attr( $counter_animation ) ) ) {
								?>
			 data-delay="<?php echo esc_attr( $counter_animation_delay ); ?>" data-animation="<?php echo esc_attr( $counter_animation ); ?>" <?php } ?> data-countNmber="<?php echo esc_attr( $counter_number ); ?>">
			<span class="counterboxnumber highlight">0<?php // echo esc_attr($counter_number); ?></span>
			<h4 class="counterboxdetails"><?php echo esc_html( $counter_text ); ?></h4>


			<?php if ( strlen( esc_attr( $counter_text2 ) ) ) { ?>

				<div class="counterboxdetails2"><?php echo esc_html( $counter_text2 ); ?></div>

			<?php } ?>

		</div>

		<?php
		return ob_get_clean();
	}
}
