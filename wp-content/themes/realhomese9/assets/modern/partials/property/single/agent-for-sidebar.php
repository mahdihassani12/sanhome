<?php
/**
 * Property agent for sidebar on single property.
 *
 * @package realhomes
 * @subpackage modern
 */

global $post;   // Property.

/**
 * A function that works as re-usable template
 *
 * @param array $args - function arguments.
 */
function display_sidebar_agent_box( $args ) {
	global $post;

	$theme_display_agent_contact_info     = get_option( 'theme_display_agent_contact_info', 'true' );
	$theme_display_agent_detail_page_link = get_option( 'theme_display_agent_detail_page_link', 'true' );
	$inspiry_property_agent_form          = get_option( 'inspiry_property_agent_form', 'true' );
	$agent_section_classes                = '';

	if( 'false' === $theme_display_agent_contact_info ){
		$agent_section_classes .= ' no-agent-contact-info';
	}

    if( 'false' === $theme_display_agent_detail_page_link ){
		$agent_section_classes .= ' no-agent-know-more-btn';
	}

	if( 'false' === $inspiry_property_agent_form ){
		$agent_section_classes .= ' no-agent-contact-form';
	}
	?>
	<section class="widget rh_property_agent<?php echo esc_attr( $agent_section_classes ); ?> <?php echo esc_attr( ( ! empty( $args['agent_class'] ) ) ? $args['agent_class'] : '' ); ?>">
		<?php
		if ( isset( $args['display_author'] ) && ( $args['display_author'] ) ) {
			if ( isset( $args['profile_image_id'] ) && ( 0 < $args['profile_image_id'] ) ) :
			?>
				<a class="agent-image" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php echo wp_get_attachment_image( $args['profile_image_id'], 'agent-image' ); ?>
				</a>
				<?php
			elseif ( isset( $args['agent_email'] ) ) :
			?>
				<a class="agent-image" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php echo get_avatar( $args['agent_email'], '210' ); ?>
				</a>
				<?php
			endif;
		} else {
			if ( isset( $args['agent_id'] ) && has_post_thumbnail( $args['agent_id'] ) ) {
				?>
				<a class="agent-image" href="<?php echo esc_url( get_permalink( $args['agent_id'] ) ); ?>">
					<?php echo get_the_post_thumbnail( $args['agent_id'], 'agent-image' ); ?>
				</a>
				<?php
			}
		}
		?>
		<?php
		if ( isset( $args['agent_title_text'] ) && ! empty( $args['agent_title_text'] ) ) {
			?>
			<h3 class="rh_property_agent__title"><?php echo esc_html( $args['agent_title_text'] ); ?></h3>
			<?php
		}
		?>
	    <?php if( 'true' === $theme_display_agent_contact_info ) : ?>
            <div class="rh_property_agent__agent_info">
                <?php
                if ( isset( $args['agent_office_phone'] ) && ! empty( $args['agent_office_phone'] ) ) {
                    ?>
                    <p class="contact office">
                        <?php esc_html_e( 'Office', 'easy-real-estate' ); ?> : <span class="value"><?php echo esc_html( $args['agent_office_phone'] ); ?></span>
                    </p>
                    <?php
                }
                if ( isset( $args['agent_mobile'] ) && ! empty( $args['agent_mobile'] ) ) {
                    ?>
                    <p class="contact mobile">
                        <?php esc_html_e( 'Mobile', 'easy-real-estate' ); ?> : <span class="value"><?php echo esc_html( $args['agent_mobile'] ); ?></span>
                    </p>
                    <?php
                }
                if ( isset( $args['agent_office_fax'] ) && ! empty( $args['agent_office_fax'] ) ) {
                    ?>
                    <p class="contact fax">
                        <?php esc_html_e( 'Fax', 'easy-real-estate' ); ?> : <span class="value"><?php echo esc_html( $args['agent_office_fax'] ); ?></span>
                    </p>
                    <?php
                }
                if ( isset( $args['agent_whatsapp'] ) && ! empty( $args['agent_whatsapp'] ) ) {
                    ?>
                    <p class="contact whatsapp">
                        <?php esc_html_e( 'WhatsApp', 'easy-real-estate' ); ?> : <span class="value"><?php echo esc_html( $args['agent_whatsapp'] ); ?></span>
                    </p>
                    <?php
                }
                if ( isset( $args['agent_email'] ) && ! empty( $args['agent_email'] ) ) {
                    ?>
                    <p class="contact email">
                        <?php esc_html_e( 'Email', 'easy-real-estate' ); ?> : <a href="mailto:<?php echo esc_attr( antispambot( $args['agent_email'] ) ); ?>" class="value"><?php echo esc_html( antispambot( $args['agent_email'] ) ); ?></a>
                    </p>
                    <?php
                }
                ?>
            </div>
        <?php endif;

	    if ( 'true' === $theme_display_agent_detail_page_link ) :
		    $theme_agent_detail_page_link_text = get_option( 'theme_agent_detail_page_link_text', esc_html__( 'بیشتر در باره من', 'easy-real-estate' ) );
		    ?>
		    <?php if ( isset( $args['display_author'] ) && ( $args['display_author'] ) ) : ?>
                <a class="rh_btn rh_btn--primary rh_property_agent__link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( $theme_agent_detail_page_link_text ); ?></a>
		    <?php else : ?>
                <a class="rh_btn rh_btn--primary rh_property_agent__link" href="<?php echo esc_url( get_permalink( $args['agent_id'] ) ); ?>"><?php echo esc_html( $theme_agent_detail_page_link_text ); ?></a>
		    <?php endif;
	    endif; ?>

		<?php
		if ( 'true' === $inspiry_property_agent_form ) :
			if ( isset( $args['agent_email'] ) && ! empty( $args['agent_email'] ) ) :
				$agent_form_id = 'agent-form-id';
				if ( isset( $args['agent_id'] ) ) {
					$agent_form_id .= $args['agent_id'];
				}
				?>
				<div class="rh_property_agent__enquiry_form">
					<form id="<?php echo esc_attr( $agent_form_id ); ?>" class="rh_widget_form agent-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
						<p class="rh_widget_form__row">
							<label for="name"><?php esc_html_e( 'Name', 'easy-real-estate' ); ?></label>
							<input type="text" name="name" placeholder="<?php esc_html_e( 'Name', 'easy-real-estate' ); ?>" class="required" title="<?php esc_html_e( '* Please provide your name', 'easy-real-estate' ); ?>" />
						</p>
						<!-- /.rh_widget_form__row -->
						<p class="rh_widget_form__row">
							<label for="email"><?php esc_html_e( 'Email', 'easy-real-estate' ); ?></label>
							<input type="text" name="email" placeholder="<?php esc_html_e( 'Email', 'easy-real-estate' ); ?>" class="required" title="<?php esc_html_e( '* Please provide valid email address', 'easy-real-estate' ); ?>" />
						</p>
						<!-- /.rh_widget_form__row -->
						<p class="rh_widget_form__row">
							<label for="phone"><?php esc_html_e( 'Phone', 'easy-real-estate' ); ?></label>
							<input type="text" name="phone" placeholder="<?php esc_html_e( 'Phone', 'easy-real-estate' ); ?>" class="required" title="<?php esc_html_e( '* Please provide valid phone number', 'easy-real-estate' ); ?>" />
						</p>
						<!-- /.rh_widget_form__row -->
						<p class="rh_widget_form__row">
							<label for="message"><?php esc_html_e( 'Message', 'easy-real-estate' ); ?></label>
							<textarea cols="40" rows="6" type="text" name="message" placeholder="<?php esc_html_e( 'Message', 'easy-real-estate' ); ?>" class="required" title="<?php esc_html_e( '* Please provide your message', 'easy-real-estate' ); ?>"></textarea>
						</p>
						<!-- /.rh_widget_form__row -->
						<?php

							$is_gdpr_enabled = inspiry_is_gdpr_enabled();

							if ( $is_gdpr_enabled ) {

								$gdpr_agreement_text = inspiry_gdpr_agreement_content();

								if ( ! empty( $gdpr_agreement_text ) ) {
									?>
									<div id="rh_inspiry_gdpr-<?php echo esc_attr( $agent_form_id ); ?>" class="rh_inspiry_gdpr rh_widget_form__row clearfix">
										<?php

											$gdpr_agreement_label   = inspiry_gdpr_agreement_content( 'label' );
											$gdpr_agreement_val_msg = inspiry_gdpr_agreement_content( 'validation-message' );

											if ( ! empty( $gdpr_agreement_label ) ) {
												?>
												<span class="gdpr-checkbox-label"><?php echo esc_html( $gdpr_agreement_label ); ?>
													<span class="required-label">*</span></span>
												<?php
											}

										?>
										<input type="checkbox" id="inspiry-gdpr-<?php echo esc_attr( $agent_form_id ); ?>" class="required" name="gdpr" title="<?php echo esc_attr( $gdpr_agreement_val_msg ); ?>" value="<?php echo strip_tags( $gdpr_agreement_text ); ?>">
										<label for="inspiry-gdpr-<?php echo esc_attr( $agent_form_id ); ?>"><?php echo wp_kses( $gdpr_agreement_text, inspiry_allowed_html() ); ?></label>
									</div>
									<?php
								}
							}

							if ( class_exists( 'Easy_Real_Estate' ) ) {
								if ( ere_is_reCAPTCHA_configured() ) :
									?>
									<div class="rh_modal__recaptcha">
										<div class="inspiry-recaptcha-wrapper clearfix">
											<div class="inspiry-google-recaptcha"></div>
										</div>
									</div>
									<?php
								endif;
							}
						?>

						<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'agent_message_nonce' ) ); ?>"/>
						<input type="hidden" name="target" value="<?php echo esc_attr( antispambot( $args['agent_email'] ) ); ?>">
                        <?php
                        if(!empty($args['agent_id'])){
	                        ?>
                            <input type="hidden" name="agent_id" value="<?php echo esc_attr($args['agent_id']); ?>">
	                        <?php
                        }
                        if(!empty($args['author_id'])){
                            ?>
                            <input type="hidden" name="author_id" value="<?php echo esc_attr($args['author_id'])?>">
	                        <?php
                        }
                        ?>
                        <input type="hidden" name="author_name" value="<?php echo esc_attr($args['agent_title_text']); ?>">
                        <input type="hidden" name="property_id" value="<?php echo esc_attr( get_the_ID() ) ?>">
                        <input type="hidden" name="action" value="send_message_to_agent"/>
						<input type="hidden" name="property_title" value="<?php echo esc_attr( get_the_title( $post->ID ) ); ?>"/>
						<input type="hidden" name="property_permalink" value="<?php echo esc_url_raw( get_permalink( $post->ID ) ); ?>"/>

						<input type="submit" value="<?php esc_html_e( 'Send Message', 'easy-real-estate' ); ?>" name="submit" class="rh_btn rh_btn--primary rh_widget_form__submit">

						<span id="ajax-loader-<?php echo esc_attr( $agent_form_id ); ?>" class="ajax-loader"><?php include INSPIRY_THEME_DIR . '/images/loader.svg'; ?></span>

						<div class="error-container"></div>
						<!-- /.error-container -->
						<div class="message-container"></div>
						<!-- /.message-container -->

					</form>
				</div>
				<!-- /.rh_property_agent__enquiry_form -->

				<script type="text/javascript">
					( function( $ ) {
						"use strict";

						if ( jQuery().validate && jQuery().ajaxSubmit ) {

							var agentForm = $('#<?php echo esc_attr( $agent_form_id ); ?>');
							var submitButton = agentForm.find( '.rh_widget_form__submit' ),
								ajaxLoader = agentForm.find( '.ajax-loader' ),
								messageContainer = agentForm.find( '.message-container' ),
								errorContainer = agentForm.find( '.error-container' );

							// Property detail page form
							agentForm.validate( {
								errorLabelContainer: errorContainer,
								submitHandler : function( form ) {
									$( form ).ajaxSubmit( {
										beforeSubmit: function() {
											submitButton.attr('disabled','disabled');
											ajaxLoader.fadeIn('fast');
											messageContainer.fadeOut('fast');
											errorContainer.fadeOut('fast');
										},
										success: function( ajax_response, statusText, xhr, $form) {
											var response = $.parseJSON ( ajax_response );
											ajaxLoader.fadeOut('fast');
											submitButton.removeAttr('disabled');
											if ( response.success ) {
												$form.resetForm();
												messageContainer.html( '<p>' + response.message + '</p>' ).fadeIn('fast');

												// call reset function if it exists
												if ( typeof inspiryResetReCAPTCHA == 'function' ) {
													inspiryResetReCAPTCHA();
												}

											} else {
												errorContainer.html( '<p>' + response.message + '</p>' ).fadeIn('fast');
											}
										}
									} );
								}
							} );
						}
					} )( jQuery );
				</script>
			<?php endif; ?>
		<?php endif; ?>
	</section>
	<?php
}

