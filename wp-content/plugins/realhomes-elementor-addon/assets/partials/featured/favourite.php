<?php
global $settings;
$show_fav_button = $settings['ere_enable_fav_properties'];
$fav_label       = $settings['ere_property_fav_label'];
$fav_added_label = $settings['ere_property_fav_added_label'];

$fav_button = get_option( 'theme_enable_fav_button' );
if ( 'true' === $fav_button ) {
//	if ( 'yes' === $show_fav_button ) {
		?>
        <div class="rh_prop_card__btns rhea_svg_fav_icons ">
			<?php
			if ( is_added_to_favorite( get_the_ID() ) ) {
				?>
                <span class="favorite-placeholder highlight__red"
                      data-tooltip="<?php if ( $fav_added_label ) {
					      echo esc_attr( $fav_added_label );
				      } else {
					      echo esc_attr__( 'Added to favorites', 'realhomes-elementor-addon' );
				      }; ?>">
								<?php include RHEA_ASSETS_DIR . '/icons/favorite.svg'; ?>
							</span>
				<?php
			} else {
				?>
                <form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
                      method="post"
                      class="add-to-favorite-form">
                    <input type="hidden" name="property_id"
                           value="<?php echo esc_attr( get_the_ID() ); ?>"/>
                    <input type="hidden" name="action" value="add_to_favorite"/>
                </form>
                <span class="favorite-placeholder highlight__red hide"
                      data-tooltip="<?php if ( $fav_added_label ) {
					      echo esc_attr( $fav_added_label );
				      } else {
					      echo esc_attr__( 'Added to favorites', 'realhomes-elementor-addon' );
				      }; ?>">
								<?php include RHEA_ASSETS_DIR . '/icons/favorite.svg'; ?>
							</span>
                <a href="#" class="favorite ere-add-to-favorite"
                   data-tooltip="<?php if ( $fav_label ) {
					   echo esc_attr( $fav_label );
				   } else {
					   echo esc_attr__( 'Add to favorites', 'realhomes-elementor-addon' );
				   }; ?>">
					<?php include RHEA_ASSETS_DIR . '/icons/favorite.svg'; ?>
                </a>
				<?php
			}
			?>
        </div>
		<?php
//	}
}
?>
