<?php
/**
 * Contains Basic Functions for RealHomes Elementor Addon plugin.
 */

/**
 * Get template part for RHEA plugin.
 *
 * @access public
 *
 * @param mixed $slug Template slug.
 * @param string $name Template name (default: '').
 */
function rhea_get_template_part( $slug, $name = '' ) {
	$template = '';

	// Get slug-name.php.
	if ( ! $template && $name && file_exists( RHEA_PLUGIN_DIR . "/{$slug}-{$name}.php" ) ) {
		$template = RHEA_PLUGIN_DIR . "/{$slug}-{$name}.php";
	}

	// Get slug.php.
	if ( ! $template && file_exists( RHEA_PLUGIN_DIR . "/{$slug}.php" ) ) {
		$template = RHEA_PLUGIN_DIR . "/{$slug}.php";
	}

	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'rhea_get_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}


if ( ! function_exists( 'rhea_allowed_tags' ) ) :
	/**
	 * Returns array of allowed tags to be used in wp_kses function.
	 *
	 * @return array
	 */
	function rhea_allowed_tags() {

		return array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
				'alt'   => array(),
			),
			'b'      => array(),
			'br'     => array(),
			'div'    => array(
				'class' => array(),
				'id'    => array(),
			),
			'em'     => array(),
			'strong' => array(),
		);

	}
endif;


if ( ! function_exists( 'rhea_list_gallery_images' ) ) {
	/**
	 * Get list of Gallery Images - use in gallery post format
	 *
	 * @param string $size
	 */
	function rhea_list_gallery_images( $size = 'post-featured-image' ) {

		$gallery_images = rwmb_meta( 'REAL_HOMES_gallery', 'type=plupload_image&size=' . $size, get_the_ID() );

		if ( ! empty( $gallery_images ) ) {
			foreach ( $gallery_images as $gallery_image ) {
				$caption = ( ! empty( $gallery_image['caption'] ) ) ? $gallery_image['caption'] : $gallery_image['alt'];
				echo '<li><a href="' . esc_url( $gallery_image['full_url'] ) . '" title="' . esc_attr( $caption ) . '" class="' . esc_attr( rhea_get_lightbox_plugin_class() ) . '">';
				echo '<img src="' . esc_url( $gallery_image['url'] ) . '" alt="' . esc_attr( $gallery_image['title'] ) . '" />';
				echo '</a></li>';
			}
		} else if ( has_post_thumbnail( get_the_ID() ) ) {
			echo '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '" >';
			the_post_thumbnail( $size );
			echo '</a></li>';
		}
	}
}


if ( ! function_exists( 'rhea_get_lightbox_plugin_class' ) ) {
	/**
	 * Get Lightbox Plugin Class
	 *
	 * @return string
	 */
	function rhea_get_lightbox_plugin_class() {
		return get_option( 'theme_lightbox_plugin', 'swipebox' );
	}
}


if ( ! function_exists( 'rhea_framework_excerpt' ) ) {
	/**
	 * Output custom excerpt of required length
	 *
	 * @param int $len number of words
	 * @param string $trim string to appear after excerpt
	 */
	function rhea_framework_excerpt( $len = 15, $trim = "&hellip;" ) {
		echo rhea_get_framework_excerpt( $len, $trim );
	}
}


if ( ! function_exists( 'rhea_get_framework_excerpt' ) ) {
	/**
	 * Returns custom excerpt of required length
	 *
	 * @param int $len number of words
	 * @param string $trim string after excerpt
	 *
	 * @return string
	 */
	function rhea_get_framework_excerpt( $len = 15, $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', get_the_excerpt(), $limit );
		$num_words = count( $excerpt );
		if ( $num_words >= $len ) {
			array_pop( $excerpt );
		} else {
			$trim = "";
		}
		$excerpt = implode( " ", $excerpt ) . "$trim";

		return $excerpt;
	}
}

