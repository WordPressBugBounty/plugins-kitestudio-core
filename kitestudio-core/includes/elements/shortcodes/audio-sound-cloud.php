<?php

/*-----------------------------------------------------------------------------------*/
/*  Audio SoundCloud
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_audio_soundcloud' ) ) {
	function kite_sc_audio_soundcloud( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'soundcloud_id'     => '',
					'soundcloud_height' => 'auto',
					'soundcloud_style'  => 'full_width_thumbnail',
					'soundcloud_color'  => '',
				),
				$atts
			)
		);

		$id = kite_sc_id( 'audio_soundcloud' );
		?>
	
		<?php
		ob_start();
		?>
	
		<div class="soundcloud_shortcode" id="<?php echo esc_attr( $id ); ?>">
		<?php
		if ( esc_attr( $soundcloud_style ) == 'full_width_thumbnail' ) {
			echo wp_oembed_get( $soundcloud_id, array( 'height' => $soundcloud_height ) );
		} else {
			$soundcloud_id .= '?color=' . str_replace( '#', '', esc_attr( $soundcloud_color ) );
			echo wp_oembed_get( $soundcloud_id );
		}
		?>
		</div>
	
		<?php
		return ob_get_clean();
	}
}
