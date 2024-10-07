<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kite_Product' ) ) {

	class Kite_Product extends Kite_Post_Type {

		/**
		 * Instance of this class.
		 *
		 * @var      object
		 */
		protected static $instance = null;

		/**
		 * Return an instance of this class.
		 *
		 * @return    object    A single instance of this class.
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			parent::__construct( 'product' );
		}

		public function kite_enqueue_scripts() {

			wp_enqueue_script( 'jquery-easing' );

			// Include wpcolorpicker + its patch to support alpha chanel
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'kite-product', KITE_CORE_URL . 'includes/post-types/js/product.js', array( 'jquery' ), KITE_THEME_VERSION, true );
		}

		protected function kite_get_options() {

			$fields = array(
				'video_type'                        => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Video type', 'kitestudio-core' ),
					'options' => array(
						'none'                        => esc_html__( 'No video', 'kitestudio-core' ),
						'local_video_popup'           => esc_html__( 'local video popup', 'kitestudio-core' ),
						'embeded_video_vimeo_popup'   => esc_html__( 'Vimeo video popup', 'kitestudio-core' ),
						'embeded_video_youtube_popup' => esc_html__( 'Youtube video popup', 'kitestudio-core' ),
					),
				),
				'video_webm'                        => array(
					'type'        => 'text',
					'label'       => esc_html__( '.webm extension', 'kitestudio-core' ),
					'placeholder' => esc_html__( '.webm video', 'kitestudio-core' ),
				),
				'video_mp4'                         => array(
					'type'        => 'text',
					'label'       => esc_html__( '.mp4 extension', 'kitestudio-core' ),
					'placeholder' => esc_html__( '.mp4 video', 'kitestudio-core' ),
				),
				'video_ogv'                         => array(
					'type'        => 'text',
					'label'       => esc_html__( '.ogv extension', 'kitestudio-core' ),
					'placeholder' => esc_html__( '.ogv video', 'kitestudio-core' ),
				),
				'video_vimeo_id'                    => array(
					'type'  => 'text',
					'label' => esc_html__( 'Vimeo Video link', 'kitestudio-core' ),
				),
				'video_youtube_id'                  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Youtube Video link', 'kitestudio-core' ),
				),
				'video_play_button_color'           => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Select play button style.', 'kitestudio-core' ),
					'options' => array(
						'light' => esc_html__( 'Light', 'kitestudio-core' ),
						'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
					),
				),
				'video_button_label'                => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Play button label', 'kitestudio-core' ),
					'placeholder' => esc_html__( 'Watch Video', 'kitestudio-core' ),
				),
				'shop_enable_zoom_inherit'          => array(
					'type'    => 'switch',
					'state0'  => esc_html__( 'Inherit from theme setting', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Custom', 'kitestudio-core' ),
					'default' => 0,
					'value'   => 0,
				),
				'shop_enable_zoom'                  => array(
					'type'    => 'switch',
					'state0'  => esc_html__( 'Disabled', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Enabled', 'kitestudio-core' ),
					'value'   => 1,
					'default' => 1,
				),
				'product_description_align_inherit' => array(
					'type'    => 'switch',
					'state0'  => esc_html__( 'Inherit from theme setting', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Custom', 'kitestudio-core' ),
					'default' => 0,
					'value'   => 0,
				),
				'product_description_align'         => array(
					'type'    => 'switch',
					'state0'  => esc_html__( 'center', 'kitestudio-core' ),
					'state1'  => esc_html__( 'left', 'kitestudio-core' ),
					'value'   => 0,
					'default' => 1,
				),
				'variations_select_style_inherit'   => array(
					'type'    => 'switch',
					'state0'  => esc_html__( 'Inherit from theme setting', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Custom', 'kitestudio-core' ),
					'default' => 0,
					'value'   => 0,
				),
				'variations_select_style'           => array(
					'type'    => 'switch',
					'state0'  => esc_html__( 'Dropdown Style', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Swatch Style', 'kitestudio-core' ),
					'value'   => 1,
					'default' => 0,
				),
				'custom_product_label'              => array(
					'label'       => esc_html__( 'Custom Product Label', 'kitestudio-core' ),
					'id'          => 'custom_product_label',
					'type'        => 'text',
					'placeholder' => esc_html__( 'For example: New', 'kitestudio-core' ),

				),
				'product_lable_bg'                  => array(
					'type'  => 'color',
					'label' => esc_html__( 'Label Background Color', 'kitestudio-core' ),
					'value' => '#eee',
				),

				'extra_class'                       => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Extra Class Name', 'kitestudio-core' ),
					'placeholder' => esc_html__( 'class name ex: class1 class2', 'kitestudio-core' ),
				), // Extra class name
				'social_share_inherit'              => array(
					'type'    => 'switch',
					'state0'  => esc_html__( 'Inherit from theme setting', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Custom', 'kitestudio-core' ),
					'default' => 0,
					'value'   => 0,
				),
				'product-social-share'              => array(
					'type'    => 'switch',
					'state0'  => esc_html__( 'Disable', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Enable', 'kitestudio-core' ),
					'default' => 1,
				),
				'product_hashtag'                   => array(
					'label'       => esc_html__( 'Instagram product username', 'kitestudio-core' ),
					'id'          => 'product_hashtag',
					'type'        => 'text',
					'placeholder' => esc_html__( 'For example: #nike_rush_run', 'kitestudio-core' ),

				),
			);

			// Option sections
			$options = array(
				'shop_enable_zoom'          => array(
					'title'   => esc_html__( 'Zooming of Products Images', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Enable or disable zooming of products images', 'kitestudio-core' ),
					'fields'  => array(
						'shop_enable_zoom_inherit' => $fields['shop_enable_zoom_inherit'],
						'shop_enable_zoom'         => $fields['shop_enable_zoom'],
					),
				),
				'product_description_align' => array(
					'title'   => esc_html__( 'Product Summary Alignment in Product details', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Product Summary Alignment(left/center) in Product details', 'kitestudio-core' ),
					'fields'  => array(
						'product_description_align_inherit' => $fields['product_description_align_inherit'],
						'product_description_align' => $fields['product_description_align'],
					),
				),
				'variations_select_style'   => array(
					'title'   => esc_html__( 'Variations Select Style in Product details', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Select Variable Selection Style in Product detail', 'kitestudio-core' ),
					'fields'  => array(
						'variations_select_style_inherit' => $fields['variations_select_style_inherit'],
						'variations_select_style'         => $fields['variations_select_style'],
					),
				),
				'extra_class'               => array(
					'title'   => esc_html__( 'Extra Class name', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS. use space between different class name', 'kitestudio-core' ),
					'fields'  => array(
						'extra_class' => $fields['extra_class'],
					),
				), // Extra Class name
				'custom_product_label'      => array(
					'title'   => esc_html__( 'custom product lable', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Insert custom Label to products', 'kitestudio-core' ),
					'fields'  => array(
						'custom_product_label' => $fields['custom_product_label'],
						'product_lable_bg'     => $fields['product_lable_bg'],
					),
				), // custom label product
				'product_hashtag'           => array(
					'title'   => esc_html__( 'product hashtag', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Insert tag and display the instagram images. Note that this option will not works if you select the api connection method inside theme settings.', 'kitestudio-core' ),
					'fields'  => array(
						'product_hashtag' => $fields['product_hashtag'],
					),
				), // instagram hashtag
				'product-social-share'      => array(
					'title'   => esc_html__( 'Social Share display', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Disable/enable social share', 'kitestudio-core' ),
					'fields'  => array(
						'social_share_inherit' => $fields['social_share_inherit'],
						'product-social-share' => $fields['product-social-share'],
					),
				), // Product detail social share button
				'video_type'                => array(
					'title'   => esc_html__( 'Video type', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Select video display type.', 'kitestudio-core' ),
					'fields'  => array(
						'video_type' => $fields['video_type'],
					),
				), // Video Type
				'video_extensions'          => array(
					'title'   => esc_html__( 'Video extension', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Enter self Hosted Videos', 'kitestudio-core' ),
					'fields'  => array(
						'video_webm' => $fields['video_webm'],
						'video_mp4'  => $fields['video_mp4'],
						'video_ogv'  => $fields['video_ogv'],
					),
				),
				'video_vimeo_id'            => array(
					'title'   => esc_html__( 'Vimeo Video Link', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Enter a Video link', 'kitestudio-core' ),
					'fields'  => array(
						'video_vimeo_id' => $fields['video_vimeo_id'],
					),
				),
				'video_youtube_id'          => array(
					'title'   => esc_html__( 'Youtube Video link', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Enter a Video link', 'kitestudio-core' ),
					'fields'  => array(
						'video_youtube_id' => $fields['video_youtube_id'],
					),
				), // Youtube ID
				'video_play_button_color'   => array(
					'title'   => esc_html__( 'Play button style', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Select play button style', 'kitestudio-core' ),
					'fields'  => array(
						'video_play_button_color' => $fields['video_play_button_color'],
						'video_button_label'      => $fields['video_button_label'],
					),
				), // Video Button Color
			);

			/**
			 * Filter to modify metabox options
			 */
			$options = apply_filters( 'kite_product_metaboxes_options', $options );

			$metaboxes = array(
				array(
					'id'       => 'product_meta_box',
					'title'    => esc_html__( 'Settings', 'kitestudio-core' ),
					'context'  => 'normal',
					'priority' => 'default',
					'options'  => $options,
				), // Meta box 1
			);

			/**
			 * Filter to modify metabox panels
			 */
			return apply_filters( 'kite_product_metabox_panels', $metaboxes );
		}

		public function kite_on_process_field_for_store( $post_id, $key, $settings ) {
			$editor_inputs = [
				'size_guide',
				'delivery_return',
				'ask_question'
			];
			if ( ! in_array( $key, $editor_inputs ) ) {
				return false;
			}

			// new value.
			$posted_val = isset( $_POST[ $key ] ) ? wp_kses_post( $_POST[ $key ] ) : '';
			// old value.
			$val       = get_post_meta( $post_id, $key, false );

			// Insert.
			if ( !empty( $posted_val ) && empty( $val ) ) {
				add_post_meta( $post_id, $key, $posted_val );

			} elseif ( ! empty( $val ) && empty( $posted_val ) ) {
				// Delete.
				delete_post_meta( $post_id, $key );
			} elseif ( ! empty( $posted_val ) && ! empty( $val ) && $posted_val != $val ) {
				// Update.
				update_post_meta( $post_id, $key, $posted_val );
			}

			return $post_id;
		}
	}

	Kite_Product::get_instance();

}
