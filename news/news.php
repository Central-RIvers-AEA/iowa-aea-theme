<?php

/* Register News Post Type */

function register_news_post_type() {
  $supports = array(
    'title', // post title
    'editor', // post content
    'author', // post author
    'thumbnail', // featured images
    'excerpt', // post excerpt
    'custom-fields', // custom fields
    'revisions', // post revisions
    'post-formats', // post formats
    'page-attributes', // post page attributes
    'trackbacks', 
	);

  register_post_type( 'news', array(
      'label' => 'News',
      'labels' => array(
        'name' => 'News',
        'singular_name' => 'News',
        'add_new' => _x('Add New', 'News', 'textdomain'),
        'add_new_item' => 'Add New News',
        'edit_item' => 'Edit News',
        'new_item' => 'New News',
        'view_item' => 'View News',
        'not_found' => 'No News found',
        'not_found_in_trash' => 'No News found in Trash',
      ),
      'description' => 'News',
      'public' => true,
      'publicly_queryable' => true,
      'has_archive' => true,
      'show_in_rest' => true,
      'show_in_admin' => true,
      'exclude_from_search' => false,
      'supports' => $supports,
      'menu_position' => 7,
      'query_var' => true,
      'rewrite' => array(
        'slug' => 'news',
        'with_front' => false
      )
      ));
}

add_action( 'init', 'register_news_post_type' );