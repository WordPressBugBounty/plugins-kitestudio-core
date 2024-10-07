<?php
/**
 * Elementor Icon Box Creative Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Icon_Box_Creative_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Icon Box Creative widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-icon-box-creative';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Icon Box Creative widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Icon Box Creative', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Icon Box Creative widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-favorite kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Icon Box Creative widget belongs to.
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
			'kite-custom-iconbox',
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
		return array( 'kite-icon-box' );
	}

	/**
	 * Register Icon Box Creative widget controls.
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
				'label' => esc_html__( 'Icon Box Creative', 'kitestudio-core' ),
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
			'title_color',
			array(
				'label'     => esc_html__( 'Title color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .icon-container h3.title' => 'color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'content_text',
			array(
				'label' => esc_html__( 'Content', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
			)
		);
		$this->add_control(
			'new_icon',
			array(
				'label' => esc_html__( 'Icon', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::ICONS,
			)
		);
		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .icon-container .glyph' => 'color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'border_color',
			array(
				'label'     => esc_html__( 'Border color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .icon-container' => 'border-color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'bg_color',
			array(
				'label'     => esc_html__( 'Background color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .custom-iconbox' => 'background-color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'bg_hover_color',
			array(
				'label'     => esc_html__( 'Background Hover Color ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .overlay:before' => 'background-color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'text_color_hover_state',
			array(
				'label'     => esc_html__( 'Text color in hover state ', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .hover-content .title' => 'color:{{VALUE}}',
					'{{WRAPPER}} .hover-content .content-wrap .content' => 'color:{{VALUE}}',
					'{{WRAPPER}} .hover-content .content-wrap .more-link a' => 'color:{{VALUE}}',
					'{{WRAPPER}} .hover-content .content-wrap .more-link a:before' => 'background-color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'image',
			array(
				'label'     => esc_html__( 'Hover background image', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'selectors' => array(
					'{{WRAPPER}} .hover-content' => 'background:url({{URL}})',
				),
			)
		);
		$this->add_control(
			'hover_style',
			array(
				'label'   => esc_html__( 'Hover style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'style1' => esc_html__( 'Style 1', 'kitestudio-core' ),
					'style2' => esc_html__( 'Style 2', 'kitestudio-core' ),
				),
				'default' => 'style1',
			)
		);
		$this->add_control(
			'url',
			array(
				'label'         => esc_html__( 'Link', 'kitestudio-core' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'show_external' => true,
				'default'       => array(
					'url' => '#',
				),
			)
		);
		$this->add_control(
			'elementor_link_title',
			array(
				'label'   => esc_html__( 'Link Title', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);
		$this->add_control(
			'whole_box_link',
			array(
				'label'        => esc_html__( 'Whole Icon box Link', 'kitestudio-core' ),
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
	 * Render Icon Box Creative widget output on the frontend.
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

		$settings['whole_box_link'] = ( $settings['whole_box_link'] == 'enable' ) ? 'enable' : 'disable';
		$atts = [
			'title' =>  $settings['title']  ,
			'title_color' =>  $settings['title_color']  ,
			'icon' =>  $icon  ,
			'icon_color' =>  $settings['icon_color']  ,
			'url' =>  $settings['url']['url']  ,
			'new_tab' =>  $settings['url']['is_external']  ,
			'elementor_link_title' =>  $settings['elementor_link_title']  ,
			'whole_box_link' =>  $settings['whole_box_link']  ,
			'content_text' =>  $settings['content_text']  ,
			'border_color' =>  $settings['border_color']  ,
			'bg_color' =>  $settings['bg_color']  ,
			'bg_hover_color' =>  $settings['bg_hover_color']  ,
			'hover_style' =>  $settings['hover_style']  ,
			'image' =>  $settings['image']['id']  ,
		];

		echo kite_sc_iconbox_custom( $atts );
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

		echo '[iconbox_custom title="' . esc_attr( $settings['title'] ) . '" title_color="' . esc_attr( $settings['title_color'] ) . '" icon="' . esc_attr( $icon ) . '" icon_color="' . esc_attr( $settings['icon_color'] ) . '" url="' . esc_attr( $settings['url']['url'] ) . '" new_tab="' . esc_attr( $settings['url']['is_external'] ) . '" elementor_link_title="' . esc_attr( $settings['elementor_link_title'] ) . '" whole_box_link="' . esc_attr( $settings['whole_box_link'] ) . '" content_text="' . esc_attr( $settings['content_text'] ) . '" border_color="' . esc_attr( $settings['border_color'] ) . '" bg_color="' . esc_attr( $settings['bg_color'] ) . '" bg_hover_color="' . esc_attr( $settings['bg_hover_color'] ) . '" hover_style="' . esc_attr( $settings['hover_style'] ) . '" image="' . esc_attr( $settings['image']['id'] ) . '"]';

	}

	protected function content_template() {

	}
}
