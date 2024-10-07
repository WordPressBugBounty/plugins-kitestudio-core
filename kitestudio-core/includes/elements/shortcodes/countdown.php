<?php
/*-----------------------------------------------------------------------------------*/
/*  Countdown
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_countdown' ) ) {
	function kite_sc_countdown( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'end_date'             => '',
					'style'                => '',
					'fontsize'             => '16',
					'bg_color'             => '',
					'color'                => '',
					'label_color'          => '',
					'alignment'            => 'center',
					'animation'            => 'none',
					'animation_delay'      => '1000',
					'responsive_animation' => 'disable',
				),
				$atts
			)
		);

		if ( $end_date == '' ) {
			return;
		}

		$id = kite_sc_id( 'countdown' );

		$class = array( 'countdown-timer' );

		$class[] = 'fontsize' . $fontsize;

		if ( $animation != 'none' ) {
			$class[] = 'shortcodeanimation';

			if ( $responsive_animation != '' ) {
				$class[] = 'no-responsive-animation';
			}
		}

		if ( $style == 'deal_style' ) {
			$class[] = 'secondstyle';
		}

		$color_style = $label_color_style = '';

		if ( $color != '' ) {
			$color_style = 'color:' . $color;
		}

		if ( $label_color != '' ) {
			$label_color_style = 'color:' . $label_color;
		}

		switch ( $alignment ) {
			case 'right':
				$class[] = 'right';
				break;
			case 'center':
				$class[] = 'center';
				break;
			case 'left':
				$class[] = 'left';
				break;
		}

		ob_start();

		?>
		<?php
		$kite_inline_style = '';
		if ( ! empty( $bg_color ) ) {
			$kite_inline_style .= "#$id{background-color:$bg_color}";
		}
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		?>
		<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( implode( ' ', $class ) ); ?>"
							<?php
							if ( strlen( esc_attr( $animation ) ) ) {
								?>
			 data-delay="<?php echo esc_attr( $animation_delay ); ?>" data-animation="<?php echo esc_attr( $animation ); ?>" <?php } ?> data-end="<?php echo esc_attr( $end_date ); ?>">
			<div class="time-block">
				<span class="days number" style="<?php echo esc_attr( $color_style ); ?>">0</span>
				<span class="label" style="<?php echo esc_attr( $label_color_style ); ?>"><?php echo esc_html__( 'Days', 'kitestudio-core' ); ?></span>
			</div>
			<div class="time-block">
				<span class="hours number" style="<?php echo esc_attr( $color_style ); ?>">0</span>
				<span class="label" style="<?php echo esc_attr( $label_color_style ); ?>"><?php echo esc_html__( 'Hours', 'kitestudio-core' ); ?></span>
			</div>
			<div class="time-block">
				<span class="minutes number" style="<?php echo esc_attr( $color_style ); ?>">0</span>
				<span class="label" style="<?php echo esc_attr( $label_color_style ); ?>"><?php echo esc_html__( 'Mins', 'kitestudio-core' ); ?></span>
			</div>
			<div class="time-block">
				<span class="seconds number" style="<?php echo esc_attr( $color_style ); ?>">0</span>
				<span class="label" style="<?php echo esc_attr( $label_color_style ); ?>"><?php echo esc_html__( 'Secs', 'kitestudio-core' ); ?></span>
			</div>
		</div>

		<?php
		return ob_get_clean();
	}
}
