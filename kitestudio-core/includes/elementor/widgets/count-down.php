<?php
/**
 * Elementor Count Down Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Count_Down_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Count Down widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-count-down';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Count Down widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Count Down', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Count Down widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-countdown kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Count Down widget belongs to.
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
		return array();
	}

	/**
	 * load dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'kite-countdown',
		);
	}

	/**
	 * Register Count Down widget controls.
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
				'label' => esc_html__( 'Count Down', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'end_date',
			array(
				'label' => esc_html__( 'count to', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::DATE_TIME,

			)
		);
		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'countdown style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'default'    => esc_html__( 'Style 1', 'kitestudio-core' ),
					'deal_style' => esc_html__( 'Style 2', 'kitestudio-core' ),
				),
				'default' => 'default',
			)
		);
		$this->add_control(
			'bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .countdown-timer' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'style' => 'deal_style',
				),
			)
		);
		$this->add_control(
			'color',
			array(
				'label'     => esc_html__( 'Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .countdown-timer .number, {{WRAPPER}} .countdown-timer.secondstyle .time-block span:not(.seconds).number' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'label_color',
			array(
				'label'     => esc_html__( 'Label Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .countdown-timer .label' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'fontsize',
			array(
				'label'   => esc_html__( 'Countdown font size', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'16' => '16',
					'20' => '20',
					'28' => '28',
					'35' => '35',
					'44' => '44',
				),
				'default' => '16',
			)
		);
		$this->add_responsive_control(
			'alignment',
			array(
				'label'        => esc_html__( 'Alignment', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'options'      => array(
					'flex-start'    => array(
						'title' => __( 'Start', 'kitestudio-core' ),
						'icon'  => 'eicon-align-start-v',
					),
					'center'  => array(
						'title' => __( 'Center', 'kitestudio-core' ),
						'icon'  => 'eicon-align-center-v',
					),
					'flex-end'   => array(
						'title' => __( 'End', 'kitestudio-core' ),
						'icon'  => 'eicon-align-end-v',
					),
				),
				'default'      => '',
				'selectors_dictionary' => array(
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
					'flex-start' => 'flex-start',
					'flex-end'  => 'flex-end',
				),
				'selectors'    => array(
					'{{WRAPPER}}' => 'display:flex;justify-content:{{VALUE}} !important',
				),
			)
		);
		$this->end_controls_section();

	}

	/**
	 * Render Count Down widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings  = $this->get_settings_for_display();
		$end_date  = date( 'Y-m-d\TH:i:s', strtotime( $settings['end_date'] ) );
		$atts = [
			'end_date' =>  $end_date  ,
			'style' =>  $settings['style']  ,
			'alignment' =>  is_array( $settings['alignment'] ) || empty( $settings['alignment']) ? '' : $settings['alignment'] ,
			'fontsize' =>  $settings['fontsize']  ,
		];
		echo kite_sc_countdown( $atts );
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
		$end_date = date( 'Y-m-d\TH:i:s', strtotime( $settings['end_date'] ) );
		$alignment = is_array( $settings['alignment'] ) || empty( $settings['alignment']) ? '' : $settings['alignment'];
		echo '[countdown end_date="' . esc_attr( $end_date ) . '" style="' . esc_attr( $settings['style'] ) . '" alignment="' . esc_attr( $alignment ) . '" fontsize="' . esc_attr( $settings['fontsize'] ) . '"]';

	}

	protected function content_template() {
		?>
		<#
		let classes = ['countdown-timer','fontsize'+settings.fontsize];
		classes = (settings.style == 'deal_style') ? [...classes, 'secondstyle'] : classes;
		classes = classes.join(' ');
		#>
		<div class="{{classes}}" data-end="{{settings.end_date}}">
			<div class="time-block">
				<span class="days number">0</span>
				<span class="label">Days</span>
			</div>
			<div class="time-block">
				<span class="hours number">0</span>
				<span class="label">Hours</span>
			</div>
			<div class="time-block">
				<span class="minutes number">0</span>
				<span class="label">Mins</span>
			</div>
			<div class="time-block">
				<span class="seconds number">0</span>
				<span class="label">Secs</span>
			</div>
		</div>
		<?php
	}
}
