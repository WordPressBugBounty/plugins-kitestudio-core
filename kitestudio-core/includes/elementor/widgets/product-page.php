<?php
/**
 * Elementor Product Page Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Product_Page_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Product Page widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-product-page';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Product Page widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product Page', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Product Page widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-price kite-element-icon';
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
	 * Retrieve the list of categories the Product Page widget belongs to.
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
	 * Register Product Page widget controls.
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
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Product Page', 'kitestudio-core' ),
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
		$this->end_controls_section();
	}

	/**
	 * Render Product Page widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings  = $this->get_settings_for_display();
		echo kite_product_page([
			'product_id' => $settings['product_id'],
		]);
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
		echo '[product_page product_id="' . esc_attr( $settings['product_id'] ) . '"]';
	}

	protected function content_template() {

	}
}
