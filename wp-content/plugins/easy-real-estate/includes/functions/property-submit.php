<?php
/**
 * Property Submit Functions
 */

if ( ! function_exists( 'ere_submit_notice' ) ) {
	/**
	 * Property Submit Notice Email
	 *
	 * @param $property_id
	 */
	function ere_submit_notice( $property_id ) {

		/* get and sanitize target email */
		$target_email = sanitize_email( get_option( 'theme_submit_notice_email' ) );
		$target_email = is_email( $target_email );
		if ( $target_email ) {

			/* current user ( submitter ) information */
			$current_user = wp_get_current_user();
			$submitter_name = $current_user->display_name;
			$submitter_email = $current_user->user_email;
			$site_name = get_bloginfo( 'name' );

			/* email subject */
			$email_subject = sprintf( __( 'A new property is submitted by %s at %s', 'easy-real-estate' ), $submitter_name, $site_name );

			/* start of email body */
			$email_body = $email_subject . "<br/><br/>";

			/* preview link */
			$preview_link = set_url_scheme( get_permalink( $property_id ) );
			$preview_link = esc_url( apply_filters( 'preview_post_link', add_query_arg( 'preview', 'true', $preview_link ) ) );
			if ( ! empty( $preview_link ) ) {
				$email_body .= esc_html__( 'You can preview it here : ', 'easy-real-estate' );
				$email_body .= '<a target="_blank" href="' . $preview_link . '">' . sanitize_text_field( $_POST[ 'inspiry_property_title' ] ) . '</a>';
				$email_body .= "<br/><br/>";
			}

			/* message to reviewer */
			if ( isset( $_POST[ 'message_to_reviewer' ] ) ) {
				$message_to_reviewer = stripslashes( $_POST[ 'message_to_reviewer' ] );
				if ( ! empty( $message_to_reviewer ) ) {
					$email_body .= sprintf( __( 'Message to the Reviewer : %s', 'easy-real-estate' ), $message_to_reviewer ) . "<br/><br/>";
				}
			}

			/* end of message body */
			$email_body .= sprintf( __( 'You can contact the submitter "%s" via email %s', 'easy-real-estate' ), $submitter_name, $submitter_email ) . "<br/>";

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers = array();
			$headers[] = "Reply-To: $submitter_name <$submitter_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers = apply_filters( "inspiry_property_submit_mail_header", $headers );    // just in case if you want to modify the header in child theme

			// Send Email
			if ( ! wp_mail( $target_email, $email_subject, $email_body, $headers ) ) {
				inspiry_log( 'Failed: To send property submit notice' );
			}

		}

	}

	add_action( 'inspiry_after_property_submit', 'ere_submit_notice' );
}

