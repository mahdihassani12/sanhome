<?php
/**
 * Functions related to Contact or Message Forms Handling
 *
 */


if( !function_exists( 'ere_mail_from_name' ) ) :
	/**
	 * Override 'WordPress' as from name in emails sent by wp_mail function
	 * @return string
	 */
    function ere_mail_from_name() {
	    // The blogname option is escaped with esc_html on the way into the database in sanitize_option
	    // we want to reverse this for the plain text arena of emails.
	    return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
    }
	add_filter( 'wp_mail_from_name', 'ere_mail_from_name' );
endif;


if ( ! function_exists( 'ere_send_contact_message' ) ) {
	/**
	 * Handler for Contact form on contact page template
	 */
	function ere_send_contact_message() {

		if ( isset( $_POST[ 'email' ] ) ):

			/*
			 * Verify Nonce
			 */
			if ( ! isset( $_POST[ 'nonce' ] ) || ! wp_verify_nonce( $_POST[ 'nonce' ], 'send_message_nonce' ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Unverified Nonce!', 'easy-real-estate' )
				) );
				die;
			}

			/* Verify Google reCAPTCHA */
			ere_verify_google_recaptcha();

			/*
			 * Sanitize and Validate Target email address that will be configured from theme options
			 */
			if ( isset( $_POST['the_id'] ) ) {
				$to_email = sanitize_email( get_post_meta( $_POST['the_id'], 'theme_contact_email', true ) );
			} else {
				$to_email = sanitize_email( get_option( 'theme_contact_email' ) );
			}

			$to_email = is_email( $to_email );

			if ( ! $to_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Target Email address is not properly configured!', 'easy-real-estate' )
				) );
				die;
			}

			/*
			 * Sanitize and Validate contact form input data
			 */
			$from_name = sanitize_text_field( $_POST[ 'name' ] );
			$phone_number = sanitize_text_field( $_POST[ 'number' ] );
			$message = stripslashes( $_POST[ 'message' ] );

			$from_email = sanitize_email( $_POST[ 'email' ] );
			$from_email = is_email( $from_email );
			if ( ! $from_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Provided Email address is invalid!', 'easy-real-estate' )
				) );
				die;
			}

			/*
			 * Email Subject
			 */
			$email_subject = esc_html__( 'New message sent by', 'easy-real-estate' ) . ' ' . $from_name . ' ' . esc_html__( 'using contact form at', 'easy-real-estate' ) . ' ' . get_bloginfo( 'name' );

			/*
			 * Email Body
			 */
			$email_body = esc_html__( "You have received a message from: ", 'easy-real-estate' ) . $from_name . " <br/>";
			if ( ! empty( $phone_number ) ) {
				$email_body .= esc_html__( "Phone Number : ", 'easy-real-estate' ) . $phone_number . " <br/>";
			}
			$email_body .= esc_html__( "Their additional message is as follows.", 'easy-real-estate' ) . " <br/>";
			$email_body .= wpautop( $message ) . " <br/>";

			$add_gdpr_in_email = get_option( 'inspiry_gdpr_in_email', '0' );

			if ( '1' == $add_gdpr_in_email ) {
				$GDPR_agreement = $_POST['gdpr'];
				if ( ! empty( $GDPR_agreement ) ) {
					$email_body .= esc_html__( 'GDPR Agreement: ' ) . wpautop( $GDPR_agreement ) . " <br/>";
				}
			}

			$email_body .= esc_html__( "You can contact ", 'easy-real-estate' ) . $from_name . esc_html__( " via email, ", 'easy-real-estate' ) . $from_email;

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers = array();

			/* Send CC of contact form message if configured */
			if ( isset( $_POST['the_id'] ) ) {
				$cc_email = sanitize_email( get_post_meta( $_POST['the_id'], 'theme_contact_cc_email', true ) );
			} else {
				$cc_email = sanitize_email( get_option( 'theme_contact_cc_email' ) );
			}

			$cc_email = explode( ',', $cc_email );
			if ( ! empty( $cc_email ) ) {
				foreach ( $cc_email as $ind_email ) {
					$ind_email = sanitize_email( $ind_email );
					$ind_email = is_email( $ind_email );
					if ( $ind_email ) {
						$headers[] = "Cc: $ind_email";
					}
				}
			}

			/* Send BCC of contact form message if configured */
			if ( isset( $_POST['the_id'] ) ) {
				$bcc_email = sanitize_email( get_post_meta( $_POST['the_id'], 'theme_contact_bcc_email', true ) );
			} else {
				$bcc_email = sanitize_email( get_option( 'theme_contact_bcc_email' ) );
			}

			$bcc_email = explode( ',', $bcc_email );
			if ( ! empty( $bcc_email ) ) {
				foreach ( $bcc_email as $ind_email ) {
					$ind_email = sanitize_email( $ind_email );
					$ind_email = is_email( $ind_email );
					if ( $ind_email ) {
						$headers[] = "Bcc: $ind_email";
					}
				}
			}

			$headers[] = "Reply-To: $from_name <$from_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers = apply_filters( "inspiry_contact_mail_header", $headers );    // just in case if you want to modify the header in child theme

			if ( wp_mail( $to_email, $email_subject, $email_body, $headers ) ) {
				echo json_encode( array(
					'success' => true,
					'message' => esc_html__( "Message Sent Successfully!", 'easy-real-estate' )
				) );
			} else {
				echo json_encode( array(
						'success' => false,
						'message' => esc_html__( "Server Error: WordPress mail function failed!", 'easy-real-estate' )
					)
				);
			}

		else:
			echo json_encode( array(
					'success' => false,
					'message' => esc_html__( "Invalid Request !", 'easy-real-estate' )
				)
			);
		endif;

		do_action('inspiry_after_contact_form_submit');

		die;

	}

	add_action( 'wp_ajax_nopriv_send_message', 'ere_send_contact_message' );
	add_action( 'wp_ajax_send_message', 'ere_send_contact_message' );

}


