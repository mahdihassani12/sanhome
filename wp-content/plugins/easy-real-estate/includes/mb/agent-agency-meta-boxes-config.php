<?php
if ( ! function_exists( 'ere_agent_meta_boxes' ) ) :
	/**
	 * Contains agent's meta box declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function ere_agent_meta_boxes( $meta_boxes ) {

		$meta_boxes[] = array(
			'id'         => 'agent-meta-box',
			'title'      => esc_html__( 'Provide Related Information', 'easy-real-estate' ),
			'post_types' => array( 'agent' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields'     => array(
				array(
					'name'    => esc_html__( 'Email Address', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_agent_email",
					'desc'    => esc_html__( 'Provide Agent Email Address. Agent related messages from contact form on property details page, will be sent on this email address.', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'Mobile Number', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_mobile_number",
					'desc'    => esc_html__( 'Provide Agent mobile number', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'WhatsApp Number', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_whatsapp_number",
					'desc'    => esc_html__( 'Provide Agent whatsapp number', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'Office Number', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_office_number",
					'desc'    => esc_html__( 'Provide Agent office number', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'Fax Number', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_fax_number",
					'desc'    => esc_html__( 'Provide Agent fax number', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'Facebook URL', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_facebook_url",
					'desc'    => esc_html__( 'Provide Agent Facebook URL', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'Twitter URL', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_twitter_url",
					'desc'    => esc_html__( 'Provide Agent Twitter URL', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'LinkedIn URL', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_linked_in_url",
					'desc'    => esc_html__( 'Provide Agent LinkedIn URL', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'Instagram URL', 'easy-real-estate' ),
					'id'      => 'inspiry_instagram_url',
					'desc'    => esc_html__( 'Provide Agent Instagram URL', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'type' => 'divider',
					'id'   => 'agent_agency_divider',
				),
				array(
					'name'    => esc_html__( 'Agency', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_agency",
					'desc'    => esc_html__( 'Select Related Agency.', 'easy-real-estate' ),
					'type'    => 'select',
					'options' => ere_get_agency_array(),
					'columns' => 6,
				),
			),
		);

		return $meta_boxes;

	}

	add_filter( 'rwmb_meta_boxes', 'ere_agent_meta_boxes' );

endif;


if ( ! function_exists( 'ere_agency_meta_boxes' ) ) :
	/**
	 * Contains agency's meta box declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function ere_agency_meta_boxes( $meta_boxes ) {

		$meta_boxes[] = array(
			'id'         => 'agency-meta-box',
			'title'      => esc_html__( 'Provide Related Information', 'easy-real-estate' ),
			'post_types' => array( 'agency' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields'     => array(
				array(
					'name'    => esc_html__( 'Email Address', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_agency_email",
					'desc'    => esc_html__( 'Provide Agency Email Address. Agency related messages from contact form on property details page, will be sent on this email address.', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'Mobile Number', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_mobile_number",
					'desc'    => esc_html__( 'Provide Agency mobile number', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'WhatsApp Number', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_whatsapp_number",
					'desc'    => esc_html__( 'Provide Agency whatsapp number', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'Office Number', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_office_number",
					'desc'    => esc_html__( 'Provide Agency office number', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'Fax Number', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_fax_number",
					'desc'    => esc_html__( 'Provide Agency fax number', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'Facebook URL', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_facebook_url",
					'desc'    => esc_html__( 'Provide Agency Facebook URL', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'Twitter URL', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_twitter_url",
					'desc'    => esc_html__( 'Provide Agency Twitter URL', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'LinkedIn URL', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_linked_in_url",
					'desc'    => esc_html__( 'Provide Agency LinkedIn URL', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__( 'Instagram URL', 'easy-real-estate' ),
					'id'      => 'inspiry_instagram_url',
					'desc'    => esc_html__( 'Provide Agency Instagram URL', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),
			),
		);

		return $meta_boxes;

	}

	add_filter( 'rwmb_meta_boxes', 'ere_agency_meta_boxes' );

endif;