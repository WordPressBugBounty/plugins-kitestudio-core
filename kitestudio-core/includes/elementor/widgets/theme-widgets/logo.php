<?php
namespace KiteStudioCore\Elementor\Widgets\ThemeElements;

/**
 * Elementor Logo Widget
 *
 * @since 1.2.2
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Logo extends Widget_Base {

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
		return 'kite-theme-logo';
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
		return esc_html__( 'Logo', 'kitestudio-core' );
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
		return 'eicon-site-logo kite-element-icon';
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
				'label' => esc_html__( 'Logo', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'site_logo',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf( __( '<strong>Logo comes from theme settings.</strong><br>To change logo go to <a href="%s" target="_blank">Theme Settings</a>.', 'kitestudio-core' ), admin_url( 'admin.php?page=theme_settings' ) ),
				'separator'       => 'after',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'logo_style_section',
			array(
				'label' => esc_html__( 'Logo Style', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'logo_size',
			array(
				'label'      => __( 'Logo Width', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 300,
						'step' => 5,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .kt-logo img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				),
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
		$logo            = kite_opt( 'logo', KITE_THEME_ASSETS_URI . '/content/img/logo.svg' );
		$responsive_logo = kite_opt( 'responsivelogo', '' );
		if ( empty( $logo ) && empty( $responsive_logo ) ) {
			return;
		}
		?>
		<div class="kt-logo">
			<?php if ( ! empty( $responsive_logo ) ) { ?>
				<a href="<?php echo esc_url( home_url() ); ?>" class="hidden-phone hidden-tablet"><img src="<?php echo esc_url( $logo ); ?> " alt="site-logo"></a>
				<a href="<?php echo esc_url( home_url() ); ?>" class="hidden-desktop"><img src="<?php echo esc_url( $responsive_logo ); ?> " alt="site-logo"></a>
			<?php } else { ?>
				<a href="<?php echo esc_url( home_url() ); ?>"><img src="<?php echo esc_url( $logo ); ?> " alt="site-logo"></a>
			<?php } ?>
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
	}
}
