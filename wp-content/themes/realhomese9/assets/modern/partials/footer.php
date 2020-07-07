<?php
/**
 * Footer template
 *
 * @package realhomes
 * @subpackage modern
 */

$get_border_type   = get_option( 'inspiry_home_sections_border', 'diagonal-border' );
//if ( $get_border_type == 'diagonal-border' || $get_border_type == 'diagonal-border-rtl') {
//	$border_class = 'diagonal-border-footer';
//} else {
//	$border_class = 'flat-border';
//}

if( is_page_template('templates/home.php')){
	if ( $get_border_type == 'diagonal-border') {
	$border_class = 'diagonal-border-footer';
} else {
	$border_class = 'rh_footer__before_fix';
}
}else{
	$border_class = 'rh_footer__before_fix';
}

?>
<footer class="rh_footer <?php echo esc_attr($border_class);?>">

	

	<div class="rh_footer__wrap rh_footer--alignTop rh_footer--paddingBottom">
		<?php

			$footer_columns = get_option( 'inspiry_footer_columns', '3' );

			switch ( $footer_columns ) {
				case '1' :
					$column_class = 'column-1';
					break;
				case '2' :
					$column_class = 'columns-2';
					break;
				case '4' :
					$column_class = 'columns-4';
					break;
				default:
					$column_class = 'columns-3';
			}

		?>
		<div class="rh_footer__widgets <?php echo esc_attr( $column_class ); ?>">
			<?php get_template_part( 'assets/modern/partials/footer/first-column' ); ?>
		</div>
		<!-- /.rh_footer__widgets -->

		<?php
			if ( intval( $footer_columns ) >= 2 ) {
				?>
				<div class="rh_footer__widgets <?php echo esc_attr( $column_class ); ?>">
					<?php get_template_part( 'assets/modern/partials/footer/second-column' ); ?>
				</div>
				<!-- /.rh_footer__widgets -->
				<?php
			}

			if ( intval( $footer_columns ) >= 3 ) {
				?>
				<div class="rh_footer__widgets <?php echo esc_attr( $column_class ); ?>">
					<?php get_template_part( 'assets/modern/partials/footer/third-column' ); ?>
				</div>
				<!-- /.rh_footer__widgets -->
				<?php
			}

			if ( intval( $footer_columns ) == 4 ) {
				?>
				<div class="rh_footer__widgets <?php echo esc_attr( $column_class ); ?>">
					<?php get_template_part( 'assets/modern/partials/footer/fourth-column' ); ?>
				</div>
				<!-- /.rh_footer__widgets -->
				<?php
			}
		?>
	</div>
	<!-- /.rh_footer__wrap -->

	<div class="rh_footer__wrap rh_footer--space_between">
		<p class="copyrights">
			<?php
			$copyrights = get_option( 'theme_copyright_text' );
			echo ( ! empty( $copyrights ) ) ? $copyrights : false;
			?>
		</p>
		<!-- /.copyrights -->

		<p class="designed-by">
			<?php
			$designed_by = get_option( 'theme_designed_by_text' );
			echo ( ! empty( $designed_by ) ) ? $designed_by : false;
			?>
		</p>
		<!-- /.copyrights -->
	</div>
	<!-- /.rh_footer__wrap -->

</footer>
<!-- /.rh_footer -->

<?php
/**
 * Display link to previous and next entry
 */
inspiry_post_nav();
?>

</div>
<!-- /.rh_wrap -->
