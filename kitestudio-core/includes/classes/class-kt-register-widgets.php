<?php
/**
 * This class is responsible for importing theme codes that related to plugins territory
 */
class Kite_Register_Widgets {

	public $widgets = array();

	public function __construct() {

		$this->widgets = array(
			'kite-widgets'             => array(
				'Kite_Facebook_Widget',
				'Kite_Instagram_Widget',
				'Kite_Progress_Widget',
				'Kite_Recent_Post_Widget',
				'Kite_Video_Widget',
			),
			'kite-woocommerce-widgets' => array(
				'Kite_Advanced_WC_Widget_Layered_Nav'   => 'WC_Widget_Layered_Nav',
				'Kite_WC_Widget_In_Stock_Filter'        => '',
				'Kite_WC_Widget_Layered_Nav_Filters'    => 'WC_Widget_Layered_Nav_Filters',
				'Kite_WC_Widget_On_Sale_Filter'         => '',
				'Kite_WC_Widget_Order_By_Filter'        => '',
				'Kite_WC_Widget_Ranged_Price_Filter'    => '',
				'Kite_Woocommerce_Wishlist_Icon_Widget' => '',
				'Kite_WC_Widget_Rating_Filter'          => 'WC_Widget_Rating_Filter',

			),
		);

		add_action( 'widgets_init', array( $this, 'register_widgets' ), 25 );

	}

	/**
	 * Registering Kite Widgets
	 */
	public function register_widgets() {

		// Add widgets
		Kite_Core_Loader::get_instance()->require_files(
			KITE_CORE_DIR . 'includes/widgets',
			array(
				'widget-instagram',
				'widget-recent-posts',
				'widget-video',
				'widget-progress',
				'widget-facebook',
				'widget-woocommerce-wishlist-icon',
				'widget-advanced-layered-nav',
				'widget-woocommerce-ranged-price-filter',
				'widget-woocommerce-on-sale-filter',
				'widget-woocommerce-in-stock-filter',
				'widget-woocommerce-layered-nav-filters',
				'widget-woocommerce-order-by-filter',
				'widget-woocommerce-rating-filter',
			)
		);

		foreach ( $this->widgets['kite-widgets'] as $key => $widget ) {
			register_widget( $widget );
		}

		if ( kite_woocommerce_installed() ) {
			foreach ( $this->widgets['kite-woocommerce-widgets'] as $kite_widget => $woocommerce_widget ) {
				if ( ! empty( $woocommerce_widget ) && class_exists( $woocommerce_widget ) ) {
					unregister_widget( $woocommerce_widget );
				}

				register_widget( $kite_widget );

			}
		}
	}

}
new Kite_Register_Widgets();

