<?php
/**
 * Page: Agents Listing
 *
 * Page template for agents listing.
 *
 * @since 	3.0.0
 * @package RH/modern
 */

get_header();

// Page Head.
$header_variation = get_option( 'inspiry_agents_header_variation' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
    get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
    get_template_part( 'assets/modern/partials/banner/image' );
}

if ( inspiry_show_header_search_form() ) {
    get_template_part( 'assets/modern/partials/properties/search/advance' );
}

get_template_part( 'assets/modern/partials/blog/loop' );

get_footer();
