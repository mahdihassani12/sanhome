<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_News_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ere-news-widget-home';
	}

	public function get_title() {
		return esc_html__( 'News Grid', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function _register_controls() {
		$grid_size_array = wp_get_additional_image_sizes();

		$prop_grid_size_array = array();
		foreach ($grid_size_array as $key => $value){
			$str_rpl_key = ucwords( str_replace("-", " " , $key));

			$prop_grid_size_array[$key] =  $str_rpl_key . ' - ' .$value['width'] . 'x' . $value['height'] ;
		}

		unset($prop_grid_size_array['partners-logo']);
		unset($prop_grid_size_array['property-detail-slider-thumb']);
		unset($prop_grid_size_array['post-thumbnail']);
		unset($prop_grid_size_array['agent-image']);
		unset($prop_grid_size_array['property-detail-slider-image']);
//		unset($prop_grid_size_array['gallery-two-column-image']);
		unset($prop_grid_size_array['post-featured-image']);

		if(INSPIRY_DESIGN_VARIATION == 'modern'){
			$default_prop_grid_size = 'modern-property-child-slider';
		}else{
			$default_prop_grid_size = 'gallery-two-column-image';
		}


		$this->start_controls_section(
			'ere_news_section',
			[
				'label' => esc_html__( 'News', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ere_news_grid_thumb_sizes',
			[
				'label' => esc_html__( 'Thumbnail Size', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => $default_prop_grid_size,
				'options' => $prop_grid_size_array
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Number of Posts', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
				'default' => 3,
			]
		);

		// Select controls for Custom Taxonomies related to Property
		$property_taxonomies = get_object_taxonomies( 'post', 'objects' );
		if ( ! empty( $property_taxonomies ) && ! is_wp_error( $property_taxonomies ) ) {
			foreach ( $property_taxonomies as $single_tax ) {
				$options = [];
				$terms = get_terms( $single_tax->name );

				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						$options[ $term->slug ] = $term->name;
					}
				}

				$this->add_control(
					$single_tax->name,
					[
						'label'    => $single_tax->label,
						'type'     => \Elementor\Controls_Manager::SELECT2,
						'multiple' => true,
						'options'  => $options,
					]
				);
			}
		}


		// Sorting Controls
		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'date'       => esc_html__( 'Date', 'realhomes-elementor-addon' ),
					'title'      => esc_html__( 'Title', 'realhomes-elementor-addon' ),
					'menu_order' => esc_html__( 'Menu Order', 'realhomes-elementor-addon' ),
					'rand'       => esc_html__( 'Random', 'realhomes-elementor-addon' ),
				],
				'default' => 'date',
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'asc'  => esc_html__( 'Ascending', 'realhomes-elementor-addon' ),
					'desc' => esc_html__( 'Descending', 'realhomes-elementor-addon' ),
				],
				'default' => 'desc',
			]
		);

		$this->add_control(
			'offset',
			[
				'label'   => esc_html__( 'Offset or Skip From Start', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => '0'
			]
		);

		$this->add_control(
			'excerpt-length',
			[
				'label' => esc_html__( 'Excerpt Length (Words)', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 100,
				'default' => 18,
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'ere_news_labels',
			[
				'label' => esc_html__( 'Labels', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ere_news_in_label',
			[
				'label' => esc_html__( 'In', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'In', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_news_by_label',
			[
				'label' => esc_html__( 'By', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'By', 'realhomes-elementor-addon' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'ere_news_typo_section',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_heading_typography',
				'label'    => esc_html__( 'Heading', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor h3 a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_date_typography',
				'label'    => esc_html__( 'Date', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor .date',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_category_in_typography',
				'label'    => esc_html__( 'In', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor .categories .category_in',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_category_typography',
				'label'    => esc_html__( 'Category', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor .categories a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_excerpt_typography',
				'label'    => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor p',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_by_author_typography',
				'label'    => esc_html__( 'By', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor .by-author',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_author_typography',
				'label'    => esc_html__( 'Author', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor .author-link',
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'ere_news_spacing_size',
			[
				'label' => esc_html__( 'Size', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'ere_news_single_sizes',
			[
				'label' => esc_html__( 'News Width (%)', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '33.3333',
					'unit' => '%',
				],
				'tablet_default' => [
					'size' => '',
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => '',
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor article' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_news_content_padding',
			[
				'label' => esc_html__( 'Content Area Padding', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .rh-wrapper-post-contents_elementor' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_news_spacing_section',
			[
				'label' => esc_html__( 'Spacings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_news_vertical_spacings',
			[
				'label'           => esc_html__( 'News Bottom Space (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__news_elementor article' => 'padding-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_news_date_spacings',
			[
				'label'           => esc_html__( 'Date & Category Bottom Space (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__news_elementor .post_meta_elementor' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_news_title_spacings',
			[
				'label'           => esc_html__( 'Title Bottom Space (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__news_elementor h3.post-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_news_excerpt_spacings',
			[
				'label'           => esc_html__( 'Excerpt Bottom Space (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__news_elementor p' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_news_colors_section',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ere_news_bg_color',
			[
				'label'     => esc_html__( 'News Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh-wrapper-post-contents_elementor' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_date_color',
			[
				'label'     => esc_html__( 'Date', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor .date' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_category_in_color',
			[
				'label'     => esc_html__( 'In', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor .categories .category_in' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_category_color',
			[
				'label'     => esc_html__( 'Category', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor .categories a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_category_hover_color',
			[
				'label'     => esc_html__( 'Category Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor .categories a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_heading_color',
			[
				'label'     => esc_html__( 'Heading', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor h3 a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_news_heading_hover_color',
			[
				'label'     => esc_html__( 'Heading Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor h3 a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_excerpt_color',
			[
				'label'     => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_by_color',
			[
				'label'     => esc_html__( 'By', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor .by-author' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_author_color',
			[
				'label'     => esc_html__( 'Author', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor .author-link' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_gallery_circle_color',
			[
				'label'     => esc_html__( 'Gallery Arrows Circle', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .cls-1' => 'fill: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'ere_news_gallery_arrow_color',
			[
				'label'     => esc_html__( 'Gallery Arrows', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .cls-2' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_news_box_shadow',
			[
				'label' => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rh_section__news_elementor article .rh_news_module_inner',
			]
		);



		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();


        global $news_grid_size;
		$news_grid_size = $settings['ere_news_grid_thumb_sizes'];

		$news_args = array(
			'post_type'           => 'post',
			'posts_per_page'      => $settings[ 'posts_per_page' ],
			'ignore_sticky_posts' => 1,
			'order' => $settings[ 'order' ],
			'orderby' => $settings[ 'orderby' ],
			'offset' => $settings[ 'offset' ],
			'meta_query'          => array(
				'relation' => 'OR',
				array(
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS'
				),
				array(
					'key'     => 'REAL_HOMES_embed_code',
					'compare' => 'EXISTS'
				),
				array(
					'key'     => 'REAL_HOMES_gallery',
					'compare' => 'EXISTS'
				)
			)
		);

		$news_args['tax_query'] = array(
			array(
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => array( 'post-format-quote', 'post-format-link', 'post-format-audio' ),
				'operator' => 'NOT IN'
			)
		);

		// Filter based on taxonomies
		$post_taxonomies = get_object_taxonomies( 'post', 'objects' );
		if ( ! empty( $post_taxonomies ) && ! is_wp_error( $post_taxonomies ) ) {
			foreach ( $post_taxonomies as $single_tax ) {
				$setting_key = $single_tax->name;
				if ( ! empty( $settings[ $setting_key ] ) ) {
					$news_args['tax_query'][] = [
						'taxonomy' => $setting_key,
						'field' => 'slug',
						'terms' => $settings[ $setting_key ],
					];
				}
			}
			if( isset( $news_args['tax_query'] ) && count( $news_args['tax_query'] ) > 1 ) {
				$news_args['tax_query']['relation'] = 'AND';
			}
		}

		$news_query = new WP_Query( $news_args );

		if ( $news_query->have_posts() ) {
			?>
			<section class="rh_wrapper__news_elementor">

					<div class="rh_section__news_elementor">
						<?php
						while ( $news_query->have_posts() ) {

							$news_query->the_post();

							$format = get_post_format( get_the_ID() );

							if ( false === $format ) {
								$format = 'standard';
							}
							?>
							<article <?php post_class(); ?>>

                                <div class="rh_news_module_inner">
								<div class="rh-wrapper-post-media">
									<?php rhea_get_template_part( "assets/partials/post-formats/modern/$format" ); ?>
								</div>

								<div class="rh-wrapper-post-contents_elementor">
									<div class="post_meta_elementor">
										<span class="date"> <?php the_time( get_option( 'date_format' ) ); ?></span>
										<?php
										$get_categories = get_the_category();
										if ( is_array( $get_categories ) && ! empty( $get_categories ) ) {
											?>
											<span class="categories">
                                                <span class="category_in">
												<?php
												        echo esc_html($settings['ere_news_in_label']);
												foreach ( $get_categories as $category ) {
													?>
                                                    </span>
                                                <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"><?php echo esc_attr( $category->name ); ?></a><?php
												}
												?>
											</span>
											<?php
										}
										?>
									</div>

									<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

									<p><?php rhea_framework_excerpt( $settings['excerpt-length'] ); ?></p>

									<span class="by-author"><span class="rhea_by"><?php echo esc_html($settings['ere_news_by_label']); ?></span><span class="author-link"><?php the_author() ?></span></span>

								</div>
                                </div>
							</article>
							<?php
						}

						wp_reset_postdata();
						?>
				</div>
			</section>
                <script type="application/javascript">

                    function EREloadNewsSlider(){
                        jQuery('.listing-slider_elementor').each(function () {
                            jQuery(this).flexslider({
                                animation: "slide",
                                slideshow: false,
                                controlNav: false,
                                // directionNav: false,
                                // customDirectionNav: $(".rh_flexslider__nav_main_gallery .nav-mod"),
                                customDirectionNav: jQuery(this).next('.rh_flexslider__nav_main_gallery').find('.nav-mod'),
                            });
                        });
                    }

                    EREloadNewsSlider();

                    jQuery(window).on('load',function () {
                        EREloadNewsSlider();
                        jQuery(window).trigger('resize');
                    });
                    // jQuery(window).trigger('resize',EREloadNewsSlider);




                </script>
			<?php
		}

	}

}