/**
 * Logic behind displaying agents / author information
 */
$display_agent_info   = get_option( 'theme_display_agent_info' );
$agent_display_option = get_post_meta( get_the_ID(), 'REAL_HOMES_agent_display_option', true );

if ( ( 'true' === $display_agent_info ) && ( 'none' !== $agent_display_option ) ) {

	if ( 'my_profile_info' === $agent_display_option ) {

		$profile_args                       = array();
		$profile_args['display_author']     = true;
		$profile_args['author_id'] = get_the_author_meta('ID');
		$profile_args['agent_title_text']   = get_the_author_meta( 'display_name' );
		$profile_args['profile_image_id']   = intval( get_the_author_meta( 'profile_image_id' ) );
		$profile_args['agent_mobile']       = get_the_author_meta( 'mobile_number' );
		$profile_args['agent_whatsapp']     = get_the_author_meta( 'mobile_whatsapp' );
		$profile_args['agent_office_phone'] = get_the_author_meta( 'office_number' );
		$profile_args['agent_office_fax']   = get_the_author_meta( 'fax_number' );
		$profile_args['agent_email']        = get_the_author_meta( 'user_email' );
		display_sidebar_agent_box( $profile_args );

	} else {

		$property_agents = get_post_meta( get_the_ID(), 'REAL_HOMES_agents' );
		// Remove invalid ids.
		$property_agents = array_filter(
			$property_agents, function( $v ) {
				return ( $v > 0 );
			}
		);
		// Remove duplicated ids.
		$property_agents = array_unique( $property_agents );
		$agents_count    = 0;
		if ( ! empty( $property_agents ) ) {
			foreach ( $property_agents as $agent ) {
				if ( 0 < intval( $agent ) ) {
					$agent_args                       = array();
					$agent_args['agent_id']           = intval( $agent );
					$agent_args['agent_title_text']   = esc_html(get_option('inspiry_property_agent_label','Agent')) . ' ' . get_the_title( $agent_args['agent_id'] );
					$agent_args['agent_mobile']       = get_post_meta( $agent_args['agent_id'], 'REAL_HOMES_mobile_number', true );
					$agent_args['agent_whatsapp']     = get_post_meta( $agent_args['agent_id'], 'REAL_HOMES_whatsapp_number', true );
					$agent_args['agent_office_phone'] = get_post_meta( $agent_args['agent_id'], 'REAL_HOMES_office_number', true );
					$agent_args['agent_office_fax']   = get_post_meta( $agent_args['agent_id'], 'REAL_HOMES_fax_number', true );
					$agent_args['agent_email']        = get_post_meta( $agent_args['agent_id'], 'REAL_HOMES_agent_email', true );
					$agent_args['agent_class']        = ( 0 !== $agents_count ) ? 'multiple-agent' : false;
					display_sidebar_agent_box( $agent_args );
					$agents_count++;
				}
			}
		}
	}
}
