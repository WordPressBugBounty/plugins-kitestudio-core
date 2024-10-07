<?php
namespace KiteStudioCore\Elementor;

use Elementor\Plugin;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Handler {

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

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'elementor/elements/categories_registered', array( $this, 'add_widget_categories' ) );

		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.5.0', '>=' ) ) { 
            add_action( 'elementor/widgets/register', array( $this, 'init_widgets' ) );
        } else {
            add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );
        }

		add_filter( 'elementor/fonts/additional_fonts', array( $this, 'add_fonts_to_elementor' ) );
		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'add_font_icons' ) );
		add_action( 'elementor/element/after_section_end', array( $this, 'add_custom_css_controls_section' ), 25, 3 );

		if ( ! defined( 'KT_PRO_TOOLS_VERSION' ) || version_compare( KT_PRO_TOOLS_VERSION, '1.4.1', '>' ) ) {
			add_action( 'elementor/theme/register_locations', array( $this, 'register_locations' ) );
			if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
				define( 'KITE_ELEMENTOR_TEMPLATES', true );
				add_filter( 'single_template', array( $this, 'load_canvas_template' ) );
				add_action( 'elementor/documents/register', array( $this, 'register_documents' ) );

				add_action( 'elementor/element/parse_css', array( $this, 'add_post_css' ), 10, 2 );
			}

			add_action( 'elementor/element/before_section_end', array( $this, 'register_column_flex_display' ), 10, 2 );
		}
	}

	/**
	 * register elementor locations
	 *
	 * @param object $elementor_theme_manager
	 * @return void
	 */
	public function register_locations( $elementor_theme_manager ) {

		$elementor_theme_manager->register_core_location( 'header' );
		$elementor_theme_manager->register_core_location( 'footer' );

	}

	/**
	 * add elementor widget category
	 *
	 * @param object $elements_manager
	 * @return void
	 */
	public function add_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'by-kite',
			array(
				'title' => esc_html__( 'By Kite', 'kitestudio-core' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * init widgets
	 *
	 * @return void
	 */
	public function init_widgets( $widgets_manager ) {
		$widgets = array(
			'theme-widgets' => array(
				'cart'       => [
					'dependency'	=> 'woocommerce',
					'class'			=> '\KiteStudioCore\Elementor\Widgets\ThemeElements\Cart'
				],
				'wishlist'   => [
					'dependency'	=> 'YITH_WCWL',
					'class'			=> '\KiteStudioCore\Elementor\Widgets\ThemeElements\Wishlist'
				],
				'compare'    => [
					'dependency'	=> 'YITH_Woocompare',
					'class'			=> '\KiteStudioCore\Elementor\Widgets\ThemeElements\Compare'
				],
				'account'    => [
					'dependency'	=> 'woocommerce',
					'class'			=> '\KiteStudioCore\Elementor\Widgets\ThemeElements\Account'
				],
				'logo'       => [
					'dependency'	=> '',
					'class'			=> '\KiteStudioCore\Elementor\Widgets\ThemeElements\Logo'
				],
				'menu'       => [
					'dependency'	=> '',
					'class'			=> '\KiteStudioCore\Elementor\Widgets\ThemeElements\Menu'
				],
				'search'     => [
					'dependency'	=> '',
					'class'			=> '\KiteStudioCore\Elementor\Widgets\ThemeElements\Search'
				],
				'select'     => [
					'dependency'	=> '',
					'class'			=> '\KiteStudioCore\Elementor\Widgets\ThemeElements\Select'
				],
				'categories' => [
					'dependency'	=> '',
					'class'			=> '\KiteStudioCore\Elementor\Widgets\ThemeElements\Categories'
				],
				'newsletter' => [
					'dependency'	=> '',
					'class'			=> '\KiteStudioCore\Elementor\Widgets\ThemeElements\Newsletter'
				],
			),
			'widgets'       => array(
				'team-member'                     => [
					'dependency'	=> '',
					'class'			=> 'Kite_Team_Member_Widget'
				],
				'testimonial'                     => [
					'dependency'	=> '',
					'class'			=> 'Kite_Testimonial_Widget'
				],
				'progressbar'                     => [
					'dependency'	=> '',
					'class'			=> 'Kite_Progressbar_Widget'
				],
				'soundcloud'                      => [
					'dependency'	=> '',
					'class'			=> 'Kite_SoundCloud_Widget'
				],
				'embed-video'                     => [
					'dependency'	=> '',
					'class'			=> 'Kite_EmbedVideo_Widget'
				],
				'animated-text'                   => [
					'dependency'	=> '',
					'class'			=> 'Kite_Animated_Text_Widget'
				],
				'banner'                          => [
					'dependency'	=> '',
					'class'			=> 'Kite_Banner_Widget'
				],
				'pie-chart'                       => [
					'dependency'	=> '',
					'class'			=> 'Kite_Pie_Chart_Widget'
				],
				'button'                          => [
					'dependency'	=> '',
					'class'			=> 'Kite_Button_Widget'
				],
				'image-carousel'                  => [
					'dependency'	=> '',
					'class'			=> 'Kite_Image_Carousel_Widget'
				],
				'teta-text-box'                   => [
					'dependency'	=> '',
					'class'			=> 'Kite_Teta_TextBox_Widget'
				],
				'icon-box-top'                    => [
					'dependency'	=> '',
					'class'			=> 'Kite_Icon_Box_Top_Widget'
				],
				'icon-box-top-square'             => [
					'dependency'	=> '',
					'class'			=> 'Kite_Icon_Box_Square_Widget'
				],
				'icon-box-top-circle'             => [
					'dependency'	=> '',
					'class'			=> 'Kite_Icon_Box_Circle_Widget'
				],
				'icon-box-left'                   => [
					'dependency'	=> '',
					'class'			=> 'Kite_Icon_Box_Left_Widget'
				],
				'icon-box-creative'               => [
					'dependency'	=> '',
					'class'			=> 'Kite_Icon_Box_Creative_Widget'
				],
				'social-icon'                     => [
					'dependency'	=> '',
					'class'			=> 'Kite_Social_Icon_Widget'
				],
				'social-link'                     => [
					'dependency'	=> '',
					'class'			=> 'Kite_Social_Link_Widget'
				],
				'count-down'                      => [
					'dependency'	=> '',
					'class'			=> 'Kite_Count_Down_Widget'
				],
				'counter-box'                     => [
					'dependency'	=> '',
					'class'			=> 'Kite_Counter_Box_Widget'
				],
				'instagram-feed'                  => [
					'dependency'	=> '',
					'class'			=> 'Kite_Instagram_Feed_Widget'
				],
				'blog'                            => [
					'dependency'	=> '',
					'class'			=> 'Kite_Blog_Widget'
				],
				'mailPoet'                        => [
					'dependency'	=> '',
					'class'			=> 'Kite_Newsletter_Widget'
				],
				'mailchimp'                       => [
					'dependency'	=> '',
					'class'			=> 'Kite_Mailchimp_Widget'
				],
				'contact-form-7'                  => [
					'dependency'	=> 'WPCF7',
					'class'			=> 'Kite_Contact_Form_7_Widget'
				],
				'woocommerce-products'            => [
					'dependency'	=> 'woocommerce',
					'class'			=> 'Kite_Woocommerce_Products_Widget'
				],
				'woocommerce-handpicked-products' => [
					'dependency'	=> 'woocommerce',
					'class'			=> 'Kite_Woocommerce_HandPicked_Products_Widget'
				],
				'ajax-woocommerce-products'       => [
					'dependency'	=> 'woocommerce',
					'class'			=> 'Kite_Ajax_Woocommerce_Products_Widget'
				],
				'single-product'                  => [
					'dependency'	=> 'woocommerce',
					'class'			=> 'Kite_Single_Product_Widget'
				],
				'product-categories'              => [
					'dependency'	=> 'woocommerce',
					'class'			=> 'Kite_Product_Categories_Widget'
				],
				'cart'                            => [
					'dependency'	=> 'woocommerce',
					'class'			=> 'Kite_Cart_Widget'
				],
				'checkout'                        => [
					'dependency'	=> 'woocommerce',
					'class'			=> 'Kite_Checkout_Widget'
				],
				'my-account'                      => [
					'dependency'	=> 'woocommerce',
					'class'			=> 'Kite_My_Account_Widget'
				],
				'product-page'                    => [
					'dependency'	=> 'woocommerce',
					'class'			=> 'Kite_Product_Page_Widget'
				],
				'products-by-attribute'           => [
					'dependency'	=> 'woocommerce',
					'class'			=> 'Kite_Woocommerce_Products_By_Attributes_Widget'
				],
			),
		);

		if ( defined( 'KITE_THEME_MAIN_NAME' ) && strtolower( KITE_THEME_MAIN_NAME ) == 'pinkmart' ) {
			$widgets['widgets']['imagebox'] = [
				'dependency'	=> '',
				'class'			=> 'Kite_ImageBox_Widget'
			];
		}

		if ( ! empty( $widgets['theme-widgets'] ) ) {
			if ( ! defined( 'KT_PRO_TOOLS_VERSION' ) || version_compare( KT_PRO_TOOLS_VERSION, '1.4.1', '>' ) ) {
				foreach ( $widgets['theme-widgets'] as $element => $info ) {
					$widgetImported = false;
					if ( ! empty( $info['dependency'] ) ) {
						if ( class_exists( $info['dependency'] ) ) {
							require_once dirname( __FILE__ ) . '/widgets/theme-widgets/' . $element . '.php';
							$widgetImported = true;
						}
					} else {
						require_once dirname( __FILE__ ) . '/widgets/theme-widgets/' . $element . '.php';
						$widgetImported = true;
					}

					if ( $widgetImported ) {
						if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.5.0', '>=' ) ) { 
							$widgets_manager->register( new $info['class']() );
						} else {
							$widgets_manager->register_widget_type( new $info['class']() );
						}
					}
				}
			}
		}

		if ( ! empty( $widgets['widgets'] ) ) {
			foreach ( $widgets['widgets'] as $element => $info ) {
				$widgetImported = false;
				if ( ! empty( $info['dependency'] ) ) {
					if ( class_exists( $info['dependency'] ) ) {
						require_once dirname( __FILE__ ) . '/widgets/' . $element . '.php';
						$widgetImported = true;
					}
				} else {
					require_once dirname( __FILE__ ) . '/widgets/' . $element . '.php';
					$widgetImported = true;
				}

				if ( $widgetImported ) {
					if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.5.0', '>=' ) ) { 
						$widgets_manager->register( new $info['class']() );
					} else {
						$widgets_manager->register_widget_type( new $info['class']() );
					}
				}
			}
		}
	}

	/**
	 * add fonts to elementor fonts list
	 *
	 * @param object $additional_fonts
	 * @return array
	 */
	public function add_fonts_to_elementor( $additional_fonts ) {
		$fonts = array(
			'Gayathri' => 'googlefonts',
		);
		return array_merge( $additional_fonts, $fonts );
	}

	/**
	 * add kite icon fonts
	 *
	 * @param array $tabs
	 * @return array
	 */
	public function add_font_icons( $tabs = array() ) {

		if ( false === $icons = maybe_unserialize( get_transient( 'kite_icon_names' ) ) ) {
			$icons = kite_return_icon_names();
		}

		$tabs['kite-icon'] = array(
			'name'          => 'kite-icon',
			'label'         => sprintf( __( '%s Bundled Icons', 'kitestudio-core' ), KITE_THEME_MAIN_NAME ),
			'url'           => KITE_THEME_ASSETS_URI . '/css/icomoon.css',
			'enqueue'       => array( KITE_THEME_ASSETS_URI . '/css/icomoon.css' ),
			'prefix'        => 'icon icon-',
			'displayPrefix' => '',
			'labelIcon'     => 'icon icon-paper-plane2',
			'ver'           => '1.0.0',
			'icons'         => $icons,
		);

		return $tabs;
	}

	/**
	 * add custom css contorl section
	 *
	 * @param object $widget
	 * @param string $section_id
	 * @param [type] $args
	 * @return void
	 */
	public function add_custom_css_controls_section( $widget, $section_id, $args ) {

		if ( 'section_custom_css_pro' !== $section_id ) {
			return;
		}

		if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {

			$widget->start_controls_section(
				'kite_custom_css_section',
				array(
					'label' => __( 'Custom CSS', 'kitestudio-core' ),
					'tab'   => Controls_Manager::TAB_ADVANCED,
				)
			);

			$widget->add_control(
				'custom_css',
				array(
					'type'        => Controls_Manager::CODE,
					'label'       => __( 'Custom CSS', 'kitestudio-core' ),
					'label_block' => true,
					'language'    => 'css',
				)
			);
			ob_start();?>
	<pre>
	Examples:
	// To target main element
	selector { color: red; }
	// For child element
	selector .child-element{ margin: 10px; }
	</pre>
			<?php
			$example = ob_get_clean();

			$widget->add_control(
				'custom_css_description',
				array(
					'raw'             => __( 'Use "selector" keyword to target wrapper element.', 'kitestudio-core' ) . $example,
					'type'            => Controls_Manager::RAW_HTML,
					'content_classes' => 'elementor-descriptor',
					'separator'       => 'none',
				)
			);

			$widget->end_controls_section();
		}

	}

	/**
	 * Render Custom CSS for an Elementor Element
	 *
	 * @param $post_css Post_CSS_File
	 * @param $element Element_Base
	 */
	public function add_post_css( $post_css, $element ) {
		$element_settings = $element->get_settings();

		if ( empty( $element_settings['custom_css'] ) ) {
			return;
		}

		$css = trim( $element_settings['custom_css'] );

		if ( empty( $css ) ) {
			return;
		}
		$css = str_replace( 'selector', $post_css->get_element_unique_selector( $element ), $css );

		// Add a css comment
		$css = sprintf( '/* Start custom CSS for %s, class: %s */', $element->get_name(), $element->get_unique_selector() ) . $css . '/* End custom CSS */';

		$post_css->get_stylesheet()->add_raw_css( $css );
	}

	/**
	 * Register Header and Footer Documents
	 *
	 * @return void
	 */
	public function register_documents() {

		require __DIR__ . '/documents/header.php';
		require __DIR__ . '/documents/footer.php';

		Plugin::$instance->documents->register_document_type( 'header', Documents\Header::class );
		Plugin::$instance->documents->register_document_type( 'footer', Documents\Footer::class );
	}

	/**
	 * Add canvas on elementor header/footer template
	 *
	 * @param string $single_template
	 * @return string
	 */
	public function load_canvas_template( $single_template ) {
		global $post;

		if ( 'elementor_library' === $post->post_type && defined( 'ELEMENTOR_PATH' ) && defined( 'KITE_ELEMENTOR_TEMPLATES' ) ) {
			$template_type = get_post_meta( $post->ID, '_elementor_template_type', true );
			// Limit the template types
			if ( ! in_array( $template_type, array( 'header', 'footer' ) ) ) {
				return $single_template;
			}

			global $kt_template_type;
			$kt_template_type = $template_type;
			// Load elementor header-footer template
			// return ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';
			return KITE_CORE_DIR . 'public/partials/site-header-footer-builder.php';

		}

		return $single_template;
	}

	/**
	 * Register Column Flex Dispaly
	 *
	 * @param object $element
	 * @param string $section_id
	 *
	 */
	public function register_column_flex_display( $element, $section_id ) {
		if ( $element->get_type() == 'column' && $section_id == 'layout' ) {
			$element->add_responsive_control(
				'kt_display_type',
				array(
					'label'        => __( 'Display', 'kitestudio-core' ),

					'type'         => Controls_Manager::SELECT,
					'options'      => array(
						'default' => __( 'default', 'kitestudio-core' ),
						'flex'    => __( 'Flex Horizontal', 'kitestudio-core' ),
					),
					'default'      => 'default',
					'prefix_class' => 'kt%s-display-',
				)
			);
		}

		if ( $element->get_type() == 'widget' && $section_id == '_section_style' ) {
			$element->add_responsive_control(
				'kt_flex',
				array(
					'label'     => __( 'Flex', 'kitestudio-core' ),
					'type'      => Controls_Manager::NUMBER,
					'selectors' => array(
						'{{WRAPPER}}' => 'flex: {{VALUE}}',
					),
				)
			);

			$element->add_responsive_control(
				'kt_flex_order',
				array(
					'label'     => __( 'Flex Order', 'kitestudio-core' ),
					'type'      => Controls_Manager::NUMBER,
					'selectors' => array(
						'{{WRAPPER}}' => 'order: {{VALUE}}',
					),
				)
			);
		}
	}
}

Handler::get_instance();
