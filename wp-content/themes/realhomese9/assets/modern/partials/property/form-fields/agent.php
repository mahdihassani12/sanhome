


<div class="rh_form__item rh_form--1-column rh_form--columnAlign agent-fields-wrapper">
    <label><?php esc_html_e( 'نمایش به حیث:', 'easy-real-estate' ); ?></label>
    <div class="rh_agent_options">



        <label for="property_option_normal">
            <span class="title"><?php esc_html_e( 'عادری', 'framework' ); ?></span>
            <span class="sub-title"><?php esc_html_e( '( نمایش در بخش جستچو )', 'easy-real-estate' ); ?></span>
            <input <?php  echo get_user_meta(get_current_user_id(),"normal_properties",true) <= 0 ? " disabled" : ""; ?> id="property_option_normal" type="radio" name="agent_display_option" value="normal" />
            <span class="control__indicator"></span>

            <span class="remind-property">
                <?php  ?>

                <?php

                if (get_user_meta(get_current_user_id(),"normal_properties",true) ){
                    esc_html_e( 'مقدار باقی مانده ملک ساده تان ', 'framework' );

                   echo get_user_meta(get_current_user_id(),"normal_properties",true) ;
                    esc_html_e( ' میباشد.', 'framework' );
                }else{

                    esc_html_e( 'شما هیچ ملک عادی ندارید.', 'framework' );
                }
                ?>

            </span>

        </label>
        <label for="property_option_vip">
            <span class="title"><?php esc_html_e( 'ویژه', 'framework' ); ?></span>
            <span class="sub-title"><?php esc_html_e( '( نمایش ۴ برابر بهتر از ملک عادی )', 'easy-real-estate' ); ?></span>
            <input <?php  echo get_user_meta(get_current_user_id(),"vip_properties",true) <= 0 ? " disabled" : ""; ?> id="property_option_vip" type="radio" name="agent_display_option" value="vip" />
            <span class="control__indicator"></span>
            <span class="remind-property">
                <?php  ?>

                <?php

                if (get_user_meta(get_current_user_id(),"vip_properties",true) ){
                    esc_html_e( 'مقدار باقی مانده ملک ویژه تان ', 'framework' );

                    echo get_user_meta(get_current_user_id(),"vip_properties",true) ;
                    esc_html_e( ' میباشد.', 'framework' );
                }else{

                    esc_html_e( 'شما هیچ ملک ویژه ندارید.', 'framework' );
                }
                ?>

            </span>

        </label>
        <label for="property_option_golden">
            <span class="title"><?php esc_html_e( 'طلایی', 'framework' ); ?></span>
            <span class="sub-title"><?php esc_html_e( '( نمایش به صدر جستجو و ۱۰ برابر بهتر از ملک عادی )', 'easy-real-estate' ); ?></span>
            <input <?php  echo get_user_meta(get_current_user_id(),"golden_properties",true) <= 0 ? " disabled" : ""; ?> id="property_option_golden" type="radio" name="agent_display_option" value="golden" />
            <span class="control__indicator"></span>
            <span class="remind-property">
                <?php  ?>

                <?php

                if (get_user_meta(get_current_user_id(),"golden_properties",true) ){
                    esc_html_e( 'مقدار باقی مانده ملک طلایی تان ', 'framework' );

                    echo get_user_meta(get_current_user_id(),"golden_properties",true) ;
                    esc_html_e( ' میباشد.', 'framework' );
                }else{

                    esc_html_e( 'شما هیچ ملک طلایی ندارید.', 'framework' );
                }
                ?>

            </span>

        </label>

    </div>


</div>

