<?php
/**
 * Elementor Animated Text Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Animated_Text_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Animated Text widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-animated-text';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Animated Text widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Animated Text', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Animated Text widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-text-area kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Animated Text widget belongs to.
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
		return array( 'kite-animated-text' );
	}

	/**
	 * Register Animated Text widget controls.
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
				'label' => esc_html__( 'Animated Text', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'title',
			array(
				'label' => esc_html__( 'Title', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
			)
		);
		$this->add_control(
			'animatedtext_style',
			array(
				'label'   => esc_html__( 'Styles', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'with_image' => esc_html__( 'Animated text with Image background', 'kitestudio-core' ),
					'text_only'  => esc_html__( 'Animated text', 'kitestudio-core' ),
				),
				'default' => 'with_image',
			)
		);
		$this->add_control(
			'image_url',
			array(
				'label'     => esc_html__( 'Image URL', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'animatedtext_style' => 'with_image',
				),
			)
		);
		$this->add_control(
			'title_front_color',
			array(
				'label'     => esc_html__( 'Front Text Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => array(
					'animatedtext_style' => 'with_image',
				),
				'selectors' => array(
					'{{WRAPPER}} .firsttitle' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_back_color',
			array(
				'label'     => esc_html__( 'Text Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#272727',
				'selectors' => array(
					'{{WRAPPER}} .secondtitle' => 'color:{{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Text Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .immediate',
			)
		);
		$this->add_control(
			'animatedtext_font_size',
			array(
				'label'       => esc_html__( 'Animated Text Height(vw)', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'description' => esc_html__( 'Enter the size of height (minimum possible value is equal to 1), for example 14.', 'kitestudio-core' ),
				'default'     => 30,
			)
		);
		$this->add_control(
			'animatedtext_speed',
			array(
				'label'   => esc_html__( 'Animation Duration', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'4'  => esc_html__( 'Faster', 'kitestudio-core' ),
					'8'  => esc_html__( 'Fast', 'kitestudio-core' ),
					'12' => esc_html__( 'Medium', 'kitestudio-core' ),
					'16' => esc_html__( 'Slow', 'kitestudio-core' ),
					'24' => esc_html__( 'Slower', 'kitestudio-core' ),
				),
				'default' => '4',
			)
		);
		$this->end_controls_section();

	}

	/**
	 * Render Animated Text widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$atts = [
			'title' =>   $settings['title']  ,
			'title_back_color' =>   $settings['title_back_color']  ,
			'animatedtext_font_size' =>   $settings['animatedtext_font_size']  ,
			'animatedtext_speed' =>   $settings['animatedtext_speed']  ,
		];

		if ( $settings['animatedtext_style'] == 'with_image' ) {
			$atts['style'] = 'with_image';
			$atts['image_url'] =  $settings['image_url']['id'] ;
			$atts['title_front_color'] =  $settings['title_front_color'] ;
		} else {
			$atts['animatedtext_style'] = 'text_only';
		}

		echo kite_sc_animated_text( $atts );
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
		if ( $settings['animatedtext_style'] == 'with_image' ) {
			$image = 'style="with_image" image_url="' . esc_attr( $settings['image_url']['id'] ) . '" title_front_color="' . esc_attr( $settings['title_front_color'] ) . '"';
		} else {
			$image = 'animatedtext_style="text_only"';
		}
		echo '[animatedtext title="' . esc_attr( $settings['title'] ) . '" ' . esc_html( $image ) . ' title_back_color="' . esc_attr( $settings['title_back_color'] ) . '" animatedtext_font_size="' . esc_attr( $settings['animatedtext_font_size'] ) . '" animatedtext_speed="' . esc_attr( $settings['animatedtext_speed'] ) . '"]';

	}

	protected function content_template() {

	}
}
