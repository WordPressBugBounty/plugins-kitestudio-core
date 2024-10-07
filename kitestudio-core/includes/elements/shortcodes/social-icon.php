<?php
/*-----------------------------------------------------------------------------------*/
/*  Social Icon
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_socialIcon' ) ) {
	function kite_sc_socialIcon( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'sociallink_url'   => '',
					'sociallink_type'  => 'facebook',
					'sociallink_style' => 'dark',
					'sociallink_image' => '',
				),
				$atts
			)
		);

		$id = kite_sc_id( 'socialIcon' );
		if ( is_numeric( $sociallink_image ) ) {
			$sociallink_image = wp_get_attachment_url( $sociallink_image );
		}

		if ( esc_attr( $sociallink_type ) == 'custom' ) {
			$sociallink_type = $id;
		}//if social network name was custom

		ob_start();

		?>
	
		<div class="sociallink-shortcode iconstyle <?php echo esc_attr( $sociallink_type ); ?> <?php echo esc_attr( $sociallink_style ); ?>">
			<a id="<?php echo esc_attr( $id ); ?>" href="<?php echo esc_url( $sociallink_url ); ?>" target="_blank">
				<span class="icon icon-<?php echo esc_attr( $sociallink_type ); ?>" style="background-image: url('<?php echo esc_url( $sociallink_image ); ?>') !important;"></span>
			</a>
		</div>
	
		<?php
		return ob_get_clean();
	}
}
