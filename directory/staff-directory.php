<?php

/* Staff directory setup */

// Include School Directory & AEA directories
include_once __DIR__ . '/aea-directory.php';
include_once __DIR__ . '/school-directory.php';

class StaffDirectory
{
  public function __construct()
  {
    add_action('init', array($this, 'register_employee_post_type'));
    // add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

    add_action('save_post_employee', array($this, 'save_employee_details'));

    add_action('wp_ajax_directory_filter', array($this, 'directory_filter'));
    add_action('wp_ajax_nopriv_directory_filter', array($this, 'directory_filter'));

    add_action('admin_menu', array($this, 'import_employees_page'));

    add_action('admin_enqueue_scripts', array($this, 'enqueue_assignment_script'));
    
    add_action('rest_api_init', array($this, 'register_staff_rest_routes'));

    add_action('admin_init', array($this, 'directory_settings_init'));
  }

  // import employees page
  public function import_employees_page(){
    add_submenu_page(
      'edit.php?post_type=employee',
      'Import Employees',
      'Import Employees',
      'manage_options',
      'import-employees',
      array($this, 'import_employees_page_callback')
    );

    add_submenu_page(
      'edit.php?post_type=employee',
      'Directory Config',
      'Directory Config',
      'manage_options',
      'directory-config',
      array($this, 'directory_config_page_callback')
    );
  }

