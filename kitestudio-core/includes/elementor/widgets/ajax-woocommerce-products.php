<?php
/**
 * Elementor Ajax Woocommerce Products Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Ajax_Woocommerce_Products_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Ajax Woocommerce Products widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-ajax-woocommerce-products';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Ajax Woocommerce Products widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Ajax Woocommerce Products', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Ajax Woocommerce Products widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-categories kite-element-icon';
	}

	/**
	 * Get widget keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords
	 */
	public function get_keywords() {
		return array( 'woocommerce', 'shop', 'products' );
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Ajax Woocommerce Products widget belongs to.
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
			'kite-product-card',
			'elementor-icons-fa-regular',
			'elementor-icons-fa-solid',
			'elementor-icons-fa-brands',
		);
	}

	/**
	 * load dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'kite-carousel',
			'kite-ajax-woocommerce-tab',
		);
	}

	/**
	 * Register Ajax Woocommerce Products widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$product_cats = array();
		$product_tags = array();
		$cat_args     = array(
			'orderby'    => 'term_id',
			'order'      => 'ASC',
			'hide_empty' => false,
		);

		$terms = get_terms( 'product_cat', $cat_args );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) { // check is gallery plugin is active or not
			foreach ( $terms as $taxonomy ) {
					$product_cats[ $taxonomy->slug ] = $taxonomy->name;
			}
		}
		$tag_terms = get_terms( 'product_tag', $cat_args );
		if ( ! empty( $tag_terms ) && ! is_wp_error( $tag_terms ) ) { // check is gallery plugin is active or not
			foreach ( $tag_terms as $taxonomy ) {
					$product_tags[ $taxonomy->slug ] = $taxonomy->name;
			}
		}
		$accent_color = kite_opt( 'style-accent-color', '#5956e9' );
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Ajax Woocommerce Products Tabs', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'heading_title',
			array(
				'label'   => esc_html__( 'Title', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'heading_subtitle',
			array(
				'label'   => esc_html__( 'Subtitle', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::WYSIWYG,
			)
		);
		$this->add_responsive_control(
			'headings_align',
			array(
				'label'        => esc_html__( 'Headings Alignment', 'kitestudio-core' ),
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
				'selectors'    => array(
					'{{WRAPPER}} .vc_tta-tabs-container > h2, {{WRAPPER}} .vc_tta-tabs-container > span.subtitle' => 'text-align:{{VALUE}} !important',
				),
			)
		);
		$this->add_control(
			'position',
			array(
				'label'   => esc_html__( 'Tab Position', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'top'    => esc_html__( 'Top', 'kitestudio-core' ),
					'bottom' => esc_html__( 'Bottom', 'kitestudio-core' ),
					'left' => esc_html__( 'Left', 'kitestudio-core' ),
					'right' => esc_html__( 'Right', 'kitestudio-core' ),
				),
				'default' => 'top',
			)
		);
		$this->add_responsive_control(
			'alignment',
			array(
				'label'        => esc_html__( 'Alignment', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'options'      => array(
					'flex-start'    => array(
						'title' => __( 'Start', 'kitestudio-core' ),
						'icon'  => 'eicon-align-start-v',
					),
					'center'  => array(
						'title' => __( 'Center', 'kitestudio-core' ),
						'icon'  => 'eicon-align-center-v',
					),
					'flex-end'   => array(
						'title' => __( 'End', 'kitestudio-core' ),
						'icon'  => 'eicon-align-end-v',
					),
				),
				'default' => 'center',
				'selectors_dictionary' => array(
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
					'flex-start' => 'flex-start',
					'flex-end'  => 'flex-end',
				),
				'condition' => array(
					'position' => [ 'top', 'bottom'],
				),
				'selectors'    => array(
					'{{WRAPPER}} .vc_tta-tabs-container' => 'align-items: {{VALUE}}; justify-content: {{VALUE}};',
					'{{WRAPPER}} .vc_tta-tabs-position-left, {{WRAPPER}} .vc_tta-tabs-position-right' => 'align-items: {{VALUE}}; justify-content: {{VALUE}};'
				),
			)
		);

		$this->add_control(
			'vertical_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'center' => esc_html__( 'Center', 'kitestudio-core' ),
					'top'   => esc_html__( 'Top', 'kitestudio-core' ),
					'bottom'  => esc_html__( 'Bottom', 'kitestudio-core' ),
				),
				'default' => 'center',
				'condition' => array(
					'position' => [ 'left', 'right'],
				),
				'prefix_class' => 'kt-vertical-alignment-',
			)
		);
		$this->add_control(
			'tab_width',
			array(
				'label'   	 => esc_html__( 'Tab Width', 'kitestudio-core' ),
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
				'default'    => array(
					'unit' => 'px',
					'size' => 200,
				),
				'selectors'  => array(
					'{{WRAPPER}} .vc_tta-container.ajax_products_tab > .vc_tta-tabs.vc_tta-tabs-position-left .vc_tta-tabs-container,{{WRAPPER}} .vc_tta-container.ajax_products_tab > .vc_tta-tabs.vc_tta-tabs-position-right .vc_tta-tabs-container' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .vc_tta-container.ajax_products_tab > .vc_tta-tabs.vc_tta-tabs-position-left .vc_tta-panels-container,{{WRAPPER}} .vc_tta-container.ajax_products_tab > .vc_tta-tabs.vc_tta-tabs-position-right .vc_tta-panels-container' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
				),
				'condition' => array(
					'position' => [ 'left', 'right'],
				),
			)
		);
		$this->add_responsive_control(
			'tab_text_align',
			array(
				'label'        => esc_html__( 'Tab Text Alignment', 'kitestudio-core' ),
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
				'selectors'    => array(
					'{{WRAPPER}} .vc_tta-tabs ul.vc_tta-tabs-list li' => 'text-align:{{VALUE}} !important',
				),
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
			'shape',
			array(
				'label'   => esc_html__( 'Icon Alignment', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'left'  => esc_html__( 'Before of title', 'kitestudio-core' ),
					'right' => esc_html__( 'After of title', 'kitestudio-core' ),
					'top'   => esc_html__( 'Top of title', 'kitestudio-core' ),
				),
				'default' => 'left',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'repeater_section',
			array(
				'label' => esc_html__( 'Products Tabs', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'tab_title',
			array(
				'label'   => esc_html__( 'Title', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Tab Title',
			)
		);
		$repeater->add_control(
			'tab_icon_check',
			array(
				'label'        => esc_html__( 'Tab Icon', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'disable',
			)
		);
		$repeater->add_control(
			'tab_new_icon',
			array(
				'label'     => esc_html__( 'Icon', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'condition' => array(
					'tab_icon_check' => 'enable',
				),
			)
		);
		$repeater->add_control(
			'product_type',
			array(
				'label'   => esc_html__( 'Product Type', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'top_rated'    => esc_html__( 'Top Rated Products', 'kitestudio-core' ),
					'featured'     => esc_html__( 'Featured Products', 'kitestudio-core' ),
					'sale'         => esc_html__( 'onSale Products', 'kitestudio-core' ),
					'best_selling' => esc_html__( 'Best Selling Products', 'kitestudio-core' ),
					'recent'       => esc_html__( 'Recent Products', 'kitestudio-core' ),
					'deal'         => esc_html__( 'Deal Products', 'kitestudio-core' ),
				),
				'default' => 'top_rated',
			)
		);
		$repeater->add_control(
			'per_page',
			array(
				'label'       => esc_html__( 'Number of Products', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '12',
				'description' => esc_html__( 'Number of Products per page', 'kitestudio-core' ),
			)
		);
		$repeater->add_control(
			'orderby',
			array(
				'label'     => esc_html__( 'Order by', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'date'             => esc_html__( 'Date', 'kitestudio-core' ),
					'ID'               => esc_html__( 'ID', 'kitestudio-core' ),
					'author'           => esc_html__( 'Author', 'kitestudio-core' ),
					'title'            => esc_html__( 'Title', 'kitestudio-core' ),
					'modified'         => esc_html__( 'Modified', 'kitestudio-core' ),
					'rand'             => esc_html__( 'Random', 'kitestudio-core' ),
					'comment_count'    => esc_html__( 'Comment count', 'kitestudio-core' ),
					'menu_order'       => esc_html__( 'Menu order', 'kitestudio-core' ),
					'menu_order title' => esc_html__( 'Menu order & title', 'kitestudio-core' ),
					'include'          => esc_html__( 'Include', 'kitestudio-core' ),
				),
				'default'   => 'date',
				'condition' => array(
					'product_type!' => 'best_selling',
				),
			)
		);
		$repeater->add_control(
			'order',
			array(
				'label'   => esc_html__( 'Sort order', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'DESC' => esc_html__( 'Descending', 'kitestudio-core' ),
					'ASC'  => esc_html__( 'Ascending', 'kitestudio-core' ),
				),
				'default' => 'DESC',
			)
		);
		$repeater->add_control(
			'product_cats',
			array(
				'label'       => esc_html__( 'product Categories', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'all'    => esc_html__( 'All', 'kitestudio-core' ),
					'custom' => esc_html__( 'Custom', 'kitestudio-core' ),
				),
				'default'     => 'all',
			)
		);
		$repeater->add_control(
			'category',
			array(
				'label'       => esc_html__( 'Categories', 'kitestudio-core' ),
				'label_block' => true,
				'multiple'    => true,
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $product_cats,
				'default'     => '',
				'condition'   => array(
					'product_cats' => 'custom',
				),
			)
		);
		$repeater->add_control(
			'tags',
			array(
				'label'       => esc_html__( 'Product Tags', 'kitestudio-core' ),
				'label_block' => true,
				'multiple'    => true,
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $product_tags,
				'default'     => '',
			)
		);
		$repeater->add_control(
			'carousel',
			array(
				'label'       => esc_html__( 'Carousel/Grid Mode/List View', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'disable' => esc_html__( 'Grid', 'kitestudio-core' ),
					'enable'  => esc_html__( 'Carousel', 'kitestudio-core' ),
					'list'    => esc_html__( 'List View', 'kitestudio-core' ),
				),
				'default'     => 'disable',
			)
		);
		$repeater->add_control(
			'list_style',
			array(
				'label'       => esc_html__( 'List Style', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
				),
				'default'     => 'light',
				'condition'   => array(
					'carousel' => 'list',
				),
			)
		);
		$repeater->add_control(
			'columns',
			array(
				'label'       => esc_html__( 'Columns', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				),
				'default'     => '3',
				'condition'   => array(
					'carousel' => array( 'disable', 'enable' ),
				),
			)
		);
		$repeater->add_control(
			'image_size',
			array(
				'label'       => esc_html__( 'Image Size', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'shop_catalog'   => esc_html__( 'Catalog Images', 'kitestudio-core' ),
					'shop_single'    => esc_html__( 'Single Product Image', 'kitestudio-core' ),
					'shop_thumbnail' => esc_html__( 'Product Thumbnails', 'kitestudio-core' ),
					'full'           => esc_html__( 'Full', 'kitestudio-core' ),
					'custom'         => esc_html__( 'Custom', 'kitestudio-core' ),
				),
				'default'     => 'shop_catalog',
			)
		);
		$repeater->add_control(
			'image_size_width',
			array(
				'label'       => esc_html__( 'Image Size Width', 'kitestudio-core' ),
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'image_size' => 'custom',
				),
			)
		);

		$repeater->add_control(
			'image_size_height',
			array(
				'label'       => esc_html__( 'Image Size Height', 'kitestudio-core' ),
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'image_size' => 'custom',
				),
			)
		);

		$repeater->add_control(
			'image_size_crop',
			array(
				'label'        => esc_html__( 'Crop Image', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'image_size' => 'custom',
				),
			)
		);

		$this->add_responsive_control(
			'list_view_image_width',
			array(
				'label'      => __( 'Image Placeholder Width', 'kitestudio-core' ),
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
				'default'    => array(
					'unit' => 'px',
					'size' => 70,
				),
				'selectors'  => array(
					'{{WRAPPER}} .products div.product.list_view img' => 'width: {{SIZE}}{{UNIT}};height: auto;',
					'{{WRAPPER}} .products.listview div.product .productwrap .productinfo' => 'width: calc(100% - {{SIZE}}{{UNIT}});',
				),
				'condition'  => array(
					'carousel' => 'list',
				),
			)
		);

		$repeater->add_control(
			'list_view_flow',
			array(
				'label'                => esc_html__( 'List View Direction', 'kitestudio-core' ),
				'label_block'          => true,
				'type'                 => \Elementor\Controls_Manager::SELECT,
				'options'              => array(
					'column' => esc_html__( 'Column', 'kitestudio-core' ),
					'row'    => esc_html__( 'Row', 'kitestudio-core' ),
				),
				'default'              => 'column',
				'condition'            => array(
					'carousel' => 'list',
				),
				'selectors_dictionary' => array(
					'column' => 'display: flex; flex-direction: column;',
					'row'    => 'display: flex; flex-wrap: wrap;',
				),
				'selectors'            => array(
					'{{WRAPPER}} .products' => '{{VALUE}}',
				),
			)
		);

		$repeater->add_responsive_control(
			'list_view_item_width',
			array(
				'label'      => __( 'Product Item Width', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
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
				'default'    => array(
					'unit' => '%',
					'size' => 30,
				),
				'selectors'  => array(
					'{{WRAPPER}} .products div.product.list_view' => 'flex-basis: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'carousel'       => 'list',
					'list_view_flow' => 'row',
				),
			)
		);

		$repeater->add_control(
			'hover_image',
			array(
				'label'       => esc_html__( 'Hover Image', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'show' => esc_html__( 'Show', 'kitestudio-core' ),
					'hide' => esc_html__( 'Hide', 'kitestudio-core' ),
				),
				'default'     => 'show',
				'condition'   => array(
					'carousel' => array( 'disable', 'enable' ),
				),
			)
		);
		$repeater->add_control(
			'is_autoplay',
			array(
				'label'     => esc_html__( 'Autoplay', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'on'  => esc_html__( 'On', 'kitestudio-core' ),
					'off' => esc_html__( 'Off', 'kitestudio-core' ),
				),
				'default'   => 'on',
				'condition' => array(
					'carousel' => 'enable',
				),
			)
		);
		$repeater->add_control(
			'responsive_autoplay',
			array(
				'label'     => esc_html__( 'Responsive Autoplay', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'on'  => esc_html__( 'On', 'kitestudio-core' ),
					'off' => esc_html__( 'Off', 'kitestudio-core' ),
				),
				'default'   => 'off',
				'condition' => array(
					'carousel' => 'enable',
				),
			)
		);
		$repeater->add_control(
			'countdown_activation',
			array(
				'label'        => esc_html__( 'Countdown timer', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'ON', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'OFF', 'kitestudio-core' ),
				'return_value' => 'on',
				'default'      => '',
				'condition'    => array(
					'carousel' => array( 'enable', 'disable' ),
				),
			)
		);
		$repeater->add_control(
			'progressbar_activation',
			array(
				'label'        => esc_html__( 'Product Avalibilty', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'ON', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'OFF', 'kitestudio-core' ),
				'return_value' => 'on',
				'default'      => '',
				'condition'    => array(
					'carousel' => array( 'enable', 'disable' ),
				),
			)
		);
		$repeater->add_control(
			'carousel_navigation',
			array(
				'label'        => esc_html__( 'Carousel Navigation', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'on',
				'default'      => 'on',
				'condition'    => array(
					'carousel' => 'enable',
				),
			)
		);
		$repeater->add_control(
			'nav_style',
			array(
				'label'     => esc_html__( 'Navigations Style', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
				),
				'default'   => 'light',
				'condition' => array(
					'carousel'            => 'enable',
					'carousel_navigation' => 'on',
				),
			)
		);

		$repeater->add_control(
			'style',
			array(
				'label'     => esc_html__( 'Style', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => kite_get_product_cards_style(),
				'default'   => KITE_DEFAULT_PRODUCT_STYLE,
				'condition' => array(
					'carousel' => array( 'enable', 'disable' ),
				),
			)
		);

		$repeater->add_control(
			'product-buttons-style',
			array(
				'label'     => esc_html__( 'Product Buttons Style', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'horizontal' => esc_html__( 'Horizontal', 'kitestudio-core' ),
					'vertical'   => esc_html__( 'Vertical', 'kitestudio-core' ),
				),
				'default'   => 'horizontal',
				'condition' => array(
					'carousel' => array( 'disable', 'enable' ),
					'style'    => 'modern-buttons-on-hover',
				),
			)
		);

		$repeater->add_control(
			'cart-button-style',
			array(
				'label'     => esc_html__( 'Cart Button Style', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'default'   => esc_html__( 'Default', 'kitestudio-core' ),
					'stretched' => esc_html__( 'Stretched Cart', 'kitestudio-core' ),
					'quantity'  => esc_html__( 'Quantity Mode', 'kitestudio-core' ),
				),
				'default'   => 'default',
				'condition' => array(
					'style'                 => 'modern-buttons-on-hover',
					'product-buttons-style' => 'vertical',
				),
			)
		);

		$repeater->add_control(
			'product_color_scheme',
			array(
				'label'   => esc_html__( 'Product Color Scheme', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
				),
				'default' => 'light',
			)
		);
		$repeater->add_control(
			'layout_mode',
			array(
				'label'     => esc_html__( 'Layout Mode', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'masonry' => esc_html__( 'Masonry', 'kitestudio-core' ),
					'fitRows' => esc_html__( 'Fit Rows', 'kitestudio-core' ),
				),
				'default'   => 'fitRows',
				'condition' => array(
					'carousel' => 'disable',
				),
			)
		);
		$repeater->add_control(
			'custom_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => $accent_color,
				'condition' => array(
					'style' => array( 'style2', 'style3' ),
				),
			)
		);
		$repeater->add_control(
			'gutter',
			array(
				'label'        => esc_html__( 'Gutter', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'carousel' => array( 'enable', 'disable' ),
				),
			)
		);
		$repeater->add_control(
			'border',
			array(
				'label'        => esc_html__( 'Border', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => '',
				'description'  => esc_html__( 'Border around the product box', 'kitestudio-core' ),
				'condition'    => array(
					'carousel' => array( 'enable', 'disable' ),
					'carousel' => array( 'disable', 'enable' ),
				),
			)
		);
		$repeater->add_control(
			'hide_buttons',
			array(
				'label'        => esc_html__( 'Hide All Buttons', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => '',
				'condition'    => array(
					'style'    => array( 'style1', 'style1-center', 'style2', 'style4', 'buttonsappearunder', 'modern-buttons-on-hover' ),
					'carousel' => array( 'disable', 'enable' ),
				),
			)
		);
		$repeater->add_control(
			'quickview',
			array(
				'label'        => esc_html__( 'Quick View Button', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'enable',
				'condition'    => array(
					'style'    => array( 'style1', 'style1-center', 'style2', 'style4', 'buttonsappearunder', 'modern-buttons-on-hover' ),
					'carousel' => array( 'disable', 'enable' ),
					'hide_buttons' => '',
				),
			)
		);
		$repeater->add_control(
			'wishlist',
			array(
				'label'        => esc_html__( 'Wishlist button', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'enable',
				'condition'    => array(
					'style'    => array( 'style1', 'style1-center', 'style2', 'buttonsappearunder', 'modern-buttons-on-hover' ),
					'carousel' => array( 'disable', 'enable' ),
					'hide_buttons' => '',
				),
			)
		);
		$repeater->add_control(
			'compare',
			array(
				'label'        => esc_html__( 'Compare button', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'enable',
				'condition'    => array(
					'style'    => array( 'style1', 'style1-center', 'style2', 'buttonsappearunder', 'modern-buttons-on-hover' ),
					'carousel' => array( 'disable', 'enable' ),
					'hide_buttons' => '',
				),
			)
		);
		$repeater->add_control(
			'badges',
			array(
				'label'        => esc_html__( 'Badges', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'enable',
				'condition'    => array(
					'carousel' => array( 'enable', 'disable' ),
				),
			)
		);
		$repeater->add_control(
			'rating',
			array(
				'label'        => esc_html__( 'Rating', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'enable',
				'condition'    => array(
					'carousel' => array( 'enable', 'disable' ),
				),
			)
		);
		$repeater->add_control(
			'hover_price',
			array(
				'label'        => esc_html__( 'hover price', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'disable',
				'condition'    => array(
					'style' => array( 'style2' ),
				),
			)
		);
		$repeater->add_control(
			'enterance_animation',
			array(
				'label'       => esc_html__( 'Entrance animation', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'fadein'           => esc_html__( 'FadeIn', 'kitestudio-core' ),
					'fadeinfrombottom' => esc_html__( 'FadeIn From Bottom', 'kitestudio-core' ),
					'fadeinfromtop'    => esc_html__( 'FadeIn From Top', 'kitestudio-core' ),
					'fadeinfromright'  => esc_html__( 'FadeIn From Right', 'kitestudio-core' ),
					'fadeinfromleft'   => esc_html__( 'FadeIn From Left', 'kitestudio-core' ),
					'zoomin'           => esc_html__( 'Zoom-in', 'kitestudio-core' ),
					'default'          => esc_html__( 'No Animation', 'kitestudio-core' ),
				),
				'default'     => 'fadein',
			)
		);
		$repeater->add_control(
			'responsive_animation',
			array(
				'label'        => esc_html__( 'Animation in Responsive', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'disable',
			)
		);

		do_action( 'kite_ajax_woocommerce_products_options_repeater', $repeater );

		$this->add_control(
			'product_tabs',
			array(
				'label'       => esc_html__( 'WooCommerce Products Tabs', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'tab_title' => esc_html__( 'First Product Tab', 'kitestudio-core' ),
					),
					array(
						'tab_title' => esc_html__( 'Second Product Tab', 'kitestudio-core' ),
					),
				),
				'title_field' => '{{{ tab_title }}}',
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
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Product Title Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} div.product .woocommerce-loop-product__title, {{WRAPPER}} .products div.product.list_view h2.product-title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Product title color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} div.product .woocommerce-loop-product__title, {{WRAPPER}}  div.product.list_view h2.product-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'categories_typography',
				'label'    => esc_html__( 'Categories Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} div.product .default_product_cat a',
				'default'  => '',
			)
		);

		$this->add_control(
			'categories_color',
			array(
				'label'     => esc_html__( 'Categories color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} div.product .default_product_cat a' => 'color: {{VALUE}}',
				),
			)
		);

		// $this->add_group_control(
		// 	\Elementor\Group_Control_Typography::get_type(),
		// 	array(
		// 		'name'     => 'price_typography',
		// 		'label'    => esc_html__( 'Price Typography', 'kitestudio-core' ),
		// 		'global'   => [
				// 	'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				// ],
		// 		'selector' => '{{WRAPPER}} div.product .price .woocommerce-Price-amount, {{WRAPPER}} div.product .price .woocommerce-Price-currencySymbol',
		// 	)
		// );

		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'Price color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} div.product .price .woocommerce-Price-amount, {{WRAPPER}} div.product .price .woocommerce-Price-currencySymbol' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'product_image_border_radius',
			array(
				'label'      => esc_html__( 'Image Border Radius', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} img, {{WRAPPER}} .hover-image, {{WRAPPER}} .imageswrap, {{WRAPPER}} .add_to_cart_btn_wrap, {{WRAPPER}} .infoonhover div.product.with-border .productwrap,{{WRAPPER}} .hover_layer, {{WRAPPER}} .infoonclickwrapper, {{WRAPPER}} .buttonsappearunder .product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'tab_list_margin',
			array(
				'label'      => esc_html__( 'Tab List Margin', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ul.vc_tta-tabs-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_list_padding',
			array(
				'label'      => esc_html__( 'Tab List Padding', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ul.vc_tta-tabs-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'headings_style',
			array(
				'label' => esc_html__( 'Headings Style', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_title_typography',
				'label'    => esc_html__( 'Title Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .vc_tta-tabs-container > h2',
			)
		);

		$this->add_control(
			'heading_title_color',
			array(
				'label'     => esc_html__( 'Title color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .vc_tta-tabs-container > h2' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_subtitle_typography',
				'label'    => esc_html__( 'Subtitle Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .vc_tta-tabs-container > span.subtitle',
			)
		);

		$this->add_control(
			'heading_subtitle_color',
			array(
				'label'     => esc_html__( 'Subtitle color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .vc_tta-tabs-container > span.subtitle' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'headings_title_margin',
			array(
				'label'      => esc_html__( 'Title Margin', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .vc_tta-tabs-container > h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'headings_title_padding',
			array(
				'label'      => esc_html__( 'Title Padding', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .vc_tta-tabs-container > h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'headings_subtitle_margin',
			array(
				'label'      => esc_html__( 'Subtitle Margin', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .vc_tta-tabs-container > span.subtitle > p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'headings_subtitle_padding',
			array(
				'label'      => esc_html__( 'Subtitle Padding', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .vc_tta-tabs-container > span.subtitle > p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'tab_items_style',
			array(
				'label' => esc_html__( 'Tab Items Style', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tab_states' );

		$this->start_controls_tab(
			'normal_tab_item',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_item_typography',
				'label'    => esc_html__( 'Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .vc_tta-title-text',
				'default'  => '',
			)
		);

		$this->add_control(
			'deactive_tab_color',
			array(
				'label'     => esc_html__( 'Deactive Tab Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .ajax_products_tab ul.vc_tta-tabs-list li span' => 'color:{{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'tab_item_background',
				'label'    => __( 'Select Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} li.vc_tta-tab',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'tab_item_border',
				'label'     => esc_html__( 'Border', 'kitestudio-core' ),
				'selector'  => '{{WRAPPER}} li.vc_tta-tab',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'tab_item_border_radius',
			array(
				'label'      => esc_html__( ' Border Radius', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} li.vc_tta-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_item_margin',
			array(
				'label'      => esc_html__( 'Margin', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} li.vc_tta-tab' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_item_padding',
			array(
				'label'      => esc_html__( 'Padding', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} li.vc_tta-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} li.vc_tta-tab .vc_tta-title-text' => 'padding: 0 !important'
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover_tab_item',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'hover_tab_color',
			array(
				'label'     => esc_html__( 'Tab Hover Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .ajax_products_tab ul.vc_tta-tabs-list li:hover span' => 'color:{{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'hover_tab_item_background',
				'label'    => __( 'Select Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} li.vc_tta-tab:hover',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'hover_tab_item_border',
				'label'     => esc_html__( 'Border', 'kitestudio-core' ),
				'selector'  => '{{WRAPPER}} li.vc_tta-tab:hover',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'hover_tab_item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} li.vc_tta-tab:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'active_tab_item',
			array(
				'label' => __( 'Selected', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'active_tab_item_typography',
				'label'    => esc_html__( 'Selected Item Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .vc_active .vc_tta-title-text',
				'default'  => '',
			)
		);

		$this->add_control(
			'active_tab_color',
			array(
				'label'     => esc_html__( 'Active Tab Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .ajax_products_tab ul.vc_tta-tabs-list li.vc_active span' => 'color:{{VALUE}} !important',
					'{{WRAPPER}} .ajax_products_tab ul.vc_tta-tabs-list li.vc_active' => 'border-top-color:{{VALUE}} !important;border-bottom-color:{{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'active_tab_item_background',
				'label'    => __( 'Select Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} li.vc_tta-tab.vc_active',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'active_tab_item_border',
				'label'     => esc_html__( 'Border', 'kitestudio-core' ),
				'selector'  => '{{WRAPPER}} li.vc_tta-tab.vc_ative',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'active_tab_item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} li.vc_tta-tab.vc_active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'list_view_style',
			array(
				'label'     => esc_html__( 'List View Style', 'kitestudio-core' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'carousel' => 'list',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'banner_border',
				'label'    => __( 'Image Border', 'kitestudio-core' ),
				'selector' => '{{WRAPPER}} img',
			)
		);

		$this->add_responsive_control(
			'banner_border_radius',
			array(
				'label'      => esc_html__( 'Image Border Radius', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'product_info_margin',
			array(
				'label'      => esc_html__( 'Product Info Margin', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .product.list_view .productinfo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render Ajax Woocommerce Products widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings              = $this->get_settings_for_display();
		$product_tab_shortcode = '';
		foreach ( $settings['product_tabs'] as $product_tab ) {
			$product_tab_shortcode .= $this->kite_generate_product_shortcode( $product_tab, $settings );
		}
		$atts = [
			'heading_title' => $settings['heading_title'],
			'heading_subtitle' => $settings['heading_subtitle'],
			'position' =>  $settings['position']  ,
			'alignment' =>  $settings['alignment'] ?? 'center' ,
			'style' =>  $settings['style']  ,
			'shape' =>  $settings['shape']  ,
			'active_tab_color' =>  $settings['active_tab_color']  ,
			'deactive_tab_color' =>  $settings['deactive_tab_color']  ,
		];
		echo kite_ajax_products_tab( $atts, $product_tab_shortcode );
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
		return true;
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
		$settings              = $this->get_settings_for_display();
		$product_tab_shortcode = '';
		foreach ( $settings['product_tabs'] as $product_tab ) {
			$product_tab_shortcode .= $this->kite_generate_product_shortcode( $product_tab, $settings );
		}
		$alignment = $settings['alignment'] ?? 'center';
		echo '[ajax_products_tab heading_title="' . esc_attr( $settings['heading_title'] ) . '" heading_subtitle="' . esc_attr( $settings['heading_subtitle'] ) . '" position="' . esc_attr( $settings['position'] ) . '" alignment="' . esc_attr( $alignment ) . '" style="' . esc_attr( $settings['style'] ) . '" shape="' . esc_attr( $settings['shape'] ) . '" active_tab_color="' . esc_attr( $settings['active_tab_color'] ) . '" deactive_tab_color="' . esc_attr( $settings['deactive_tab_color'] ) . '"]' . $product_tab_shortcode . '[/ajax_products_tab]';
	}

	public function kite_generate_product_shortcode( $settings, $parent_shortcode_settings, $return_args = false ) {
		if ( is_array( $settings['category'] ) ) {
			$category = implode( ',', $settings['category'] );
		} else {
			$category = $settings['category'];
		}

		if ( is_array( $settings['tags'] ) ) {
			$tags = implode( ',', $settings['tags'] );
		} else {
			$tags = $settings['tags'];
		}

		if ( $settings['image_size'] == 'custom' ) {
			$image_size = 'image_size="custom" image_size_width="' . $settings['image_size_width'] . '" image_size_height="' . $settings['image_size_height'] . '" image_size_crop="' . $settings['image_size_crop'] . '"';
		} else {
			$image_size = 'image_size="' . $settings['image_size'] . '"';
		}

		$settings['gutter'] = ( $settings['gutter'] == 'yes' ) ? '' : 'no';
		$toggles            = array(
			'quickview',
			'wishlist',
			'compare',
			'badges',
			'hover_price',
		);
		foreach ( $toggles as $toggle ) {
			$settings[ $toggle ] = ( $settings[ $toggle ] == 'enable' ) ? '' : 'disable';
		}

		$body_class[] = $settings['carousel_navigation'] == 'on' ? 'carousel-navigation-on' : 'carousel-navigation-off';

		if ( $settings['tab_icon_check'] == 'enable' ) {

			// Check if its already migrated
			$migrated = isset( $settings['__fa4_migrated']['tab_new_icon'] );
			// Check if its a new widget without previously selected icon using the old Icon control
			$is_new = empty( $settings['tab_icon'] );
			if ( $is_new || $migrated ) {
				$tab_icon = $settings['tab_new_icon']['library'] == 'svg' ? '' : $settings['tab_new_icon']['value'];
			} elseif ( isset( $settings['tab_icon']['value'] ) ) {
				$tab_icon = $settings['tab_icon']['library'] == 'svg' ? '' : $settings['tab_icon']['value'];
			} else {
				$tab_icon = $settings['tab_icon'];
			}
		} else {
			$tab_icon = '';
		}

		$args = array(
			'tab_title'              => $settings['tab_title'],
			'tab_icon_check'         => $settings['tab_icon_check'],
			'tab_icon'               => $tab_icon,
			'product_type'           => $settings['product_type'],
			'per_page'               => $settings['per_page'],
			'order'                  => $settings['order'],
			'product_cats'           => $settings['product_cats'],
			'category'               => $category,
			'tags'                   => $tags,
			'carousel'               => $settings['carousel'],
			'list_style'             => $settings['list_style'],
			'columns'                => $settings['columns'],
			'hover_image'            => $settings['hover_image'],
			'is_autoplay'            => $settings['is_autoplay'],
			'responsive_autoplay'    => $settings['responsive_autoplay'],
			'countdown_activation'   => $settings['countdown_activation'],
			'progressbar_activation' => $settings['progressbar_activation'],
			'nav_style'              => $settings['nav_style'],
			'style'                  => $settings['style'],
			'product_color_scheme'   => $settings['product_color_scheme'],
			'layout_mode'            => $settings['layout_mode'],
			'custom_hover_color'     => $settings['custom_hover_color'],
			'hover_color'            => 'custom-color',
			'gutter'                 => $settings['gutter'],
			'border'                 => $settings['border'],
			'quickview'              => $settings['quickview'],
			'wishlist'               => $settings['wishlist'],
			'compare'                => $settings['compare'],
			'badges'                 => $settings['badges'],
			'rating'				 => $settings['rating'],
			'hover_price'            => $settings['hover_price'],
			'enterance_animation'    => $settings['enterance_animation'],
			'responsive_animation'   => $settings['responsive_animation'],
			'body_class'             => implode( ' ', $body_class ),
			'product_buttons_style'  => $settings['product-buttons-style'],
			'cart_button_style'      => $settings['cart-button-style'],
			'load_skeleton_style'    => ! empty( $parent_shortcode_settings['load_skeleton_style'] ) ? $parent_shortcode_settings['load_skeleton_style'] : false,
			'catalog_mode'           => ! empty( $settings['catalog_mode'] ) && $settings['catalog_mode'] === 'enable' ? '' : true,
		);

		if ( ! empty( $settings['orderby'] ) ) {
			$args['orderby'] = $settings['orderby'];
		}

		$args = apply_filters( 'kite_elementor_product_cards_args', $args, $settings );

		if ( ! isset( $args['column_in_mobile'] ) ) {
			$desktop_columns = (int) $args['columns'];
			if ( $desktop_columns <= 3 ) {
				$args['column_in_mobile'] = 1;
				$args['tablet_columns']   = $desktop_columns;
			} else {
				$args['column_in_mobile'] = 1;
				$args['tablet_columns']   = 3;
			}
		}

		if ( $return_args ) {
			return $args;
		}

		$shortcode = '[woocommerce_products_ajax ';
		foreach ( $args as $key => $value ) {
			$shortcode .= $key . '="' . esc_attr( $value ) . '" ';
		}
		$shortcode .= $image_size;
		$shortcode .= ']';

		return $shortcode;
	}

	protected function content_template() {

	}
}
