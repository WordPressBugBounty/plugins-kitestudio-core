<?php
/*-----------------------------------------------------------------------------------*/
/*  Button
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_button' ) ) {
	function kite_sc_button( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'title'                     => '',
					'text'                      => esc_html__( 'View Page', 'kitestudio-core' ),
					'text_hover'                => esc_html__( 'View Page', 'kitestudio-core' ),
					'button_hover_style'        => 'style2',
					'button_bg_style'           => 'fill',
					'link_display_style'        => 'text',
					'url'                       => '#',
					'new_tab'                   => false,
					'elementor'                 => '',
					'size'                      => 'default',
					'alignment'                 => 'left',
					'position'                  => '',
					'button_display'            => '',
					'button_icon'               => '',
					'button_icon_position'      => '',
					'button_text_color'         => '',
					'button_text_hover_color'   => '',
					'button_border_color'       => '',
					'button_border_hover_color' => '',
					'button_bg_color'           => '',
					'button_bg_hover_color'     => '',
					'button_border_radius'      => '',
					'button_border_width'       => '',
					'animation'                 => 'none',
					'animation_delay'           => '1000',
					'responsive_animation'      => 'disable',

				),
				$atts
			)
		);

		$class   = array();
		$class[] = 'kt_button';

		switch ( $size ) {
			case 'small':
				$class[] = 'button-small';
				break;
			case 'standard':
				$class[] = 'button-medium';
				break;
			case 'default':
				$class[] = 'button-default';
				break;
			case 'large':
				$class[] = 'button-large';
				break;
		}

		switch ( $alignment ) {
			case 'right':
				$class[] = 'right';
				break;
			case 'center':
				$class[] = 'center';
				break;
			case 'left':
				$class[] = 'left';
				break;
		}

		switch ( $position ) {
			case 'row':
				$class[] = 'row';
				break;
			case 'separate':
				$class[] = 'separate';
				break;
		}
		switch ( $button_display ) {
			case 'box':
				$class[] = 'box';
				break;
			case 'full':
				$class[] = 'full';
				break;
		}

		switch ( $button_hover_style ) {
			case 'style1':
				$class[] = 'style1';
				break;
			case 'style2':
				$class[] = 'style2';
				break;
			case 'link_style':
				$class[] = 'link_style';
				break;
		}

		switch ( $button_bg_style ) {
			case 'fill':
				$class[] = 'fill';
				break;
			case 'transparent':
				$class[] = 'transparent';
				break;
		}
		switch ( $link_display_style ) {
			case 'text':
				$class[] = 'text';
				break;
			case 'icon':
				$class[] = 'icon';
				break;
		}

		if ( strlen( $button_icon ) ) {
			$class[] = 'hasicon';
			// $button_icon = str_replace( 'icon icon-', '', $button_icon );
		}

		switch ( $button_icon_position ) {
			case 'left':
				$class[] = 'buttoniconleft';
				break;
			case 'right':
				$class[] = 'buttoniconright';
				break;
		}

		$id                = kite_sc_id( 'button' );
		$has_style         = '' != $button_text_color || '' != $button_text_hover_color || '' != $button_border_color || '' != $button_border_hover_color || '' != $button_bg_color || '' != $button_bg_hover_color || '' != $button_border_radius || '' != $button_border_width;
		$kite_inline_style = '';
		if ( $has_style ) {
			if ( strlen( esc_attr( $button_bg_color ) ) ) {
				if ( $button_bg_style == 'fill' ) {
					$kite_inline_style .= "#$id.kt_button{background-color:$button_bg_color;}";
				}
			}
			if ( strlen( esc_attr( $button_bg_hover_color ) ) ) {
				$kite_inline_style .= "#$id.kt_button:hover{background-color:$button_bg_hover_color;}";
			}
			if ( strlen( esc_attr( $button_border_radius ) ) ) {
				$kite_inline_style .= "#$id.kt_button{border-radius:$button_border_radius;}";
			}
			if ( strlen( esc_attr( $button_border_width ) ) ) {
				$kite_inline_style .= "#$id.kt_button{border-width:$button_border_width;}";
			}

			if ( strlen( esc_attr( $button_border_color ) ) ) {
				$kite_inline_style .= "#$id.kt_button{border-color:$button_border_color;}";
			}

			if ( strlen( esc_attr( $button_border_hover_color ) ) ) {
				if ( $button_hover_style == 'link_style' ) {
					$kite_inline_style .= "#$id.kt_button.link_style:after {";
				} else {
					$kite_inline_style .= "#$id.kt_button:hover {";
				}
				$kite_inline_style .= "border-color:$button_border_hover_color;}";
			}
			if ( strlen( esc_attr( $button_text_color ) ) ) {
				$kite_inline_style .= "#$id.kt_button{color:$button_text_color;}";
			}
			if ( strlen( esc_attr( $button_text_hover_color ) ) ) {
				$kite_inline_style .= "#$id.kt_button:hover{color:$button_text_hover_color;}";
			}
		} // End if
		wp_add_inline_style( 'kite-inline-style', $kite_inline_style );
		?>

		<?php
		if ( $url && function_exists( 'vc_build_link' ) && empty( $elementor ) ) {
			$link = vc_build_link( $url );
		} else {
			$link['url'] = $url;
			if ( $new_tab ) {
				$link['target'] = '_blank';
			} else {
				$link['target'] = '_self';
			}
		}
		$btntext = '';
		if ( $button_hover_style == 'style1' ) {
			$btntext = esc_attr( $text_hover );
		} else {
			$btntext = esc_attr( $text );
		}

		ob_start();

		?>
		<?php if ( $position == 'row' ) { ?>
				<div class="inlinestyle <?php echo esc_attr( $alignment ); ?>">
		<?php } ?>
		<div class="buttonwrapper
		<?php
		if ( $button_display == 'full' ) {
			echo 'full'; }
		?>
			 <?php
				if ( $responsive_animation != '' ) {
					echo 'no-responsive-animation';}
				?>
				 <?php
					if ( strlen( esc_attr( $animation ) ) ) {
						echo 'shortcodeanimation';}
					?>
	"
		 <?php
			if ( strlen( esc_attr( $animation ) ) ) {
				?>
		 data-delay="<?php echo esc_attr( $animation_delay ); ?>" <?php } ?>data-animation="<?php echo esc_attr( $animation ); ?>">
		<?php if ( $alignment == 'center' ) { ?>
			<div class="centeralignment">
		<?php } ?>
		<?php if ( ( $button_hover_style == 'link_style' ) && ( $button_display == 'full' ) ) { ?>
			<div class="fullwidth">
		<?php } ?>

		 <a id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( implode( ' ', $class ) ); ?>" href="<?php echo esc_url( $link['url'] ); ?>" title="<?php echo esc_attr( $title ); ?>"
						   <?php
							if ( $link['target'] != '' ) {
								?>
				target="<?php echo esc_attr( $link['target'] ); ?>"<?php } ?>>
			<?php if ( strlen( $button_icon ) && ( ( $button_icon_position ) != 'right' || ( $button_hover_style ) == 'style1' ) ) { ?>
					<span class="icon"
					<?php
					if ( strlen( $button_icon_position ) ) {
						?>
						 data-float="<?php echo esc_attr( $button_icon_position ); ?>" <?php } ?> data-hover="<?php echo esc_attr( $button_icon ); ?>">
						<span class="firsticon glyph <?php echo esc_attr( $button_icon ); ?>"></span>
						<span class="hovericon glyph <?php echo esc_attr( $button_icon ); ?>"></span>
					</span>
				<?php } ?>

			<span class="txt" data-hover="<?php echo esc_attr( $btntext ); ?>">
					<?php echo esc_html( $btntext ); ?>
				</span>

			<?php if ( strlen( $button_icon ) && ( $button_icon_position ) == 'right' ) { ?>
					<span class="icon"
					<?php
					if ( strlen( $button_icon_position ) ) {
						?>
						 data-float="<?php echo esc_attr( $button_icon_position ); ?>" <?php } ?> data-hover="<?php echo esc_attr( $button_icon ); ?>">
						<span class="firsticon glyph <?php echo esc_attr( $button_icon ); ?>"></span>
						<span class="hovericon glyph <?php echo esc_attr( $button_icon ); ?>"></span>
					</span>
				<?php } ?>

			</a>
			<div class="clearfix"></div>

		<?php if ( $alignment == 'center' ) { ?>
			</div>
		<?php } ?>
		<?php if ( ( $button_hover_style == 'link_style' ) && ( $button_display == 'full' ) ) { ?>
			</div>
		<?php } ?>

		 </div>
		 <?php if ( $position == 'row' ) { ?>
			</div>
		<?php } ?>
		<?php
		return ob_get_clean();
	}
}
