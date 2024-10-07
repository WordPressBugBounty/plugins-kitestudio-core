<?php
/**
 * Elementor Counter Box Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Counter_Box_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Counter Box widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-counter-box';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Counter Box widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Counter Box', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Counter Box widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-counter kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Counter Box widget belongs to.
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
		return array( 'kite-counterbox' );
	}

	/**
	 * load dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'jquery-count-to',
			'kite-counter',
		);
	}

	/**
	 * Register Counter Box widget controls.
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
				'label' => esc_html__( 'Counter Box', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'counter_number',
			array(
				'label' => esc_html__( 'Number', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'counter_number_color',
			array(
				'label'     => esc_html__( "Counter's Number Color", 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .counterboxnumber' => 'color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'counter_text',
			array(
				'label' => esc_html__( 'Counter title', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'counter_text2',
			array(
				'label' => esc_html__( 'Counter text', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'counter_text_color',
			array(
				'label'     => esc_html__( 'Title Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .counterboxdetails, {{WRAPPER}} .counterboxdetails2' => 'color:{{VALUE}}',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'animation_section',
			array(
				'label' => esc_html__( 'Animation', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'counter_animation',
			array(
				'label'       => esc_html__( 'Entrance animation', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'fade-in'        => esc_html__( 'FadeIn', 'kitestudio-core' ),
					'fade-in-bottom' => esc_html__( 'FadeIn From Bottom', 'kitestudio-core' ),
					'fade-in-top'    => esc_html__( 'FadeIn From Top', 'kitestudio-core' ),
					'fade-in-right'  => esc_html__( 'FadeIn From Right', 'kitestudio-core' ),
					'fade-in-left'   => esc_html__( 'FadeIn From Left', 'kitestudio-core' ),
					'grow-in'        => esc_html__( 'Grow In', 'kitestudio-core' ),
					'none'           => esc_html__( 'No Animation', 'kitestudio-core' ),
				),
				'default'     => 'none',
			)
		);
		$this->add_control(
			'responsive_animation',
			array(
				'label'        => esc_html__( 'Disable Animation in Responsive', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'disable',
				'default'      => 'disable',
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Render Counter Box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings  = $this->get_settings_for_display();
		$atts = [
			'counter_number' =>  $settings['counter_number']  ,
			'counter_number_color' =>  $settings['counter_number_color']  ,
			'counter_text' =>  $settings['counter_text']  ,
			'counter_text2' =>  $settings['counter_text2']  ,
			'counter_text_color' =>  $settings['counter_text_color']  ,
			'counter_animation' =>  $settings['counter_animation']  ,
			'responsive_animation' =>  $settings['responsive_animation']  ,
		];
		echo kite_sc_conterbox( $atts );
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
		echo '[conterbox counter_number="' . esc_attr( $settings['counter_number'] ) . '" counter_number_color="' . esc_attr( $settings['counter_number_color'] ) . '" counter_text="' . esc_attr( $settings['counter_text'] ) . '" counter_text2="' . esc_attr( $settings['counter_text2'] ) . '" counter_text_color="' . esc_attr( $settings['counter_text_color'] ) . '" counter_animation="' . esc_attr( $settings['counter_animation'] ) . '" responsive_animation="' . esc_attr( $settings['responsive_animation'] ) . '" ]';

	}

	protected function content_template() {

	}
}