  /* callback for import employees page */
  public function import_employees_page_callback(){
    if (!current_user_can('manage_options')) {
      wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    ?>
    <div class="wrap">
      <h1>Import Employees from CSV</h1>
      <p>Please upload a CSV file containing employee data. The columns should be as below</p>
      <ul>
        <li>first_name</li>
        <li>last_name</li>
        <li>position</li>
        <li>email</li>
        <li>phone</li>
        <li>photo url (if applicable)</li>
      </ul>
      <form method="post" enctype="multipart/form-data">
        <input type="file" name="employee_csv" accept=".csv" required />
        <input type="hidden" name="action" value="import_employees_from_csv">
        <?php submit_button('Import Employees'); ?>
      </form>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['employee_csv'])) {
      $file = $_FILES['employee_csv'];
      if ($file['error'] === UPLOAD_ERR_OK) {
        $file_path = $file['tmp_name'];
        $result = $this->import_employees();
        if (is_wp_error($result)) {
          echo '<div class="error"><p>' . $result->get_error_message() . '</p></div>';
        } else {
          echo '<div class="updated"><p>Employees imported successfully!</p></div>';
        }
      } else {
        echo '<div class="error"><p>Error uploading file: ' . $file["error"] . '</p></div>';
      }
    }
  }

  /* register employee custom post type */
  public function register_employee_post_type(){
    $options = array(
      'label' => 'Staff Directory',
      'labels' => array(
        'name' => 'Staff Directory',
        'singular_name' => 'Employee',
        'add_new' => _x('Add New', 'Employee', 'textdomain'),
        'add_new_item' => 'Add New Employee',
        'edit_item' => 'Edit Employee',
        'new_item' => 'New Employee',
        'view_item' => 'View Employee',
      ),
      'description' => 'Employees',
      'hierarchical' => true,
      'public' => '',
      'show_ui' => true,
      'show_in_admin_bar' => true,
      'show_in_rest' => true,
      'menu_position' => 10,
      'exclude_from_search' => true,
      'supports' => array('title', 'thumbnail'),
      'register_meta_box_cb' => array($this, 'employee_meta_boxes')
    );

    register_post_type('employee', $options);
  }

  /* register meta boxes for employee post type */
  public function employee_meta_boxes(){
    add_meta_box(
      'employee_details',
      'Employee Details',
      array($this, 'employee_details_callback'),
      'employee',
      'normal',
      'high'
    );

    add_meta_box(
      'assignment_details',
      'Assignment Details',
      array($this, 'employee_districts_callback'),
      'employee',
      'normal',
      'high'
    );
  }

  /* callback for employee details meta box */
  public function employee_details_callback($post)
  {
    // Add nonce for security and authentication.
    wp_nonce_field('employee_details_nonce_action', 'employee_details_nonce');
    // Retrieve existing values from the database.
    $district = get_post_meta($post->ID, 'district', true);
    $building = get_post_meta($post->ID, 'building', true);
    $area = get_post_meta($post->ID, 'area', true);
    $position = get_post_meta($post->ID, 'position', true);
    $location = get_post_meta($post->ID, 'location', true);
    $email = get_post_meta($post->ID, 'email', true);
    $phone = get_post_meta($post->ID, 'phone', true);
    $photo = get_post_meta($post->ID, 'photo', true);
    $first_name = get_post_meta($post->ID, 'first_name', true);
    $last_name = get_post_meta($post->ID, 'last_name', true);

    ?>
    <table class="form-table">
      <tr>
        <th><label for="first_name">First Name</label></th>
        <td>
          <input type="text" id="first_name" name="first_name" value="<?php echo esc_attr($first_name); ?>" class="regular-text" />
          <p class="description">Enter Employees first name.</p>
        </td>
      </tr>
      <tr>
        <th><label for="last_name">Last Name</label></th>
        <td>
          <input type="text" id="last_name" name="last_name" value="<?php echo esc_attr($last_name); ?>" class="regular-text" />
          <p class="description">Enter Employees last name.</p>
        </td>
      </tr>
      <tr>
        <th><label for="area">Content Area</label></th>
        <td>
          <input type="text" id="area" name="area" value="<?php echo esc_attr($area); ?>" class="regular-text" />
          <p class="description">Enter the content area for this employee.</p>
        </td>
      </tr>
      <tr>
        <th><label for="position">Position</label></th>
        <td>
          <input type="text" id="position" name="position" value="<?php echo esc_attr($position); ?>" class="regular-text" />
          <p class="description">Enter the position for this employee.</p>
        </td>
      </tr>
      <tr>
        <th><label for="email">Email</label></th>
        <td>
          <input type="email" id="email" name="email" value="<?php echo esc_attr($email); ?>" class="regular-text" />
          <p class="description">Enter the email address for this employee.</p>
        </td>
      </tr>
      <tr>
        <th><label for="phone">Phone</label></th>
        <td>
          <input type="tel" id="phone" name="phone" value="<?php echo esc_attr($phone); ?>" class="regular-text" />
          <p class="description">Enter the phone number for this employee.</p>
        </td>
      </tr>
      <tr>
        <th><label for="photo">Photo URL</label></th>
        <td>
          <input type="text" id="photo" name="photo" value="<?php echo esc_attr($photo); ?>" class="regular-text" />
          <p class="description">Enter the URL of the employee's photo.</p>
        </td>
      </tr>

      <tr>
        <th><label for="location">Location</label></th>
        <td>
          <select id='location' name='location'>
            <option value=''>Select a Location</option>
            <?php
            $locations = array(
              'Decorah',
              'Delhi',
              'Dubuque',
              'Elkader',
              'New Hampton',
              'Oelwein',
              'Waukon',
              'West Union'
            );

            foreach ($locations as $local) {
              $selected = $local == $location ? 'selected=selected' : '';

              echo "<option $selected>$local</option>";
            }

            ?>
          </select>
          <p class="description">Field Office</p>
        </td>
      </tr>

    </table>
  <?php
  }

  public function employee_districts_callback($post){
    $assignments = unserialize(get_post_meta($post->ID, 'assignments', true));

    $districts = get_posts(array(
      'post_type' => 'district',
      'numberposts' => -1,
      'orderby' => 'title',
      'order' => 'ASC'
    ));

    $buildings = get_posts(array(
      'post_type' => 'school',
      'numberposts' => -1,
      'orderby' => 'title',
      'order' => 'ASC'
    ));

    foreach ($buildings as $id => $building) {
      // $district = get_posts(array(
      //   'connected_type' => 'posts_to_pages',
      //   'connected_items' => $building,
      //   'nopaging' => true,
      //   'suppress_filters' => false
      // ))[0];

      // if ($district) {
        $buildings[$id]->district_id = get_post_meta($building->ID, 'district', true);
      // }
    }

    /*
      Headers:
        Content Area:string | District:select:id | District Wide:boolean | Building Served:select:id | Agency Wide:boolean | Search Priority:integer 
    */

    /* 
      Assignment array layout??
      [
        'content_area' => 'slklkjdf',
        'district' => '1...1000',
        'district_wide' => true|false,
        'building' => '1....1000',
        'agency_wide' => true|false,
        'search_priority' => '1...5'
      ]

    */

   ?>
    <button type='button' id='addAssignment' class='button'>Add Assignment</button>

    <template id='rowTemplate'>
      <td><input type="text" value="" name="assignment[NEW_RECORD][content_area]" /></td>
      <td>
        <select class='districtSelect' name="assignment[NEW_RECORD][district]">
          <option value=''>Select A District</option>
          <?php
          foreach ($districts as $district) {
            echo ('<option value="' . $district->ID . '">');
            echo (get_the_title($district->ID));
            echo ('</option>');
          }
          ?>
        </select>
      </td>
      <td><input type="checkbox" name="assignment[NEW_RECORD][district_wide]" /></td>
      <td><select class='buildingSelect' name="assignment[NEW_RECORD][building]"></select></td>
      <td><input type="checkbox" name="assignment[NEW_RECORD][agency_wide]" /></td>
      <td><input type="number" name="assignment[NEW_RECORD][search_priority]" /></td>
      <td>
        <button='button' class='button remove'>X</button>
      </td>
    </template>

    <table id='assignmentList'>
      <thead>
        <th>Content Area</th>
        <th>District</th>
        <th>District Wide</td>
        <th>Building</th>
        <th>Agency Wide</th>
        <th>Search Priority</th>
        <th></th>
      </thead>
      <tbody>
        <?php
        if($assignments){
          foreach ($assignments as $id => $assignment) {
            echo ('<tr>');
            echo ('<td><input type="text" value="' . $assignment['content_area'] . '" name="assignment[' . $id . '][content_area]"/></td>');
            echo ('<td><select name="assignment[' . $id . '][district]">');
            echo ('<option value="">Select A District</option>');
            foreach ($districts as $district) {
              $district_id = $district->ID;
              $selected = $district_id == $assignment['district'] ? 'selected=selected' : '';
              echo ('<option value="' . $district_id . '" ' . $selected . '>');
              echo (get_the_title($district_id));
              echo ('</option>');
            }
            echo ('</select></td>');
            $dist_wide_checked = isset($assignment['district_wide']) && $assignment['district_wide'] == 'true' ? 'checked=checked' : '';
            echo ('<td><input type="checkbox" ' . $dist_wide_checked . ' name="assignment[' . $id . '][district_wide]" value="true"/></td>');
            echo ('<td><select name="assignment[' . $id . '][building]">');
            echo ('<option value="">Select A Building</option>');
  
            $filtered_buildings = array();
  
            foreach ($buildings as $building) {
              if ($building->district_id == $assignment['district']) {
                array_push($filtered_buildings, $building);
              }
            };
  
            foreach ($filtered_buildings as $building) {
              $selected = $building->ID == $assignment['building'] ? 'selected=selected' : '';
              echo ('<option value="' . $building->ID . '" ' . $selected . '>');
              echo (get_the_title($building->ID));
              echo ('</option>');
            }
  
            echo ('</select></td>');
  
            $agency_wide_checked = isset($assignment['agency_wide']) && $assignment['agency_wide'] == 'true' ? 'checked=checked' : '';
            echo ('<td><input type="checkbox" ' . $agency_wide_checked . '" name="assignment[' . $id . '][agency_wide]" value="true"/></td>');
            echo ('<td><input type="number" value="' . $assignment['search_priority'] . '" name="assignment[' . $id . '][search_priority]"/></td>');
            echo ('<td><button type="button" class="button" onclick="this.parentNode.parentNode.remove()">X</button></td>');
            echo ('</tr>');
          }
        }

        ?>
      </tbody>
    </table>

    <?php

  }

  public function directory_settings_init(){
    register_setting(
      'staff_directory_options_group',
      'staff_directory_options'
    );

    register_setting(
      'staff_directory_options_group',
      'staff_directory_use_external_api_enabled'
    );

    register_setting(
      'staff_directory_options_group',
      'staff_directory_use_external_api'
    );

    register_setting(
      'staff_directory_options_group',
      'staff_directory_api_mappings'
    );
    
    register_setting(
      'staff_directory_options_group',
      'staff_directory_api_search_mappings'
    );
  }

  public function directory_config_page_callback(){
    if (!current_user_can('manage_options')) {
      wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    ?>
      <div class="wrap">
        <h1>Staff Directory Configuration</h1>
        <p>Configure settings for the staff directory here.</p>
        <!-- Configuration options can be added here -->

        <form method="post" action="options.php">
          <?php
          settings_fields('staff_directory_options_group');
          do_settings_sections('staff_directory_options_group');

          $initial_api_mappings = ['Full_Name' => '', 'First Name' => '', 'Last Name' => '', 'Position' => '', 'Email' => '', 'Phone' => '', 'Image' => ''];

          $saved_api_mappings = get_option('staff_directory_api_mappings', $initial_api_mappings);

          $api_mappings = array_merge($initial_api_mappings, $saved_api_mappings);

          $initial_api_search_mappings = ['Name' => '', 'Position' => '', 'District' => '', 'Building' => ''];
          $saved_api_search_mappings = get_option('staff_directory_api_search_mappings', $initial_api_search_mappings);
          $api_search_mappings = array_merge($initial_api_search_mappings, $saved_api_search_mappings);
          
          ?>
          <input type="hidden" name="action" value="update" />
          <input type="hidden" name="page_options" value="staff_directory_options" />

          <h2>General Settings</h2>
          <table class="form-table">
            <tr>
              <th><label for="staff_directory_use_external_api">Use External API</label></th>
              <td>
                <input type="checkbox" name="staff_directory_use_external_api_enabled" value="1" <?php checked(1, get_option('staff_directory_use_external_api_enabled', 0)); ?> />
                <p class="description">Check this box to enable using an external API for staff directory data.</p>
              </td>
            </tr>
            <tr>
              <th><label for="staff_directory_use_external_api">External API URL</label></th>
              <td>
                <input type="text" name="staff_directory_use_external_api" value="<?php echo esc_attr(get_option('staff_directory_use_external_api', '')); ?>" class="regular-text" />
                <p class="description">Enter the URL of the external API to use for staff directory data.</p>
              </td>
            </tr>
            <tr>
              <th>API Mapping</th>
              <td>
                <p class="description">Map external API fields to staff directory fields.</p>
                <input type="hidden" id="apiFieldMappingsNonce" value="<?php echo wp_create_nonce('api_field_mappings_nonce'); ?>" />
                <input type='hidden' id='apiFieldsRecieved' value='<?php echo get_option('staff_directory_api_fields_received', '') ?>' name='staff_directory_api_fields_received' />
                <div id="apiFieldMappings">
                  <?php
                    
                    foreach ($api_mappings as $field => $mapping) {
                      echo '<div class="api-mapping-row">';
                      echo '<label>' . esc_html($field) . ':</label> ';
                      echo '<input type="text" name="staff_directory_api_mappings[' . esc_attr($field) . ']" value="' . esc_attr($mapping) . '" class="regular-text" />';
                      echo '</div>';
                    }        
                  ?>
                </div>
                <br />
                <p>Search Field Key Mapping</p>

                <div id='apiSearchFieldMappings'>
                  <?php
                    foreach ($api_search_mappings as $field => $mapping) {
                      echo '<div class="api-search-mapping-row">';
                      echo '<label>' . esc_html($field) . ':</label> ';
                      echo '<input type="text" name="staff_directory_api_search_mappings[' . esc_attr($field) . ']" value="' . esc_attr($mapping) . '" class="regular-text" />';
                      echo '</div>';
                    }
                  ?>
                </div>

              </td>
            </tr>

          </table>
          <?php
          submit_button();
          ?>
        </form>
      </div>
    <?php
  }

  public function enqueue_assignment_script(){
    if ('employee' != get_post_type()) {
      return;
    }

    $districts = get_posts(array(
      'post_type' => 'district',
      'numberposts' => -1,
      'orderby' => 'title',
      'order' => 'ASC'
    ));

    $buildings = get_posts(array(
      'post_type' => 'school',
      'numberposts' => -1,
      'orderby' => 'title',
      'order' => 'ASC'
    ));

    foreach ($buildings as $id => $building) {
      // $district = get_posts(array(
      //   'connected_type' => 'posts_to_pages',
      //   'connected_items' => $building,
      //   'nopaging' => true,
      //   'suppress_filters' => false
      // ))[0];

      // if ($district) {
      $buildings[$id]->district_id = get_post_meta($building->ID, 'district', true);
      // }
    }

    wp_enqueue_script('assignments', get_stylesheet_directory_uri(__FILE__) . '/assets/js/employee_assignment.js', array(), fileatime(get_stylesheet_directory(__FILE__) . '/assets/js/employee_assignment.js'));
    wp_localize_script('assignments', 'assignment_vars', array(
      'districts' => $districts,
      'buildings' => $buildings
    ));
  }

  /* Save employee details */
  public function save_employee_details($post_id){
    // Check if our nonce is set.
    if (!isset($_POST['employee_details_nonce']) || !wp_verify_nonce($_POST['employee_details_nonce'], 'employee_details_nonce_action')) {
      return;
    }
    // Check if this is an autosave.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }
    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'employee' === $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
        return;
      } else {
        if (!current_user_can('edit_post', $post_id)) {
          return;
        }
      }
    }

    // Sanitize and save the data.
    $fields = [
      'district',
      'building',
      'area',
      'position',
      'email',
      'phone',
      'photo',
      'first_name',
      'last_name',
      'location'
    ];

    foreach ($fields as $field) {
      if (isset($_POST[$field])) {
        $value = sanitize_text_field($_POST[$field]);
        update_post_meta($post_id, $field, $value);
      }
    }

    if (isset($_POST['assignment'])) {
      update_post_meta($post_id, 'assignments', serialize($_POST['assignment']));
    } else {
      delete_post_meta($post_id, 'assignments');
    }
  }

  public function directory_filter(){
    // Check if the request is an AJAX request
    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_send_json_error('Invalid request', 400);
      return;
    }

    // Get the filter parameters from the request
    $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
    $district = isset($_POST['district']) ? sanitize_text_field($_POST['district']) : '';
    $building = isset($_POST['building']) ? sanitize_text_field($_POST['building']) : '';
    $area = isset($_POST['area']) ? sanitize_text_field($_POST['area']) : '';
    $position = isset($_POST['position']) ? sanitize_text_field($_POST['position']) : '';

    // Prepare the query arguments
    $args = array(
      'post_type' => 'employee',
      'posts_per_page' => -1,
      'meta_query' => array(),
      'meta_key' => 'last_name',
      'order_by' => 'meta_value',
      'order' => 'ASC'
    );

    // Add meta queries based on the provided parameters
    if (!empty($first_name)) {
      $args['meta_query'][] = array(
        'key' => 'first_name',
        'value' => $first_name,
        'compare' => 'LIKE'
      );
    }

    if (!empty($last_name)) {
      $args['meta_query'][] = array(
        'key' => 'last_name',
        'value' => $last_name,
        'compare' => 'LIKE'
      );
    }

    if (!empty($position)) {
      $args['meta_query'][] = array(
        'key' => 'position',
        'value' => $position,
        'compare' => 'LIKE'
      );
    }

    if (!empty($district)) {
      $args['meta_query'][] = array(
        'key' => 'assignments',
        'value' => $district,
        'compare' => 'LIKE'
      );
    }

    // if (!empty($building)) {
    //   $args['meta_query'][] = array(
    //     'key' => 'assignments',
    //     'value' => $building,
    //     'compare' => 'LIKE'
    //   );
    // }

    if (!empty($area)) {
      $args['meta_query'][] = array(
        'key' => 'assignments',
        'value' => $area,
        'compare' => 'LIKE'
      );
    }

    // If no filters are provided, return all employees
    if (empty($args['meta_query'])) {
      unset($args['meta_query']);
    }

    // Execute the query
    $query = new WP_Query($args);

    // Check if any posts were found
    if ($query->have_posts()) {
      $employees = [];
      while ($query->have_posts()) {
        $query->the_post();

        $assignments = unserialize(get_post_meta(get_the_ID(), 'assignments', true));

        if (!empty($district)) {
          $connected_to_district = false;

          foreach ($assignments as $assignment) {
            if ($assignment['district'] == $district) {
              $connected_to_district = true;
            }
          }

          if (!$connected_to_district) {
            continue;
          }
        }

        if (!empty($building)) {
          $connected_to_building = false;

          foreach ($assignments as $assignment) {
            if ($connected_to_building) {
              continue;
            }

            if ($assignment['building'] == $building) {
              $connected_to_building = true;
            }

            if ($assignment['district_wide'] == 'true') {
              $connected_to_building = true;
            }
          }

          if (!$connected_to_building) {
            continue;
          }
        }

        if (!empty($area)) {
          $connected_to_content_area = false;

          foreach ($assignments as $assignment) {
            if ($assignment['content_area'] == $area) {
              $connected_to_content_area = true;
            }
          }

          if (!$connected_to_content_area) {
            continue;
          }
        }

        $employees[] = array(
          'ID' => get_the_ID(),
          'name' => get_the_title(),
          'area' => get_post_meta(get_the_ID(), 'area', true),
          'job_title' => get_post_meta(
            get_the_ID(),
            'position',
            true
          ),
          'email' => get_post_meta(get_the_ID(), 'email', true),
          'work_phone' => get_post_meta(get_the_ID(), 'phone', true),
          'photo' => get_post_meta(get_the_ID(), 'photo', true),
          'first_name' => get_post_meta(get_the_ID(), 'first_name', true),
          'last_name' => get_post_meta(get_the_ID(), 'last_name', true),
          'location' => get_post_meta(get_the_ID(), 'location', true),
          'assignments' => $assignments
        );
      }
      wp_reset_postdata();
      wp_send_json_success($employees);
    } else {
      wp_send_json_error('No employees found', 404);
    }
  }

  public function import_employees(){
    $post = $_POST;
    $extension = pathinfo($_FILES['employee_csv']['name'], PATHINFO_EXTENSION);
    // echo 'hello';
    // echo var_dump($_FILES['district_import_file']);
    if (!empty($_FILES['employee_csv']['name']) && $extension == 'csv') {
      $csvFile = fopen($_FILES['employee_csv']['tmp_name'], 'r');

      $headers = fgetcsv($csvFile); // Skipping header row

      $dataArray = array();

      while (($csvData = fgetcsv($csvFile)) !== FALSE) {
        $csvData = array_map("utf8_encode", $csvData);
        $rowData = array();
        foreach ($csvData as $key => $value) {
          $rowData[strtolower($headers[$key])] = $value;
        }

        array_push($dataArray, $rowData);
      }

      echo var_dump($dataArray);

      foreach ($dataArray as $row) {
        $first_name = trim($row['first_name']);
        $last_name = trim($row['last_name']);
        $name = $first_name . ' ' . $last_name;
        $position = trim($row['position']);
        $email = trim($row['email']);
        $phone = trim($row['phone']);
        $photo = trim($row['photo']);

        $meta_data = array(
          'position' => $position,
          'email' => $email,
          'phone' => $phone,
          'first_name' => $first_name,
          'last_name' => $last_name
        );

        if(!empty($photo)){
          $meta_data['photo'] = $photo;
        }

        $postArray = array(
          'post_title' => $name,
          'post_content' => '',
          'post_type' => 'employee',
          'post_status' => 'publish',
          'meta_input' => $meta_data
        );
        wp_insert_post($postArray);
      }
      fclose($csvFile);
      return true;
    } else {
      return new WP_Error('invalid_file', 'Please upload a valid CSV file.');
    }
  }

  /**
   * Register REST API routes for staff directory
   */
  public function register_staff_rest_routes() {
    register_rest_route('staff-directory/v1', '/employees', array(
      'methods' => 'GET',
      'callback' => array($this, 'get_employees_rest'),
      'permission_callback' => array($this, 'check_staff_directory_permissions'),
      'args' => array(
        'per_page' => array(
          'default' => 100,
          'sanitize_callback' => 'absint',
        ),
        'search' => array(
          'sanitize_callback' => 'sanitize_text_field',
        ),
        'district' => array(
          'sanitize_callback' => 'sanitize_text_field',
        ),
        'building' => array(
          'sanitize_callback' => 'sanitize_text_field',
        ),
        'area' => array(
          'sanitize_callback' => 'sanitize_text_field',
        ),
        'position' => array(
          'sanitize_callback' => 'sanitize_text_field',
        ),
      ),
    ));

    register_rest_route('staff-directory/v1', '/employees/(?P<id>\d+)', array(
      'methods' => 'GET',
      'callback' => array($this, 'get_employee_rest'),
      'permission_callback' => array($this, 'check_staff_directory_permissions'),
      'args' => array(
        'id' => array(
          'validate_callback' => function($param, $request, $key) {
            return is_numeric($param);
          }
        ),
      ),
    ));
  }

  /**
   * Permission callback for staff directory REST endpoints
   * 
   * Choose one of the security levels below by uncommenting the desired option
   */
  public function check_staff_directory_permissions($request) {
    // Option 1: Require user to be logged in (any authenticated user)
    //return is_user_logged_in();
    
    // Option 2: Require specific capability (uncomment to use instead)
    // return current_user_can('edit_posts');

    return true;
    
    // Option 3: Require administrator privileges (uncomment to use instead)
    // return current_user_can('manage_options');
    
    // Option 4: Allow specific user roles (uncomment to use instead)
    //$user = wp_get_current_user();
    //$allowed_roles = array('administrator', 'editor', 'author');
    //return !empty(array_intersect($allowed_roles, $user->roles));
    
    // Option 5: Check for specific nonce/API key (uncomment to use instead)
    // $api_key = $request->get_header('X-API-Key');
    // return $api_key === 'your-secret-api-key';
    
    // Option 6: IP address restriction (uncomment to use instead)
    // $allowed_ips = array('127.0.0.1', '192.168.1.0/24');
    // $user_ip = $_SERVER['REMOTE_ADDR'];
    // return $this->ip_in_range($user_ip, $allowed_ips);
  }

  /**
   * REST API callback to get all employees
   */
  public function get_employees_rest($request) {
    if($this->check_if_using_external_api()){
      return $this->get_employees_from_external_api($request);
    } else {
      return $this->get_employees_from_internal_api($request);
    }
  }

  public function check_if_using_external_api(){
    $use_api = get_option('staff_directory_use_external_api_enabled', 0);
    return $use_api == 1;
  }

  public function get_employees_from_external_api($request){
    $search_mappings = get_option('staff_directory_api_search_mappings', array());

    $search = isset($request['search']) ? sanitize_text_field($request['search']) : '';

    $name = isset($request['staff-name']) ? sanitize_text_field($request['staff-name']) : '';
    $school_district = isset($request['school-district']) ? sanitize_text_field($request['school-district']) : '';
    $school_building = isset($request['school-building']) ? sanitize_text_field($request['school-building']) : '';
    $position = isset($request['position']) ? sanitize_text_field($request['position']) : '';

    if(empty($search_mappings)){
      wp_send_json_error('API Search Mappings not configured', 500);
      return;
    }

    $search_terms = array();
    if(!empty($search) && !empty($search_mappings['Name'])){
      $search_terms[$search_mappings['Name']] = $search;
    }

    $api_url = get_option('staff_directory_use_external_api', '');

    if (empty($api_url)) {
      wp_send_json_error('API URL not configured', 500);
      return;
    }

    $search_string = add_query_arg($search_terms, $api_url);

    $response = wp_remote_get($search_string);

    if (is_wp_error($response)) {
      return new WP_REST_Response($response, 500);
      return;
    }

    $data = wp_remote_retrieve_body($response);
    $employees = json_decode($data, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      wp_send_json_error('Invalid JSON response from API', 500);
      return;
    }

    $formatted_employees = array();
    foreach ($employees as $employee) {
      $formatted_employees[] = $this->reformat_employee_data_from_external_api($employee);
    }

    $returns = array(
      'search_string' => $search_string,
      'search_terms' => $search_terms,
      'source' => 'external_api',
      'employees' => $formatted_employees,
    );

    return new WP_REST_Response($returns, 200);
  }

  public function reformat_employee_data_from_external_api($employee){
    $api_mappings = get_option('staff_directory_api_mappings', array());

    $formatted_employee = array();

    foreach ($api_mappings as $field => $mapping) {
      if (isset($employee[$mapping])) {
        $formatted_employee[strtolower(str_replace(' ', '_', $field))] = $employee[$mapping];
      } else {
        $formatted_employee[strtolower(str_replace(' ', '_', $field))] = '';
      } 
    }

    // Additional formatting can be done here if needed

    $formatted_employee['assignments'] = array();

    return $formatted_employee;
  }

  public function get_employees_from_internal_api($request){
    $params = $request->get_params();
    
    $args = array(
      'post_type' => 'employee',
      'posts_per_page' => isset($params['per_page']) ? $params['per_page'] : 100,
      'post_status' => 'publish',
      'orderby' => 'title',
      'order' => 'ASC',
    );

    // Add search functionality
    if (!empty($params['search'])) {
      $args['s'] = $params['search'];
    }

    // Add meta query for filtering
    $meta_query = array();

    if (!empty($params['position'])) {
      $meta_query[] = array(
        'key' => 'position',
        'value' => $params['position'],
        'compare' => '='
      );
    }

    if (!empty($meta_query)) {
      $args['meta_query'] = $meta_query;
    }

    $employees = get_posts($args);
    $formatted_employees = array();

    foreach ($employees as $employee) {
      $formatted_employees[] = $this->format_employee_data($employee);
    }

    return new WP_REST_Response($formatted_employees, 200);
  }

  /**
   * REST API callback to get a single employee
   */
  public function get_employee_rest($request) {
    $id = (int) $request['id'];
    $employee = get_post($id);

    if (empty($employee) || $employee->post_type !== 'employee') {
      return new WP_Error('employee_not_found', 'Employee not found.', array('status' => 404));
    }

    return new WP_REST_Response($this->format_employee_data($employee), 200);
  }

  /**
   * Format employee data for REST API response
   */
  public static function format_employee_data($employee) {
    $meta_fields = array(
      'first_name', 'last_name', 'district', 'building', 'area', 
      'position', 'email', 'phone', 'photo', 'location'
    );

    $employee_data = array(
      'id' => $employee->ID,
      'title' => $employee->post_title,
      'slug' => $employee->post_name,
      'image' => get_the_post_thumbnail_url($employee->ID, 'full')
    );

    // Add all meta fields
    foreach ($meta_fields as $field) {
      $employee_data[$field] = get_post_meta($employee->ID, $field, true);
    }

    // Get assignments (if any)
    $assignments = get_post_meta($employee->ID, 'assignments', true);
    if ($assignments) {
      $employee_data['assignments'] = maybe_unserialize($assignments);
    } else {
      $employee_data['assignments'] = [];
    }

    // Create full name for convenience
    $employee_data['full_name'] = trim($employee_data['first_name'] . ' ' . $employee_data['last_name']);
    
    // Format for important contacts block compatibility
    $employee_data['name'] = $employee_data['full_name'];
    $employee_data['jobTitle'] = $employee_data['position'];
    $employee_data['image'] = $employee_data['image'] ?:  $employee_data['photo'] ?: get_stylesheet_directory_uri() . '/assets/images/default-profile.png';

    return $employee_data;
  }

  /** Staff Directory Employee Positions */
  public static function get_positions() {
    global $wpdb;
    $results = $wpdb->get_results("SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key = 'position'");
    return wp_list_pluck($results, 'meta_value');
  }

  /** Staff Directory Employee Content Areas */
  public static function get_content_areas() {
    global $wpdb;
    $results = $wpdb->get_results("SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key = 'assignments'");

    $unserialized_assignments = array_map('maybe_unserialize', wp_list_pluck($results, 'meta_value'));
    $unArrayed_assignments = array_map('maybe_unserialize', $unserialized_assignments);
    $flattened_assignments = array_merge(...$unArrayed_assignments);

    $assignments = [];

    foreach($flattened_assignments as $key => $assignment) {
      $assignments[] = $assignment['content_area'];
    }

    return $assignments;
  }
}

