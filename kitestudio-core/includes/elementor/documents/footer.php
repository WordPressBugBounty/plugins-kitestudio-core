<?php
namespace KiteStudioCore\Elementor\Documents;

use Elementor\Modules\Library\Documents\Library_Document;
use Elementor\Core\DocumentTypes\Post;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Elementor footer library document.
 *
 * Elementor footer library document handler class is responsible for
 * handling a document of a footer type.
 *
 * @since 1.6
 */
class Footer extends Library_Document {

	public static function get_properties() {
		$properties = parent::get_properties();

		$properties['location']    = 'footer';
		$properties['support_kit'] = true;

		return $properties;
	}

	public function get_name() {
		return 'footer';
	}

	public static function get_title() {
		return __( 'Footer', 'kitestudio-core' );
	}

	public function get_css_wrapper_selector() {
		return '.elementor-' . $this->get_main_id();
	}

	protected static function get_editor_panel_categories() {
		// Move to top as active.
		$categories = array(
			'kite-theme-elements' => array(
				'title'  => __( 'Site Footer', 'kitestudio-core' ),
				'active' => true,
			),
		);

		return $categories + parent::get_editor_panel_categories();
	}

	protected function register_controls() {
		parent::register_controls();

		Post::register_style_controls( $this );
	}
}
