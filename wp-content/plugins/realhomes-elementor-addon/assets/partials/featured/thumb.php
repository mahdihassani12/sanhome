<a class="rhea_fp_thumb" href="<?php the_permalink(); ?>">
	<?php
	if ( has_post_thumbnail( get_the_ID() ) ) {
		the_post_thumbnail( 'modern-property-detail-slider' );
	} else {
		inspiry_image_placeholder( 'modern-property-detail-slider' );
	}
	?>
</a>