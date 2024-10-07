<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product sorting filter
 *
 * Generates a order by list.
 */
// Ensure woocommerce is active
if ( kite_woocommerce_installed() && ! class_exists( 'Kite_WC_Widget_Order_By_Filter' ) ) {

	class Kite_WC_Widget_Order_By_Filter extends WC_Widget {

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->widget_cssclass    = 'woocommerce widget_order_by_filter';
			$this->widget_description = esc_html__( 'Display a product sorting list.', 'kitestudio-core' );
			$this->widget_id          = 'Kite_woocommerce_order_by_filter';
			$this->widget_name        = esc_html__( 'Kite WC Product Sorting', 'kitestudio-core' );
			$this->settings           = array(
				'title' => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Sort product by', 'kitestudio-core' ),
					'label' => esc_html__( 'Title', 'kitestudio-core' ),
				),
			);

			parent::__construct();
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

			if ( get_option( 'permalink_structure' ) == '' ) {
				$link = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
			} else {
				$link = preg_replace( '%\/page/[0-9]+%', '', home_url( $wp->request ) );
			}

			// Min/Max
			if ( isset( $_GET['min_price'] ) ) {
				$link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
			}

			if ( isset( $_GET['max_price'] ) ) {
				$link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
			}

			if ( get_search_query() ) {
				$link = add_query_arg( 's', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
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

			// Min Rating Arg
			if ( isset( $_GET['rating_filter'] ) ) {
				$link = add_query_arg( 'rating_filter', wc_clean( $_GET['rating_filter'] ), $link );
			}

			// KiteSt
			// On Sale Arg
			if ( isset( $_GET['status'] ) && $_GET['status'] == 'sale' ) {
				$link = add_query_arg( 'status', wc_clean( $_GET['status'] ), $link );
			}
			// In stock Arg
			if ( isset( $_GET['availability'] ) && $_GET['availability'] == 'in_stock' ) {
				$link = add_query_arg( 'availability', wc_clean( $_GET['availability'] ), $link );
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

			$orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
			$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
			$catalog_orderby_options = apply_filters(
				'woocommerce_catalog_orderby',
				array(
					'menu_order' => esc_html__( 'Default sorting', 'kitestudio-core' ),
					'popularity' => esc_html__( 'Sort by popularity', 'kitestudio-core' ),
					'rating'     => esc_html__( 'Sort by average rating', 'kitestudio-core' ),
					'date'       => esc_html__( 'Sort by newness', 'kitestudio-core' ),
					'price'      => esc_html__( 'Sort by price: low to high', 'kitestudio-core' ),
					'price-desc' => esc_html__( 'Sort by price: high to low', 'kitestudio-core' ),
				)
			);

			if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
				unset( $catalog_orderby_options['rating'] );
			}

			// Echo wrapper of widget & title
			echo wp_kses_post( $before_widget );

			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}

			echo '<ul class="order-by-filter">';

			foreach ( $catalog_orderby_options as $key => $name ) {
				if ( $orderby == $key ) {
					echo '<li class="current">' . esc_attr( $name ) . '</li>';
				} else {
					// Add 'orderby' URL query string
					$link    = add_query_arg( 'orderby', $key, $link );
					echo '<li><a href="' . esc_url( $link ) . '">' . esc_attr( $name ) . '</a></li>';
				}
			}

			echo '</ul>';

			echo wp_kses_post( $after_widget );
		}
	}
}
