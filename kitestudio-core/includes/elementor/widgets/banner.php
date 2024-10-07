<?php
/**
 * Elementor Banner Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Banner_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Banner widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-banner';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Banner widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Banner', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Banner widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-info-box kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Animated Text widget belongs to.
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
		return array( 'kite-banner' );
	}

	/**
	 * load dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'kite-banner',
		);
	}

	/**
	 * Register Animated Text widget controls.
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
				'label' => esc_html__( 'Banner', 'kitestudio-core' ),
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
					'large'     => esc_html__( 'Large', 'kitestudio-core' ),
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
			'heading',
			array(
				'label' => esc_html__( 'Heading', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Heading Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .content .heading',
			)
		);
		$this->add_control(
			'heading_color',
			array(
				'label'     => esc_html__( 'Heading Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .content .heading' => 'color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title',
			array(
				'label' => esc_html__( 'Title', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
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
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .content .title' => 'color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'subtitle',
			array(
				'label' => esc_html__( 'Subtitle', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
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
				'selector' => '{{WRAPPER}} .content .subtitle',
			)
		);
		$this->add_control(
			'subtitle_color',
			array(
				'label'     => esc_html__( 'Subtitle Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .content .subtitle' => 'color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'badge',
			array(
				'label'        => esc_html__( 'Badge', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => '',
			)
		);
		$this->add_control(
			'badge_position',
			array(
				'label'     => esc_html__( 'Badge Position', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'top left'     => esc_html__( 'Top Left', 'kitestudio-core' ),
					'top right'    => esc_html__( 'Top Right', 'kitestudio-core' ),
					'bottom left'  => esc_html__( 'Bottom Left', 'kitestudio-core' ),
					'bottom right' => esc_html__( 'Bottom Right', 'kitestudio-core' ),
				),
				'default'   => 'top left',
				'condition' => array(
					'badge' => 'enable',
				),
			)
		);
		$this->add_control(
			'badge_bg_color',
			array(
				'label'     => esc_html__( 'Badge Background Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'badge' => 'enable',
				),
			)
		);
		$this->add_control(
			'badge_content',
			array(
				'label'     => esc_html__( 'Badge Content', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::TEXTAREA,
				'condition' => array(
					'badge' => 'enable',
				),
			)
		);
		$this->add_control(
			'badge_content_color',
			array(
				'label'     => esc_html__( 'Badge Content Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'badge' => 'enable',
				),
			)
		);
		$this->add_control(
			'alignment',
			array(
				'label'   => esc_html__( 'Content Position', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'top_left'      => esc_html__( 'Top Left', 'kitestudio-core' ),
					'top_center'    => esc_html__( 'Top Center', 'kitestudio-core' ),
					'top_right'     => esc_html__( 'Top Right', 'kitestudio-core' ),
					'center_center' => esc_html__( 'Center Center', 'kitestudio-core' ),
					'center_left'   => esc_html__( 'Center Left', 'kitestudio-core' ),
					'center_right'  => esc_html__( 'Center Right', 'kitestudio-core' ),
					'bottom_left'   => esc_html__( 'Bottom Left', 'kitestudio-core' ),
					'bottom_center' => esc_html__( 'Bottom Center', 'kitestudio-core' ),
					'bottom_right'  => esc_html__( 'Bottom Right', 'kitestudio-core' ),
				),
				'default' => 'top_left',
			)
		);
		$this->add_responsive_control(
			'margin',
			array(
				'label'      => esc_html__( 'Content Margin', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .banner .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'hover',
			array(
				'label'        => esc_html__( 'Hover', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'enable',
			)
		);
		$this->add_control(
			'hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .banner:hover .hover' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'hover' => 'enable',
				),
			)
		);
		$this->add_control(
			'hover_zoom',
			array(
				'label'        => esc_html__( 'Hover Zoom Animation', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => 'disable',
				'condition'    => array(
					'hover' => 'enable',
				),
			)
		);
		$this->add_control(
			'url',
			array(
				'label'       => esc_html__( 'Link', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::URL,
				'description' => esc_html__( 'Optional URL to another web page.', 'kitestudio-core' ),
			)
		);
		$this->add_control(
			'url_title',
			array(
				'label'       => esc_html__( 'Link Title', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( 'Optional URL to another web page.', 'kitestudio-core' ),
			)
		);
		$this->add_control(
			'link_color',
			array(
				'label'     => esc_html__( 'Link Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .banner a span,{{WRAPPER}} .banner a.link span:after' => 'color:{{VALUE}}; border-bottom-color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'button_style',
			array(
				'label'   => esc_html__( 'Button Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'link' => esc_html__( 'Link Style', 'kitestudio-core' ),
					'fill' => esc_html__( 'Button Fill Style', 'kitestudio-core' ),
				),
				'default' => 'link',
			)
		);
		$this->add_control(
			'link_bg_color',
			array(
				'label'     => esc_html__( 'Link Background Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'button_style' => 'fill',
				),
				'selectors' => array(
					'{{WRAPPER}} .banner a.fill' => 'background-color:{{VALUE}}; border-color: {{VALUE}} !important',
				),
			)
		);
		$this->add_control(
			'link_bg_hover_color',
			array(
				'label'     => esc_html__( 'Link Background Hover Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'button_style' => 'fill',
				),
				'selectors' => array(
					'{{WRAPPER}} .banner a.fill:hover' => 'background-color:{{VALUE}} !important;border-color: {{VALUE}} !important',
				),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'link_typography',
				'label'     => __( 'Link Typography', 'kitestudio-core' ),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} a',
				'condition' => array(
					'button_style' => 'link',
				),
			)
		);
		$this->add_control(
			'show_button',
			array(
				'label'        => esc_html__( 'Show Button on release style', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Disable', 'kitestudio-core' ),
				'return_value' => 'enable',
				'default'      => '',
			)
		);
		$this->add_control(
			'size',
			array(
				'label'     => esc_html__( 'Button Size', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'default'  => esc_html__( 'Default', 'kitestudio-core' ),
					'small'    => esc_html__( 'Small', 'kitestudio-core' ),
					'standard' => esc_html__( 'Medium', 'kitestudio-core' ),
					'large'    => esc_html__( 'Large', 'kitestudio-core' ),
				),
				'default'   => 'default',
				'condition' => array(
					'button_style' => 'fill',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'banner_border',
				'label'    => __( 'Banner Border', 'kitestudio-core' ),
				'selector' => '{{WRAPPER}} .banner',
			)
		);

		$this->add_responsive_control(
			'banner_border_radius',
			array(
				'label'      => esc_html__( 'Banner Border Radius', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .banner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render Animated Text widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		
		$atts = [
			'image_url' =>  $settings['image_url']['id']  ,
			'heading' => $settings['heading'] ,
			'heading_color' =>  $settings['heading_color']  ,
			'title' =>  $settings['title']  ,
			'title_color' =>  $settings['title_color']  ,
			'subtitle' => $settings['subtitle'],
			'subtitle_color' =>  $settings['subtitle_color'] ?? '' ,
			'alignment' =>  $settings['alignment']  ,
			'url' =>  $settings['url']['url']  ,
			'new_tab' =>  $settings['url']['is_external']  ,
			'url_title' => $settings['url_title'],
			'link_color' =>  $settings['link_color']  ,
			'link_bg_color' =>  $settings['link_bg_color'] ?? '' ,
			'button_style' =>  $settings['button_style']  ,
			'show_button' =>  $settings['show_button']  ,
			'size' =>  $settings['size']  ,
			'heading_size' => 'custom' ,
			'title_size' => 'custom' ,
			'subtitle_size' => 'custom' ,
			'link_size' => 'custom' ,
		];

		if ( $settings['image_size'] == 'custom' ) {
			$atts['image_size'] = 'custom';
			$atts['image_size_width'] =  $settings['image_size_width'] ;
			$atts['image_size_height'] =  $settings['image_size_height'] ;
			$atts['image_size_crop'] =  $settings['image_size_crop'] ;
		} else {
			$atts['image_size'] =  $settings['image_size'] ;
		}

		if ( $settings['hover'] == 'enable' ) {
			$atts['hover'] = 'enable';
			$atts['hvoer_color_preset'] = 'custom';
			$atts['hover_color'] =  $settings['hover_color'] ?? '' ;
			$atts['hover_zoom'] =  $settings['hover_zoom'] ;
		} else {
			$atts['hover'] = 'disable';;
		}

		if ( $settings['badge'] == 'enable' ) {
			$atts['badge'] = 'enable';
			$atts['badge_content'] =  $settings['badge_content'] ;
			$atts['badge_bg_color'] =  $settings['badge_bg_color'] ;
			$atts['badge_content_color'] =  $settings['badge_content_color'] ;
			$atts['badge_position'] =  $settings['badge_position'] ;
		} else {
			$atts['badge'] = 'disable';;
		}
		
		echo kite_sc_banner( $atts );
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

		if ( $settings['hover'] == 'enable' ) {
			$hover = 'hover="enable" hover_color_preset="custom" hover_color="' . esc_attr( $settings['hover_color'] ) . '" hover_zoom="' . esc_attr( $settings['hover_zoom'] ) . '"';
		} else {
			$hover = 'hover="disable"';
		}

		if ( $settings['badge'] == 'enable' ) {
			$badge = 'badge="enable" badge_content="' . esc_attr( $settings['badge_content'] ) . '" badge_bg_color="' . esc_attr( $settings['badge_bg_color'] ) . '" badge_content_color="' . esc_attr( $settings['badge_content_color'] ) . '" badge_position="' . esc_attr( $settings['badge_position'] ) . '"';
		} else {
			$badge = 'badge="disable"';
		}
		echo '[banner image_url="' . esc_attr( $settings['image_url']['id'] ) . '" ' . esc_html( $image_size ) . ' heading="' . wp_kses_post( $settings['heading'] ) . '" heading_color="' . esc_attr( $settings['heading_color'] ) . '" title="' . esc_attr( $settings['title'] ) . '" title_color="' . esc_attr( $settings['title_color'] ) . '" subtitle="' . wp_kses_post( $settings['subtitle'] ) . '" subtitle_color="' . esc_attr( $settings['subtitle_color'] ) . '" alignment="' . esc_attr( $settings['alignment'] ) . '" ' . esc_html( $hover ) . ' url="' . esc_attr( $settings['url']['url'] ) . '" new_tab="' . esc_attr( $settings['url']['is_external'] ) . '" url_title="' . wp_kses_post( $settings['url_title'] ) . '" link_color="' . esc_attr( $settings['link_color'] ) . '" link_bg_color="' . esc_attr( $settings['link_bg_color'] ) . '" button_style="' . esc_attr( $settings['button_style'] ) . '" show_button="' . esc_attr( $settings['show_button'] ) . '" size="' . esc_attr( $settings['size'] ) . '" ' . esc_html( $badge ) . ' heading_size="custom" title_size="custom" subtitle_size="custom" link_size="custom"]';

	}

	protected function content_template() {
		?>
		<#
		let container_class = 'banner ';
		container_class += (settings.image_url.url == '') ? ' no-image ' : '';
		container_class += settings.alignment;
		container_class += (settings.url_title != '' && settings.url.url != '') ? ' has_button ' : '';
		container_class += (settings.url_title != '' && settings.url.url != '' && settings.show_button == 'enable') ? ' show_button ' : '';
		container_class += (settings.hover_zoom != 'enable') ? '' : ' zoom ';

		view.addRenderAttribute('banner-container','class',[container_class]);
		var html = '<div ' + view.getRenderAttributeString('banner-container') + '>';
			if (settings.image_url.url != "") {
				html += '<div class="image">';
					if (settings.hover == 'enable') { 
						html += '<div class="hover"></div>';
					}
					html += '<img src="' + settings.image_url.url + '" alt="' + settings.title + '">';
				html += '</div>';
			}
			html += '<div class="content-container">';
				if (settings.badge == 'enable') {
					view.addRenderAttribute('badge','class','badge '+settings.badge_position);
					html += '<div ' + view.getRenderAttributeString('badge') + '><span style="white-space:pre;">' + settings.badge_content + '</span></div>';
				}
				html += '<div class="content">';
					if (settings.heading != "") {
						view.addRenderAttribute('heading','class','heading clearfix');
						view.addInlineEditingAttributes('heading','none');
						html += '<span ' + view.getRenderAttributeString('heading') + '>' + settings.heading + '</span>';
					}
					if (settings.title != "") {
						view.addRenderAttribute('title','class','title clearfix');
						view.addInlineEditingAttributes('title','none');
						html += '<span ' + view.getRenderAttributeString('title') + '>' + settings.title + '</span>';
					}
					if (settings.subtitle != "") {
						view.addRenderAttribute('subtitle','class','subtitle');
						view.addInlineEditingAttributes('subtitle','none');
						html += '<span ' + view.getRenderAttributeString('subtitle') + '>' + settings.subtitle + '</span>';
					}
					if (settings.url.url != "" ) {
						let button_class = '';
						let button_size = (settings.size == 'standard') ? 'button-medium' : ((settings.size != "") ? 'button-'+settings.size:'');
						button_class += (settings.button_style == 'fill') ? 'kt_button style2 text '+button_size : '';
						let target = (settings.url.is_external) ? "_blank" : "_self";
						let link_style = (settings.url_title != "") ? '':'display:none;';
						view.addRenderAttribute(
							'link',
							{
								class: [button_class] + ' ' + settings.button_style,
								href: settings.url.url,
								target: [target],
								style: [link_style]
							}
						);
						view.addRenderAttribute('link_text','class','txt');
						view.addInlineEditingAttributes('link_text','none');

						html += '<a ' + view.getRenderAttributeString('link') + '>';
							html += '<span ' + view.getRenderAttributeString('link_text') + '>' + settings.url_title + '</span>';
						html += '</a>';
					}
				html += '</div>';
			html += '</div>';
		html += '</div>';
		print(html);
		#>
		<?php
	}
}