if ( ! function_exists( 'ere_send_contact_message_cfos' ) ) {
	/**
	 * Handler for Contact form on contact page template
	 */
	function ere_send_contact_message_cfos() {

		if ( isset( $_POST[ 'email' ] ) ):

			/*
			 * Verify Nonce
			 */
			if ( ! isset( $_POST[ 'nonce' ] ) || ! wp_verify_nonce( $_POST[ 'nonce' ], 'send_cfos_message_nonce' ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Unverified Nonce!', 'easy-real-estate' )
				) );
				die;
			}

			/* Verify Google reCAPTCHA */
			ere_verify_google_recaptcha();

			/*
			 * Sanitize and Validate Target email address that will be configured from theme options
			 */
			if ( isset( $_POST['the_id'] ) ) {
				$to_email = sanitize_email( get_post_meta( $_POST['the_id'], 'theme_contact_form_email_cfos', true ) );
			} else {
				$to_email = '';
			}

			$to_email = is_email( $to_email );

			if ( ! $to_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Target Email address is not properly configured!', 'easy-real-estate' )
				) );
				die;
			}

			/*
			 * Sanitize and Validate contact form input data
			 */
			$from_name = sanitize_text_field( $_POST[ 'name' ] );
			$phone_number = sanitize_text_field( $_POST[ 'number' ] );
			$message = stripslashes( $_POST[ 'message' ] );

			$from_email = sanitize_email( $_POST[ 'email' ] );
			$from_email = is_email( $from_email );
			if ( ! $from_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Provided Email address is invalid!', 'easy-real-estate' )
				) );
				die;
			}

			/*
			 * Email Subject
			 */
			$email_subject = esc_html__( 'New message sent by', 'easy-real-estate' ) . ' ' . $from_name . ' ' . esc_html__( 'using home contact form at', 'easy-real-estate' ) . ' ' . get_bloginfo( 'name' );

			/*
			 * Email Body
			 */
			$email_body = esc_html__( "You have received a message from: ", 'easy-real-estate' ) . $from_name . " <br/>";
			if ( ! empty( $phone_number ) ) {
				$email_body .= esc_html__( "Phone Number : ", 'easy-real-estate' ) . $phone_number . " <br/>";
			}
			$email_body .= esc_html__( "Their additional message is as follows.", 'easy-real-estate' ) . " <br/>";
			$email_body .= wpautop( $message ) . " <br/>";

			$add_gdpr_in_email = get_option( 'inspiry_gdpr_in_email', '0' );

			if ( '1' == $add_gdpr_in_email ) {
				$GDPR_agreement = $_POST['gdpr'];
				if ( ! empty( $GDPR_agreement ) ) {
					$email_body .= esc_html__( 'GDPR Agreement: ' ) . wpautop( $GDPR_agreement ) . " <br/>";
				}
			}

			$email_body .= esc_html__( "You can contact ", 'easy-real-estate' ) . $from_name . esc_html__( " via email, ", 'easy-real-estate' ) . $from_email;

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers = array();

			/* Send CC of contact form message if configured */
			if ( isset( $_POST['the_id'] ) ) {
				$cc_email = sanitize_email( get_post_meta( $_POST['the_id'], 'theme_contact_form_email_cc_cfos', true ) );
			} else {
				$cc_email = '';
			}

			$cc_email = explode( ',', $cc_email );
			if ( ! empty( $cc_email ) ) {
				foreach ( $cc_email as $ind_email ) {
					$ind_email = sanitize_email( $ind_email );
					$ind_email = is_email( $ind_email );
					if ( $ind_email ) {
						$headers[] = "Cc: $ind_email";
					}
				}
			}

			/* Send BCC of contact form message if configured */
			if ( isset( $_POST['the_id'] ) ) {
				$bcc_email = sanitize_email( get_post_meta( $_POST['the_id'], 'theme_contact_form_email_bcc_cfos', true ) );
			} else {
				$bcc_email = '';
			}

			$bcc_email = explode( ',', $bcc_email );
			if ( ! empty( $bcc_email ) ) {
				foreach ( $bcc_email as $ind_email ) {
					$ind_email = sanitize_email( $ind_email );
					$ind_email = is_email( $ind_email );
					if ( $ind_email ) {
						$headers[] = "Bcc: $ind_email";
					}
				}
			}

			$headers[] = "Reply-To: $from_name <$from_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers = apply_filters( "inspiry_contact_mail_header", $headers );    // just in case if you want to modify the header in child theme

			if ( wp_mail( $to_email, $email_subject, $email_body, $headers ) ) {
				echo json_encode( array(
					'success' => true,
					'message' => esc_html__( "Message Sent Successfully!", 'easy-real-estate' )
				) );
			} else {
				echo json_encode( array(
						'success' => false,
						'message' => esc_html__( "Server Error: WordPress mail function failed!", 'easy-real-estate' )
					)
				);
			}

		else:
			echo json_encode( array(
					'success' => false,
					'message' => esc_html__( "Invalid Request !", 'easy-real-estate' )
				)
			);
		endif;

		do_action('inspiry_after_contact_form_submit');

		die;

	}

	add_action( 'wp_ajax_nopriv_send_message_cfos', 'ere_send_contact_message_cfos' );
	add_action( 'wp_ajax_send_message_cfos', 'ere_send_contact_message_cfos' );

}


