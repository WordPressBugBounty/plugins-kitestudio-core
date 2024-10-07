<?php

class KITE_Element_ID_Generator {
    
    private $elements_counter_holder;

    /**
	 * Holds the current instance of the id generator
	 *
	 */
	protected static $instance = null;

    /**
	 * Retrieves class instance
	 *
	 * @return KITE_Element_ID_Generator
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * __construct method
	 */
	public function __construct() {
		$this->elements_counter_holder = [];
	}

    /**
     * Count number of elements use and generate unique id for each id
     * 
     * @param string $key
     * @return string
     */
    public function generate_id( $key ) {
        $this->elements_counter_holder[ $key ] = !empty( $this->elements_counter_holder[ $key ] ) ? ++$this->elements_counter_holder[ $key ] : 1;
        return $key . '_' . $this->elements_counter_holder[ $key ];
    }
}