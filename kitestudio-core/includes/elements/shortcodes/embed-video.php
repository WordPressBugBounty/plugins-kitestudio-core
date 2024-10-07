<?php
/*-----------------------------------------------------------------------------------*/
/*  Embed Video
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_embed_video' ) ) {
	function kite_sc_embed_video( $atts ) {
		$class[] = '';
		extract(
			shortcode_atts(
				array(

					'video_display_type'      => 'local_video',
					'video_autoplay'          => 'enable',
					'loop'                    => 'enable',
					'mejs_controls'           => 'enable',
					'video_poster_image'      => '',
					'video_background_image'  => '',
					'video_webm'              => '',
					'video_mp4'               => '',
					'video_ogv'               => '',
					'video_vimeo_id'          => '',
					'video_youtube_id'        => '',
					'alignment'               => '',
					'video_play_button_color' => 'light',
					'animation'               => 'none',
					'delay'                   => '0',
					'responsive_animation'    => 'disable',
					'el_aspect'               => '169',
					'text'                    => '', // Just used in Product detail video ( not included in VC )
				),
				$atts
			)
		);

		switch ( $alignment ) {
			case 'right':
				$class[] = ' right';
				break;
			case 'center':
				$class[] = ' center';
				break;
			case 'left':
				$class[] = ' left';
				break;
		}

		if ( $video_display_type == 'local_video' || $video_display_type == 'local_video_popup' ) {
			if ( $video_webm == '' && $video_mp4 == '' && $video_ogv == '' ) {
				return;
			}
		} elseif ( $video_display_type == 'embeded_video_vimeo' || $video_display_type == 'embeded_video_vimeo_popup' ) {
			if ( $video_vimeo_id == '' ) {
				return;
			}
		} elseif ( $video_display_type == 'embeded_video_youtube' || $video_display_type == 'embeded_video_youtube_popup' ) {
			if ( $video_youtube_id == '' ) {
				return;
			}
		}

		// Video ID extractor
		$vimeo_url = $video_vimeo_id;
		$vimeo_id  = preg_replace( '/[^0-9]/', '', $vimeo_url );

		// detect youtube id form url
		$youtube_url = $video_youtube_id;
		if ( $youtube_url && ( $video_display_type == 'embeded_video_youtube_popup' || $video_display_type == 'embeded_video_youtube' ) ) {
			$youtube_id = explode( '?v=', $youtube_url ); // For videos like http://www.youtube.com/watch?v=...
			if ( empty( $youtube_id[1] ) ) {
				$youtube_id = explode( '/v/', $youtube_url ); // For videos like http://www.youtube.com/watch/v/..
			} else {
				$youtube_id = explode( '&', $youtube_id[1] ); // Deleting any other params
			}
			$youtube_id = $youtube_id[0];
		}

		if ( is_numeric( $video_background_image ) ) {
			$video_background_image_id = $video_background_image;
			$video_background_image    = wp_get_attachment_url( $video_background_image );
		} else {
			$video_background_image_id = attachment_url_to_postid( $video_background_image );
		}

		if ( is_numeric( $video_poster_image ) ) {
			$video_poster_image = wp_get_attachment_url( $video_poster_image );
		}

		$id = kite_sc_id( 'embed_video' );

		ob_start();

		?>


		<?php if ( $video_display_type == 'local_video_popup' ) { ?>

			<!-- Hidden video div -->
			<div style="display:none;" id="video<?php echo esc_attr( $id ); ?>">
				<video class="lg-video-object lg-html5 video-js vjs-default-skin" controls preload="none"
				<?php
				if ( $video_poster_image ) {
					?>
					 poster="<?php echo esc_url( $video_poster_image ); ?>" <?php } ?>>

					<?php if ( $video_webm ) { ?>
						<source src="<?php echo esc_url( $video_webm ); ?>" type="video/webm">
					<?php } ?>

					<?php if ( $video_mp4 ) { ?>
						<source src="<?php echo esc_url( $video_mp4 ); ?>" type="video/mp4">
					<?php } ?>

					<?php if ( $video_ogv ) { ?>
						<source src="<?php echo esc_url( $video_ogv ); ?>" type="video/ogv">
					<?php } ?>

				</video>
			</div>

		<?php } ?>

		<?php if ( $video_display_type == 'local_video_popup' || $video_display_type == 'embeded_video_youtube_popup' || $video_display_type == 'embeded_video_vimeo_popup' ) { ?>

			<div id="<?php echo esc_attr( $id ); ?>" class="video_embed_container
								<?php
								if ( $animation != 'none' ) {
									?>
				  shortcodeanimation
									  <?php
										if ( $responsive_animation != '' ) {
													echo ' no-responsive-animation';}
								}
								?>
					 "
					 <?php
						if ( strlen( esc_attr( $animation ) ) ) {
							?>
		 data-delay="<?php echo esc_attr( $delay ); ?>" data-animation="<?php echo esc_attr( $animation ); ?>" <?php } ?>>

				<?php if ( $video_display_type == 'local_video_popup' ) { ?>


					<!-- data-src should not be provided when you use html5 videos -->
					<a data-html="#video<?php echo esc_attr( $id ); ?>">

						<?php if ( esc_attr( $video_background_image ) ) { ?>
							<img src="<?php echo esc_url( $video_background_image ); ?>" alt="
												 <?php
													if ( $img_alt = get_post_meta( $video_background_image_id, '_wp_attachment_image_alt', true ) ) {
														echo esc_attr( $img_alt );}
													?>
							"/>
						<?php } ?>

						<div class="play-button
						<?php
						echo esc_attr( $video_play_button_color );
						echo esc_attr( implode( ' ', $class ) );
						?>
						">
							<span class="glyph icon icon-play2"></span>
						</div>
						<?php
						if ( $text != '' ) {
							echo '<span class="text">' . wp_kses( $text, kite_allowed_html() ) . '</span>';
						}
						?>

					</a>

				<?php } elseif ( $video_display_type == 'embeded_video_youtube_popup' ) { ?>

					<!-- Youtube popup -->
					<a class="image" href="<?php echo esc_url( 'https://youtu.be/' ) . esc_attr( $youtube_id ); ?>">

						<?php if ( esc_url( $video_background_image ) ) { ?>
							<img src="<?php echo esc_url( $video_background_image ); ?>" alt="
												 <?php
													if ( $img_alt = get_post_meta( $video_background_image_id, '_wp_attachment_image_alt', true ) ) {
														echo esc_attr( $img_alt );}
													?>
							"/>
						<?php } ?>

						 <div class="play-button <?php echo esc_attr( $video_play_button_color ); ?>">
							<span class="glyph icon  icon-play2"></span>
						</div>
						<?php
						if ( $text != '' ) {
							echo '<span class="text">' . wp_kses( $text, kite_allowed_html() ) . '</span>';
						}
						?>

					</a>

				<?php } elseif ( $video_display_type == 'embeded_video_vimeo_popup' ) { ?>

					<!-- Vimeo popup -->
					<a class="image" href="<?php echo esc_url( 'https://vimeo.com/' ) . esc_attr( $vimeo_id ); ?>" >

						<?php if ( esc_url( $video_background_image ) ) { ?>
							<img src="<?php echo esc_url( $video_background_image ); ?>" alt="
												 <?php
													if ( $img_alt = get_post_meta( $video_background_image_id, '_wp_attachment_image_alt', true ) ) {
														echo esc_attr( $img_alt );}
													?>
							"/>
						<?php } ?>

						 <div class="play-button <?php echo esc_attr( $video_play_button_color ); ?>">
							<span class="glyph icon  icon-play2"></span>
						</div>
						<?php
						if ( $text != '' ) {
							echo '<span class="text">' . wp_kses( $text, kite_allowed_html() ) . '</span>';
						}
						?>

					</a>

				<?php } ?>

			</div>

		<?php } ?>

		<?php if ( $video_display_type == 'local_video' ) { ?>

			<!-- HTML5 Video popup -->
			<div class="inline_video video_embed_container" <?php echo ( $mejs_controls == 'disable' ) ? 'playsinline style="pointer-events: none;"' : '';?>">
				<video id="<?php echo esc_attr( $id ); ?>" class="video" width="320" height="240"
									  <?php
										if ( $video_poster_image ) {
											?>
					poster="<?php echo esc_url( $video_poster_image ); ?>"<?php } ?> controls="controls" preload="auto"
									   <?php
										if ( $video_autoplay == 'enable' ) {
											?>
		 autoplay muted="muted"
											<?php
										} if ( $loop == 'enable' ) {
											?>
						 loop <?php } ?>>

					<?php if ( esc_attr( $video_webm ) ) { ?>
						<source src="<?php echo esc_url( $video_webm ); ?>" type="video/webm">
					<?php } ?>

					<?php if ( esc_attr( $video_mp4 ) ) { ?>
						<source src="<?php echo esc_url( $video_mp4 ); ?>" type="video/mp4">
					<?php } ?>

					<?php if ( esc_attr( $video_ogv ) ) { ?>
						<source src="<?php echo esc_url( $video_ogv ); ?>" type="video/ogv">
					<?php } ?>

					<object width="320" height="240" type="application/x-shockwave-flash" data="<?php echo esc_url( get_template_directory_uri() ); ?>/js/flashmediaelement.swf">
						<param name="movie" value="<?php echo esc_url( get_template_directory_uri() ); ?>/js/flashmediaelement.swf" />
						<param name="flashvars" value="controls=true&file='<?php echo esc_url( $video_mp4 ); ?>" />

						<?php if ( $video_poster_image ) { ?>

							<img src="<?php echo esc_url( $video_poster_image ); ?>" width="1920" height="800" title="No video playback capabilities" alt="Video thumb"/>

						<?php } ?>

					</object>
				</video>

				<?php if ( esc_attr( $video_poster_image ) ) { ?>

					<div class="play-button <?php echo esc_attr( $video_play_button_color ); ?>">
						<span class="glyph icon  icon-play2"></span>
					</div>

				<?php } ?>


			</div>

		<?php } elseif ( $video_display_type == 'embeded_video_vimeo' ) { ?>

			<div id="<?php echo esc_attr( $id ); ?>">

				<?php
					$video_w   = 500;
					$video_h   = $video_w / 1.61; // 1.61 golden ratio
					$link      = 'http://vimeo.com/' . $vimeo_id;
					$el_aspect = 'vc_video-aspect-ratio-' . $el_aspect;
					global $wp_embed;
					$embed = $wp_embed->run_shortcode( '[embed  width="' . esc_attr( $video_w ) . '"     height="' . esc_attr( $video_h ) . '"]' . $link . '[/embed]' );
				?>

				<div class="wpb_video_widget wpb_content_element vc_clearfix <?php echo esc_attr( $el_aspect ); ?>">
					<div class="wpb_wrapper">
						<div class="wpb_video_wrapper"> <?php echo wp_kses( $embed, kite_allowed_html() ); ?> </div>
					</div>
				</div>
			</div>

		<?php } elseif ( $video_display_type == 'embeded_video_youtube' ) { ?>

			<div id="<?php echo esc_attr( $id ); ?>">

				<?php
					$el_aspect = 'vc_video-aspect-ratio-169';
				?>

				<div class="wpb_video_widget wpb_content_element vc_clearfix <?php echo esc_attr( $el_aspect ); ?>">
					<div class="wpb_wrapper">
						<div class="wpb_video_wrapper">
							<?php echo wp_oembed_get( 'https://www.youtube.com/watch?v=' . $youtube_id ); ?>
						</div>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php
		return ob_get_clean();
	}
}
