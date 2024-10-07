<?php
/**
 * Elementor Button Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Button_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Button widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-button';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Button widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Button', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Button widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-button kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Button widget belongs to.
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
		return array();
	}

	/**
	 * Register Button widget controls.
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
				'label' => esc_html__( 'Button', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'button_hover_style',
			array(
				'label'   => esc_html__( 'Buttons Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'style1'     => esc_html__( 'Style 1', 'kitestudio-core' ),
					'style2'     => esc_html__( 'Style 2', 'kitestudio-core' ),
					'link_style' => esc_html__( 'Link Style', 'kitestudio-core' ),
				),
				'default' => 'style2',
			)
		);
		$this->add_control(
			'button_bg_style',
			array(
				'label'     => esc_html__( 'Background Style', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'fill'        => esc_html__( 'Fill', 'kitestudio-core' ),
					'transparent' => esc_html__( 'Transparent', 'kitestudio-core' ),
				),
				'default'   => 'fill',
				'condition' => array(
					'button_hover_style' => array( 'style1', 'style2' ),
				),
			)
		);
		$this->add_control(
			'link_display_style',
			array(
				'label'     => esc_html__( 'Background Style', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'text' => esc_html__( 'Text', 'kitestudio-core' ),
					'icon' => esc_html__( 'Icon', 'kitestudio-core' ),
				),
				'default'   => 'text',
				'condition' => array(
					'button_hover_style' => 'link_style',
				),
			)
		);
		$this->add_control(
			'text',
			array(
				'label'     => esc_html__( 'Button Text', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => array(
					'button_hover_style' => array( 'style2', 'link_style' ),
				),
				'default'   => __( 'Button', 'kitestudio-core'),
			)
		);
		$this->add_control(
			'text_hover',
			array(
				'label'       => esc_html__( 'Button on Hover Text', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'button_hover_style' => 'style1',
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
			'size',
			array(
				'label'   => esc_html__( 'Size', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'default'  => esc_html__( 'Default', 'kitestudio-core' ),
					'small'    => esc_html__( 'Small', 'kitestudio-core' ),
					'standard' => esc_html__( 'Medium', 'kitestudio-core' ),
					'large'    => esc_html__( 'Large', 'kitestudio-core' ),
				),
				'default' => 'default',
			)
		);
		$this->add_control(
			'button_display',
			array(
				'label'   => esc_html__( 'Display', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'box'  => esc_html__( 'Box', 'kitestudio-core' ),
					'full' => esc_html__( 'Fullwidth', 'kitestudio-core' ),
				),
				'default' => 'box',
			)
		);

		$this->add_responsive_control(
			'responsive_alignment',
			array(
				'label'        => esc_html__( 'Alignment', 'kitestudio-core' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'options'      => array(
					'left'    => array(
						'title' => __( 'Left', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'      => '',
				'selectors'    => array(
					'{{WRAPPER}} .buttonwrapper' => 'display: flex; justify-content: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'position',
			array(
				'label'     => esc_html__( 'Position', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'separate' => esc_html__( 'In separate rows', 'kitestudio-core' ),
					'row'      => esc_html__( 'In a row', 'kitestudio-core' ),
				),
				'default'   => 'left',
				'condition' => array(
					'alignment' => array( 'left', 'right' ),
				),
			)
		);
		$this->add_control(
			'button_new_icon',
			array(
				'label' => esc_html__( 'Select an icon', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::ICONS,
			)
		);
		$this->add_control(
			'button_icon_position',
			array(
				'label'     => esc_html__( 'Icon position', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'left'  => esc_html__( 'Icon at left', 'kitestudio-core' ),
					'right' => esc_html__( 'Icon at right', 'kitestudio-core' ),
				),
				'default'   => 'left',
				'condition' => array(
					'button_hover_style' => array( 'style2', 'link_style' ),
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Tooltip text', 'kitestudio-core' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter the text that you want to be shown on your button tooltip.', 'kitestudio-core' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Style', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Button Padding', 'kitestudio-core' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab(
            'button_tab_normal_state',
            [
                'label' => __( 'Normal', 'kitestudio-core' ),
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Text Typography', 'kitestudio-core' ),
				'global'   => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ?? '',
				],
				'selector' => '{{WRAPPER}} .kt_button',
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'Text & Icon Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt_button' => 'color:{{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'button_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt_button' => 'border-color:{{VALUE}} !important',
				),
				'condition' => array(
					'button_hover_style' => array( 'style1', 'style2' ),
				),
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'button_hover_style' => array( 'style1', 'style2' ),
					'button_bg_style'    => 'fill',
				),
				'selectors' => array(
					'{{WRAPPER}} .kt_button.fill' => 'background-color:{{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'button_border_width',
			array(
				'label'     => esc_html__( 'Border stroke', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'1px' => '1px',
					'2px' => '2px',
					'3px' => '3px',
					'4px' => '4px',
				),
				'default'   => '1px',
				'condition' => array(
					'button_hover_style' => array( 'style1', 'style2' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .kt_button' => 'border-width:{{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'     => esc_html__( 'Border radius', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'1px'  => '1px',
					'5px'  => '5px',
					'10px' => '10px',
					'15px' => '15px',
					'20px' => '20px',
				),
				'default'   => '2px',
				'condition' => array(
					'button_hover_style' => array( 'style1', 'style2' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .kt_button' => 'border-radius:{{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab(
            'button_tab_hover_state',
            [
                'label' => __( 'Hover', 'kitestudio-core' ),
            ]
        );

		$this->add_control(
			'button_text_hover_color',
			array(
				'label'     => esc_html__( 'Text & Icon On-hover Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt_button:hover' => 'color:{{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'button_border_hover_color',
			array(
				'label'     => esc_html__( 'Border On-hover Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#444',
				'selectors' => array(
					'{{WRAPPER}} .kt_button:hover,{{WRAPPER}} .kt_button.link_style:after' => 'border-color:{{VALUE}} !important',
				),

			)
		);

		$this->add_control(
			'button_bg_hover_color',
			array(
				'label'     => esc_html__( 'Background On-hover Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'button_hover_style' => array( 'style1', 'style2' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .kt_button.fill:hover,{{WRAPPER}} .kt_button:hover' => 'background-color:{{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render Button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		if ( empty( $settings['url']['url'] ) ) {
			$settings['url']['url'] = '#';
		}

		// Check if its already migrated
		$migrated = isset( $settings['__fa4_migrated']['button_new_icon'] );
		// Check if its a new widget without previously selected icon using the old Icon control
		$is_new = empty( $settings['button_icon'] ) || ( !empty( $settings['button_new_icon'] ) && ! empty( $settings['button_new_icon']['value'] ) );
		if ( $is_new || $migrated ) {
			$button_icon = $settings['button_new_icon']['library'] == 'svg' ? '' : $settings['button_new_icon']['value'];
		} elseif ( isset( $settings['button_icon']['value'] ) ) {
			$button_icon = $settings['button_icon']['library'] == 'svg' ? '' : $settings['button_icon']['value'];
		} else {
			$button_icon = $settings['button_icon'];
		}

		$atts = [
			'title' =>  $settings['title']  ,
			'text' =>  $settings['text']  ,
			'text_hover' =>  $settings['text_hover']  ,
			'button_hover_style' =>  $settings['button_hover_style']  ,
			'button_bg_style' =>  $settings['button_bg_style']  ,
			'link_display_style' =>  $settings['link_display_style']  ,
			'url' =>  $settings['url']['url']  ,
			'new_tab' =>  $settings['url']['is_external']  ,
			'size' =>  $settings['size']  ,
			'alignment' =>  $settings['alignment'] ?? 'left'  ,
			'position' =>  $settings['position']  ,
			'button_display' =>  $settings['button_display']  ,
			'button_icon' =>  $button_icon  ,
			'button_icon_position' =>  $settings['button_icon_position']  ,
			'button_text_color' =>  $settings['button_text_color']  ,
			'button_text_hover_color' =>  $settings['button_text_hover_color']  ,
			'button_border_color' =>  $settings['button_border_color'] ?? '' ,
			'button_border_hover_color' =>  $settings['button_border_hover_color']  ,
			'button_bg_color' =>  $settings['button_bg_color'] ?? '' ,
			'button_bg_hover_color' =>  $settings['button_bg_hover_color']  ?? '',
			'button_border_radius' =>  $settings['button_border_radius'] ?? '' ,
			'button_border_width' =>  $settings['button_border_width'] ?? '' ,
			'elementor' => 'elementor' ,
		];

		echo kite_sc_button( $atts );
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
		if ( empty( $settings['url']['url'] ) ) {
			$settings['url']['url'] = '#';
		}

		// Check if its already migrated
		$migrated = isset( $settings['__fa4_migrated']['button_new_icon'] );
		// Check if its a new widget without previously selected icon using the old Icon control
		$is_new = empty( $settings['button_icon'] );
		if ( $is_new || $migrated ) {
			$button_icon = $settings['button_new_icon']['library'] == 'svg' ? '' : $settings['button_new_icon']['value'];
		} elseif ( isset( $settings['button_icon']['value'] ) ) {
			$button_icon = $settings['button_icon']['library'] == 'svg' ? '' : $settings['button_icon']['value'];
		} else {
			$button_icon = $settings['button_icon'];
		}

		$settings['alignment'] = $settings['alignment'] ?? 'left';
		echo '[button title="' . esc_attr( $settings['title'] ) . '" text="' . esc_attr( $settings['text'] ) . '" text_hover="' . esc_attr( $settings['text_hover'] ) . '" button_hover_style="' . esc_attr( $settings['button_hover_style'] ) . '" button_bg_style="' . esc_attr( $settings['button_bg_style'] ) . '" link_display_style="' . esc_attr( $settings['link_display_style'] ) . '" url="' . esc_attr( $settings['url']['url'] ) . '" new_tab="' . esc_attr( $settings['url']['is_external'] ) . '" size="' . esc_attr( $settings['size'] ) . '" alignment="' . esc_attr( $settings['alignment'] ) . '" position="' . esc_attr( $settings['position'] ) . '" button_display="' . esc_attr( $settings['button_display'] ) . '" button_icon="' . esc_attr( $button_icon ) . '" button_icon_position="' . esc_attr( $settings['button_icon_position'] ) . '" button_text_color="' . esc_attr( $settings['button_text_color'] ) . '" button_text_hover_color="' . esc_attr( $settings['button_text_hover_color'] ) . '" button_border_color="' . esc_attr( $settings['button_border_color'] ) . '" button_border_hover_color="' . esc_attr( $settings['button_border_hover_color'] ) . '" button_bg_color="' . esc_attr( $settings['button_bg_color'] ) . '" button_bg_hover_color="' . esc_attr( $settings['button_bg_hover_color'] ) . '" button_border_radius="' . esc_attr( $settings['button_border_radius'] ) . '" button_border_width="' . esc_attr( $settings['button_border_width'] ) . '" elementor="elementor"]';

	}

	protected function content_template() {
		?>
		<#
		let classes = [];
		classes[0] = "kt_button";
		settings.alignment = settings.alignment ?? 'left';
		classes[1] = (settings.size == 'standard') ? 'button-medium' : ((settings.size != '') ? 'button-'+settings.size : '');
		classes = [
			...classes,
			settings.alignment,
			settings.position,
			settings.button_display,
			settings.button_hover_style,
			settings.button_bg_style,
			settings.link_display_style
		];
		classes = (settings.button_new_icon.value != "") ? [...classes, 'hasicon'] : [...classes];
		classes = [...classes, 'buttonicon'+settings.button_icon_position];
		classes = classes.join(' ');
		let button_icon = settings.button_new_icon.value;
		if (settings.position == 'row') {
		#>
		<div class="inlinestyle {{settings.alignment}}">
		<# } #>
			<# let button_display = (settings.button_display == 'full') ? 'full' : ''; #>
			<div class="buttonwrapper {{button_display}}">
				<#
				if (settings.alignment == 'center') {
				#>
				<div class="centeralignment">
				<# } #>
					<#
					if (settings.button_hover_style == 'link_style' && settings.button_display == 'full') {
					#>
						<div class="fullwidth">
					<# } #>
							<# let target = (settings.url.is_external) ? '_blank':'_self'; #>
							<a class="{{{classes}}}" href="{{{settings.url.url}}}" title="{{settings.title}}" target="{{target}}">
								<#
								if (settings.button_new_icon.value != "" && (settings.button_icon_position != 'right' || settings.button_hover_style == 'style1')) {
									let data_float = (settings.button_icon_position != '') ? 'data-float="'+settings.button_icon_position+'"' : '';
									let data_hover = (settings.button_new_icon.value != '') ? 'data-hover="'+settings.button_new_icon.value+'"' : '';
								#>
									<span class="icon" {{{data_float}}} {{{data_hover}}}>
										<span class="firsticon glyph {{button_icon}}"></span>
										<span class="hovericon glyph {{button_icon}}"></span>
									</span>
								<# } #>
								<# let button_text = (settings.button_hover_style == 'style1') ? settings.text_hover : settings.text; #>
								<span class="txt" data-hover="{{button_text}}">{{button_text}}</span>
								<#
								if (settings.button_icon != "" && settings.button_icon_position == 'right') {
									let data_float = (settings.button_icon_position != '') ? 'data-float="'+settings.button_icon_position+'"' : '';
									let data_hover = (settings.button_icon != '') ? 'data-hover="'+settings.button_icon+'"' : '';
								#>
									<span class="icon" {{{data_float}}} {{{data_hover}}}>
										<span class="firsticon glyph {{button_icon}}"></span>
										<span class="hovericon glyph {{button_icon}}"></span>
									</span>
								<# } #>
							</a>
							<div class="clearfix"></div>
							<#
					if (settings.button_hover_style == 'link_style' && settings.button_display == 'full') {
					#>
						</div>
					<# } #>
				<#
				if (settings.alignment == 'center') {
				#>
				</div>
				<# } #>
			</div>
		<#
		if (settings.position == 'row') {
		#>
		</div>
		<# } #>
		<?php
	}
}
