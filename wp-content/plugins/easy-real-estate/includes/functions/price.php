<?php
/**
 * Price related functions.
 */

if ( ! function_exists( 'ere_get_currency_sign' ) ) {
	/**
	 * Get Currency
	 *
	 * @return string
	 */
	function ere_get_currency_sign() {
		return get_option( 'theme_currency_sign', esc_html__( '$', 'easy-real-estate' ) );
	}
}


if ( ! function_exists( 'ere_no_price_text' ) ) {
	/**
	 * Returns text to display in case of empty price
	 *
	 * @return string
	 */
	function ere_no_price_text() {
		return get_option( 'theme_no_price_text', esc_html__( 'On Call', 'easy-real-estate' ) );
	}
}


if ( ! function_exists( 'ere_get_base_currency' ) ) {
	/**
	 * Get Base Currency
	 *
	 * @return string
	 */
	function ere_get_base_currency() {
		return get_option( 'theme_base_currency', 'USD' );
	}
}


if ( ! function_exists( 'ere_property_price' ) ) {
	/**
	 * Output property price
	 */
	function ere_property_price() {
		echo ere_get_property_price();
	}
}


if ( ! function_exists( 'ere_get_property_price' ) ) {
	/**
	 * Returns property price in configured format
	 *
	 * @return mixed|string
	 */
	function ere_get_property_price() {

		// get property price
		$price_digits = doubleval( get_post_meta( get_the_ID(), 'REAL_HOMES_property_price', true ) );

		if ( $price_digits ) {
			// get price postfix
			$price_post_fix = get_post_meta( get_the_ID(), 'REAL_HOMES_property_price_postfix', true );

			// if wp-currencies plugin installed and current currency cookie is set
			if ( class_exists( 'WP_Currencies' ) && isset( $_COOKIE[ "current_currency" ] ) ) {
				$current_currency = $_COOKIE[ "current_currency" ];
				if ( currency_exists( $current_currency ) ) {    // validate current currency
					$base_currency = ere_get_base_currency();
					$converted_price = convert_currency( $price_digits, $base_currency, $current_currency );
					return format_currency( $converted_price, $current_currency ) . ' ' . $price_post_fix;
				}
			}

			// otherwise go with default approach.
			$currency = ere_get_currency_sign();
			$decimals = intval( get_option( 'theme_decimals', '2' ) );
			$decimal_point = get_option( 'theme_dec_point', '.' );
			$thousands_separator = get_option( 'theme_thousands_sep', ',' );
			$currency_position = get_option( 'theme_currency_position' );
			$formatted_price = number_format( $price_digits, $decimals, $decimal_point, $thousands_separator );
			if ( $currency_position == 'after' ) {
				return $formatted_price . $currency  . ' ' . $price_post_fix;
			} else {
				return $currency . $formatted_price . ' ' . $price_post_fix;
			}
		} else {
			return ere_no_price_text();
		}
	}
}




if ( ! function_exists( 'ere_get_property_price_by_id' ) ) {
	/**
	 * Returns property price in configured format
	 *
	 * @return mixed|string
	 */
	function ere_get_property_price_by_id( $property_id ) {

		// get property price
		$price_digits = doubleval( get_post_meta( $property_id, 'REAL_HOMES_property_price', true ) );

		if ( $price_digits ) {
			// get price postfix
			$price_post_fix = get_post_meta( $property_id, 'REAL_HOMES_property_price_postfix', true );

			// if wp-currencies plugin installed and current currency cookie is set
			if ( class_exists( 'WP_Currencies' ) && isset( $_COOKIE[ "current_currency" ] ) ) {
				$current_currency = $_COOKIE[ "current_currency" ];
				if ( currency_exists( $current_currency ) ) {    // validate current currency
					$base_currency = ere_get_base_currency();
					$converted_price = convert_currency( $price_digits, $base_currency, $current_currency );
					return format_currency( $converted_price, $current_currency ) . ' ' . $price_post_fix;
				}
			}

			// otherwise go with default approach.
			$currency = ere_get_currency_sign();
			$decimals = intval( get_option( 'theme_decimals', '2' ) );
			$decimal_point = get_option( 'theme_dec_point', '.' );
			$thousands_separator = get_option( 'theme_thousands_sep', ',' );
			$currency_position = get_option( 'theme_currency_position' );
			$formatted_price = number_format( $price_digits, $decimals, $decimal_point, $thousands_separator );
			if ( $currency_position == 'after' ) {
				return $formatted_price . $currency . ' ' . $price_post_fix;
			} else {
				return $currency . $formatted_price . ' ' . $price_post_fix;
			}
		} else {
			return ere_no_price_text();
		}
	}
}


