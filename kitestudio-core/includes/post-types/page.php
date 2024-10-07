<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Kite_Page' ) ) {

	class Kite_Page extends Kite_Post_Type {

		/**
		 * Instance of this class.
		 *
		 * @var      object
		 */
		protected static $instance = null;

		/**
		 * Return an instance of this class.
		 *
		 * @return    object    A single instance of this class.
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			parent::__construct( 'page' );
		}

		public function kite_enqueue_scripts() {
			wp_enqueue_script( 'hoverIntent' );
			wp_enqueue_script( 'jquery-easing' );

			// Include wpcolorpicker + its patch to support alpha chanel
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker-alpha' );

			wp_enqueue_style( 'kite-admin-css' );
			wp_enqueue_script( 'kite-admin-js' );

			wp_enqueue_script( 'kite-page', KITE_CORE_URL . 'includes/post-types/js/page.js', array( 'jquery' ), KITE_THEME_VERSION, true );

		}

		private function kite_get_sidebars() {
			$sidebars = array(
				'no-sidebar'   => esc_html__( 'No Sidebar', 'kitestudio-core' ),
				'page-sidebar' => esc_html__( 'Page Sidebar', 'kitestudio-core' ),
				'main-sidebar' => esc_html__( 'Blog Sidebar', 'kitestudio-core' ),
			);

			if ( kite_opt( 'custom_sidebars' ) != '' ) {
				$arr = explode( ',', kite_opt( 'custom_sidebars' ) );

				foreach ( $arr as $bar ) {
					$sidebars[ $bar ] = str_replace( '%666', ',', $bar );
				}
			}

			$sidebars = array_unique( $sidebars );
			return $sidebars;
		}

		protected function kite_get_options() {

			$args = array(
				'orderby'    => 'id',
				'order'      => 'DESC',
				'hide_empty' => false,
				'fields'     => 'all',
			);

			$fields = array(
				'header-type-switch'       => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Choose your Header Type', 'kitestudio-core' ),
					'options' => array(
						'0' => esc_html__( 'Enable Header', 'kitestudio-core' ),
						'1' => esc_html__( 'Enable Top Space', 'kitestudio-core' ),
						'2' => esc_html__( 'Disable Top Space', 'kitestudio-core' ),
					),
					'default' => '0',
				),
				'header-title-bar-switch'  => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Section Title', 'kitestudio-core' ),
					'options' => array(
						'2' => esc_html__( 'Show post title', 'kitestudio-core' ),
						'1' => esc_html__( 'Show custom title', 'kitestudio-core' ),
						'0' => esc_html__( 'Don\'t show title', 'kitestudio-core' ),
					),
					'default' => '2',
				),
				'title-text'               => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Title Text', 'kitestudio-core' ),
					'placeholder' => esc_html__( 'Override title text', 'kitestudio-core' ),

				),
				'subtitle-text'            => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Subtitle Text', 'kitestudio-core' ),
					'placeholder' => esc_html__( 'Subtitle text', 'kitestudio-core' ),
				),

				'header-background-image'  => array(
					'type'  => 'upload',
					'label' => esc_html__( 'Background Image', 'kitestudio-core' ),
					'title' => esc_html__( 'Upload Background image for header', 'kitestudio-core' ),
				),
				'header-background-color'  => array(
					'type'  => 'color',
					'label' => esc_html__( 'Header Background Color', 'kitestudio-core' ),
					'value' => '',
				),

				'header-text-color'        => array(
					'type'  => 'color',
					'label' => esc_html__( 'Header Text Color', 'kitestudio-core' ),
					'value' => '',
				),
				'page-type-switch'         => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Section Type', 'kitestudio-core' ),
					'options' => array(
						'custom-section'  => esc_html__( 'Custom section', 'kitestudio-core' ),
						'blog-section'    => esc_html__( 'Blog section', 'kitestudio-core' ),
						// @if PRO
						'recently-viewed' => esc_html__( 'Recently Viewed Products', 'kitestudio-core' ),
						// @endif
					),
				),
				'page-position-switch'     => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Choose your section to be shown in:', 'kitestudio-core' ),
					'options' => array(
						'1' => esc_html__( 'OnePage Container', 'kitestudio-core' ),
						'0' => esc_html__( 'External page', 'kitestudio-core' ),
					),
				),
				'sidebar'                  => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Choose the sidebar', 'kitestudio-core' ),
					'options' => $this->kite_get_sidebars(),
				),
				'blog-sidebar'             => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Blog Sidebar Display', 'kitestudio-core' ),
					'options' => array(
						'0' => esc_html__( 'Inherit from theme settings', 'kitestudio-core' ),
						'1' => esc_html__( 'Show', 'kitestudio-core' ),
						'2' => esc_html__( 'Don\'t show', 'kitestudio-core' ),
					),
				),
				'blog-sidebar-position'    => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Blog Sidebar position', 'kitestudio-core' ),
					'options' => array(
						'main-sidebar' => esc_html__( 'Right sidebar', 'kitestudio-core' ),
						'left-sidebar' => esc_html__( 'Left Sidebar', 'kitestudio-core' ),
					),
				),
				'display-top-slider'       => array(
					'type'    => 'switch',
					'label'   => esc_html__( 'Top Slider', 'kitestudio-core' ),
					'state0'  => esc_html__( 'Disable', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Enable', 'kitestudio-core' ),
					'value'   => 0,
					'default' => 0,
				),
				'revslider-container'      => array(
					'type'    => 'switch',
					'label'   => esc_html__( 'Revolution Slider Container/fullwidth', 'kitestudio-core' ),
					'state0'  => esc_html__( 'fullwidth', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Container', 'kitestudio-core' ),
					'value'   => 0,
					'default' => 0,
				),
				'slider-parallax'          => array(
					'type'    => 'switch',
					'label'   => esc_html__( 'Slider parallax effect', 'kitestudio-core' ),
					'state0'  => esc_html__( 'Disable', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Enable', 'kitestudio-core' ),
					'value'   => 1,
					'default' => 1,
				),
				'home-rev-slide'           => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Choose a revolution slider', 'kitestudio-core' ),
					'options' => kite_get_revolutionSlider_slides(),
				),
				'resume-exp-section'       => array(
					'type'    => 'checkbox',
					'checked' => true,
					'value'   => 'visible',
					'label'   => esc_html__( 'Experience', 'kitestudio-core' ),
				),
				'extra_class'              => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Extra Class Name', 'kitestudio-core' ),
					'placeholder' => esc_html__( 'class name ex: class1 class2', 'kitestudio-core' ),
				), // Extra class name
				'snap-to-scroll'           => array(
					'type'    => 'switch',
					'label'   => esc_html__( 'Enable snap to scroll', 'kitestudio-core' ),
					'state0'  => esc_html__( 'Disable', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Enable', 'kitestudio-core' ),
					'default' => 0,
				),
				'snap-to-scroll-nav-style' => array(
					'type'    => 'switch',
					'label'   => esc_html__( 'Navigation style', 'kitestudio-core' ),
					'state0'  => esc_html__( 'Light', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Dark', 'kitestudio-core' ),
					'default' => 0,
				),
				'footer-widget-area'       => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Footer widget area visibility', 'kitestudio-core' ),
					'options' => array(
						'inherit' => 'Inherit from theme setting',
						'enable'  => 'Enable',
						'disable' => 'Disable',
					),
				),
				'page_bg_color'            => array(
					'type'  => 'color',
					'label' => esc_html__( 'page Background color', 'kitestudio-core' ),
					'title' => esc_html__( 'Upload Background image for page', 'kitestudio-core' ),
				),
				'page_bg_image'            => array(
					'type'  => 'upload',
					'label' => esc_html__( 'page Background Image', 'kitestudio-core' ),
					'title' => esc_html__( 'Upload Background image for page', 'kitestudio-core' ),
				),
				'bg_img_size'              => array(
					'type'    => 'select',
					'label'   => esc_html__( 'background image Size', 'kitestudio-core' ),
					'options' => array(
						'contain' => 'contain',
						'cover'   => 'cover',
						'initial' => 'initial',
					),
				),
				'bg_img_repeat'            => array(
					'type'    => 'select',
					'label'   => esc_html__( 'background image repeat', 'kitestudio-core' ),
					'options' => array(
						'repeat'    => 'repeat',
						'repeat-x'  => 'repeat-x',
						'repeat-y'  => 'repeat-y',
						'no-repeat' => 'no-repeat',
					),
				),
				'bg_img_position'          => array(
					'type'    => 'select',
					'label'   => esc_html__( 'background image position', 'kitestudio-core' ),
					'options' => array(
						'center'  => 'center',
						'top'     => 'top',
						'bottom'  => 'bottom',
						'right'   => 'right',
						'left'    => 'left',
						'inherit' => 'inherit',
					),
				),
				'bg_img_attachment'        => array(
					'type'    => 'select',
					'label'   => esc_html__( 'background image attachment:', 'kitestudio-core' ),
					'options' => array(
						'fixed'   => 'fixed',
						'scroll'  => 'scroll',
						'local'   => 'local',
						'inherit' => 'inherit',
						'unset'   => 'unset',
					),
				),
				'custom-content-layout'    => array(
					'type'    => 'switch',
					'label'   => esc_html__( 'Content Layout Inherit', 'kitestudio-core' ),
					'state0'  => esc_html__( 'Inherit', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Custom', 'kitestudio-core' ),
					'value'   => 0,
					'default' => 0,
				),
				'content-layout'           => array(
					'type'    => 'switch',
					'label'   => esc_html__( 'Content Layout', 'kitestudio-core' ),
					'state0'  => esc_html__( 'Container', 'kitestudio-core' ),
					'state1'  => esc_html__( 'Fullwidth', 'kitestudio-core' ),
					'value'   => 0,
					'default' => 0,
				),

			);

			// Option sections
			$options = array(
				'custom-content-layout' => array(
					'title'   => esc_html__( 'Content Layout Inherit', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Select layout of content page. If page content inherits from theme settings or not.', 'kitestudio-core' ),
					'fields'  => array(
						'custom-content-layout' => $fields['custom-content-layout'],
					),
				),
				'content-layout'        => array(
					'title'   => esc_html__( 'Content Layout', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Select layout of content page.', 'kitestudio-core' ),
					'fields'  => array(
						'content-layout' => $fields['content-layout'],
					),
				),
				'page-type-switch'      => array(
					'title'   => esc_html__( 'Section Type', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Choose a section which will be shown in OnePage Container page.   Create a new section. This section can be shown in any one of your pages.', 'kitestudio-core' ),
					'fields'  => array(
						'page-type-switch' => $fields['page-type-switch'],
					),
				), // Section Type
				'page-position-switch'  => array(
					'title'   => esc_html__( 'Section Display', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Choose where you want to show your section. It can be shown in OnePage Container page or be shown as an external page.', 'kitestudio-core' ),
					'fields'  => array(
						'page-position-switch' => $fields['page-position-switch'],
					),
				), // Open Page As Separate Page Or Front Page
				'page-sidebar'          => array(
					'title'   => esc_html__( 'Page Sidebar', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'You can choose a sidebar to be shown in this section which is created in theme settings ', 'kitestudio-core' ),
					'fields'  => array(
						'sidebar' => $fields['sidebar'],
					),
				), // Add Page Sidebar
				'blog-sidebar'          => array(
					'title'   => esc_html__( 'Blog Sidebar', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'You can enable or disable blog sidebar ', 'kitestudio-core' ),
					'fields'  => array(
						'blog-sidebar' => $fields['blog-sidebar'],
					),
				), // Enable blog Sidebar
				'blog-sidebar-position' => array(
					'title'   => esc_html__( 'Blog Sidebar Position', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'choose left or right blog sidebar ', 'kitestudio-core' ),
					'fields'  => array(
						'blog-sidebar-position' => $fields['blog-sidebar-position'],
					),
				), // Enable blog Sidebar Position
				'footer-widget-area'    => array(
					'title'   => esc_html__( 'Footer Widget Area', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Enable or disable widget area in the footer.', 'kitestudio-core' ),
					'fields'  => array(
						'footer-widget-area' => $fields['footer-widget-area'],
					),
				), // Footer Widget Area
			// page background image
				'page_background_image' => array(
					'title'   => esc_html__( 'page background image', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'choose image for page background.', 'kitestudio-core' ),
					'fields'  => array(
						'page_bg_color'     => $fields['page_bg_color'],
						'page_bg_image'     => $fields['page_bg_image'],
						'bg_img_size'       => $fields['bg_img_size'],
						'bg_img_repeat'     => $fields['bg_img_repeat'],
						'bg_img_position'   => $fields['bg_img_position'],
						'bg_img_attachment' => $fields['bg_img_attachment'],

					),
				),
				'extra_class'           => array(
					'title'   => esc_html__( 'Extra Class name', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS. use space between diffrent class name', 'kitestudio-core' ),
					'fields'  => array(
						'extra_class' => $fields['extra_class'],
					),
				), // Extra Class name
			);

			$header_options = array(
				'header-type-switch'      => array(
					'title'   => esc_html__( 'Header Type', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Choose your Header Type that you want to show in your page.', 'kitestudio-core' ),
					'fields'  => array(
						'header-type-switch' => $fields['header-type-switch'],
					),
				), // header type
				'title-bar'               => array(
					'title'   => esc_html__( 'Title', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Choose a title to be shown at the beginning of each section', 'kitestudio-core' ),
					'fields'  => array(
						'title-bar'     => $fields['header-title-bar-switch'],
						'title-text'    => $fields['title-text'],
						'subtitle-text' => $fields['subtitle-text'],
					),
				), // Title bar sec
				'header-background-image' => array(
					'title'   => esc_html__( 'Header Background Image', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Choose your Header background image that you want to show in your page.', 'kitestudio-core' ),
					'fields'  => array(
						'header-background-image' => $fields['header-background-image'],
					),
				), // header Background image
				'header-background-color' => array(
					'title'   => esc_html__( 'Header Background Color', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Choose Header Background Color that you want to show in Header of Page.', 'kitestudio-core' ),
					'fields'  => array(
						'header-background-color' => $fields['header-background-color'],
					),
				), // header background color
				'header-text-color'       => array(
					'title'   => esc_html__( 'Header Text Color', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Choose Header Text Color that you want to show in Header of Page.', 'kitestudio-core' ),
					'fields'  => array(
						'header-text-color' => $fields['header-text-color'],
					),
				), // header Text color

			);

			$slider_options = array(
				'display-top-slider'     => array(
					'title'   => esc_html__( 'Slider Visibility', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Enable or disable Slider.', 'kitestudio-core' ),
					'fields'  => array(
						'display-top-slider' => $fields['display-top-slider'],
					),
				), // Display Header
				'revslider-container'    => array(
					'title'   => esc_html__( 'Slider Revolution Type', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Choose your slider type.', 'kitestudio-core' ),
					'fields'  => array(
						'revslider-container' => $fields['revslider-container'],
					),
				), // Intro Full-width Slider
				'slider-parallax'        => array(
					'title'   => esc_html__( 'Slider parallax effect', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Enable or disable parallax effect of slider.', 'kitestudio-core' ),
					'fields'  => array(
						'slider-parallax' => $fields['slider-parallax'],
					),
				),
				'slide-revolutionSlider' => array(
					'title'   => esc_html__( 'Revolution Slider', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Choose an existing revolution slider slide show, to be shown in intro section', 'kitestudio-core' ),
					'fields'  => array(
						'home-rev-slide' => $fields['home-rev-slide'],
					),
				),

			);

			$snap_to_scroll_options = array(
				'snap-to-scroll'           => array(
					'title'   => esc_html__( 'Snap to Scroll', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Enable or disable snap to scroll for this page.', 'kitestudio-core' ),
					'fields'  => array(
						'snap-to-scroll' => $fields['snap-to-scroll'],
					),
				), // Display Header
				'snap-to-scroll-nav-style' => array(
					'title'   => esc_html__( 'Navigation style', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Navigation style(Dark/Light)', 'kitestudio-core' ),
					'fields'  => array(
						'snap-to-scroll-nav-style' => $fields['snap-to-scroll-nav-style'],
					),
				),
			);

			$menu_options = array(
				'menu'               => array(
					'title'   => esc_html__( 'Menu style', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Override menu style for current page.', 'kitestudio-core' ),
					'fields'  => array(
						'menu' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Menu style', 'kitestudio-core' ),
							'options' => array(
								'default' => esc_html__( 'Inherit from theme settings', 'kitestudio-core' ),
								'custom'  => esc_html__( 'Custom', 'kitestudio-core' ),
							),
						),
					),
				),
				'initial-menu-color' => array(
					'title'   => esc_html__( 'Initial Menu Colors', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Choose the color and set the opacity for initial menu.', 'kitestudio-core' ),
					'fields'  => array(
						'initial-menu-background-color'    => array(
							'type'  => 'color',
							'label' => esc_html__( 'Background Color', 'kitestudio-core' ),
							'value' => '#ffffff',
						),
						'initial-menu-text-color'          => array(
							'type'  => 'color',
							'label' => esc_html__( 'Text Color', 'kitestudio-core' ),
							'value' => '#000000',
						),
						'initial-menu-text-hover-color'    => array(
							'type'  => 'color',
							'label' => esc_html__( 'Text Hover Color', 'kitestudio-core' ),
							'value' => '#000000',
							'class' => 'menu-hover-color',
						),
						'initial-menu-text-bg-hover-color' => array(
							'type'  => 'color',
							'label' => esc_html__( 'on-hover Background Color', 'kitestudio-core' ),
							'value' => '#f83333',
							'class' => 'menu-bg-hover-color',
						),
						'initial-menu-border-color'        => array(
							'type'  => 'color',
							'class' => 'initial-border-color',
							'label' => esc_html__( 'Border Color', 'kitestudio-core' ),
							'value' => '#eee',
						),
					),
				),
				'menu-color'         => array(
					'title'   => esc_html__( 'Menu Colors', 'kitestudio-core' ),
					'tooltip' => esc_html__( 'Choose the color and set the opacity for menu.', 'kitestudio-core' ),
					'fields'  => array(
						'menu-background-color'    => array(
							'type'  => 'color',
							'label' => esc_html__( 'Background Color', 'kitestudio-core' ),
							'value' => '#ffffff',
						),
						'menu-text-color'          => array(
							'type'  => 'color',
							'label' => esc_html__( 'Text Color', 'kitestudio-core' ),
							'value' => '#000000',
						),
						'menu-text-hover-color'    => array(
							'type'  => 'color',
							'label' => esc_html__( 'Text Hover Color', 'kitestudio-core' ),
							'value' => '#000000',
							'class' => 'menu-hover-color',
						),
						'menu-text-bg-hover-color' => array(
							'type'  => 'color',
							'label' => esc_html__( 'on-hover Background Color', 'kitestudio-core' ),
							'value' => '#e8e8e8',
							'class' => 'menu-bg-hover-color',
						),
						'menu-border-color'        => array(
							'type'  => 'color',
							'class' => 'border-color',
							'label' => esc_html__( 'Border Color', 'kitestudio-core' ),
							'value' => '#eee',
						),
					),
				),
			);

			/**
			 * Filter to modify page header metabox options
			 */
			$header_options = apply_filters( 'kite_page_header_metaboxes_options', $header_options );

			/**
			 * Filter to modify snap to scroll metabox options
			 */
			$snap_to_scroll_options = apply_filters( 'kite_page_snap_to_scroll_metaboxes_options', $snap_to_scroll_options );

			/**
			 * Filter to modify page settings metabox options
			 */
			$options = apply_filters( 'kite_page_settings_metaboxes_options', $options );

			/**
			 * Filter to modify page slider metabox options
			 */
			$slider_options = apply_filters( 'kite_page_slider_metaboxes_options', $slider_options );

			$metaboxes = array(
				array(
					'id'       => 'page_header_meta_box',
					'title'    => esc_html__( 'Page Header Settings', 'kitestudio-core' ),
					'context'  => 'normal',
					'priority' => 'high',
					'options'  => $header_options,
				), // Meta box 1
				array(
					'id'       => 'snap_to_scroll_meta_box',
					'title'    => esc_html__( 'Snap to Scroll Settings', 'kitestudio-core' ),
					'context'  => 'normal',
					'priority' => 'high',
					'options'  => $snap_to_scroll_options,
				), // Meta box 2
				array(
					'id'       => 'blog_meta_box',
					'title'    => esc_html__( 'Page Settings', 'kitestudio-core' ),
					'context'  => 'normal',
					'priority' => 'high',
					'options'  => $options,
				), // Meta box 3
				array(
					'id'       => 'slider_meta_box',
					'title'    => esc_html__( 'Top Slider Settings', 'kitestudio-core' ),
					'context'  => 'normal',
					'priority' => 'high',
					'options'  => $slider_options,
				), // Meta box 4
			);

			// Add menu metabox - unset some options that is not appropriate for current menu type
			if ( kite_opt( 'header-type' ) != 7 && kite_opt( 'header-type' ) != 8 ) {

				if ( kite_opt( 'menu-hover-style', 3 ) == 3 ) {
					unset( $menu_options['menu-color']['fields']['menu-text-hover-color'] );
					unset( $menu_options['initial-menu-color']['fields']['initial-menu-text-hover-color'] );

					unset( $menu_options['menu-color']['fields']['menu-text-bg-hover-color'] );
					unset( $menu_options['initial-menu-color']['fields']['initial-menu-text-bg-hover-color'] );
				} elseif ( kite_opt( 'menu-hover-style', 3 ) == 2 ) {
					unset( $menu_options['menu-color']['fields']['menu-text-bg-hover-color'] );
					unset( $menu_options['initial-menu-color']['fields']['initial-menu-text-bg-hover-color'] );
				}

				if ( kite_opt( 'header-style', 'normal-menu' ) == 'fixed-menu' ) {
					unset( $menu_options['menu-color'] );
				}

				$metaboxes[] = array(
					'id'       => 'menu_meta_box',
					'title'    => esc_html__( 'Menu Settings', 'kitestudio-core' ),
					'context'  => 'normal',
					'priority' => 'high',
					'options'  => $menu_options,
				);
			}

			/**
			 * Filter to modify metabox panels
			 */
			return apply_filters( 'kite_page_metabox_panels', $metaboxes );

		}
	}

	Kite_Page::get_instance();

}