// Initialize the StaffDirectory class
$GLOBALS['staff-directory'] = new StaffDirectory();


// Some example parameters that Green Hills AEA uses for their directory REST API

// action -directory
// ajax - true
// per_page - 1000
// department - 271
// district - 82
// building - 272
// title - 213
// office - 180
// search - pa

// Example Return for Green Hills

// {
//   "id": 1239,
//   "date": "2022-10-28T13:14:56",
//   "date_gmt": "2022-10-28T18:14:56",
//   "guid": {
//     "rendered": "https://green-hills.staging2.juiceboxint.com/directory-listing/teresa-johnsen/"
//   },
//   "modified": "2024-07-15T09:39:35",
//   "modified_gmt": "2024-07-15T14:39:35",
//   "slug": "teresa-johnsen",
//   "status": "publish",
//   "type": "directory",
//   "link": "https://www.ghaea.org/directory-listing/teresa-johnsen/",
//   "title": {
//     "rendered": "Teresa Johnsen"
//   },
//   "template": "",
//   "meta": {
//     "_acf_changed": false,
//     "_links_to": "",
//     "_links_to_target": ""
//   },
//   "departments": [
//     160
//   ],
//   "districts": [
//     386,
//     61
//   ],
//   "buildings": [
//     76
//   ],
//   "expertises": [],
//   "positions": [],
//   "titles": [
//     492,
//     171
//   ],
//   "offices": [
//     180
//   ],
//   "class_list": [
//     "post-1239",
//     "type-directory",
//     "status-publish",
//     "hentry",
//     "department-specialized-services-and-supports",
//     "district-agency-wide",
//     "district-council-bluffs",
//     "title-consultant-integrated-support-assistive-technology",
//     "title-speech-language-pathologist",
//     "office-council-bluffs-office"
//   ],
//   "yoast_head": "<!-- This site is optimized with the Yoast SEO plugin v23.6 - https://yoast.com/wordpress/plugins/seo/ -->\n<meta name=\"robots\" content=\"index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1\" />\n<link rel=\"canonical\" href=\"https://www.ghaea.org/directory-listing/teresa-johnsen/\" />\n<meta property=\"og:locale\" content=\"en_US\" />\n<meta property=\"og:type\" content=\"article\" />\n<meta property=\"og:title\" content=\"Teresa Johnsen - Green Hills AEA\" />\n<meta property=\"og:url\" content=\"https://www.ghaea.org/directory-listing/teresa-johnsen/\" />\n<meta property=\"og:site_name\" content=\"Green Hills AEA\" />\n<meta property=\"article:modified_time\" content=\"2024-07-15T14:39:35+00:00\" />\n<meta name=\"twitter:card\" content=\"summary_large_image\" />\n<script type=\"application/ld+json\" class=\"yoast-schema-graph\">{\"@context\":\"https://schema.org\",\"@graph\":[{\"@type\":\"WebPage\",\"@id\":\"https://www.ghaea.org/directory-listing/teresa-johnsen/\",\"url\":\"https://www.ghaea.org/directory-listing/teresa-johnsen/\",\"name\":\"Teresa Johnsen - Green Hills AEA\",\"isPartOf\":{\"@id\":\"https://www.ghaea.org/#website\"},\"datePublished\":\"2022-10-28T18:14:56+00:00\",\"dateModified\":\"2024-07-15T14:39:35+00:00\",\"breadcrumb\":{\"@id\":\"https://www.ghaea.org/directory-listing/teresa-johnsen/#breadcrumb\"},\"inLanguage\":\"en-US\",\"potentialAction\":[{\"@type\":\"ReadAction\",\"target\":[\"https://www.ghaea.org/directory-listing/teresa-johnsen/\"]}]},{\"@type\":\"BreadcrumbList\",\"@id\":\"https://www.ghaea.org/directory-listing/teresa-johnsen/#breadcrumb\",\"itemListElement\":[{\"@type\":\"ListItem\",\"position\":1,\"name\":\"Home\",\"item\":\"https://www.ghaea.org/\"},{\"@type\":\"ListItem\",\"position\":2,\"name\":\"Directory Listings\",\"item\":\"https://www.ghaea.org/directory-listing/\"},{\"@type\":\"ListItem\",\"position\":3,\"name\":\"Teresa Johnsen\"}]},{\"@type\":\"WebSite\",\"@id\":\"https://www.ghaea.org/#website\",\"url\":\"https://www.ghaea.org/\",\"name\":\"Green Hills AEA\",\"description\":\"Proud to be a part of Iowa’s Area Education Agencies\",\"publisher\":{\"@id\":\"https://www.ghaea.org/#organization\"},\"inLanguage\":\"en-US\"},{\"@type\":\"Organization\",\"@id\":\"https://www.ghaea.org/#organization\",\"name\":\"Green Hills AEA\",\"url\":\"https://www.ghaea.org/\",\"logo\":{\"@type\":\"ImageObject\",\"inLanguage\":\"en-US\",\"@id\":\"https://www.ghaea.org/#/schema/logo/image/\",\"url\":\"https://www.ghaea.org/app/uploads/sites/21/2021/05/logo-gh.png\",\"contentUrl\":\"https://www.ghaea.org/app/uploads/sites/21/2021/05/logo-gh.png\",\"width\":232,\"height\":91,\"caption\":\"Green Hills AEA\"},\"image\":{\"@id\":\"https://www.ghaea.org/#/schema/logo/image/\"}}]}</script>\n<!-- / Yoast SEO plugin. -->",
//   "yoast_head_json": {
//     "robots": {
//       "index": "index",
//       "follow": "follow",
//       "max-snippet": "max-snippet:-1",
//       "max-image-preview": "max-image-preview:large",
//       "max-video-preview": "max-video-preview:-1"
//     },
//     "canonical": "https://www.ghaea.org/directory-listing/teresa-johnsen/",
//     "og_locale": "en_US",
//     "og_type": "article",
//     "og_title": "Teresa Johnsen - Green Hills AEA",
//     "og_url": "https://www.ghaea.org/directory-listing/teresa-johnsen/",
//     "og_site_name": "Green Hills AEA",
//     "article_modified_time": "2024-07-15T14:39:35+00:00",
//     "twitter_card": "summary_large_image",
//     "schema": {
//       "@context": "https://schema.org",
//       "@graph": [
//         {
//           "@type": "WebPage",
//           "@id": "https://www.ghaea.org/directory-listing/teresa-johnsen/",
//           "url": "https://www.ghaea.org/directory-listing/teresa-johnsen/",
//           "name": "Teresa Johnsen - Green Hills AEA",
//           "isPartOf": {
//             "@id": "https://www.ghaea.org/#website"
//           },
//           "datePublished": "2022-10-28T18:14:56+00:00",
//           "dateModified": "2024-07-15T14:39:35+00:00",
//           "breadcrumb": {
//             "@id": "https://www.ghaea.org/directory-listing/teresa-johnsen/#breadcrumb"
//           },
//           "inLanguage": "en-US",
//           "potentialAction": [
//             {
//               "@type": "ReadAction",
//               "target": [
//                 "https://www.ghaea.org/directory-listing/teresa-johnsen/"
//               ]
//             }
//           ]
//         },
//         {
//           "@type": "BreadcrumbList",
//           "@id": "https://www.ghaea.org/directory-listing/teresa-johnsen/#breadcrumb",
//           "itemListElement": [
//             {
//               "@type": "ListItem",
//               "position": 1,
//               "name": "Home",
//               "item": "https://www.ghaea.org/"
//             },
//             {
//               "@type": "ListItem",
//               "position": 2,
//               "name": "Directory Listings",
//               "item": "https://www.ghaea.org/directory-listing/"
//             },
//             {
//               "@type": "ListItem",
//               "position": 3,
//               "name": "Teresa Johnsen"
//             }
//           ]
//         },
//         {
//           "@type": "WebSite",
//           "@id": "https://www.ghaea.org/#website",
//           "url": "https://www.ghaea.org/",
//           "name": "Green Hills AEA",
//           "description": "Proud to be a part of Iowa’s Area Education Agencies",
//           "publisher": {
//             "@id": "https://www.ghaea.org/#organization"
//           },
//           "inLanguage": "en-US"
//         },
//         {
//           "@type": "Organization",
//           "@id": "https://www.ghaea.org/#organization",
//           "name": "Green Hills AEA",
//           "url": "https://www.ghaea.org/",
//           "logo": {
//             "@type": "ImageObject",
//             "inLanguage": "en-US",
//             "@id": "https://www.ghaea.org/#/schema/logo/image/",
//             "url": "https://www.ghaea.org/app/uploads/sites/21/2021/05/logo-gh.png",
//             "contentUrl": "https://www.ghaea.org/app/uploads/sites/21/2021/05/logo-gh.png",
//             "width": 232,
//             "height": 91,
//             "caption": "Green Hills AEA"
//           },
//           "image": {
//             "@id": "https://www.ghaea.org/#/schema/logo/image/"
//           }
//         }
//       ]
//     }
//   },
//   "acf": {
//     "office": [
//       {
//         "term_id": 180,
//         "name": "Council Bluffs Office",
//         "slug": "council-bluffs-office",
//         "term_group": 0,
//         "term_taxonomy_id": 180,
//         "taxonomy": "office",
//         "description": "",
//         "parent": 0,
//         "count": 98,
//         "filter": "raw"
//       }
//     ],
//     "department": [
//       {
//         "term_id": 160,
//         "name": "Specialized Services and Supports",
//         "slug": "specialized-services-and-supports",
//         "term_group": 0,
//         "term_taxonomy_id": 160,
//         "taxonomy": "department",
//         "description": "",
//         "parent": 0,
//         "count": 197,
//         "filter": "raw"
//       }
//     ],
//     "position": false,
//     "phone_extension": "6420",
//     "phone_number": "712-366-0503 ext. 6420",
//     "fax_number": "712-527-5263",
//     "email": "tjohnsen@ghaea.org",
//     "first_name": "Teresa",
//     "last_name": "Johnsen",
//     "photo": {
//       "ID": 4601,
//       "id": 4601,
//       "title": "Teresa Johnsen",
//       "filename": "Teresa-Johnsen.png",
//       "filesize": 6647263,
//       "url": "https://www.ghaea.org/app/uploads/sites/21/2022/10/Teresa-Johnsen.png",
//       "link": "https://www.ghaea.org/directory-listing/teresa-johnsen/teresa-johnsen-3/",
//       "alt": "Teresa Johnsen",
//       "author": "2531",
//       "description": "",
//       "caption": "",
//       "name": "teresa-johnsen-3",
//       "status": "inherit",
//       "uploaded_to": 1239,
//       "date": "2023-07-05 16:20:47",
//       "modified": "2023-07-05 16:20:47",
//       "menu_order": 0,
//       "mime_type": "image/png",
//       "type": "image",
//       "subtype": "png",
//       "icon": "https://www.ghaea.org/wp/wp-includes/images/media/default.png",
//       "width": 1828,
//       "height": 2512,
//       "sizes": {
//         "thumbnail": "https://www.ghaea.org/app/uploads/sites/21/2022/10/Teresa-Johnsen-150x150.png",
//         "thumbnail-width": 150,
//         "thumbnail-height": 150,
//         "medium": "https://www.ghaea.org/app/uploads/sites/21/2022/10/Teresa-Johnsen-218x300.png",
//         "medium-width": 218,
//         "medium-height": 300,
//         "medium_large": "https://www.ghaea.org/app/uploads/sites/21/2022/10/Teresa-Johnsen-768x1055.png",
//         "medium_large-width": 620,
//         "medium_large-height": 852,
//         "large": "https://www.ghaea.org/app/uploads/sites/21/2022/10/Teresa-Johnsen-745x1024.png",
//         "large-width": 620,
//         "large-height": 852,
//         "1536x1536": "https://www.ghaea.org/app/uploads/sites/21/2022/10/Teresa-Johnsen-1118x1536.png",
//         "1536x1536-width": 620,
//         "1536x1536-height": 852,
//         "2048x2048": "https://www.ghaea.org/app/uploads/sites/21/2022/10/Teresa-Johnsen-1490x2048.png",
//         "2048x2048-width": 620,
//         "2048x2048-height": 852
//       }
//     },
//     "fax": "712-527-5263",
//     "job_classification": "Certified",
//     "job_level": "",
//     "expertise": "",
//     "assignments": [
//       {
//         "job_title": {
//           "term_id": 171,
//           "name": "Speech-Language Pathologist"
//         },
//         "district": [
//           {
//             "term_id": 61,
//             "name": "Council Bluffs"
//           }
//         ],
//         "building": [
//           {
//             "term_id": 76,
//             "name": "Council Bluffs Kirn Middle (6-8)"
//           }
//         ]
//       },
//       {
//         "job_title": {
//           "term_id": 492,
//           "name": "Consultant, Integrated Support: Assistive Technology"
//         },
//         "district": [
//           {
//             "term_id": 386,
//             "name": "Agency Wide"
//           }
//         ]
//       }
//     ]
//   },
//   "permalink": "https://www.ghaea.org/directory-listing/teresa-johnsen/",
//   "featured_image": null,
//   "email": "mailto:tjohnsen@ghaea.org",
//   "_links": {
//     "self": [
//       {
//         "href": "https://www.ghaea.org/wp-json/wp/v2/directory/1239"
//       }
//     ],
//     "collection": [
//       {
//         "href": "https://www.ghaea.org/wp-json/wp/v2/directory"
//       }
//     ],
//     "about": [
//       {
//         "href": "https://www.ghaea.org/wp-json/wp/v2/types/directory"
//       }
//     ],
//     "wp:attachment": [
//       {
//         "href": "https://www.ghaea.org/wp-json/wp/v2/media?parent=1239"
//       }
//     ],
//     "wp:term": [
//       {
//         "taxonomy": "department",
//         "embeddable": true,
//         "href": "https://www.ghaea.org/wp-json/wp/v2/departments?post=1239"
//       },
//       {
//         "taxonomy": "district",
//         "embeddable": true,
//         "href": "https://www.ghaea.org/wp-json/wp/v2/districts?post=1239"
//       },
//       {
//         "taxonomy": "building",
//         "embeddable": true,
//         "href": "https://www.ghaea.org/wp-json/wp/v2/buildings?post=1239"
//       },
//       {
//         "taxonomy": "expertise",
//         "embeddable": true,
//         "href": "https://www.ghaea.org/wp-json/wp/v2/expertises?post=1239"
//       },
//       {
//         "taxonomy": "position",
//         "embeddable": true,
//         "href": "https://www.ghaea.org/wp-json/wp/v2/positions?post=1239"
//       },
//       {
//         "taxonomy": "title",
//         "embeddable": true,
//         "href": "https://www.ghaea.org/wp-json/wp/v2/titles?post=1239"
//       },
//       {
//         "taxonomy": "office",
//         "embeddable": true,
//         "href": "https://www.ghaea.org/wp-json/wp/v2/offices?post=1239"
//       }
//     ],
//     "curies": [
//       {
//         "name": "wp",
//         "href": "https://api.w.org/{rel}",
//         "templated": true
//       }
//     ]
//   }
// }