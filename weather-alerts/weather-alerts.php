<?php

/** Weather Alerts */

function register_weather_alerts_post_type() {
  $supports = array(
    'title',
    'editor',
	);


  register_post_type( 'weather_alert', array(
    'label' => 'Weather Alert',
    'labels' => array(
      'name' => 'Weather Alerts',
      'singular_name' => 'Weather Alert',
      'add_new' => _x('Add New', 'Weather Alert', 'textdomain'),
      'add_new_item' => 'Add New Weather Alert',
      'edit_item' => 'Edit Weather Alert',
      'new_item' => 'New Weather Alert',
      'view_item' => 'View Weather Alert',
      'not_found' => 'No Weather Alerts found',
      'not_found_in_trash' => 'No Weather Alerts found in Trash',
    ),
    'description' => 'Weather Alerts',
    'public' => true,
    'publicly_queryable' => true,
    'has_archive' => true,
    'show_in_rest' => true,
    'show_in_admin' => true,
    'exclude_from_search' => false,
    'supports' => $supports,
    'query_var' => true,
    'menu_position' => 2,
    'rewrite' => array(
      'slug' => 'weather_alerts',
      'with_front' => false
    ),
    'register_meta_box_cb' => 'add_weather_alerts_metaboxes'
  ));
}

add_action( 'init', 'register_weather_alerts_post_type');

function add_weather_alerts_metaboxes() {
  add_meta_box('weather_alert_details', 'Posting Info', 'render_weather_alert_details_metabox', 'weather_alert', 'side', 'high');
}

function render_weather_alert_details_metabox($post) {
  // Add nonce for security
  wp_nonce_field('weather_alert_details_nonce', 'weather_alert_details_nonce_field');

  // Retrieve existing weather alert details
  $alert_start_date = get_post_meta($post->ID, 'alert_start_date', true);
  $alert_end_date = get_post_meta($post->ID, 'alert_end_date', true);
  $alert_location = get_post_meta($post->ID, 'alert_location', true);

  // Output the form fields
  echo '<label for="alert_start_date">Start Date:</label>';
  echo '<input type="datetime-local" id="alert_start_date" name="alert_start_date" value="' . esc_attr($alert_start_date) . '" />';

  echo '<label for="alert_end_date">End Date:</label>';
  echo '<input type="datetime-local" id="alert_end_date" name="alert_end_date" value="' . esc_attr($alert_end_date) . '" />';

  echo '<label for="alert_location">Location:</label>';
  echo '<input type="text" id="alert_location" name="alert_location" value="' . esc_attr($alert_location) . '" />';
  
}

// Handle Save of meta
function save_weather_alert_details($post_id) {

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  // Check user permissions
  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  // Check nonce for security
  if (!isset($_POST['weather_alert_details_nonce_field']) || !wp_verify_nonce($_POST['weather_alert_details_nonce_field'], 'weather_alert_details_nonce')) {
    return;
  }

  // Save or update weather alert details
  update_post_meta($post_id, 'alert_start_date', sanitize_text_field($_POST['alert_start_date']));
  update_post_meta($post_id, 'alert_end_date', sanitize_text_field($_POST['alert_end_date']));
  update_post_meta($post_id, 'alert_location', sanitize_text_field($_POST['alert_location']));
}

add_action('save_post', 'save_weather_alert_details');

/* Add dismissable notice to site if a new weather alert is published */
function add_notice_to_front_of_website() {
  $alerts = get_posts([
    'post_type' => 'weather_alert',
    'post_status' => 'publish',
    'numberposts' => 5,
    'meta_query' => [
      'relation' => 'AND',
      [
        'key' => 'alert_start_date',
        'value' => current_time('mysql'),
        'compare' => '<=',
        'type' => 'DATETIME'
      ],
      [
        'key' => 'alert_end_date',
        'value' => current_time('mysql'),
        'compare' => '>=',
        'type' => 'DATETIME'
      ]
    ]
  ]);


  $feeds = retrieve_weather_feeds();

  $show_alerts = !empty($alerts) || !empty($feeds);

  if($show_alerts){
    echo '<div class="weather-alerts-notices">';

    foreach ($alerts as $alert) {
      echo '<div class="weather-alert">';
        echo '<div class="location">' . esc_html(get_post_meta($alert->ID, 'alert_location', true)) . ' Alert</div>';
        echo $alert->post_content;
      echo '</div>';
    }

    foreach($feeds as $feed) {
      $title = $feed['title'];
      $items = $feed['items'];
      foreach ($items as $alert) {
        echo '<div class="weather-alert">';
          echo '<div class="location">'. $title . ' Alert</div>';
          echo '<p>' . $alert['descript'] . '</p>';
        echo '</div>';
      }
    }

    echo '</div>';
  }
}

