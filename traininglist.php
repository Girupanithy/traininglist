<?php

/**
*Plugin Name:Training Shows
*Plugin URI:https://github.com/Girupanithy
*Description:This plugin shows the list of training shows.
*Author:Giri
*Version:0.1
*/
function training_section(){
	$singular='Training Show';
	$plural='Training Shows';

	$labels=array(
          'name'=>$plural,
          'singular_name'=>$singular,
          'add_name'=>'Add New',
          'add_new_item'=>'Add New' . $singular,
          'edit'=>'Edit',
          'edit_item' =>'Edit' . $singular,
          'new_item' =>'New' . $singular,
          'view'=>'View' . $singular,
          'view_item'=>'View' . $singular,
          'search_item'=>'Search' . $plural,
          'parent'=>'Parent' . $singular,
          'not_found'=>'No' . $plural .'found',
          'not_found_in_trash'=>'No' . $plural .'in Trash'
		);
	$args =array(
          'labels' =>$labels,
          'public' =>true,
          'menu_position'=>10,
          'has_archive'=>true,
          'capability_type'=>'post',
          'map_meta_cap'=>true,
          'supports'=>array(
              'title',
              'editor',
              'custom-fields',
              'thumbnail'
          	)
		);
	register_post_type('training_show',$args);
}
add_action('init','training_section');
add_action( 'admin_init', 'training_details' );
function training_details() {
    add_meta_box( 'training_details_meta_box',
        'Training Section Details',
        'display_training_details_meta_box',
        'training_show', 'normal', 'high'
    );
}
function display_training_details_meta_box( $training_detail ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    $training_name = esc_html( get_post_meta( $training_detail->ID, 'training_name', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 100%">Training Name</td>
            <td><input type="text" size="80" name="training_name" value="<?php echo $training_name; ?>" /></td>
        </tr>
    </table>
    <?php
}
add_action( 'save_post', 'add_training_fields',10,2);
function add_training_fields( $training_detail_id, $training_detail) {
    // Check post type for movie reviews
    if ( $training_detail->post_type == 'training_show' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['training_name'] ) && $_POST['training_name'] != '' ) {
            update_post_meta( $training_detail_id, 'training_name', $_POST['training_name'] );
        }

    }
}
