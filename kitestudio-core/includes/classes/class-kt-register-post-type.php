<?php
abstract class Kite_Post_Type {

	protected $post_type;

	public function __construct( $post_type ) {

		$this->post_type = $post_type;

		add_action( 'after_setup_theme', array( &$this, 'kite_create_post_type' ), 0 );

		add_action( 'add_meta_boxes', array( &$this, 'kite_add_meta_boxes' ) );
		add_action( 'admin_print_scripts-post-new.php', array( &$this, 'kite_init_scripts' ) );
		add_action( 'admin_print_scripts-post.php', array( &$this, 'kite_init_scripts' ) );

		/* Save post meta on the 'save_post' hook. */
		add_action( 'save_post', array( &$this, 'kite_save_data' ), 10, 2 );

	}

	public function kite_save_data( $post_id = false, $post = false ) {

		/* Verify the nonce before proceeding. */
		$nonce = KITE_THEME_NAME_SEO . '_post_nonce';

		if ( ! isset( $_POST[ $nonce ] ) || ! wp_verify_nonce( $_POST[ $nonce ], 'theme-post-meta-form' ) ) {
			return $post_id;
		}

		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( $post->post_type != $this->post_type || ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// CRUD Operation
		foreach ( $this->kite_get_options_for_store() as $key => $settings ) {
			// Let the derived class intercept the process
			if ( $this->kite_on_process_field_for_store( $post_id, $key, $settings ) ) {
				continue;
			}

			if ( isset( $_POST[ $key ] ) ) {
				if ( !is_array( $_POST[ $key ] ) ) {
					$posted_val = sanitize_text_field( $_POST[ $key ] );
				} else {
					$posted_val = $_POST[ $key ];
				}
			} else {
				$posted_val = '';
			}

			$val       = get_post_meta( $post_id, $key, false );

			if ( is_array( $posted_val ) ) {
				// Insert
				if ( ! empty( $posted_val ) && empty( $val ) ) {
					add_post_meta( $post_id, $key, $posted_val );

				}
				// Delete
				elseif ( ! empty( $val ) && empty( $posted_val ) ) {
					delete_post_meta( $post_id, $key );

					// Delete the attachment as well
					if ( $settings['type'] == 'upload' ) {
						kite_delete_attachment( $val );
					}
				}
				// Update
				elseif ( ! empty( $val ) && ! empty( $posted_val ) && $posted_val != $val ) {
					update_post_meta( $post_id, $key, $posted_val );
				}
			} else {
				// Insert
				if ( $posted_val != '' && empty( $val ) ) {
					add_post_meta( $post_id, $key, $posted_val );

				}
				// Delete
				elseif ( ! empty( $val ) && $posted_val == '' ) {
					delete_post_meta( $post_id, $key );

					// Delete the attachment as well
					if ( $settings['type'] == 'upload' ) {
						kite_delete_attachment( $val );
					}
				}
				// Update
				elseif ( $posted_val != '' && ! empty( $val ) && $posted_val != $val ) {
					update_post_meta( $post_id, $key, $posted_val );
				}
			}
		}

		return $post_id;
	}

	public function kite_on_process_field_for_store( $post_id, $key, $settings ) {
		return false;
	}

	public function kite_create_post_type() {

	}

	protected function kite_get_options_for_store() {
		$options = $this->kite_get_options();
		$values  = array();

		foreach ( $options as $box ) {
			foreach ( $box['options'] as $section ) {
				foreach ( $section['fields'] as $key => $field ) {
					$ignore = kite_array_value( 'dontsave', kite_array_value( 'meta', $field, array() ), false );

					if ( $ignore ) {
						continue;
					}

					$values[ $key ] = $field;
				}
			}
		}

		return $values;
	}

	protected function kite_get_options() {
		return array();
	}

	function kite_add_meta_boxes() {

		require_once KITE_THEME_LIB . '/forms/fieldtemplate.php';
		require_once KITE_THEME_LIB . '/forms/post-options-provider.php';

		$options = $this->kite_get_options();

		foreach ( $options as $box ) {

			add_meta_box(
				$box['id'], // $id
				$box['title'], // $title
				array( &$this, 'kite_show_meta_box' ), // $callback
				$this->post_type, // $page
				$box['context'], // $context
				$box['priority'], // $priority
				$box['options']
			);

		}

	}

	function kite_show_meta_box( $post, $metabox ) {
		$args = $metabox['args'];

		$form = new Kite_field_template( new Kite_post_options_provider(), KITE_CORE_DIR . 'includes/post-types' );

		echo $form->kite_get_template( 'meta-form', $args );
	}


	public function kite_init_scripts() {
		global $post_type;

		if ( $post_type != $this->post_type ) {
			return;
		}

		$this->kite_register_scripts();
		$this->kite_enqueue_scripts();
	}

	protected function kite_register_scripts() {
		wp_register_script( 'jquery-easing', KITE_THEME_ASSETS_URI . '/js/jquery.easing.min.js', array( 'jquery' ), '1.3', true );

		wp_register_script( 'wp-color-picker-alpha', KITE_THEME_LIB_URI . '/admin/scripts/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '3.0.0', true );

		wp_register_style( 'chosen', KITE_THEME_LIB_URI . '/admin/css/chosen.css', false, '1.0.0', 'screen' );
		wp_register_script( 'chosen', KITE_THEME_LIB_URI . '/admin/scripts/chosen.jquery.min.js', array( 'jquery' ), '1.0.0', true );

		wp_register_style( 'theme-admin-css', KITE_THEME_LIB_URI . '/admin/css/style.css', false, '1.0.0', 'screen' );
		wp_register_script( 'theme-admin-script', KITE_THEME_LIB_URI . '/admin/scripts/admin.js', array( 'jquery' ), '1.0.0', true );
	}

	protected function kite_enqueue_scripts() {
		wp_enqueue_script( 'hoverIntent' );
		wp_enqueue_script( 'jquery-easing' );

		// Include wpcolorpicker + its patch to support alpha chanel
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'colorpickerAlpha' );

		wp_enqueue_style( 'chosen' );
		wp_enqueue_script( 'chosen' );

		wp_enqueue_style( 'theme-admin' );
		wp_enqueue_script( 'theme-admin' );
	}
}

Kite_Core_Loader::get_instance()->require_files(
	KITE_CORE_DIR . 'includes/post-types',
	array(
		'blog',
		'page',
		'product',
	)
);
