<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * In Stock Filter Widget
 *
 * Filter to show in stock products.
 */
// Ensure woocommerce is active
if ( kite_woocommerce_installed() && ! class_exists( 'Kite_WC_Widget_In_Stock_Filter' ) ) {

	class Kite_WC_Widget_In_Stock_Filter extends WC_Widget {

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->widget_cssclass    = 'woocommerce widget_in_stock_filter';
			$this->widget_description = esc_html__( 'Shows in stock filter in a widget which lets you narrow down the list of in stock products.', 'kitestudio-core' );
			$this->widget_id          = 'Kite_woocommerce_in_stock_filter';
			$this->widget_name        = esc_html__( 'Kite WC in stock Filter', 'kitestudio-core' );
			$this->settings           = array(
				'title' => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Filter in Stock', 'kitestudio-core' ),
					'label' => esc_html__( 'Title', 'kitestudio-core' ),
				),
			);

			add_action( 'pre_get_posts', array( $this, 'in_stock_items' ) );

			parent::__construct();
		}



		function in_stock_items( $query ) {

			if ( ! is_admin() && ( $query->is_post_type_archive( 'product' ) || $query->is_tax( get_object_taxonomies( 'product' ) ) ) ) {

				if ( isset( $_GET['availability'] ) && $_GET['availability'] == 'in_stock' ) {
					$meta_query   = WC()->query->get_meta_query();
					$meta_query[] = array(
						'key'     => '_stock_status',
						'value'   => 'outofstock', // instock,outofstock
						'compare' => 'NOT IN',
					);

					if ( isset( $_GET['status'] ) && $_GET['status'] == 'sale' ) {
						$product_ids_on_sale = wc_get_product_ids_on_sale();
						$query->set( 'post__in', (array) $product_ids_on_sale );
					}

					$query->set( 'meta_query', $meta_query );
				}
			}
		}


		/**
		 * widget function.
		 *
		 * @see WP_Widget
		 * @param array $args
		 * @param array $instance
		 */

		public function widget( $args, $instance ) {
			global $wp, $wp_the_query;

			extract( $args );

			if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
				return;
			}

			if ( ! $wp_the_query->post_count ) {
				return;
			}

			$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
#
			if ( get_option( 'permalink_structure' ) == '' ) {
				$link = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
			} else {
				$link = preg_replace( '%\/page/[0-9]+%', '', home_url( $wp->request ) );
			}

			if ( get_search_query() ) {
				$link = add_query_arg( 's', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
			}

			// Min/Max
			if ( isset( $_GET['min_price'] ) ) {
				$link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
			}

			if ( isset( $_GET['max_price'] ) ) {
				$link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
			}

			if ( ! empty( $_GET['post_type'] ) ) {

				$link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
			}

			if ( ! empty( $_GET['product_cat'] ) ) {
				$link = add_query_arg( 'product_cat', wc_clean( $_GET['product_cat'] ), $link );
			}

			if ( ! empty( $_GET['product_tag'] ) ) {
				$link = add_query_arg( 'product_tag', wc_clean( $_GET['product_tag'] ), $link );
			}

			if ( ! empty( $_GET['orderby'] ) ) {
				$link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
			}

			// Min Rating Arg
			if ( isset( $_GET['rating_filter'] ) ) {
				$link = add_query_arg( 'rating_filter', wc_clean( $_GET['rating_filter'] ), $link );
			}

			// KiteSt
			if ( ! empty( $_GET['status'] ) ) {
				$link = add_query_arg( 'status', wc_clean( $_GET['status'] ), $link );
			}

			if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
				foreach ( $_chosen_attributes as $attribute => $data ) {
					$taxonomy_filter = 'filter_' . wc_attribute_taxonomy_slug( $attribute );

					$link = add_query_arg( wc_clean( $taxonomy_filter ), wc_clean( implode( ',', $data['terms'] ) ), $link );

					if ( 'or' == $data['query_type'] ) {
						$link = add_query_arg( wc_clean( str_replace( 'pa_', 'query_type_', $attribute ) ), 'or', $link );
					}
				}
			}

			// Echo wrapper of widget & title
			echo wp_kses_post( $before_widget );
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}

			echo '<ul class="in-stock-filter">';

			if ( isset( $_GET['availability'] ) && $_GET['availability'] == 'in_stock' ) {
				echo '<li class="chosen"><a href="' . esc_url( $link ) . '"><span></span>' . esc_html__( 'In Stock Items Only', 'kitestudio-core' ) . '</a></li>';
			} else {
				$url     = add_query_arg( array( 'availability' => 'in_stock' ), $link );
				echo '<li><a href="' . esc_url( $url ) . '"><span></span>' . esc_html__( 'In Stock Items Only', 'kitestudio-core' ) . '</a></li>';

			}

			echo '</ul>';

			echo wp_kses_post( $after_widget );
		}
	}
}
