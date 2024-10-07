<?php
/*-----------------------------------------------------------------------------------*/
/*  VC carousel
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_imagecarousel' ) ) {
	function kite_sc_imagecarousel( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'nav_style'            => 'dark',
					'images'               => '',
					'hover_color'          => 'c0392b',
					'custom_hover_color'   => '',
					'visible_items'        => '1',
					'image_size'           => 'full',
					'image_size_width'     => '',
					'image_size_height'    => '',
					'image_size_crop'      => '',
					'zoom'                 => '',
					'gutter'               => '',
					'naxt_prev_btn'        => 'show',
					'enterance_animation'  => 'fadein',
					'responsive_animation' => 'disable',
					'is_autoplay'          => 'on',
				),
				$atts
			)
		);

		$id = kite_sc_id( 'image_carousel' );

		$gutter = ( $gutter == 'no' ? 'no-gutter' : '' );

		// Make an array of image IDs
		$image_ids = array();
		if ( $images ) {
			$image_ids = explode( ',', esc_attr( $images ) );
		}

		ob_start();

		if ( $hover_color != 'c0392b' ) {

			$color = 'c0392b';
			if ( isset( $hover_color ) ) {
				if ( $hover_color != 'custom' ) {
					$color = '#' . $hover_color;
				} else {
					if ( isset( $custom_hover_color ) ) {
						$color = $custom_hover_color;
					}
				}
			}

			$kite_inline_style = "#$id.carousel .swiper-slide .image-container:before{background-color:$color;}";
			wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		}
		?>

		<div id="<?php echo esc_attr( $id ); ?>" class="carousel
							<?php
							if ( $enterance_animation != 'default' ) {
								echo 'has-animation';
								if ( $responsive_animation != '' ) {
									echo ' no-responsive-animation';}
							}
							?>
				  <?php echo esc_attr( $enterance_animation ); ?> <?php echo esc_attr( $gutter ); ?> <?php
					if ( strlen( $nav_style ) ) {
								 echo esc_attr( $nav_style ); }
					?>
				  <?php echo esc_attr( $zoom != '' ? 'zoom-hover' : '' ); ?>" data-id="<?php echo esc_attr( $id ); ?>"   data-autoplay="<?php echo esc_attr( $is_autoplay ); ?>" >
			<div class="swiper swiper-<?php echo esc_attr( $id ); ?> clearfix"  data-visibleitems="
																	<?php
																	if ( strlen( $visible_items ) ) {
																		echo esc_attr( $visible_items ); }
																	?>
			">
				<div class="swiper-wrapper">
					<?php
					foreach ( $image_ids as $image_id ) {
						$image_url = wp_get_attachment_image_src( $image_id, $image_size );
						if ( ! is_array( $image_url ) ) {
							$image_url[0] = $image_url;
							$image_url[1] = 'auto';
							$image_url[2] = 'auto';
						}

						if ( ! function_exists( 'aq_resize' ) && $image_size == 'custom' ) {
							$image_size = 'full';
						}

						if ( $image_size == 'custom' && $image_size_width != '' && $image_size_height != '' ) {
							if ( $image_size_crop == 'yes' ) {
									$image_size_crop = true;
							} else {
								$image_size_crop = false;
							}

								$image_link = aq_resize( $image_url[0], $image_size_width, $image_size_height, $image_size_crop, false, true );
							if ( $image_link ) {
								$image_url = $image_link;
							}
						}
						$image = '<img src="data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D\'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg\'%20viewBox%3D\'0%200%20' . $image_url[1] . '%20' . $image_url[2] . '\'%2F%3E" width="' . esc_attr( $image_url[1] ) . '" height="' . esc_attr( $image_url[2] ) . '" data-src="' . esc_url( $image_url[0] ) . '" alt="carousel_image' . esc_attr( $image_id ) . '">';
						?>

						<div class="swiper-slide carousel_item">
							<div class="image-container lazy-load lazy-load-on-load" style="padding-top:<?php echo esc_attr( kite_get_height_percentage( $image ) ); ?>%">
							<?php
							// sanitization performed in above lines!
							echo wp_kses( $image, kite_allowed_html() );
							?>
							</div>
						</div>

					<?php } ?>

				</div>
			</div>

			<?php if ( $naxt_prev_btn == 'show' ) { ?>

			<!-- Next Arrows -->
			<div class="arrows-button-next no-select"></div>

			<!-- Prev Arrows -->
			<div class="arrows-button-prev no-select"></div>

			<?php } ?>

		</div>

		<?php

		return ob_get_clean();
	}
}
