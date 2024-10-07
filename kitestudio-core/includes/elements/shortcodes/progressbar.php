<?php
/*-----------------------------------------------------------------------------------*/
/*  Horizontal progress bar
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_progressbar' ) ) {
	function kite_sc_progressbar( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'title'                       => '',
					'title_color'                 => '',
					'percent'                     => '50',
					'active_bg_color'             => '',
					'inactive_bg_color'           => '',
					'progressbar_animation'       => 'none',
					'progressbar_animation_delay' => '0',
					'responsive_animation'        => 'disable',
				),
				$atts
			)
		);

		$has_style                  = '' != $title_color || '' != $active_bg_color || '' != $inactive_bg_color;
		$id                         = kite_sc_id( 'progressbar' );
		$progressbar_with_animation = '';

		if ( $progressbar_animation != 'none' ) {
			$progressbar_with_animation = ' shortcodeanimation';

			if ( $responsive_animation != '' ) {
				$progressbar_with_animation .= ' no-responsive-animation';
			}
		}

		ob_start();
		$kite_inline_style = '';
		if ( $has_style ) {
			if ( strlen( esc_attr( $active_bg_color ) ) ) {
				$kite_inline_style .= "#$id.progress_bar .progressbar_percent:after{background-color:$active_bg_color;}";
			}

			if ( strlen( esc_attr( $inactive_bg_color ) ) ) {
				$kite_inline_style .= "#$id.progress_bar .progressbar_holder:after{background-color:$inactive_bg_color;}";
			}
		}
		if ( strlen( esc_attr( $title_color ) ) ) {
			$kite_inline_style .= "#$id .progress_title,#$id .progress_percent_value{color:" . esc_attr( $title_color ) . ';}';
		}
		if ( strlen( esc_attr( $active_bg_color ) ) ) {
			$kite_inline_style .= "#$id .progressbar_percent{background-color:" . esc_attr( $active_bg_color ) . ';}';
		}
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		?>

		<div id="<?php echo esc_attr( $id ); ?>"  class="progress_bar <?php echo esc_attr( $progressbar_with_animation ); ?>" data-delay="<?php echo esc_attr( $progressbar_animation_delay ); ?>" data-animation="<?php echo esc_attr( $progressbar_animation ); ?>">
			<div class="progressbar_holder">
				<?php
				if ( $title ) {
					?>
					<span class="progress_title">
					<?php
					if ( esc_attr( $title ) ) {
									echo esc_attr( $title ); }
					?>
					</span><?php } ?>
				<span class="progress_percent_value" style="<?php echo is_rtl() ? 'right:' . esc_attr( $percent ) . '%;left:auto;' : 'left:' . esc_attr( $percent ) . '%;right:auto;'; ?>"><?php echo esc_html( $percent ); ?>%</span>
				<div class="progressbar_percent" data-percentage="
				<?php
				if ( esc_attr( $percent ) ) {
					echo esc_attr( $percent ); }
				?>
					" style="width:<?php echo esc_attr( $percent ); ?>%;"></div>
			</div>
		</div>

		<?php
		return ob_get_clean();
	}
}
