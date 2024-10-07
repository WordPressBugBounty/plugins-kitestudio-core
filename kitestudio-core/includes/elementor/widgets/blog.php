<?php
/**
 * Elementor Blog Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Blog_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Blog widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-blog';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Blog widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Blog - Card Style', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Blog widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-group kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Blog widget belongs to.
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
		return array( 'kite-blog' );
	}

	/**
	 * load dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'kite-blog',
		);
	}

	/**
	 * Register Blog widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$posts_cats = array();
		$cat_args   = array(
			'orderby'    => 'term_id',
			'order'      => 'ASC',
			'hide_empty' => false,
		);

		$terms = get_terms( 'category', $cat_args );

		foreach ( $terms as $taxonomy ) {
			 $posts_cats[ $taxonomy->slug ] = $taxonomy->name;
		}
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Blog', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'blog_column',
			array(
				'label'   => esc_html__( 'Number of columns', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'3' => esc_html__( 'Three', 'kitestudio-core' ),
					'4' => esc_html__( 'Four', 'kitestudio-core' ),
				),
				'default' => '3',
			)
		);
		$this->add_control(
			'blog_filter',
			array(
				'label'       => esc_html__( 'Blog Categories', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'all'    => esc_html__( 'All', 'kitestudio-core' ),
					'custom' => esc_html__( 'Custom', 'kitestudio-core' ),
				),
				'default'     => 'all',
			)
		);
		$this->add_control(
			'blog_category',
			array(
				'label'       => esc_html__( 'Category', 'kitestudio-core' ),
				'label_block' => true,
				'multiple'    => true,
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $posts_cats,
				'default'     => '',
				'condition'   => array(
					'blog_filter' => 'custom',
				),
			)
		);
		$this->add_control(
			'blog_style',
			array(
				'label'   => esc_html__( 'Blog Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'inline_interaction' => esc_html__( 'Inline interaction', 'kitestudio-core' ),
					'popup_interaction'  => esc_html__( 'Pop-up interaction', 'kitestudio-core' ),
				),
				'default' => 'inline_interaction',
			)
		);
		$this->add_control(
			'blog_layout_mode',
			array(
				'label'   => esc_html__( 'Layout Mode', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'masonry' => esc_html__( 'Masonry', 'kitestudio-core' ),
					'fitRows' => esc_html__( 'Fit Rows', 'kitestudio-core' ),
				),
				'default' => 'masonry',
			)
		);
		$this->add_control(
			'blog_image_size',
			array(
				'label'   => esc_html__( 'Image size', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'large'  => esc_html__( 'Large', 'kitestudio-core' ),
					'scaled' => esc_html__( 'Scaled', 'kitestudio-core' ),
					'custom' => esc_html__( 'Custom', 'kitestudio-core' ),
				),
				'default' => 'large',
			)
		);
		$this->add_control(
			'blog_image_size_width',
			array(
				'label'       => esc_html__( 'Image Size Width', 'kitestudio-core' ),
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'blog_image_size' => 'custom',
				),
			)
		);

		$this->add_control(
			'blog_image_size_height',
			array(
				'label'       => esc_html__( 'Image Size Height', 'kitestudio-core' ),
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'blog_image_size' => 'custom',
				),
			)
		);

		$this->add_control(
			'blog_image_size_crop',
			array(
				'label'        => esc_html__( 'Crop Image', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'blog_image_size' => 'custom',
				),
			)
		);
		$this->add_control(
			'blog_post_number',
			array(
				'label'      => esc_html__( 'Number of posts', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'num' ),
				'range'      => array(
					'num' => array(
						'min'  => 1,
						'max'  => 30,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'num',
					'size' => 16,
				),
			)
		);
		$this->add_control(
			'blog_category_author',
			array(
				'label'   => esc_html__( 'Blog Author & Comments', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'yes' => esc_html__( 'Visible', 'kitestudio-core' ),
					'no'  => esc_html__( 'Invisible', 'kitestudio-core' ),
				),
				'default' => 'yes',
			)
		);
		$this->add_control(
			'blog_category_visibility',
			array(
				'label'   => esc_html__( 'Category Visibility', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'yes' => esc_html__( 'Visible', 'kitestudio-core' ),
					'no'  => esc_html__( 'Invisible', 'kitestudio-core' ),
				),
				'default' => 'yes',
			)
		);
		$this->add_control(
			'blog_foreground_color',
			array(
				'label'       => esc_html__( 'Text Color', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
				),
				'default'     => 'dark',
				'description' => esc_html__( 'Choose dark or light style of text', 'kitestudio-core' ),
			)
		);
		$this->add_control(
			'blog_more_button',
			array(
				'label'        => esc_html__( 'Disable Load More Button', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'No', 'kitestudio-core' ),
				'return_value' => 'disable',
				'default'      => 'disable',
			)
		);
		$this->add_control(
			'load_more_style',
			array(
				'label'     => esc_html__( 'Load more style', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'dark'       => esc_html__( 'Dark', 'kitestudio-core' ),
					'lightstyle' => esc_html__( 'Light', 'kitestudio-core' ),
				),
				'default'   => 'dark',
				'condition' => array(
					'blog_more_button' => '',
				),
			)
		);
		$this->add_control(
			'blog_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .blog-masonry-container' => 'background-color:{{VALUE}}',
					'{{WRAPPER}} .blog-masonry-container .blog-masonry-content .like-count,{{WRAPPER}} .blog-masonry-container .blog-masonry-content .post-share:hover .share-hover i' => 'color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'quote_blog_background_color',
			array(
				'label'     => esc_html__( 'Quote Post Background Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#073B87',
				'selectors' => array(
					'{{WRAPPER}} .blog-masonry-container.kt_quote' => 'background-color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'quote_blog_text_color',
			array(
				'label'     => esc_html__( 'Quote Post text Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => array(
					'{{WRAPPER}} .blog-masonry-container.kt_quote .icon, {{WRAPPER}} .blog-masonry-container.kt_quote .blog-masonry-content .blog-excerpt,{{WRAPPER}} .blog-masonry-container.kt_quote .blog-masonry-content .quote-author' => 'color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'blog_multimedia_icon_style',
			array(
				'label'   => esc_html__( 'Video & sound icon style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
				),
				'default' => 'light',
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
					'fadein'           => esc_html__( 'FadeIn', 'kitestudio-core' ),
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

	}

	/**
	 * Render Blog widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( is_array( $settings['blog_category'] ) ) {
			$blog_category = implode( ',', $settings['blog_category'] );
		} else {
			$blog_category = $settings['blog_category'];
		}

		$atts = [
			'blog_column' =>  $settings['blog_column']  ,
			'blog_filter' =>  $settings['blog_filter']  ,
			'blog_category' => $blog_category,
			'blog_style' =>  $settings['blog_style']  ,
			'blog_layout_mode' =>  $settings['blog_layout_mode']  ,
			'blog_post_number' =>  $settings['blog_post_number']['size']  ,
			'blog_category_author' =>  $settings['blog_category_author']  ,
			'blog_category_visibility' =>  $settings['blog_category_visibility']  ,
			'blog_foreground_color' =>  $settings['blog_foreground_color']  ,
			'blog_more_button' =>  $settings['blog_more_button']  ,
			'load_more_style' =>  $settings['load_more_style']  ,
			'blog_background_color' =>  $settings['blog_background_color']  ,
			'quote_blog_background_color' =>  $settings['quote_blog_background_color']  ,
			'quote_blog_text_color' =>  $settings['quote_blog_text_color']  ,
			'blog_multimedia_icon_style' =>  $settings['blog_multimedia_icon_style']  ,
			'enterance_animation' =>  $settings['enterance_animation']  ,
			'responsive_animation' =>  $settings['responsive_animation']  ,
		];

		if ( $settings['blog_image_size'] == 'custom' ) {
			$atts['blog_image_size'] = 'custom';
			$atts['blog_image_size_width'] =  $settings['blog_image_size_width'] ;
			$atts['blog_image_size_height'] =  $settings['blog_image_size_height'] ;
			$atts['blog_image_size_crop'] =  $settings['blog_image_size_crop'] ;
		} else {
			$atts['blog_image_size'] =  $settings['blog_image_size'] ;
		}

		echo kite_sc_blog_masonry( $atts );
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
		if ( is_array( $settings['blog_category'] ) ) {
			$blog_category = implode( ',', $settings['blog_category'] );
		} else {
			$blog_category = $settings['blog_category'];
		}
		echo '[kt_masonry_blog blog_column="' . esc_attr( $settings['blog_column'] ) . '" blog_filter="' . esc_attr( $settings['blog_filter'] ) . '" blog_category="' . esc_attr( $blog_category ) . '" blog_style="' . esc_attr( $settings['blog_style'] ) . '" blog_layout_mode="' . esc_attr( $settings['blog_layout_mode'] ) . '" blog_image_size="' . esc_attr( $settings['blog_image_size'] ) . '" blog_post_number="' . esc_attr( $settings['blog_post_number']['size'] ) . '" blog_category_author="' . esc_attr( $settings['blog_category_author'] ) . '" blog_category_visibility="' . esc_attr( $settings['blog_category_visibility'] ) . '" blog_foreground_color="' . esc_attr( $settings['blog_foreground_color'] ) . '" blog_more_button="' . esc_attr( $settings['blog_more_button'] ) . '" load_more_style="' . esc_attr( $settings['load_more_style'] ) . '" blog_background_color="' . esc_attr( $settings['blog_background_color'] ) . '" quote_blog_background_color="' . esc_attr( $settings['quote_blog_background_color'] ) . '" quote_blog_text_color="' . esc_attr( $settings['quote_blog_text_color'] ) . '" blog_multimedia_icon_style="' . esc_attr( $settings['blog_multimedia_icon_style'] ) . '" enterance_animation="' . esc_attr( $settings['enterance_animation'] ) . '" responsive_animation="' . esc_attr( $settings['responsive_animation'] ) . '"]';

	}

	protected function content_template() {

	}
}
