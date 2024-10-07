<?php
/**
 * Elementor Custom Title Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Custom_Title_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Custom Title widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-custom-title';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Custom Title widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Custom Title', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Custom Title widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'icon icon-header kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Custom Title widget belongs to.
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
			'kite-custom-title',
		);
	}

	/**
	 * Register Custom Title widget controls.
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
				'label' => esc_html__( 'Custom Title', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'title',
			array(
				'label' => esc_html__( 'Title', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
			)
		);
		$this->add_control(
			'title_fontsize',
			array(
				'label'   => esc_html__( 'Title Font Size', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'1'  => '1',
					'2'  => '2',
					'3'  => '3',
					'4'  => '4',
					'6'  => '6',
					'8'  => '8',
					'10' => '10',
					'12' => '12',
					'14' => '14',
					'16' => '16',
					'18' => '18',
				),
				'default' => '2',
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
				'selector' => '{{WRAPPER}} div.title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'   => esc_html__( 'Title color ', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '',
			)
		);
		$this->add_control(
			'title_background_style',
			array(
				'label'   => esc_html__( 'Title Background Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'iconbackground'  => esc_html__( 'Icon Background', 'kitestudio-core' ),
					'shapebackground' => esc_html__( 'Shape Background', 'kitestudio-core' ),
					'textbackground'  => esc_html__( 'text Background', 'kitestudio-core' ),
				),
				'default' => 'iconbackground',
			)
		);
		$this->add_control(
			'bg_title',
			array(
				'label'     => esc_html__( 'Background Title', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => array(
					'title_background_style' => 'textbackground',
				),
			)
		);
		$this->add_control(
			'bg_title_font_size',
			array(
				'label'     => esc_html__( 'Background Title Font Size', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'1'  => '1',
					'2'  => '2',
					'3'  => '3',
					'4'  => '4',
					'6'  => '6',
					'8'  => '8',
					'10' => '10',
					'12' => '12',
					'14' => '14',
					'16' => '16',
					'18' => '18',
					'20' => '20',
					'24' => '24',
				),
				'default'   => '1',
				'condition' => array(
					'title_background_style' => 'textbackground',
				),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'bg_title_typography',
				'label'     => esc_html__( 'Background Title Typography', 'kitestudio-core' ),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} span.textbackground',
				'condition' => array(
					'title_background_style' => 'textbackground',
				),
			)
		);
		$this->add_control(
			'bg_title_color',
			array(
				'label'     => esc_html__( 'Background title color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'title_background_style' => 'textbackground',
				),
			)
		);

		$this->add_control(
			'new_icon',
			array(
				'label'     => esc_html__( 'Icon', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'condition' => array(
					'title_background_style' => 'iconbackground',
				),
			)
		);
		$this->add_control(
			'bg_icon_color',
			array(
				'label'     => esc_html__( 'Background icon color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'title_background_style' => 'iconbackground',
				),
			)
		);
		$this->add_control(
			'style',
			array(
				'label'     => esc_html__( 'Title Background Style', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'line'           => esc_html__( 'Line', 'kitestudio-core' ),
					'circle'         => esc_html__( 'Circle', 'kitestudio-core' ),
					'square'         => esc_html__( 'Square', 'kitestudio-core' ),
					'rotated_square' => esc_html__( 'Rotated Square', 'kitestudio-core' ),
					'triangle'       => esc_html__( 'Triangle', 'kitestudio-core' ),
				),
				'default'   => 'line',
				'condition' => array(
					'title_background_style' => 'shapebackground',
				),
			)
		);
		$this->add_control(
			'hoverline_color',
			array(
				'label'     => esc_html__( 'Hover line color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'style' => 'line',
				),
			)
		);
		$this->add_control(
			'shape_border_color',
			array(
				'label'     => esc_html__( 'Shape border color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'style' => array( 'circle', 'square', 'rotated_square', 'triangle' ),
				),
			)
		);
		$this->add_control(
			'shape_fill_color',
			array(
				'label'     => esc_html__( 'Shape fill color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'style' => array( 'circle', 'square', 'rotated_square', 'triangle' ),
				),
			)
		);
		$this->end_controls_section();

	}

	/**
	 * Render Custom Title widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		// Check if its already migrated
		$migrated = isset( $settings['__fa4_migrated']['new_icon'] );
		// Check if its a new widget without previously selected icon using the old Icon control
		$is_new = empty( $settings['icon'] );
		if ( $is_new || $migrated ) {
			$icon = $settings['new_icon']['library'] == 'svg' ? '' : $settings['new_icon']['value'];
		} elseif ( isset( $settings['icon']['value'] ) ) {
			$icon = $settings['icon']['library'] == 'svg' ? '' : $settings['icon']['value'];
		} else {
			$icon = $settings['icon'];
		}

		$atts = [
			'title' =>  $settings['title']  ,
			'title_fontsize' =>  $settings['title_fontsize']  ,
			'title_color' =>  $settings['title_color']  ,
			'hoverline_color' =>  $settings['hoverline_color']  ,
			'title_background_style' =>  $settings['title_background_style']  ,
			'bg_title' =>  $settings['bg_title']  ,
			'bg_title_font_size' =>  $settings['bg_title_font_size']  ,
			'bg_title_color' =>  $settings['bg_title_color']  ,
			'bg_icon_color' =>  $settings['bg_icon_color']  ,
			'icon' =>  $icon  ,
			'shape_fill_color' =>  $settings['shape_fill_color']  ,
			'shape_border_color' =>  $settings['shape_border_color']  ,
			'style' =>  $settings['style']  ,
			'elementor' => 'elementor' ,
		];

		echo kite_sc_customTitle( $atts );
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

		// Check if its already migrated
		$migrated = isset( $settings['__fa4_migrated']['new_icon'] );
		// Check if its a new widget without previously selected icon using the old Icon control
		$is_new = empty( $settings['icon'] );
		if ( $is_new || $migrated ) {
			$icon = $settings['new_icon']['library'] == 'svg' ? '' : $settings['new_icon']['value'];
		} elseif ( isset( $settings['icon']['value'] ) ) {
			$icon = $settings['icon']['library'] == 'svg' ? '' : $settings['icon']['value'];
		} else {
			$icon = $settings['icon'];
		}

		echo '[custom_title title="' . esc_attr( $settings['title'] ) . '" title_fontsize="' . esc_attr( $settings['title_fontsize'] ) . '" title_color="' . esc_attr( $settings['title_color'] ) . '" hoverline_color="' . esc_attr( $settings['hoverline_color'] ) . '" title_background_style="' . esc_attr( $settings['title_background_style'] ) . '" bg_title="' . esc_attr( $settings['bg_title'] ) . '" bg_title_font_size="' . esc_attr( $settings['bg_title_font_size'] ) . '" bg_title_color="' . esc_attr( $settings['bg_title_color'] ) . '" bg_icon_color="' . esc_attr( $settings['bg_icon_color'] ) . '" icon="' . esc_attr( $icon ) . '" shape_fill_color="' . esc_attr( $settings['shape_fill_color'] ) . '" shape_border_color="' . esc_attr( $settings['shape_border_color'] ) . '" style="' . esc_attr( $settings['style'] ) . '" elementor="elementor"]';
	}

	protected function content_template() {

	}
}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Kite_Custom_Title_Widget() );
