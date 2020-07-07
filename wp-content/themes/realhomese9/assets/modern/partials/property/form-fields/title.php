<?php
/**
 * Field: Title
 *
 * @since 	3.0.0
 * @package RH/modern
 */

?>

<div class="rh_form__item rh_form--1-column rh_form--columnAlign">
	<label for="inspiry_property_title"><?php esc_html_e( 'عنوان ملک', 'easy-real-estate' ); ?></label>
	<input id="inspiry_property_title" name="inspiry_property_title" type="text" class="required" value="<?php
	if ( inspiry_is_edit_property() ) {
	    global $target_property;
	    echo esc_attr( $target_property->post_title );
	}
	?>" title="<?php esc_attr_e( '* لطفا عنوان ملک تان را وارد کنید', 'easy-real-estate' ); ?>" placeholder="<?php esc_attr_e( 'لطفا عنوان ملک تان را وارد کنید', 'easy-real-estate' ); ?>" autofocus required/>
</div>
<!-- /.rh_form__item -->
