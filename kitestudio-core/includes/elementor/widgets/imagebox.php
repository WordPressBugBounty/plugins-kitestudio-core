<?php
/**
 * Elementor ImageBox Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_ImageBox_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve ImageBox widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-image-box';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve ImageBox widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Image Box', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve ImageBox widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image-bold kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the ImageBox widget belongs to.
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
			'kite-image-box',
		);
	}

	/**
	 * Register ImageBox widget controls.
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
				'label' => esc_html__( 'Image Box', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'image_url',
			array(
				'label'   => esc_html__( 'Image URL', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);
		$this->add_control(
			'image_size',
			array(
				'label'   => esc_html__( 'Image Size', 'kitestudio-core' ),
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
				'default'      => 'yes',
				'condition'    => array(
					'image_size' => 'custom',
				),
			)
		);
		$this->add_control(
			'image_hover',
			array(
				'label'       => esc_html__( 'Image Hover', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'enable'  => esc_html__( 'Enable', 'kitestudio-core' ),
					'disable' => esc_html__( 'Disable', 'kitestudio-core' ),
				),
				'default'     => 'enable',
				'description' => esc_html__( 'You can Enable Or Disable ImageBox hover', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'image_hover_shadow',
			array(
				'label'       => esc_html__( 'Image Hover Shadow', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'enable'  => esc_html__( 'Enable', 'kitestudio-core' ),
					'disable' => esc_html__( 'Disable', 'kitestudio-core' ),
				),
				'default'     => 'disable',
				'description' => esc_html__( 'You can Enable Or Disable ImageBox hover shadow', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'image_hover_color_custom',
			array(
				'label'     => esc_html__( 'Image Hover Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'condition' => array(
					'image_hover' => 'enable',
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'kitestudio-core' ),
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'title_color',
			array(
				'label'   => esc_html__( 'Title Color', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#cccccc',
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
				'selector' => '{{WRAPPER}} .content .title',
			)
		);
		$this->add_control(
			'subtitle',
			array(
				'label'       => esc_html__( 'Subtitle', 'kitestudio-core' ),
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'subtitle_color',
			array(
				'label'   => esc_html__( 'Subtitle Color', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#cccccc',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'subtitle_typography',
				'label'    => esc_html__( 'Subtitle Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .content .title .subtitle',
			)
		);
		$this->add_control(
			'vccontent',
			array(
				'label'       => esc_html__( 'Text', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
			)
		);
		$this->add_control(
			'image_text_color',
			array(
				'label'   => esc_html__( 'Image Text Color', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#cccccc',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'label'    => esc_html__( 'Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .content .text',
			)
		);
		$this->add_control(
			'image_text_align',
			array(
				'label'   => esc_html__( 'Text align', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'left'   => esc_html__( 'Left', 'kitestudio-core' ),
					'right'  => esc_html__( 'Right', 'kitestudio-core' ),
					'center' => esc_html__( 'Center', 'kitestudio-core' ),
				),
				'default' => 'left',
			)
		);
		$this->add_control(
			'image_text_background_color',
			array(
				'label'   => esc_html__( 'Image Text Background Color', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#fff',
			)
		);
		$this->add_control(
			'imagebox_content_border',
			array(
				'label'   => esc_html__( 'Content Border', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'enable'  => esc_html__( 'Enable', 'kitestudio-core' ),
					'disable' => esc_html__( 'Disable', 'kitestudio-core' ),
				),
				'default' => 'enable',
			)
		);
		$this->add_control(
			'image_text_border_color',
			array(
				'label'     => esc_html__( 'Image Text Border Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'condition' => array(
					'imagebox_content_border' => 'enable',
				),
			)
		);
		$this->add_control(
			'url',
			array(
				'label'         => esc_html__( 'Link', 'kitestudio-core' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'kitestudio-core' ),
				'show_external' => true,
				'default'       => array(
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				),
			)
		);
		$this->end_controls_section();

	}

	/**
	 * Render ImageBox widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$atts = [
			'image_url' => $settings['image_url']['id'],
			'image_hover' => $settings['image_hover'],
			'image_hover_shadow' => $settings['image_hover_shadow'],
			'image_hover_color_preset' => 'custom' ,
			'image_hover_color_custom' => $settings['image_hover_color_custom'] ,
			'title' => $settings['title'],
			'title_color' => $settings['title_color'],
			'subtitle' => $settings['subtitle'],
			'subtitle_color' => $settings['subtitle_color'],
			'vccontent' => $settings['vccontent'],
			'image_text_color' => $settings['image_text_color'],
			'image_text_align' => $settings['image_text_align'],
			'image_text_background_color' => $settings['image_text_background_color'],
			'image_title_size' => 'custom' ,
			'content_fontsize' => 'custom' ,
			'subtitle_fontsize' => 'custom' ,
			'url' => $settings['url']['url']
		];

		if ( ! empty( $settings['url']['url'] ) && $settings['url']['is_external'] ) {
			$atts['target'] = '_blank';
		} else {
			$atts['target'] = '_self';
		}

		if ( $settings['image_size'] == 'custom' ) {
			$atts['image_size'] = 'custom';
			$atts['image_size_width'] =  $settings['image_size_width'] ;
			$atts['image_size_height'] =  $settings['image_size_height'] ;
			$atts['image_size_crop'] =  $settings['image_size_crop'] ;
		} else {
			$atts['image_size'] =  $settings['image_size'] ;
		}

		if ( $settings['imagebox_content_border'] == 'enable' ) {
			$atts['imagebox_content_border'] = 'enable';
			$atts['image_text_border_color'] =  $settings['image_text_border_color'] ;
		} else {
			$atts['imagebox_content_border'] = 'disable';
		}

		echo kite_sc_imagebox( $atts );
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
			$image_size = 'image_size="custom" image_size_width="' . $settings['image_size_width'] . '" image_size_height="' . $settings['image_size_height'] . '" image_size_crop="' . $settings['image_size_crop'] . '"';
		} else {
			$image_size = 'image_size="' . $settings['image_size'] . '"';
		}

		if ( $settings['imagebox_content_border'] == 'enable' ) {
			$border = 'imagebox_content_border="enable" image_text_border_color="' . $settings['image_text_border_color'] . '"';
		} else {
			$border = 'imagebox_content_border="disable"';
		}

		if ( ! empty( $settings['url']['url'] ) && $settings['url']['is_external'] ) {
			$url = 'url="' . $settings['url']['url'] . '" target="_blank"';
		} else {
			$url = 'url="' . $settings['url']['url'] . '" target="_self"';
		}

		echo '[imagebox image_url="' . $settings['image_url']['id'] . '" ' . $image_size . ' image_hover="' . $settings['image_hover'] . '" image_hover_shadow="' . $settings['image_hover_shadow'] . '" image_hover_color_preset="custom" image_hover_color_custom="' . $settings['image_hover_color_custom'] . '" title="' . $settings['title'] . '" title_color="' . $settings['title_color'] . '" subtitle="' . $settings['subtitle'] . '" subtitle_color="' . $settings['subtitle_color'] . '" vccontent="' . $settings['vccontent'] . '" image_text_color="' . $settings['image_text_color'] . '" image_text_align="' . $settings['image_text_align'] . '" image_text_background_color="' . $settings['image_text_background_color'] . '" ' . $border . ' ' . $url . ' image_title_size="custom" content_fontsize="custom" subtitle_fontsize="custom"]';

	}

	protected function content_template() {

	}
}
