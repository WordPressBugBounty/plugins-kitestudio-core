<?php
/*-----------------------------------------------------------------------------------*/
/*  Title with horizontal line
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_title' ) ) {
	function kite_sc_title( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'title'                   => 'Title',
					'title_align'             => 'separator_align_center',
					'title_font_size'         => '20',
					'title_weight'            => 'bold',
					'title_border_enable'     => 'disable',
					'pxthickness'             => '1',
					'title_color'             => '#464646',
					'color'                   => '#888',
					'separator_margin_bottom' => '30',
					'separator_margin_top'    => '30',
					'border_style'            => 'solid',
				),
				$atts
			)
		);

		$id = kite_sc_id( 'vc_text_separator' );

		$vc_sep_line = '<span class="vc_sep_line" style=" border-color: ' . esc_attr( $color ) . ';border-style: ' . esc_attr( $border_style ) . ';border-top-width: ' . esc_attr( $pxthickness ) . 'px;height:' . esc_attr( $pxthickness ) . 'px;top:' . ceil( ( (int) esc_attr( -( $pxthickness ) ) ) / 2 ) . 'px;"></span>';
		ob_start();
		?>

		<div id=<?php echo esc_attr( $id ); ?> class="vc_separator <?php echo esc_attr( $title_align ); ?> <?php echo esc_attr( $title_border_enable ); ?>" style=" margin-top: <?php echo esc_attr( $separator_margin_top ); ?>px; margin-bottom: <?php echo esc_attr( $separator_margin_bottom ); ?>px;">
			<span class="vc_sep_holder vc_sep_holder_l">
				<?Php echo wp_kses_post( $vc_sep_line ); ?>
			</span>
			<div class="title" style ="border-left-color:<?php echo esc_attr( $color ); ?>; border-right-color:<?php echo esc_attr( $color ); ?>; font-size:<?php echo esc_attr( $title_font_size ); ?>px; font-weight:<?php echo esc_attr( $title_weight ); ?>; color:<?php echo esc_attr( $title_color ); ?>;"><?php echo esc_html( $title ); ?></div>
			<span class="vc_sep_holder vc_sep_holder_r">
				<?Php echo wp_kses_post( $vc_sep_line ); ?>
			</span>
		</div>

		<?php
		return ob_get_clean();
	}
}
