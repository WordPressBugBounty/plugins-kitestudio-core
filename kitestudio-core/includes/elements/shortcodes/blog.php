<?php
/*-----------------------------------------------------------------------------------*/
/*  Masonry Blog - Cart blog
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_blog_masonry' ) ) {
	function kite_sc_blog_masonry( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'blog_column'                 => '3',
					'blog_category'               => '',
					'blog_post_number'            => '16',
					'blog_more_button'            => 'disable',
					'blog_foreground_color'       => 'dark',
					'blog_layout_mode'            => 'masonry',
					'blog_background_color'       => '',
					'quote_blog_background_color' => '#073B87',
					'quote_blog_text_color'       => '#fff',
					'blog_category_author'        => 'yes',
					'blog_filter'                 => 'all',
					'blog_style'                  => 'inline_interaction',
					'enterance_animation'         => 'fadein',
					'responsive_animation'        => 'disable',
					'blog_category_visibility'    => 'yes',
					'blog_multimedia_icon_style'  => 'light',
					'load_more_style'             => 'dark',
					'blog_image_size'             => 'large',
					'blog_image_size_width'       => '',
					'blog_image_size_height'      => '',
					'blog_image_size_crop'        => '',
				),
				$atts
			)
		);

		$query = $width = $sub_str = $col = $id = '';

		$i = 0;

		$id          = kite_sc_id( 'blog-masonry' );
		$postpage    = isset( $_GET['postpage'] ) ? (int) sanitize_text_field( $_GET['postpage'] ) : 1;
		$more_button = '';
		if ( $blog_more_button == 'disable' ) {
			$more_button = 'disablemore ';
		}

		if ( $blog_category == '' ) {
			$category_array = '';
			$arrg           = array(
				'posts_per_page' => $blog_post_number,
				'paged'          => $postpage,
				'post_type'      => 'post',
			);
		} else {
			$category_array = explode( ',', $blog_category );
			$arrg           = array(
				'tax_query'      => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => $category_array,
					),
				),
				'posts_per_page' => $blog_post_number,
				'paged'          => $postpage,
				'post_type'      => 'post',
			);
		}

		$query = new WP_Query( $arrg );

		$post_count = $query->found_posts;
		$max        = ceil( $post_count / $blog_post_number );

		if ( $blog_column == '3' ) {
			$width = 100 / 3;
			$col   = 3;
		} else {
			$width = 100 / 4;
			$col   = 4;
		}

		ob_start();
		$kite_inline_style = '';
		$color             = '';
		if ( ! empty( $blog_background_color ) ) {
				$color              = $blog_background_color;
				$kite_inline_style .= ".$id .blog-masonry-container {background-color: $color;}";
		}

		$kite_inline_style .= ".$id .blog-masonry-container.kt_quote {background-color: $quote_blog_background_color;}";

		$kite_inline_style .= ".$id .blog-masonry-container .video-img{width:100%;}";

		$kite_inline_style .= ".$id .blog-masonry-container .blog-masonry-content .like-count,.$id .blog-masonry-container .blog-masonry-content .post-share:hover .share-hover i{color: $blog_background_color;}";

		$kite_inline_style .= ".$id .blog-masonry-container.kt_quote .icon,.$id .blog-masonry-container.kt_quote .blog-masonry-content .blog-excerpt,.$id .blog-masonry-container.kt_quote .blog-masonry-content .quote-author  {color: $quote_blog_text_color;}";
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		?>
		<div id="<?php echo esc_attr( $id ); ?>" class="blogloop <?php echo esc_attr( $id ); ?> masonry-blog isotope clearfix
							<?php
							echo esc_attr( $more_button );
							echo esc_attr( $blog_style );
							?>
		 blogcolumn<?php echo esc_attr( $blog_column ); ?>  <?php
			if ( $enterance_animation != 'default' ) {
				echo 'has-animation';
				if ( $responsive_animation != '' ) {
					echo ' no-responsive-animation';}
			}
			?>
		 <?php echo esc_attr( $enterance_animation ); ?>" data-columnnumber="<?php echo esc_attr( $blog_column ); ?>" data-layoutmode="<?php echo esc_attr( $blog_layout_mode ); ?>" data-id="<?php echo esc_attr( $id ); ?>" data-page="1" data-maxpages="<?php echo esc_attr( $max ); ?>">

			<?php
			while ( $query->have_posts() ) {
				$i++;
				$query->the_post();
				global $post;

				if ( strlen( get_the_excerpt() ) > 100 ) {
					$sub_str = '...';
				} else {
					$sub_str = '';
				}

				$format = get_post_meta( get_the_ID(), 'media', true );
				if ( $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'Kite_thumbnail-auto-height' ) ) {
					$thumb = $thumb[0];
				} else {
					$thumb = get_the_post_thumbnail_url();
				}
				?>
			<div class="isotope-item">
				<div class="blog_item">
					<div class="blog-masonry-container kt_lightgallery <?php echo esc_attr( $blog_foreground_color ); ?> <?php echo 'kt_' . esc_attr( $format ); ?>"
																				  <?php
																					if ( $format == 'quote' && ! ( empty( $thumb[0] ) ) ) {
																						?>
						 style="background-image:url(<?php echo esc_attr( $thumb ); ?>);" <?php } ?> >

						<?php
						if ( $format == 'audio' ) {

								$audio = get_post_meta( get_the_ID(), 'audio-url', true );
							?>
							 <?php
								if ( $audio != null ) {
									?>

									<?php if ( $blog_style == 'popup_interaction' ) { ?>

										<?php
										if ( ! function_exists( 'aq_resize' ) && $blog_image_size == 'custom' ) {
											$blog_image_size = 'large';
										}
										$post_thumbnail_id = get_post_thumbnail_id();
										if ( $blog_image_size == 'custom' && $blog_image_size_width != '' && $blog_image_size_height != '' ) {
											if ( $blog_image_size_crop == 'yes' ) {
													$blog_image_size_crop = true;
											} else {
												$blog_image_size_crop = false;
											}
											$image_url  = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
											$image_link = aq_resize( $image_url[0], $blog_image_size_width, $blog_image_size_height, $blog_image_size_crop, false, true );
											$thumb      = array();
											$thumb[0]   = $image_link ? $image_link[0] : $image_url[0];
											$thumb[1]   = $blog_image_size_width;
											$thumb[2]   = $blog_image_size_height;

										} elseif ( $blog_image_size == 'large' ) {
											$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );
										} else {
											$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'Kite_thumbnail-auto-height' );
										}

										if ( $thumb != false ) {
											$image = '<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width="' . esc_attr( $thumb[1] ) . '" height="' . esc_attr( $thumb[2] ) . '" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" data-src="' . esc_url( $thumb[0] ) . '" alt="' . ( ( $img_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) ? esc_attr( $img_alt ) : '' ) . '"/>';
										} else {
											$image = '<div class="cartblogaudioplaceholder"></div>';
										}
										?>

										<?php if ( $thumb != false ) { ?>

										<div class="soundcloud-format galleryitem" data-iframe="true" data-src="https://w.soundcloud.com/player/?visual=true&url=<?php echo esc_attr( $audio ); ?>">
											<div class="image-container lazy-load lazy-load-on-load" style="padding-top:<?php echo esc_attr( kite_get_height_percentage( $image ) ); ?>%">
											   <div class="play-button-wrap">
													<a>
														<div class="play-button <?php echo esc_attr( $blog_multimedia_icon_style ); ?>">
															<span class="glyph icon icon-music-note3"></span>
														</div>
													</a>
												</div>
												<?php
												// Sanitization performed in above lines!
												echo wp_kses( $image, kite_allowed_html() );
												?>
											</div>
										</div>

								<?php } ?>

										<?php
									} else {

										echo kite_sc_audio_soundcloud([
											'soundcloud_id' => $audio
										]);

									}
									?>

							<?php } ?>

							<?php
						} elseif ( $format == 'gallery' ) {

							if ( ! function_exists( 'aq_resize' ) && $blog_image_size == 'custom' ) {
								$blog_image_size = 'large';
							}
							$post_thumbnail_id = get_post_thumbnail_id();
							if ( $blog_image_size == 'custom' && $blog_image_size_width != '' && $blog_image_size_height != '' ) {
								if ( $blog_image_size_crop == 'yes' ) {
										$blog_image_size_crop = true;
								} else {
									$blog_image_size_crop = false;
								}
								$image_url  = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
								$image_link = aq_resize( $image_url[0], $blog_image_size_width, $blog_image_size_height, $blog_image_size_crop, false, true );
								$thumb      = array();
								$thumb[0]   = $image_link ? $image_link[0] : $image_url[0];
								$thumb[1]   = $blog_image_size_width;
								$thumb[2]   = $blog_image_size_height;
							} elseif ( $blog_image_size == 'large' ) {
								$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );
							} else {
								$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'Kite_thumbnail-auto-height' );
							}

							$image = '<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width="' . esc_attr( $thumb[1] ) . '" height="' . esc_attr( $thumb[2] ) . '" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" data-src="' . esc_url( $thumb[0] ) . '" alt="' . ( ( $img_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) ? esc_attr( $img_alt ) : '' ) . '"/>';

							if ( $thumb != false ) {
								?>
								<div class="image-container lazy-load lazy-load-on-load" style="padding-top:<?php echo esc_attr( kite_get_height_percentage( $image ) ); ?>%">
									   <?php

										// Sanitization performed in above lines!
										echo wp_kses( $image, kite_allowed_html() );
										?>
								</div>
								 <?php
							} else {
								?>
								<!-- If we don't have images -->
								   <div class="cartblogplaceholder"></div>
							<?php } ?>
							<?php
						} elseif ( $format == 'video' ) {
							$video_url = get_post_meta( get_the_ID(), 'video-id', true );
							$host      = get_post_meta( get_the_ID(), 'video-type', true );

							if ( $blog_style == 'popup_interaction' ) {
								?>

								<?php

								if ( ! function_exists( 'aq_resize' ) && $blog_image_size == 'custom' ) {
									$blog_image_size = 'large';
								}

								$post_thumbnail_id = get_post_thumbnail_id();
								if ( $blog_image_size == 'custom' && $blog_image_size_width != '' && $blog_image_size_height != '' ) {
									if ( $blog_image_size_crop == 'yes' ) {
											$blog_image_size_crop = true;
									} else {
										$blog_image_size_crop = false;
									}
									$image_url  = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
									$image_link = aq_resize( $image_url[0], $blog_image_size_width, $blog_image_size_height, $blog_image_size_crop, false, true );
									$thumb      = array();
									$thumb[0]   = $image_link ? $image_link[0] : $image_url[0];
									$thumb[1]   = $blog_image_size_width;
									$thumb[2]   = $blog_image_size_height;

								} elseif ( $blog_image_size == 'large' ) {
									$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );
								} else {
									$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'Kite_thumbnail-auto-height' );
								}

								if ( $thumb != false ) {  // if set features image
									$image = '<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width="' . esc_attr( $thumb[1] ) . '" height="' . esc_attr( $thumb[2] ) . '" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" data-src="' . esc_url( $thumb[0] ) . '" alt="' . ( ( $img_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) ? esc_attr( $img_alt ) : '' ) . '"/>';
								}

								?>

								<?php if ( $thumb != false ) { // if set features image ?>
									<div class="video-format"  data-id="<?php echo esc_attr( $id ); ?>">
										<div class="video_buttons_wrap">
											<a class="galleryitem" href="<?php echo esc_url( $video_url ); ?>">
												<div class="image-container lazy-load lazy-load-on-load" style="padding-top:<?php echo esc_attr( kite_get_height_percentage( $image ) ); ?>%">
													<?php
													// Sanitization performed in above lines!
													echo wp_kses( $image, kite_allowed_html() );
													?>
												</div>
												<div class="play-button <?php echo esc_attr( $blog_multimedia_icon_style ); ?>">
													<span class="glyph icon  icon-play2"></span>
												</div>
											</a>
										</div>
									</div>

							   <?php } ?>

								<?php
							} else {

								  $video_display_type = "embeded_video_$host";
								if ( $video_display_type == 'local_video' ) {

								} elseif ( $video_display_type == 'embeded_video_vimeo' ) {
									?>

								<div data-id="<?php echo esc_attr( $id ); ?>">
									<?php 
									echo kite_sc_embed_video([
										'video_display_type' => 'embeded_video_vimeo',
										'video_vimeo_id' => $video_url
									]);
									?>
								</div>

									<?php
								} elseif ( $video_display_type == 'embeded_video_youtube' ) {

									// detect youtube id form url
									$video_id = explode( '?v=', $video_url ); // For videos like http://www.youtube.com/watch?v=...
									if ( empty( $video_id[1] ) ) {
										$video_id = explode( '/v/', $video_url ); // For videos like http://www.youtube.com/watch/v/..
									}
									if ( ! empty( $video_id[1] ) ) {
										 $video_id = explode( '&', $video_id[1] ); // Deleting any other params
										 $video_id = $video_id[0];
									} else {
										$video_id = $video_url;
									}

									?>


								<div data-id="<?php echo esc_attr( $id ); ?>">

									<?php
									  $el_aspect = 'vc_video-aspect-ratio-169';
									?>

									  <div class="wpb_video_widget wpb_content_element vc_clearfix <?php echo esc_attr( $el_aspect ); ?>">
										<div class="wpb_wrapper">
											<div class="wpb_video_wrapper">
											<?php echo wp_oembed_get( 'https://www.youtube.com/watch?v=' . $video_id ); ?>
											</div>
										</div>
									</div>
								</div>

									<?php
								}
							}
						} elseif ( $format == 'quote' ) {
							?>

							<?php
						} else { // format is standard or combined formats like(video/sound)
							if ( has_post_thumbnail() ) {
								if ( ! function_exists( 'aq_resize' ) && $blog_image_size == 'custom' ) {
									$blog_image_size = 'large';
								}

								$post_thumbnail_id = get_post_thumbnail_id();

								if ( $blog_image_size == 'custom' && $blog_image_size_width != '' && $blog_image_size_height != '' ) {
									if ( $blog_image_size_crop == 'yes' ) {
											$blog_image_size_crop = true;
									} else {
										$blog_image_size_crop = false;
									}
									$image_url  = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
									$image_link = aq_resize( $image_url[0], $blog_image_size_width, $blog_image_size_height, $blog_image_size_crop, false, true );
									$thumb      = array();
									$thumb[0]   = $image_link ? $image_link[0] : $image_url[0];
									$thumb[1]   = $blog_image_size_width;
									$thumb[2]   = $blog_image_size_height;

								} elseif ( $blog_image_size == 'large' ) {
									$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );
								} else {
									$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'Kite_thumbnail-auto-height' );
								}

								 $image = '<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width="' . esc_attr( $thumb[1] ) . '" height="' . esc_attr( $thumb[2] ) . '" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" data-src="' . esc_url( $thumb[0] ) . '" alt="' . ( ( $img_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) ? esc_attr( $img_alt ) : '' ) . '"/>';

								?>
									<div class="image-container lazy-load lazy-load-on-load" style="padding-top:<?php echo esc_attr( kite_get_height_percentage( $image ) ); ?>%">
									   <?php
										// Sanitization performed in above lines!
										echo wp_kses( $image, kite_allowed_html() );
										?>
									</div>
								 <?php
							} else {
								?>
							 <!-- If we don't have images -->
								   <div class="cartblogplaceholder"></div>
								<?php
							}
						}

						if ( $format == 'quote' ) {
							echo '<a class="quote-wrap-link" href="' . esc_url( get_the_permalink() ) . '">';
						}
						?>
						<div class="blog-masonry-content">

							<?php if ( $format != 'quote' ) { ?>
								<span class="blog-details">
								<?php
								if ( $blog_category_visibility == 'yes' ) {
									$terms      = get_the_category( $post->ID );
									$catcounter = 0;
									if ( $terms ) {
										foreach ( $terms as $term ) {

											$catcounter++;
											if ( $catcounter < 2 && ( ( $term->cat_name ) != 'Uncategorized' ) ) {
												?>
										<span class="blog-cat">
										   <a href="<?php echo esc_url( get_category_link( get_cat_ID( $term->cat_name ) ) ); ?>" title='<?php echo esc_attr( $term->cat_name ); ?>'>
												<?php echo esc_attr( $term->cat_name ); ?>
										   </a>
										</span>
												<?php
											}
										}
									}
								}
								?>
								</span>
								<?php
							}
							$archive_year  = get_the_time( 'Y' );
							$archive_month = get_the_time( 'm' );
							$archive_day   = get_the_time( 'd' );

							?>

							<?php if ( $format != 'quote' ) { ?>
							<a class="link_to_details" href="<?php the_permalink(); ?>">
								<h2 class="blog-title"> <?php the_title(); ?></h2>
								<span class="blog-date">
									<span><?php the_time( get_option( 'date_format' ) ); ?></span>
								</span>
								<p class="blog-excerpt"> <?php echo mb_substr( get_the_excerpt(), 0, 100 ) . esc_html( $sub_str ); ?></p>
								</a>
								<?php
							} else {

								$quote_content = get_post_meta( get_the_ID(), 'quote_content', true );
								$quote_author  = get_post_meta( get_the_ID(), 'quote_author', true );
								if ( ! empty( $quote_content ) && ! empty( $quote_author ) ) {
									echo '<div class="icon kt-icon icon-quotes-right"></div>';
								}
								?>

								<p class="blog-excerpt"> <?php echo esc_html( $quote_content ); ?></p>
								<p class="quote-author"> <?php echo esc_html( $quote_author ); ?></p>
								<?php
							}
							?>
						</div>
						<?php
						if ( $format == 'quote' ) {
							echo '</a>';
						}

						if ( $format != 'quote' ) {
							?>
							<?php if ( $blog_category_author == 'yes' ) { ?>
								<div class="post-author-meta">

									<span class="kt-icon icon-user"></span>
									<span class="post-author "><?php the_author_posts_link(); ?></span>
									<span class="kt-icon icon-bubble"></span>
									<span class="meta-comment-count"><a href="<?php comments_link(); ?>"> <?php comments_number( esc_html__( '0', 'kitestudio-core' ), esc_html__( '1', 'kitestudio-core' ), esc_html__( '%', 'kitestudio-core' ) ); ?></a></span>

								</div>
							<?php } ?>

						<?php } ?>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
					<?php if ( $max > 1 ) { ?>
					<!-- Single Page Navigation-->
					<div class="pagenavigation cartblog clearfix <?php echo esc_attr( $load_more_style ); ?>">
						<div class="navNext"><?php next_posts_link( esc_html__( '&larr; Older Entries', 'kitestudio-core' ) ); ?></div>
						<div class="navPrevious"><?php previous_posts_link( esc_html__( 'Newer Entries &rarr;', 'kitestudio-core' ) ); ?></div>
					</div>
					<?php } ?>


		<?php
		wp_reset_postdata();

		return ob_get_clean();

	}
}
