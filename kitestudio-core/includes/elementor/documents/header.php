<?php
namespace KiteStudioCore\Elementor\Documents;

use Elementor\Modules\Library\Documents\Library_Document;
use Elementor\Core\DocumentTypes\Post;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Elementor Header library document.
 *
 * Elementor header library document handler class is responsible for
 * handling a document of a header type.
 *
 * @since 1.6
 */
class Header extends Library_Document {

	public static function get_properties() {
		$properties = parent::get_properties();

		$properties['location']    = 'header';
		$properties['support_kit'] = true;

		return $properties;
	}

	public function get_name() {
		return 'header';
	}

	public static function get_title() {
		return __( 'Header', 'kitestudio-core' );
	}

	public function get_css_wrapper_selector() {
		return '.elementor-' . $this->get_main_id();
	}

	protected static function get_editor_panel_categories() {
		// Move to top as active.
		$categories = array(
			'kite-theme-elements' => array(
				'title'  => __( 'Site Header', 'kitestudio-core' ),
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
