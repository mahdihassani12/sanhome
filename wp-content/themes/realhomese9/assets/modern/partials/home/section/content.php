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
			<div class="home_sidebar" style="height: 317px; background: #eee; margin-top: 15px;">
					<?php dynamic_sidebar( 'home-sidebar' ); ?>
			</div>
			<div class="home_sidebar2" style="width: 100%; height: 500px; background: #eee; margin-top: 14px;">
				
			</div>
		</div> <!-- advetisement -->
		<div class="col-md-9">

			<div class="row">
				<?php
					$property_listing_args = array(
						'post_type'      => 'property',
						'posts_per_page' => 4,
						'order' => 'asc',
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

		</div> <!-- end of home content -->
	</div>
</div>

