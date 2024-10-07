<?php
namespace KiteStudioCore\Elementor\Widgets\ThemeElements;

/**
 * Elementor Cart Widget
 *
 * @since 1.2.2
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class Cart extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Icon Box Left widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-theme-cart';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Icon Box Left widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Header - Cart', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Icon Box Left widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-cart-medium kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Icon Box Left widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'kite-theme-elements' );
	}

	/**
	 * load dependent styles
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array(
			'kite-header-buttons',
		);
	}

	/**
	 * Register Icon Box Left widget controls.
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
				'label' => esc_html__( 'Cart', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Cart Icon', 'kitestudio-core' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'icon-cart',
					'library' => 'kite-icon',
				),
			)
		);

		$this->add_control(
			'icon_subtitle',
			array(
				'label' => esc_html__( 'Cart Icon Subtitle', 'kitestudio-core' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'title',
			array(
				'label' => esc_html__( 'Cart Icon Title', 'kitestudio-core' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'show_total_amount',
			array(
				'label'        => esc_html__( 'Show Total Amount', 'kitestudio-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'ON', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'OFF', 'kitestudio-core' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'show_items_number',
			array(
				'label'        => esc_html__( 'Show Total Items In Cart', 'kitestudio-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'ON', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'OFF', 'kitestudio-core' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'show_items_number_badge',
			array(
				'label'        => esc_html__( 'Show Total Items Badge', 'kitestudio-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'ON', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'OFF', 'kitestudio-core' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'show_items_number' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'wrapper_style_section',
			array(
				'label' => esc_html__( 'Wrapper Style', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'alignment',
			array(
				'label'                => esc_html__( 'Alignment', 'kitestudio-core' ),
				'type'                 => Controls_Manager::CHOOSE,
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
					'left'   => '',
					'center' => 'margin-left:auto; margin-right: auto;',
					'right'  => 'float:right',
				),
				'default'              => 'left',
				'selectors'            => array(
					'{{WRAPPER}} .kt-header-button' => '{{VALUE}}',
				),
			)
		);

		$this->add_control(
			'checkout_bg_color',
			array(
				'label'     => esc_html__( 'Checkout Button Background ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .cart-bottom-box .checkout.wc-forward:not(:hover), {{WRAPPER}} .togglesidebar .cart-bottom-box .checkout.wc-forward' => 'background-color: {{VALUE}} !important;',
				),
			)
		);

		$this->start_controls_tabs( 'wrapper_background' );

		$this->start_controls_tab(
			'wrapper_bg_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'wrapper_background_normal',
				'label'    => __( 'Wrapper Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .kt-header-button',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Wrapper Box Shadow', 'kitestudio-core' ),
				'name'     => 'wrapper_box_shadow_normal',
				'selector' => '{{WRAPPER}} .kt-header-button',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'wrapper_bg_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'wrapper_background_hover',
				'label'    => __( 'Wrapper Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .kt-header-button:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Wrapper Box Shadow', 'kitestudio-core' ),
				'name'     => 'wrapper_box_shadow_hover',
				'selector' => '{{WRAPPER}} .kt-header-button:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wrapper_bg_transition',
			array(
				'label'      => __( 'Background Transition (ms)', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 5000,
						'step' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button' => 'transition: all {{SIZE}}ms ease;',
				),
			)
		);

		$this->add_responsive_control(
			'wrapper_margin',
			array(
				'label'      => esc_html__( 'Wrapper Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'wrapper_padding',
			array(
				'label'      => esc_html__( 'Wrapper Padding', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'wrapper_border',
				'selector'  => '{{WRAPPER}} .kt-header-button',
				'separator' => 'none',
			)
		);

		$this->add_responsive_control(
			'wrapper_border_radius',
			array(
				'label'      => esc_html__( 'Wrapper Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'icon_style_section',
			array(
				'label' => esc_html__( 'Icon Style', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'icon_styles' );

		$this->start_controls_tab(
			'icon_style_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => __( 'Icon Size', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
					'em' => array(
						'min'  => 1,
						'max'  => 15,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .element-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .kt-header-button .kt-icon-container .element-icon img' => 'width: {{SIZE}}{{UNIT}};height: auto;',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .element-icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_subtitle_color',
			array(
				'label'     => esc_html__( 'Icon Subtitle color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-subtitle' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'subtitle_margin',
			array(
				'label'      => esc_html__( 'Subtitle Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'badge_margin',
			array(
				'label'      => esc_html__( 'Badge Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'show_items_number_badge' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'badge_padding',
			array(
				'label'      => esc_html__( 'Badge Padding', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'show_items_number_badge' => 'yes',
				),
			)
		);

		$this->add_control(
			'badge_color_normal',
			array(
				'label'     => esc_html__( 'Badge color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-badge' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'badge_background',
				'label'     => __( 'Badge Background', 'kitestudio-core' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .kt-header-button .kt-icon-container .kt-badge',
				'condition' => array(
					'show_items_number_badge' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'badge_border',
				'selector'  => '{{WRAPPER}} .kt-header-button .kt-icon-container .kt-badge',
				'separator' => 'none',
				'condition' => array(
					'show_items_number_badge' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'badge_border_radius',
			array(
				'label'      => esc_html__( 'Badge Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'show_items_number_badge' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'     => __( 'Badge Box Shadow', 'kitestudio-core' ),
				'name'      => 'badge_box_shadow',
				'selector'  => '{{WRAPPER}} .kt-header-button .kt-icon-container .kt-badge',
				'condition' => array(
					'show_items_number_badge' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_style_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_responsive_control(
			'icon_size_hover',
			array(
				'label'      => __( 'Icon Size', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
					'em' => array(
						'min'  => 1,
						'max'  => 15,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .element-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .element-icon img' => 'width: {{SIZE}}{{UNIT}};height: auto;',
				),
			)
		);

		$this->add_control(
			'icon_color_hover',
			array(
				'label'     => esc_html__( 'Icon color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .element-icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_subtitle_color_hover',
			array(
				'label'     => esc_html__( 'Icon Subtitle color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .kt-subtitle' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'subtitle_margin_hover',
			array(
				'label'      => esc_html__( 'Subtitle Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .kt-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'badge_margin_hover',
			array(
				'label'      => esc_html__( 'Badge Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .kt-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'show_items_number_badge' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'badge_padding_hover',
			array(
				'label'      => esc_html__( 'Badge Padding', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .kt-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'show_items_number_badge' => 'yes',
				),
			)
		);

		$this->add_control(
			'badge_color_hover',
			array(
				'label'     => esc_html__( 'Badge color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .kt-badge' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'badge_background_hover',
				'label'     => __( 'Badge Background', 'kitestudio-core' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .kt-header-button:hover .kt-icon-container .kt-badge',
				'condition' => array(
					'show_items_number_badge' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'badge_border_hover',
				'selector'  => '{{WRAPPER}} .kt-header-button:hover .kt-icon-container .kt-badge',
				'separator' => 'none',
				'condition' => array(
					'show_items_number_badge' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'badge_border_radius_hover',
			array(
				'label'      => esc_html__( 'Badge Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .kt-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'show_items_number_badge' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'     => __( 'Badge Box Shadow', 'kitestudio-core' ),
				'name'      => 'badge_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .kt-header-button:hover .kt-icon-container .kt-badge',
				'condition' => array(
					'show_items_number_badge' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'icon_style_transition',
			array(
				'label'      => __( 'Icon Styles Transition (ms)', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 5000,
						'step' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .element-icon, {{WRAPPER}} .kt-header-button .kt-icon-container .element-icon img' => 'transition: all {{SIZE}}ms ease;',
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-subtitle' => 'transition: all {{SIZE}}ms ease;',
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-badge' => 'transition: all {{SIZE}}ms ease;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'subtitle_typography',
				'label'     => __( 'Subtitle Typography', 'kitestudio-core' ),
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .kt-header-button .kt-icon-container .kt-subtitle',
				'seperator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'badge_typography',
				'label'    => __( 'Badge Typography', 'kitestudio-core' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .kt-header-button .kt-icon-container .kt-badge',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'meta_texts_section',
			array(
				'label' => esc_html__( 'Meta Texts Style', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'meta_texts_margin',
			array(
				'label'      => esc_html__( 'Meta Texts Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-meta-texts' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button .kt-meta-texts .kt-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => __( 'Title Typography', 'kitestudio-core' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .kt-header-button .kt-meta-texts .kt-title',
			)
		);

		$this->add_control(
			'amount_color',
			array(
				'label'     => esc_html__( 'Amount color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button .kt-meta-texts .kt-amount' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'amount_typography',
				'label'    => __( 'Amount Typography', 'kitestudio-core' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .kt-header-button .kt-meta-texts .kt-amount',
			)
		);

		$this->add_control(
			'total_items_color',
			array(
				'label'     => esc_html__( 'Total Items color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button .kt-meta-texts .kt-total-items' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'total_items_typography',
				'label'    => __( 'Total Items Typography', 'kitestudio-core' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .kt-header-button .kt-meta-texts .kt-total-items',
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render Icon Box Left widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$count = is_object( WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
		$total = is_object( WC()->cart ) ? WC()->cart->get_cart_subtotal() : '$0.00';
		?>
		<div class="kt-header-button kt-cart">
			<div class="kt-icon-container">
				<?php
				if ( $settings['icon']['library'] == 'svg' ) {
					echo '<span class="element-icon"><img src="' . esc_url( $settings['icon']['value']['url'] ) . '"  alt="svgicon"></span>';
				} else {
					echo '<span class="element-icon ' . esc_attr( $settings['icon']['value'] ) . '"></span>';
				}
				?>

				<?php if ( ! empty( $settings['icon_subtitle'] ) ) { ?>
					<span class="kt-subtitle"><?php echo esc_html( $settings['icon_subtitle'] ); ?></span>
				<?php } ?>
				<?php if ( $settings['show_items_number'] == 'yes' && ! empty( $settings['show_items_number_badge'] ) && $settings['show_items_number_badge'] == 'yes' ) { ?>
					<span class="kt-badge kt-count"><?php echo esc_html( $count ); ?></span>
				<?php } ?>
			</div>
			<div class="kt-meta-texts">
				<?php if ( ! empty( $settings['title'] ) ) { ?>
					<span class="kt-title"><?php echo esc_html( $settings['title'] ); ?></span>
				<?php } ?>
				<?php if ( $settings['show_total_amount'] == 'yes' ) { ?>
					<span class="kt-amount"><?php echo wp_kses_post( $total ); ?></span>
				<?php } ?>
				<?php if ( $settings['show_items_number'] == 'yes' && $settings['show_items_number_badge'] != 'yes' ) { ?>
					<span class="kt-total-items"><span class="kt-count"><?php echo esc_html( $count ); ?></span> <?php echo esc_html__( 'Items', 'kitestudio-core' ); ?></span>
				<?php } ?>
			</div>

		<?php
		if ( ! empty( $settings['cart_type'] ) && $settings['cart_type'] == 'dropdown' ) {
			?>
			<div class="dropdown-cart-container hidden-tablet hidden-phone">
				<div class="widget_shopping_cart_content hidden-phone hidden-tablet">
					<?php woocommerce_mini_cart(); ?>
				</div>
			</div>
			<?php
		}
		?>
		</div> <!-- end of kt-header-button  -->
			<div class="togglesidebar cart-sidebar-container
			<?php
			if ( ! empty( $settings['cart_type'] ) && $settings['cart_type'] == 'dropdown' ) {
				echo 'hidden-desktop';}
			?>
			">
				<div class="cartsidebarwrap">
					<div class="wc-loading"></div>
					<span class="wc-loading-bg"></span>
					<div class="widget_shopping_cart_content">
						<?php woocommerce_mini_cart(); ?>
					</div>
				</div>
			</div>
		<?php
		// echo '<div class="kt-header-builder-overlay"></div>';
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

	}

	protected function content_template() {
		?>
		<div class="kt-header-button kt-cart">
			<div class="kt-icon-container">
				<# if ( settings.icon.library == 'svg' ) { #>
					<span class="element-icon"><img src="{{{settings.icon.value.url}}}" alt="svgicon"></span>
				<# } else { #>
					<span class="element-icon {{{settings.icon.value}}}"></span>
				<# } #>
				<# if ( settings.show_items_number == 'yes' && settings.show_items_number_badge == 'yes') { #>
					<span class="kt-badge">0</span>
				<# } #>
				<span class="kt-subtitle">{{{settings.icon_subtitle}}}</span>
			</div>
			<div class="kt-meta-texts">
				<span class="kt-title">{{{settings.title}}}</span>
				<# if ( settings.show_total_amount == 'yes') { #>
					<span class="kt-amount">$0.00</span>
				<# } #>
				<# if ( settings.show_items_number == 'yes' && settings.show_items_number_badge != 'yes') { #>
					<span class="kt-total-items"><?php echo esc_html__( '0 Items', 'kitestudio-core' ); ?></span>
				<# } #>
			</div>
		</div>
		<?php
	}
}
