<?php
global $settings;
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
	$property_id = get_the_ID();
	if ( ere_is_added_to_compare( $property_id ) ) {
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
