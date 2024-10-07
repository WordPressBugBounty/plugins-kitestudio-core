<?php
/**
 * Elementor Image Carousel Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Image_Carousel_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Image Carousel widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-image-carousel';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Image Carousel widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Image Carousel', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Image Carousel widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-slides kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Image Carousel widget belongs to.
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
	 * Register Image Carousel widget controls.
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
				'label' => esc_html__( 'Image Carousel', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'visible_items',
			array(
				'label'   => esc_html__( 'Visible Items', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => '7',
					'8' => '8',
				),
				'default' => '1',
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
				'description'  => esc_html__( 'Remove gutter between items', 'kitestudio-core' ),
			)
		);
		$this->add_control(
			'naxt_prev_btn',
			array(
				'label'   => esc_html__( 'Navigation Buttons Visibility', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'show' => esc_html__( 'Enable', 'kitestudio-core' ),
					'hide' => esc_html__( 'Disable', 'kitestudio-core' ),
				),
				'default' => 'show',
			)
		);
		$this->add_control(
			'nav_style',
			array(
				'label'   => esc_html__( 'Navigation Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
				),
				'default' => 'dark',
			)
		);
		$this->add_control(
			'images',
			array(
				'label'   => esc_html__( 'Images', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::GALLERY,
				'default' => array(),
			)
		);
		$this->add_control(
			'image_size',
			array(
				'label'   => esc_html__( 'Carousel Image Size', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'full'      => esc_html__( 'Full', 'kitestudio-core' ),
					'medium'    => esc_html__( 'Medium', 'kitestudio-core' ),
					'thumbnail' => esc_html__( 'Thumbnail', 'kitestudio-core' ),
					'custom'    => esc_html__( 'Custom', 'kitestudio-core' ),
				),
				'default' => 'full',
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
			'custom_hover_color',
			array(
				'label'     => esc_html__( 'Custom hover Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .carousel .swiper-slide .image-container:before' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'zoom',
			array(
				'label'        => esc_html__( 'Hover Zoom effect', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);
		$this->add_control(
			'is_autoplay',
			array(
				'label'   => esc_html__( 'Autoplay', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'on'  => esc_html__( 'On', 'kitestudio-core' ),
					'off' => esc_html__( 'Off', 'kitestudio-core' ),
				),
				'default' => 'on',
			)
		);
		$this->add_control(
			'enterance_animation',
			array(
				'label'   => esc_html__( 'Entrance animation', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'fadeinfrombottom' => esc_html__( 'FadeIn From Bottom', 'kitestudio-core' ),
					'fadeinfromtop'    => esc_html__( 'FadeIn From Top', 'kitestudio-core' ),
					'fadeinfromright'  => esc_html__( 'FadeIn From Right', 'kitestudio-core' ),
					'fadeinfromleft'   => esc_html__( 'FadeIn From Left', 'kitestudio-core' ),
					'zoomin'           => esc_html__( 'Zoom-in', 'kitestudio-core' ),
					'default'          => esc_html__( 'No Animation', 'kitestudio-core' ),
				),
				'default' => 'fadeinfrombottom',
			)
		);
		$this->add_control(
			'responsive_animation',
			array(
				'label'        => esc_html__( 'Animation in Responsive', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'Enable',
				'default'      => 'disable',
			)
		);
		$this->end_controls_section();

	}

	/**
	 * Render Image Carousel widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$images_id = array();
		foreach ( $settings['images'] as $image ) {
			$images_id[] = $image['id'];
		}
		$images_id  = implode( ',', $images_id );

		$atts = [
			'visible_items' =>  $settings['visible_items']  ,
			'gutter' =>  $settings['gutter']  ,
			'naxt_prev_btn' =>  $settings['naxt_prev_btn']  ,
			'nav_style' =>  $settings['nav_style']  ,
			'images' =>  $images_id  ,
			'hover_color' => 'custom' ,
			'custom_hover_color' =>  $settings['custom_hover_color']  ,
			'zoom' =>  $settings['zoom']  ,
			'is_autoplay' =>  $settings['is_autoplay']  ,
			'enterance_animation' =>  $settings['enterance_animation']  ,
			'responsive_animation' =>  $settings['responsive_animation']  ,
		];

		if ( $settings['image_size'] == 'custom' ) {
			$atts['image_size'] = 'custom';
			$atts['image_size_width'] =  $settings['image_size_width'] ;
			$atts['image_size_height'] =  $settings['image_size_height'] ;
			$atts['image_size_crop'] =  $settings['image_size_crop'] ;
		} else {
			$atts['image_size'] =  $settings['image_size'] ;
		}

		echo kite_sc_imagecarousel( $atts );
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
		if ( $settings['image_size'] == 'custom' ) {
			$image_size = 'image_size="custom" image_size_width="' . esc_attr( $settings['image_size_width'] ) . '" image_size_height="' . esc_attr( $settings['image_size_height'] ) . '" image_size_crop="' . esc_attr( $settings['image_size_crop'] ) . '"';
		} else {
			$image_size = 'image_size="' . esc_attr( $settings['image_size'] ) . '"';
		}

		$images_id = array();
		foreach ( $settings['images'] as $image ) {
			$images_id[] = $image['id'];
		}
		$images_id = implode( ',', $images_id );
		echo '[image_carousel visible_items="' . esc_attr( $settings['visible_items'] ) . '" ' . esc_html( $image_size ) . ' gutter="' . esc_attr( $settings['gutter'] ) . '" naxt_prev_btn="' . esc_attr( $settings['naxt_prev_btn'] ) . '" nav_style="' . esc_attr( $settings['nav_style'] ) . '" images="' . esc_attr( $images_id ) . '" hover_color="custom" custom_hover_color="' . esc_attr( $settings['custom_hover_color'] ) . '" zoom="' . esc_attr( $settings['zoom'] ) . '" is_autoplay="' . esc_attr( $settings['is_autoplay'] ) . '" enterance_animation="' . esc_attr( $settings['enterance_animation'] ) . '" responsive_animation="' . esc_attr( $settings['responsive_animation'] ) . '"]';

	}

	protected function content_template() {

	}
}
