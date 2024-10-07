<?php
/*-----------------------------------------------------------------------------------*/
/*  Instagram feed
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_instgram_feed' ) ) {
	function kite_sc_instgram_feed( $atts ) {
		extract(
			shortcode_atts(
				array(
					'method'               => '',
					'user'                 => 'teta_cosmetic',
					'posts_count'          => '10',
					'column'               => '1',
					'image_resolution'     => 'thumbnail',
					'gutter'               => '',
					'carousel'             => 'disable',
					'naxt_prev_btn'        => 'show',
					'nav_style'            => 'light',
					'hover_color'          => '',
					'custom_hover_color'   => '',
					'like'                 => '',
					'comment'              => '',
					'enterance_animation'  => 'fadein',
					'responsive_animation' => 'disable',
					'delay'                => '0',
					'equal_height_width'   => 'enable',
				),
				$atts
			)
		);

		$id           = kite_sc_id( 'instagram_feed' );
		$ajax_request = false;
		if ( $method == 'api' && class_exists( 'Kite_Instagram_Api' ) ) {
			$media_array = Kite_Instagram_Api::get_instance()->get_media_list();
		} else {
			$media_array = kite_scrape_instagram( $user, $posts_count );
		}

		if ( is_wp_error( $media_array ) ) {
			$ajax_request = true;
		} elseif ( empty( $media_array ) ) {
			return '';
		}

		$gutter = ( $gutter == 'no' ? 'no-gutter' : '' );

		if ( $posts_count < $column ) {
			$post_count = $column;
		}

		$carousel_class      = '';
		$carousel_item_class = '';
		if ( $carousel == 'enable' ) {
			$carousel_class = 'carousel instagram-carousel';

			$carousel_item_class = 'insta-media';
		}

			$color = '#c0392b';
		if ( isset( $hover_color ) ) {
			if ( $hover_color != 'custom' && $hover_color != '' ) {
				$color = '#' . $hover_color;
			} else {
				if ( isset( $custom_hover_color ) && $custom_hover_color != '' ) {
					if ( strpos( $custom_hover_color, '#' ) === false ) {
						$custom_hover_color = '#' . $custom_hover_color;
					}

					$color = $custom_hover_color;
				}
			}
		}
		if ( $ajax_request ) {
			$by_hashtag = ( substr( $user, 0, 1 ) == '#' );
			$hashtag    = $by_hashtag ? 'enable' : '';
			$data_insta = array(
				'username'   => $user,
				'resolution' => $image_resolution,
				'image_num'  => $posts_count,
				'hashtag'    => $hashtag,
				'carousel'   => $carousel_item_class,
				'like'       => $like,
				'comment'    => $comment,
			);
			$data_insta = wp_json_encode( $data_insta );
		}
			$kite_inline_style = ".instagram-feed#$id .instagram-img .hover{background-color:$color;}";
			wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
			ob_start();
		?>
			<div class="instagram-feed
			<?php
			echo esc_attr( $enterance_animation );
			if ( $responsive_animation != '' ) {
				echo ' no-responsive-animation'; }
			?>
			 <?php
				if ( $ajax_request ) {
					echo 'insta-ajax';}
				?>
				" id="<?php echo esc_attr( $id ); ?>" data-equal-height-width="
		 <?php
			if ( $equal_height_width == 'enable' ) {
				echo 'true';
			} else {
				echo 'false';
			}
			?>
		"
		<?php
		if ( $ajax_request ) {
			echo "data-insta='" . esc_attr( $data_insta ) . "'";}
		?>
		>

				<!-- header instagram  -->
				<div class="instagramfeed <?php echo 'column-' . esc_attr( $column ) . ' ' . esc_attr( $gutter ) . ' ' . esc_attr( $carousel_class ) . ' ' . esc_attr( $nav_style ); ?> <?php
				if ( $enterance_animation != 'default' ) {
					?>
					 has-animation <?php } ?>">
					<?php
					if ( $carousel == 'enable' ) {
						?>
							<div class="swiper" data-visibleitems="<?php echo esc_attr( $column ); ?>">
								<div class="swiper-wrapper lazy-load-hover-container">
						<?php
					}
					$i = 1;
					if ( ! $ajax_request ) {
						foreach ( $media_array as $item ) {

							if ( $i > $posts_count ) {
								break;
							}
							$i++;

							if ( $method == 'api' ) {
								$image        = $item['media_url'];
								$item['link'] = $item['permalink'];
							} else {
								if ( $image_resolution == 'low_resolution' || $image_resolution == 'low_resolution_crop' || $image_resolution == 'standard_resolution' || $image_resolution == 'standard_resolution_crop' ) {
									$image = $item['large'];
								} else {
									$image = $item[ $image_resolution ];
								}
							}

							$media_tag = "<img src=\"data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==\" class=\"media\" data-src=\"{$image}\"/>";

							$content  = '<div class="instagram-img ' . esc_attr( $carousel_item_class ) . ' " >';
							$content .= '<a  href="' . esc_url( $item['link'] ) . '" target="_blank">';

							$content .= '<img src="' . esc_url( $image ) . '" alt="instagram_feed"/>';

							$content .= '<div class="hover"></div>
									<div class="content">';

							if ( $method != 'api' ) {
								if ( $like == 'enable' ) {
									$content .= '<span class="like">' . kite_pretty_number( $item['likes'] ) . '</span>';
								}

								if ( $comment == 'enable' ) {
									$content .= '<span class="comment">' . kite_pretty_number( $item['comments'] ) . '</span>';
								}
							}

							$content .= '</div>';

							// output media
							echo wp_kses_post( $content ) . '</a></div>';

						}
					}

					if ( $carousel == 'enable' ) {
						?>
								</div>
							</div>
						<?php
					}

					if ( $naxt_prev_btn == 'show' ) {
						?>
						<div class="arrows-button-next"></div>
						<div class="arrows-button-prev"></div>
						<?php
					}

					?>
				</div>
			</div>

			<?php
			return ob_get_clean();
	}
}
