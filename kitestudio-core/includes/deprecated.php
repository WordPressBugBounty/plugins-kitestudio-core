<?php
add_action( 'init', 'kite_change_deprecated_constants' );
function kite_change_deprecated_constants() {
	$constants = array(
		'THEME_MAIN_NAME',
		'THEME_NAME',
		'THEME_SLUG',
		'THEME_NAME_SEO',
		'THEME_AUTHOR',
		'THEME_VERSION',
		'OPTIONS_KEY',
		'PRODUCT_ID',
		'PACK_MODE',
		'DEFAULT_PRODUCT_STYLE',
		'THEME_DIR',
		'THEME_LIB',
		'THEME_PLUGINS',
		'THEME_CSS',
		'THEME_URI',
		'THEME_LIB_URI',
		'THEME_ASSETS_URI',
		'THEME_IMAGES_URI',
	);

	foreach ( $constants as $key => $constant ) {
		if ( defined( 'KITEST_' . $constant ) && ! defined( 'KITE_' . $constant ) ) {
			define( 'KITE_' . $constant, constant( 'KITEST_' . $constant ) );
		}
	}

	if ( ! defined( 'KITE_DEFAULT_PRODUCT_STYLE' ) ) {
		define( 'KITE_DEFAULT_PRODUCT_STYLE', 'style1' );
	}
}
