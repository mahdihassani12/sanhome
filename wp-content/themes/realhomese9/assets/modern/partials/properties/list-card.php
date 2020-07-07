<?php
	/**
	 * View: Property List Card
	 *
	 * Property card for listing view.
	 *
	 * @since    3.0.0
	 * @package  realhomes
	 */

	global $post;
	$property_size      = get_post_meta( $post->ID, 'REAL_HOMES_property_size', true );
	$size_postfix       = get_post_meta( $post->ID, 'REAL_HOMES_property_size_postfix', true );
	$property_bedrooms  = get_post_meta( $post->ID, 'REAL_HOMES_property_bedrooms', true );
	$property_bathrooms = get_post_meta( $post->ID, 'REAL_HOMES_property_bathrooms', true );
	$property_address   = get_post_meta( $post->ID, 'REAL_HOMES_property_address', true );
	$is_featured        = get_post_meta( $post->ID, 'REAL_HOMES_featured', true );

?>

<article <?php post_class( 'rh_list_card' ); ?>>

	<div class="rh_list_card__wrap">

		<figure class="rh_list_card__thumbnail">
			<?php if ( $is_featured ) : ?>
				<div class="rh_label rh_label__list">
					<div class="rh_label__wrap">
						<?php esc_html_e( 'تصویر', 'easy-real-estate' ); ?>
						<span></span>
					</div>
				</div>				<!-- /.rh_label -->
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>">
				<?php if ( has_post_thumbnail( $post->ID ) ) : ?><?php $post_thumbnail_url = get_the_post_thumbnail_url( $post->ID, 'property-listing-image' ); ?>
					<div class="post_thumbnail" style="background: url('<?php echo esc_url( $post_thumbnail_url ); ?>') 50% 50% no-repeat; background-size: cover;"></div>					<!-- /.post_thumbnail -->
				<?php else : ?><?php $post_thumbnail_url = get_inspiry_image_placeholder_url( 'property-listing-image' ); ?>
					<div class="post_thumbnail" style="background: url('<?php echo esc_url( $post_thumbnail_url ); ?>') 50% 50% no-repeat; background-size: cover;"></div>					<!-- /.post_thumbnail -->
				<?php endif; ?>
			</a>

			<div class="rh_overlay"></div>
			<div class="rh_overlay__contents rh_overlay__fadeIn-bottom">
				<a href="<?php the_permalink(); ?>">توضیحات بیشتر</a>
			</div>
			<!-- /.rh_overlay__contents -->

			<?php inspiry_display_property_label( $post->ID ); ?>

			<div class="rh_list_card__btns">

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
			<!-- /.rh_list_card__btns -->
		</figure>
		<!-- /.rh_list_card__thumbnail -->

		<div class="rh_list_card__details_wrap">

			<div class="rh_list_card__details">

				<h3>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
				<p class="rh_list_card__excerpt"><?php framework_excerpt( 5 ); ?></p>
				<!-- /.rh_list_card__excerpt -->

				<div class="rh_list_card__meta_wrap">

					<?php if ( ! empty( $property_bedrooms ) ) : ?>
						<div class="rh_list_card__meta">
							<span class="rh_meta_titles">
								<?php
									$bedrooms_label = get_option( 'inspiry_bedrooms_field_label' );
									echo ( empty ( $bedrooms_label ) ) ? esc_html__( 'اتاق خواب', 'framework' ) : esc_html( $bedrooms_label );
								?>
							</span>
							<div>
								<?php include INSPIRY_THEME_DIR . '/images/icons/icon-bed.svg'; ?>
								<span class="figure"><?php echo esc_html( $property_bedrooms ); ?></span>
							</div>
						</div>						<!-- /.rh_list_card__meta -->
					<?php endif; ?>

					<?php if ( ! empty( $property_bathrooms ) ) : ?>
						<div class="rh_list_card__meta">
							<span class="rh_meta_titles">
								<?php
									$bathrooms_label = get_option( 'inspiry_bathrooms_field_label' );
									echo ( empty ( $bathrooms_label ) ) ? esc_html__( 'احمام', 'framework' ) : esc_html( $bathrooms_label );
								?>
							</span>
							<div>
								<?php include INSPIRY_THEME_DIR . '/images/icons/icon-shower.svg'; ?>
								<span class="figure"><?php echo esc_html( $property_bathrooms ); ?></span>
							</div>
						</div>						<!-- /.rh_list_card__meta -->
					<?php endif; ?>

					<?php if ( ! empty( $property_size ) ) : ?>
						<div class="rh_list_card__meta">
							<span class="rh_meta_titles">
								<?php
									$area_label = get_option( 'inspiry_area_field_label' );
									echo ( empty ( $area_label ) ) ? esc_html__( 'مساحت', 'framework' ) : esc_html( $area_label );
								?>
							</span>
							<div>
								<?php include INSPIRY_THEME_DIR . '/images/icons/icon-area.svg'; ?>
								<span class="figure">
									<?php echo esc_html( $property_size ); ?>
								</span>
								<?php if ( ! empty( $size_postfix ) ) : ?>
									<span class="label">
										<?php echo esc_html( $size_postfix ); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>						<!-- /.rh_list_card__meta -->
					<?php endif; ?>

				</div>
				<!-- /.rh_list_card__meta_wrap -->

			</div>
			<!-- /.rh_list_card__details -->

			<div class="rh_list_card__priceLabel">

				<div class="rh_list_card__price">
					<span class="status">
						<?php echo esc_html( display_property_status( $post->ID ) ); ?>
					</span>
					<!-- /.rh_prop_card__type -->

					<p class="price">
						<?php
                        if ( function_exists( 'ere_property_price' ) ) {
							ere_property_price();
						}
						?>
					</p>
					<!-- /.price -->
				</div>
				<!-- /.rh_list_card__price -->

				<?php
					$agent_display_option = get_post_meta( get_the_ID(), 'REAL_HOMES_agent_display_option', true );
					if ( ( ! empty( $agent_display_option ) ) && ( 'none' !== $agent_display_option ) ) {
						if ( 'my_profile_info' === $agent_display_option ) {
							$author_display_name = get_the_author_meta( 'display_name' );
							if ( ! empty( $author_display_name ) ) {
								?>
								<p class="rh_list_card__author">
									<?php esc_html_e( 'توسط', 'framework' ); ?>
									<span class="author"><?php echo esc_html( $author_display_name ); ?></span>
								</p>							<!-- /.rh_list_card__author -->
								<?php
							}
						} else {
							$agents_names = inspiry_get_property_agents_names();
							if ( ! empty( $agents_names ) ) {
								?>
								<p class="rh_list_card__author">
									<?php esc_html_e( 'توسط', 'framework' ); ?>
									<span class="author"><?php echo esc_html( $agents_names ); ?></span>
								</p>							<!-- /.rh_list_card__author -->
								<?php
							}
						}
					}
				?>

			</div>
			<!-- /.rh_list_card__priceLabel -->

		</div>
		<!-- /.rh_list_card__details_wrap -->

	</div>
	<!-- /.rh_list_card__wrap -->

</article><!-- /.rh_list_card -->
