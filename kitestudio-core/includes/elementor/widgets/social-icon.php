<?php
/**
 * Elementor Social Icon Widget.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Social_Icon_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Social Icon widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-social-icon';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Social Icon widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Social Icon', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Social Icon widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return ' eicon-social-icons kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Social Icon widget belongs to.
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
	 * Register Social Icon widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$social_icon_dark_light = array(
			'facebook',
			'twitter',
			'vimeo',
			'youtube-play',
			'google-plus',
			'dribbble',
			'tumblr',
			'linkedin',
			'flickr',
			'github',
			'lastfm',
			'paypal',
			'feed',
			'skype',
			'wordpress',
			'yahoo',
			'steam',
			'reddit-alien',
			'stumbleupon',
			'pinterest',
			'deviantart',
			'xing',
			'blogger',
			'soundcloud',
			'delicious',
			'foursquare',
			'instagram',
			'behance',
		);

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Social Icon', 'kitestudio-core' ),
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
				'label'     => esc_html__( 'Social Network Type', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
				),
				'default'   => 'dark',
				'condition' => array(
					'sociallink_type' => $social_icon_dark_light,
				),
			)
		);
		$this->add_control(
			'sociallink_image',
			array(
				'label'     => esc_html__( 'Image URL', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'sociallink_type' => 'custom',
				),
			)
		);
		$this->end_controls_section();

	}

	/**
	 * Render Social Icon widget output on the frontend.
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
			'sociallink_image' =>  $settings['sociallink_image']['id']  ,
		];
		echo kite_sc_socialIcon( $atts );
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
		echo '[socialIcon sociallink_type="' . esc_attr( $settings['sociallink_type'] ) . '" sociallink_url="' . esc_attr( $settings['sociallink_url'] ) . '" sociallink_style="' . esc_attr( $settings['sociallink_style'] ) . '" sociallink_image="' . esc_attr( $settings['sociallink_image']['id'] ) . '"]';
	}

	protected function content_template() {

	}
}