if ( ! function_exists( 'ere_send_message_to_agent' ) ) {
	/**
	 * Handler for agent's contact form
	 */
	function ere_send_message_to_agent() {
		if ( isset( $_POST[ 'email' ] ) ):

			/*
			 *  Verify Nonce
			 */
			$nonce = $_POST[ 'nonce' ];
			if ( ! wp_verify_nonce( $nonce, 'agent_message_nonce' ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Unverified Nonce!', 'easy-real-estate' )
				) );
				die;
			}

			/* Verify Google reCAPTCHA */
			ere_verify_google_recaptcha();

			/* Sanitize and Validate Target email address that is coming from agent form */
			$to_email = sanitize_email( $_POST[ 'target' ] );
			$to_email = is_email( $to_email );
			if ( ! $to_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Target Email address is not properly configured!', 'easy-real-estate' )
				) );
				die;
			}


			/* Sanitize and Validate contact form input data */
			$from_name = sanitize_text_field( $_POST[ 'name' ] );
			$from_phone = sanitize_text_field( $_POST[ 'phone' ] );
			$message = stripslashes( $_POST[ 'message' ] );

			/*
			 * Property title and URL
			 */
			if ( isset( $_POST[ 'property_title' ] ) ) {
				$property_title = sanitize_text_field( $_POST[ 'property_title' ] );
			}
			if ( isset( $_POST[ 'property_permalink' ] ) ) {
				$property_permalink = esc_url( $_POST[ 'property_permalink' ] );
			}

			/*
			 * From email
			 */
			$from_email = sanitize_email( $_POST[ 'email' ] );
			$from_email = is_email( $from_email );
			if ( ! $from_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Provided Email address is invalid!', 'easy-real-estate' )
				) );
				die;
			}


			/*
			 * Email Subject
			 */
			$form_of = ( isset( $_POST['form_of'] ) && 'agency' == $_POST['form_of'] ) ? esc_html__( 'using agency contact form at', 'easy-real-estate' ) : esc_html__( 'using agent contact form at', 'easy-real-estate' );
			$email_subject = esc_html__( 'New message sent by', 'easy-real-estate' ) . ' ' . $from_name . ' ' . $form_of . ' ' . get_bloginfo( 'name' );


			/*
			 * Email body
			 */
			$email_body = esc_html__( "You have received a message from: ", 'easy-real-estate' ) . $from_name . " <br/>";
			if ( ! empty( $property_title ) ) {
				$email_body .= "<br/>" . esc_html__( "Property Title : ", 'easy-real-estate' ) . $property_title . " <br/>";
			}
			if ( ! empty( $property_permalink ) ) {
				$email_body .= esc_html__( "Property URL : ", 'easy-real-estate' ) . '<a href="' . $property_permalink . '">' . $property_permalink . "</a><br/>";
			}
			$email_body .= "<br/>" . esc_html__( "Their additional message is as follows.", 'easy-real-estate' ) . " <br/>";
			$email_body .= wpautop( $message ) . " <br/>";

			$add_gdpr_in_email = get_option( 'inspiry_gdpr_in_email', '0' );

			if ( '1' == $add_gdpr_in_email ) {
				$GDPR_agreement = $_POST['gdpr'];
				if ( ! empty( $GDPR_agreement ) ) {
					$email_body .= esc_html__( 'GDPR Agreement: ' ) . wpautop( $GDPR_agreement ) . " <br/>";
				}
			}

			$email_body .= esc_html__( "You can contact ", 'easy-real-estate' ) . $from_name . esc_html__( " via email, ", 'easy-real-estate' ) . $from_email;
			$email_body .= esc_html__( " or via contact number ", 'easy-real-estate' ) . $from_phone;


			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers = array();
			$headers[] = "Reply-To: $from_name <$from_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers = apply_filters( "inspiry_agent_mail_header", $headers );    // just in case if you want to modify the header in child theme

			/* Send copy of message to admin if configured */
			$theme_send_message_copy = get_option( 'theme_send_message_copy' );
			if ( $theme_send_message_copy == 'true' ) {
				$cc_email = get_option( 'theme_message_copy_email' );
				$cc_email = explode( ',', $cc_email );
				if ( ! empty( $cc_email ) ) {
					foreach ( $cc_email as $ind_email ) {
						$ind_email = sanitize_email( $ind_email );
						$ind_email = is_email( $ind_email );
						if ( $ind_email ) {
							$headers[] = "Cc: $ind_email";
						}
					}
				}
			}

			if ( wp_mail( $to_email, $email_subject, $email_body, $headers ) ) {
				echo json_encode( array(
					'success' => true,
					'message' => esc_html__( "Message Sent Successfully!", 'easy-real-estate' )
				) );
			} else {
				echo json_encode( array(
						'success' => false,
						'message' => esc_html__( "Server Error: WordPress mail function failed!", 'easy-real-estate' )
					)
				);
			}

		else:
			echo json_encode( array(
					'success' => false,
					'message' => esc_html__( "Invalid Request !", 'easy-real-estate' )
				)
			);
		endif;

		do_action('inspiry_after_agent_form_submit');

		die;
	}

	add_action( 'wp_ajax_nopriv_send_message_to_agent', 'ere_send_message_to_agent' );
	add_action( 'wp_ajax_send_message_to_agent', 'ere_send_message_to_agent' );
}


