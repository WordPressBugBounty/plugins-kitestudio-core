<?php
namespace KiteStudioCore\Elementor\Widgets\ThemeElements;

/**
 * Elementor Search Widget
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

class Search extends Widget_Base {

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
		return 'kite-theme-search';
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
		return esc_html__( 'Header - Search', 'kitestudio-core' );
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
		return 'eicon-site-search kite-element-icon';
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
			'kite-search',
		);
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
				'label' => esc_html__( 'Search', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'search_post_type',
			array(
				'label'   => __( 'Search Post Type', 'kitestudio-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'product' => __( 'Product', 'kitestudio-core' ),
					'post'    => __( 'Post', 'kitestudio-core' ),
				),
				'default' => 'product',
			)
		);

		$this->add_control(
			'search_type',
			array(
				'label'   => __( 'Search Type', 'kitestudio-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'icon' => __( 'Icon', 'kitestudio-core' ),
					'form' => __( 'Inline Form', 'kitestudio-core' ),
				),
				'default' => 'icon',
			)
		);

		$this->add_control(
			'search_style',
			array(
				'label'   => __( 'Form Chroma', 'kitestudio-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'light' => __( 'Light', 'kitestudio-core' ),
					'dark'  => __( 'Dark', 'kitestudio-core' ),
				),
				'default' => 'light',
			)
		);

		$this->add_control(
			'results_columns',
			array(
				'label'   => __( 'Results Columns Number', 'kitestudio-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
				),
				'default' => '2',
			)
		);

		$this->add_control(
			'search_place_holder',
			array(
				'label'     => esc_html__( 'Search Placeholder', 'kitestudio-core' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'search_type' => 'form',
				),
			)
		);

		$this->add_control(
			'show_categories',
			array(
				'label'        => esc_html__( 'Show Categories', 'kitestudio-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'ON', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'OFF', 'kitestudio-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'kitestudio-core' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'icon-magnifier',
					'library' => 'kite-icon',
				),
			)
		);

		$this->add_control(
			'icon_subtitle',
			array(
				'label'     => esc_html__( 'Icon Subtitle', 'kitestudio-core' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'search_type' => 'icon',
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'     => esc_html__( 'Icon Title', 'kitestudio-core' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'search_type' => 'icon',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'search_form_style_section',
			array(
				'label'     => esc_html__( 'Search Form', 'kitestudio-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'search_type' => 'form',
				),
			)
		);

		$this->add_control(
			'search_form_style',
			array(
				'label'        => __( 'Search Form Style', 'kitestudio-core' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'type-1' => __( 'Search input first', 'kitestudio-core' ),
					'type-2' => __( 'Categories first', 'kitestudio-core' ),
				),
				'prefix_class' => 'search-',
				'default'      => 'type-1',
			)
		);

		$this->add_responsive_control(
			'search_form_align',
			array(
				'label'                => esc_html__( 'Form Alignment', 'kitestudio-core' ),
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
					'left'   => 'margin-left:0;',
					'center' => 'margin: 0 auto;',
					'right'  => 'margin-left:auto;margin-right: 0;',
				),
				'default'              => '',
				'selectors'            => array(
					'{{WRAPPER}} .search-inputwrapper' => '{{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'search_form_width',
			array(
				'label'      => __( 'Form Width', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 2000,
						'step' => 100,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .search-inputwrapper, {{WRAPPER}} .results-info' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'search_form_height',
			array(
				'label'      => __( 'Form Height', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .searchelements, {{WRAPPER}} .searchinput, {{WRAPPER}} .nice-select.searchcats, {{WRAPPER}} .searchicon, {{WRAPPER}} .mobilesearchcats' => 'height: {{SIZE}}{{UNIT}} !important;',
				),
			)
		);

		$this->start_controls_tabs( 'search_form_background' );

		$this->start_controls_tab(
			'search_form_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'form_box_shadow_normal',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'form_border_normal',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements',
			)
		);

		$this->add_responsive_control(
			'form_border_radius_normal',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .search-inputwrapper .searchelements' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'form_background_normal',
				'label'    => __( 'Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'search_form_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'form_box_shadow_hover',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'form_border_hover',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements:hover',
			)
		);

		$this->add_responsive_control(
			'form_border_radius_hover',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .search-inputwrapper .searchelements:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'form_background_hover',
				'label'    => __( 'Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'search_form_transition',
			array(
				'label'       => __( 'Transition (ms)', 'kitestudio-core' ),
				'type'        => Controls_Manager::SLIDER,
				'separator'   => 'before',
				'description' => __( 'Transition for all elements in widget', 'kitestudio-core' ),
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min'  => 0,
						'max'  => 5000,
						'step' => 100,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} .search-inputwrapper .searchelements, {{WRAPPER}} .search-inputwrapper .searchelements input, {{WRAPPER}} .search-inputwrapper .searchelements div.nice-select, {{WRAPPER}} .search-inputwrapper .searchicon' => 'transition: all {{SIZE}}ms ease;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'search_input_style_section',
			array(
				'label'     => esc_html__( 'Search Input', 'kitestudio-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'search_type' => 'form',
				),
			)
		);

		$this->add_responsive_control(
			'search_input_margin',
			array(
				'label'      => esc_html__( 'Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .search-inputwrapper input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// $this->add_responsive_control(
		// 	'search_input_padding',
		// 	array(
		// 		'label'      => esc_html__( 'Padding', 'kitestudio-core' ),
		// 		'type'       => Controls_Manager::DIMENSIONS,
		// 		'size_units' => array( 'px', '%', 'em' ),
		// 		'selectors'  => array(
		// 			'{{WRAPPER}} .searchinput' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		),
		// 	)
		// );

		$this->start_controls_tabs( 'search_input_tabs' );

		$this->start_controls_tab(
			'search_input_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'input_box_shadow_normal',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements input',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'input_border_normal',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements input',
			)
		);

		$this->add_responsive_control(
			'input_border_radius_normal',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .search-inputwrapper .searchelements input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'input_background_normal',
				'label'    => __( 'Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements input',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'search_input_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'input_box_shadow_hover',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements input:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'input_border_hover',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements input:hover',
			)
		);

		$this->add_responsive_control(
			'input_border_radius_hover',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .search-inputwrapper .searchelements input:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'input_background_hover',
				'label'    => __( 'Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements input:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'search_categories_style_section',
			array(
				'label'     => esc_html__( 'Search Categories', 'kitestudio-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'search_type' => 'form',
				),
			)
		);

		$this->add_responsive_control(
			'search_cagtegories_margin',
			array(
				'label'      => esc_html__( 'Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .search-inputwrapper div.nice-select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// $this->add_responsive_control(
		// 	'search_categories_padding',
		// 	array(
		// 		'label'      => esc_html__( 'Padding', 'kitestudio-core' ),
		// 		'type'       => Controls_Manager::DIMENSIONS,
		// 		'size_units' => array( 'px', '%', 'em' ),
		// 		'selectors'  => array(
		// 			'{{WRAPPER}} .nice-select.searchcats, {{WRAPPER}} .nice-select.mobilesearchcats' => 'width: auto !important; height: auto !important; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
		// 		),
		// 	)
		// );

		$this->start_controls_tabs( 'search_categories_tabs' );

		$this->start_controls_tab(
			'search_categories_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'categories_box_shadow_normal',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements div.nice-select',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'categories_border_normal',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements div.nice-select',
			)
		);

		$this->add_responsive_control(
			'categories_border_radius_normal',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .search-inputwrapper .searchelements div.nice-select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'categories_background_normal',
				'label'    => __( 'Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements div.nice-select',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'search_categories_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'categories_box_shadow_hover',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements div.nice-select:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'categories_border_hover',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements div.nice-select:hover',
			)
		);

		$this->add_responsive_control(
			'categories_border_radius_hover',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .search-inputwrapper .searchelements div.nice-select:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'categories_background_hover',
				'label'    => __( 'Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchelements div.nice-select:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'search_icon_style_section',
			array(
				'label'     => esc_html__( 'Search Icon', 'kitestudio-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'search_type' => 'form',
				),
			)
		);

		$this->add_responsive_control(
			'search_icon_margin',
			array(
				'label'      => esc_html__( 'Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .searchicon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// $this->add_responsive_control(
		// 	'search_icon_padding',
		// 	array(
		// 		'label'      => esc_html__( 'Padding', 'kitestudio-core' ),
		// 		'type'       => Controls_Manager::DIMENSIONS,
		// 		'size_units' => array( 'px', '%', 'em' ),
		// 		'selectors'  => array(
		// 			'{{WRAPPER}} .searchicon' => 'width: auto !important; height: auto !important; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		),
		// 	)
		// );

		$this->start_controls_tabs( 'search_icon_tabs' );

		$this->start_controls_tab(
			'search_icon_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_responsive_control(
			'search_icon_size_normal',
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
					'{{WRAPPER}} .searchicon span'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .searchicon span img' => 'width: {{SIZE}}{{UNIT}};height: auto;max-width: unset;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'search_icon_box_shadow_normal',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchicon',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'search_icon_border_normal',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchicon',
			)
		);

		$this->add_responsive_control(
			'search_icon_border_radius_normal',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .search-inputwrapper .searchicon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'search_icon_background_normal',
				'label'    => __( 'Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchicon',
			)
		);

		$this->add_control(
			'search_icon_color_normal',
			array(
				'label'     => esc_html__( 'Search Icon color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .search-inputwrapper .searchicon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'search_icon_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_responsive_control(
			'search_icon_size_hover',
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
					'{{WRAPPER}} .searchicon:hover span' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .searchicon:hover span img' => 'width: {{SIZE}}{{UNIT}};height: auto;max-width: unset;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'kitestudio-core' ),
				'name'     => 'search_icon_box_shadow_hover',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchicon:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'search_icon_border_hover',
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchicon:hover',
			)
		);

		$this->add_responsive_control(
			'search_icon_border_radius_hover',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .search-inputwrapper .searchicon:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'search_icon_background_hover',
				'label'    => __( 'Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .search-inputwrapper .searchicon:hover',
			)
		);

		$this->add_control(
			'search_icon_color_hover',
			array(
				'label'     => esc_html__( 'Search Icon color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .search-inputwrapper .searchicon:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'icon_style_section',
			array(
				'label'     => esc_html__( 'Icon Style', 'kitestudio-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'search_type' => 'icon',
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

		$this->start_controls_tabs( 'icon_background' );

		$this->start_controls_tab(
			'icon_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'wrapper_background_normal',
				'label'    => __( 'Search Icon Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .kt-header-button.kt-search',
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

		$this->add_responsive_control(
			'icon_size_normal',
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
					'{{WRAPPER}} .elementor-search-button.search-button' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-search-button.search-button img' => 'width: {{SIZE}}{{UNIT}};height: auto;max-width: unset;',
				),
			)
		);

		$this->add_control(
			'icon_color_normal',
			array(
				'label'     => esc_html__( 'Icon color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-button.search-button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_subtitle_color_normal',
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
			'subtitle_margin_normal',
			array(
				'label'      => esc_html__( 'Subtitle Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'icon_border_normal',
				'selector' => '{{WRAPPER}} .kt-header-button.kt-search',
			)
		);

		$this->add_responsive_control(
			'icon_border_radius_normal',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button.kt-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'wrapper_background_hover',
				'label'    => __( 'Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .kt-header-button.kt-search:hover',
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
					'{{WRAPPER}} .elementor-search-button.search-button:hover' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-search-button.search-button:hover img' => 'width: {{SIZE}}{{UNIT}};height: auto;max-width: unset;',
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
					'{{WRAPPER}} .kt-search:hover .elementor-search-button.search-button' => 'color: {{VALUE}};',
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

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'icon_border_hover',
				'selector' => '{{WRAPPER}} .kt-header-button.kt-search:hover',
			)
		);

		$this->add_responsive_control(
			'icon_border_radius_hover',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button.kt-search:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'search_icon_transition',
			array(
				'label'      => __( 'Form Transition (ms)', 'kitestudio-core' ),
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
					'{{WRAPPER}} .elementor-search-button.search-button, {{WRAPPER}} .kt-header-button.kt-search, {{WRAPPER}} .elementor-search-button.search-button img' => 'transition: all {{SIZE}}ms ease;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'meta_texts_section',
			array(
				'label'     => esc_html__( 'Meta Texts Style', 'kitestudio-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'search_type' => 'icon',
				),
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

		$search_post_type = $settings['search_post_type'];

		if ( $settings['show_categories'] == 'yes' ) {
			$cat_args = array(
				'orderby'    => 'term_id',
				'order'      => 'ASC',
				'hide_empty' => false,
			);
			if ( $search_post_type == 'product' && kite_woocommerce_installed() ) {
				$terms = get_terms( 'product_cat', $cat_args );
			} else {
				$terms = get_terms( 'category', $cat_args );
			}
		} else {
			$terms = array();
		}

		if ( $settings['search_type'] == 'form' ) {

			if ( function_exists( 'kite_generate_search_form' ) ) {
				$args = array(
					'wrap_classes'        => 'first-search-input-wrapper search-inputwrapper search-container search-element columns-' . $settings['results_columns'],
					'form_classes'        => 'firstStateSearchForm',
					'style'               => '',
					'terms'               => $terms,
					'search_place_holder' => esc_html( $settings['search_place_holder'] ),
					'search_post_type'    => $settings['search_post_type'],
				);
				if ( $settings['search_style'] == 'light' ) {
					$args['style'] = 'light';
				} else {
					$args['wrap_classes'] = $args['wrap_classes'] . ' dark';
				}
				if ( $settings['icon']['library'] != 'svg' ) {
					$args['search_icon'] = $settings['icon']['value'];
				} else {
					$args['svg_icon'] = true;
					$args['svg_url']  = $settings['icon']['value']['url'];
				}
				echo kite_generate_search_form( $args );
			}
		} else {
			?>
			<div class="kt-header-button kt-search">
				<div class="kt-icon-container">
					<a href="#" class="search-icon-link">
					<?php
					if ( $settings['icon']['library'] == 'svg' ) {
						echo '<span class="element-icon elementor-search-button search-button"><img src="' . esc_url( $settings['icon']['value']['url'] ) . '" alt="svgicon"></span>';
					} else {
						echo '<span class="element-icon elementor-search-button search-button ' . esc_attr( $settings['icon']['value'] ) . '"></span>';
					}
					?>
					
					<?php if ( ! empty( $settings['icon_subtitle'] ) ) { ?>
						<span class="kt-subtitle"><?php echo esc_html( $settings['icon_subtitle'] ); ?></span>
					<?php } ?>
					</a>
				</div>
				<div class="kt-meta-texts">
					<?php if ( ! empty( $settings['title'] ) ) { ?>
						<span class="kt-title"><?php echo esc_html( $settings['title'] ); ?></span>
					<?php } ?>
				</div>
			</div>
			<div class="responsive-whole-search-container">
					<?php
					if ( function_exists( 'kite_generate_search_form' ) ) {
						$args = array(
							'wrap_classes'        => 'first-search-input-wrapper search-inputwrapper search-container search-element columns-' . $settings['results_columns'],
							'form_classes'        => 'firstStateSearchForm',
							'style'               => '',
							'terms'               => $terms,
							'search_place_holder' => esc_html( $settings['search_place_holder'] ),
							'search_post_type'    => $settings['search_post_type'],
						);
						if ( $settings['search_style'] == 'light' ) {
							$args['style'] = 'light';
						} else {
							$args['wrap_classes'] = $args['wrap_classes'] . ' dark';
						}

						echo kite_generate_search_form( $args );
					}
					?>
			</div>
			<div class="search-element-popup search-form-cls">
						<?php
						get_search_form(
							array(
								'kite-search-form' => true,
							)
						);
						?>
			</div>
					<?php
		}
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
