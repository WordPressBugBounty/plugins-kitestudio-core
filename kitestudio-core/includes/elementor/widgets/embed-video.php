<?php
/**
 * Elementor EmbedVideo Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_EmbedVideo_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve EmbedVideo widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-embed-video';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve EmbedVideo widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Embed Video', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve EmbedVideo widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-video-camera kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the EmbedVideo widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'by-kite' );
	}

	/**
	 * load dependent styles
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'mediaelement' );
	}

	/**
	 * load dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'jquery-fitvids',
			'kite-video',
		);
	}

	/**
	 * Register EmbedVideo widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Embed Video', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'video_display_type',
			array(
				'label'   => esc_html__( 'Video Display Type', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'local_video'                 => esc_html__( 'local Video', 'kitestudio-core' ),
					'embeded_video_youtube'       => esc_html__( 'Embedded Video (Youtube)', 'kitestudio-core' ),
					'embeded_video_vimeo'         => esc_html__( 'Embedded Video (Vimeo)', 'kitestudio-core' ),
					'local_video_popup'           => esc_html__( 'Local Video Popup', 'kitestudio-core' ),
					'embeded_video_youtube_popup' => esc_html__( 'Embedded Video  ( Youtube Popup )', 'kitestudio-core' ),
					'embeded_video_vimeo_popup'   => esc_html__( 'Embedded Video ( Vimeo Popup )', 'kitestudio-core' ),
				),
				'default' => 'local_video',
			)
		);
		$this->add_control(
			'alignment',
			array(
				'label'     => esc_html__( 'Play Button Alignment', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'center' => esc_html__( 'center', 'kitestudio-core' ),
					'left'   => esc_html__( 'left', 'kitestudio-core' ),
					'right'  => esc_html__( 'right', 'kitestudio-core' ),
				),
				'default'   => 'center',
				'condition' => array(
					'video_display_type' => array( 'local_video_popup', 'embeded_video_youtube_popup', 'embeded_video_vimeo_popup' ),
				),
			)
		);
		$this->add_control(
			'el_aspect',
			array(
				'label'     => esc_html__( 'Video Aspect Ratio', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'169' => '16:9',
					'43'  => '4:3',
					'235' => '2.35:1',
				),
				'default'   => '169',
				'condition' => array(
					'video_display_type' => array( 'embeded_video_youtube', 'embeded_video_vimeo' ),
				),
			)
		);
		$this->add_control(
			'video_autoplay',
			array(
				'label'     => esc_html__( 'Auto-play', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'enable'  => esc_html__( 'Enable', 'kitestudio-core' ),
					'disable' => esc_html__( 'Disable', 'kitestudio-core' ),
				),
				'default'   => 'enable',
				'condition' => array(
					'video_display_type' => array( 'local_video', 'local_video_popup', 'embeded_video_youtube_popup', 'embeded_video_vimeo_popup' ),
				),
			)
		);
		$this->add_control(
			'loop',
			array(
				'label'     => esc_html__( 'Loop', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'enable'  => esc_html__( 'Enable', 'kitestudio-core' ),
					'disable' => esc_html__( 'Disable', 'kitestudio-core' ),
				),
				'default'   => 'enable',
				'condition' => array(
					'video_display_type' => array( 'local_video', 'local_video_popup', 'embeded_video_youtube_popup', 'embeded_video_vimeo_popup' ),
				),
			)
		);
		$this->add_control(
			'mejs_controls',
			array(
				'label'     => esc_html__( 'video controls', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'enable'  => esc_html__( 'Show', 'kitestudio-core' ),
					'disable' => esc_html__( 'Hide', 'kitestudio-core' ),
				),
				'default'   => 'enable',
				'condition' => array(
					'video_display_type' => array( 'local_video', 'local_video_popup', 'embeded_video_youtube_popup', 'embeded_video_vimeo_popup' ),
				),
			)
		);
		$this->add_control(
			'video_poster_image',
			array(
				'label'     => esc_html__( 'Video Poster Image', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'video_display_type' => array( 'local_video', 'local_video_popup' ),
				),
			)
		);
		$this->add_control(
			'video_background_image',
			array(
				'label'     => esc_html__( 'Video Cover Image', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'video_display_type' => array( 'local_video_popup', 'embeded_video_youtube_popup', 'embeded_video_vimeo_popup' ),
				),
			)
		);
		$this->add_control(
			'video_webm',
			array(
				'label'       => esc_html__( 'Self Hosted Video (.webm video type)', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'video_display_type' => array( 'local_video', 'local_video_popup' ),
				),
			)
		);
		$this->add_control(
			'video_mp4',
			array(
				'label'       => esc_html__( 'Self Hosted Video (.mp4 video type)', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'video_display_type' => array( 'local_video', 'local_video_popup' ),
				),
			)
		);
		$this->add_control(
			'video_ogv',
			array(
				'label'       => esc_html__( 'Self Hosted Video (.ogv video type)', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'video_display_type' => array( 'local_video', 'local_video_popup' ),
				),
			)
		);
		$this->add_control(
			'video_play_button_color',
			array(
				'label'     => esc_html__( 'Video Play Button Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
				),
				'default'   => 'light',
				'condition' => array(
					'video_display_type' => array( 'local_video', 'local_video_popup', 'embeded_video_youtube_popup', 'embeded_video_vimeo_popup' ),
				),
			)
		);
		$this->add_control(
			'video_vimeo_id',
			array(
				'label'       => esc_html__( 'Vimeo Video URL', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'video_display_type' => array( 'embeded_video_vimeo', 'embeded_video_vimeo_popup' ),
				),
			)
		);
		$this->add_control(
			'video_youtube_id',
			array(
				'label'       => esc_html__( 'Youtube Video URL', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'video_display_type' => array( 'embeded_video_youtube', 'embeded_video_youtube_popup' ),
				),
			)
		);
		$this->end_controls_section();

	}

	/**
	 * Render EmbedVideo widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$video_poster_image     = ! empty( $settings['video_poster_image'] ) ? $settings['video_poster_image']['id'] : '';
		$video_background_image = ! empty( $settings['video_background_image'] ) ? $settings['video_background_image']['id'] : '';
		$atts = [
			'video_display_type' =>  $settings['video_display_type']  ,
			'alignment' =>  $settings['alignment']  ,
			'el_aspect' =>  $settings['el_aspect']  ,
			'video_autoplay' =>  $settings['video_autoplay']  ,
			'loop' =>  $settings['loop']  ,
			'mejs_controls' =>  $settings['mejs_controls']  ,
			'video_poster_image' =>  $video_poster_image  ,
			'video_background_image' =>  $video_background_image  ,
			'video_webm' =>  $settings['video_webm']  ,
			'video_mp4' =>  $settings['video_mp4']  ,
			'video_ogv' =>  $settings['video_ogv']  ,
			'video_play_button_color' =>  $settings['video_play_button_color']  ,
			'video_vimeo_id' =>  $settings['video_vimeo_id']  ,
			'video_youtube_id' =>  $settings['video_youtube_id']  ,
		];
		echo kite_sc_embed_video( $atts );
	}

	/**
	 * Whether the reload preview is required or not.
	 *
	 * Used to determine whether the reload preview is required.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return bool Whether the reload preview is required.
	 */
	public function is_reload_preview_required() {
		return false;
	}

	/**
	 * Render shortcode widget as plain content.
	 *
	 * Override the default behavior by printing the shortcode instead of rendering it.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render_plain_content() {
		// In plain mode, render without shortcode
		$settings = $this->get_settings_for_display();

		$video_poster_image     = ! empty( $settings['video_poster_image'] ) ? $settings['video_poster_image']['id'] : '';
		$video_background_image = ! empty( $settings['video_background_image'] ) ? $settings['video_background_image']['id'] : '';

		echo '[embed_video video_display_type="' . esc_attr( $settings['video_display_type'] ) . '" alignment="' . esc_attr( $settings['alignment'] ) . '" el_aspect="' . esc_attr( $settings['el_aspect'] ) . '" video_autoplay="' . esc_attr( $settings['video_autoplay'] ) . '" loop="' . esc_attr( $settings['loop'] ) . '" mejs_controls="' . esc_attr( $settings['mejs_controls'] ) . '" video_poster_image="' . esc_attr( $video_poster_image ) . '" video_background_image="' . esc_attr( $video_background_image ) . '" video_webm="' . esc_attr( $settings['video_webm'] ) . '" video_mp4="' . esc_attr( $settings['video_mp4'] ) . '" video_ogv="' . esc_attr( $settings['video_ogv'] ) . '" video_play_button_color="' . esc_attr( $settings['video_play_button_color'] ) . '" video_vimeo_id="' . esc_attr( $settings['video_vimeo_id'] ) . '" video_youtube_id="' . esc_attr( $settings['video_youtube_id'] ) . '"]';

	}

	protected function content_template() {

	}
}