add_action('wp_head', 'add_notice_to_front_of_website');

/** Custom Columns in alerts table */
function add_custom_columns($columns) {
  $columns['alert_start_date'] = 'Start Date & Time';
  $columns['alert_end_date'] = 'End Date & Time';
  $columns['alert_location'] = 'Location';
  return $columns;
}

add_filter('manage_weather_alert_posts_columns', 'add_custom_columns');

/** Load content for custom columns */
function load_custom_columns_content($column, $post_id) {
  switch ($column) {
    case 'alert_start_date':
      // Format date time
      $start = get_post_meta($post_id, 'alert_start_date', true);
      $start = date('F j, Y, g:i a', strtotime($start));
      echo $start;
      break;
    case 'alert_end_date':
      $end = get_post_meta($post_id, 'alert_end_date', true);
      $end = date('F j, Y, g:i a', strtotime($end));
      echo $end;
      break;
    case 'alert_location':
      echo esc_html(get_post_meta($post_id, 'alert_location', true));
      break;
  }
}

add_action('manage_weather_alert_posts_custom_column', 'load_custom_columns_content', 10, 2);

/** Load Content From an RSS Feed */

// Read from rssfeed
function readFeed($feed){
  $rss = new DOMDocument();
  if($rss->load($feed) === false){ return array(); }

  $list = array();
    
  foreach ($rss->getElementsByTagName('item') as $node) {
    $item = array ( 
      'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
      'descript' => $node->getElementsByTagName('description')->item(0)->nodeValue,
      'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
    );

    if(time() - strtotime($item['date']) < (20 * 60 * 60) ){
      $list[] = $item;
    }
  }

  return $list;
}

// shortcode for rss feed
function retrieve_weather_feeds(){
  // get list of feeds from weather alerts feeds list
  $feeds_list = get_option('iaea_weather_alerts_map');

  $feeds = [];

  foreach($feeds_list as $feed_item){
    if(empty($feed_item['title'])){
      continue;
    }

    $list = readFeed($feed_item['feed_url']);
    $title = $feed_item['title'];
    
    if(count($list) > 0){
      $feeds[] = ["title" => $title, "items" => $list];
    }
  }

  return $feeds;
}

// Add Subpage for Weather Alerts Config
function iaea_weather_alerts_config_page(){
  add_submenu_page(
    'edit.php?post_type=weather_alert', 
    'alerts_config', 
    'Alerts Config', 
    'manage_options', 
    'alerts-config',
    'iaea_weather_alerts_config',
    10
  );
}

add_action('admin_menu', 'iaea_weather_alerts_config_page');

function iaea_weather_alerts_settings_init(){
  register_setting(
    'iaea_weather_alerts_group',
    'iaea_weather_alerts_map'
  );
}

add_action('admin_init', 'iaea_weather_alerts_settings_init');

function iaea_weather_alerts_config(){
      if (!current_user_can('manage_options')) {
      wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    ?>
      <div class="wrap">
        <h1>Weather Alerts Configuration</h1>
        <p>Configure settings for the Weather Alerts here.</p>
        <!-- Configuration options can be added here -->

        <form method="post" action="options.php">
          <?php
          settings_fields('iaea_weather_alerts_group');
          do_settings_sections('iaea_weather_alerts_group');

          $initial_mapping = [[ 'title' => '',  'feed_url' => '' ], [ 'title' => '',  'feed_url' => '' ], [ 'title' => '',  'feed_url' => '' ]];
          $saved_weather_mappings = get_option('iaea_weather_alerts_map', $initial_mapping);

          ?>
          
          <table class="form-table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Feed Url</th>
              </tr>
            </thead>
            <tbody>
            <?php
              foreach($saved_weather_mappings as $key => $mapping){
                echo "<tr>";
                  echo '<td><input placeholder="AEA Office" type="text" name="iaea_weather_alerts_map[' . esc_attr($key) . '][title]" value="' . esc_attr($mapping['title']) . '" /></td>';
                  echo '<td><input placeholder="https://api.retrieve.com/something" type="text" name="iaea_weather_alerts_map[' . esc_attr($key) . '][feed_url]" value="' . esc_attr($mapping['feed_url']) . '" /></td>';
                echo "</tr>";
              }
            ?>
            </tbody>
          <table>

          <?php
          submit_button();
          ?>
        </form>
      </div>
    <?php
}