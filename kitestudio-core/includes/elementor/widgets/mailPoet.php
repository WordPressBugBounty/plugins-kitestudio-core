<?php
/**
 * Elementor Newsletter Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Newsletter_Widget extends \Elementor\Widget_Base {

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
		return 'kite-newsletter';
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
		return esc_html__( 'Newsletter', 'kitestudio-core' );
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
		return 'eicon-mail kite-element-icon';
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
			'mailpoet_form',
			array(
				'label'   => esc_html__( 'MailPoet Form', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array_merge( array( 1 => 'Select a form ...' ), array_flip( kite_get_mailpoet_forms() ) ),
				'default' => '1',
			)
		);
		$this->add_control(
			'mail_poet_form_style',
			array(
				'label'   => esc_html__( 'Form Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
				),
				'default' => 'light',
			)
		);
		$this->add_control(
			'mail_poet_form_width_style',
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
			'mail_poet_button_style',
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
			'mailpoet_form' =>  $settings['mailpoet_form']  ,
			'mail_poet_form_style' =>  $settings['mail_poet_form_style']  ,
			'mail_poet_form_width_style' =>  $settings['mail_poet_form_width_style']  ,
			'mail_poet_button_style' =>  $settings['mail_poet_button_style']  ,
		];
		
		echo kite_sc_newsletter_v3( $atts );
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
		echo '[kt_newsletter_3 mailpoet_form="' . esc_attr( $settings['mailpoet_form'] ) . '" mail_poet_form_style="' . esc_attr( $settings['mail_poet_form_style'] ) . '" mail_poet_form_width_style="' . esc_attr( $settings['mail_poet_form_width_style'] ) . '" mail_poet_button_style="' . esc_attr( $settings['mail_poet_button_style'] ) . '"]';
	}

	protected function content_template() {

	}
}
