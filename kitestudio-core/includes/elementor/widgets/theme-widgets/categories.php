<?php
namespace KiteStudioCore\Elementor\Widgets\ThemeElements;

/**
 * Elementor Categories Widget
 *
 * @since 1.2.2
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Kite_Nav_Walker;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class Categories extends Widget_Base {

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
		return 'kite-theme-categories';
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
		return esc_html__( 'Header - Ladder Menu', 'kitestudio-core' );
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
		return 'eicon-nav-menu kite-element-icon';
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
	 * Get the all available menus
	 *
	 * Retrieve the list of all menus.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array menu slug.
	 */
	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = array();

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
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
				'label' => esc_html__( 'Menu', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu_slug',
				array(
					'label'        => __( 'Menu', 'kitestudio-core' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => $menus,
					'default'      => array_keys( $menus )[0],
					'save_default' => true,
					'description'  => sprintf(
						__( 'Go to the %1$s Menus screen %2$s to manage your menus.', 'kitestudio-core' ),
						'<a href="' . self_admin_url( 'nav-menus.php' ) . '" target="_blank">',
						'</a>'
					),
				)
			);
		} else {
			$this->add_control(
				'menu_slug',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'kitestudio-core' ), self_admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				)
			);
		}

		$this->add_control(
			'cat_icon',
			array(
				'label'   => __( 'Icon', 'kitestudio-core' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-bars',
					'library' => 'solid',
				),
			)
		);

		$this->add_control(
			'categories_label',
			array(
				'label'        => esc_html__( 'Categories Label', 'kitestudio-core' ),
				'type'         => Controls_Manager::TEXT,
				'default'      => ''
			)
		);

		$this->add_control(
			'categories_state',
			array(
				'label'        => esc_html__( 'Show Categories', 'kitestudio-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Open', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Close', 'kitestudio-core' ),
				'return_value' => 'open',
				'default'      => '',
			)
		);

		$this->add_control(
			'always_open',
			array(
				'label'        => esc_html__( 'Alway Open', 'kitestudio-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'categories_state' => 'open'
				]
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'responsive_section',
			array(
				'label' => esc_html__( 'Responsive', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'responsive_cat_icon',
			array(
				'label'   => __( 'Icon', 'kitestudio-core' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-bars',
					'library' => 'solid',
				),
			)
		);

		$this->add_control(
			'offcanvas_style',
			array(
				'label'        => esc_html__( 'Offcanvas style', 'kitestudio-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Dark', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Light', 'kitestudio-core' ),
				'return_value' => true,
				'default'      => kite_opt( 'mobile_menu-color', false ),
			)
		);

		$this->add_control(
			'offcanvas_from',
			array(
				'label'                => esc_html__( 'Open menu from', 'kitestudio-core' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => array(
					'left'   => array(
						'title' => __( 'Left', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'right'  => array(
						'title' => __( 'Right', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'              => 'left',
				'prefix_class'         => 'kt-open-offcanvas-from-',
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
			'wrapper_width',
			array(
				'label'      => __( 'Width', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 2000,
						'step' => 5,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .categories-element' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'wrapper_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .categories-element, #kt-header {{WRAPPER}} .allcats, {{WRAPPER}} .allcats' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
					'#kt-header {{WRAPPER}} nav.navigation, {{WRAPPER}} nav.navigation' => 'border-radius: 0 0 {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'toggle_btn_style_section',
			array(
				'label' => __( 'Toggle Button', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'toggle_btn_align',
			array(
				'label'     => esc_html__( 'Alignment', 'kitestudio-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
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
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .allcats' => 'text-align: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'toggle_btn_typography',
				'label'    => __( 'Typography', 'kitestudio-core' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '#kt-header {{WRAPPER}} .allcats, {{WRAPPER}} .allcats',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'toggle_btn_border',
				'selector'  => '#kt-header {{WRAPPER}} .allcats, {{WRAPPER}} .allcats',
				'separator' => 'none',
			)
		);

		$this->add_responsive_control(
			'toggle_btn_padding',
			array(
				'label'      => esc_html__( 'Padding', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'#kt-header {{WRAPPER}} .allcats, {{WRAPPER}} .allcats' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'toggle_btn_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'#kt-header {{WRAPPER}} .allcats, {{WRAPPER}} .allcats' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'toggle_btn_background' );

		$this->start_controls_tab(
			'toggle_btn_bg_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'btn_bg_color_normal',
				'label'    => __( 'Background Color', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '#kt-header {{WRAPPER}} .allcats,{{WRAPPER}} .allcats',
			)
		);

		$this->add_control(
			'btn_txt_color_normal',
			array(
				'label'     => esc_html__( 'Text Color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'#kt-header {{WRAPPER}} .allcats,{{WRAPPER}} .allcats' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'box_shadow_normal',
				'selector' => '{{WRAPPER}} .elementor-widget-container > .allcats, {{WRAPPER}} .category-menu-container, {{WRAPPER}} nav.navigation',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'toggle_btn_bg_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'btn_bg_color_hover',
				'label'    => __( 'Background Color', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '#kt-header {{WRAPPER}} .allcats:hover, {{WRAPPER}} .allcats:hover',
			)
		);

		$this->add_control(
			'btn_txt_color_hover',
			array(
				'label'     => esc_html__( 'Text Color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'#kt-header {{WRAPPER}} .allcats:hover, {{WRAPPER}} .allcats:hover' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'box_shadow_hover',
				'selector' => '{{WRAPPER}} .elementor-widget-container > .allcats:hover, {{WRAPPER}} .category-menu-container:hover, {{WRAPPER}} nav.navigation:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'toggle_btn_transition',
			array(
				'label'      => __( 'Transition (ms)', 'kitestudio-core' ),
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
					'{{WRAPPER}} nav.navigation, {{WRAPPER}} .allcats' => 'transition: all {{SIZE}}ms ease;',
				),
				'separator'  => 'before',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'menu_item_style_section',
			array(
				'label' => esc_html__( 'Menu Item Style', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'menu_item_typography',
				'label'    => __( 'Typography', 'kitestudio-core' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} nav.navigation ul li a',
			)
		);

		$this->add_control(
			'menu_item_icon_position',
			array(
				'label'                => __( 'Icon Position', 'kitestudio-core' ),
				'type'                 => Controls_Manager::SELECT,
				'options'              => array(
					''      => __( 'Default', 'kitestudio-core' ),
					'left'  => __( 'Left', 'kitestudio-core' ),
					'right' => __( 'Right', 'kitestudio-core' ),
				),
				'selectors_dictionary' => array(
					''      => 'order: 2;',
					'left'  => 'order: 1;',
					'right' => 'order: 2;',
				),
				'default'              => '',
				'selectors'            => array(
					'{{WRAPPER}} .navigation.catmenu > ul > li > a span.icon' => '{{VALUE}}',
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => __( 'Icon Size', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .navigation > ul > li .icon' => 'font-size: {{SIZE}}px;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'menu_item_border',
				'selector'  => '#kt-header {{WRAPPER}} nav.navigation > ul > li',
				'separator' => 'none',
			)
		);

		$this->add_responsive_control(
			'menu_item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} nav.navigation > ul > li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'menu_last_item_border_radius',
			array(
				'label'      => esc_html__( 'Last Item Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} nav.navigation > ul > li:last-child' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->start_controls_tabs( 'menu_item_state' );

		$this->start_controls_tab(
			'menu_item_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'menu_item_color_normal',
			array(
				'label'     => esc_html__( 'Item Text Color', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} nav.navigation > ul > li > a .menu_title, #kt-header {{WRAPPER}} nav.navigation > ul > li:after' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'menu_item_icon_color_normal',
			array(
				'label'     => esc_html__( 'Item Icon Color', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} nav.navigation > ul > li > a .icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'menu_item_background_normal',
				'label'    => __( 'Menu Item Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} nav.navigation > ul > li',
			)
		);

		$this->add_control(
			'menu_item_decoration_normal',
			array(
				'label'     => __( 'Decoration Line', 'kitestudio-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''             => __( 'Select', 'kitestudio-core' ),
					'underline'    => __( 'Underline', 'kitestudio-core' ),
					'overline'     => __( 'Overline', 'kitestudio-core' ),
					'line-through' => __( 'Line Through', 'kitestudio-core' ),
				),
				'selectors' => array(
					'{{WRAPPER}} nav.navigation > ul > li > a' => 'text-decoration:{{VALUE}};',
				),
			)
		);

		$this->add_control(
			'menu_item_decoration_color_normal',
			array(
				'label'     => esc_html__( 'Decoration Style Color', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} nav.navigation > ul > li > a' => 'text-decoration-color: {{VALUE}};',
				),
				'condition' => array(
					'menu_item_decoration_normal!' => '',
				),
			)
		);

		$this->add_control(
			'menu_item_decoration_style_normal',
			array(
				'label'     => __( 'Decoration Style', 'kitestudio-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'solid'  => __( 'Solid', 'kitestudio-core' ),
					'double' => __( 'Double', 'kitestudio-core' ),
					'dotted' => __( 'Dotted', 'kitestudio-core' ),
					'dashed' => __( 'Dashed', 'kitestudio-core' ),
					'wavy'   => __( 'Wavy', 'kitestudio-core' ),
				),
				'selectors' => array(
					'{{WRAPPER}} nav.navigation > ul > li > a' => 'text-decoration-style:{{VALUE}};',
				),
				'condition' => array(
					'menu_item_decoration_normal!' => '',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'menu_item_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'menu_item_color_hover',
			array(
				'label'     => esc_html__( 'Text Color', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} nav.navigation > ul > li:hover > a .menu_title, #kt-header {{WRAPPER}} nav.navigation > ul > li:hover:after' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'menu_item_icon_color_hover',
			array(
				'label'     => esc_html__( 'Item Icon Color', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} nav.navigation > ul > li:hover > a .icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'menu_item_background_hover',
				'label'    => __( 'Menu Item Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '#kt-header {{WRAPPER}} nav.navigation > ul > li.hover, #kt-header {{WRAPPER}} nav.navigation > ul > li:hover',
			)
		);

		$this->add_control(
			'menu_item_decoration_hover',
			array(
				'label'     => __( 'Decoration Line', 'kitestudio-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''             => __( 'Select', 'kitestudio-core' ),
					'underline'    => __( 'Underline', 'kitestudio-core' ),
					'overline'     => __( 'Overline', 'kitestudio-core' ),
					'line-through' => __( 'Line Through', 'kitestudio-core' ),
				),
				'selectors' => array(
					'{{WRAPPER}} nav.navigation > ul > li.hover > a, {{WRAPPER}} nav.navigation > ul > li:hover > a' => 'text-decoration:{{VALUE}};',
				),
			)
		);

		$this->add_control(
			'menu_item_decoration_color_hover',
			array(
				'label'     => esc_html__( 'Decoration Style Color', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} nav.navigation > ul > li.hover > a, {{WRAPPER}} nav.navigation > ul > li:hover > a' => 'text-decoration-color: {{VALUE}};',
				),
				'condition' => array(
					'menu_item_decoration_hover!' => '',
				),
			)
		);

		$this->add_control(
			'menu_item_decoration_style_hover',
			array(
				'label'     => __( 'Decoration Style', 'kitestudio-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'solid'  => __( 'Solid', 'kitestudio-core' ),
					'double' => __( 'Double', 'kitestudio-core' ),
					'dotted' => __( 'Dotted', 'kitestudio-core' ),
					'dashed' => __( 'Dashed', 'kitestudio-core' ),
					'wavy'   => __( 'Wavy', 'kitestudio-core' ),
				),
				'selectors' => array(
					'{{WRAPPER}} nav.navigation > ul > li.hover > a, {{WRAPPER}} nav.navigation > ul > li:hover > a' => 'text-decoration-style:{{VALUE}};',
				),
				'condition' => array(
					'menu_item_decoration_hover!' => '',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'menu_item_transition',
			array(
				'label'      => __( 'Transition (ms)', 'kitestudio-core' ),
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
					'{{WRAPPER}} nav.navigation > ul > li' => 'transition: all {{SIZE}}ms ease;',
				),
			)
		);

		$this->add_responsive_control(
			'menu_item_margin',
			array(
				'label'      => esc_html__( 'Menu Item Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} nav.navigation > ul > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'menu_item_padding',
			array(
				'label'      => esc_html__( 'Menu Item Padding', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} nav.navigation > ul > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'icon_menu_item_padding',
			array(
				'label'      => esc_html__( 'Icon Menu Item Padding', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} nav.navigation > ul > li > a > span.icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'responsive_style_section',
			array(
				'label' => esc_html__( 'Responsive', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'toggle_size',
			array(
				'label'      => __( 'Toggle Size', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .allcats.cat-nav-button span' => 'font-size: {{SIZE}}{{UNIT}} !important;',
				),
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
					'center' => 'margin-left:auto !important; margin-right: auto !important;',
					'right'  => 'float:right',
				),
				'default'              => 'left',
				'selectors'            => array(
					'{{WRAPPER}} .allcats.cat-nav-button' => '{{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'toggle_background',
				'label'    => __( 'Toggle Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .allcats.cat-nav-button',
			)
		);

		$this->add_control(
			'toggle_color',
			array(
				'label'     => esc_html__( 'Toggle Button Color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .allcats.cat-nav-button span' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'toggle_padding',
			array(
				'label'      => esc_html__( 'Toggle Padding', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .allcats.cat-nav-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'toggle_margin',
			array(
				'label'      => esc_html__( 'Toggle Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .allcats.cat-nav-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'toggle_border',
				'selector'  => '{{WRAPPER}} .allcats.cat-nav-button',
				'separator' => 'none',
			)
		);

		$this->add_responsive_control(
			'toggle_border_radius',
			array(
				'label'      => esc_html__( 'Toggle Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .allcats.cat-nav-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
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

		if ( ! isset( $settings['menu_slug'] ) ) {
			return esc_html_e( 'There are no menus in your site.', 'kitestudio-core' );
		}

		$menu_args = array(
			'container'   => '',
			'menu_class'  => 'clearfix',
			'before'      => '',
			'walker'      => new Kite_Nav_Walker(),
			'fallback_cb' => false,
			'after'       => '',
		);
		if ( is_nav_menu( $settings['menu_slug'] ) ) {
			$menu_args['menu'] = $settings['menu_slug'];
		} else {
			$menu_args['theme_location'] = 'category-nav';
		}

		$cat_button_classes = [];
		if ( ! kite_opt( 'cat-menu-state-light', false ) ) {
			$cat_button_classes[] = 'dark'; 
		}

		if ( $settings['always_open'] == 'yes' && $settings['categories_state'] == 'open' ) {
			$cat_button_classes[] = 'always-open';
		}
		?>
		<div class="categories-element category-menu-container hidden-phone hidden-tablet">
			<div class="allcats <?php echo esc_attr( implode( ' ', $cat_button_classes ) );?>">
			<?php
			$categories_label = !empty( $settings['categories_label'] ) ? $settings['categories_label'] : kite_opt( 'cat-menu-title', __( 'All Categories', 'kitestudio-core' ) );
			if ( $settings['cat_icon']['library'] == 'svg' ) {
				echo '<span class="icon"><img src="' . esc_url( $settings['cat_icon']['value']['url'] ) . '"></span>' . esc_html( $categories_label );
			} else {
				echo '<span class="' . esc_attr( $settings['cat_icon']['value'] ) . '"></span>' . esc_html( $categories_label );
			}
			?>
			</div>
			<nav class="navigation catmenu
			<?php
			if ( $settings['categories_state'] != 'open' ) {
				echo 'close';}
			?>
		<?php
		if ( ! kite_opt( 'cat-menu-state-light', false ) ) {
			echo ' dark'; }
		?>
">
				<?php
				wp_nav_menu( $menu_args );
				?>
			</nav>
		</div>
		<div class="allcats cat-nav-button kt-categories-element hidden-desktop">
			<?php
			if ( $settings['responsive_cat_icon']['library'] == 'svg' ) {
				echo '<span class="icon"><img src="' . esc_url( $settings['responsive_cat_icon']['value']['url'] ) . '"></span>';
			} else {
				echo '<span class="' . esc_attr( $settings['responsive_cat_icon']['value'] ) . '"></span>';
			}
			?>
		</div>
		<?php
		$sidebar_classes = array(
			'togglesidebar',
			'toggle-sidebar-category-menu',
			'sidebar-menu',
			'right',
			'hidden-desktop',
		);

		if ( empty( $settings['offcanvas_style'] ) ) {
			$sidebar_classes[] = 'light';
		}

		/**
		 * Sidebar Classess Hook
		 *
		 * @since 1.3.3
		 */
		$sidebar_classes = apply_filters( 'kite_category_menu_sidebar_classes', $sidebar_classes );

		?>
		<div class="<?php echo esc_attr( implode( ' ', $sidebar_classes ) ); ?>">
			<div class="mobile-menu-close-button">
				<span><?php esc_html_e( 'All Categories', 'kitestudio-core' ); ?></span>
				<span class="mobile-menu-icon"></span>
			</div>
			<nav class="mobile-navigation">
				<?php
					$menu_args['menu_class'] = 'clearfix simple-menu ';
					wp_nav_menu( $menu_args );
				?>

			</nav>
		</div>
		<?php
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
	}
}
