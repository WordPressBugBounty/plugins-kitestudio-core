<?php
namespace KiteStudioCore\Elementor\Widgets\ThemeElements;

/**
 * Elementor Account Widget
 *
 * @since 1.2.2
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class Account extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Icon Box Left widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-theme-account';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Icon Box Left widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Header - Account', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Icon Box Left widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-preferences kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Icon Box Left widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'kite-theme-elements' );
	}

	/**
	 * load dependent styles
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array(
			'kite-header-buttons',
			'kite-account',
		);
	}

	/**
	 * Register Icon Box Left widget controls.
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
				'label' => esc_html__( 'Account', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Account Icon', 'kitestudio-core' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'icon-user',
					'library' => 'kite-icon',
				),
			)
		);

		$this->add_control(
			'icon_subtitle',
			array(
				'label' => esc_html__( 'Account Icon Subtitle', 'kitestudio-core' ),
				'type'  => Controls_Manager::TEXTAREA,
			)
		);

		$this->add_control(
			'logged_in_icon_subtitle',
			array(
				'label'     => esc_html__( 'Account Icon Subtitle When User Logged In', 'kitestudio-core' ),
				'type'      => Controls_Manager::TEXTAREA,
				'condition' => array(
					'icon_subtitle!' => '',
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label' => esc_html__( 'Account Icon Title', 'kitestudio-core' ),
				'type'  => Controls_Manager::TEXTAREA,
			)
		);

		$this->add_control(
			'logged_in_title',
			array(
				'label'     => esc_html__( 'Account Icon Title When User Logged In', 'kitestudio-core' ),
				'type'      => Controls_Manager::TEXTAREA,
				'condition' => array(
					'title!' => '',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'wrapper_style_section',
			array(
				'label' => esc_html__( 'Wrapper Style', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'alignment',
			array(
				'label'                => esc_html__( 'Alignment', 'kitestudio-core' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => array(
					'left'   => array(
						'title' => __( 'Left', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors_dictionary' => array(
					'left'   => '',
					'center' => 'margin-left:auto; margin-right: auto;',
					'right'  => 'float:right',
				),
				'default'              => 'left',
				'selectors'            => array(
					'{{WRAPPER}} .kt-header-button' => '{{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'wrapper_background' );

		$this->start_controls_tab(
			'wrapper_bg_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'wrapper_background_normal',
				'label'    => __( 'Wrapper Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .kt-header-button',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Wrapper Box Shadow', 'kitestudio-core' ),
				'name'     => 'wrapper_box_shadow_normal',
				'selector' => '{{WRAPPER}} .kt-header-button',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'wrapper_bg_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'wrapper_background_hover',
				'label'    => __( 'Wrapper Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .kt-header-button:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Wrapper Box Shadow', 'kitestudio-core' ),
				'name'     => 'wrapper_box_shadow_hover',
				'selector' => '{{WRAPPER}} .kt-header-button:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wrapper_bg_transition',
			array(
				'label'      => __( 'Background Transition (ms)', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 5000,
						'step' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button' => 'transition: all {{SIZE}}ms ease;',
				),
			)
		);

		$this->add_responsive_control(
			'wrapper_margin',
			array(
				'label'      => esc_html__( 'Wrapper Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'wrapper_padding',
			array(
				'label'      => esc_html__( 'Wrapper Padding', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'wrapper_border',
				'selector'  => '{{WRAPPER}} .kt-header-button',
				'separator' => 'none',
			)
		);

		$this->add_responsive_control(
			'wrapper_border_radius',
			array(
				'label'      => esc_html__( 'Wrapper Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'icon_style_section',
			array(
				'label' => esc_html__( 'Icon Style', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'icon_styles' );

		$this->start_controls_tab(
			'icon_style_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => __( 'Icon Size', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
					'em' => array(
						'min'  => 1,
						'max'  => 15,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .element-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .kt-header-button .kt-icon-container .element-icon img' => 'width: {{SIZE}}{{UNIT}};height: auto;',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .element-icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_subtitle_color',
			array(
				'label'     => esc_html__( 'Icon Subtitle color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-subtitle' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'subtitle_margin',
			array(
				'label'      => esc_html__( 'Subtitle Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_style_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_responsive_control(
			'icon_size_hover',
			array(
				'label'      => __( 'Icon Size', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
					'em' => array(
						'min'  => 1,
						'max'  => 15,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .element-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .element-icon img' => 'width: {{SIZE}}{{UNIT}};height: auto;',
				),
			)
		);

		$this->add_control(
			'icon_color_hover',
			array(
				'label'     => esc_html__( 'Icon color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .element-icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_subtitle_color_hover',
			array(
				'label'     => esc_html__( 'Icon Subtitle color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .kt-subtitle' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'subtitle_margin_hover',
			array(
				'label'      => esc_html__( 'Subtitle Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-icon-container .kt-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'icon_style_transition',
			array(
				'label'      => __( 'Icon Styles Transition (ms)', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 5000,
						'step' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .kt-header-button .kt-icon-container .element-icon, {{WRAPPER}} .kt-header-button .kt-icon-container .element-icon img' => 'transition: all {{SIZE}}ms ease;',
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-subtitle' => 'transition: all {{SIZE}}ms ease;',
					'{{WRAPPER}} .kt-header-button .kt-icon-container .kt-badge' => 'transition: all {{SIZE}}ms ease;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'subtitle_typography',
				'label'    => __( 'Subtitle Typography', 'kitestudio-core' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .kt-header-button .kt-icon-container .kt-subtitle pre',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'meta_texts_section',
			array(
				'label' => esc_html__( 'Meta Texts Style', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'meta_texts_margin',
			array(
				'label'      => esc_html__( 'Meta Texts Margin', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .kt-meta-texts' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button .kt-meta-texts .kt-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Title hover color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .kt-header-button:hover .kt-meta-texts .kt-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => __( 'Title Typography', 'kitestudio-core' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .kt-header-button .kt-meta-texts .kt-title',
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render Icon Box Left widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
		<div class="kt-header-button kt-account <?php echo is_user_logged_in() ? '' : 'login-link-popup'; ?>">
			<a class="hd-btn-link" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>"></a>
			<div class="account-btn-container">
				<div class="kt-icon-container">
					<?php
					if ( $settings['icon']['library'] == 'svg' ) {
						echo '<span class="element-icon"><img src="' . esc_url( $settings['icon']['value']['url'] ) . '" alt="svgicon"></span>';
					} else {
						echo '<span class="element-icon ' . esc_attr( $settings['icon']['value'] ) . '"></span>';
					}
					?>
					<?php if ( ! empty( $settings['icon_subtitle'] ) ) { ?>
						<span class="kt-subtitle">
							<?php
							if ( is_user_logged_in() ) {
								echo '<pre>' . wp_kses_post( $settings['logged_in_icon_subtitle'] ) . '</pre>';
							} else {
								echo '<pre>' . wp_kses_post( $settings['icon_subtitle'] ) . '</pre>';
							}
							?>
						</span>
					<?php } ?>
				</div>
				<div class="kt-meta-texts">
					<?php if ( ! empty( $settings['title'] ) ) { ?>
						<span class="kt-title">
							<?php
							//removed pre (pre not allowed as child of element span)
							if ( is_user_logged_in() ) {
								echo '<span>' . esc_html( $settings['logged_in_title'] ) . '</span>';
							} else {
								echo '<span>' . esc_html( $settings['title'] ) . '</span>';
							}
							?>
						</span>
					<?php } ?>
				</div>
			</div>

			<?php if ( is_user_logged_in() && kite_woocommerce_installed() ) { ?>
					<ul  class="topbar_login-content">
						<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
							<li class="<?php echo esc_attr( wc_get_account_menu_item_classes( $endpoint ) ); ?>">
							<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
					<?php
			}
			?>
		</div>
		<?php
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

	}

	protected function content_template() {
		?>
		<div class="kt-header-button kt-account">
			<div class="account-btn-container">
				<div class="kt-icon-container">
					<# if ( settings.icon.library == 'svg' ) { #>
						<span class="element-icon"><img src="{{{settings.icon.value.url}}}" alt="svgicon"></span>
					<# } else { #>
						<span class="element-icon {{{settings.icon.value}}}"></span>
					<# } #>
					<span class="kt-subtitle"><pre>{{{settings.icon_subtitle}}}</pre></span>
				</div>
				<?php //pre not allowed as child of element span ?>
				<div class="kt-meta-texts">
					<span class="kt-title"><span>{{{settings.title}}}</span></span>
				</div>
			</div>
		</div>
		<?php
	}
}
