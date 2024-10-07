<?php
/**
 * Elementor Woocommerce Specific Products Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Woocommerce_HandPicked_Products_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Woocommerce Specific Products widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-woocommerce-hand-picked-products';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Woocommerce Specific Products widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Woocommerce HandPicked Products', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Woocommerce Specific Products widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-add-to-cart kite-element-icon';
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
		return array( 'woocommerce', 'shop', 'handpicked', 'product' );
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Woocommerce Specific Products widget belongs to.
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
		return array( 'kite-product-card' );
	}

	/**
	 * load dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'kite-carousel',
			'kite-product-cards',
		);
	}

	/**
	 * Register Woocommerce Specific Products widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$products_list = array();
		$args          = array(
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'fields' => 'ids'
		);

		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) {
			foreach( $loop->posts as $product_id ) {
				$products_list[ $product_id ] = get_the_title( $product_id );	
			}
		}

		$accent_color = kite_opt( 'style-accent-color', '#5956e9' );

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Woocommerce Specific Products', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'ids',
			array(
				'label'       => esc_html__( 'Products', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $products_list,
			)
		);
		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order by', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
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
				'default' => 'date',
			)
		);
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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

		$this->add_control(
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
		$this->add_control(
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

		$this->add_control(
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

		$this->add_control(
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

		$this->add_control(
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

		$this->add_responsive_control(
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

		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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

		$this->add_control(
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

		$this->add_control(
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

		$this->add_control(
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

		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->end_controls_section();
		$this->start_controls_section(
			'animation_section',
			array(
				'label' => esc_html__( 'Animation', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'enterance_animation',
			array(
				'label'       => esc_html__( 'Entrance animation', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'fadeIn'           => esc_html__( 'FadeIn', 'kitestudio-core' ),
					'fadeInFromBottom' => esc_html__( 'FadeIn From Bottom', 'kitestudio-core' ),
					'fadeInFromTop'    => esc_html__( 'FadeIn From Top', 'kitestudio-core' ),
					'fadeInFromRight'  => esc_html__( 'FadeIn From Right', 'kitestudio-core' ),
					'fadeInFromLeft'   => esc_html__( 'FadeIn From Left', 'kitestudio-core' ),
					'zoomIn'           => esc_html__( 'Zoom-in', 'kitestudio-core' ),
					'default'          => esc_html__( 'No Animation', 'kitestudio-core' ),
				),
				'default'     => 'fadeIn',
			)
		);
		$this->add_control(
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
				'label'    => esc_html__( 'Title Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} div.product .woocommerce-loop-product__title, {{WRAPPER}} .products div.product.list_view h2.product-title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title color ', 'kitestudio-core' ),
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
				'condition'  => array(
					'carousel!' => 'list',
				),
			)
		);

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
				'name'     => 'list_view_image_border',
				'label'    => __( 'Image Border', 'kitestudio-core' ),
				'selector' => '{{WRAPPER}} img',
			)
		);

		$this->add_responsive_control(
			'list_view_image_border_radius',
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
	 * Render Woocommerce Specific Products widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$args = $this->kite_generate_shortcode( $settings, true );
		echo kite_products( $args );
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
		$settings  = $this->get_settings_for_display();
		$shortcode = $this->kite_generate_shortcode( $settings );
		echo wp_kses( $shortcode, kite_allowed_html() );

	}

	public function kite_generate_shortcode( $settings, $return_args = false ) {

		if ( is_array( $settings['ids'] ) ) {
			$ids = implode( ',', $settings['ids'] );
		} else {
			$ids = $settings['ids'];
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

		$args = array(
			'ids'                    => $ids,
			'orderby'                => $settings['orderby'],
			'order'                  => $settings['order'],
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
			'hover_color'            => 'custom',
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
			'hide_buttons'           => $settings['hide_buttons'] === 'enable',
		);

		if ( $settings['image_size'] == 'custom' ) {
			$args['image_size'] = 'custom';
			$args['image_size_width'] =  $settings['image_size_width'] ;
			$args['image_size_height'] =  $settings['image_size_height'] ;
			$args['image_size_crop'] =  $settings['image_size_crop'] ;
		} else {
			$args['image_size'] =  $settings['image_size'] ;
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

		$shortcode = '[products ';
		foreach ( $args as $key => $value ) {
			$shortcode .= $key . '="' . $value . '" ';
		}
		$shortcode .= ']';

		return $shortcode;
	}

	protected function content_template() {

	}
}
