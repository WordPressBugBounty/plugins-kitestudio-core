<?php
/**
 * Elementor Teta TextBox Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Teta_TextBox_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Teta TextBox widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-teta-text-box';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Teta TextBox widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Teta TextBox', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Teta TextBox widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-animation-text kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Teta TextBox widget belongs to.
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
		return array( 'kite-teta-textbox' );
	}

	/**
	 * load dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'typed',
			'kite-teta-text-box',
		);
	}

	/**
	 * Register Teta TextBox widget controls.
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
				'label' => esc_html__( 'Teta TextBox', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'content',
			array(
				'label' => esc_html__( 'Content', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::WYSIWYG,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'label'    => esc_html__( 'Content Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .text',
			)
		);
		$this->add_responsive_control(
			'content_align',
			array(
				'label'        => esc_html__( 'Alignment', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'options'      => array(
					'left'    => array(
						'title' => __( 'Left', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => __( 'Justified', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'default'      => '',
				'prefix_class' => 'textbox-align-',
				'selectors'    => array(
					'{{WRAPPER}} .textbox .text' => 'text-align:{{VALUE}} !important',
					'{{WRAPPER}}.textbox-align-center .textbox .text' => 'margin: 0 auto',
					'{{WRAPPER}}.textbox-align-right .textbox .text' => 'margin-left: auto;margin-right:unset;',
					'{{WRAPPER}}.textbox-align-left .textbox .text,{{WRAPPER}}.textbox-align-justify .textbox .text' => 'margin-right: auto;margin-left:unset;',
				),
			)
		);
		$this->add_responsive_control(
			'content_size',
			array(
				'label'      => esc_html__( 'Content Size', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .text' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'custom_color_check',
			array(
				'label'        => esc_html__( 'Custom Color', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => '',
			)
		);

		$this->add_control(
			'text_content_color',
			array(
				'label'     => esc_html__( 'Content Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'custom_color_check' => 'enable',
				),
			)
		);
		$this->add_control(
			'typing_animation_check',
			array(
				'label'        => esc_html__( 'Typing Animation', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => '',
			)
		);
		$this->add_control(
			'type_speed',
			array(
				'label'     => esc_html__( 'Type Speed', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'very_slow' => esc_html__( 'Very Slow', 'kitestudio-core' ),
					'slow'      => esc_html__( 'Slow', 'kitestudio-core' ),
					'normal'    => esc_html__( 'Normal', 'kitestudio-core' ),
					'fast'      => esc_html__( 'Fast', 'kitestudio-core' ),
					'very_fast' => esc_html__( 'very fast', 'kitestudio-core' ),
				),
				'condition' => array(
					'typing_animation_check' => 'enable',
				),
			)
		);
		$this->add_control(
			'loop_animation_check',
			array(
				'label'        => esc_html__( 'Loop', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => '',
				'condition'    => array(
					'typing_animation_check' => 'enable',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render Teta TextBox widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$atts = [
			'content_align' =>  $settings['content_align']  ,
			'custom_color_check' =>  $settings['custom_color_check']  ,
			'typing_animation_check' =>  $settings['typing_animation_check']  ,
			'type_speed' =>  $settings['type_speed']  ,
			'loop_animation_check' =>  $settings['loop_animation_check']  ,
			'text_content_color' =>  $settings['text_content_color']  ,
			'content_fontsize' => 'custom' ,
		];
		
		echo kite_sc_textbox( $atts, $settings['content'] );
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
		echo '[textbox content_align="' . esc_attr( $settings['content_align'] ) . '" custom_color_check="' . esc_attr( $settings['custom_color_check'] ) . '" typing_animation_check="' . esc_attr( $settings['typing_animation_check'] ) . '" type_speed="' . esc_attr( $settings['type_speed'] ) . '" loop_animation_check="' . esc_attr( $settings['loop_animation_check'] ) . '" text_content_color="' . esc_attr( $settings['text_content_color'] ) . '" content_fontsize="custom"]' . esc_attr( $settings['content'] ) . '[/textbox]';
	}

	protected function content_template() {

	}
}
