<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://kitestudio.co/
 * @since      1.0.0
 *
 * @package    Kite_Core
 * @subpackage Kite_Core/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Kite_Core
 * @subpackage Kite_Core/includes
 * @author     KiteStudio <help.kitestudio@gmail.com>
 */
class Kite_Core_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * Holds the current instance of the dashboard
	 *
	 */
	protected static $instance = null;

	/**
	 * Retrieves class instance
	 *
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string $hook             The name of the WordPress action that is being registered.
	 * @param    object $component        A reference to the instance of the object on which the action is defined.
	 * @param    string $callback         The name of the function definition on the $component.
	 * @param    int    $priority         Optional. he priority at which the function should be fired. Default is 10.
	 * @param    int    $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string $hook             The name of the WordPress filter that is being registered.
	 * @param    object $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string $callback         The name of the function definition on the $component.
	 * @param    int    $priority         Optional. he priority at which the function should be fired. Default is 10.
	 * @param    int    $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array  $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string $hook             The name of the WordPress filter that is being registered.
	 * @param    object $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string $callback         The name of the function definition on the $component.
	 * @param    int    $priority         The priority at which the function should be fired.
	 * @param    int    $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);

		return $hooks;

	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

	}

	/**
	 * Includes (require_once) php file(s) inside selected folder
	 *
	 * * @since    1.5.6
	 */
	public function require_files( $path, $file_name ) {

		if ( is_string( $file_name ) ) {
			require_once $this->path_combine( $path, $file_name ) . '.php';
		} elseif ( is_array( $file_name ) ) {
			foreach ( $file_name as $name ) {
				require_once $this->path_combine( $path, $name ) . '.php';
			}
		} else {
			// Throw error
			throw new Exception( 'Unknown parameter type' );
		}
	}

	/**
	 * Simple Path combining method
	 *
	 * * @since    1.5.6
	 */
	public function path_combine( $path1, $path2 ) {
		$paths    = func_get_args();
		$last_key = func_num_args() - 1;
		array_walk(
			$paths,
			function( &$val, $key ) use ( $last_key ) {
				switch ( $key ) {
					case 0:
						$val = rtrim( $val, '/ ' );
						break;
					case $last_key:
						$val = ltrim( $val, '/ ' );
						break;
					default:
						$val = trim( $val, '/ ' );
						break;
				}
			}
		);

		$first = array_shift( $paths );
		$last  = array_pop( $paths );
		$paths = array_filter( $paths ); // clean empty elements to prevent double slashes
		array_unshift( $paths, $first );
		$paths[] = $last;
		return implode( '/', $paths );
	}

}
