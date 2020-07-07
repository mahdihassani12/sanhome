<?php
/**
 * Field: Price
 *
 * @since    3.0.0
 * @package RH/modern
 */

?>

<div class="rh_form__item rh_form--3-column rh_form--columnAlign">
    <label for="price"><?php esc_html_e(' قمیت فروش یا اجاره', 'easy-real-estate'); ?></label>
    <div class="d-flex containter-input-with-perfix">
        <input id="price" style="border: none;" name="price" type="number" value="<?php
        if (inspiry_is_edit_property()) {
            global $post_meta_data;
            if (isset($post_meta_data['REAL_HOMES_property_price'])) {
                echo esc_attr($post_meta_data['REAL_HOMES_property_price'][0]);
            }
        }
        ?>" title="<?php esc_attr_e('* لطفا فقط عدد وارد کنید!', 'easy-real-estate'); ?>"/>
        <span class="prefex-input">افغانی</span>
    </div>
</div>
<!-- /.rh_form__item -->
