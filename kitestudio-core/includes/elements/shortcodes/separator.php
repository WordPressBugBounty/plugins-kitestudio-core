<?php
/*-----------------------------------------------------------------------------------*/
/*  Separators
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_separator' ) ) {
	function kite_sc_separator( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'size'                    => 'full',  // small, small-center, medium, medium-center
					'pxthickness'             => '1',
					'color'                   => '#888',
					'separator_margin_bottom' => '30',
					'separator_margin_top'    => '30',
					'border_style'            => 'solid',
				),
				$atts
			)
		);

		$id    = kite_sc_id( 'vc_separator' );
		$class = array();

		switch ( $size ) {
			case 'small':
				$class[] = 'hr-small';
				break;
			case 'small-center':
				$class[] = 'hr-small hr-center';
				break;
			case 'extra-small':
				$class[] = 'hr-extra-small';
				break;
			case 'extra-small-center':
				$class[] = 'hr-extra-small hr-center   ';
				break;
			case 'medium':
				$class[] = 'hr-medium';
				break;
			case 'medium-center':
				$class[] = 'hr-medium hr-center';
				break;
			case 'full':
				$class[] = ' full';
				break;
		}

		$has_style         = '' != $color || '' != $pxthickness;
		$kite_inline_style = '';
		if ( $has_style ) {
			$hr = '
                border-color: ' . esc_attr( $color ) . ';
                margin-top: ' . esc_attr( $separator_margin_top ) . 'px;
                margin-bottom: ' . esc_attr( $separator_margin_bottom ) . 'px;
                border-style: ' . esc_attr( $border_style ) . ';
                border-width: ' . esc_attr( $pxthickness ) . 'px;
			';
			if ( $pxthickness == 1 ) {
				$kite_inline_style .= "hr#$id{border-bottom-width:0px;}";
			}
		}//End of if
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		ob_start();
		?>

			<hr id="<?php echo esc_attr( $id ); ?>"  class="vc_separator <?php echo esc_attr( implode( ' ', $class ) ); ?>" style="<?php echo esc_attr( $hr ); ?>" />

		<?php
		return ob_get_clean();
	}
}
