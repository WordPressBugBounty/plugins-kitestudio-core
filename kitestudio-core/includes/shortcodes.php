<?php
function kite_vc_add_custom_fields() {
	if ( ! function_exists( 'vc_add_shortcode_param' ) ) {
		return false;
	}

	// add icon box option for vc
	vc_add_shortcode_param( 'vc_icons', 'kite_vc_icons_field', KITE_THEME_URI . '/extendvc/js/vc_icon.js' );

	// add date option for vc
	vc_add_shortcode_param( 'vc_date', 'kite_vc_date_field' );

	// add image select option for vc
	vc_add_shortcode_param( 'vc_imageselect', 'kite_vc_imageselect_field', KITE_THEME_URI . '/extendvc/js/vc_imageselect.js' );

	// add range field for vc
	vc_add_shortcode_param( 'vc_rangefield', 'kite_vc_range_field', KITE_THEME_URI . '/extendvc/js/vc_rangefield.js' );

	// add checkbox field for vc
	vc_add_shortcode_param( 'vc_multiselect', 'kite_vc_multi_select', KITE_THEME_URI . '/extendvc/js/vc_multiselect.js' );

	// add responsive text field for vc
	vc_add_shortcode_param( 'vc_responsive_text', 'kite_vc_responsive_text_font_size', KITE_THEME_URI . '/extendvc/js/vc_responsive_text.js' );

	// contact form
	vc_add_shortcode_param( 'vc_contactform_style', 'kite_vc_contactform_style', KITE_THEME_URI . '/extendvc/js/vc_contactform.js' );

}

add_action( 'admin_init', 'kite_vc_add_custom_fields' );

// Separators
add_shortcode( 'vc_separator', 'kite_sc_separator' );

// Title with horizontal line
add_shortcode( 'vc_text_separator', 'kite_sc_title' );

// Team Member
add_shortcode( 'team_member', 'kite_sc_team_member' );

// Testimonials shortcode
add_shortcode( 'testimonial', 'kite_sc_testimonial' );

// Testimonial item shortcode
add_shortcode( 'testimonial_item', 'kite_sc_testimonial_item' );

// Pie Chart
add_shortcode( 'piechart', 'kite_sc_piechart' );

// Horizontal progress bar
add_shortcode( 'progressbar', 'kite_sc_progressbar' );

// Social Icon
add_shortcode( 'socialIcon', 'kite_sc_socialIcon' );

// Social Link
add_shortcode( 'socialLink', 'kite_sc_socialLink' );

// Text-Box
add_shortcode( 'textbox', 'kite_sc_textbox' );

// Custom Title
add_shortcode( 'custom_title', 'kite_sc_customTitle' );

// Image-Box
add_shortcode( 'imagebox', 'kite_sc_imagebox' );

// Animated Text
add_shortcode( 'animatedtext', 'kite_sc_animated_text' );

// Banner
add_shortcode( 'banner', 'kite_sc_banner' );

// Modern Banner
add_shortcode( 'modernBanner', 'kite_sc_modern_banner' );

// Icon-Box-custom ( creative iconbox )
add_shortcode( 'iconbox_custom', 'kite_sc_iconbox_custom' );

// Icon-Box-top No border
add_shortcode( 'iconbox_top_noborder', 'kite_sc_iconbox_noborder' );

// Icon-Box-Rectangle
add_shortcode( 'iconbox_rectangle', 'kite_sc_iconbox_rectangle' );

// Icon-Box-Circle
add_shortcode( 'iconbox_circle', 'kite_sc_iconbox_circle' );

// Icon-Box-left
add_shortcode( 'iconbox_left', 'kite_sc_iconbox_left' );

// Countdown
add_shortcode( 'countdown', 'kite_sc_countdown' );

// Counter Box
add_shortcode( 'conterbox', 'kite_sc_conterbox' );

// Embed Video
add_shortcode( 'embed_video', 'kite_sc_embed_video' );

// Audio SoundCloud
add_shortcode( 'audio_soundcloud', 'kite_sc_audio_soundcloud' );

// Button
add_shortcode( 'button', 'kite_sc_button' );

// VC Toggle Counter Box
add_shortcode( 'vc_toggle', 'kite_sc_vctoggle' );

// VC carousel
add_shortcode( 'image_carousel', 'kite_sc_imagecarousel' );

// Showcase
add_shortcode( 'showcase', 'kite_sc_showcase' );

// Showcase Items
add_shortcode( 'showcase_item', 'kite_sc_showcase_item' );

// Newsletter(subscribtion form)
add_shortcode( 'kt_newsletter', 'kite_sc_newsletter' );
add_shortcode( 'kt_newsletter_3', 'kite_sc_newsletter_v3' );
add_shortcode( 'kt_newsletter_mailchimp', 'kite_sc_newsletter_mailchimp' );

// Woocommerce shortcodes
add_shortcode( 'kt_instagram', 'kite_sc_instgram_feed' );

// Masonry Blog - Cart blog
add_shortcode( 'kt_masonry_blog', 'kite_sc_blog_masonry' );

// Woocommerce Products
add_shortcode( 'woocommerce_products', 'kite_woocommerce_products' );
add_shortcode( 'woocommerce_products_ajax', 'kite_woocommerce_products' );

add_shortcode( 'ajax_products_tab', 'kite_ajax_products_tab' );

function kite_sc_woocommerce_shortcodes_changes() {
	 // Remove WC shortcodes
	remove_shortcode( 'product' );
	remove_shortcode( 'products' );
	remove_shortcode( 'recent_products' );
	remove_shortcode( 'sale_products' );
	remove_shortcode( 'best_selling_products' );
	remove_shortcode( 'top_rated_products' );
	remove_shortcode( 'featured_products' );
	remove_shortcode( 'product_attribute' );
	remove_shortcode( 'product_categories' );
	remove_shortcode( 'product_category' );
	remove_shortcode( 'product_page' );

	if ( function_exists( 'vc_remove_element' ) ) {
		vc_remove_element( 'top_rated_products' );
		vc_remove_element( 'recent_products' );
		vc_remove_element( 'best_selling_products' );
		vc_remove_element( 'sale_products' );
		vc_remove_element( 'featured_products' );
		vc_remove_element( 'product_category' );
	}

	// Add WC shortcodes and define handler for them
	add_shortcode( 'product', 'kite_sc_product' );
	add_shortcode( 'products', 'kite_products' );
	add_shortcode( 'product_attribute', 'kite_product_attribute' );
	add_shortcode( 'product_categories', 'kite_product_categories' );
	add_shortcode( 'product_page', 'kite_product_page' );
}

add_action( 'init', 'kite_sc_woocommerce_shortcodes_changes' );

// Remove below Scripts becuase cause bug and We replace Our functionality
function kite_remove_VC_scripts( $handles = array() ) {

	wp_deregister_style( 'vc_tta_style' );
	wp_dequeue_style( 'vc_tta_style' );

	wp_deregister_script( 'vc_accordion_script' );
	wp_dequeue_script( 'vc_accordion_script' );

	wp_deregister_script( 'vc_tta_autoplay_script' );
	wp_dequeue_script( 'vc_tta_autoplay_script' );

	wp_deregister_script( 'vc_tabs_script' );
	wp_dequeue_script( 'vc_tabs_script' );

	wp_deregister_script( 'waypoints' );
	wp_dequeue_script( 'waypoints' );
}

add_action( 'wp_footer', 'kite_remove_VC_scripts' );


