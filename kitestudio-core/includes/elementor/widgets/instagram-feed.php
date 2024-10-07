<?php
/**
 * Elementor Instagram Feed Widget.
 *
 * @since 1.0.0
 */

use Elementor\Core\Breakpoints\Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Instagram_Feed_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Instagram Feed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-instagram-feed';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Instagram Feed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Instagram Feed', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Instagram Feed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Instagram Feed widget belongs to.
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
			'kite-instagram-feed'
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
			'kite-instagram',
		);
	}

	/**
	 * Register Instagram Feed widget controls.
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
				'label' => esc_html__( 'Instagram Feed', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'method',
			array(
				'label'        => esc_html__( 'Connection Method', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Api', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Ajax', 'kitestudio-core' ),
				'return_value' => 'api',
				'default'      => 'api',
				'description'  => esc_html__( 'Choose the way to get instagram medias. The best and trusted method is api.', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'user',
			array(
				'label'     => esc_html__( 'Username', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => array(
					'method!' => 'api',
				),
			)
		);

		$this->add_control(
			'posts_count',
			array(
				'label'      => esc_html__( 'Post count', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'num' ),
				'range'      => array(
					'num' => array(
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'num',
					'size' => 10,
				),
			)
		);
		$this->add_control(
			'image_resolution',
			array(
				'label'       => esc_html__( 'Image Resolution', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'thumbnail' => esc_html__( 'Thumbnail (150x150)', 'kitestudio-core' ),
					'medium'    => esc_html__( 'Medium', 'kitestudio-core' ),
					'large'     => esc_html__( 'Full size', 'kitestudio-core' ),
				),
				'default'     => 'thumbnail',
				'condition'   => array(
					'method!' => 'api',
				),
			)
		);
		$this->add_control(
			'carousel',
			array(
				'label'       => esc_html__( 'Carousel/Grid', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'disable' => esc_html__( 'Grid', 'kitestudio-core' ),
					'enable'  => esc_html__( 'Carousel', 'kitestudio-core' ),
				),
				'default'     => 'disable',
			)
		);
		$this->add_control(
			'column',
			array(
				'label'   => esc_html__( 'Columns', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
				'default' => '1',
				'condition'   => array(
					'carousel' => 'enable',
				),
			)
		);
		$this->add_responsive_control(
			'responsive_column',
			array(
				'label'   => esc_html__( 'Columns', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
				'default' => '4',
				"selectors" => [
					"{{WRAPPER}} .instagram-feed .instagramfeed div.instagram-img" => "max-width: calc(100% / {{VALUE}});flex: 0 0 calc( 100% /  {{VALUE}} - ( ( {{VALUE}} - 1 ) * var(--instagram-spacing) / {{VALUE}} ) ); margin: 0 !important;"
				],
				'condition'   => array(
					'carousel' => 'disable',
				),
			)
		);
		$this->add_responsive_control(
			'responsive_gap',
			array(
				'label'   => esc_html__( 'Gap', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				"selectors" => [
					"{{WRAPPER}} .instagram-feed .instagramfeed" => "gap: {{VALUE}}px;",
					'{{WRAPPER}} .instagram-feed .instagramfeed div.instagram-img' => '--instagram-spacing: {{VALUE}}px;'
				],
				'condition'   => array(
					'carousel' => 'disable',
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
				'description'  => esc_html__( 'Remove gutter between items', 'kitestudio-core' ),
				'condition'   => array(
					'carousel' => 'enable',
				),
			)
		);
		$this->add_control(
			'naxt_prev_btn',
			array(
				'label'       => esc_html__( 'Navigation Buttons Visibility', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'show' => esc_html__( 'Enable', 'kitestudio-core' ),
					'hide' => esc_html__( 'Disable', 'kitestudio-core' ),
				),
				'default'     => 'show',
				'condition'   => array(
					'carousel' => 'enable',
				),
			)
		);
		$this->add_control(
			'nav_style',
			array(
				'label'       => esc_html__( 'Navigations Style', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
				),
				'default'     => 'light',
				'condition'   => array(
					'naxt_prev_btn' => 'show',
				),
			)
		);
		$this->add_control(
			'custom_hover_color',
			array(
				'label'   => esc_html__( 'Custom hover Color', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '',
			)
		);
		$this->add_control(
			'like',
			array(
				'label'        => esc_html__( 'Like', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'disable',
				'description'  => esc_html__( 'Show likes count', 'kitestudio-core' ),
				'condition'    => array(
					'method!' => 'api',
				),
			)
		);
		$this->add_control(
			'comment',
			array(
				'label'        => esc_html__( 'Comment', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'disable',
				'description'  => esc_html__( 'Show comment count', 'kitestudio-core' ),
				'condition'    => array(
					'method!' => 'api',
				),
			)
		);
		$this->add_control(
			'eqaul_height_width',
			array(
				'label'        => esc_html__( 'Equal width and height image', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'enable',
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
	 * Render Instagram Feed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$atts = [
			'method' =>  $settings['method']  ,
			'user' =>  $settings['user']  ,
			'posts_count' =>  $settings['posts_count']['size']  ,
			'column' =>  $settings['column'] ?? 1  ,
			'image_resolution' =>  $settings['image_resolution']  ,
			'gutter' => $settings['gutter'] ?? 'no' ,
			'carousel' =>  $settings['carousel']  ,
			'naxt_prev_btn' =>  $settings['naxt_prev_btn']  ,
			'nav_style' =>  $settings['nav_style']  ,
			'custom_hover_color' =>  $settings['custom_hover_color']  ,
			'hover_color' => 'custom' ,
			'like' =>  $settings['like']  ,
			'comment' =>  $settings['comment']  ,
			'eqaul_height_width' =>  $settings['eqaul_height_width']  ,
			'enterance_animation' =>  $settings['enterance_animation']  ,
			'responsive_animation' =>  $settings['responsive_animation']  ,
		];

		echo kite_sc_instgram_feed( $atts );
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
		$settings = $this->get_settings_for_display();
		$column = $settings['column'] ?? 1;
		echo '[kt_instagram method="' . esc_attr( $settings['method'] ) . '" user="' . esc_attr( $settings['user'] ) . '" posts_count="' . esc_attr( $settings['posts_count']['size'] ) . '" column="' . esc_attr( $column ) . '" image_resolution="' . esc_attr( $settings['image_resolution'] ) . '" carousel="' . esc_attr( $settings['carousel'] ) . '" naxt_prev_btn="' . esc_attr( $settings['naxt_prev_btn'] ) . '" nav_style="' . esc_attr( $settings['nav_style'] ) . '" custom_hover_color="' . esc_attr( $settings['custom_hover_color'] ) . '" hover_color="custom" like="' . esc_attr( $settings['like'] ) . '" comment="' . esc_attr( $settings['comment'] ) . '" eqaul_height_width="' . esc_attr( $settings['eqaul_height_width'] ) . '" enterance_animation="' . esc_attr( $settings['enterance_animation'] ) . '" responsive_animation="' . esc_attr( $settings['responsive_animation'] ) . '"]';
	}

	protected function content_template() {

	}

	protected function get_gap_selectors() {
		
		$selectors_array = [
			"{{WRAPPER}} .instagram-feed .instagramfeed" => "gap: {{VALUE}}px;",
			"(desktop) {{WRAPPER}} .instagram-feed .instagramfeed div.instagram-img" => "flex: 0 0 calc( 100% /  {{responsive_column.VALUE}} - {{VALUE}}px); margin: 0 !important;" 
		];

		$breakpoints = new Manager();
		$active_breakpoints = $breakpoints->get_active_breakpoints();
		foreach( $active_breakpoints as $breakpoint_name => $breakpoint ) {
			$selectors_array[ "($breakpoint_name) {{WRAPPER}} .instagram-feed .instagramfeed div.instagram-img" ] = "flex: 0 0 calc( 100% /  {{responsive_column_$breakpoint_name.VALUE}} - {{responsive_gap_$breakpoint_name.VALUE}}px)";
		}

		return $selectors_array;
	}
}
