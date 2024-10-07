(function ($) {

	function video_type_dependencies()
	{
		var $video_type                = $( 'select[name="video_type"]' ),
			$self_hosted_video_section = $( '.section.section-video_extensions' ),
			$vimeo_section             = $( '.section.section-video_vimeo_id' ),
			$youtube_section           = $( '.section.section-video_youtube_id' ),
			$play_button_style_section = $( '.section.section-video_play_button_color' );

		function changeHandler()
		{

			var selected = $video_type.find( ':selected' ).val();

			if ('none' == selected) {
				$youtube_section.add( $youtube_section.next( 'hr' ) ).slideUp( 'fast' );
				$vimeo_section.add( $vimeo_section.next( 'hr' ) ).slideUp( 'fast' );
				$self_hosted_video_section.add( $self_hosted_video_section.next( 'hr' ) ).slideUp( 'fast' );
				$play_button_style_section.slideUp( 'fast' );
			} else if ('local_video_popup' == selected) {
				$youtube_section.add( $youtube_section.next( 'hr' ) ).slideUp( 'fast' );
				$vimeo_section.add( $vimeo_section.next( 'hr' ) ).slideUp( 'fast' );
				$self_hosted_video_section.add( $self_hosted_video_section.next( 'hr' ) ).slideDown( 'fast' );
				$play_button_style_section.slideDown( 'fast' );

			} else if ('embeded_video_vimeo_popup' == selected) { // Vimeo
				$youtube_section.add( $youtube_section.next( 'hr' ) ).slideUp( 'fast' );
				$vimeo_section.add( $vimeo_section.next( 'hr' ) ).slideDown( 'fast' );
				$self_hosted_video_section.add( $self_hosted_video_section.next( 'hr' ) ).slideUp( 'fast' );
				$play_button_style_section.slideDown( 'fast' );
			} else // Youtube
			{
				$youtube_section.add( $youtube_section.next( 'hr' ) ).slideDown( 'fast' );
				$vimeo_section.add( $vimeo_section.next( 'hr' ) ).slideUp( 'fast' );
				$self_hosted_video_section.add( $self_hosted_video_section.next( 'hr' ) ).slideUp( 'fast' );
				$play_button_style_section.slideDown( 'fast' );
			}

		}

		$video_type.change( changeHandler );
		changeHandler();
	}

	function product_detail_style_dependencies()
	{
		var $product_detail_inherit       = $( 'input[name="product_detail_style_inherit"]' ),
			$product_detail               = $product_detail_inherit.closest( '.field' ).siblings( '.field.product-detail' ),
			$color_field                  = $product_detail_inherit.closest( '.field' ).siblings( '.field.color-field' );
			$Text_color_field             = $product_detail_inherit.closest( '.field' ).siblings( '.field.txt-color' ),
			$gallery_column_field         = $product_detail_inherit.closest( '.field' ).siblings( '.field.col-number' ),
			$gallery_direction_field      = $product_detail_inherit.closest( '.field' ).siblings( '.field.product-dir' ),
			$sidebar_field                = $product_detail_inherit.closest( '.section-product_detail_style' ).siblings( '.section-product_detail_sidebar_position' ),
			$gallery_sidebar_field        = $product_detail_inherit.closest( '.section-product_detail_style' ).siblings( '.section-product_detail_gallery_sidebar' ),
			$gallery_sidebar_pos_field    = $product_detail_inherit.closest( '.section-product_detail_style' ).siblings( '.section-product_detail_gallery_sidebar_position' ),
			$sidebar_field_hr             = $sidebar_field.next( 'hr' ),
			$gallery_sidebar_field_hr     = $gallery_sidebar_field.next( 'hr' ),
			$gallery_sidebar_pos_field_hr = $gallery_sidebar_pos_field.next( 'hr' );

		function toggle_product_detail_section() {

			if ($( 'input[name="product_detail_style_inherit"]:checked' ).val() == '0') {
				$product_detail.hide();
				$color_field.hide();
				$sidebar_field.hide();
				$gallery_sidebar_field.hide();
				$gallery_sidebar_pos_field.hide();
				$Text_color_field.hide();
				$gallery_column_field.hide();
				$gallery_direction_field.hide();
				$sidebar_field_hr.hide();
				$gallery_sidebar_field_hr.hide();
				$gallery_sidebar_pos_field_hr.hide();
			} else {
				$product_detail.show();
				var $selected_product_detail = $product_detail.find( 'a.selected' );
				if ($selected_product_detail.hasClass( 'pd_background' ) ) {
					$color_field.show();
					$Text_color_field.show();
					$sidebar_field.hide();
					$gallery_column_field.hide();
					$gallery_direction_field.show();
					$sidebar_field_hr.hide();
					$gallery_sidebar_field.hide();
					$gallery_sidebar_pos_field.hide();
					$gallery_sidebar_field_hr.hide();
					$gallery_sidebar_pos_field_hr.hide();
				} else if ($selected_product_detail.hasClass( 'pd_top' )) {
					$color_field.show();
					$Text_color_field.hide();
					$gallery_column_field.hide();
					$gallery_direction_field.hide();
					$sidebar_field.hide();
					$sidebar_field_hr.hide();
					$gallery_sidebar_field.hide();
					$gallery_sidebar_pos_field.hide();
					$gallery_sidebar_field_hr.hide();
					$gallery_sidebar_pos_field_hr.hide();
				} else if ($selected_product_detail.hasClass( 'pd_fullwidth_top' )) {
					$color_field.hide();
					$Text_color_field.hide();
					$gallery_column_field.hide();
					$gallery_direction_field.hide();
					$sidebar_field.hide();
					$sidebar_field_hr.hide();
					$gallery_sidebar_field.hide();
					$gallery_sidebar_pos_field.hide();
					$gallery_sidebar_field_hr.hide();
					$gallery_sidebar_pos_field_hr.hide();
				} else if ($selected_product_detail.hasClass( 'pd_classic_sidebar' )) {
					$color_field.hide();
					$Text_color_field.hide();
					$gallery_sidebar_field.hide();
					$gallery_column_field.hide();
					$gallery_direction_field.show();
					$gallery_sidebar_pos_field.hide();
					$gallery_sidebar_field_hr.hide();
					$gallery_sidebar_pos_field_hr.hide();
					$sidebar_field.show();
					$sidebar_field_hr.show();
				} else if ($selected_product_detail.hasClass( 'pd_col_gallery' )) {
					$color_field.hide();
					$Text_color_field.hide();
					$gallery_column_field.show();
					$gallery_direction_field.show();
					$gallery_sidebar_field.show();
					$gallery_sidebar_pos_field.hide();
					$gallery_sidebar_pos_field_hr.hide();
					$gallery_sidebar_field_hr.show();
					$sidebar_field.hide();
					$sidebar_field_hr.hide();

				} else {
					$color_field.hide();
					$Text_color_field.hide();
					$gallery_column_field.hide();
					$gallery_direction_field.show();
					$sidebar_field.hide();
					$sidebar_field_hr.hide();
					$gallery_sidebar_field.hide();
					$gallery_sidebar_pos_field.hide();
					$gallery_sidebar_pos_field_hr.hide();
					$gallery_sidebar_field_hr.hide();
				}
			}
		}

		$( 'input[name="product_detail_style_inherit"]' ).on( 'click', toggle_product_detail_section );
		toggle_product_detail_section();

		$product_detail.find( 'a' ).on(
			'click',
			function(){
				if ($( this ).hasClass( 'pd_background' ) ) {
					$color_field.show();
					$Text_color_field.show();
					$gallery_column_field.hide();
					$gallery_direction_field.show();
					$sidebar_field.hide();
					$sidebar_field_hr.hide();
					$gallery_sidebar_field.hide();
					$gallery_sidebar_pos_field.hide();
					$gallery_sidebar_pos_field_hr.hide();
					$gallery_sidebar_field_hr.hide();
				} else if ($( this ).hasClass( 'pd_top' )) {
					$color_field.show();
					$Text_color_field.hide();
					$gallery_column_field.hide();
					$gallery_direction_field.hide();
					$sidebar_field.hide();
					$sidebar_field_hr.hide();
					$gallery_sidebar_field.hide();
					$gallery_sidebar_pos_field.hide();
					$gallery_sidebar_pos_field_hr.hide();
					$gallery_sidebar_field_hr.hide();
				} else if ($( this ).hasClass( 'pd_fullwidth_top' )) {
					$color_field.hide();
					$Text_color_field.hide();
					$gallery_column_field.hide();
					$gallery_direction_field.hide();
					$sidebar_field.hide();
					$sidebar_field_hr.hide();
					$gallery_sidebar_field.hide();
					$gallery_sidebar_pos_field.hide();
					$gallery_sidebar_pos_field_hr.hide();
					$gallery_sidebar_field_hr.hide();
				} else if ($( this ).hasClass( 'pd_classic_sidebar' )) {
					$color_field.hide();
					$Text_color_field.hide();
					$gallery_column_field.hide();
					$gallery_direction_field.show();
					$sidebar_field.show();
					$sidebar_field_hr.show();
					$gallery_sidebar_field.hide();
					$gallery_sidebar_pos_field.hide();
					$gallery_sidebar_pos_field_hr.hide();
					$gallery_sidebar_field_hr.hide();
				} else if ($( this ).hasClass( 'pd_col_gallery' )) {
					$color_field.hide();
					$Text_color_field.hide();
					$sidebar_field.hide();
					$sidebar_field_hr.hide();
					$gallery_column_field.show();
					$gallery_direction_field.show();
					$gallery_sidebar_field.show();
					$gallery_sidebar_pos_field.hide();
					$gallery_sidebar_pos_field_hr.hide();
					$gallery_sidebar_field_hr.show();
				} else {
					$color_field.hide();
					$Text_color_field.hide();
					$gallery_column_field.hide();
					$gallery_direction_field.show();
					$sidebar_field.hide();
					$sidebar_field_hr.hide();
					$gallery_sidebar_field.hide();
					$gallery_sidebar_pos_field.hide();
					$gallery_sidebar_pos_field_hr.hide();
					$gallery_sidebar_field_hr.hide();
				}
			}
		)
	}

	function product_social_share_dependencies()
	{
		var $product_social_share_display = $( 'input[name="social_share_inherit"]' ).closest( '.field' ).next( '.field' );

		function toggle_product_social_share_section() {

			if ($( 'input[name="social_share_inherit"]:checked' ).val() == '0') {
				$product_social_share_display.hide();
			} else {
				$product_social_share_display.show();
			}
		}

		$( 'input[name="social_share_inherit"]' ).on( 'click', toggle_product_social_share_section );
		toggle_product_social_share_section();
	}
	function product_payment_methods_dependencies()
	{
		var $product_payment_methods_display = $( 'input[name="payment_methods_image_inherit"]' ).closest( '.field' ).next( '.field' );

		function toggle_product_payment_methods_display_section() {

			if ($( 'input[name="payment_methods_image_inherit"]:checked' ).val() == '0') {
				$product_payment_methods_display.hide();
			} else {
				$product_payment_methods_display.show();
			}
		}

		$( 'input[name="payment_methods_image_inherit"]' ).on( 'click', toggle_product_payment_methods_display_section );
		toggle_product_payment_methods_display_section();
	}
	function product_zoom_dependencies()
	{
		var $product_zoom_display = $( 'input[name="shop_enable_zoom_inherit"]' ).closest( '.field' ).next( '.field' );

		function toggle_product_zoom_section() {

			if ($( 'input[name="shop_enable_zoom_inherit"]:checked' ).val() == '0') {
				$product_zoom_display.hide();
			} else {
				$product_zoom_display.show();
			}
		}

		$( 'input[name="shop_enable_zoom_inherit"]' ).on( 'click', toggle_product_zoom_section );
		toggle_product_zoom_section();
	}

	function product_description_align_dependencies()
	{
		var $product_description_align_display = $( 'input[name="product_description_align_inherit"]' ).closest( '.field' ).next( '.field' );

		function toggle_product_description_align_section() {

			if ($( 'input[name="product_description_align_inherit"]:checked' ).val() == '0') {
				$product_description_align_display.hide();
			} else {
				$product_description_align_display.show();
			}
		}

		$( 'input[name="product_description_align_inherit"]' ).on( 'click', toggle_product_description_align_section );
		toggle_product_description_align_section();
	}
	function variations_select_style_dependencies()
	{
		var $variations_select_style_display = $( 'input[name="variations_select_style_inherit"]' ).closest( '.field' ).next( '.field' );

		function toggle_variations_select_style_section() {

			if ($( 'input[name="variations_select_style_inherit"]:checked' ).val() == '0') {
				$variations_select_style_display.hide();
			} else {
				$variations_select_style_display.show();
			}
		}

		$( 'input[name="variations_select_style_inherit"]' ).on( 'click', toggle_variations_select_style_section );
		toggle_variations_select_style_section();
	}

	function product_extera_content_dependencies()
	{
		var $product_extera_content_display    = $( 'input[name="product_extera_content_inherit"]' ).closest( '.field' ).next( '.field' );
		var $product_extera_content_visibility = $( 'input[name="product_extera_content_inherit"]' ).closest( '.section-product_extera_content' ).siblings( '.section-size_guide' );

		function toggle_product_extera_content_section() {

			if ($( 'input[name="product_extera_content_inherit"]:checked' ).val() == '0') {
				$product_extera_content_display.hide();
				$product_extera_content_visibility.hide();
			} else {
				$product_extera_content_display.show();
				if ($( 'input[name="product_extera_content"]:checked' ).val() == '0') {
					$product_extera_content_visibility.hide();
				} else {
					$product_extera_content_visibility.show();
				}
			}

		}
		$( 'input[name="product_extera_content_inherit"] , input[name="product_extera_content"]' ).on( 'click', toggle_product_extera_content_section );
		toggle_product_extera_content_section();
	}

	function product_gallery_sidebar_dependencies()
	{
		var $product_gallery_sidebar = $( 'input[name="product_detail_gallery_sidebar"]' ).closest( '.field' ).next( '.field' );

		function toggle_product_gallery_section() {

			if ($( 'input[name="product_detail_gallery_sidebar"]:checked' ).val() == '1') {
				$product_gallery_sidebar.hide();
			} else {
				$product_gallery_sidebar.show();
			}
		}

		$( 'input[name="product_detail_gallery_sidebar"]' ).on( 'click', toggle_product_gallery_section );
		toggle_product_gallery_section();
	}

	function product_desc_tab_dependencies()
	{
		var $product_desc_tab_display = $( 'input[name="product_desc_tab_inherit"]' ).closest( '.field' ).next( '.field' );

		function toggle_product_desc_tab_section() {

			if ($( 'input[name="product_desc_tab_inherit"]:checked' ).val() == '0') {
				$product_desc_tab_display.hide();
			} else {
				$product_desc_tab_display.show();
			}
		}

		$( 'input[name="product_desc_tab_inherit"]' ).on( 'click', toggle_product_desc_tab_section );
		toggle_product_desc_tab_section();
	}
	function gallery_sidebar_dependencies()
	{
		var $gallery_sidebar_display    = $( 'input[name="product_detail_style_inherit"]' ).closest( '.section-product_detail_style' ).siblings( '.section-product_detail_gallery_sidebar_position' );
			$gallery_sidebar_display_hr = $gallery_sidebar_display.next( 'hr' );

		function toggle_gallery_sidebar_section() {

			if ($( 'input[name="product_detail_gallery_sidebar"]:checked' ).val() == '0') {
				$gallery_sidebar_display.show();
				$gallery_sidebar_display_hr.show();
			} else {
				$gallery_sidebar_display.hide();
				$gallery_sidebar_display_hr.hide();
			}
		}

		$( 'input[name="product_detail_gallery_sidebar"]' ).on( 'click', toggle_gallery_sidebar_section );
		toggle_gallery_sidebar_section();
	}

	function ColorPicker() {
		if ( ! $.fn.wpColorPicker) {
			return;
		}

		$( '#product_meta_box .colorinput' ).each(
			function () {
				$( this ).wpColorPicker( { palettes : false} );
			}
		);

	}

	$( document ).ready(
		function () {
			ColorPicker();
			video_type_dependencies();
			product_detail_style_dependencies();
			product_social_share_dependencies();
			product_payment_methods_dependencies();
			product_desc_tab_dependencies();
			product_gallery_sidebar_dependencies();
			product_zoom_dependencies();
			product_description_align_dependencies();
			variations_select_style_dependencies();
			product_extera_content_dependencies();
			gallery_sidebar_dependencies();
		}
	);

})( jQuery );