if ( ! function_exists( 'ere_get_custom_price' ) ) {
	/**
	 * Return custom price in configured format
	 *
	 * @param $amount
	 * @return bool|string
	 */
	function ere_get_custom_price( $amount ) {
		$amount = doubleval( $amount );
		if ( $amount ) {
			// if wp-currencies plugin is installed and current currency cookie is set
			if ( class_exists( 'WP_Currencies' ) && isset( $_COOKIE[ "current_currency" ] ) ) {
				$current_currency = $_COOKIE[ "current_currency" ];
				if ( currency_exists( $current_currency ) ) {    // validate current currency
					$base_currency = ere_get_base_currency();
					$converted_price = convert_currency( $amount, $base_currency, $current_currency );
					return format_currency( $converted_price, $current_currency );
				}
			}

			// otherwise default approach
			$currency = ere_get_currency_sign();
			$decimals = intval( get_option( 'theme_decimals', '2' ) );
			$decimal_point = get_option( 'theme_dec_point', '.' );
			$thousands_separator = get_option( 'theme_thousands_sep', ',' );
			$currency_position = get_option( 'theme_currency_position' );
			$formatted_price = number_format( $amount, $decimals, $decimal_point, $thousands_separator );
			if ( $currency_position == 'after' ) {
				return $formatted_price . $currency;
			} else {
				return $currency . $formatted_price;
			}
		} else {
			return false;
		}
	}
}


if ( ! function_exists( 'ere_get_property_floor_price' ) ) {
	/**
	 * Returns floor price in configured format
	 *
	 * @param   array $floor Floor details
	 * @return  string  Floor price
	 */
	function ere_get_property_floor_price( $floor ) {
		// get property price
		$price_digits = doubleval( $floor[ 'inspiry_floor_plan_price' ] );

		if ( $price_digits ) {
			// get price postfix
			if ( isset( $floor['inspiry_floor_plan_price_postfix'] ) ) {
				$price_post_fix = $floor['inspiry_floor_plan_price_postfix'];
			} else {
				$price_post_fix = '';
			}

			// if wp-currencies plugin installed and current currency cookie is set
			if ( class_exists( 'WP_Currencies' ) && isset( $_COOKIE[ "current_currency" ] ) ) {
				$current_currency = $_COOKIE[ "current_currency" ];
				if ( currency_exists( $current_currency ) ) {    // validate current currency
					$base_currency = ere_get_base_currency();
					$converted_price = convert_currency( $price_digits, $base_currency, $current_currency );
					return format_currency( $converted_price, $current_currency ) . ' ' . $price_post_fix;
				}
			}

			// otherwise go with default approach.
			$currency = ere_get_currency_sign();
			$decimals = intval( get_option( 'theme_decimals', '2' ) );
			$decimal_point = get_option( 'theme_dec_point', '.' );
			$thousands_separator = get_option( 'theme_thousands_sep', ',' );
			$currency_position = get_option( 'theme_currency_position' );
			$formatted_price = number_format( $price_digits, $decimals, $decimal_point, $thousands_separator );
			if ( $currency_position == 'after' ) {
				return '<span class="floor-price-value">' . $formatted_price . $currency . '</span>' . ' ' . $price_post_fix;
			} else {
				return '<span class="floor-price-value">' . $currency . $formatted_price . '</span>' . ' ' . $price_post_fix;
			}

		} else {
			return ere_no_price_text();
		}
	}
}


if ( ! function_exists( 'ere_property_floor_price' ) ) {
	/**
	 * Output floor price
	 *
	 * @param   array $floor Floor details
	 */
	function ere_property_floor_price( $floor ) {
		echo ere_get_property_floor_price( $floor );
	}
}