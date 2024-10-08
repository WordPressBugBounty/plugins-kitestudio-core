<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Layered Navigation Fitlers Widget
 *
 * Widget to show all active filters
 */
// Ensure woocommerce is active
if ( kite_woocommerce_installed() && ! class_exists( 'Kite_WC_Widget_Layered_Nav_Filters' ) ) {

	class Kite_WC_Widget_Layered_Nav_Filters extends WC_Widget {

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->widget_cssclass    = 'woocommerce widget_layered_nav_filters';
			$this->widget_description = esc_html__( 'Shows active layered nav filters so users can see and deactivate them.', 'kitestudio-core' );
			$this->widget_id          = 'woocommerce_layered_nav_filters';
			$this->widget_name        = esc_html__( 'Kite WC Layered Nav Filters', 'kitestudio-core' );
			$this->settings           = array(
				'title' => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Active Filters', 'kitestudio-core' ),
					'label' => esc_html__( 'Title', 'kitestudio-core' ),
				),
			);

			parent::__construct();
		}

		/**
		 * Get current page URL for layered nav items.
		 *
		 * @return string
		 */
		protected function get_page_base_url() {
			if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
				$link = esc_url( home_url( '/' ) );
			} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
				$link = get_post_type_archive_link( 'product' );
			} elseif ( is_product_category() ) {
				$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
			} elseif ( is_product_tag() ) {
				$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
			} else {
				$queried_object = get_queried_object();
				$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
			}

			// Min/Max
			if ( isset( $_GET['min_price'] ) ) {
				$link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
			}

			if ( isset( $_GET['max_price'] ) ) {
				$link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
			}

			// Orderby
			if ( isset( $_GET['orderby'] ) ) {
				$link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
			}

			/***** KiteSt codes */
			// On Sale Arg
			if ( isset( $_GET['status'] ) && $_GET['status'] == 'sale' ) {
				$link = add_query_arg( 'status', wc_clean( $_GET['status'] ), $link );
			}
			// In stock Arg
			if ( isset( $_GET['availability'] ) && $_GET['availability'] == 'in_stock' ) {
				$link = add_query_arg( 'availability', wc_clean( $_GET['availability'] ), $link );
			}
			/***** End of KiteSt codes */

			/**
			 * Search Arg.
			 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
			 */
			if ( get_search_query() ) {
				$link = add_query_arg( 's', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
			}

			// Post Type Arg
			if ( isset( $_GET['post_type'] ) ) {
				$link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
			}

			// Min Rating Arg
			if ( isset( $_GET['rating_filter'] ) ) {
				$link = add_query_arg( 'rating_filter', wc_clean( $_GET['rating_filter'] ), $link );
			}

			// All current filters
			if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
				foreach ( $_chosen_attributes as $name => $data ) {
					$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
					if ( ! empty( $data['terms'] ) ) {
						$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
					}
					if ( 'or' == $data['query_type'] ) {
						$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
					}
				}
			}

			return $link;
		}


		/**
		 * widget function.
		 *
		 * @see WP_Widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {

			if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
				return;
			}

			// Price
			$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
			$min_price          = isset( $_GET['min_price'] ) ? wc_clean( $_GET['min_price'] ) : 0;
			$max_price          = isset( $_GET['max_price'] ) ? wc_clean( $_GET['max_price'] ) : 0;
			$rating_filter      = isset( $_GET['rating_filter'] ) ? array_filter( array_map( 'absint', explode( ',', $_GET['rating_filter'] ) ) ) : array();
			$base_link          = $this->get_page_base_url();

			// KiteSt
			$on_sale   = ( isset( $_GET['status'] ) && $_GET['status'] == 'sale' ) ? true : false;
			$in_stock  = ( isset( $_GET['availability'] ) && $_GET['availability'] == 'in_stock' ) ? true : false;
			$is_search = ( get_search_query() ) ? true : false;

			if ( 0 < count( $_chosen_attributes ) || 0 < $min_price || 0 < $max_price || ! empty( $rating_filter ) || $on_sale || $in_stock || $is_search ) {

				$this->widget_start( $args, $instance );
				echo "<button class='clearfilters'>" . sprintf( "<a href='%s'>%s</a>", get_permalink( wc_get_page_id( 'shop' ) ), esc_html__( 'Clear All', 'kitestudio-core' ) ) . '</button>';
				echo '<ul>';

				// By KiteSt
				if ( get_search_query() ) {

					global $wp;

					if ( get_option( 'permalink_structure' ) == '' ) {
						$link = remove_query_arg( array( 'page', 'paged', 's' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
					} else {
						if ( is_shop() ) {
							$link = wc_get_page_permalink( 'shop' );
						} else {
							$link = preg_replace( '%\/page/[0-9]+%', '', home_url( $wp->request ) );
						}
					}

					echo '<li class="chosen search-keyword-active"><a href="' . esc_url( $link ) . '">' . esc_html__( 'Search result for "', 'kitestudio-core' ) . get_search_query() . '"' . '</a></li>';
				}

				// Attributes
				if ( ! empty( $_chosen_attributes ) ) {
					foreach ( $_chosen_attributes as $taxonomy => $data ) {
						foreach ( $data['terms'] as $term_slug ) {
							if ( ! $term = get_term_by( 'slug', $term_slug, $taxonomy ) ) {
								continue;
							}

							$filter_name    = 'filter_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
							$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( $_GET[ $filter_name ] ) ) : array();
							$current_filter = array_map( 'sanitize_title', $current_filter );
							$new_filter     = array_diff( $current_filter, array( $term_slug ) );

							$link = remove_query_arg( array( 'add-to-cart', $filter_name ), $base_link );

							if ( count( $new_filter ) > 0 ) {
								$link = add_query_arg( $filter_name, implode( ',', $new_filter ), $link );
							}

							echo '<li class="chosen"><a aria-label="' . esc_attr__( 'Remove filter', 'kitestudio-core' ) . '" href="' . esc_url( $link ) . '">' . esc_html( $term->name ) . '</a></li>';
						}
					}
				}

				if ( $min_price ) {
					$link = remove_query_arg( 'min_price', $base_link );
					echo '<li class="chosen"><a aria-label="' . esc_attr__( 'Remove filter', 'kitestudio-core' ) . '" href="' . esc_url( $link ) . '">' . sprintf( esc_html__( 'Min %s', 'kitestudio-core' ), wc_price( $min_price ) ) . '</a></li>';
				}

				if ( $max_price ) {
					$link = remove_query_arg( 'max_price', $base_link );
					echo '<li class="chosen"><a aria-label="' . esc_attr__( 'Remove filter', 'kitestudio-core' ) . '" href="' . esc_url( $link ) . '">' . sprintf( esc_html__( 'Max %s', 'kitestudio-core' ), wc_price( $max_price ) ) . '</a></li>';
				}

				if ( ! empty( $rating_filter ) ) {
					foreach ( $rating_filter as $rating ) {
						$link_ratings = implode( ',', array_diff( $rating_filter, array( $rating ) ) );
						$link         = $link_ratings ? add_query_arg( 'rating_filter', $link_ratings ) : remove_query_arg( 'rating_filter', $base_link );
						echo '<li class="chosen"><a aria-label="' . esc_attr__( 'Remove filter', 'kitestudio-core' ) . '" href="' . esc_url( $link ) . '">' . sprintf( esc_html__( 'Rated %s out of 5', 'kitestudio-core' ), esc_html( $rating ) ) . '</a></li>';
					}
				}

				// KiteSt
				if ( $on_sale ) {
					$link = remove_query_arg( 'status', $base_link );
					echo '<li class="chosen"><a title="' . esc_attr__( 'Remove filter', 'kitestudio-core' ) . '" href="' . esc_url( $link ) . '">' . esc_html__( 'On Sale', 'kitestudio-core' ) . '</a></li>';
				}

				if ( $in_stock ) {
					$link = remove_query_arg( 'availability', $base_link );
					echo '<li class="chosen"><a title="' . esc_attr__( 'Remove filter', 'kitestudio-core' ) . '" href="' . esc_url( $link ) . '">' . esc_html__( 'In Stock', 'kitestudio-core' ) . '</a></li>';
				}

				echo '</ul>';

				$this->widget_end( $args );
			}
		}
	}
}
