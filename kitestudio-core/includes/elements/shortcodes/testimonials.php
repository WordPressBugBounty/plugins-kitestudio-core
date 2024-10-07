<?php
/*-----------------------------------------------------------------------------------*/
/* Testimonials shortcode
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_testimonial' ) ) {
	function kite_sc_testimonial( $atts, $content = null ) {
		$class = '';
		extract(
			shortcode_atts(
				array(
					'style'                       => 'Dark',
					'visible_items'               => '1',
					'testimonial_animation'       => 'none',
					'testimonial_animation_delay' => '0',
					'responsive_animation'        => 'disable',
					'arrow_navigation'			  => 'enable',
					'bullet_navigation'			  => false,
					'scroll_navigation'			  => false
				),
				$atts
			)
		);

		$class .= 'carousel';

		$class .= ' testimonials-style ';
		$class .= ' testimonials-' . $visible_items;

		$animation_params           = '';
		$testimonial_with_animation = '';

		if ( $testimonial_animation != 'none' ) {
			$testimonial_with_animation = ' shortcodeanimation';
			$animation_params           = " data-delay='" . esc_attr( $testimonial_animation_delay ) . "' data-animation='" . esc_attr( $testimonial_animation ) . "'";

			if ( $responsive_animation != '' ) {
				$testimonial_with_animation .= ' no-responsive-animation';
			}
		};

		$id = kite_sc_id( 'testimonial' );
		ob_start();
		?>


		<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?> <?php
		echo esc_attr( $testimonial_with_animation );
		if ( $style == 'light' ) {
			echo ' skin-light'; }
		?>
		" data-id="<?php echo esc_attr( $id ); ?>" <?php echo esc_attr( $animation_params ); ?>>
			<div class="swiper swiper-<?php echo esc_attr( $id ); ?> clearfix" data-visibleitems="
																	 <?php
																		if ( strlen( $visible_items ) ) {
																			echo esc_attr( $visible_items ); }
																		?>
			">
				<div class="swiper-wrapper">
					<?php
					if ( is_array( $content ) ) {
						foreach ( $content as $key => $testimonial_item ) {
							echo kite_sc_testimonial_item( $testimonial_item );
						}
					} else {
						echo wp_kses_post( do_shortcode( $content ) );
					}
					?>
				</div>
			</div>

			<?php if ( ! empty( $bullet_navigation ) && $bullet_navigation === 'enable' ) { ?>
				<!-- If we need pagination -->
  				<div class="swiper-pagination"></div>
			<?php } ?>

			<?php if ( ! empty( $arrow_navigation ) && $arrow_navigation === 'enable' ) { ?>
			<!-- Next Arrows -->
			<div class="arrows-button-next no-select arrows-button-next-<?php echo esc_attr( $id ); ?>">
			</div>
			<!-- Prev Arrows -->
			<div class="arrows-button-prev no-select arrows-button-prev-<?php echo esc_attr( $id ); ?>">
			</div>

			<?php } ?>

			<?php if ( ! empty( $scroll_navigation ) && $scroll_navigation === 'enable' ) { ?>
				<!-- If we need scrollbar -->
  				<div class="swiper-scrollbar"></div>
			<?php } ?>

		</div>

		<?php

		return ob_get_clean();
	}
}

/*-----------------------------------------------------------------------------------*/
/* Testimonial item shortcode
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_testimonial_item' ) ) {
	function kite_sc_testimonial_item( $atts, $content = null ) {

		extract(
			shortcode_atts(
				array(
					'author'    => '',
					'text'      => '',
					'job'       => '',
					'image_url' => '',
				),
				$atts
			)
		);

		$html = $authorimg = '';
		if ( is_numeric( $image_url ) ) {
			$authorimg = wp_get_attachment_url( $image_url );
		}

		ob_start();
		$allowed_html = kite_allowed_tags();

		?>

		<div class="swiper-slide testimonial">
			<div class="quote">

			<blockquote><?php echo wp_kses( $text, $allowed_html ); ?> </blockquote>
				<div class="head">
					<?php if ( ! empty( $authorimg ) ) { ?>
					<div class="author-image" style="background-image:url(<?php echo esc_attr( $authorimg ); ?>)"></div>
					<?php } ?>
					<?php if ( ! empty( $author ) || ! empty( $job ) ) { ?>
						<div class="author">
							<?php if ( ! empty( $author ) ) { ?>
								<h4 class="name"><?php echo esc_html( $author ); ?> </h4>
							<?php } ?>
							<?php if ( ! empty( $job ) ) { ?>
								<cite class="job"><?php echo esc_html( $job ); ?> </cite>
							<?php } ?>
						</div>
					<?php } ?>
				</div>

			</div>
		</div>

		<?php

		return ob_get_clean();
	}
}
