<?php
//
// ─── WPML COMPATIBILITY ─────────────────────────────────────────────────────────
//
if ( ! function_exists( 'kite_wpml_widgets_to_translate' ) ) {
	/**
	 * Make our widgets compatible with WPML elementor list
	 *
	 * @param array $widgets
	 * @return array
	 */
	function kite_wpml_widgets_to_translate( $widgets ) {

		$widgets['kite-team-member'] = array(
			'conditions' => array( 'widgetType' => 'kite-team-member' ),
			'fields'     => array(
				array(
					'field'       => 'name',
					'type'        => __( 'Member Name', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
				array(
					'field'       => 'job_title',
					'type'        => __( 'Member Job', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
				array(
					'field'       => 'description',
					'type'        => __( 'Content', 'kitestudio-core' ),
					'editor_type' => 'AREA',
				),
			),
		);

		$widgets['kite-testimonial'] = array(
			'conditions' => array( 'widgetType' => 'kite-testimonial' ),
			'fields'     => array(
				array(
					'field'       => 'author',
					'type'        => __( 'Name', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
				array(
					'field'       => 'job',
					'type'        => __( 'Title', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
				array(
					'field'       => 'text',
					'type'        => __( 'Statement', 'kitestudio-core' ),
					'editor_type' => 'AREA',
				),
			),
		);

		$widgets['kite-showcase'] = array(
			'conditions' => array( 'widgetType' => 'kite-showcase' ),
			'fields'     => array(
				array(
					'field'       => 'title',
					'type'        => __( 'Title', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
				array(
					'field'       => 'subtitle',
					'type'        => __( 'Subtitle', 'kitestudio-core' ),
					'editor_type' => 'AREA',
				),
				array(
					'field'       => 'text',
					'type'        => __( 'Content', 'kitestudio-core' ),
					'editor_type' => 'AREA',
				),
				array(
					'field'       => 'link_title',
					'type'        => __( 'Link Title', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
			),
		);

		$title                       = array(
			'conditions' => array( 'widgetType' => 'kite-progressbar' ),
			'fields'     => array(
				array(
					'field'       => 'title',
					'type'        => __( 'Title', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
			),
		);
		$widgets['kite-progressbar'] = $title;

		$widgets['kite-ajax-woocommerce-products']                             = $title;
		$widgets['kite-ajax-woocommerce-products']['fields']['field']          = 'tab_title';
		$widgets['kite-ajax-woocommerce-products']['conditions']['widgetType'] = 'kite-ajax-woocommerce-products';

		$widgets['kite-image-box'] = array(
			'conditions' => array( 'widgetType' => 'kite-image-box' ),
			'fields'     => array(
				array(
					'field'       => 'title',
					'type'        => __( 'Title', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
				array(
					'field'       => 'subtitle',
					'type'        => __( 'Subtitle', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
				array(
					'field'       => 'vccontent',
					'type'        => __( 'Text', 'kitestudio-core' ),
					'editor_type' => 'AREA',
				),
			),
		);

		$widgets['kite-animated-text'] = array(
			'conditions' => array( 'widgetType' => 'kite-animated-text' ),
			'fields'     => array(
				array(
					'field'       => 'title',
					'type'        => __( 'Title', 'kitestudio-core' ),
					'editor_type' => 'AREA',
				),
			),
		);
		$banner                        = array(
			'conditions' => array( 'widgetType' => 'kite-banner' ),
			'fields'     => array(
				array(
					'field'       => 'heading',
					'type'        => __( 'Heading', 'kitestudio-core' ),
					'editor_type' => 'AREA',
				),
				array(
					'field'       => 'title',
					'type'        => __( 'Title', 'kitestudio-core' ),
					'editor_type' => 'AREA',
				),
				array(
					'field'       => 'subtitle',
					'type'        => __( 'Subtitle', 'kitestudio-core' ),
					'editor_type' => 'AREA',
				),
				array(
					'field'       => 'url_title',
					'type'        => __( 'Link Title', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
			),
		);

		$widgets['kite-banner'] = $banner;

		$widgets['kite-modern-banner']                             = $banner;
		$widgets['kite-modern-banner']['conditions']['widgetType'] = 'kite-modern-banner';

		$widgets['kite-piechart'] = array(
			'conditions' => array( 'widgetType' => 'kite-piechart' ),
			'fields'     => array(
				array(
					'field'       => 'title',
					'type'        => __( 'Pie Chart Title', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
				array(
					'field'       => 'subtitle',
					'type'        => __( 'Pie Chart Subtitle', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
			),
		);

		$widgets['kite-button'] = array(
			'conditions' => array( 'widgetType' => 'kite-button' ),
			'fields'     => array(
				array(
					'field'       => 'text',
					'type'        => __( 'Button Text', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
				array(
					'field'       => 'text_hover',
					'type'        => __( 'Button on Hover Text', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
				array(
					'field'       => 'title',
					'type'        => __( 'Tooltip text', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
			),
		);

		$editor = array(
			'conditions' => array( 'widgetType' => 'kite-teta-text-box' ),
			'fields'     => array(
				array(
					'field'       => 'content',
					'type'        => __( 'Title', 'kitestudio-core' ),
					'editor_type' => 'VISUAL',
				),
			),
		);

		$widgets['kite-teta-text-box'] = $editor;

		$widgets['kite-text-slider']                             = $editor;
		$widgets['kite-text-slider']['conditions']['widgetType'] = 'kite-text-slider';

		$icon_box                     = array(
			'conditions' => array( 'widgetType' => 'kite-icon-box-top' ),
			'fields'     => array(
				array(
					'field'       => 'title',
					'type'        => __( 'Title', 'kitestudio-core' ),
					'editor_type' => 'AREA',
				),
				array(
					'field'       => 'content_text',
					'type'        => __( 'Content', 'kitestudio-core' ),
					'editor_type' => 'AREA',
				),
				array(
					'field'       => 'elementor_link_title',
					'type'        => __( 'Link Title', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
			),
		);
		$widgets['kite-icon-box-top'] = $icon_box;

		$widgets['kite-icon-box-square']                             = $icon_box;
		$widgets['kite-icon-box-square']['conditions']['widgetType'] = 'kite-icon-box-square';

		$widgets['kite-icon-box-circle']                             = $icon_box;
		$widgets['kite-icon-box-circle']['conditions']['widgetType'] = 'kite-icon-box-circle';

		$widgets['kite-icon-box-left']                             = $icon_box;
		$widgets['kite-icon-box-left']['conditions']['widgetType'] = 'kite-icon-box-left';

		$widgets['kite-icon-box-creative']                             = $icon_box;
		$widgets['kite-icon-box-creative']['conditions']['widgetType'] = 'kite-icon-box-creative';

		$widgets['kite-social-link'] = array(
			'conditions' => array( 'widgetType' => 'kite-social-link' ),
			'fields'     => array(
				array(
					'field'       => 'sociallink_style',
					'type'        => __( 'Social Network Type', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
			),
		);

		$widgets['kite-counter-box'] = array(
			'conditions' => array( 'widgetType' => 'kite-counter-box' ),
			'fields'     => array(
				array(
					'field'       => 'counter_text',
					'type'        => __( 'Counter title', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
				array(
					'field'       => 'counter_text2',
					'type'        => __( 'Counter Text', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
			),
		);

		$widgets['kite-gallery'] = array(
			'conditions' => array( 'widgetType' => 'kite-gallery' ),
			'fields'     => array(
				array(
					'field'       => 'title_text',
					'type'        => __( 'Title', 'kitestudio-core' ),
					'editor_type' => 'LINE',
				),
			),
		);

		$widgets['kite-lookbook-image-popup-reveal'] = array(
			'conditions' => array( 'widgetType' => 'kite-lookbook-image-popup-reveal' ),
			'fields'     => array(
				array(
					'field'       => 'title',
					'type'        => __( 'Title', 'kitestudio-core' ),
					'editor_type' => 'AREA',
				),
			),
		);

		return $widgets;
	}

	/**
	 * Add filter on wpml elementor widgets node when init action.
	 *
	 * @return void
	 */
	function kite_wpml_widgets_to_translate_filter() {
		add_filter( 'wpml_elementor_widgets_to_translate', 'kite_wpml_widgets_to_translate' );
	}
	add_action( 'init', 'kite_wpml_widgets_to_translate_filter' );
}

//
// ─── YITH PLUGINS ───────────────────────────────────────────────────────────────
//
function kite_modify_compare_fields( $fields ) {
	if ( ! empty( $fields['description'] ) ) {
		unset( $fields['description'] );
	}
	return $fields;
}
add_filter( 'yith_woocompare_filter_table_fields', 'kite_modify_compare_fields' );

