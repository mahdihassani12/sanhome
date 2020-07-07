<?php
/**
 * Content Section of homepage.
 *
 * @package    realhomes
 * @subpackage modern
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$get_border_type   = get_option( 'inspiry_home_sections_border', 'diagonal-border' );

if ( $get_border_type == 'diagonal-border') {
	$border_class = 'diagonal-mod';
} else {
	$border_class = 'flat-border';
}

global $post;

?>

<div class="container">

	<div class="row home_layout">
		<div class="col-md-3">
			
		</div> <!-- advetisement -->
		<div class="col-md-9">

			<div class="row">
				<?php
					$property_listing_args = array(
						'post_type'      => 'property',
						'posts_per_page' => 4,
						'order' => 'desc',
						'order_by' => 'date'
					);

					$property_listing_query = new WP_Query( $property_listing_args );

					if ( $property_listing_query->have_posts() ) :
						while ( $property_listing_query->have_posts() ) :
							$property_listing_query->the_post();

								?>

									<div class="col-md-6">
										<div class="home_content">
											<?php 
												get_template_part( 'assets/modern/partials/home/section/grid-content' );
											?>
										</div>
									</div>

								<?php

						endwhile;
						wp_reset_postdata();
					else :
						?>
						<div class="rh_alert-wrapper">
							<h4 class="no-results"><?php esc_html_e( 'Sorry No Results Found!', 'framework' ); ?></h4>
						</div>
						<?php
					endif;
				?>
			</div> <!-- end of inner row -->

	