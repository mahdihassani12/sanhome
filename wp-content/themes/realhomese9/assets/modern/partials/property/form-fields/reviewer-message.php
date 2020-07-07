<?php
/**
 * Field: Reviewer Message
 *
 * @since    3.0.0
 * @package RH/modern
 */

$target_email = get_option('theme_submit_notice_email');



if (inspiry_is_edit_property()){

    $post_id = $_GET["edit_property"];

    $inspiry_whatsup = get_post_meta($post_id, 'inspiry_whatsup', true);

    $inspiry_fullname = get_post_meta($post_id, 'inspiry_fullname', true);

    $inspiry_mobile = get_post_meta($post_id, 'inspiry_mobile', true);

}


?>
<div class="rh_form__item rh_form--1-column rh_form--columnAlign agent-fields-wrapper">

    <label> معلومات خودتان</label>


    <div class="rh_form__item rh_form--1-column rh_form--columnAlign">
        <label for="fullname">
            <?php esc_html_e('نام و نام خانوادگی  برای بازدید کننده', 'easy-real-estate'); ?></label>
        <input name="fullname" type="text" value="<?php
        if (inspiry_is_edit_property()) {
            if (isset($inspiry_fullname)) {
                echo($inspiry_fullname);
            }
        } else {
            echo get_user_meta(get_current_user_id(), "first_name", true) . " " . get_user_meta(get_current_user_id(), "last_name", true);
        }
        ?>" id="fullname">

    </div>
    <div class="rh_form__item rh_form--1-column rh_form--columnAlign reviewer-message-field-wrapper">
        <label for="phone"><?php esc_html_e(' شماره تماس برای بازدید کننده', 'easy-real-estate'); ?></label>
        <input name="mobile"
               type="number"
               value="<?php
               if (inspiry_is_edit_property()) {

                   if (isset($inspiry_mobile)) {

                       echo($inspiry_mobile);

                   }
               } else {
                   echo get_user_meta(get_current_user_id(), "mobile_number", true);
               }
               ?>"
               id="phone"
               class="demo-input number-only flex-label w-100 dirty"
               pattern="07[0-9]{8}"
               required="">
    </div>
    <div class="rh_form__item rh_form--1-column rh_form--columnAlign reviewer-message-field-wrapper">
        <label for="whatsup"><?php esc_html_e('شماره تماس (whatsapp) برای بازدید کننده', 'easy-real-estate'); ?></label>
        <input  name="whatsup"
               value="<?php
               if (inspiry_is_edit_property()) {
                   if (isset($inspiry_whatsup)) {
                       echo($inspiry_whatsup);
                   }
               } else {
                   echo get_user_meta(get_current_user_id(), "mobile_number_whatsup", true);
               }
               ?>"
               type="number"
               id="whatsup">
    </div>

</div>