if ( ! function_exists( 'ere_is_reCAPTCHA_configured' ) ) :
	/**
	 * Check if Google reCAPTCHA is properly configured and enabled or not
	 *
	 * @return bool
	 */
	function ere_is_reCAPTCHA_configured() {

		$show_reCAPTCHA = get_option( 'theme_show_reCAPTCHA' );
		if ( $show_reCAPTCHA == 'true' ) {
			$reCAPTCHA_public_key  = get_option( 'theme_recaptcha_public_key' );
			$reCAPTCHA_private_key = get_option( 'theme_recaptcha_private_key' );
			if ( ! empty( $reCAPTCHA_public_key ) && ! empty( $reCAPTCHA_private_key ) ) {
				return true;
			}
		}

		return false;
	}
endif;


if ( ! function_exists( 'ere_recaptcha_callback_generator' ) ) :
	/**
	 * Generates a call back JavaScript function for reCAPTCHA
	 */
	function ere_recaptcha_callback_generator() {
		if ( ere_is_reCAPTCHA_configured() ) {
			$reCAPTCHA_public_key = get_option( 'theme_recaptcha_public_key' );
			?>
			<script type="text/javascript">
				var reCAPTCHAWidgetIDs = [];
				var inspirySiteKey = '<?php echo $reCAPTCHA_public_key; ?>';

				/**
				 * Render Google reCAPTCHA and store their widget IDs in an array
				 */
				var loadInspiryReCAPTCHA = function() {
					jQuery( '.inspiry-google-recaptcha' ).each( function( index, el ) {
						var tempWidgetID = grecaptcha.render( el, {
							'sitekey' : inspirySiteKey
						} );
						reCAPTCHAWidgetIDs.push( tempWidgetID );
					} );
				};

				/**
				 * For Google reCAPTCHA reset
				 */
				var inspiryResetReCAPTCHA = function() {
					if( typeof reCAPTCHAWidgetIDs != 'undefined' ) {
						var arrayLength = reCAPTCHAWidgetIDs.length;
						for( var i = 0; i < arrayLength; i++ ) {
							grecaptcha.reset( reCAPTCHAWidgetIDs[i] );
						}
					}
				};
			</script>
			<?php
		}
	}

	add_action( 'wp_footer', 'ere_recaptcha_callback_generator' );
