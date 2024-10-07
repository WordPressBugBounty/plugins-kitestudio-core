<?php
/*-----------------------------------------------------------------------------------*/
/*  Allowed tags for wp_kses
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_allowed_tags' ) ) {
	function kite_allowed_tags() {
		return array(
			'strong' => array(),
			'br'     => array(),
			'em'     => array(),
			'a'      => array(
				'href'  => array(),
				'title' => array(),
			),
		);
	}
}

/*-----------------------------------------------------------------------------------*/
/*  Shortcode helpers
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_id' ) ) {
	// Generate ID for shortcodes
	function kite_sc_id( $key ) {
		return KITE_Element_ID_Generator::get_instance()->generate_id( $key );
	}
}

if ( ! function_exists( 'kite_sc_ss_id' ) ) {
	function kite_sc_ss_id( $key ) {
		$global_key = "kt_sc_$key";
		if ( session_status() == PHP_SESSION_NONE ) {
			session_start();
		}
		if ( isset( $_SESSION[ $global_key ] ) && ! empty( $_SESSION[ $global_key ] ) ) {
			$_SESSION[ $global_key ] = $_SESSION[ $global_key ] + 1;
		} else {
			$_SESSION[ $global_key ] = 1;
		}
		$id = sanitize_key( $_SESSION[ $global_key ] );
		return $key . '_' . $id;
	}
}


/*-----------------------------------------------------------------------------------*/
/*  VC Toggle Counter Box
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_vctoggle' ) ) {
	function kite_sc_vctoggle( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'title' => '',
					'open'  => 'false',
					'style' => '',
					'color' => 'disable',
				),
				$atts
			)
		);

		$id = kite_sc_id( 'vc_toggle' );

		ob_start();
		?>


		<div class="toggle_wrap
		<?php
		if ( $open == 'true' ) {
			?>
			 wpb_toggle_open
			 <?php
		} echo esc_attr( $style );
		if ( $color != 'disable' ) {
			echo ' hasbg ';}
		?>
									">
			<div class="wpb_toggle
			<?php
			if ( $open == 'true' ) {
				?>
				 wpb_toggle_title_active<?php } ?>">
				<div class="border-bottom">
					<div class="icon icon-plus"></div>
					<div class="icon icon-minus"></div>
					<div class="title"><?php echo esc_html( $title ); ?></div>
				</div>
			</div>
			<div class="toggle_content_wrap">
				<div class="wpb_toggle_content"
				<?php
				if ( $open == 'true' ) {
					?>
					 style="display: block;"  <?php } ?>>
					<?php echo wpb_js_remove_wpautop( $content ); ?>
				</div>
			</div>
		</div>

		<?php
		return ob_get_clean();
	}
}

$elements = array(
	'woocommerce/ajax-products-tab',
	'woocommerce/hand-picked-products',
	'woocommerce/product-categories',
	'woocommerce/product-loop',
	'woocommerce/products-by-attributes',
	'woocommerce/products',
	'woocommerce/single-product',
	'animated-text',
	'audio-sound-cloud',
	'banner',
	'blog',
	'button',
	'countdown',
	'counter-box',
	'custom-title',
	'embed-video',
	'icon-box-circle',
	'icon-box-left',
	'icon-box-rectangle',
	'icon-box-top',
	'icon-box',
	'image-carousel',
	'instagram',
	'newsletter',
	'pie-chart',
	'progressbar',
	'separator',
	'social-icon',
	'social-link',
	'team-member',
	'testimonials',
	'text-box',
	'title',
	'image-box',
);

foreach ( $elements as $element ) {
	require_once 'shortcodes/' . $element . '.php';
}
