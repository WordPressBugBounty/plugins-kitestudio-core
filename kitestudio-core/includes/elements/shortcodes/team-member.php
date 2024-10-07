<?php
/*-----------------------------------------------------------------------------------*/
/*  Team Member
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_team_member' ) ) {
	function kite_sc_team_member( $atts, $content = null ) {

		extract(
			shortcode_atts(
				array(
					'name'                 => 'JOHN DOE',
					'job_title'            => 'Designer',
					'image'                => '',
					'signature'            => '',
					'style'                => 'dark',
					'team_color_preset'    => 'd02d48',
					'team_color'           => '#cccccc',
					'description'          => '',
					'url'                  => '',
					'elementor_url_title'  => '',
					'new_tab'              => false,
					'team_animation'       => 'none',
					'team_animation_delay' => '0',
					'responsive_animation' => 'disable',
					'team_icon1'           => '',
					'team_icon2'           => '',
					'team_icon3'           => '',
					'team_icon4'           => '',
					'team_icon5'           => '',
					'team_icon_url1'       => '',
					'team_icon_url2'       => '',
					'team_icon_url3'       => '',
					'team_icon_url4'       => '',
					'team_icon_url5'       => '',
					'team_icon_target1'    => '_self',
					'team_icon_target2'    => '_self',
					'team_icon_target3'    => '_self',
					'team_icon_target4'    => '_self',
					'team_icon_target5'    => '_self',
				),
				$atts
			)
		);

		if ( is_numeric( $image ) ) {
			$image = wp_get_attachment_url( $image );
		}

		if ( is_numeric( $signature ) ) {
			$signature = wp_get_attachment_url( $signature );
		}

		$has_team_icon = '' != $team_icon1 || '' != $team_icon2 || '' != $team_icon3 || '' != $team_icon4 || '' != $team_icon5;

		$has_style = '' != $team_color || '' != $team_color_preset;
		$id        = kite_sc_id( 'team_member' );

		ob_start();
		$allowed_html       = kite_allowed_tags();
		 $color             = '';
		 $kite_inline_style = '';
		if ( $has_style ) {
			if ( strlen( esc_attr( $team_color_preset ) ) ) {
				if ( $team_color_preset == 'custom' ) {
					$color = $team_color;
				} else {
					$color = '#' . $team_color_preset;
				}
			}

			$kite_inline_style .= "#$id.team-member:hover .member-plus{background-color: $color;}";
			$kite_inline_style .= "#$id.team-member .member-line{background-color: $color;}";
			$kite_inline_style .= "#$id.team-member .icons li:hover a{color:$color;}";
		}//End of if
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		?>
			<div id="<?php echo esc_attr( $id ); ?>" class="team-member
								<?php
								if ( strlen( $style ) ) {
									echo esc_attr( $style );  }
								?>
			 <?php
				if ( $team_animation != 'none' ) {
							echo 'shortcodeanimation';
					if ( $responsive_animation != '' ) {
						echo ' no-responsive-animation';}
				}
				?>
	"
		<?php
		if ( $team_animation != 'none' ) {
			?>
		 data-delay="<?php echo esc_attr( $team_animation_delay ); ?>" data-animation="<?php echo esc_attr( $team_animation ); ?>" <?php } ?>>

				<?php
				if ( $image ) {
					?>
				<div class="member-pic-container">

					<div class="member-line"></div>

					<div class="member-pic">
						<?php
						if ( $image ) {
							?>
								<img class ="bg-image" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $name ); ?>">
							<?php
						}
						?>
					</div>

					<div class="member-plus">
						<span class="member-plus-line"></span>
					</div>

					<?php if ( $has_team_icon ) { ?>
							<ul class="icons">

								<?php if ( $team_icon1 ) { ?>
									<li>
										<a href="<?php echo esc_url( $team_icon_url1 ); ?>" title="<?php echo esc_attr( $job_title ); ?>"
															<?php
															if ( $team_icon_target1 != '' ) {
																?>
	  target="<?php echo esc_attr( $team_icon_target1 ); ?>"<?php } ?>>
											<span class="<?php echo esc_attr( $team_icon1 ); ?>" ></span>
										</a>
									</li>
								 <?php } ?>

								<?php if ( $team_icon2 ) { ?>
									<li>
										<a href="<?php echo esc_url( $team_icon_url2 ); ?>" title="<?php echo esc_attr( $job_title ); ?>"
															<?php
															if ( $team_icon_target2 != '' ) {
																?>
	  target="<?php echo esc_attr( $team_icon_target2 ); ?>"<?php } ?>>
											<span class="<?php echo esc_attr( $team_icon2 ); ?>" ></span>
										</a>
									</li>
								<?php } ?>

								<?php if ( $team_icon3 ) { ?>
									<li>
										<a href="<?php echo esc_url( $team_icon_url3 ); ?>" title="<?php echo esc_attr( $job_title ); ?>"
															<?php
															if ( $team_icon_target3 != '' ) {
																?>
	  target="<?php echo esc_attr( $team_icon_target3 ); ?>"<?php } ?>>
											<span class="<?php echo esc_attr( $team_icon3 ); ?>" ></span>
										</a>
									</li>
								<?php } ?>

								<?php if ( $team_icon4 ) { ?>
									<li>
										<a href="<?php echo esc_url( $team_icon_url4 ); ?>" title="<?php echo esc_attr( $job_title ); ?>"
															<?php
															if ( $team_icon_target4 != '' ) {
																?>
	 target="<?php echo esc_attr( $team_icon_target4 ); ?>"<?php } ?>>
											<span class="<?php echo esc_attr( $team_icon4 ); ?>" ></span>
										</a>
									</li>
								<?php } ?>

								<?php if ( $team_icon5 ) { ?>
									<li>
										<a href="<?php echo esc_url( $team_icon_url5 ); ?>" title="<?php echo esc_attr( $job_title ); ?>"
															<?php
															if ( $team_icon_target5 != '' ) {
																?>
	 target="<?php echo esc_attr( $team_icon_target5 ); ?>"<?php } ?>>
											<span class="<?php echo esc_attr( $team_icon5 ); ?>" ></span>
										</a>
									</li>
								<?php } ?>

							</ul>
					<?php } ?>

					<div class="overlay"></div>
				</div>

				<div class="member-info">

					 <span class="member-name"> <?php echo esc_html( $name ); ?></span>

					<cite><?php echo esc_html( $job_title ); ?></cite>

					<div class="member-description">

						<p><?php echo wp_kses( $description, $allowed_html ); ?></p>

						<?php
						if ( $url ) {
							if ( function_exists( 'vc_build_link' ) && empty( $elementor_url_title ) ) {
								$link = vc_build_link( $atts['url'] );
							} else {
								$link['title'] = $elementor_url_title;
								$link['url']   = $url;
								if ( $new_tab ) {
									$link['target'] = '_blank';
								} else {
									$link['target'] = '_self';
								}
							}

							if ( strlen( $link['url'] ) ) {
								?>
							<a href="<?php echo esc_url( $link['url'] ); ?>"
												<?php
												if ( $link['target'] != '' ) {
													?>
	 target="<?php echo esc_attr( $link['target'] ); ?>"<?php } ?> class="more-link-arrow" title="<?php echo esc_attr( $link['title'] ); ?>">[ <?php echo esc_attr( $link['title'] ); ?> ]</a>
								<?php
							}
						}
						?>

						<?php if ( '' != esc_url( $signature ) ) { ?>

							<div class="signature">

								<img src="<?php echo esc_url( $signature ); ?>" alt="<?php echo esc_attr( $name ); ?>">

							</div>

						<?php } ?>

					</div>

				</div>

					<?php
				}
				?>

			</div>
		<?php
		return ob_get_clean();
	}
}
