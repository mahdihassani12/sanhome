<?php
/**
 * Widget: Property Types Widget
 */

if ( ! class_exists( 'Property_Types_Widget' ) ) {

	/**
	 * Property_Types_Widget.
	 *
	 * Display Available Property Types for Real Homes
	 * in the form of a list.
	 *
	 * @since 1.0.0
	 */
	class Property_Types_Widget extends WP_Widget {

		/**
		 * Method: Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$widget_ops = array(
				'classname'                   => 'Property_Types_Widget',
				'description'                 => esc_html__( 'This widget displays a list of Property Types.', 'easy-real-estate' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct( 'property_types_widget', esc_html__( 'RealHomes - Property Types', 'easy-real-estate' ), $widget_ops );
		}

		/**
		 * Method: Widget Front-End Display.
		 *
		 * @param array $args - contains the argument of the widget.
		 * @param array $instance - contains the parameters of the widget.
		 *
		 * @since 1.0.0
		 */
		function widget( $args, $instance ) {

		    extract( $args );

			// Title
			if ( isset( $instance['title'] ) ) {
				$title = apply_filters( 'widget_title', $instance['title'] );
			}
			if ( empty( $title ) ) {
				$title = esc_html__( 'Property Types', 'easy-real-estate' );
			}

			echo $before_widget;

			if ( $title ) :
				echo $before_title;
				echo $title;
				echo $after_title;
			endif;

			$this->property_types();

			echo $after_widget;

		}

		/**
		 * Method: Widget Form.
		 *
		 * @param array $instance - contains the parameters of the widget.
		 *
		 * @return void
		 */
		function form( $instance ) {
			$instance = wp_parse_args(
				(array) $instance, array(
					'title' => esc_html__( 'Property Types', 'easy-real-estate' ),
				)
			);
			$title    = esc_attr( $instance['title'] );
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'easy-real-estate' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat"/>
            </p>
			<?php
		}

		/**
		 * Method: Widget Update.
		 *
		 * @param array $new_instance - contains the new instance of the widget.
		 * @param array $old_instance - contains the old instance of the widget.
		 *
		 * @return array
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			return $instance;
		}

		/**
		 * Method: Get Property Types.
		 *
		 * @since 1.0.0
		 */
		function property_types() {
			$terms = get_terms(
				array(
					'taxonomy' => 'property-type',
					'parent'   => 0,
				)
			);
			$count = count( $terms );
			if ( $count > 0 ) {
				$this->show_hierarchical_property_types( $terms );
			}
		}

		/**
		 * Method: Show Property types in the
		 * form of list.
		 *
		 * @param array $terms - Terms of Property types.
		 * @param bool $top_level - True if top level.
		 *
		 * @since 1.0.0
		 */
		function show_hierarchical_property_types( $terms, $top_level = true ) {
			$count = count( $terms );
			if ( $count > 0 ) {

				if ( $top_level ) {
					echo '<ul>';
				} else {
					echo '<ul class="children">';
				}

				foreach ( $terms as $term ) {
					echo '<li><a href="' . get_term_link( $term->slug, $term->taxonomy ) . '">' . $term->name . '</a>';
					$child_terms = get_terms(
						array(
							'taxonomy' => 'property-type',
							'parent'   => $term->term_id,
						)
					);
					if ( $child_terms ) {
						$this->show_hierarchical_property_types( $child_terms, false );
					}
					echo '</li>';
				}
				echo '</ul>';
			}
		}

	}

}


if ( ! function_exists( 'register_property_types_widget' ) ) {
	function register_property_types_widget() {
		register_widget( 'Property_Types_Widget' );
	}

	add_action( 'widgets_init', 'register_property_types_widget' );
}