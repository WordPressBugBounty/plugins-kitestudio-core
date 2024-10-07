<?php
/**
 * Elementor Single Product Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Single_Product_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Single Product widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-single-product';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Single Product widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Single Product', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Single Product widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-info kite-element-icon';
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
		return array( 'woocommerce', 'shop', 'product' );
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Single Product widget belongs to.
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
			'kite-product-cards',
		);
	}

	/**
	 * Register Single Product widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$products = array();
		$args          = array(
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'fields' => 'ids'
		);

		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) {
			foreach( $loop->posts as $product_id ) {
				$products[ $product_id ] = get_the_title( $product_id );	
			}
		}

		wp_reset_postdata();

		$accent_color = kite_opt( 'style-accent-color', '#5956e9' );

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Single Product', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'product_id',
			array(
				'label'   => esc_html__( 'Select Product', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $products,
			)
		);

		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => kite_get_product_cards_style(),
				'default' => KITE_DEFAULT_PRODUCT_STYLE,
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
					'style' => 'modern-buttons-on-hover',
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
			'border',
			array(
				'label'        => esc_html__( 'Border', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => '',
				'description'  => esc_html__( 'Border around the product box', 'kitestudio-core' ),
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
					'style' => array( 'style1', 'style1-center', 'style2', 'style4', 'buttonsappearunder', 'modern-buttons-on-hover' ),
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
					'style' => array( 'style1', 'style1-center', 'style2', 'buttonsappearunder', 'modern-buttons-on-hover' ),
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
					'style' => array( 'style1', 'style1-center', 'style2', 'buttonsappearunder', 'modern-buttons-on-hover' ),
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
					'fadeinfrombottom' => esc_html__( 'FadeIn From Bottom', 'kitestudio-core' ),
					'fadeinfromtop'    => esc_html__( 'FadeIn From Top', 'kitestudio-core' ),
					'fadeinfromright'  => esc_html__( 'FadeIn From Right', 'kitestudio-core' ),
					'fadeinfromleft'   => esc_html__( 'FadeIn From Left', 'kitestudio-core' ),
					'zoomin'           => esc_html__( 'Zoom-in', 'kitestudio-core' ),
					'default'          => esc_html__( 'No Animation', 'kitestudio-core' ),
				),
				'default'     => 'fadeinfrombottom',
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
	}

	/**
	 * Render Single Product widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$args = $this->kite_generate_shortcode( $settings, true );
		echo kite_sc_product( $args );
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
		$settings  = $this->get_settings_for_display();
		echo $this->kite_generate_shortcode( $settings );
	}

	public function kite_generate_shortcode( $settings, $return_args = false ) {

		$toggles = array(
			'quickview',
			'wishlist',
			'compare',
			'badges',
			'hover_price',
		);
		foreach ( $toggles as $toggle ) {
			$settings[ $toggle ] = ( $settings[ $toggle ] == 'enable' ) ? '' : 'disable';
		}

		$args = array(
			'product_id'             => $settings['product_id'],
			'hover_image'            => $settings['hover_image'],
			'countdown_activation'   => $settings['countdown_activation'],
			'progressbar_activation' => $settings['progressbar_activation'],
			'style'                  => $settings['style'],
			'product_buttons_style'  => $settings['product-buttons-style'],
			'cart_button_style'      => $settings['cart-button-style'],
			'product_color_scheme'   => $settings['product_color_scheme'],
			'custom_hover_color'     => $settings['custom_hover_color'],
			'hover_color'            => 'custom',
			'border'                 => $settings['border'],
			'quickview'              => $settings['quickview'],
			'wishlist'               => $settings['wishlist'],
			'compare'                => $settings['compare'],
			'badges'                 => $settings['badges'],
			'rating'				 => $settings['rating'],
			'hover_price'            => $settings['hover_price'],
			'enterance_animation'    => $settings['enterance_animation'],
			'responsive_animation'   => $settings['responsive_animation'],
			'catalog_mode'           => !empty( $settings['catalog_mode'] ) && $settings['catalog_mode'] === 'enable' ? '' : true,
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

		if ( $return_args ) {
			return $args;
		}

		$shortcode = '[product ';
		foreach ( $args as $key => $value ) {
			$shortcode .= $key . '="' . $value . '" ';
		}
		$shortcode .= ']';

		return $shortcode;
	}

	protected function content_template() {

	}
}
