<?php
	/**
	 * Grid Property Card
	 *
	 * Property grid card to be displayed on grid listing page.
	 *
	 * @since    3.0.0
	 * @package RH/modern
	 */

	global $post;
	$property_size      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
	$size_postfix       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
	$property_bedrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
	$property_bathrooms = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
	$property_address   = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
	$is_featured        = get_post_meta( get_the_ID(), 'REAL_HOMES_featured', true );

?>

<article <?php post_class( 'rh_prop_card rh_prop_card--listing' ); ?>>

	<div class="rh_prop_card__wrap">

		<figure class="rh_prop_card__thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php
					if ( has_post_thumbnail( get_the_ID() ) ) {
						the_post_thumbnail( 'modern-property-child-slider' );
					} else {
						inspiry_image_placeholder( 'modern-property-child-slider' );
					}
				?>
			</a>

			<div class="rh_overlay"></div>
			<div class="rh_overlay__contents rh_overlay__fadeIn-bottom">
				<a href="<?php the_permalink(); ?>"><?php inspiry_property_detail_page_link_text(); ?></a>
			</div>
			<!-- /.rh_overlay__contents -->

			<?php inspiry_display_property_label( get_the_ID() ); ?>

			<div class="rh_prop_card__btns">
				<?php
                    // Display add to favorite button
                    inspiry_favorite_button();

					$compare_properties_module = get_option( 'theme_compare_properties_module' );
					$inspiry_compare_page      = get_option( 'inspiry_compare_page' );
					if ( ( 'enable' === $compare_properties_module ) && ( $inspiry_compare_page ) ) {
						get_template_part( 'assets/modern/partials/properties/compare/button' );
					}
				?>
			</div>
			<!-- /.rh_prop_card__btns -->
		</figure>
		<!-- /.rh_prop_card__thumbnail -->

		<div class="rh_prop_card__details">

			<h3 class="property_title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>

			<div class="rh_prop_card__meta_wrap property_meta">

				<?php if ( ! empty( $property_bedrooms ) ) : ?>
					<div class="rh_prop_card__meta">
						<div>
							<?php include( INSPIRY_THEME_DIR . '/images/icons/icon-bed.svg' ); ?>
							<span class="figure"><?php echo esc_html( $property_bedrooms ); ?></span>
						</div>
					</div>					<!-- /.rh_prop_card__meta -->
				<?php endif; ?>

				<?php if ( ! empty( $property_bathrooms ) ) : ?>
					<div class="rh_prop_card__meta">
						<div>
							<?php include( INSPIRY_THEME_DIR . '/images/icons/icon-shower.svg' ); ?>
							<span class="figure"><?php echo esc_html( $property_bathrooms ); ?></span>
						</div>
					</div>					<!-- /.rh_prop_card__meta -->
				<?php endif; ?>

				<?php if ( ! empty( $property_size ) ) : ?>
					<div class="rh_prop_card__meta">
						<div>
							<?php include( INSPIRY_THEME_DIR . '/images/icons/icon-area.svg' ); ?>
							<span class="figure">
								<?php echo esc_html( $property_size ); ?>
							</span>
						</div>
					</div>					<!-- /.rh_prop_card__meta -->
				<?php endif; ?>

			</div>
			<!-- /.rh_prop_card__meta_wrap -->

			<div class="rh_prop_card__priceLabel property_price">

				<p class="rh_prop_card__price">
					<?php
					if ( function_exists( 'ere_property_price' ) ) {
						ere_property_price();
					}
                    ?>
				</p>
				<!-- /.rh_prop_card__price -->

			</div>
			<!-- /.rh_prop_card__priceLabel -->

		</div>
		<!-- /.rh_prop_card__details -->

	</div>
	<!-- /.rh_prop_card__wrap -->

</article><!-- /.rh_prop_card -->
