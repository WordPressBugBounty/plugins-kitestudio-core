<?php
/**
 * Elementor SoundCloud Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_SoundCloud_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve SoundCloud widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-sound-cloud';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve SoundCloud widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'SoundCloud', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve SoundCloud widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-headphones kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the SoundCloud widget belongs to.
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
	 * Register SoundCloud widget controls.
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
				'label' => esc_html__( 'SoundCloud', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'soundcloud-url',
			array(
				'label'       => esc_html__( 'SoundCloud Url', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter SoundCloud track URL here', 'kitestudio-core' ),
			)
		);
		$this->add_control(
			'soundcloud-style',
			array(
				'label'   => esc_html__( 'SoundCloud Player Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'full_width_thumbnail' => esc_html__( 'Full background album art', 'kitestudio-core' ),
					'small_thumbnail'      => esc_html__( 'Thumbnail album art', 'kitestudio-core' ),
				),
				'default' => 'full_width_thumbnail',
			)
		);

		$this->add_control(
			'soundcloud-height',
			array(
				'label'       => esc_html__( 'SoundCloud Player Height', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter SoundCloud height, for example 300.', 'kitestudio-core' ),
				'condition'   => array(
					'soundcloud-style' => 'full_width_thumbnail',
				),
			)
		);

		$this->add_control(
			'player-color',
			array(
				'label'     => esc_html__( 'SoundCloud Player Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'condition' => array(
					'soundcloud-style' => 'small_thumbnail',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render SoundCloud widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings          = $this->get_settings_for_display();
		$soundcloud_height = ( $settings['soundcloud-height'] == '' ) ? 'auto' : $settings['soundcloud-height'];
		$atts = [
			'soundcloud_id' =>  $settings['soundcloud-url']  ,
			'soundcloud_height' =>  $soundcloud_height  ,
			'soundcloud_style' =>  $settings['soundcloud-style']  ,
			'soundcloud_color' =>  $settings['player-color']  ,
		];
		echo kite_sc_audio_soundcloud( $atts );
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
		$settings          = $this->get_settings_for_display();
		$soundcloud_height = ( $settings['soundcloud-height'] == '' ) ? 'auto' : $settings['soundcloud-height'];
		echo '[audio_soundcloud soundcloud_id="' . esc_attr( $settings['soundcloud-url'] ) . '" soundcloud_height="' . esc_attr( $soundcloud_height ) . '" soundcloud_style="' . esc_attr( $settings['soundcloud-style'] ) . '" soundcloud_color="' . esc_attr( $settings['player-color'] ) . '"]';
	}

	protected function content_template() {

	}
}
