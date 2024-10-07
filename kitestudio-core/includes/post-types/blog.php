<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kite_Blog' ) ) {

	class Kite_Blog extends Kite_Post_Type {

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
			parent::__construct( 'post' );
		}

		public function kite_enqueue_scripts() {
			wp_enqueue_script( 'hoverIntent' );
			wp_enqueue_script( 'jquery-easing' );

			// Include wpcolorpicker + its patch to support alpha chanel
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker-alpha' );

			wp_enqueue_style( 'kite-admin-css' );
			wp_enqueue_script( 'kite-admin-js' );

			wp_enqueue_script( 'kite-blog', KITE_CORE_URL . 'includes/post-types/js/blog.js', array( 'jquery' ), KITE_THEME_VERSION, true );

		}

		public function kite_on_process_field_for_store( $post_id, $key, $settings ) {
			// Process media field
			if ( $key != 'media' ) {
				return false;
			}

			switch ( $_POST[ $key ] ) {
				case 'image':
				{
					// delete video meta
					delete_post_meta( $post_id, 'video-type' );
					delete_post_meta( $post_id, 'video-id' );

					$images = sanitize_text_field( $_POST['gallery'] );

					update_post_meta( $post_id, 'gallery', $images );

					break;
				}
				case 'video':
				{
					// Delete images
					delete_post_meta( $post_id, 'image' );

					$video_type = sanitize_text_field( $_POST['video-type'] );
					$video_id   = sanitize_text_field( $_POST['video-id'] );

					update_post_meta( $post_id, 'video-type', $video_type );
					update_post_meta( $post_id, 'video-id', $video_id );

					break;
				}
				default:
				{
					// Delete all
					delete_post_meta( $post_id, 'video-type' );
					delete_post_meta( $post_id, 'video-id' );
					delete_post_meta( $post_id, 'image' );

					break;
				}
			}

			return false;
		}

		protected function kite_get_options() {
			$fields = array(
				'social_share_inherit' => array(
					'type'    => 'switch',
					'state0'  => esc_html__( 'Inherit from theme setting', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Custom', 'kitestudio-core' ),
					'default' => 0,
					'value'   => 0,
				),
				'post-social-share'    => array(
					'type'    => 'switch',
					'state0'  => esc_html__( 'Disable', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Enable', 'kitestudio-core' ),
					'default' => 0,
				),
				'media'                => array(
					'type'    => 'visual-select',
					'title'   => 'Specify kind of media',
					'options' => array(
						'none'          => 'none',
						'quote'         => 'quote',
						'gallery'       => 'gallery',
						'video'         => 'video',
						'video_gallery' => 'video_gallery',
						'audio'         => 'audio',
						'audio_gallery' => 'audio_gallery',
					),
					'class'   => 'post_type',
				),
				'video-type'           => array(
					'type'    => 'select',
					'options' => array(
						'vimeo'   => esc_html__( 'Vimeo', 'kitestudio-core' ),
						'youtube' => esc_html__( 'YouTube', 'kitestudio-core' ),
					),
				),
				'video-id'             => array(
					'type'        => 'text',
					'placeholder' => esc_html__( 'Video URL', 'kitestudio-core' ),
				), // video id
				'audio-url'            => array(
					'type'        => 'text',
					'placeholder' => esc_html__( 'Audio URL', 'kitestudio-core' ),
				), // Audio url
				'gallery'              => array(
					'type'    => 'upload',
					'title'   => esc_html__( 'Gallery Image', 'kitestudio-core' ),
					'referer' => 'kt-post-gallery-image',
					'meta'    => array( 'array' => true ),
				), // gallery image
				'quote_content'        => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Quote', 'kitestudio-core' ),
					'placeholder' => esc_html__( 'Quote', 'kitestudio-core' ),
				), // Quote content
				'quote_author'         => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Quote author', 'kitestudio-core' ),
					'placeholder' => esc_html__( 'Author', 'kitestudio-core' ),
				), // Quote author
				'extra_class'          => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Extra Class Name', 'kitestudio-core' ),
					'placeholder' => esc_html__( 'class name ex: class1 class2', 'kitestudio-core' ),
				), // Extra class name
			);

			// Option sections
			$options = array(
				'post-social-share' => array(
					'title'   => esc_html__( 'Display social share icons', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Choose to Show or hide social share icons in blog detail', 'kitestudio-core' ),
					'fields'  => array(
						'social_share_inherit' => $fields['social_share_inherit'],
						'post-social-share'    => $fields['post-social-share'],
					),
				), // Enable And Disable social share icon in blog detail
				'media'             => array(
					'title'   => esc_html__( 'Display Media Type', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Specify what kind of media (Image(s), Video , Audio , Video and Image(s) or Audio and Image(s)) you would like to be displayed in  blog detail page. You can always use shortcodes to add other media types in content', 'kitestudio-core' ),
					'fields'  => array(
						'media' => $fields['media'],
					),
				), // media sec
				'video'             => array(
					'title'   => esc_html__( 'Post Video', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Copy and paste your browser URL in this section to automatically load a video into your portfolio. Additional information can be uploaded in the content area.', 'kitestudio-core' ),
					'fields'  => array(
						'video-type' => $fields['video-type'],
						'video-id'   => $fields['video-id'],
					),
				), // Video sec
				'audio'             => array(
					'title'   => esc_html__( 'Post Audio', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Copy the URL of an audio that is uploaded on the SoundCloud.', 'kitestudio-core' ),
					'fields'  => array(
						'audio-url' => $fields['audio-url'],
					),
				), // Audio sec
				'gallery'           => array(
					'title'   => esc_html__( 'Post Gallery', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Upload images to be shown in blog detail page slider', 'kitestudio-core' ),
					'fields'  => array(
						'gallery' => $fields['gallery'],
					),
				), // Gallery sec
				'quote'             => array(
					'title'   => esc_html__( 'Quote', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Type down quote information', 'kitestudio-core' ),
					'fields'  => array(
						'quote_content' => $fields['quote_content'],
						'quote_author'  => $fields['quote_author'],
					),
				), // Quote sec
				'extra_class'       => array(
					'title'   => esc_html__( 'Extra Class name', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS. use space between different class name', 'kitestudio-core' ),
					'fields'  => array(
						'extra_class' => $fields['extra_class'],
					),
				), // Extra Class name
			);

			/**
			 * Filter to modify metabox options
			 */
			$options = apply_filters( 'kite_post_metaboxes_options', $options );

			$metaboxes = array(
				array(
					'id'       => 'blog_meta_box',
					'title'    => esc_html__( 'Settings', 'kitestudio-core' ),
					'context'  => 'normal',
					'priority' => 'default',
					'options'  => $options,
				), // Meta box
			);

			/**
			 * Filter to modify metabox panels
			 */
			return apply_filters( 'kite_post_metabox_panels', $metaboxes );
		}
	}

	Kite_Blog::get_instance();
}
