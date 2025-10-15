<?php

/* Register events Post Type */

function register_events_post_type() {
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



