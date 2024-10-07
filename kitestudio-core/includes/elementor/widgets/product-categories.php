<?php
/**
 * Elementor Product Categories Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Product_Categories_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Product Categories widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-product-categories';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Product Categories widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product Categories', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Product Categories widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-images kite-element-icon';
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
		return array( 'woocommerce', 'shop', 'products', 'categories' );
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Product Categories widget belongs to.
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
		return array();
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
	 * Register Product Categories widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$product_cats = array();
		$cat_args     = array(
			'orderby'    => 'term_id',
			'order'      => 'ASC',
			'hide_empty' => false,
		);

		$terms = get_terms( 'product_cat', $cat_args );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) { // check is gallery plugin is active or not
			foreach ( $terms as $taxonomy ) {
					$product_cats[ $taxonomy->term_id ] = $taxonomy->name;
			}
		}

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Product Categories', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'number',
			array(
				'label'       => esc_html__( 'Number', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'description' => esc_html__( 'The `number` field is used to display the number of products.', 'kitestudio-core' ),
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
			'hide_empty',
			array(
				'label'        => esc_html__( 'Hide Empty Categories', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => true,
				'default'      => false,
			)
		);
		$this->add_control(
			'ids',
			array(
				'label'       => esc_html__( 'product Categories', 'kitestudio-core' ),
				'label_block' => true,
				'multiple'    => true,
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $product_cats,
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
			'show_image',
			array(
				'label'        => esc_html__( 'Show Category Image', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'true',
				'default'      => '',
				'condition'    => array(
					'carousel' => 'list',
				),
			)
		);
		$this->add_control(
			'list_image_size',
			array(
				'label'      => esc_html__( 'Image Size', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 70,
						'max'  => 300,
						'step' => 5,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 70,
				),
				'condition'  => array(
					'show_image' => 'true',
				),
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce.wc-categories.list div.products div.product div.interactive-background-image' => 'width:{{SIZE}}{{UNIT}} !important; height:{{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .woocommerce.wc-categories.list .product-category h3' => 'width:calc(100% - ({{SIZE}}{{UNIT}}*2) + 45px) !important;padding-left:15px;',
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
					'full'           => 'Full',
					'custom'         => 'Custom',
				),
				'default'     => 'shop_catalog',
				'condition'   => array(
					'carousel' => array( 'disable', 'enable' ),
				),
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
			'product-category-styles',
			array(
				'label'     => esc_html__( 'Title Styles', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'style-1' => esc_html__( 'Top Left', 'kitestudio-core' ),
					'style-3' => esc_html__( 'Bottom Center', 'kitestudio-core' ),
					'style-2' => esc_html__( 'Under Center', 'kitestudio-core' ),
				),
				'default'   => 'style-1',
				'condition' => array(
					'carousel' => array( 'enable', 'disable' ),
				),
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
				'selector' => '{{WRAPPER}} .woocommerce div.products div.product.product-category h3',
			)
		);
		$this->add_control(
			'style',
			array(
				'label'       => esc_html__( 'Text color', 'kitestudio-core' ),
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => array(
					'{{WRAPPER}} .wc-categories .product-category h3' => 'color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'custom_hover_color',
			array(
				'label'     => esc_html__( 'Custom hover color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#c0392b',
				'selectors' => array(
					'{{WRAPPER}} .wc-categories .product-category .category-hover' => 'background-color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'hover_text_color',
			array(
				'label'     => esc_html__( 'Hover Text Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} div.product.product-category:hover h3' => 'color:{{VALUE}} !important',
				),
			)
		);
		$this->add_control(
			'count',
			array(
				'label'        => esc_html__( 'Show Product count', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'disable',
			)
		);
		$this->add_control(
			'description',
			array(
				'label'        => esc_html__( 'Show category description', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'enable',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'description_typography',
				'label'     => esc_html__( 'Description Typography', 'kitestudio-core' ),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .woocommerce div.products div.product.product-category h3 span',
				'condition' => array(
					'description' => 'enable',
				),
			)
		);
		$this->add_control(
			'border',
			array(
				'label'        => esc_html__( 'Disable Border', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'disable',
				'default'      => '',
				'description'  => esc_html__( 'Disable border around the product box', 'kitestudio-core' ),
				'condition'    => array(
					'carousel' => array( 'enable', 'disable' ),
				),
			)
		);
		$this->add_control(
			'gutter',
			array(
				'label'        => esc_html__( 'Remove Gutter', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'no',
				'default'      => 'no',
				'condition'    => array(
					'carousel' => array( 'enable', 'disable' ),
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
			'hover_animation',
			array(
				'label'        => esc_html__( 'Hover Animation', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'enable',
			)
		);
		$this->add_control(
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
	}

	/**
	 * Render Product Categories widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( is_array( $settings['ids'] ) ) {
			$category = implode( ',', $settings['ids'] );
		} else {
			$category = $settings['ids'];
		}

		$body_class[] = $settings['carousel_navigation'] == 'on' ? 'carousel-navigation-on' : 'carousel-navigation-off';
		
		$atts = [
			'number' =>  $settings['number']  ,
			'orderby' =>  $settings['orderby']  ,
			'order' =>  $settings['order']  ,
			'hide_empty' =>  $settings['hide_empty']  ,
			'ids' =>  $category  ,
			'carousel' =>  $settings['carousel']  ,
			'columns' =>  $settings['columns']  ,
			'show_image' =>  $settings['show_image']  ,
			'nav_style' =>  $settings['nav_style']  ,
			'is_autoplay' =>  $settings['is_autoplay']  ,
			'product-category-styles' => $settings['product-category-styles'],
			'style' =>  $settings['style']  ,
			'font_size' => 'custom' ,
			'custom_hover_color' =>  $settings['custom_hover_color']  ,
			'hover_color' => 'custom' ,
			'hover_text_color' =>  $settings['hover_text_color']  ,
			'count' =>  $settings['count']  ,
			'description' =>  $settings['description']  ,
			'border' =>  $settings['border']  ,
			'gutter' =>  $settings['gutter']  ,
			'hover_animation' =>  $settings['hover_animation']  ,
			'enterance_animation' =>  $settings['enterance_animation']  ,
			'responsive_animation' =>  $settings['responsive_animation']  ,
			'elementor' => 'elementor' ,
			'body_class' =>  implode( ' ', $body_class  )
		];

		if ( $settings['image_size'] == 'custom' ) {
			$atts['image_size'] = 'custom';
			$atts['image_size_width'] =  $settings['image_size_width'] ;
			$atts['image_size_height'] =  $settings['image_size_height'] ;
			$atts['image_size_crop'] =  $settings['image_size_crop'] ;
		} else {
			$atts['image_size'] =  $settings['image_size'] ;
		}
		echo kite_product_categories( $atts );
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

		if ( is_array( $settings['ids'] ) ) {
			$category = implode( ',', $settings['ids'] );
		} else {
			$category = $settings['ids'];
		}

		if ( $settings['image_size'] == 'custom' ) {
			$image_size = 'image_size="custom" image_size_width="' . esc_attr( $settings['image_size_width'] ) . '" image_size_height="' . esc_attr( $settings['image_size_height'] ) . '" image_size_crop="' . esc_attr( $settings['image_size_crop'] ) . '"';
		} else {
			$image_size = 'image_size="' . esc_attr( $settings['image_size'] ) . '"';
		}
		$body_class[] = $settings['carousel_navigation'] == 'on' ? 'carousel-navigation-on' : 'carousel-navigation-off';
		echo '[product_categories number="' . esc_attr( $settings['number'] ) . '" orderby="' . esc_attr( $settings['orderby'] ) . '" order="' . esc_attr( $settings['order'] ) . '" hide_empty="' . esc_attr( $settings['hide_empty'] ) . '" ids="' . esc_attr( $category ) . '" carousel="' . esc_attr( $settings['carousel'] ) . '" columns="' . esc_attr( $settings['columns'] ) . '" show_image="' . esc_attr( $settings['show_image'] ) . '" ' . esc_html( $image_size ) . ' nav_style="' . esc_attr( $settings['nav_style'] ) . '" is_autoplay="' . esc_attr( $settings['is_autoplay'] ) . '" product-category-styles="' . esc_attr( $settings['product-category-styles'] ) . '" style="' . esc_attr( $settings['style'] ) . '" font_size="custom" custom_hover_color="' . esc_attr( $settings['custom_hover_color'] ) . '" hover_color="custom" hover_text_color="' . esc_attr( $settings['hover_text_color'] ) . '" count="' . esc_attr( $settings['count'] ) . '" description="' . esc_attr( $settings['description'] ) . '" border="' . esc_attr( $settings['border'] ) . '" gutter="' . esc_attr( $settings['gutter'] ) . '" hover_animation="' . esc_attr( $settings['hover_animation'] ) . '" enterance_animation="' . esc_attr( $settings['enterance_animation'] ) . '" responsive_animation="' . esc_attr( $settings['responsive_animation'] ) . '" elementor="elementor" body_class="' . esc_attr( implode( ' ', $body_class ) ) . '"]';
	}

	protected function content_template() {

	}
}
