<?php
/*-----------------------------------------------------------------------------------*/
/*  Newsletter(subscribtion form)
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_newsletter' ) ) {
	function kite_sc_newsletter( $atts ) {

		extract(
			shortcode_atts(
				array(
					'mail_poet_form'             => '1',
					'mail_poet_form_style'       => 'light',
					'mail_poet_form_width_style' => 'boxed',
					'mail_poet_button_style'     => 'style1',
				),
				$atts
			)
		);

		if ( ! class_exists( 'WYSIJA_NL_Widget' ) ) {
			return;
		}

		ob_start();
		?>
		<div class="kt-newsletter <?php echo esc_attr( $mail_poet_button_style ); ?> <?php echo esc_attr( $mail_poet_form_style ); ?> <?php echo esc_attr( $mail_poet_form_width_style ); ?>">
			<?php
			$widget_nl = new WYSIJA_NL_Widget( true );
			echo $widget_nl->widget(
				array(
					'form'      => esc_attr( $mail_poet_form ),
					'form_type' => 'php',
				)
			);
			?>
		</div>
		<?php
		return ob_get_clean();
	}
}

/*-----------------------------------------------------------------------------------*/
/*  Newsletter(subscribtion form) - v3
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_newsletter_v3' ) ) {
	function kite_sc_newsletter_v3( $atts ) {

		extract(
			shortcode_atts(
				array(
					'mailpoet_form'              => '1',
					'mail_poet_form_style'       => 'light',
					'mail_poet_form_width_style' => 'boxed',
					'mail_poet_button_style'     => 'style1',
				),
				$atts
			)
		);

		if ( ! function_exists( 'mailpoet_deactivate_plugin' ) ) {
			return;
		}

		ob_start();
		?>
		<div class="kt-newsletter <?php echo esc_attr( $mail_poet_button_style ); ?> <?php echo esc_attr( $mail_poet_form_style ); ?> <?php echo esc_attr( $mail_poet_form_width_style ); ?>">
			<?php
				$widget_nl = new MailPoet\Form\Widget( true );
				$html      = $widget_nl->widget(
					array(
						'form'      => esc_attr( $mailpoet_form ),
						'form_type' => 'php',
					)
				);
				$start     = strrpos( $html, '<style type=' );
				$last      = strrpos( $html, '</style>' );
			if ( $start > 0 && $last > 0 ) {
				 $found = substr( $html, $start, ( strlen( $html ) - $start ) - ( strlen( $html ) - $last ) );
				 $html  = str_replace( $found, '', $html );
				 $found = str_replace( '<style type="text/css">', '', $found );
				 $found = str_replace( '</style>', '', $found );
				 $html  = str_replace( '</style>', '', $html );
				 $html  = str_replace( '<style type="text/css">', '', $html );
				 wp_add_inline_style( 'kite-inline-style', $found );
			}
				echo wp_kses_post( $html );
			?>
		</div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'kite_sc_newsletter_mailchimp' ) ) {
	function kite_sc_newsletter_mailchimp( $atts ) {
		extract(
			shortcode_atts(
				array(
					'mailchimp_form'             => '',
					'mailchimp_form_style'       => 'light',
					'mailchimp_form_width_style' => 'boxed',
					'mailchimp_button_style'     => 'style1',
					'custom_style'               => '',
					'custom_classes'			 => ''
				),
				$atts
			)
		);

		if ( ! function_exists( 'mc4wp_get_forms' ) ) {
			return;
		}

		global $mc4wp;

		if ( empty( $mailchimp_form ) || $mailchimp_form == 0 ) {
			$forms = mc4wp_get_forms();
			foreach ( $forms as $form ) {
				$mailchimp_form = $form->ID;
				break;
			}
		}
		ob_start();
		$classes   = array( 'kt-newsletter' );
		$classes[] = $mailchimp_button_style;
		$classes[] = $mailchimp_form_style;
		$classes[] = $mailchimp_form_width_style;

		if ( $custom_style == 'yes' ) {
			$classes[] = 'remove-kt-style';
		}

		if ( !empty( $custom_classes ) ) {
			$classes[] = $custom_classes;
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php 
			$mc4wp['forms']->output_form( $mailchimp_form ); 
			?>
		</div>
		<?php
		return ob_get_clean();
	}
}
