<?php
/**
 * Elementor Pie Chart Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Pie_Chart_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Pie Chart widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-piechart';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Pie Chart widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Pie Chart', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Pie Chart widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-counter-circle kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Pie Chart widget belongs to.
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
		return array( 'kite-piechart' );
	}

	/**
	 * load dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'jquery-easypiechart',
			'kite-pie-chart',
		);
	}

	/**
	 * Register Pie Chart widget controls.
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
				'label' => esc_html__( 'Pie Chart', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'piechart_percent',
			array(
				'label' => esc_html__( 'Pie Chart Progress Percentage', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'piechart_percent_display',
			array(
				'label'   => esc_html__( 'Pie Chart Percentage visibility', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'enable'  => esc_html__( 'Enable', 'kitestudio-core' ),
					'disable' => esc_html__( 'Disable', 'kitestudio-core' ),
				),
				'default' => 'enable',
			)
		);
		$this->add_control(
			'piechart_new_icon',
			array(
				'label' => esc_html__( 'Icon', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::ICONS,
			)
		);
		$this->add_control(
			'main_color',
			array(
				'label'   => esc_html__( 'Main Color', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#444',
			)
		);
		$this->add_control(
			'piechart_color',
			array(
				'label'   => esc_html__( 'Pie chart line custom Color', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#444',
			)
		);
		$this->add_control(
			'title',
			array(
				'label' => esc_html__( 'Pie Chart Title', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'title_color',
			array(
				'label'   => esc_html__( 'Title Color', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#444',
			)
		);
		$this->add_control(
			'subtitle',
			array(
				'label' => esc_html__( 'Pie Chart Subtitle', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'subtitle_color',
			array(
				'label'   => esc_html__( 'Subtitle Color', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#444',
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
			'piechart_animation',
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
	 * Render Pie Chart widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		// Check if its already migrated
		$migrated = isset( $settings['__fa4_migrated']['piechart_new_icon'] );
		// Check if its a new widget without previously selected icon using the old Icon control
		$is_new = empty( $settings['piechart_icon'] );
		if ( $is_new || $migrated ) {
			$piechart_icon = $settings['piechart_new_icon']['library'] == 'svg' ? '' : $settings['piechart_new_icon']['value'];
		} elseif ( isset( $settings['piechart_icon']['value'] ) ) {
			$piechart_icon = $settings['piechart_icon']['library'] == 'svg' ? '' : $settings['piechart_icon']['value'];
		} else {
			$piechart_icon = $settings['piechart_icon'];
		}

		$atts = [
			'title' =>  $settings['title']  ,
			'title_color' =>  $settings['title_color']  ,
			'subtitle' =>  $settings['subtitle']  ,
			'subtitle_color' =>  $settings['subtitle_color']  ,
			'piechart_percent' =>  $settings['piechart_percent']  ,
			'piechart_percent_display' =>  $settings['piechart_percent_display']  ,
			'piechart_color' =>  $settings['piechart_color']  ,
			'piechart_color_preset' => 'custom' ,
			'main_color' =>  $settings['main_color']  ,
			'piechart_icon' =>  $piechart_icon  ,
			'piechart_animation' =>  $settings['piechart_animation']  ,
			'responsive_animation' =>  $settings['responsive_animation']  ,
		];

		echo kite_sc_piechart( $atts );
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

		// Check if its already migrated
		$migrated = isset( $settings['__fa4_migrated']['piechart_new_icon'] );
		// Check if its a new widget without previously selected icon using the old Icon control
		$is_new = empty( $settings['piechart_icon'] );
		if ( $is_new || $migrated ) {
			$piechart_icon = $settings['piechart_new_icon']['library'] == 'svg' ? '' : $settings['piechart_new_icon']['value'];
		} elseif ( isset( $settings['piechart_icon']['value'] ) ) {
			$piechart_icon = $settings['piechart_icon']['library'] == 'svg' ? '' : $settings['piechart_icon']['value'];
		} else {
			$piechart_icon = $settings['piechart_icon'];
		}

		echo '[piechart title="' . esc_attr( $settings['title'] ) . '" title_color="' . esc_attr( $settings['title_color'] ) . '" subtitle="' . esc_attr( $settings['subtitle'] ) . '" subtitle_color="' . esc_attr( $settings['subtitle_color'] ) . '" piechart_percent="' . esc_attr( $settings['piechart_percent'] ) . '" piechart_percent_display="' . esc_attr( $settings['piechart_percent_display'] ) . '" piechart_color="' . esc_attr( $settings['piechart_color'] ) . '" piechart_color_preset="custom" main_color="' . esc_attr( $settings['main_color'] ) . '" piechart_icon="' . esc_attr( $piechart_icon ) . '" piechart_animation="' . esc_attr( $settings['piechart_animation'] ) . '" responsive_animation="' . esc_attr( $settings['responsive_animation'] ) . '"]';
	}

	protected function content_template() {

	}
}
