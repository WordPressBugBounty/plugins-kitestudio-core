<?php

namespace KiteStudioCore;

class Color_Handler {

    /**
     * Opacity codes in hex format
     *
     * @var array
     */
    protected $hex_alpha_codes = [
        'FF' => 100,
        'FC' => 99,
        'FA' => 98,
        'F7' => 97,
        'F5' => 96,
        'F2' => 95,
        'F0' => 94,
        'ED' => 93,
        'EB' => 92,
        'E8' => 91,
        'E6' => 90,
        'E3' => 89,
        'E0' => 88,
        'DE' => 87,
        'DB' => 86,
        'D9' => 85,
        'D6' => 84,
        'D4' => 83,
        'D1' => 82,
        'CF' => 81,
        'CC' => 80,
        'C9' => 79,
        'C7' => 78,
        'C4' => 77,
        'C2' => 76,
        'BF' => 75,
        'BD' => 74,
        'BA' => 73,
        'B8' => 72,
        'B5' => 71,
        'B3' => 70,
        'B0' => 69,
        'AD' => 68,
        'AB' => 67,
        'A8' => 66,
        'A6' => 65,
        'A3' => 64,
        'A1' => 63,
        '9E' => 62,
        '9C' => 61,
        '99' => 60,
        '96' => 59,
        '94' => 58,
        '91' => 57,
        '8F' => 56,
        '8C' => 55,
        '8A' => 54,
        '87' => 53,
        '85' => 52,
        '82' => 51,
        '80' => 50,
        '7D' => 49,
        '7A' => 48,
        '78' => 47,
        '75' => 46,
        '73' => 45,
        '70' => 44,
        '6E' => 43,
        '6B' => 42,
        '69' => 41,
        '66' => 40,
        '63' => 39,
        '61' => 38,
        '5E' => 37,
        '5C' => 36,
        '59' => 35,
        '57' => 34,
        '54' => 33,
        '52' => 32,
        '4F' => 31,
        '4D' => 30,
        '4A' => 29,
        '47' => 28,
        '45' => 27,
        '42' => 26,
        '40' => 25,
        '3D' => 24,
        '3B' => 23,
        '38' => 22,
        '36' => 21,
        '33' => 20,
        '30' => 19,
        '2E' => 18,
        '2B' => 17,
        '29' => 16,
        '26' => 15,
        '24' => 14,
        '21' => 13,
        '1F' => 12,
        '1C' => 11,
        '1A' => 10,
        '17' => 9,
        '14' => 8,
        '12' => 7,
        '0F' => 6,
        '0D' => 5,
        '0A' => 4,
        '08' => 3,
        '05' => 2,
        '03' => 1,
        '00' => 0,
    ];

    /**
	 * Holds the current instance of the dashboard
	 *
	 */
	protected static $instance = null;

	/**
	 * Retrieves class instance
	 *
	 * @return Dashboard
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
		
	}

    /**
     * Check if color is rgb or not
     *
     * @param string $color
     * @return boolean
     */
    public static function is_rgb( $color ) {
        return strpos( trim( $color, ' ' ), 'rgb' ) !== false;
    }

    /**
     * Check if color is rgba or not
     *
     * @param string $color
     * @return boolean
     */
    public static function is_rgba( $color ) {
        return strpos( trim( $color, ' ' ), 'rgba' ) !== false;
    }

    /**
     * Check if color is in hex format or not
     *
     * @param string $color
     * @return boolean
     */
    public static function is_hex( $color ) {
        return strpos( trim( $color, ' ' ), '#' ) !== false;
    }

    /**
     * Convert hex format to rgba
     *
     * @param string $color
     * @param boolean|float $opacity
     * @return string
     */
    public static function hex2rgba($color, $opacity = false) {

        $default = 'rgb(0,0,0)';
    
        //Return default if no color provided
        if( empty( $color ) ) {
            return $default; 
        }
    
        //Sanitize $color if "#" is provided 
        if ( $color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if  (strlen($color) == 6 ) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } elseif ( strlen( $color ) == 8 ) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            if ( !$opacity ) {
                $alpha = substr( $color, 6 );
                if ( in_array( $alpha, array_keys( $this->hex_alpha_codes ) ) ) {
                    $opacity = $this->hex_alpha_codes[ $alpha ] / 100;
                }
            }
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if ( $opacity ) {
            $opacity = abs( $opacity ) > 1 ? 1.0 : $opacity ;
            $output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
        } else {
            $output = 'rgb('.implode( ",", $rgb ) . ')';
        }

        //Return rgb(a) color string
        return $output;
    }

    /**
     * Add opacity to color
     *
     * @param string $color
     * @param float $opacity
     * @return string $color
     */
    public static function add_opacity( $color, $opacity ) {
        
        if ( $opacity > 1 ) {
            return $color;
        }

        if ( self::is_hex( $color ) ) {
            return self::hex2rgba( $color, $opacity );
        }

        if ( self::is_rgba( $color ) || self::is_rgb( $color ) ) {
            $color = str_replace( 'rgba(', '', $color );
            $color = str_replace( 'rgb(', '', $color );
            $color = str_replace( ')', '', $color );
            list( $r, $g, $b ) = explode( ',', $color );
            return 'rgba(' .  $r . ',' . $g . ',' . $b . ',' .  $opacity . ')';
        }

        return $color;
    }
}