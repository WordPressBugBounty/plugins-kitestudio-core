<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Wishlist Widget
 */
// Ensure woocommerce is active
if ( kite_woocommerce_installed() && ! class_exists( 'Kite_Woocommerce_Wishlist_Icon_Widget' ) ) {
	class Kite_Woocommerce_Wishlist_Icon_Widget extends WP_Widget {

		public function __construct() {
			parent::__construct(
				'woocommerce-wishlist-icon', // Base ID
				'Woocommerce Wishlist Icon', // Name
				array( 'description' => esc_html__( 'Kite WC Wishlist Icon.', 'kitestudio-core' ) ) // Args
			);
		}
		public function widget( $args, $instance ) {

			global $post;
			extract( $args );
			global $woocommerce;
			global $yith_wcwl;
			// Our variables from the widget settings
			$type = isset( $instance['type'] ) ? esc_attr( $instance['type'] ) : '';
			?>
			<?php if ( class_exists( 'YITH_WCWL' ) ) : ?>
			<a href="<?php echo esc_url( $yith_wcwl->get_wishlist_url() ); ?>" class="tools_button
								<?php
								if ( $type == 'light' ) {
									?>
				 light <?php } ?>">
				<div class="wishlist-content">
					<div class="wishlist-contentcount"><?php echo yith_wcwl_count_products(); ?></div>
				</div>
				<span class="icon icon-heart"></span>
			</a>
			<?php endif; ?>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['type'] = strip_tags( $new_instance['type'] );

			return $instance;
		}

		public function form( $instance ) {

			// Set up some default widget settings
			$defaults = array(
				'type' => 'dark',
			);

			$instance = wp_parse_args( (array) $instance, $defaults );
			?>

			<!-- Type: Select Box -->
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html_e( 'Icon Style ( Dark or light ):', 'kitestudio-core' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" class="widefat">
					<option
					<?php
					if ( 'dark' == esc_attr( $instance['type'] ) ) {
						echo 'selected="selected"';}
					?>
					>dark</option>
					<option
					<?php
					if ( 'light' == esc_attr( $instance['type'] ) ) {
						echo 'selected="selected"';}
					?>
					>light</option>
				</select>
				</p>
			<?php
		}
	}
}
