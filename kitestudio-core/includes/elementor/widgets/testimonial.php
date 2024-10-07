<?php
/**
 * Elementor Testimonial Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Testimonial_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Testimonial widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-testimonial';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Testimonial widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Testimonial', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Testimonial widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return ' eicon-testimonial-carousel kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Testimonial widget belongs to.
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
		return array( 'kite-testimonial' );
	}

	/**
	 * load dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'kite-carousel',
		);
	}

	/**
	 * Register Testimonial widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'testimonial_settings',
			array(
				'label' => esc_html__( 'Testimonial Settings', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
				),
				'default' => 'dark',
			)
		);
		$this->add_control(
			'visible_items',
			array(
				'label'   => esc_html__( 'Column', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'1' => esc_html__( '1', 'kitestudio-core' ),
					'2' => esc_html__( '2', 'kitestudio-core' ),
					'3' => esc_html__( '3', 'kitestudio-core' ),
					'4' => esc_html__( '4', 'kitestudio-core' ),
				),
				'default' => '2',
			)
		);

		$this->add_control(
			'arrow_navigation',
			array(
				'label'        => esc_html__( 'Arrow Navigation', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'enable',
			)
		);

		$this->add_control(
			'bullet_navigation',
			array(
				'label'        => esc_html__( 'Bullet Navigation', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => '',
			)
		);

		$this->add_control(
			'scroll_navigation',
			array(
				'label'        => esc_html__( 'Scroll Navigation', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => '',
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'repeater_section',
			array(
				'label' => esc_html__( 'Testimonial Items', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'image_url',
			array(
				'label'   => esc_html__( 'Image URL', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);
		$repeater->add_control(
			'author',
			array(
				'label' => esc_html__( 'Name', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$repeater->add_control(
			'job',
			array(
				'label' => esc_html__( 'Title', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$repeater->add_control(
			'text',
			array(
				'label' => esc_html__( 'Statement', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
			)
		);
		$this->add_control(
			'testimonial_items',
			array(
				'label'       => esc_html__( 'Testimonial Items', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'author' => esc_html__( 'John Doe', 'kitestudio-core' ),
						'Job'    => esc_html__( 'Executive Manager', 'kitestudio-core' ),
					),
					array(
						'author' => esc_html__( 'John Doe', 'kitestudio-core' ),
						'Job'    => esc_html__( 'Executive Manager', 'kitestudio-core' ),
					),
				),
				'title_field' => '{{{ author }}}',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'testimonial_style',
			array(
				'label' => esc_html__( 'Testimonial Style', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'item_background',
				'label'    => __( 'Items Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .carousel.testimonials-style .quote',
			)
		);

		$this->add_responsive_control(
			'item_align',
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
					)
				),
				'default'      => 'center',
				'prefix_class' => 'alignment%s-'
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'item_border',
				'selector' => '{{WRAPPER}} .quote',
			)
		);

		$this->add_responsive_control(
			'item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .quote' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'item_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .carousel.testimonials-style .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .carousel.testimonials-style .quote blockquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .carousel.testimonials-style .quote .head' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->start_controls_tabs( 'testimonial_item' );

		$this->start_controls_tab(
			'item_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'item_box_shadow_normal',
				'selector' => '{{WRAPPER}} .quote',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'item_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'item_box_shadow_hover',
				'selector' => '{{WRAPPER}} .quote:hover',
			)
		);

		$this->add_responsive_control(
			'item_transition',
			array(
				'label'      => __( 'Transition (ms)', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'separator'  => 'before',
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 5000,
						'step' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .quote' => 'transition: all {{SIZE}}ms ease;',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'texts_style',
			array(
				'label' => esc_html__( 'Texts Style', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'label'    => __( 'Content Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} blockquote',
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => esc_html__( 'Content color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} blockquote' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'name_typography',
				'label'    => __( 'Name Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .author .name',
			)
		);

		$this->add_control(
			'name_color',
			array(
				'label'     => esc_html__( 'Name color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .author .name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => __( 'Title Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .author .job',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .author .job' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'bullets_style',
			array(
				'label' => esc_html__( 'Bullets Style', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'bullet_navigation' => 'enable',
				]
			)
		);

		$this->add_control(
			'bullets_normal_color',
			array(
				'label'     => __( 'Bullets color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'bullets_active_color',
			array(
				'label'     => __( 'Bullets Active color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'bullets_align',
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
					)
				),
				'selectors' => array(
					'{{WRAPPER}} .carousel.testimonials-style .swiper-pagination' => 'text-align: {{VALUE}} !important;',
				),
				
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render Testimonial widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings          = $this->get_settings_for_display();
		$testimonial_items = [];
		foreach ( $settings['testimonial_items'] as $item ) {
			$testimonial_items[] = [
				'author' => $item['author'],
				'job' => $item['job'],
				'text' => $item['text'],
				'image_url' => $item['image_url']['id']
			];
		}
		
		$atts = [
			'style' =>  $settings['style']  ,
			'visible_items' =>  $settings['visible_items'],
			'arrow_navigation' => $settings['arrow_navigation'],
			'bullet_navigation' => $settings['bullet_navigation'],
			'scroll_navigation' => $settings['scroll_navigation'],
		];
		echo kite_sc_testimonial( $atts, $testimonial_items );
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
		$testimonial_items = '';
		foreach ( $settings['testimonial_items'] as $item ) {
			$testimonial_items .= '[testimonial_item author="' . esc_attr( $item['author'] ) . '" job="' . esc_attr( $item['job'] ) . '" text="' . esc_attr( $item['text'] ) . '" image_url="' . esc_attr( $item['image_url']['url'] ) . '"]';
		}
		echo '[testimonial style="' . esc_attr( $settings['style'] ) . '" visible_items="' . esc_attr( $settings['visible_items'] ) . '"]' . esc_html( $testimonial_items ) . '[/testimonial]';
	}

	protected function content_template() {

	}
}
