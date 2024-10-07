<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Price Filter Widget and related functions
 *
 * Generates a range list to filter products by price.
 */
// Ensure woocommerce is active

if ( kite_woocommerce_installed() && ! class_exists( 'Kite_WC_Widget_Ranged_Price_Filter' ) ) {
	class Kite_WC_Widget_Ranged_Price_Filter extends WC_Widget {

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->widget_cssclass    = 'woocommerce widget_ranged_price_filter';
			$this->widget_description = esc_html__( 'Shows a price filter list in a widget which lets you narrow down the list of shown products when viewing product categories.', 'kitestudio-core' );
			$this->widget_id          = 'Kite_woocommerce_ranged_price_filter';
			$this->widget_name        = esc_html__( 'Kite WC Ranged Price Filter List', 'kitestudio-core' );
			$this->settings           = array(
				'title'            => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Filter by price', 'kitestudio-core' ),
					'label' => esc_html__( 'Title', 'kitestudio-core' ),
				),
				'price_range_size' => array(
					'type'  => 'number',
					'step'  => 1,
					'min'   => 1,
					'max'   => '',
					'std'   => 100,
					'label' => esc_html__( 'Range size', 'kitestudio-core' ),
				),
				'max_price_ranges' => array(
					'type'  => 'number',
					'step'  => 1,
					'min'   => 1,
					'max'   => '',
					'std'   => 5,
					'label' => esc_html__( 'Max number of ranges', 'kitestudio-core' ),
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

			$min_price = isset( $_GET['min_price'] ) ? wc_clean( $_GET['min_price'] ) : 0;
			$max_price = isset( $_GET['max_price'] ) ? wc_clean( $_GET['max_price'] ) : 0;

			$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

			if ( get_option( 'permalink_structure' ) == '' ) {
				$link = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
			} else {
				$link = preg_replace( '%\/page/[0-9]+%', '', home_url( $wp->request ) );
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

			if ( ! empty( $_GET['orderby'] ) ) {
				$link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
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
					$link            = add_query_arg( wc_clean( $taxonomy_filter ), wc_clean( implode( ',', $data['terms'] ) ), $link );

					if ( 'or' == $data['query_type'] ) {
						$link = add_query_arg( wc_clean( str_replace( 'pa_', 'query_type_', $attribute ) ), 'or', $link );
					}
				}
			}

			$min      = $max = 0;

			// Find min and max price in current result set
			$prices = $this->get_filtered_price();
			$min    = floor( $prices->min_price );
			$max    = ceil( $prices->max_price );

			if ( $min == $max ) {
				return;
			}

			/**
			 * Adjust max if the store taxes are not displayed how they are stored.
			 * Min is left alone because the product may not be taxable.
			 * Kicks in when prices excluding tax are displayed including tax.
			 */
			if ( wc_tax_enabled() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) && ! wc_prices_include_tax() ) {
				$tax_classes = array_merge( array( '' ), WC_Tax::get_tax_classes() );
				$class_max   = $max;

				foreach ( $tax_classes as $tax_class ) {
					if ( $tax_rates = WC_Tax::get_rates( $tax_class ) ) {
						$class_max = $max + WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $max, $tax_rates ) );
					}
				}

				$max = $class_max;
			}

			// Echo wrapper of widget & title
			echo wp_kses_post( $before_widget );
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}

			$count      = 0;
			$range_size = intval( $instance['price_range_size'] );
			$max_ranges = ( intval( $instance['max_price_ranges'] ) - 1 );

			echo '<ul class="ranged-price-filter">';

			if ( $min_price >= $min ) {
				echo '<li><a href="' . esc_url( $link ) . '">' . esc_html__( 'All', 'kitestudio-core' ) . '</a></li>';
			} else {
				echo '<li class="current">' . esc_html__( 'All', 'kitestudio-core' ) . '</li>';
			}

			for ( $range_min = $min; $range_min < ( $max + $range_size ); $range_min += $range_size ) {
				$range_max = $range_min + $range_size;

				// Hide empty price ranges?
				// Are there products in this price range?
				if ( ( $max + $range_size ) < $range_max ) {
					continue;
				}

				$count++;

				$min_price_output = wc_price( $range_min );

				if ( $count == $max_ranges ) {
					$price_output = $min_price_output . '+';

					if ( $range_min != $min_price ) {
						$url     = add_query_arg(
							array(
								'min_price' => $range_min,
								'max_price' => $max,
							),
							$link
						);
						echo '<li><a href="' . esc_url( $url ) . '">' . wp_kses_post( $price_output ) . '</a></li>';
					} else {
						echo '<li class="current">' . wp_kses_post( $price_output ) . '</li>';
					}

					break; // Max price ranges limit reached, break loop
				} else {
					$price_output = $min_price_output . ' - ' . wc_price( $range_min + $range_size );

					if ( $range_min == $min_price && $range_max == $max_price ) {
						echo '<li class="current">' . wp_kses_post( $price_output ) . '</li>';
					} else {
						$url     = add_query_arg(
							array(
								'min_price' => $range_min,
								'max_price' => $range_max,
							),
							$link
						);
						echo '<li><a href="' . esc_url( $url ) . '">' . wp_kses_post( $price_output ) . '</a></li>';
					}
				}
			}

			echo '</ul>';

			echo wp_kses_post( $after_widget );
		}

		protected function get_filtered_price() {
			global $wpdb, $wp_the_query;

			$args       = $wp_the_query->query_vars;
			$tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
			$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

			if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {

				$tax_query[] = array(
					'taxonomy' => $args['taxonomy'],
					'terms'    => array( $args['term'] ),
					'field'    => 'slug',
				);
			}

			foreach ( $meta_query + $tax_query as $key => $query ) {
				if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
					unset( $meta_query[ $key ] );
				}
			}

			$meta_query = new WP_Meta_Query( $meta_query );
			$tax_query  = new WP_Tax_Query( $tax_query );

			$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
			$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

			$sql  = "SELECT min( CAST( price_meta.meta_value AS UNSIGNED ) ) as min_price, max( CAST( price_meta.meta_value AS UNSIGNED ) ) as max_price FROM {$wpdb->posts} ";
			$sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
			$sql .= " 	WHERE {$wpdb->posts}.post_type = 'product'
						AND {$wpdb->posts}.post_status = 'publish'
						AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
						AND price_meta.meta_value > '' ";
			$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

			if ( $search = WC_Query::get_main_search_query_sql() ) {
				$sql .= ' AND ' . $search;
			}

			return $wpdb->get_row( $sql );
		}
	}


}
