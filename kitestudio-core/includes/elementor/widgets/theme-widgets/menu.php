<?php
namespace KiteStudioCore\Elementor\Widgets\ThemeElements;

/**
 * Elementor Menu Widget
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

class Menu extends Widget_Base {

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
		return 'kite-theme-menu';
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
		return esc_html__( 'Header - Navigation', 'kitestudio-core' );
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

			$this->add_responsive_control(
				'menu_align',
				array(
					'label'                => esc_html__( 'Menu Alignment', 'kitestudio-core' ),
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
						'left'   => 'justify-content:' . ( is_rtl() ? 'flex-end; text-align: left;' : 'flex-start; text-align: left;'),
						'center' => 'justify-content: center; text-align: center;',
						'right'  => 'justify-content:' .  ( is_rtl() ? 'flex-start; text-align: right;' : 'flex-end; text-align: right;' ) ,
					),
					'default'              => 'left',
					'prefix_class'         => 'textbox-align-',
					'selectors'            => array(
						'{{WRAPPER}} .kt-menu.navigation, {{WRAPPER}} .elementor-widget-container' => '{{VALUE}}',
					),
				)
			);

			$this->add_control(
				'vertical_menu',
				array(
					'label'        => esc_html__( 'Vertical Menu', 'kitestudio-core' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'ON', 'kitestudio-core' ),
					'label_off'    => esc_html__( 'OFF', 'kitestudio-core' ),
					'return_value' => 'vertical-menu-enabled',
					'default'      => '',
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

		$this->end_controls_section();

		$this->start_controls_section(
			'responsive_section',
			array(
				'label'     => esc_html__( 'Responsive', 'kitestudio-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'vertical_menu!' => 'vertical-menu-enabled',
				),
			)
		);

		$this->add_control(
			'responsive_menu_in_desktop',
			array(
				'label'        => esc_html__( 'Toggle button in desktop', 'kitestudio-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'ON', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'OFF', 'kitestudio-core' ),
				'return_value' => 'yes',
				'default'      => '',
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
			'responsive_menu_icon',
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
				'default'              => 'right',
				'prefix_class'         => 'kt-open-offcanvas-from-',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'menu_style_section',
			array(
				'label' => esc_html__( 'Menu Style', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
				'selector' => '{{WRAPPER}} nav.navigation > ul',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'wrapper_border',
				'selector'  => '{{WRAPPER}} nav.navigation > ul',
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
					'{{WRAPPER}} nav.navigation > ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Wrapper Box Shadow', 'kitestudio-core' ),
				'name'     => 'wrapper_box_shadow_normal',
				'selector' => '{{WRAPPER}} nav.navigation > ul',
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
				'selector' => '{{WRAPPER}} nav.navigation > ul:hover ',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Wrapper Box Shadow', 'kitestudio-core' ),
				'name'     => 'wrapper_box_shadow_hover',
				'selector' => '{{WRAPPER}} nav.navigation > ul:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wrapper_bg_transition',
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
					'{{WRAPPER}} nav.navigation > ul' => 'transition: all {{SIZE}}ms ease;',
				),
			)
		);

		$this->add_responsive_control(
			'menu_padding',
			array(
				'label'      => esc_html__( 'Menu Padding', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} nav.navigation > ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
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
					'{{WRAPPER}} nav.navigation > ul > li > a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'menu_item_background_normal',
				'label'    => __( 'Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} nav.navigation > ul > li',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'menu_item_border_normal',
				'selector'  => '{{WRAPPER}} nav.navigation > ul > li',
				'separator' => 'none',
			)
		);

		$this->add_responsive_control(
			'menu_item_border_radius_normal',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} nav.navigation > ul > li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'menu_item_box_shadow_normal',
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
					'{{WRAPPER}} nav.navigation > ul > li > a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'menu_item_background_hover',
				'label'    => __( 'Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} nav.navigation > ul > li.hover, {{WRAPPER}} nav.navigation > ul > li:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'menu_item_border_hover',
				'selector'  => '{{WRAPPER}} nav.navigation > ul > li.hover, {{WRAPPER}} nav.navigation > ul > li:hover',
				'separator' => 'none',
			)
		);

		$this->add_responsive_control(
			'menu_item_border_radius_hover',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} nav.navigation > ul > li.hover, {{WRAPPER}} nav.navigation > ul > li:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'menu_item_box_shadow_hover',
				'selector' => '{{WRAPPER}} nav.navigation > ul > li.hover, {{WRAPPER}} nav.navigation > ul > li:hover',
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

		$this->start_controls_tab(
			'menu_item_selected',
			array(
				'label' => __( 'Selected', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'menu_item_color_selected',
			array(
				'label'     => esc_html__( 'Text Color', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} nav.navigation > ul > li.current-menu-item > a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'menu_item_background_selected',
				'label'    => __( 'Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} nav.navigation > ul > li.current-menu-item, {{WRAPPER}} nav.navigation > ul > li.current-menu-item',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'menu_item_border_selected',
				'selector'  => '{{WRAPPER}} nav.navigation > ul > li.current-menu-item, {{WRAPPER}} nav.navigation > ul > li.current-menu-item',
				'separator' => 'none',
			)
		);

		$this->add_responsive_control(
			'menu_item_border_radius_selected',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} nav.navigation > ul > li.current-menu-item, {{WRAPPER}} nav.navigation > ul > li.current-menu-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'menu_item_box_shadow_selected',
				'selector' => '{{WRAPPER}} nav.navigation > ul > li.current-menu-item, {{WRAPPER}} nav.navigation > ul > li.current-menu-item',
			)
		);

		$this->add_control(
			'menu_item_decoration_selected',
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
					'{{WRAPPER}} nav.navigation > ul > li.current-menu-item > a, {{WRAPPER}} nav.navigation > ul > li.current-menu-item > a' => 'text-decoration:{{VALUE}};',
				),
			)
		);

		$this->add_control(
			'menu_item_decoration_color_selected',
			array(
				'label'     => esc_html__( 'Decoration Style Color', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} nav.navigation > ul > li.current-menu-item > a, {{WRAPPER}} nav.navigation > ul > li.current-menu-item > a' => 'text-decoration-color: {{VALUE}};',
				),
				'condition' => array(
					'menu_item_decoration_selected!' => '',
				),
			)
		);

		$this->add_control(
			'menu_item_decoration_style_selected',
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
					'{{WRAPPER}} nav.navigation > ul > li.current-menu-item > a, {{WRAPPER}} nav.navigation > ul > li.current-menu-item > a' => 'text-decoration-style:{{VALUE}};',
				),
				'condition' => array(
					'menu_item_decoration_selected!' => '',
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
					'{{WRAPPER}} nav.navigation > ul > li' => 'transition: all {{SIZE}}ms ease;',
				),
			)
		);

		$this->add_responsive_control(
			'menu_item_margin',
			array(
				'label'      => esc_html__( 'Margin', 'kitestudio-core' ),
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
				'label'      => esc_html__( 'Padding', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} nav.navigation > ul > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_menu_item_padding',
			array(
				'label'      => esc_html__( 'Icon Padding', 'kitestudio-core' ),
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
				'label'     => esc_html__( 'Responsive', 'kitestudio-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'vertical_menu!' => 'vertical-menu-enabled',
				),
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
					'{{WRAPPER}} .mobilenavbutton.kt-menu-element span' => 'font-size: {{SIZE}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'toggle_background',
				'label'    => __( 'Toggle Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .mobilenavbutton.kt-menu-element',
			)
		);

		$this->add_control(
			'toggle_color',
			array(
				'label'     => esc_html__( 'Toggle Button Color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mobilenavbutton.kt-menu-element span' => 'color: {{VALUE}} !important;',
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
					'{{WRAPPER}} .mobilenavbutton.kt-menu-element' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .mobilenavbutton.kt-menu-element' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'toggle_border',
				'selector'  => '{{WRAPPER}} .mobilenavbutton.kt-menu-element',
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
					'{{WRAPPER}} .mobilenavbutton.kt-menu-element' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			$menu_args['theme_location'] = 'primary-nav';
		}

		$settings['vertical_menu'] = isset( $settings['vertical_menu'] ) && ! empty( $settings['vertical_menu'] ) ? $settings['vertical_menu'] : '';
		$vertical_menu             = $settings['vertical_menu'] == 'vertical-menu-enabled' ? 'kt-vertical-menu' : 'hidden-phone hidden-tablet';
		if ( $settings['vertical_menu'] == 'vertical-menu-enabled' || $settings['responsive_menu_in_desktop'] != 'yes' ) {
			echo '<nav class="kt-menu navigation ' . esc_attr( $vertical_menu ) . '">';
			echo wp_nav_menu( $menu_args );
			echo '</nav>';
			$responsive_condition_class = 'hidden-desktop';
		} else {
			$responsive_condition_class = '';
		}
		if ( $settings['vertical_menu'] != 'vertical-menu-enabled' ) {
			$sidebar_classes = array(
				'togglesidebar',
				'toggle-sidebar-mobile-menu',
				'sidebar-menu',
				$responsive_condition_class,
			);

			if ( empty( $settings['offcanvas_style'] ) ) {
				$sidebar_classes[] = 'light';
			} else {
				$sidebar_classes[] = 'dark';
			}

			/**
			 * Sidebar Classess Hook
			 *
			 * @since 1.3.3
			 */
			$sidebar_classes = apply_filters( 'kite_mobile_menu_sidebar_classes', $sidebar_classes );
			?>
			<div class="kt-menu-element mobile-nav-button mobilenavbutton <?php echo esc_attr( $responsive_condition_class ); ?>">
				<a href="#/"><span class="<?php echo esc_attr( $settings['responsive_menu_icon']['value'] ); ?>"></span></a>
			</div>
			<div class="<?php echo esc_attr( implode( ' ', $sidebar_classes ) ); ?>">
				<div class="mobile-menu-close-button">
					<span><?php esc_html_e( 'Navigation', 'kitestudio-core' ); ?></span>
					<span class="mobile-menu-icon" tabindex="0"></span>
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
	}
}
