<?php
/**
 * Head of the single property template.
 *
 * @package    realhomes
 * @subpackage modern
 */

global $post;

?>

<div class="rh_page__head rh_page__property single_head">

	<div class="rh_page__property_title single_property_title">

        <?php inspiry_property_qr_code(); ?>

		<h1 class="rh_page__title">
			<?php the_title(); ?>
		</h1>
		<!-- /.rh_page__title -->

		<?php
		$address_display  = get_option( 'inspiry_display_property_address', 'true' );
		$property_address = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );

		if ( 'true' === $address_display ) {
			?>
			<p class="rh_page__property_address">
				<?php echo esc_html( $property_address ); ?>
			</p>

			<?php
		}

		$display_property_breadcrumbs = get_option( 'theme_display_property_breadcrumbs' );
			if ( 'true' == $display_property_breadcrumbs ) {
				get_template_part( 'common/partials/breadcrumbs' );
			}
			?>

	</div>
	<!-- /.rh_page__property_title -->
	
</div>
<!-- /.rh_page__head -->
