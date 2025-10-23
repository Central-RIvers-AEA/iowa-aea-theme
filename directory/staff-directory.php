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
  }

  // import employees page
  public function import_employees_page()
  {
    add_submenu_page(
      'edit.php?post_type=employee',
      'Import Employees',
      'Import Employees',
      'manage_options',
      'import-employees',
      array($this, 'import_employees_page_callback')
    );

    // add_menu_page(
    //   'Import Employees',
    //   'Import Employees',
    //   'manage_options',
    //   'import-employees',
    //   array($this, 'import_employees_page_callback'),
    //   'dashicons-upload',
    //   20
    // );
  }

  /* callback for import employees page */
  public function import_employees_page_callback()
  {
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
  public function register_employee_post_type()
  {
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
  public function employee_meta_boxes()
  {
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

  public function employee_districts_callback($post)
  {
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

  public function enqueue_assignment_script()
  {
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
  public function save_employee_details($post_id)
  {
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

  public function directory_filter()
  {
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

  public function import_employees()
  {
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
   * Helper method for IP range checking (for Option 6)
   */
  private function ip_in_range($ip, $allowed_ranges) {
    foreach ($allowed_ranges as $range) {
      if (strpos($range, '/') !== false) {
        // CIDR notation
        list($subnet, $mask) = explode('/', $range);
        if ((ip2long($ip) & ~((1 << (32 - $mask)) - 1)) == ip2long($subnet)) {
          return true;
        }
      } else {
        // Single IP
        if ($ip === $range) {
          return true;
        }
      }
    }
    return false;
  }

  /**
   * REST API callback to get all employees
   */
  public function get_employees_rest($request) {
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
