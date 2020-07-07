<?php
/**
 * Grid Property Card
 *
 */

$property_size      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
$size_postfix       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
$property_bedrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
$property_bathrooms = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
$property_address   = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
$is_featured        = get_post_meta( get_the_ID(), 'REAL_HOMES_featured', true );


global $settings;

$bedroom_label           = $settings['ere_property_bedrooms_label'];
$bathroom_label          = $settings['ere_property_bathrooms_label'];
$area_label              = $settings['ere_property_area_label'];
$show_fav_button         = $settings['ere_enable_fav_properties'];
$fav_label               = $settings['ere_property_fav_label'];
$fav_added_label         = $settings['ere_property_fav_added_label'];
$view_property_label     = $settings['ere_property_view_prop_label'];
$ere_property_grid_image = $settings['ere_property_grid_thumb_sizes'];
$prop_excerpt_length     = $settings['prop_excerpt_length'];

?>

<article <?php post_class( ' rh_prop_card_elementor' ); ?>>

    <div class="rh_prop_card__wrap">

		<?php if ( $is_featured ) : ?>
            <div class="rh_label_elementor rh_label__property_elementor">
                <div class="rh_label__wrap">
	                <?php
	                if ( ! empty( $settings['ere_property_featured_label'] ) ) {
		                echo esc_html( $settings['ere_property_featured_label'] );
	                } else {
		                esc_html_e( 'Featured', 'realhomes-elementor-addon' );
	                }
	                ?>
                    <span></span>
                </div>
            </div>
		<?php endif; ?>

        <figure class="rh_prop_card__thumbnail">
            <a href="<?php the_permalink(); ?>">
				<?php

				if ( has_post_thumbnail( get_the_ID() ) ) {
					the_post_thumbnail( $ere_property_grid_image );
				} else {
					inspiry_image_placeholder( $ere_property_grid_image );
				}
				?>
            </a>

            <div class="rh_overlay"></div>
            <div class="rh_overlay__contents rh_overlay__fadeIn-bottom">
				<?php
				?>
                <a href="<?php the_permalink(); ?>"><?php if ( ! empty( $view_property_label ) ) {
						echo esc_html( "دیدن ملک" );
					} else {
						echo esc_attr__( 'دیدن ملک', 'realhomes-elementor-addon' );
					}; ?></a>

            </div>

			<?php rhea_display_property_label( get_the_ID() ); ?>

            <div class="rh_prop_card__btns">
				<?php
                if('yes' === $show_fav_button){
				if ( function_exists( 'inspiry_favorite_button' ) ) {
					inspiry_favorite_button(get_the_ID(),null,$fav_label,$fav_added_label);
				}
                }
				$compare_properties_module = get_option( 'theme_compare_properties_module' );
				$inspiry_compare_page      = get_option( 'inspiry_compare_page' );
				if ( 'enable' === $compare_properties_module && $inspiry_compare_page ) {

					if ( 'yes' == $settings['ere_enable_compare_properties'] ) {
						?>
                        <span class="add-to-compare-span rhea_compare_icons rhea_svg_fav_icons"
                              data-button-id="<?php the_ID(); ?>"
                              data-button-title="<?php echo get_the_title( get_the_ID() ); ?>"
                              data-button-url="<?php echo get_the_permalink( get_the_ID() ); ?>"

                        >
	<?php

	if ( ere_is_added_to_compare( get_the_ID() ) ) {
		?>
        <span class="compare-placeholder highlight"
              data-tooltip="<?php echo esc_attr( $settings['ere_property_compare_added_label'] ); ?>">
			<?php include RHEA_ASSETS_DIR . 'icons/icon-compare.svg'; ?>
		</span>
        <a class="rh_trigger_compare rhea_add_to_compare hide"
           data-tooltip="<?php echo esc_attr( $settings['ere_property_compare_label'] ); ?>"
           data-property-id="<?php the_ID(); ?>" href="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">
			<?php include RHEA_ASSETS_DIR . 'icons/icon-compare.svg'; ?>
		</a>
		<?php
	} else {
		?>
        <span class="compare-placeholder highlight hide"
              data-tooltip="<?php echo esc_attr( $settings['ere_property_compare_added_label'] ); ?>">
			<?php include RHEA_ASSETS_DIR . 'icons/icon-compare.svg'; ?>
		</span>
        <a class="rh_trigger_compare rhea_add_to_compare"
           data-tooltip="<?php echo esc_attr( $settings['ere_property_compare_label'] ); ?>"
           data-property-id="<?php the_ID(); ?>" href="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">
			<?php include RHEA_ASSETS_DIR . 'icons/icon-compare.svg'; ?>
		</a>
		<?php
	}
	?>
</span>
						<?php
					}
				}
?>


            </div>
        </figure>

        <div class="rh_prop_card__details_elementor">

            <h3>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>

            <p class="rh_prop_card__excerpt"><?php rhea_framework_excerpt( esc_html( $prop_excerpt_length ) ); ?></p>

            <div class="rh_prop_card__meta_wrap_elementor">

				<?php if ( ! empty( $property_bedrooms ) ) : ?>

                    <div class="rh_prop_card__meta">
                        <span class="rhea_meta_titles"><?php

							if ( $bedroom_label ) {
								echo esc_html( $bedroom_label );
							} else {
								esc_html_e( 'Bedrooms', 'realhomes-elementor-addon' );
							}
							?></span>
                        <div class="rhea_meta_icon_wrapper">
							<?php include RHEA_ASSETS_DIR . '/icons/bed.svg'; ?>
                            <span class="figure"><?php echo esc_html( $property_bedrooms ); ?></span>
                        </div>
                    </div>
				<?php endif; ?>

				<?php if ( ! empty( $property_bathrooms ) ) : ?>
                    <div class="rh_prop_card__meta">
                        <span class="rhea_meta_titles"><?php
							if ( $bathroom_label ) {
								echo esc_html( $bathroom_label );
							} else {
								esc_html_e( 'Bathrooms', 'realhomes-elementor-addon' );
							}
							?></span>
                        <div class="rhea_meta_icon_wrapper">
							<?php include RHEA_ASSETS_DIR . '/icons/shower.svg'; ?>
                            <span class="figure"><?php echo esc_html( $property_bathrooms ); ?></span>
                        </div>
                    </div>
				<?php endif; ?>

				<?php if ( ! empty( $property_size ) ) : ?>
                    <div class="rh_prop_card__meta">
                        <span class="rhea_meta_titles"><?php
							if ( $area_label ) {
								echo esc_html( $area_label );
							} else {
								esc_html_e( 'Area', 'realhomes-elementor-addon' );
							}
							?></span>
                        <div class="rhea_meta_icon_wrapper">
							<?php include RHEA_ASSETS_DIR . '/icons/area.svg'; ?>
                            <span class="figure"><?php echo esc_html( $property_size ); ?></span>
							<?php if ( ! empty( $size_postfix ) ) : ?>
                                <span class="label"><?php echo esc_html( $size_postfix ); ?></span>
							<?php endif; ?>
                        </div>
                    </div>
				<?php endif; ?>

            </div>

			<div class="rh_prop_card__priceLabel">
				<span class="rh_prop_card__status"><?php echo esc_html( ere_get_property_statuses( get_the_ID() ) ); ?></span>
				<p class="rh_prop_card__price"><?php ere_property_price(); ?></p>
			</div>

        </div>

    </div>

</article>
<!-- /.rh_prop_card -->
