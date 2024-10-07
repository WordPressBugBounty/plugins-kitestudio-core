<?php
/*-----------------------------------------------------------------------------------*/
/*  Pie Chart
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_piechart' ) ) {
	function kite_sc_piechart( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'title'                    => '',
					'title_color'              => '',
					'subtitle'                 => '',
					'subtitle_color'           => '',
					'piechart_percent'         => '70',
					'piechart_percent_display' => 'enable',
					'piechart_color_preset'    => 'd02d48',
					'piechart_color'           => '',
					'main_color'               => '',
					'piechart_icon'            => '',
					'piechart_animation'       => 'none',
					'piechart_animation_delay' => '0',
					'responsive_animation'     => 'disable',
				),
				$atts
			)
		);

		if ( $piechart_color_preset != 'custom' ) {
			$piechart_color = '#' . $piechart_color_preset;
		}

		$class                   = 'piechart easypiechart';
		$piechart_with_animation = '';
		$id                      = kite_sc_id( 'piechart' );

		if ( $piechart_animation != 'none' ) {
			$piechart_with_animation = ' shortcodeanimation';

			if ( $responsive_animation != '' ) {
				$piechart_with_animation .= ' no-responsive-animation';
			}
		}

		if ( strpos( $piechart_icon, 'fa-') ) {
			kite_load_elementor_font_awesome();
		}

		ob_start();
		?>

		<div id="<?php echo esc_attr( $id ); ?>" class="piechartbox <?php echo esc_attr( $piechart_with_animation ); ?> <?php
		if ( $piechart_percent_display == 'disable' ) {
			?>
			 disablepercent <?php } ?>"
			<?php
			if ( strlen( esc_attr( $piechart_animation ) ) ) {
				?>
		 data-delay="<?php echo esc_attr( $piechart_animation_delay ); ?>" data-animation="<?php echo esc_attr( $piechart_animation ); ?>" <?php } ?> <?php
			if ( esc_attr( $piechart_color ) ) {
				?>
		 data-barColor=<?php echo esc_attr( $piechart_color ); } ?>>
			<div class="
			<?php
			if ( $piechart_icon ) {
				?>
				iconpchart <?php } ?> <?php echo esc_attr( $class ); ?>" data-percent="<?php echo esc_attr( $piechart_percent ); ?>">
				<?php if ( $piechart_icon ) { ?>
					<span class="icon <?php echo esc_attr( $piechart_icon ); ?>"
												 <?php
													if ( strlen( esc_attr( $main_color ) ) ) {
														?>
						 style="color:<?php echo esc_attr( $main_color ); ?>;" <?php } ?>></span>
				<?php } ?>
				<?php if ( $piechart_percent_display == 'enable' ) { ?>
					<span class="perecent"
					<?php
					if ( strlen( esc_attr( $main_color ) ) ) {
						?>
						 style="color:<?php echo esc_attr( $main_color ); ?>;" <?php } ?>><?php echo esc_html( $piechart_percent ); ?><span class="piechart_percent">%</span></span>
				<?php } ?>
				<div class="dot-container">
					<div class="dot"
					<?php
					if ( strlen( esc_attr( $main_color ) ) ) {
						?>
						 style="background-color:<?php echo esc_attr( $main_color ); ?>;" <?php } ?>></div>
				</div>
			</div>
			<p class="title"
			<?php
			if ( strlen( esc_attr( $title_color ) ) ) {
				?>
				 style="color:<?php echo esc_attr( $title_color ); ?>;" <?php } ?>><?php echo esc_html( $title ); ?></p>
			<p class="subtitle"
			<?php
			if ( strlen( esc_attr( $subtitle_color ) ) ) {
				?>
				 style="color:<?php echo esc_attr( $subtitle_color ); ?>;" <?php } ?>><?php echo esc_html( $subtitle ); ?></p>
		</div>

		<?php
		return ob_get_clean();
	}
}
