<?php

/** Add custom post type for AEA Directory */

function create_aea_posttype(){
  register_post_type( 
    'aea', 
    array(
      'label' => 'AEAs',
      'labels' => array(
        'name' => 'AEAs',
        'singular_name' => 'AEA',
        'add_new' => _x('Add New', 'AEA', 'textdomain'),
        'add_new_item' => 'Add New AEA',
        'edit_item' => 'Edit AEA',
        'new_item' => 'New AEA',
        'view_item' => 'View AEA',
        'not_found' => 'No AEAs found',
        'not_found_in_trash' => 'No AEAs found in Trash',
      ),
      'description' => 'aeas',
      'public' => true,
      'has_archive' => false,
      'show_in_rest' => true,
      'show_in_admin' => true,
      'show_in_menu' => 'edit.php?post_type=employee',
      'menu_position' => 9,
      'exclude_from_search' => true,
      'supports' => array('title'),
      'rewrite' => array('slug' => 'aeas', 'with_front' => false)
    )
  );
}

add_action('init', 'create_aea_posttype');

add_action('add_meta_boxes_aea', 'create_aea_information_meta_box');

function create_aea_information_meta_box() {
  add_meta_box( 'aea-information', 'AEA Information', 'aea_info_meta_box', null, 'normal', 'high');
}

function aea_info_meta_box($post) {
  wp_nonce_field( basename( __FILE__ ), 'aea_directory_nonce' );
  sd_input_field($post, 'Address', 'address', 'text', true);
  sd_input_field($post, 'City, St Zip','city_state_zip', 'text', true, '', 'Eg. Cedar Falls, IA 50613');
  sd_input_field($post, 'Phone Number', 'phone_number', 'text', true, '', null, '555-555-5555');
  sd_input_field($post, 'Fax Number', 'fax_number', 'text', false, '', null, '555-555-5555');
  sd_input_field($post, 'Website', 'website', 'url');
  sd_input_field($post, 'MapId', 'map_id', 'text');
}

add_action('save_post_aea', 'aea_handle_save', 10, 1);

function aea_handle_save($post_id) {
  if (!isset($_POST['aea_directory_nonce']) || !wp_verify_nonce($_POST['aea_directory_nonce'], basename(__FILE__))) {
    return;
  }

  // Save AEA specific fields
  $fields = array('address', 'city_state_zip', 'phone_number', 'fax_number', 'website', 'map_id');
  foreach ($fields as $field) {
    if (isset($_POST[$field])) {
      update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
    }
  }
}

add_action('rest_api_init', function(){
  $meta_fields = array(
    'address' => 'District address',
    'city_state_zip' => 'City, State, ZIP',
    'phone_number' => 'Phone number',
    'fax_number' => 'Fax number',
    'website' => 'Website URL',
    'map_id' => 'Map ID'
  );

  foreach($meta_fields as $field_name => $description) {
    register_rest_field('aea', $field_name, array(
      'get_callback' => function($post) use ($field_name) {
        $value = get_post_meta($post['id'], $field_name, true);
        return $value;
      },
      'update_callback' => function($value, $post) use ($field_name) {
        return update_post_meta($post->ID, $field_name, $value);
      },
      'schema' => array(
        'description' => $description,
        'type' => 'string'
      )
    ));
  }
});