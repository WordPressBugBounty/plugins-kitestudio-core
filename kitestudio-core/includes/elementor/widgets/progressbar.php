<?php
/**
 * Elementor Progressbar Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Progressbar_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Progressbar widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-progressbar';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Progressbar widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Progressbar', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Progressbar widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-skill-bar kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Progressbar widget belongs to.
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
			'kite-progressbar',
		);
	}

	/**
	 * Register Progressbar widget controls.
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
				'label' => esc_html__( 'Progressbar', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Title', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'title-color',
			array(
				'label'     => esc_html__( 'Title Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'selectors' => array(
					'{{WRAPPER}} .progress_title'         => 'color:{{VALUE}}',
					'{{WRAPPER}} .progress_percent_value' => 'color:{{VALUE}}',
				),
			)
		);

		$this->add_control(
			'percentage',
			array(
				'label'       => esc_html__( 'Percentage', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Percentage', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'active-background-color',
			array(
				'label'     => esc_html__( 'Active Background Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'selectors' => array(
					'{{WRAPPER}} .progressbar_percent' => 'background-color:{{VALUE}}',
				),
			)
		);

		$this->add_control(
			'inactive-background-color',
			array(
				'label'     => esc_html__( 'Inactive Background Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'selectors' => array(
					'{{WRAPPER}} .progressbar_holder:after' => 'background-color:{{VALUE}}',
				),
			)
		);
		$this->end_controls_section();

	}

	/**
	 * Render Progressbar widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$atts = [
			'title' =>   $settings['title']  ,
			'title_color' =>   $settings['title-color']  ,
			'percent' =>   $settings['percentage']  ,
			'active_bg_color' =>   $settings['active-background-color']  ,
			'inactive_bg_color' =>   $settings['inactive-background-color']  ,
		];

		echo kite_sc_progressbar( $atts );
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
		$settings  = $this->get_settings_for_display();
		echo '[progressbar title="' . esc_attr( $settings['title'] ) . '" title_color="' . esc_attr( $settings['title-color'] ) . '" percent="' . esc_attr( $settings['percentage'] ) . '" active_bg_color="' . esc_attr( $settings['active-background-color'] ) . '" inactive_bg_color="' . esc_attr( $settings['inactive-background-color'] ) . '"]';

	}

	protected function content_template() {
		?>
		<div class="progress_bar">
			<div class="progressbar_holder">
				<# if (settings.title != '') { #>
					<span class="progress_title">{{{settings.title}}}</span>
				<# } #>
				<span class="progress_percent_value" style="left:{{settings.percentage}}%;">{{settings.percentage}}%</span>
				<div class="progressbar_percent" data-percentage="{{settings.percentage}}" style="width:{{settings.percentage}}%;"></div>
			</div>
		</div>
		<?php
	}
}