endif;


if ( ! function_exists( 'ere_verify_google_recaptcha' ) ) {
	/**
	 * This function verifies google recaptcha and echo a json array if fails
	 */
	function ere_verify_google_recaptcha() {

		/**
		 * If Google reCAPTCHA Enabled
		 */
		$show_reCAPTCHA = get_option( 'theme_show_reCAPTCHA' );
		if ( 'true' == $show_reCAPTCHA ) {

			/**
			 * Then, Verify Google reCAPTCHA
			 */
			$reCAPTCHA_public_key  = get_option( 'theme_recaptcha_public_key' );
			$reCAPTCHA_private_key = get_option( 'theme_recaptcha_private_key' );

			if ( ! empty( $reCAPTCHA_public_key ) && ! empty( $reCAPTCHA_private_key ) ) {

				// include reCAPTCHA library - https://github.com/google/recaptcha
				include_once( ERE_PLUGIN_DIR . 'includes/recaptcha/autoload.php' );

				// If the form submission includes the "g-captcha-response" field
				// Create an instance of the service using your secret
				$reCAPTCHA = new \ReCaptcha\ReCaptcha( $reCAPTCHA_private_key, new \ReCaptcha\RequestMethod\CurlPost() );

				// Make the call to verify the response and also pass the user's IP address
				$resp = $reCAPTCHA->verify( $_POST[ 'g-recaptcha-response' ], $_SERVER[ 'REMOTE_ADDR' ] );

				if ( $resp->isSuccess() ) {
					// If the response is a success, Then all is good =)
				} else {
					// reference for error codes - https://developers.google.com/recaptcha/docs/verify
					$error_messages      = array(
						'missing-input-secret'   => 'The secret parameter is missing.',
						'invalid-input-secret'   => 'The secret parameter is invalid or malformed.',
						'missing-input-response' => 'The response parameter is missing.',
						'invalid-input-response' => 'The response parameter is invalid or malformed.',
					);
					$error_codes         = $resp->getErrorCodes();
					$final_error_message = $error_messages[ $error_codes[ 0 ] ];
					echo json_encode( array(
						'success' => false,
						'message' => esc_html__( 'reCAPTCHA Failed:', 'easy-real-estate' ) . ' ' . $final_error_message
					) );
					die;
				}
			}
		}
	}
}


if ( ! function_exists( 'ere_mail_wrapper' ) ) {
	/**
	 * @param $to_email
	 * @param $email_subject
	 * @param $email_body
	 * @param $headers
	 *
	 * @return bool
	 */
	function ere_mail_wrapper( $to_email, $email_subject, $email_body, $headers ) {
		return wp_mail( $to_email, $email_subject, $email_body, $headers );
	}
}