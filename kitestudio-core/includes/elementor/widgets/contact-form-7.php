<?php
/**
 * Elementor Contact Form 7 Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Contact_Form_7_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Contact Form 7 widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-contact-form-7';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Contact Form 7 widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Contact Form 7', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Contact Form 7 widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-email-field kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Contact Form 7 widget belongs to.
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
		$styles = array(
			'kite-contact-form7',
			'contact-form-7',
		);
		if ( is_rtl() ) {
			$styles[] = 'contact-form-7-rtl';
		}
		return $styles;
	}

	/**
	 * load dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'contact-form-7',
			'kite-contact-form',
		);
	}

	/**
	 * Register Contact Form 7 widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$contact_forms = array();
		$args          = array(
			'post_type'      => 'wpcf7_contact_form',
			'posts_per_page' => -1,
			'fields' => 'ids'
		);
		$contact_posts = new WP_Query( $args );
		if ( $contact_posts->have_posts() ) {
			foreach ( $contact_posts->posts as $contact_form_id ) {
				$contact_forms[ $contact_form_id ] = get_the_title( $contact_form_id );
			}
		}
		wp_reset_postdata();
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Contact Form 7', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'form_id',
			array(
				'label'   => esc_html__( 'Select Contact Form', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $contact_forms,
			)
		);
		$this->add_control(
			'form_color_style',
			array(
				'label'       => esc_html__( 'Form Color Style', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'light_styles' => esc_html__( 'Light', 'kitestudio-core' ),
					'dark_styles'  => esc_html__( 'Dark', 'kitestudio-core' ),
				),
				'default'     => 'light_styles',
			)
		);
		$this->add_control(
			'form_align',
			array(
				'label'       => esc_html__( 'Form Align', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'left'   => esc_html__( 'Left', 'kitestudio-core' ),
					'center' => esc_html__( 'Center', 'kitestudio-core' ),
				),
				'default'     => 'left',
			)
		);
		$this->add_control(
			'form_width_style',
			array(
				'label'   => esc_html__( 'Form Width Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'boxed'     => esc_html__( 'Boxed', 'kitestudio-core' ),
					'fullwidth' => esc_html__( 'fullwidth', 'kitestudio-core' ),
				),
				'default' => 'boxed',
			)
		);
		$this->add_control(
			'form_style',
			array(
				'label'   => esc_html__( 'Form Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'one_column' => esc_html__( 'One Column', 'kitestudio-core' ),
					'two_column' => esc_html__( 'Two Columns', 'kitestudio-core' ),
				),
				'default' => 'one_column',
			)
		);
		$this->add_control(
			'button_style',
			array(
				'label'   => esc_html__( 'Button Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'style1' => esc_html__( 'Style 1', 'kitestudio-core' ),
					'style2' => esc_html__( 'Style 2', 'kitestudio-core' ),
					'style3' => esc_html__( 'Style 3', 'kitestudio-core' ),
				),
				'default' => 'style1',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'general_style',
			array(
				'label' => esc_html__( 'General Style', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'label_typography',
				'label'    => __( 'Label Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} form.wpcf7-form label',
			)
		);

		$this->add_responsive_control(
			'input_width',
			array(
				'label'      => __( 'Input Width', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
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
				),
				'selectors'  => array(
					'{{WRAPPER}} form.wpcf7-form input:not([type="submit"]):not([type="radio"]), {{WRAPPER}} form.wpcf7-form textarea, {{WRAPPER}} form.wpcf7-form select' => 'width: {{SIZE}}{{UNIT}}!important;',
				),
			)
		);

		$this->start_controls_tabs( 'input_normal_styles' );

		$this->start_controls_tab(
			'input_normal_style',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);
		
		$this->add_control(
			'input_bg_color',
			array(
				'label'     => esc_html__( 'Background', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} form.wpcf7-form input, {{WRAPPER}} form.wpcf7-form textarea, {{WRAPPER}} form.wpcf7-form select' => 'background-color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'input_color',
			array(
				'label'     => esc_html__( 'Input Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} form.wpcf7-form input, {{WRAPPER}} form.wpcf7-form textarea, {{WRAPPER}} form.wpcf7-form select' => 'color: {{VALUE}} !important;',
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
					'{{WRAPPER}} form.wpcf7-form label' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'input_border',
				'selector' => '{{WRAPPER}} form.wpcf7-form input, {{WRAPPER}} form.wpcf7-form textarea, {{WRAPPER}} form.wpcf7-form select',
			)
		);

		$this->add_responsive_control(
			'input_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} form.wpcf7-form input, {{WRAPPER}} form.wpcf7-form textarea, {{WRAPPER}} form.wpcf7-form select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'input_hover_style',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);
		
		$this->add_control(
			'input_bg_hover_color',
			array(
				'label'     => esc_html__( 'Background', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} form.wpcf7-form input:hover, {{WRAPPER}} form.wpcf7-form textarea:hover, {{WRAPPER}} form.wpcf7-form select:hover' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} form.wpcf7-form input:focus, {{WRAPPER}} form.wpcf7-form textarea:focus, {{WRAPPER}} form.wpcf7-form select:focus' => 'background-color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'input_hover_color',
			array(
				'label'     => esc_html__( 'Input Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} form.wpcf7-form input:hover, {{WRAPPER}} form.wpcf7-form textarea:hover, {{WRAPPER}} form.wpcf7-form select:hover' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} form.wpcf7-form input:focus, {{WRAPPER}} form.wpcf7-form textarea:focus, {{WRAPPER}} form.wpcf7-form select:focus' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'label_hover_color',
			array(
				'label'     => esc_html__( 'Label Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} form.wpcf7-form label:hover' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'input_hover_border',
				'selector' => '{{WRAPPER}} form.wpcf7-form input:hover, {{WRAPPER}} form.wpcf7-form textarea:hover, {{WRAPPER}} form.wpcf7-form select:hover',
			)
		);

		$this->add_responsive_control(
			'input_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} form.wpcf7-form input:hover, {{WRAPPER}} form.wpcf7-form textarea:hover, {{WRAPPER}} form.wpcf7-form select:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Render Contact Form 7 widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		if ( empty( $settings['form_id'] ) || ! function_exists( 'wpcf7_contact_form_tag_func' ) ) {
			return;
		}
		$classes    = array( $settings['form_color_style'], $settings['form_width_style'], $settings['form_style'], $settings['button_style'], $settings['form_align'] );
		echo wpcf7_contact_form_tag_func([
			'id' => $settings['form_id'],
			'html_class' => implode( ' ', $classes )
		], null, 'contact-form-7');
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
		if ( empty( $settings['form_id'] ) ) {
			return;
		}
		$classes    = array( $settings['form_color_style'], $settings['form_width_style'], $settings['form_style'], $settings['button_style'], $settings['form_align'] );
		$html_class = implode( ' ', $classes );
		echo '[contact-form-7 id="' . esc_attr( $settings['form_id'] ) . '" html_class="' . esc_attr( $html_class ) . '"]';

	}

	protected function content_template() {

	}
}
