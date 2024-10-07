<?php

/**
 * handling woocommerce functionalities
 *
 * @since 1.7.1
 */
class Kite_Woocommerce {

	/**
	 * Holds the current instance of this class
	 *
	 */
	protected static $instance = null;

	/**
	 * Retrieves class instance
	 *
	 * @return Kite_Woocommerce
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor method
	 */
	public function __construct() {

		if ( ! kite_woocommerce_installed() ) {
			return;
		}

		require_once KITE_THEME_LIB . '/forms/fieldtemplate.php';

		$this->custom_fields_for_attributes_hooks();

		// WordPress Media Uploader
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}

	/**
	 * Enqueue amdin scripts
	 *
	 * @since 1.7.1
	 *
	 * @return void
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_script( 'media-upload' );

		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );

		wp_enqueue_media();
		wp_enqueue_script( 'media' );
	}

	/**
	 * add related hooks for adding custom attribute fields
	 *
	 * @since 1.7.1
	 *
	 * @return void
	 */
	public function custom_fields_for_attributes_hooks() {
		$attribute_taxonamies = wc_get_attribute_taxonomies();
		foreach ( $attribute_taxonamies as $tax ) {

			// Adding Color and Image option to all attributes
			add_action( 'pa_' . $tax->attribute_name . '_add_form_fields', array( $this, 'add_custom_field' ) );
			add_action( 'pa_' . $tax->attribute_name . '_edit_form_fields', array( $this, 'edit_custom_field' ) );
			add_action( 'edited_pa_' . $tax->attribute_name, array( $this, 'save_custom_meta' ), 10, 3 );
			add_action( 'create_pa_' . $tax->attribute_name, array( $this, 'save_custom_meta' ), 10, 3 );
		}
	}

	/**
	 * Add custom field for attributes
	 *
	 * @since 1.7.1
	 *
	 * @return void
	 */
	public function add_custom_field() {
		?>
		<tr class="form-field">
		   <td>
				<div class="form-field color-field clear-after all_taxonamies_color">
					<label for="tag-color"><?php esc_html_e( 'Color Swatch', 'kitestudio-core' ); ?></label>
					<div class="color-field-wrap clear-after">
						<input name="term-color" data-alpha="true" type="text" value="" class="colorinput"/>
						<div class="color-view"></div>
					</div>
					<p><?php esc_html_e( 'Select a color as a swatch of this term.', 'kitestudio-core' ); ?></p>
				</div>
			</td>
		</tr>

		<tr class="form-field">
			<td>
				<div class="form-field term-header-image-wrap">
					<label for="tag-image"><?php esc_html_e( 'Image Swatch', 'kitestudio-core' ); ?></label>
					<div id="product_cat_background_image" data-default-img="<?php echo esc_url( wc_placeholder_img_src() ); ?>" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px"/></div>
					<div style="line-height: 60px;">
						<input type="hidden" id="header-background-image" name="term-image-id" value= />
						<button type= type="button" class="upload_wc_cat_header_image_button button"><?php esc_html_e( 'Upload/Add image', 'kitestudio-core' ); ?></button>
						<button type="button" class="remove_wc_cat_header_image_button button"><?php esc_html_e( 'Remove image', 'kitestudio-core' ); ?></button>
					</div>
					<p style="clear: left;" ><?php esc_html_e( 'Select an image as a swatch of this term.', 'kitestudio-core' ); ?></p>
				</div>
			</td>
		</tr>
		<?php
	}

	/**
	 * Edit Custom Fields
	 *
	 * @since 1.7.1
	 *
	 * @param object $term
	 * @return void
	 */
	public function edit_custom_field( $term ) {
		$term_color    = get_term_meta( $term->term_id, 'term-color', true );
		$term_image_id = absint( get_term_meta( $term->term_id, 'term-image-id', true ) );
		if ( $term_image_id ) :
			$image = wp_get_attachment_url( $term_image_id );
		else :
			$image = wc_placeholder_img_src();
		endif;
		?>
		 <tr class="form-field term-color-wrap">
			 <th scope="row"><label for="color"><?php esc_html_e( 'Color Swatch', 'kitestudio-core' ); ?></label></th>
			<td>
				<div class="field color-field clear-after all_taxonamies_color">
					<div class="color-field-wrap clear-after">
						<input name="term-color" data-alpha="true" type="text" value="<?php echo esc_attr( $term_color ); ?>" class="colorinput"/>
						<div class="color-view"></div>
					</div>
				</div>
				<p class="color"><?php esc_html_e( 'Select a color as a swatch of this term.', 'kitestudio-core' ); ?></p>
			</td>
		</tr>

		<tr class="form-field term-image-wrap">
			<th scope="row"><label for="Image"><?php esc_html_e( 'Image swatch', 'kitestudio-core' ); ?></label></th>
			<td>
				<div class="form-field term-header-image-wrap">
					<div id="product_cat_background_image" data-default-img="<?php echo esc_url( wc_placeholder_img_src() ); ?>" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px"/></div>
					<div style="line-height: 60px;">
							<input type="hidden" id="header-background-image" name="term-image-id" value="<?php echo esc_attr( $term_image_id ); ?>" />
							<button type= type="button" class="upload_wc_cat_header_image_button button"><?php esc_html_e( 'Upload/Add image', 'kitestudio-core' ); ?></button>
							<button type="button" class="remove_wc_cat_header_image_button button"><?php esc_html_e( 'Remove image', 'kitestudio-core' ); ?></button>
					</div>
				</div>
				<p class="image"><?php esc_html_e( 'Select an Image as a swatch of this term.', 'kitestudio-core' ); ?></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Saving custom fields values added to attributes
	 *
	 * @param int $term_id
	 * @param string $tt_id
	 * @param string $taxonomy
	 * @return void
	 */
	public function save_custom_meta( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( isset( $_POST['term-color'] ) ) {
			update_term_meta( $term_id, 'term-color', sanitize_text_field( $_POST['term-color'] ) );
		}

		if ( isset( $_POST['term-image-id'] ) ) {
			update_term_meta( $term_id, 'term-image-id', sanitize_text_field( $_POST['term-image-id'] ) );
		}
		delete_transient( 'wc_term_counts' );
	}
}
