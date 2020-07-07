<div id="package-form-modal" class="modal-etates">

    <!-- Modal content -->
    <div class="modal-content-form-package">
        <div class="d-flex  text-center  header-modal align-items-center">
            <span class="close-packages"><i class="fa fa-close"></i></span>
            <h3 class="margin-0 expanded">برای درخواست خرید ، لطفا اطلاعات خود را در فرم زیر وارد نمایید</h3>
        </div>
        <div class="model-content">
            <?php
            if (is_user_logged_in()):
                ?>
                <form id="package_form_submit" action="<?php echo admin_url('admin-ajax.php'); ?>"  method="post">
                    <div class="rh_form__row">

                        <input class="package-selected" type="hidden" name="packages">
                        <input id="golden-input" type="hidden" name="golden-input">
                        <input id="vip-input" type="hidden" name="vip-input">
                        <input id="normal-input" type="hidden" name="normal-input">


                        <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                            <label class="demo-label" for="name">نام</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="demo-input flex-label w-100 dirty"
                                   required="">
                            <span class="error-input">لطفا نام خود را وارد کنید .</span>

                        </div>
                        <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                            <label class="demo-label" for="last-name">نام خانوادگی</label>
                            <input type="text"
                                   name="family"
                                   id="family-name"
                                   class="demo-input flex-label w-100 dirty"
                                   required="">
                            <span class="error-input">لطفا نام خانوادگی خود را وارد کنید .</span>

                        </div>
                        <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                            <label class="demo-label" for="buildings">نام املاک یا نام شرکت</label>
                            <input type="text"
                                   name="agency_name"
                                   id="agency_name1"
                                   class="demo-input flex-label w-100 dirty"
                                   required="">
                            <span
                                    class="error-input">لطفا نام املاک خود را وارد کنید .</span></div>
                        <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                            <label class="demo-label" for="mobile">تلفن همراه</label>
                            <input type="text"
                                   name="mobile"
                                   id="request-mobile"
                                   class="demo-input number-only flex-label w-100 dirty"
                                   pattern="07[0-9]{8}"
                                   required="">
                            <span class="error-input">لطفا تلفن همراه خود را وارد کنید .</span>
                        </div>
                        <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                            <label class="demo-label" for="email">ایمیل</label>
                            <input type="text"
                                   name="email"
                                   id="email"
                                   class="demo-input flex-label w-100 dirty"
                                   required="">
                            <span class="error-input">لطفا ایمیل خود را وارد کنید .</span>
                        </div>
                        <div class="rh_form__item rh_form--3-column rh_form--columnAlign">

                        </div>
                        <div class="rh_form__item rh_form--3-column rh_form--columnAlign submit-field-wrapper">
                            <input type="submit" name="package-submit" id="form-button" value="ثبت درخواست"
                                   class="rh_btn rh_btn--primary">
                        </div>
                    </div>
                </form>
            <?php
            else:
                echo "<p>شما باید وارد شوید</p>";
            endif;
            ?>
        </div>
    </div>

</div>