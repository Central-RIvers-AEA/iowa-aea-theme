<?php

/* Register events Post Type */

function register_events_post_type() {
  $supports = array(
    'title', // post title
	);


  register_post_type( 'event', array(
      'label' => 'Events',
      'labels' => array(
        'name' => 'Events',
        'singular_name' => 'Events',
        'add_new' => _x('Add New', 'Events', 'textdomain'),
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
        'new_item' => 'New Event',
        'view_item' => 'View Event',
        'not_found' => 'No Events found',
        'not_found_in_trash' => 'No Events found in Trash',
      ),
      'description' => 'events',
      'public' => true,
      'publicly_queryable' => true,
      'has_archive' => true,
      'show_in_rest' => true,
      'show_in_admin' => true,
      'exclude_from_search' => false,
      'supports' => $supports,
      'query_var' => true,
      'rewrite' => array(
        'slug' => 'events',
        'with_front' => false
      )
      ));
}

add_action( 'init', 'register_events_post_type' );

// Add Events Config Page
function add_events_config_page() {
  add_submenu_page(
    'edit.php?post_type=event',
    'Events Config',
    'Events Config',
    'manage_options',
    'events-config',
    'render_events_config_page',
    'dashicons-calendar',
    20
  );
}

add_action( 'admin_menu', 'add_events_config_page' );

function render_events_config_page() {
   $calendar_ids = get_option('google_calendar_ids', array());
   $gcal_api_key = get_option('google_calendar_api_key', '');
  ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.add_google_calendar_id').addEventListener('click', function() {
          var newId = prompt("Enter Google Calendar ID:");
          if (newId) {
            let removeButton = '<button type="button" class="remove_google_calendar_id button">Remove</button>';
            let newInput = '<input type="text" name="google_calendar_ids[]" value="' + newId + '" />';

            let holder = document.createElement('div');
            holder.innerHTML = newInput + ' ' + removeButton;

            holder.querySelector('.remove_google_calendar_id').addEventListener('click', function() {
              holder.remove();
            });

            document.querySelector('.google_calendar_ids').appendChild(holder);
          }
        });

        document.querySelectorAll('.remove_google_calendar_id').forEach(function(button) {
          button.addEventListener('click', function() {
            button.parentElement.remove();
          });
        });
      });
    </script> 
    <div class="wrap">
      <h1>Events Config</h1>

      <!-- Add Google Calendar integration settings here -->
      <form method="post" action="options.php">
        <?php
          settings_fields( 'events_config_group' );
          do_settings_sections( 'events_config_group' );
        ?>
        <table class="form-table">
          <tr valign="top">
            <th scope="row">Google Calendar API Key</th>
            <td><input type="text" name="google_calendar_api_key" value="<?php echo esc_attr( $gcal_api_key ); ?>" /></td>
          </tr>
          <tr valign="top">
            <th scope="row">Google Calendar IDs</th>
            <td>
              <div class='google_calendar_ids' style='margin-bottom: 10px;'>
                <?php if ( empty( $calendar_ids ) ) : ?>
                  
                <?php else : ?>
                  <?php foreach ( $calendar_ids as $id ) : ?>
                    <div>
                      <input type="text" name="google_calendar_ids[]" value="<?php echo esc_attr( $id ); ?>" />
                      <button type="button" class="remove_google_calendar_id button">Remove</button>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
              <button type='button' class='add_google_calendar_id button button-primary'>Add Google Calendar ID</button>
            </td>
          </tr>
        </table>
        <?php submit_button(); ?>
      </form>
    </div>
  <?php
}

// Register settings for events config
function register_events_settings() {
  register_setting('events_config_group', 'google_calendar_api_key');
  register_setting('events_config_group', 'google_calendar_ids');
}

add_action('admin_init', 'register_events_settings');

// Add metaboxes for events
function add_events_metaboxes() {
  add_meta_box(
    'event_details',
    'Event Details',
    'render_event_details_metabox',
    'event',
    'normal',
    'high'
  );
}

add_action('add_meta_boxes', 'add_events_metaboxes');

function render_event_details_metabox($post) {
  // Add nonce for security
  wp_nonce_field('event_details_nonce', 'event_details_nonce_field');

  // Retrieve existing event details
  $event_date = get_post_meta($post->ID, 'event_date', true);
  $event_time = get_post_meta($post->ID, 'event_time', true);
  ?>
  <label for="event_date">Date:</label>
  <input type="date" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>" />

  <label for="event_time">Time:</label>
  <input type="time" id="event_time" name="event_time" value="<?php echo esc_attr($event_time); ?>" />
  <?php
}

// Save metabox data
function save_event_details_metabox($post_id) {
  // Check nonce for security
  if (!isset($_POST['event_details_nonce_field']) || !wp_verify_nonce($_POST['event_details_nonce_field'], 'event_details_nonce')) {
    return;
  }

  // Save event date
  if (isset($_POST['event_date'])) {
    update_post_meta($post_id, 'event_date', sanitize_text_field($_POST['event_date']));
  }

  // Save event time
  if (isset($_POST['event_time'])) {
    update_post_meta($post_id, 'event_time', sanitize_text_field($_POST['event_time']));
  }
}

add_action('save_post', 'save_event_details_metabox');

add_action('rest_api_init', function(){
  $meta_fields = array(
    'event_date' => 'Event Date',
    'event_time' => 'Event Time'
  );

  foreach($meta_fields as $field_name => $description) {
    register_rest_field('event', $field_name, array(
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
      ),
      
    ));
  }


  // Add custom query parameters for filtering
  add_filter('rest_event_collection_params', function($params) {
    $params['event_date'] = array(
      'description' => 'Filter events by event date',
      'type' => 'string',
      'sanitize_callback' => 'sanitize_text_field',
    );
    
    $params['event_date_after'] = array(
      'description' => 'Filter events after a specific date',
      'type' => 'string',
      'sanitize_callback' => 'sanitize_text_field',
    );
    
    $params['event_date_before'] = array(
      'description' => 'Filter events before a specific date',
      'type' => 'string',
      'sanitize_callback' => 'sanitize_text_field',
    );
    
    return $params;
  });

  // Handle the custom query parameters
  add_filter('rest_event_query', function($args, $request) {
    // Filter by exact event date
    if ($request->get_param('event_date')) {
      $args['meta_query'][] = array(
        'key' => 'event_date',
        'value' => $request->get_param('event_date'),
        'compare' => '='
      );
    }
    
    // Filter by events after a date
    if ($request->get_param('event_date_after')) {
      $args['meta_query'][] = array(
        'key' => 'event_date',
        'value' => $request->get_param('event_date_after'),
        'compare' => '>='
      );
    }
    
    // Filter by events before a date
    if ($request->get_param('event_date_before')) {
      $args['meta_query'][] = array(
        'key' => 'event_date',
        'value' => $request->get_param('event_date_before'),
        'compare' => '<='
      );
    }
    
    // Ensure proper meta_query structure
    if (isset($args['meta_query']) && count($args['meta_query']) > 1) {
      $args['meta_query']['relation'] = 'AND';
    }
    
    return $args;
  }, 10, 2);
});
