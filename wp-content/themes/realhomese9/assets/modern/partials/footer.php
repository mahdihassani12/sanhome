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
	<div class="container">
		<div class="row footer_row">
			<div class="col-md-3">
				<div class="rh_widgets">
					<?php dynamic_sidebar( 'footer-fourth-column' ); ?>
			    </div>
			</div>

			<div class="col-md-3">
				<div class="rh_widgets">
					<?php dynamic_sidebar( 'footer-third-column' ); ?>
			    </div>
			</div>

			<div class="col-md-3">
				<div class="rh_widgets">
					<?php dynamic_sidebar( 'footer-second-column' ); ?>
			    </div>
			</div>

			<div class="col-md-3">
				<div class="rh_widgets">
					<?php dynamic_sidebar( 'footer-first-column' ); ?>
			    </div>
			</div>

		</div> <!-- end of inner row -->
			<hr>
		<div class="rh_footer__wrap rh_footer--space_between copyrights_div">
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
	</div>
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
