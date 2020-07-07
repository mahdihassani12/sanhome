<?php
if ( ! function_exists( 'ere_property_meta_boxes' ) ) :
	/**
	 * Contains property related meta box declarations
	 *
	 * @param array $meta_boxes
	 *
	 * @return array
	 */


	function ere_property_meta_boxes( $meta_boxes ) {

		/* property gallery slider options */
		$REAL_HOMES_gallery_slider = array(
			'thumb-on-right'  => esc_html__( 'Gallery with thumbnails on right', 'easy-real-estate' ),
			'thumb-on-bottom' => esc_html__( 'Gallery with thumbnails on bottom', 'easy-real-estate' ),
		);
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$REAL_HOMES_gallery_slider['thumb-on-right']  = esc_html__( 'Default Gallery', 'easy-real-estate' );
			$REAL_HOMES_gallery_slider['thumb-on-bottom'] = esc_html__( 'Gallery with thumbnails', 'easy-real-estate' );
		}


		/* Property detail page meta boxes */
		$meta_boxes[] = array(
			'id'         => 'property-meta-box',
			'title'      => esc_html__( 'Property', 'easy-real-estate' ),
			'post_types' => array( 'property' ),
			'tabs'       => array(
				'details'            => array(
					'label' => esc_html__( 'Basic Information', 'easy-real-estate' ),
					'icon'  => 'dashicons-admin-home',
				),
				'map-location'       => array(
					'label' => esc_html__( 'Location on Map', 'easy-real-estate' ),
					'icon'  => 'dashicons-location',
				),
				'gallery'            => array(
					'label' => esc_html__( 'Gallery Images', 'easy-real-estate' ),
					'icon'  => 'dashicons-format-gallery',
				),
				'floor-plans'        => array(
					'label' => esc_html__( 'Floor Plans', 'easy-real-estate' ),
					'icon'  => 'dashicons-layout',
				),
				'video'              => array(
					'label' => esc_html__( 'Property Video', 'easy-real-estate' ),
					'icon'  => 'dashicons-format-video',
				),
				'agent'              => array(
					'label' => esc_html__( 'Agent Information', 'easy-real-estate' ),
					'icon'  => 'dashicons-businessman',
				),
				'energy-performance' => array(
					'label' => esc_html__( 'Energy Performance', 'easy-real-estate' ),
					'icon'  => 'dashicons-performance',
				),
				'misc'               => array(
					'label' => esc_html__( 'Misc', 'easy-real-estate' ),
					'icon'  => 'dashicons-lightbulb',
				),
				'home-slider'        => array(
					'label' => esc_html__( 'Homepage Slider', 'easy-real-estate' ),
					'icon'  => 'dashicons-images-alt',
				),
				'banner'             => array(
					'label' => esc_html__( 'Top Banner', 'easy-real-estate' ),
					'icon'  => 'dashicons-format-image',
				),
			),
			'tab_style'  => 'left',
			'fields'     => array(

				// Details.
				array(
					'id'      => "REAL_HOMES_property_price",
					'name'    => esc_html__( 'Sale or Rent Price ( Only digits )', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example Value: 435000', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'details',
				),
				array(
					'id'      => "REAL_HOMES_property_price_postfix",
					'name'    => esc_html__( 'Price Postfix', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example Value: Per Month', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'details',
				),
				array(
					'id'      => "REAL_HOMES_property_size",
					'name'    => esc_html__( 'Area Size ( Only digits )', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example Value: 2500', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'details',
				),
				array(
					'id'      => "REAL_HOMES_property_size_postfix",
					'name'    => esc_html__( 'Area Size Postfix', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example Value: sq ft', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'details',
				),
				array(
					'id'      => "REAL_HOMES_property_lot_size",
					'name'    => esc_html__( 'Lot Size ( Only digits )', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example Value: 3000', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'details',
				),
				array(
					'id'      => "REAL_HOMES_property_lot_size_postfix",
					'name'    => esc_html__( 'Lot Size Postfix', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example Value: sq ft', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'details',
				),
				array(
					'id'      => "REAL_HOMES_property_bedrooms",
					'name'    => esc_html__( 'Bedrooms', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example Value: 4', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'details',
				),
				array(
					'id'      => "REAL_HOMES_property_bathrooms",
					'name'    => esc_html__( 'Bathrooms', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example Value: 2', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'details',
				),
				array(
					'id'      => "REAL_HOMES_property_garage",
					'name'    => esc_html__( 'Garages', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example Value: 1', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'details',
				),
				array(
					'id'         => "REAL_HOMES_property_id",
					'name'       => esc_html__( 'Property ID', 'easy-real-estate' ),
					'desc'       => esc_html__( 'It will help you search a property directly.', 'easy-real-estate' ),
					'type'       => 'text',
					'std'        => ( 'true' === get_option( 'inspiry_auto_property_id_check' ) ) ? get_option( 'inspiry_auto_property_id_pattern' ) : '',
					'columns'    => 6,
					'tab'        => 'details',
					'attributes' => array(
						'readonly' => ( 'true' === get_option( 'inspiry_auto_property_id_check' ) ) ? true : false,
					),
				),
				array(
					'id'      => "REAL_HOMES_property_year_built",
					'name'    => esc_html__( 'Year Built', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example Value: 2017', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'details',
				),
				array(
					'name'    => esc_html__( 'Mark this property as featured ?', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_featured",
					'type'    => 'radio',
					'std'     => '0',
					'options' => array(
						'1' => esc_html__( 'Yes', 'easy-real-estate' ),
						'0' => esc_html__( 'No', 'easy-real-estate' ),
					),
					'columns' => 6,
					'tab'     => 'details',
				),

				// Energy Performance
				array(
					'name'    => esc_html__( 'Energy Class', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_energy_class",
					'type'    => 'select',
					'std'     => 'none',
					'options' => array(
						'none' => esc_html__( 'None', 'easy-real-estate' ),
						'A+'   => 'A+',
						'A'    => 'A',
						'B'    => 'B',
						'C'    => 'C',
						'D'    => 'D',
						'E'    => 'E',
						'F'    => 'F',
						'G'    => 'G'
					),
					'columns' => 6,
					'tab'     => 'energy-performance',
				),
				array(
					'id'      => "REAL_HOMES_energy_performance",
					'name'    => esc_html__( 'Energy Performance', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example Value: 100 kWh/m²a', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'energy-performance',
				),
				array(
					'id'      => "REAL_HOMES_epc_current_rating",
					'name'    => sprintf( esc_html__( '%s Current Rating', 'easy-real-estate' ), '<abbr title="Energy Performance Certificate">EPC</abbr>' ),
					'desc'    => esc_html__( 'Example Value: 83', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'energy-performance',
				),
				array(
					'id'      => "REAL_HOMES_epc_potential_rating",
					'name'    => sprintf( esc_html__( '%s Potential Rating', 'easy-real-estate' ), '<abbr title="Energy Performance Certificate">EPC</abbr>' ),
					'desc'    => esc_html__( 'Example Value: 94', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'energy-performance',
				),

				// Location on Map
				array(
					'id'            => "REAL_HOMES_property_location",
					'name'          => esc_html__( 'Property Location on Map', 'easy-real-estate' ),
					'desc'          => esc_html__( 'Drag the map marker to point property location. Address field given above can be used to search location.', 'easy-real-estate' ),
					'type'          => ere_metabox_map_type(),
					'api_key'       => ere_get_google_maps_api_key(),
					'std'           => get_option( 'theme_submit_default_location', '25.7308309,-80.44414899999998' ),
					// 'latitude,longitude[,zoom]' (zoom is optional)
					'style'         => 'width: 95%; height: 400px',
					'address_field' => "REAL_HOMES_property_address",
					'columns'       => 12,
					'tab'           => 'map-location',
				),
				array(
					'id'      => "REAL_HOMES_property_address",
					'name'    => esc_html__( 'Property Address', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Leaving it empty will hide the map on property detail page.', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => get_option( 'theme_submit_default_address' ),
					'columns' => 12,
					'tab'     => 'map-location',
				),
				array(
					'name'    => esc_html__( 'Hide map on property detail page ?', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_property_map",
					'type'    => 'radio',
					'std'     => '0',
					'options' => array(
						'1' => esc_html__( 'Yes', 'easy-real-estate' ),
						'0' => esc_html__( 'No', 'easy-real-estate' ),
					),
					'columns' => 12,
					'tab'     => 'map-location',
				),

				// Gallery.
				array(
					'name'    => esc_html__( 'Gallery Type You Want to Use', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_gallery_slider_type",
					'type'    => 'radio',
					'std'     => 'thumb-on-right',
					'options' => $REAL_HOMES_gallery_slider,
					'columns' => 12,
					'tab'     => 'gallery',
				),
				array(
					'name'             => esc_html__( 'Property Gallery Images', 'easy-real-estate' ),
					'id'               => "REAL_HOMES_property_images",
					'desc'             => ere_property_gallery_meta_desc(),
					'type'             => 'image_advanced',
					'max_file_uploads' => 48,
					'columns'          => 12,
					'tab'              => 'gallery',
				),

				// Floor Plans.
				array(
					'id'      => 'inspiry_floor_plans',
					'type'    => 'group',
					'columns' => 12,
					'clone'   => true,
					'tab'     => 'floor-plans',
					'fields'  => array(
						array(
							'name' => esc_html__( 'Floor Name', 'easy-real-estate' ),
							'id'   => 'inspiry_floor_plan_name',
							'desc' => esc_html__( 'Example: Ground Floor', 'easy-real-estate' ),
							'type' => 'text',
						),
						array(
							'name'    => esc_html__( 'Floor Price ( Only digits )', 'easy-real-estate' ),
							'id'      => 'inspiry_floor_plan_price',
							'desc'    => esc_html__( 'Example: 4000', 'easy-real-estate' ),
							'type'    => 'text',
							'columns' => 6,
						),
						array(
							'name'    => esc_html__( 'Price Postfix', 'easy-real-estate' ),
							'id'      => 'inspiry_floor_plan_price_postfix',
							'desc'    => esc_html__( 'Example: Per Month', 'easy-real-estate' ),
							'type'    => 'text',
							'columns' => 6,
						),
						array(
							'name'    => esc_html__( 'Floor Size ( Only digits )', 'easy-real-estate' ),
							'id'      => 'inspiry_floor_plan_size',
							'desc'    => esc_html__( 'Example: 2500', 'easy-real-estate' ),
							'type'    => 'text',
							'columns' => 6,
						),
						array(
							'name'    => esc_html__( 'Size Postfix', 'easy-real-estate' ),
							'id'      => 'inspiry_floor_plan_size_postfix',
							'desc'    => esc_html__( 'Example: sq ft', 'easy-real-estate' ),
							'type'    => 'text',
							'columns' => 6,
						),
						array(
							'name'    => esc_html__( 'Bedrooms', 'easy-real-estate' ),
							'id'      => 'inspiry_floor_plan_bedrooms',
							'desc'    => esc_html__( 'Example: 4', 'easy-real-estate' ),
							'type'    => 'text',
							'columns' => 6,
						),
						array(
							'name'    => esc_html__( 'Bathrooms', 'easy-real-estate' ),
							'id'      => 'inspiry_floor_plan_bathrooms',
							'desc'    => esc_html__( 'Example: 2', 'easy-real-estate' ),
							'type'    => 'text',
							'columns' => 6,
						),
						array(
							'name' => esc_html__( 'Description', 'easy-real-estate' ),
							'id'   => 'inspiry_floor_plan_descr',
							'type' => 'textarea',
						),
						array(
							'name'             => esc_html__( 'Floor Plan Image', 'easy-real-estate' ),
							'id'               => 'inspiry_floor_plan_image',
							'desc'             => esc_html__( 'The recommended minimum width is 770px and height is flexible.', 'easy-real-estate' ),
							'type'             => 'file_input',
							'max_file_uploads' => 1,
						),
					),
				),

				// Property Video.


				array(
					'name'    => esc_html__( 'Add Multiple Videos', 'easy-real-estate' ),
					'id'      => 'inspiry_video_group',
					'type'    => 'group',
					'columns' => 12,
					'clone'   => true,
					'tab'     => 'video',
					'desc'    => esc_html__( 'Provide an image of minimum width 818px and minimum height 417px. Bigger size images will be cropped automatically. Property featured image will be shown if no image is selected.', 'easy-real-estate' ),

					'fields' => array(

						array(
							'name'             => esc_html__( 'Image', 'easy-real-estate' ),
							'id'               => 'inspiry_video_group_image',
							'type'             => 'image_advanced',
							'columns'          => 4,
							'max_file_uploads' => 1,
						),

						array(
							'name'    => esc_html__( 'Title', 'easy-real-estate' ),
							'id'      => 'inspiry_video_group_title',
							'desc'    => esc_html__( 'Title of video', 'easy-real-estate' ),
							'type'    => 'text',
							'columns' => 4,
						),
						array(
							'name'    => esc_html__( 'URL', 'easy-real-estate' ),
							'id'      => 'inspiry_video_group_url',
							'desc'    => esc_html__( 'Provide virtual tour video URL. YouTube, Vimeo, SWF File and MOV File are supported', 'easy-real-estate' ),
							'type'    => 'text',
							'columns' => 4,
						),

					),
				),

				// Virtual Tour.
				array(
					'type'    => 'divider',
					'columns' => 12,
					'id'      => 'virtual_tour_divider',
					'tab'     => 'video',
				),
				array(
					'name'    => esc_html__( '360 Virtual Tour', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_360_virtual_tour",
					'desc'    => wp_kses(
						__( 'Provide iframe embed code or <a href="https://wordpress.org/plugins/ipanorama-360-virtual-tour-builder-lite/" target="_blank">iPanorama</a> shortcode for the 360 virtual tour. For more details please consult <a href="https://realhomes.io/documentation/add-property/#add-video-tour-and-virtual-tour" target="_blank">Add Property</a> in documentation.', 'easy-real-estate' ),
						array(
							'a' => array(
								'href'   => array(),
								'target' => array(),
							),
						)
					),
					'sanitize_callback' => 'none',
					'type'    => 'textarea',
					'columns' => 12,
					'tab'     => 'video',
				),

				array(
					'type' => 'divider',
					'tab'  => 'video',
					'id'   => "REAL_HOMES_tour_video_url_divider",
				),

				array(
					'id'      => "REAL_HOMES_tour_video_url",
					'name'    => sprintf( __( 'Virtual Tour Video URL %s * %s', 'easy-real-estate' ), '<span>', '</span>' ),
					'desc'    => sprintf( __( 'Provide virtual tour video URL. YouTube, Vimeo, SWF File and MOV File are supported. %1$s %2$s *This field is deprecated in favour of %4$s Add Multiple Videos %5$s field above , So stop using it %3$s', 'easy-real-estate' ), '<br>', '<span>', '</span>', '<strong>', '</strong>' ),
					'type'    => 'text',
					'columns' => 12,
					'tab'     => 'video',
				),
				array(
					'name'             => sprintf( __( 'Virtual Tour Video Image %s * %s', 'easy-real-estate' ), '<span>', '</span>' ),
					'desc'             => sprintf( __( 'Provide an image of minimum width 818px and minimum height 417px. Bigger size images will be cropped automatically. Property featured image will be shown if no image is selected.
								%1$s %2$s *This field is deprecated in favour of %4$s Add Multiple Videos %5$s field above , So stop using it %3$s',
						'easy-real-estate' ), '<br>', '<span>', '</span>', '<strong>', '</strong>' ),
					'id'               => "REAL_HOMES_tour_video_image",
					'type'             => 'image_advanced',
					'max_file_uploads' => 1,
					'columns'          => 12,
					'tab'              => 'video',
				),


				// Agents.
				array(
					'name'    => esc_html__( 'What to display in agent information box ?', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_agent_display_option",
					'type'    => 'radio',
					'std'     => 'none',
					'options' => array(
						'my_profile_info' => esc_html__( 'Author information.', 'easy-real-estate' ),
						'agent_info'      => esc_html__( 'Agent Information. ( Select the agent below )', 'easy-real-estate' ),
						'none'            => esc_html__( 'None. ( Hide information box )', 'easy-real-estate' ),
					),
					'columns' => 12,
					'tab'     => 'agent',
				),
				array(
					'name'     => esc_html__( 'Agent', 'easy-real-estate' ),
					'id'       => "REAL_HOMES_agents",
					'type'     => 'select',
					'options'  => ere_get_agents_array(),
					'multiple' => true,
					'columns'  => 12,
					'tab'      => 'agent',
				),

				// Misc.
				array(
					'id'      => "REAL_HOMES_sticky",
					'type'    => 'checkbox',
					'name'    => esc_html__( 'Make this property sticky for home and listings pages', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Yes', 'easy-real-estate' ),
					'std'     => 0,
					'columns' => 12,
					'tab'     => 'misc',
				),
				// Property Label Separator.
				array(
					'type'    => 'divider',
					'columns' => 12,
					'id'      => 'property_label_divider',
					'tab'     => 'misc',
				),
				array(
					'name'    => esc_html__( 'Property Label Text', 'easy-real-estate' ),
					'id'      => 'inspiry_property_label',
					'desc'    => esc_html__( 'You can add a property label to display on property thumbnails. Example Value: Hot Deal', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
					'tab'     => 'misc',
				),
				array(
					'name'    => esc_html__( 'Label Background Color', 'easy-real-estate' ),
					'id'      => 'inspiry_property_label_color',
					'desc'    => esc_html__( 'Set a label background color. Otherwise label text will be displayed with transparent background.', 'easy-real-estate' ),
					'type'    => 'color',
					'columns' => 6,
					'tab'     => 'misc',
				),
				// Property Attachments Separator.
				array(
					'type'    => 'divider',
					'columns' => 12,
					'id'      => 'property_attachments_divider',
					'tab'     => 'misc',
				),
				array(
					'id'        => "REAL_HOMES_attachments",
					'name'      => esc_html__( 'Attachments', 'easy-real-estate' ),
					'desc'      => esc_html__( 'You can attach PDF files, Map images OR other documents to provide further details related to property.', 'easy-real-estate' ),
					'type'      => 'file_advanced',
					'mime_type' => '',
					'columns'   => 12,
					'tab'       => 'misc',
				),
				// Property Owner Separator.
				array(
					'type'    => 'divider',
					'columns' => 12,
					'id'      => 'property_owner_divider',
					'tab'     => 'misc',
				),
				array(
					'name'    => esc_html__( 'Property Owner Name', 'easy-real-estate' ),
					'id'      => 'inspiry_property_owner_name',
					'type'    => 'text',
					'columns' => 6,
					'tab'     => 'misc',
				),
				array(
					'name'    => esc_html__( 'Owner Contact', 'easy-real-estate' ),
					'id'      => 'inspiry_property_owner_contact',
					'type'    => 'text',
					'columns' => 6,
					'tab'     => 'misc',
				),
				array(
					'id'      => 'inspiry_property_owner_address',
					'name'    => esc_html__( 'Owner Address', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 12,
					'tab'     => 'misc',
				),
				array(
					'id'      => "REAL_HOMES_property_private_note",
					'name'    => esc_html__( 'Private Note', 'easy-real-estate' ),
					'desc'    => esc_html__( 'In this textarea, You can write your private note about this property. This field will not be displayed anywhere else.', 'easy-real-estate' ),
					'type'    => 'textarea',
					'std'     => '',
					'columns' => 12,
					'tab'     => 'misc',
				),
				array(
					'id'      => 'inspiry_message_to_reviewer',
					'name'    => esc_html__( 'Message to Reviewer', 'easy-real-estate' ),
					'type'    => 'textarea',
					'columns' => 12,
					'tab'     => 'misc',
				),

				// Homepage Slider.
				array(
					'name'    => esc_html__( 'Do you want to add this property in Homepage Slider ?', 'easy-real-estate' ),
					'desc'    => esc_html__( 'If Yes, Then you need to provide a slider image below.', 'easy-real-estate' ),
					'id'      => "REAL_HOMES_add_in_slider",
					'type'    => 'radio',
					'std'     => 'no',
					'options' => array(
						'yes' => esc_html__( 'Yes ', 'easy-real-estate' ),
						'no'  => esc_html__( 'No', 'easy-real-estate' ),
					),
					'columns' => 12,
					'tab'     => 'home-slider',
				),
				array(
					'name'             => esc_html__( 'Slider Image', 'easy-real-estate' ),
					'id'               => "REAL_HOMES_slider_image",
					'desc'             => esc_html__( 'The recommended image size is 2000px by 700px. You can use bigger or smaller image but try to keep the same height to width ratio and use the exactly same size images for all properties that will be added in slider.', 'easy-real-estate' ),
					'type'             => 'image_advanced',
					'max_file_uploads' => 1,
					'columns'          => 12,
					'tab'              => 'home-slider',
				),

				// Top Banner.
				array(
					'name'             => esc_html__( 'Top Banner Image', 'easy-real-estate' ),
					'id'               => "REAL_HOMES_page_banner_image",
					'desc'             => esc_html__( 'Upload the banner image, If you want to change it for this property. Otherwise default banner image uploaded from theme options will be displayed. Image should have minimum width of 2000px and minimum height of 230px.', 'easy-real-estate' ),
					'type'             => 'image_advanced',
					'max_file_uploads' => 1,
					'columns'          => 12,
					'tab'              => 'banner',
				),

			),
		);

		return $meta_boxes;

	}

	add_filter( 'rwmb_meta_boxes', 'ere_property_meta_boxes' );

endif;


if ( ! function_exists( 'ere_property_type_meta_boxes' ) ) :
	/**
	 * Property type meta boxes declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function ere_property_type_meta_boxes( $meta_boxes ) {

		$meta_boxes[] = array(
			'title'      => esc_html__( 'Custom Property Type Map Icon', 'easy-real-estate' ),
			'taxonomies' => 'property-type',
			'fields'     => array(
				array(
					'name'             => esc_html__( 'Icon Image', 'easy-real-estate' ),
					'id'               => 'inspiry_property_type_icon',
					'type'             => 'image_advanced',
					'mime_type'        => 'image/png',
					'max_file_uploads' => 1,
				),
				array(
					'name'             => esc_html__( 'Retina Icon Image', 'easy-real-estate' ),
					'id'               => 'inspiry_property_type_icon_retina',
					'type'             => 'image_advanced',
					'mime_type'        => 'image/png',
					'max_file_uploads' => 1,
				),
			),
		);

		return $meta_boxes;
	}

	add_filter( 'rwmb_meta_boxes', 'ere_property_type_meta_boxes' );

endif;


if ( ! function_exists( 'ere_property_feature_meta_boxes' ) ) :
	/**
	 * Property feature meta boxes declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function ere_property_feature_meta_boxes( $meta_boxes ) {

		$meta_boxes[] = array(
			'title'      => 'Property Feature Icon',
			'taxonomies' => 'property-feature',
			'fields'     => array(
				array(
					'name'             => esc_html__( 'Icon Image', 'easy-real-estate' ),
					'desc'             => esc_html__( 'Recommended image size for icon is 64px by 64px.', 'easy-real-estate' ),
					'id'               => 'inspiry_property_feature_icon',
					'type'             => 'image_advanced',
					'mime_type'        => 'image/png',
					'max_file_uploads' => 1,
				),
			),
		);

		return $meta_boxes;
	}

	add_filter( 'rwmb_meta_boxes', 'ere_property_feature_meta_boxes' );

endif;

