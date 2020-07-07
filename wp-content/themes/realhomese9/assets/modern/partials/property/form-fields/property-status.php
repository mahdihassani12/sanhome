<?php
/**
 * Field: Property Status
 *
 * @since 	3.0.0
 * @package RH/modern
 */

?>
<!---->
<!---->
<!--<div class="rh_form__item rh_form--1-column rh_form--columnAlign">-->
<!---->
<!---->
<!--    <label>--><?php //esc_html_e('Type', 'easy-real-estate'); ?><!--</label>-->
<!---->
<!--    <div class="rh_agent_options d-flex direction-row">-->
<!---->
<!--        --><?php
//        if (inspiry_is_edit_property()) {
//            global $target_property;
//            edit_form_hierarchical_options($target_property->ID, 'property-type');
//        } else {
//
//            $property_types_terms = get_terms(array(
//                    'taxonomy' => 'property-type',
//                    'orderby' => 'name',
//                    'order' => 'ASC',
//                    'hide_empty' => false,
//                    'parent' => 0,
//                )
//            );
////                var_dump($property_types_terms);
//
//            foreach ($property_types_terms as $term):
//
//                ?>
<!--                <label for="option--><?php //echo $term->term_id; ?><!--">-->
<!--                    <span class="title">--><?php //echo $term->name; ?><!--</span>-->
<!--                    <input id="option--><?php //echo $term->term_id; ?><!--" type="radio" name="property-type"-->
<!--                           value="--><?php //echo $term->term_id; ?><!--">-->
<!--                    <span class="control__indicator"></span>-->
<!--                </label>-->
<!--            --><?php
//
//            endforeach;
//
//        }
//        ?>
<!---->
<!---->
<!--    </div>-->
<!---->
<!--</div>-->



<div class="rh_form__item rh_form--3-column rh_form--columnAlign">
	<label for="status"><?php esc_html_e( 'Status', 'easy-real-estate' ); ?></label>
	<span class="selectwrap">
	    <select name="status" id="status" class="rh_select2">
	        <?php
	        if ( inspiry_is_edit_property() ) {
	            global $target_property;
	            edit_form_taxonomy_options( $target_property->ID, 'property-status' );
	        } else {
	            ?>
<!--		        <option selected="selected" value="-1">--><?php //esc_html_e( 'وضعیت ملک تان را انتخاب کنید', 'easy-real-estate' ); ?><!--</option>-->
		        <?php
	            /**
	             * Property Status Terms
	             */
	            $property_status_terms = get_terms( array(
	                    'taxonomy'   => 'property-status',
	                    'orderby'    => 'name',
	                    'order'      => 'ASC',
	                    'hide_empty' => false,
	                )
	            );

	            if ( ! empty( $property_status_terms ) ) {
	                foreach ( $property_status_terms as $property_status ) {
	                    echo '<option value="' . esc_attr( $property_status->term_id ) . '">' . esc_html( $property_status->name ) . '</option>';
	                }
	            }
	        }
	        ?>
	    </select>
	</span>
</div>
<!-- /.rh_form__item -->
