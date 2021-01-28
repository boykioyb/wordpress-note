<?php
/**
 * Plugin Name: WP Editor in a Meta Box
 * Plugin URI: 
 * Description: Demonstration of WP Editor in a meta box.
 * Version: 1.0
 * Author: Hoatq
 * Author URI: 
 * License: 
 */

// file name: wp_editor-in-meta-box-test.php 

/* Meta box code based on http://codex.wordpress.org/Function_Reference/add_meta_box */

/* Define the custom box */
add_action( 'add_meta_boxes', 'myplugin_add_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'myplugin_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function myplugin_add_custom_box() {
  add_meta_box( 'wp_editor_test_1_box', 'Quà tặng và ưu đãi kèm theo', 'wp_editor_meta_box' );
}

/* Prints the box content */
function wp_editor_meta_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

  $field_value = get_post_meta( $post->ID, '_wp_editor_test_1', false );
  wp_editor( $field_value[0], '_wp_editor_test_1' );
}

/* When the post is saved, saves our custom data */
function myplugin_save_postdata( $post_id ) {

  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times
  if ( ( isset ( $_POST['myplugin_noncename'] ) ) && ( ! wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) ) )
      return;

  // Check permissions
  if ( ( isset ( $_POST['post_type'] ) ) && ( 'page' == $_POST['post_type'] )  ) {
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
      return;
    }    
  }
  else {
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }
  }

  // OK, we're authenticated: we need to find and save the data
  if ( isset ( $_POST['_wp_editor_test_1'] ) ) {
    update_post_meta( $post_id, '_wp_editor_test_1', $_POST['_wp_editor_test_1'] );
  }

}
