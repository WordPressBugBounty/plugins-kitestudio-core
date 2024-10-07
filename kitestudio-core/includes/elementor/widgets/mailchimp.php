<?php
/**
 * Elementor Newsletter Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Mailchimp_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Newsletter widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-newsletter-mailchimp';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Newsletter widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Mailchimp', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Newsletter widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-mailchimp kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Newsletter widget belongs to.
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
		return array(
			'kite-newsletter',
		);
	}

	/**
	 * load dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'kite-newsletter',
		);
	}

	/**
	 * Register Newsletter widget controls.
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
				'label' => esc_html__( 'Newsletter', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'mailchimp_form',
			array(
				'label'   => esc_html__( 'MailChimp Form', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => kite_get_mailchimp_forms(),
				'default' => '',
			)
		);
		$this->add_control(
			'mailchimp_form_style',
			array(
				'label'     => esc_html__( 'Form Style', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
				),
				'default'   => 'light',
				'condition' => array(
					'custom_style!' => 'yes',
				),
			)
		);
		$this->add_control(
			'mailchimp_form_width_style',
			array(
				'label'     => esc_html__( 'Form Width Style', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'boxed'     => esc_html__( 'Boxed', 'kitestudio-core' ),
					'fullwidth' => esc_html__( 'fullwidth', 'kitestudio-core' ),
				),
				'default'   => 'boxed',
				'condition' => array(
					'custom_style!' => 'yes',
				),
			)
		);
		$this->add_control(
			'mailchimp_button_style',
			array(
				'label'     => esc_html__( 'Button Style', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'style1' => esc_html__( 'Style 1', 'kitestudio-core' ),
					'style2' => esc_html__( 'Style 2', 'kitestudio-core' ),
					'style3' => esc_html__( 'Style 3', 'kitestudio-core' ),
				),
				'default'   => 'style1',
				'condition' => array(
					'custom_style!' => 'yes',
				),
			)
		);

		$this->add_control(
			'custom_style',
			array(
				'label'        => esc_html__( 'Custom Style', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'yes',
				'default'      => '',
				'description'  => esc_html__( 'Remove our default style', 'kitestudio-core' ),
			)
		);

		$this->end_controls_section();

		//
		// ─── MAILCHIMP STYLE TAB ─────────────────────────────────────────
		//

		$this->start_controls_section(
			'text_input_section',
			array(
				'label'     => __( 'Input', 'kitestudio-core' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'custom_style' => 'yes',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_typography',
				'label'    => __( 'Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="text"],{{WRAPPER}} .mc4wp-form input[type="email"]',
			)
		);

		$this->add_control(
			'input_color',
			array(
				'label'     => __( 'Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mc4wp-form input[type="text"],{{WRAPPER}} .mc4wp-form input[type="email"]' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'text_input_width',
			array(
				'label'      => __( 'Width', 'kitestudio-core' ),
				'size_units' => array( 'px', 'em', '%' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'em' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="text"],{{WRAPPER}} .mc4wp-form input[type="email"]' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'text_input_max_width',
			array(
				'label'      => __( 'Max Width', 'kitestudio-core' ),
				'size_units' => array( 'px', 'em', '%' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'em' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="text"],{{WRAPPER}} .mc4wp-form input[type="email"]' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'text_input_height',
			array(
				'label'      => __( 'Height', 'kitestudio-core' ),
				'size_units' => array( 'px', 'em' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'em' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="text"],{{WRAPPER}} .mc4wp-form input[type="email"]' => 'height: {{SIZE}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'input_border',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="text"],{{WRAPPER}} .mc4wp-form input[type="email"]',
			)
		);

		$this->add_responsive_control(
			'input_border_radius',
			array(
				'label'      => __( 'Border Radius', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="text"],{{WRAPPER}} .mc4wp-form input[type="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'input_padding',
			array(
				'label'      => __( 'Padding', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="text"],{{WRAPPER}} .mc4wp-form input[type="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'input_margin',
			array(
				'label'      => __( 'Margin', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="text"],{{WRAPPER}} .mc4wp-form input[type="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// Background and Box Shadow for input - START
		$this->start_controls_tabs( 'input_tabs' );

		$this->start_controls_tab(
			'input_tab_normal_state',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'input_background',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="text"], {{WRAPPER}} .mc4wp-form input[type="email"]',
				'types'    => array( 'classic', 'gradient' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'input_box_shadow',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="text"], {{WRAPPER}} .mc4wp-form input[type="email"]',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'input_tab_hover_state',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'input_background_hover',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="text"]:hover, {{WRAPPER}} .mc4wp-form input[type="email"]:hover',
				'types'    => array( 'classic', 'gradient' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'input_box_shadow_hover',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="text"]:hover,{{WRAPPER}} .mc4wp-form input[type="email"]:hover',
			)
		);

		$this->add_control(
			'input_transition',
			array(
				'label'       => __( 'Transition Duration', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'default'     => array(
					'size' => 0.3,
				),
				'range'       => array(
					'px' => array(
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}} .mc4wp-form input[type="text"],{{WRAPPER}} .mc4wp-form input[type="email"]' => 'transition:all ease-out {{SIZE}}s;',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		// Background and Box Shadow for input - END

		$this->end_controls_section();

		$this->start_controls_section(
			'placeholder_section',
			array(
				'label'     => __( 'Input Placeholder Text', 'kitestudio-core' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'custom_style' => 'yes',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'placeholder_typography',
				'label'    => __( 'Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="text"]::placeholder,{{WRAPPER}} .mc4wp-form input[type="email"]::placeholder',
			)
		);

		$this->add_control(
			'placeholder_color',
			array(
				'label'     => __( 'Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mc4wp-form input[type="text"]::placeholder,{{WRAPPER}} .mc4wp-form input[type="email"]::placeholder' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'submit_input_section',
			array(
				'label'     => __( 'Subscribe Button', 'kitestudio-core' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'custom_style' => 'yes',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'submit_input_typography',
				'label'    => __( 'Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="submit"]',
			)
		);

		$this->add_responsive_control(
			'submit_input_width',
			array(
				'label'      => __( 'Width', 'kitestudio-core' ),
				'size_units' => array( 'px', 'em', '%' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'em' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'submit_input_max_width',
			array(
				'label'      => __( 'Max Width', 'kitestudio-core' ),
				'size_units' => array( 'px', 'em', '%' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'em' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="submit"]' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'submit_input_height',
			array(
				'label'      => __( 'Height', 'kitestudio-core' ),
				'size_units' => array( 'px', 'em' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'em' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="submit"]' => 'height: {{SIZE}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);

		$this->add_responsive_control(
			'submit_input_padding',
			array(
				'label'      => __( 'Padding', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="submit"]' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'submit_input_margin',
			array(
				'label'      => __( 'Margin', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="submit"]' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// Background and box shadow Options for submit button - START
		$this->start_controls_tabs( 'submit_tabs' );

		$this->start_controls_tab(
			'submit_input_tab_normal_state',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'submit_input_color_normal',
			array(
				'label'     => __( 'Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mc4wp-form input[type="submit"]' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'submit_input_background',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="submit"]',
				'types'    => array( 'classic', 'gradient' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'sbumit_input_box_shadow',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="submit"]',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'submit_border',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="submit"]',
			)
		);

		$this->add_responsive_control(
			'submit_border_radius',
			array(
				'label'      => __( 'Border Radius', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="submit"]' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'submit_input_tab_hover_state',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'submit_input_color_hover',
			array(
				'label'     => __( 'Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mc4wp-form input[type="submit"]:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'submit_input_background_hover',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="submit"]:hover',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'sbumit_input_box_shadow_hover',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="submit"]:hover',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'submit_border_hover',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type="submit"]:hover',
			)
		);

		$this->add_responsive_control(
			'submit_border_radius_hover',
			array(
				'label'      => __( 'Border Radius', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form input[type="submit"]:hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'submit_input_hover_transition',
			array(
				'label'       => __( 'Transition Duration', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'default'     => array(
					'size' => 0.3,
				),
				'range'       => array(
					'px' => array(
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}} .mc4wp-form input[type="submit"]' => 'transition: all ease-out {{SIZE}}s;',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		// Background and box shadow Options for submit button - END

		$this->end_controls_section();

		$this->start_controls_section(
			'form_container_section',
			array(
				'label'     => __( 'Form Container', 'kitestudio-core' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'custom_style' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'mailchimp_flex_direction',
			array(
				'label'                => esc_html__( 'Direction', 'kitestudio-core' ),
				'type'                 => \Elementor\Controls_Manager::SELECT,
				'options'              => array(
					'default' => esc_html__( 'Default', 'kitestudio-core' ),
					'column'  => esc_html__( 'Column', 'kitestudio-core' ),
					'row'     => esc_html__( 'Row', 'kitestudio-core' ),
				),
				'default'              => 'default',
				'selectors_dictionary' => array(
					'default' => 'display: block;',
					'column'  => 'display: flex; flex-direction: column;',
					'row'     => 'display: flex; flex-direction: row;',
				),
				'selectors'            => array(
					'{{WRAPPER}} .mc4wp-form-fields' => '{{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'mailchimp_alignment',
			array(
				'label'                => esc_html__( 'Alignment', 'kitestudio-core' ),
				'type'                 => \Elementor\Controls_Manager::CHOOSE,
				'options'              => array(
					'left'   => array(
						'title' => __( 'Left', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors_dictionary' => array(
					'left'   => 'align-items: flex-start; justify-content: flex-start;',
					'center' => 'align-items: center; justify-content: center;',
					'right'  => 'align-items: flex-end; justify-content: flex-end;',
				),
				'default'              => 'left',
				'selectors'            => array(
					'{{WRAPPER}} .mc4wp-form' => 'display: flex; {{VALUE}}',
				),
				'condition'            => array(
					'mailchimp_flex_direction!' => 'default',
				),
			)
		);

		$this->add_responsive_control(
			'form_container_width',
			array(
				'label'      => __( 'Width', 'kitestudio-core' ),
				'size_units' => array( 'px', 'em', '%' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'em' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form-fields' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'form_container_max_width',
			array(
				'label'      => __( 'Max Width', 'kitestudio-core' ),
				'size_units' => array( 'px', 'em', '%' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'em' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form-fields' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'form_container_height',
			array(
				'label'      => __( 'Height', 'kitestudio-core' ),
				'size_units' => array( 'px', 'em' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'em' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mc4wp-form-fields' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render Newsletter widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$atts = [
			'mailchimp_form' =>  $settings['mailchimp_form']  ,
			'mailchimp_form_style' =>  $settings['mailchimp_form_style']  ,
			'mailchimp_form_width_style' =>  $settings['mailchimp_form_width_style']  ,
			'mailchimp_button_style' =>  $settings['mailchimp_button_style']  ,
			'custom_style' =>  $settings['custom_style']  ,
		];
		echo kite_sc_newsletter_mailchimp( $atts );
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
		echo '[kt_newsletter_mailchimp mailchimp_form="' . esc_attr( $settings['mailchimp_form'] ) . '" mailchimp_form_style="' . esc_attr( $settings['mailchimp_form_style'] ) . '" mailchimp_form_width_style="' . esc_attr( $settings['mailchimp_form_width_style'] ) . '" mailchimp_button_style="' . esc_attr( $settings['mailchimp_button_style'] ) . '" custom_style="' . esc_attr( $settings['custom_style'] ) . '"]';
	}

	protected function content_template() {

	}
}
