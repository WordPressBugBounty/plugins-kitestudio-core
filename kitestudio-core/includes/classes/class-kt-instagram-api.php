<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Kite_Instagram_Api {

	protected $app_id;
	protected $app_secret;
	protected $short_access_token;
	protected $long_access_token;

	/**
	 * Holds the current instance of the plugins handler
	 *
	 */
	protected static $instance = null;

	/**
	 * Retrieves class instance
	 *
	 * @return Kite_Instagram_Api
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'initialize_instagram' ) );
	}

	public function initialize_instagram() {

		if ( ! function_exists( 'kite_opt' ) ) {
			return;
		}

		$app_id = kite_opt( 'instagram_app_id', '' );

		if ( empty( $app_id ) ) {
			return;
		}

		$this->set_params();

		if ( false == get_transient( 'kite_instagram_authorization_code' ) && empty( get_option( 'kite_instagram_short_access_token', '' ) ) ) {
			$this->connect();
			// short-lived access token is valid for only 1 hour and will use to exchange with long-lived access token
			$this->get_authorization_code();
		}

		if ( empty( get_option( 'kite_instagram_long_access_token', '' ) ) ) {
			// long-lived access token is valid for 60 days and can refreshed to extend this period
			$this->connect_to_get_long_lived_access_token();
		}

		$this->refresh_long_lived_access_token();
	}

	public function set_params() {
		$this->app_id             = kite_opt( 'instagram_app_id', '' );
		$this->app_secret         = kite_opt( 'instagram_app_secret', '' );
		$this->short_access_token = get_option( 'kite_instagram_short_access_token', '' );
		$this->long_access_token  = get_option( 'kite_instagram_long_access_token', '' );
	}

	/**
	 * Connect to instagram account
	 *
	 * @return void
	 */
	public function connect() {
		if ( ! isset( $_GET['insta_connect'] ) ) {
			return;
		}

		$app_id = kite_opt( 'instagram_app_id', '' );

		if ( empty( $app_id ) ) {
			return;
		}

		$args = array(
			'redirect_uri'  => get_site_url( null, '', 'https' ) . '/',
			'scope'         => 'user_profile,user_media',
			'response_type' => 'code',
			'client_id'     => $app_id,
		);

		$url = add_query_arg( $args, 'https://api.instagram.com/oauth/authorize' );
		header( 'Location: ' . $url );
		exit;
	}

	/**
	 * Get Authorization Code
	 * The first step to get access token
	 *
	 * @return void
	 */
	public function get_authorization_code() {
		if ( empty( $_GET['code'] ) ) {
			return;
		}

		// Authorization codes are short-lived and are only valid for 1 hour.
		set_transient( 'kite_instagram_authorization_code', sanitize_text_field( rtrim( $_GET['code'], '#_' ) ), HOUR_IN_SECONDS );
		$this->connect_to_get_short_lived_access_token();
	}

	/**
	 * Get Short Lived Access Token
	 * this kind of token is valid only for 1 hour but we can exchange it with long lived one
	 *
	 * @return void
	 */
	public function connect_to_get_short_lived_access_token() {

		$code = get_transient( 'kite_instagram_authorization_code', '' );

		$args['body'] = array(
			'redirect_uri'  => get_site_url( null, '', 'https' ) . '/',
			'scope'         => 'user_profile,user_media',
			'grant_type'    => 'authorization_code',
			'client_id'     => $this->app_id,
			'client_secret' => $this->app_secret,
			'code'          => $code,
		);

		$url = 'https://api.instagram.com/oauth/access_token';

		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			return;
		}

		$response['body'] = json_decode( $response['body'], true );

		if ( ! empty( $response['body']['access_token'] ) ) {
			update_option( 'kite_instagram_short_access_token', $response['body']['access_token'] );
			update_option( 'kite_instagram_user_id', $response['body']['user_id'] );

			$this->short_access_token = $response['body']['access_token'];
		}

	}

	/**
	 * Connect to instagram graph api to get long lived access token
	 * this method needs to use short access token to exchange it and get long lived acess token
	 *
	 * @return void
	 */
	public function connect_to_get_long_lived_access_token() {

		if ( empty( $this->short_access_token ) ) {
			$this->connect_to_get_short_lived_access_token();
		}

		if ( empty( $this->short_access_token ) || empty( $this->app_secret ) ) {
			return;
		}

		$args = array(
			'grant_type'    => 'ig_exchange_token',
			'client_secret' => $this->app_secret,
			'access_token'  => $this->short_access_token,
		);

		$url = add_query_arg( $args, 'https://graph.instagram.com/access_token' );

		$response = wp_remote_get( $url );
		if ( is_wp_error( $response ) ) {
			return;
		}

		$response['body'] = json_decode( $response['body'], true );

		// die( print_r( $response['body'], true));
		if ( ! empty( $response['body']['access_token'] ) ) {
			update_option( 'kite_instagram_long_access_token', $response['body']['access_token'] );
			set_transient( 'kite_instagram_long_acess_token_refresh', 'yes', MONTH_IN_SECONDS );
		}

	}

	/**
	 * Refresh long lived access token
	 * Long lived access token is valid for 60 days and if not refreshed we have to connect to instagram again
	 * This method runs once every month
	 *
	 * @return void
	 */
	public function refresh_long_lived_access_token() {

		if ( false != get_transient( 'kite_instagram_long_acess_token_refresh' ) ) {
			return;
		}

		if ( empty( $this->long_access_token ) ) {
			return;
		}

		$args = array(
			'grant_type'   => 'ig_refresh_token',
			'access_token' => $this->long_access_token,
		);

		$url = add_query_arg( $args, 'https://graph.instagram.com/refresh_access_token' );

		$response = wp_remote_get( $url );
		if ( is_wp_error( $response ) ) {
			return;
		}

		$response['body'] = json_decode( $response['body'], true );

		if ( ! empty( $response['body']['access_token'] ) ) {
			update_option( 'kite_instagram_long_access_token', $response['body']['access_token'] );
			set_transient( 'kite_instagram_long_acess_token_refresh', 'yes', MONTH_IN_SECONDS );
		}
	}

	/**
	 * Get media list for current user
	 *
	 * @return arary
	 */
	public function get_media_list() {

		if ( false != $media_list = get_transient( 'kite_user_instagram_media_list' ) ) {
			return maybe_unserialize( $media_list );
		}

		if ( empty( $this->long_access_token ) ) {
			return array();
		}

		$args = array(
			'access_token' => $this->long_access_token,
			'fields'       => 'id,username,media_type,media_url,caption,permalink',
		);

		$url = add_query_arg( $args, 'https://graph.instagram.com/me/media' );

		$response = wp_remote_get( $url );
		if ( is_wp_error( $response ) ) {
			return;
		}

		$response['body'] = json_decode( $response['body'], true );

		if ( ! empty( $response['body']['data'] ) ) {
			set_transient( 'kite_user_instagram_media_list', maybe_serialize( $response['body']['data'] ), 2 * DAY_IN_SECONDS );
			if ( ! empty( $response['body']['data'][0]['username'] ) ) {
				set_transient( 'kite_instagram_username', $response['body']['data'][0]['username'], 2 * DAY_IN_SECONDS );
			}
			return $response['body']['data'];
		}

		return array();

	}

	/**
	 * Disconnect from instagram account
	 *
	 * @return void
	 */
	public static function disconnect() {

		$options = array(
			'kite_instagram_user_id',
			'kite_instagram_short_access_token',
			'kite_instagram_long_access_token',
		);

		foreach ( $options as $key => $option ) {
			delete_option( $option );
		}

		$transients = array(
			'kite_instagram_authorization_code',
			'kite_instagram_long_acess_token_refresh',
			'kite_user_instagram_media_list',
		);

		foreach ( $transients as $key => $transient ) {
			delete_transient( $transient );
		}

	}

}

Kite_Instagram_Api::get_instance();
