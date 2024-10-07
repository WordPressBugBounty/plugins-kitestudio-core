<?php
/**
 * Header|Footer builder template
 */
Elementor\Plugin::$instance->frontend->add_body_class( 'elementor-template-full-width' );

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="'width=device-width, initial-scale=1'">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> style="overflow: visible;">
<?php
wp_body_open();
global $kt_template_type;
if ( $kt_template_type == 'header' ) {
	$container_class = kite_opt( 'menu-container', false ) ? 'fullwidth' : 'container';
	?>
	<header id="kt-header" class="kt-elementor-template <?php echo esc_attr( $container_class ); ?>">
	<?php
	Elementor\Plugin::$instance->modules_manager->get_modules( 'page-templates' )->print_content();
	?>
	<div class="kt-header-builder-overlay"></div>
	</header>
	<?php wp_footer(); ?>
	<?php
} else {
	$container_class = kite_opt( 'footerFullwidth', false ) ? 'fullwidth' : 'container';
	wp_footer();
	?>
	<footer class="kt-elementor-template <?php echo esc_attr( $container_class ); ?>" >
	<?php
	Elementor\Plugin::$instance->modules_manager->get_modules( 'page-templates' )->print_content();
	?>
	</footer>
	<?php
}
?>

</body>
</html>