if ( ! function_exists( 'RHEA_ajax_pagination' ) ) {
	/**
	 * Function for Widgets AJAX pagination
	 *
	 * @param string $pages
	 */
	function RHEA_ajax_pagination( $pages = '' ) {

		global $paged;
		global $wp_query;

		if ( is_page_template( 'templates/home.php' ) ) {
			$paged = intval( get_query_var( 'page' ) );
		}

		if ( empty( $paged ) ) {
			$paged = 1;
		}

		$prev          = $paged - 1;
		$next          = $paged + 1;
		$range         = 3;                             // change it to show more links
		$pages_to_show = ( $range * 2 ) + 1;

		if ( $pages == '' ) {
			$pages = $wp_query->max_num_pages;
			if ( ! $pages ) {
				$pages = 1;
			}
		}

		if ( 1 != $pages ) {
		    echo "<div class='rhea_pagination_wrapper'>";
			echo "<div class='pagination rhea-pagination-clean'>";

			if ( ( $paged > 2 ) && ( $paged > $range + 1 ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( 1 ) . "' class='real-btn'> " . esc_html__( 'First', 'realhomes-elementor-addon' ) . "</a> "; // First Page
			}

			if ( ( $paged > 1 ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( $prev ) . "' class='real-btn'> " . esc_html__( 'Prev', 'realhomes-elementor-addon' ) . "</a> "; // Previous Page
			}

			$min_page_number = $paged - $range - 1;
			$max_page_number = $paged + $range + 1;

			for ( $i = 1; $i <= $pages; $i ++ ) {
				if ( ( ( $i > $min_page_number ) && ( $i < $max_page_number ) ) || ( $pages <= $pages_to_show ) ) {
					$current_class = 'real-btn';
					$current_class .= ( $paged == $i ) ? ' current' : '';
					echo "<a href='" . get_pagenum_link( $i ) . "' class='" . $current_class . "' >" . $i . "</a> ";
				}
			}

			if ( ( $paged < $pages ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( $next ) . "' class='real-btn'>" . esc_html__( 'Next', 'realhomes-elementor-addon' ) . " </a> "; // Next Page
			}

			if ( ( $paged < $pages - 1 ) && ( $paged + $range - 1 < $pages ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( $pages ) . "' class='real-btn'>" . esc_html__( 'Last', 'realhomes-elementor-addon' ) . " </a> "; // Last Page
			}

			echo "</div>";
			echo "</div>";
		}
	}
}

if ( ! function_exists( 'rhea_property_price' ) ) {
	/**
	 * Output property price
	 */
	function rhea_property_price() {
		echo rhea_get_property_price();
	}
}

if ( ! function_exists( 'rhea_get_property_price' ) ) {
	/**
	 * Returns property price in configured format
	 *
	 * @return mixed|string
	 */
	function rhea_get_property_price() {

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
				return $formatted_price . $currency . ' <span>' . $price_post_fix.'</span>';
			} else {
				return $currency . $formatted_price .' <span>' . $price_post_fix.'</span>';
			}
		} else {
			return ere_no_price_text();
		}
	}
}

if( ! function_exists( 'rhea_display_property_label' ) ) {
	/**
	 * Display property label
	 * @param $post_id
	 */
	function rhea_display_property_label( $post_id ){

		$label_text = get_post_meta( $post_id, 'inspiry_property_label', true );
		$color               = get_post_meta( $post_id, 'inspiry_property_label_color', true );
		if( ! empty ( $label_text ) ) {
			?>
            <span style="background: <?php echo esc_attr($color); ?>" class='rhea-property-label'><?php echo esc_html($label_text); ?></span>
			<?php

		}
	}
}

if ( ! function_exists( 'rhea_get_maps_type' ) ) {
	/**
	 * Returns the type currently available for use.
	 */
	function rhea_get_maps_type() {
		$google_maps_api_key = get_option( 'inspiry_google_maps_api_key', false );

		if ( ! empty( $google_maps_api_key ) ) {
			return 'google-maps';    // For Google Maps
		}

		return 'open-street-map';    // For OpenStreetMap https://www.openstreetmap.org/
	}
}
