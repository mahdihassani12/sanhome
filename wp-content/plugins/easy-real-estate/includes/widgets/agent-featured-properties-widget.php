<?php
/**
 * Widget: Agent Featured Properties Widget
 *
 */

if ( ! class_exists( 'Agent_Featured_Properties_Widget' ) ) {

	/**
	 * Agent_Featured_Properties_Widget.
	 *
	 * Widget of agent featured properties.
	 */
	class Agent_Featured_Properties_Widget extends WP_Widget {

		function __construct() {
			$widget_ops = array(
				'classname'                   => 'Agent_Featured_Properties_Widget',
				'description'                 => esc_html__( 'Important: This widget is only for the Agent Sidebar.', 'easy-real-estate' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct( 'Agent_Featured_Properties_Widget', esc_html__( 'RealHomes - Agent Featured Properties', 'easy-real-estate' ), $widget_ops );
		}

		function widget( $args, $instance ) {

			extract( $args );

			// Title
			if ( isset( $instance['title'] ) ) {
				$title = apply_filters( 'widget_title', $instance['title'] );
			}

			if ( isset( $instance['view_property'] ) ) {
				$view_property = apply_filters( 'view_property', $instance['view_property'] );
			}

			if ( empty( $title ) ) {
				$title = false;
			}

			// Count
			$count = 1;
			if ( isset( $instance['count'] ) ) {
				$count   = intval( $instance['count'] );
			}

			$agent_args = array(
				'post_type'      => 'property',
				'posts_per_page' => $count,
				'meta_query'     => array(
					array(
						'key'     => 'REAL_HOMES_featured',     // Show only Featured Properties
						'value'   => 1,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
				),
			);

			// If author user author id otherwise if agent use agent id
			if ( is_author() ) {
				global $wp_query;
				$current_author       = $wp_query->get_queried_object();
				$agent_args['author'] = $current_author->ID;
			} elseif ( is_singular( 'agent' ) ) {
				$agent_id                             = get_the_ID();
				$agent_args['meta_query'][]           = array(
					'key'     => 'REAL_HOMES_agents',
					'value'   => $agent_id,
					'compare' => '=',
				);
				$agent_args['meta_query']['relation'] = 'AND';
			}

			// Order by
			$sort_by = 'recent';
			if ( isset( $instance['sort_by'] ) ) {
				$sort_by = $instance['sort_by'];
			}

			if ( $sort_by == 'random' ) :
				$agent_args['orderby'] = 'rand';
			else :
				$agent_args['orderby'] = 'date';
			endif;

			$agent_query = new WP_Query( $agent_args );

			if ( is_author() || is_singular( 'agent' ) ) {  // it only works on author page or agent single page

				echo $before_widget;

				if ( $title ) :
					echo $before_title;
					echo $title;
					echo $after_title;
				endif;

				if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {

					if ( $agent_query->have_posts() ) :
						?>
                        <ul class="featured-properties">
							<?php
							while ( $agent_query->have_posts() ) :
								$agent_query->the_post();
								?>
                                <li>
                                    <figure>
                                        <a href="<?php the_permalink(); ?>">
											<?php
											if ( has_post_thumbnail() ) {
												the_post_thumbnail( 'grid-view-image' );
											} else {
												inspiry_image_placeholder( 'grid-view-image' );
											}
											?>
                                        </a>
                                    </figure>

                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <p><?php ere_framework_excerpt( 7 ); ?>
	                                    <?php if ( isset( $view_property ) && !empty($view_property) ) { ?>
                                            <a href="<?php the_permalink(); ?>"><?php echo esc_html( $view_property ); ?></a>
		                                    <?php
	                                    } else {
		                                    ?>
                                            <a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'easy-real-estate' ); ?></a>
		                                    <?php
	                                    }
	                                    ?>
                                    </p>
									<?php
									$price = ere_get_property_price();
									if ( $price ) {
										echo '<span class="price">' . $price . '</span>';
									}
									?>
                                </li>
							<?php
							endwhile;
							?>
                        </ul>
						<?php
						wp_reset_query();
					else :
						?>
                        <ul class="featured-properties">
							<?php
							echo '<li>';
							_e( 'No Featured Property Found For This Agent', 'easy-real-estate' );
							echo '.</li>';
							?>
                        </ul>
					<?php
					endif;

				} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
					if ( $agent_query->have_posts() ) :
						while ( $agent_query->have_posts() ) :
							$agent_query->the_post();

							global $post;
							$property_size      = get_post_meta( $post->ID, 'REAL_HOMES_property_size', true );
							$size_postfix       = get_post_meta( $post->ID, 'REAL_HOMES_property_size_postfix', true );
							$property_bedrooms  = get_post_meta( $post->ID, 'REAL_HOMES_property_bedrooms', true );
							$property_bathrooms = get_post_meta( $post->ID, 'REAL_HOMES_property_bathrooms', true );
							$property_address   = get_post_meta( $post->ID, 'REAL_HOMES_property_address', true );
							$is_featured        = get_post_meta( $post->ID, 'REAL_HOMES_featured', true );

							?>

                            <article <?php post_class( 'rh_prop_card rh_prop_card--block' ); ?>>

                                <div class="rh_prop_card__wrap">

									<?php if ( $is_featured ) : ?>
                                        <div class="rh_label rh_label__featured_widget">
                                            <div class="rh_label__wrap">
												<?php esc_html_e( 'Featured', 'easy-real-estate' ); ?>
                                                <span></span>
                                            </div>
                                        </div>
                                        <!-- /.rh_label -->
									<?php endif; ?>

                                    <figure class="rh_prop_card__thumbnail">
                                        <a href="<?php the_permalink(); ?>">
											<?php
											if ( has_post_thumbnail( $post->ID ) ) {
												the_post_thumbnail( 'modern-property-child-slider' );
											} else {
												inspiry_image_placeholder( 'modern-property-child-slider' );
											}
											?>
                                        </a>


                                        <div class="rh_overlay"></div>
                                        <div class="rh_overlay__contents rh_overlay__fadeIn-bottom">
		                                    <?php if ( isset( $view_property ) && !empty($view_property) ) { ?>
                                                <a href="<?php the_permalink(); ?>"><?php echo esc_html( $view_property ); ?></a>
			                                    <?php
		                                    } else {
			                                    ?>
                                                <a href="<?php the_permalink(); ?>"><?php esc_html_e( 'View Property', 'easy-real-estate' ); ?></a>
			                                    <?php
		                                    }
		                                    ?>
                                        </div>
                                        <!-- /.rh_overlay__contents -->

                                        <div class="rh_prop_card__btns">
	                                        <?php
	                                        // Display add to favorite button
	                                        if ( function_exists( 'inspiry_favorite_button' ) ) {
		                                        inspiry_favorite_button();
	                                        }

											$compare_properties_module = get_option( 'theme_compare_properties_module' );
											$inspiry_compare_page      = get_option( 'inspiry_compare_page' );
											if ( ( 'enable' === $compare_properties_module ) && ( $inspiry_compare_page ) ) {
												?>
                                                <span class="add-to-compare-span"
                                                      data-button-id="<?php the_ID(); ?>"
                                                      data-button-title="<?php echo get_the_title( get_the_ID() ); ?>"
                                                      data-button-url="<?php echo get_the_permalink( get_the_ID() ); ?>"
                                                >
                                                <?php
                                                $property_id = get_the_ID();
                                                if ( ere_is_added_to_compare( $property_id ) ) {
                                                    ?>
                                                    <span class="compare-placeholder highlight"
                                                          data-tooltip="<?php esc_attr_e( 'Added to compare', 'easy-real-estate' ); ?>">
                                                        <?php ere_include_compare_icon(); ?>
                                                    </span>
                                                    <a class="rh_trigger_compare add-to-compare hide"
                                                       data-tooltip="<?php esc_attr_e( 'Add to compare', 'easy-real-estate' ); ?>" data-property-id="<?php the_ID(); ?>"
                                                       href="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">
                                                        <?php ere_include_compare_icon(); ?>
                                                    </a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="compare-placeholder highlight hide"
                                                          data-tooltip="<?php esc_attr_e( 'Added to compare', 'easy-real-estate' ); ?>">
                                                        <?php ere_include_compare_icon(); ?>
                                                    </span>
                                                    <a class="rh_trigger_compare add-to-compare"
                                                       data-tooltip="<?php esc_attr_e( 'Add to compare', 'easy-real-estate' ); ?>" data-property-id="<?php the_ID(); ?>"
                                                       href="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">
                                                        <?php ere_include_compare_icon(); ?>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </span>

												<?php
											}
											?>
                                        </div>
                                        <!-- /.rh_prop_card__btns -->
                                    </figure>
                                    <!-- /.rh_prop_card__thumbnail -->

                                    <div class="rh_prop_card__details">

                                        <h3>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <p class="rh_prop_card__excerpt"><?php ere_framework_excerpt( 10 ); ?></p>
                                        <!-- /.rh_prop_card__excerpt -->

                                        <div class="rh_prop_card__meta_wrap">

											<?php if ( ! empty( $property_bedrooms ) ) : ?>
                                                <div class="rh_prop_card__meta">
                                                    <span class="rh_meta_titles">
                                                           <?php
                                                           $bedrooms_label = get_option( 'inspiry_bedrooms_field_label' );
                                                           if(!empty($bedrooms_label)&&($bedrooms_label)){
	                                                           echo esc_html($bedrooms_label);
                                                           }else{
	                                                           esc_html_e( 'Bedrooms', 'easy-real-estate' );
                                                           }
                                                           ?>
                                                    </span>
                                                    <div>
														<?php include( ERE_PLUGIN_DIR . 'images/icons/icon-bed.svg' ); ?>
                                                        <span class="figure"><?php echo esc_html( $property_bedrooms ); ?></span>
                                                    </div>
                                                </div>
                                                <!-- /.rh_prop_card__meta -->
											<?php endif; ?>

											<?php if ( ! empty( $property_bathrooms ) ) : ?>
                                                <div class="rh_prop_card__meta">
                                                    <span class="rh_meta_titles">
                                                            <?php
                                                            $bathrooms_label = get_option( 'inspiry_bathrooms_field_label' );

                                                            if(!empty($bathrooms_label)&&($bathrooms_label)){
	                                                            echo esc_html($bathrooms_label);
                                                            }else{
	                                                            esc_html_e( 'Bathrooms', 'easy-real-estate' );
                                                            }

                                                            ?>
                                                    </span>
                                                    <div>
														<?php include( ERE_PLUGIN_DIR . 'images/icons/icon-shower.svg' ); ?>
                                                        <span class="figure"><?php echo esc_html( $property_bathrooms ); ?></span>
                                                    </div>
                                                </div>
                                                <!-- /.rh_prop_card__meta -->
											<?php endif; ?>

											<?php if ( ! empty( $property_size ) ) : ?>
                                                <div class="rh_prop_card__meta">
                                                    <span class="rh_meta_titles">
                                                             	<?php
                                                                $area_label = get_option( 'inspiry_area_field_label' );
                                                                if(!empty($area_label)&&($area_label)){
	                                                                echo esc_html($area_label);
                                                                }else{
	                                                                esc_html_e( 'Area', 'easy-real-estate' );
                                                                }
                                                                ?>
                                                    </span>
                                                    <div>
														<?php include( ERE_PLUGIN_DIR . 'images/icons/icon-area.svg' ); ?>
                                                        <span class="figure">
															<?php echo esc_html( $property_size ); ?>
														</span>
														<?php if ( ! empty( $size_postfix ) ) : ?>
                                                            <span class="label">
																<?php echo esc_html( $size_postfix ); ?>
															</span>
														<?php endif; ?>
                                                    </div>
                                                </div>
                                                <!-- /.rh_prop_card__meta -->
											<?php endif; ?>

                                        </div>
                                        <!-- /.rh_prop_card__meta_wrap -->

                                        <div class="rh_prop_card__priceLabel">

											<span class="rh_prop_card__status">
												<?php ere_display_figcaption( $post->ID ); ?>
											</span>
                                            <!-- /.rh_prop_card__type -->
                                            <p class="rh_prop_card__price">
												<?php ere_property_price(); ?>
                                            </p>
                                            <!-- /.rh_prop_card__price -->

                                        </div>
                                        <!-- /.rh_prop_card__priceLabel -->

                                    </div>
                                    <!-- /.rh_prop_card__details -->

                                </div>
                                <!-- /.rh_prop_card__wrap -->

                            </article>
                            <!-- /.rh_prop_card -->
						<?php
						endwhile;
						wp_reset_query();
					else :
						?>
                        <div class="rh_alert-wrapper rh_alert__widget">
                            <h4 class="no-results"><?php esc_html_e( 'No Featured Property Found For This Agent', 'easy-real-estate' ); ?></h4>
                        </div>
					<?php
					endif;
				}

				echo $after_widget;
			}
		}


		function form( $instance ) {

			if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			    $label_property = esc_html__('دیدن ملک','easy-real-estate');
			}elseif ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
				$label_property = esc_html__('Read More','easy-real-estate');
			}

			$instance = wp_parse_args(
				(array) $instance, array(
					'title'   => 'Featured Properties',
					'count'   => 1,
					'sort_by' => 'random',
                    'view_property'  => $label_property,
				)
			);

			$view_property  = esc_attr( $instance['view_property'] );
			$title   = esc_attr( $instance['title'] );
			$sort_by = $instance['sort_by'];
			$count   = $instance['count'];

			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title', 'easy-real-estate' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>"><?php _e( 'Sort By:', 'easy-real-estate' ); ?></label>
                <select name="<?php echo esc_attr( $this->get_field_name( 'sort_by' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>" class="widefat">
                    <option value="recent"<?php selected( $sort_by, 'recent' ); ?>><?php _e( 'Most Recent', 'easy-real-estate' ); ?></option>
                    <option value="random"<?php selected( $sort_by, 'random' ); ?>><?php _e( 'Random', 'easy-real-estate' ); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'Number of Properties', 'easy-real-estate' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3"/>
            </p>
            <p>
				<?php
				if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
					?>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'view_property' ) ); ?>"><?php _e( 'دیدن ملک', 'easy-real-estate' ); ?></label>
					<?php
				} elseif ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
					?>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'view_property' ) ); ?>"><?php _e( 'Read More', 'easy-real-estate' ); ?></label>
					<?php
				}
				?>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'view_property' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'view_property' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $view_property ); ?>"/>
            </p>
			<?php
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']   = strip_tags( $new_instance['title'] );
			$instance['view_property']   = strip_tags( $new_instance['view_property'] );
			$instance['sort_by'] = $new_instance['sort_by'];
			$instance['count']   = $new_instance['count'];

			return $instance;

		}

	}
}

if ( ! function_exists( 'register_agent_featured_properties_widget' ) ) {
	function register_agent_featured_properties_widget() {
		register_widget( 'Agent_Featured_Properties_Widget' );
	}

	add_action( 'widgets_init', 'register_agent_featured_properties_widget' );
}
