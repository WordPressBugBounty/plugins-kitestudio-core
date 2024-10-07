<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_nonce_field( 'theme-post-meta-form', KITE_THEME_NAME_SEO . '_post_nonce' );

?>

<div class="kt-container post-meta">
	<div class="kt-main">
		<?php
			$this->kite_set_working_directory( kite_path_combine( KITE_THEME_LIB, 'forms/templates' ) );
			echo $this->kite_get_template( 'section', $vars );
		?>
	</div>
</div>
