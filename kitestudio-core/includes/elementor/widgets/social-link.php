<?php
/**
 * Elementor Social Link Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Social_Link_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Social Link widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-social-link';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Social Link widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Social Link', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Social Link widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-twitter-embed kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Social Link widget belongs to.
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
	 * Register Social Link widget controls.
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
				'label' => esc_html__( 'Social Link', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'sociallink_type',
			array(
				'label'   => esc_html__( 'Social Network Type', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'facebook'     => esc_html__( 'Facebook', 'kitestudio-core' ),
					'twitter'      => esc_html__( 'Twitter', 'kitestudio-core' ),
					'vimeo'        => esc_html__( 'Vimeo', 'kitestudio-core' ),
					'youtube-play' => esc_html__( 'YouTube', 'kitestudio-core' ),
					'google-plus'  => esc_html__( 'Google+', 'kitestudio-core' ),
					'dribbble'     => esc_html__( 'Dribbble', 'kitestudio-core' ),
					'tumblr'       => esc_html__( 'Tumblr', 'kitestudio-core' ),
					'linkedin'     => esc_html__( 'Linkedin', 'kitestudio-core' ),
					'flickr'       => esc_html__( 'Flickr', 'kitestudio-core' ),
					'github'       => esc_html__( 'Github', 'kitestudio-core' ),
					'lastfm'       => esc_html__( 'Last.fm', 'kitestudio-core' ),
					'paypal'       => esc_html__( 'Paypal', 'kitestudio-core' ),
					'feed'         => esc_html__( 'RSS', 'kitestudio-core' ),
					'skype'        => esc_html__( 'Skype', 'kitestudio-core' ),
					'wordpress'    => esc_html__( 'WordPress', 'kitestudio-core' ),
					'yahoo'        => esc_html__( 'Yahoo', 'kitestudio-core' ),
					'steam'        => esc_html__( 'Steam', 'kitestudio-core' ),
					'reddit-alien' => esc_html__( 'Reddit', 'kitestudio-core' ),
					'stumbleupon'  => esc_html__( 'StumbleUpon', 'kitestudio-core' ),
					'pinterest'    => esc_html__( 'Pinterest', 'kitestudio-core' ),
					'deviantart'   => esc_html__( 'DeviantArt', 'kitestudio-core' ),
					'xing'         => esc_html__( 'Xing', 'kitestudio-core' ),
					'blogger'      => esc_html__( 'Blogger', 'kitestudio-core' ),
					'soundcloud'   => esc_html__( 'SoundCloud', 'kitestudio-core' ),
					'delicious'    => esc_html__( 'Delicious', 'kitestudio-core' ),
					'foursquare'   => esc_html__( 'Foursquare', 'kitestudio-core' ),
					'instagram'    => esc_html__( 'Instagram', 'kitestudio-core' ),
					'behance'      => esc_html__( 'Behance', 'kitestudio-core' ),
					'custom'       => esc_html__( 'Custom Social Network', 'kitestudio-core' ),
				),
				'default' => 'custom',
			)
		);
		$this->add_control(
			'sociallink_url',
			array(
				'label' => esc_html__( 'Social Network URL', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'sociallink_style',
			array(
				'label'   => esc_html__( 'Social Network Type', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
				),
				'default' => 'dark',
			)
		);
		$this->add_control(
			'sociallink_text',
			array(
				'label'     => esc_html__( 'Social network name', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'sociallink_type' => 'custom',
				),
			)
		);
		$this->end_controls_section();

	}

	/**
	 * Render Social Link widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings  = $this->get_settings_for_display();
		$atts = [
			'sociallink_type' =>  $settings['sociallink_type']  ,
			'sociallink_url' =>  $settings['sociallink_url']  ,
			'sociallink_style' =>  $settings['sociallink_style']  ,
			'sociallink_text' =>  $settings['sociallink_text']  ,
		];
		echo kite_sc_socialLink( $atts );
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
		echo '[socialLink sociallink_type="' . esc_attr( $settings['sociallink_type'] ) . '" sociallink_url="' . esc_attr( $settings['sociallink_url'] ) . '" sociallink_style="' . esc_attr( $settings['sociallink_style'] ) . '" sociallink_text="' . esc_attr( $settings['sociallink_text'] ) . '"]';
	}

	protected function content_template() {

	}
}
