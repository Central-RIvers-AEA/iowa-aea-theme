<?php

function create_district_posttype(){
  register_post_type( 
    'district', 
    array(
      'label' => 'Districts',
      'labels' => array(
        'name' => 'Districts',
        'singular_name' => 'District',
        'add_new' => _x('Add New', 'District', 'textdomain'),
        'add_new_item' => 'Add New District',
        'edit_item' => 'Edit District',
        'new_item' => 'New District',
        'view_item' => 'View District',
        'not_found' => 'No districts found',
        'not_found_in_trash' => 'No districts found in Trash',
      ),
      'description' => 'Districts',
      'public' => true,
      'has_archive' => false,
      'show_in_rest' => true,
      'show_in_admin' => true,
      'show_in_menu' => 'edit.php?post_type=employee',
      'exclude_from_search' => true,
      'supports' => array('title'),
      'rewrite' => array('slug' => 'districts', 'with_front' => false)
    )
  );
}

add_action('init', 'create_district_posttype');


function create_school_posttype(){
  register_post_type( 
    'school', 
    array(
      'label' => 'Schools',
      'labels' => array(
        'name' => 'Schools',
        'singular_name' => 'School',
        'add_new' => _x('Add New', 'School', 'textdomain'),
        'add_new_item' => 'Add New School',
        'edit_item' => 'Edit School',
        'new_item' => 'New School',
        'view_item' => 'View School',
        'not_found' => 'No schools found',
        'not_found_in_trash' => 'No schools found in Trash',
      ),
      'public' => true,
      'has_archive' => false,
      'show_in_rest' => true,
      'show_in_admin' => false,
      'show_in_menu' => 'edit.php?post_type=employee',
      'supports' => array('title'),
      'rewrite' => array('slug' => 'schools', 'with_front' => false)
    )
  );
}

add_action('init', 'create_school_posttype');

// Adding Meta Section
add_action('add_meta_boxes_district', 'create_school_information_meta_box');
add_action('add_meta_boxes_school', 'create_school_information_meta_box');

function create_school_information_meta_box(){
  add_meta_box( 'school-information', 'School Information', 'school_info_meta_box', null, 'normal', 'high');
}

function get_aea_options() {
  $aeas = get_posts(array(
    'post_type' => 'aea',
    'numberposts' => -1,
    'post_status' => 'publish'
  ));

  $options = array();
  foreach ($aeas as $aea) {
    $options[$aea->ID] = $aea->post_title;
  }
  return $options;
}

function get_district_options() {
  $districts = get_posts(array(
    'post_type' => 'district',
    'numberposts' => -1,
    'post_status' => 'publish'
  ));

  $options = array();
  foreach ($districts as $district) {
    $options[$district->ID] = $district->post_title;
  }
  return $options;
}

function school_info_meta_box($post){
  global $post_type;
  wp_nonce_field( basename( __FILE__ ), 'school_directory_nonce' );

  sd_input_field($post, 'Address', 'address', 'text', true);
  sd_input_field($post, 'City, St Zip','city_state_zip', 'text', true, '', 'Eg. Cedar Falls, IA 50613');
  sd_input_field($post, 'Phone Number', 'phone_number', 'text', true, '', null, '555-555-5555');
  sd_input_field($post, 'Fax Number', 'fax_number', 'text', false, '', null, '555-555-5555');
  sd_input_field($post, 'Website', 'website', 'url');

  if($post_type == 'district'){
    sd_select_field($post, 'AEA', 'aea', array('' => 'Select an AEA') + get_aea_options());
  }

  if($post_type == 'school'){
    sd_select_field($post, 'District', 'district', array('' => 'Select a District') + get_district_options());
  }

  $building_levels = array(
    '1-PK' => 'Pre-Kindergarten School',
    '2-KS' => 'Kindergarten School',
    '3-PKEL' => 'Pre-Kindergarten/Elementary School',
    '4-PKEMS' => 'Pre-Kindergarten/Elementary/Middle School',
  );

  // if($post_type == 'school'){
  //   sd_select_field($post, 'Building Level', 'building_level', $building_levels, '', 'Select a building level', true);
  // }

  sd_multi_field($post, 'School Personnel', 'school_personnel', array('Name', 'Title', 'Email'), array('text', 'text', 'email'));

  if($post_type == 'district'){
    sd_input_field($post, 'Old Post Id', 'old_post_id', 'text', false);
  }
}

function sd_input_field($post, $label, $name, $type = 'text', $required = false, $default = '', $explanation = null, $placeholder = '', $include_label = true){
  $id = "sd_$name";
  $current_value = get_post_meta( $post->ID, $name, true ); 
  if($current_value == null){
    $current_value = $default;
  }
  $require = $required ? 'required' : '';
  echo "<div class='sd-input-group'>";
    if($include_label){
      echo "<div class='sd-label $require'>";
        echo "<label for=$id>$label</label>";
        if($explanation){
          echo "<p class='description'>$explanation</p>";
        }
      echo "</div>";
    }
    echo "<div class='sd-input'>";
      echo "<input type=$type id=$id name=$name value='$current_value' $require placeholder='$placeholder' />";
    echo "</div>";
  echo "</div>";
}

function sd_select_field($post, $label, $name, $options, $default = '', $prompt = '', $required = false){
  $id = "sd_$name";
  $current_value = get_post_meta( $post->ID, $name, true ) ? get_post_meta( $post->ID, $name, true ) : $default;
  $require = $required ? 'required' : '';
  echo "<div class='sd-input-group'>";
    echo "<div class='sd-label $require'>";
      echo "<label for=$id>$label</label>";
    echo "</div>";
    echo "<div class='sd-input'>";
      echo "<select id=$id name=$name $require>";
        echo "<option value=''>$prompt</option>";
        foreach($options as $key => $value){
          $selected = $current_value == $key ? 'selected=selected' : '';
          echo "<option value='$key' $selected>$value</option>";
        }
      echo "</select>";
    echo "</div>";
  echo "</div>";
}

function sd_multi_field($post, $label, $name, $headers, $column_types, $required = false, $explanation = null){
  $id = "sd_$name";
  $current_value = get_post_meta( $post->ID, $name, true ) ? get_post_meta( $post->ID, $name, true ): array();
  $require = $required ? 'required' : '';
  echo "<div class='sd-input-group sd-multi-field'>";
    echo "<div class='sd-label $require'>";
      echo "<label for=$id>$label</label>";
      if($explanation){
        echo "<p class='description'>$explanation</p>";
      }
    echo "</div>";
    echo "<div class='sd-input'>";
      echo "<table>";
        echo "<thead>";
          echo "<tr>";
            foreach($headers as $header){
              echo "<th>$header</th>";
            }
            echo "<th>Actions</th>";
          echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
          echo "<tr class='example-row'>";
          foreach($column_types as $key => $type){
            $name = strtolower($headers[$key]);
            echo "<td data-type=$type data-name=$name></td>";
          }
          echo '<td data-remove><button type="button" class="button button-danger remove-row" onclick="removeRow(event)">X</button></td>';
          echo "<tr>";
          foreach($current_value as $row_key => $row){
            echo "<tr>";
            foreach($column_types as $key => $type){
              $name = strtolower($headers[$key]);
              $field_name = str_replace(' ', '_', strtolower($label)) . "[$row_key][$name]";
              $value = $row[$name];

              echo "<td data-type=$type data-name=$name>
                <input type='$type' name='$field_name' value='$value' />
              </td>";
            }
            echo '<td data-remove><button type="button" class="button button-danger remove-row" onclick="removeRow(event)">X</button></td>';
            echo "<tr>";
          }
          echo "</tbody>";
      echo "</table>";
    echo "</div>";
    echo "<div class='sd-actions'>";
      echo "<button type='button' class='button button-primary' onclick=\"addMultiItem(event, '$label')\">Add $label</button>";
    echo "</div>";
  echo "</div>";
}

// enque js and css
add_action('admin_enqueue_scripts', 'sd_enqueue_admin_css_js');
function sd_enqueue_admin_css_js(){
  global $pagenow, $post_type;
  if(!in_array($post_type, array('district', 'school', 'aea')) || !in_array($pagenow, array('post.php', 'post-new.php'))){
    return;
  }

  wp_enqueue_script( 'sd-admin-js', get_stylesheet_directory_uri() . '/assets/js/school-directory-admin.js', array(), '1.1', true );
  wp_enqueue_style( 'sd-admin-css', get_stylesheet_directory_uri() . '/assets/css/school-directory-admin.css', array(), '1.0' );
}

add_action('wp_enqueue_scripts', 'sd_enqueue_front_css_js');
function sd_enqueue_front_css_js(){
  $args = array(
    'post_type' => 'district',
    'numberposts' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
  );

  $districts = get_posts($args);

  foreach($districts as $key => $district){
    $districts[$key]->school_personnel = get_post_meta( $district->ID, 'school_personnel', true );
    $districts[$key]->city_state_zip = get_post_meta( $district->ID, 'city_state_zip', true );
    $districts[$key]->link = get_post_permalink($district);
  }

  wp_enqueue_script( 'sd-front-js', plugin_dir_url(__FILE__) . '/school-directory-front.js', array(), '1.2', true );

  wp_localize_script( 'sd-front-js', 'sd_districts', $districts );

  wp_enqueue_style( 'sd-front-css', plugin_dir_url( __FILE__ ) . '/school-directory-front.css', array(), '1.1' );
}

// Handle Saving of District and School Information
function sd_handle_save($post_id){
  global $post;

  if(is_object($post) && !in_array($post->post_type, array('district', 'school')))
    return;

  if(!isset($_POST['school_directory_nonce'])) {
    return;
  }

  if(!wp_verify_nonce( $_POST['school_directory_nonce'], basename( __FILE__ ) )){ 
    return; 
  }

  $fields = array('address', 'city_state_zip', 'phone_number', 'website', 'building_level', 'unique_id', 'school_personnel', 'fax_number', 'aea', 'district');

  foreach($fields as $field){
    if(isset($_POST[$field]) && $_POST[$field] != ''){
      update_post_meta( $post_id, $field, $_POST[$field] );
    } else {
      delete_post_meta( $post_id, $field );
    }
  }
}

add_action('save_post_district', 'sd_handle_save', 10, 1);
add_action('save_post_school', 'sd_handle_save', 10, 1);

// Template
add_filter( 'theme_page_templates', 'sd_add_page_template_to_dropdown' );
function sd_add_page_template_to_dropdown( $templates ){
  $templates[plugin_dir_path( __FILE__ ) . 'templates/school-directory-template.php'] = __( 'School Directory Page', 'school-directory' );

  return $templates;
}

add_filter( 'template_include', 'sd_change_page_template', 99 );
function sd_change_page_template($template){
  global $post;

  
  if (is_page() && !is_front_page() && get_the_title( $post ) == 'School Directory') {
    $meta = get_post_meta(get_the_ID());

    if (!empty($meta['_wp_page_template'][0]) && $meta['_wp_page_template'][0] != $template) {
      $template = $meta['_wp_page_template'][0];
    }
  }

  return $template;
}

// Importing
function sd_add_district_import_page(){
  add_submenu_page(
    'edit.php?post_type=employee', 
    'district import', 
    'Import Districts', 
    'manage_options', 
    'district-import',
    'sd_district_import_page',
    10
  );
}

// TO REMOVE after upload
add_action('admin_menu', 'sd_add_district_import_page');

function sd_district_import_page(){
  ?>
      <h1>District Import</h1>
      <p>Use the following to import any new or updated districts information</p>
      <p>
        Your File should include the following headings:
        <ul>
          <li>old_post_id</li>
          <li>name</li>
          <li>address</li>
          <li>city_state_zip</li>
          <li>phone_number</li>
          <li>fax_number</li>
          <li>website</li>
          <li>personnel</li>
          <li>aea</li>
        </ul>
      </p>
      <p>If any doubt of missing info, export your list of districts first before importing them</p>
      <form class='form-table' role='presentation' method='post' action='<?= admin_url( 'admin-post.php' ); ?>' enctype='multipart/form-data'>
        <!-- action post -->
        <input type='hidden' name='action' value='import_districts' />
        <table>
          <tbody>
            <tr>
              <td><label>Import File</label></td>
              <td><input type='file' name='district_import_file' /></td>
            </tr>
            <tr>
              <td><button type='submit' class='button button-primary'> Run Import </button></td>
            </tr>
          </tbody>
        </table>
      </form>
    <?php
}

function sd_import_districts(){
  $post = $_POST;
  $extension = pathinfo($_FILES['district_import_file']['name'], PATHINFO_EXTENSION);

  if(!empty($_FILES['district_import_file']['name']) && $extension == 'csv'){
    $csvFile = fopen($_FILES['district_import_file']['tmp_name'], 'r');

    $headers = fgetcsv($csvFile); // Skipping header row

    $dataArray = array();

    while(($csvData = fgetcsv($csvFile)) !== FALSE){
      $csvData = array_map("utf8_encode", $csvData);
      $rowData = array();
      foreach($csvData as $key => $value){
        $rowData[strtolower($headers[$key])] = $value;
      }

      array_push($dataArray, $rowData);
    }
    
    foreach($dataArray as $row){
      $old_post_id = trim($row['old_post_id']);
      $name = trim($row['name']);
      $address = $row['address'];
      $city_state_zip = $row['city_state_zip'];
      $aea = $row['aea'];

      $phone_number = $row['phone_number'];
      $fax_number = $row['fax_number'];

      $website = $row['website'];
      $personnel = $row['personnel'];

      if(!empty($personnel)){
        $school_personnel = array();
        foreach(explode(';', $personnel) as $person){
          $id = gettimeofday()['sec'];
          $school_personnel[$id] = array();

          $person_split = explode('|', $person);

          $school_personnel[$id]['name'] = $person_split[0];
          $school_personnel[$id]['title'] = $person_split[1];
          $school_personnel[$id]['email'] = $person_split[2];
        }
      }
        
      $postArray = array(
        'post_title' => $name,
        'post_content' => '',
        'post_type' => 'district',
        'post_status' => 'publish',
        'meta_input' => array(
          'address' => $address,
          'city_state_zip' => $city_state_zip,
          'phone_number' => $phone_number,
          'fax_number' => $fax_number,
          'website' => $website,
          'school_personnel' => $school_personnel,
          'old_post_id' => $old_post_id,
          'aea' => $aea
        )
      );
      wp_insert_post( $postArray );
    }
    sd_add_flash_notice( 'Upload Complete', "info");
    wp_redirect( 'edit.php?post_type=employee&page=district-import', 301 );
  } else {
    sd_add_flash_notice( 'Incorrect File Type', "warning");
    wp_redirect( 'edit.php?post_type=employee&page=district-import', 301 );
  }
}

// TO REMOVE after upload
add_action('admin_post_import_districts', 'sd_import_districts');

function sd_add_school_import_page(){
  add_submenu_page(
    'edit.php?post_type=employee', 
    'school import', 
    'Import Schools', 
    'manage_options', 
    'school-import',
    'sd_school_import_page',
    15
  );
}

// TO REMOVE after upload
add_action('admin_menu', 'sd_add_school_import_page');

function sd_school_import_page(){
  ?>
    <h1>School Import</h1>
    <p>Use the following to import any new or updated districts information</p>
    <p>
      Your File should include the following headings:
      <ul>
        <li>district_post_id</li>
        <li>name</li>
        <li>address</li>
        <li>city_state_zip</li>
        <li>phone_number</li>
        <li>fax_number</li>
        <li>website</li>
        <li>personnel</li>
      </ul>
    </p>
    <p>If any doubt of missing info, export your list of schools first before importing them</p>
    <form class='form-table' role='presentation' method='post' action='<?= admin_url( 'admin-post.php' ); ?>' enctype='multipart/form-data'>
      <!-- action post -->
      <input type='hidden' name='action' value='import_schools' />
      <table>
        <tbody>
          <tr>
            <td><label>Import File</label></td>
            <td><input type='file' name='school_import_file' /></td>
          </tr>
          <tr>
            <td><button type='submit' class='button button-primary'> Run Import </button></td>
          </tr>
        </tbody>
      </table>
    </form>

    <script>
      const form = document.querySelector('.form-table')

      form.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('submitting stoed')
      })

    </script>
  <?php
}

function sd_import_schools(){
  $post = $_POST;
  $extension = pathinfo($_FILES['school_import_file']['name'], PATHINFO_EXTENSION);
  // echo 'hello';
  // echo var_dump($_FILES['school_import_file']);
  if(!empty($_FILES['school_import_file']['name']) && $extension == 'csv'){
    $csvFile = fopen($_FILES['school_import_file']['tmp_name'], 'r');

    $headers = fgetcsv($csvFile); // Skipping header row

    $dataArray = array();

    while(($csvData = fgetcsv($csvFile)) !== FALSE){
      $csvData = array_map("utf8_encode", $csvData);
      $rowData = array();
      foreach($csvData as $key => $value){
        $rowData[strtolower($headers[$key])] = $value;
      }

      array_push($dataArray, $rowData);
    }
    
    foreach($dataArray as $row){
      $district_post_id = trim($row['district_post_id']);
      $name = trim($row['name']);
      $address = $row['address'];
      $city_state_zip = $row['city_state_zip'];

      $phone_number = $row['phone_number'];
      $fax_number = $row['fax_number'];

      $website = $row['website'];
      $personnel = $row['personnel'];

      $school_personnel = array();
      foreach(explode(';', $personnel) as $person){
        $id = gettimeofday()['sec'];
        $school_personnel[$id] = array();

        $person_split = explode('|', $person);

        $school_personnel[$id]['name'] = $person_split[0];
        $school_personnel[$id]['title'] = $person_split[1];
        $school_personnel[$id]['email'] = $person_split[2];
      }
      
      $postArray = array(
        'post_title' => $name,
        'post_content' => '',
        'post_type' => 'school',
        'post_status' => 'publish',
        'meta_input' => array(
          'address' => $address,
          'city_state_zip' => $city_state_zip,
          'phone_number' => $phone_number,
          'fax_number' => $fax_number,
          'website' => $website,
          'school_personnel' => $school_personnel,
          'district' => $district_post_id
        )
      );
      
      wp_insert_post( $postArray );
    }
    sd_add_flash_notice( 'Upload Complete', "info");
    wp_redirect( 'edit.php?post_type=district&page=school-import', 301 );
  } else {
    sd_add_flash_notice( 'Incorrect File Type', "warning");
    wp_redirect( 'edit.php?post_type=district&page=school-import', 301 );
  }
}

// TO REMOVE after upload
// add_action('admin_post_import_schools', 'sd_import_schools');


function sd_add_flash_notice( $notice = "", $type = "warning", $dismissible = true ) {
  // Here we return the notices saved on our option, if there are not notices, then an empty array is returned
  $notices = get_option( "my_flash_notices", array() );

  $dismissible_text = ( $dismissible ) ? "is-dismissible" : "";

  // We add our new notice.
  array_push( $notices, array( 
          "notice" => $notice, 
          "type" => $type, 
          "dismissible" => $dismissible_text
      ) );

  // Then we update the option with our notices array
  update_option("my_flash_notices", $notices );
}

// showing single district page when in district

add_filter( 'single_template', 'sd_override_single_template' );
function sd_override_single_template( $single_template ){
    global $post;

    if($post->post_type == 'district'){
      $file = dirname(__FILE__) .'/templates/single-'. $post->post_type .'.php';
  
      if( file_exists( $file ) ) $single_template = $file;
    }

    return $single_template;
}

// Register distict and school export endpoints
add_action('rest_api_init', function(){
  register_rest_route( 'schooldirectory/v1', '/districts/export', array(
    'methods' => 'GET',
    'callback' => 'sd_export_district_info_json'
  ));

  register_rest_route( 'schooldirectory/v1', '/schools/export', array(
    'methods' => 'GET',
    'callback' => 'sd_export_school_info_json'
  ));
});

// School Directory District Export
function sd_export_district_info_json($data){
  $districts = get_posts(array(
    'post_type' => 'district',
    'numberposts' => '-1',
    'order' => 'asc',
    'orderby' => 'title'
  ));

  $districts_data = array();

  foreach($districts as $key => $district){
    $district_data = array();
    $district_data['post_id'] = $district->ID;
    $district_data['old_post_id'] = get_post_meta($district->ID, 'old_post_id', true);

    $personnel = get_post_meta($district->ID, 'school_personnel', true);

    $strung_personnel = array();
    foreach($personnel as $pkey => $person){
      $strung_personnel[] = $person['name'] . '|' . $person['title'] . '|' . $person['email'];
    }

    $district_data['title'] = $district->post_title;
    $district_data['address'] = get_post_meta($district->ID, 'address', true);
    $district_data['city_state_zip'] = get_post_meta($district->ID, 'city_state_zip', true);
    $district_data['phone_number'] = get_post_meta($district->ID, 'phone_number', true);
    $district_data['fax_number'] = get_post_meta($district->ID, 'fax_number', true);
    $district_data['website'] = get_post_meta($district->ID, 'website', true);
    $district_data['personnel'] = implode(';', $strung_personnel);
    

    $districts_data[] = $district_data;
  }

  return $districts_data;
}

// School Directory School Export
function sd_export_school_info_json(){
  $schools = get_posts(array(
    'post_type' => 'school',
    'numberposts' => '-1',
    'order' => 'asc',
    'orderby' => 'title'
  ));

  $schools_data = array();

  foreach($schools as $key => $school){
    $school_data = array();
    $school_data['post_id'] = $school->ID;

    $personnel = get_post_meta($school->ID, 'school_personnel', true);

    $strung_personnel = array();
    foreach($personnel as $pkey => $person){
      $strung_personnel[] = $person['name'] . '|' . $person['title'] . '|' . $person['email'];
    }

    

    $district = get_posts( array(
      'connected_type' => 'posts_to_pages',
      'connected_items' => $school,
      'nopaging' => true,
      'suppress_filters' => false
    ) )[0];
    
    if($district){
      $school_data['district_post_id'] = $district->ID;
    }

    $school_data['name'] = $school->post_title;
    $school_data['address'] = get_post_meta($school->ID, 'address', true);
    $school_data['city_state_zip'] = get_post_meta($school->ID, 'city_state_zip', true);
    $school_data['phone_number'] = get_post_meta($school->ID, 'phone_number', true);
    $school_data['fax_number'] = get_post_meta($school->ID, 'fax_number', true);
    $school_data['website'] = get_post_meta($school->ID, 'website', true);
    $school_data['personnel'] = implode(';', $strung_personnel);

    $schools_data[] = $school_data;
  }

  return $schools_data;
}


// Add Export buttons to post types
// Adds "Import" button on module list page
add_action('admin_footer-edit.php','sd_export_district_buttons');
function sd_export_district_buttons(){
  global $current_screen;

  // Not our post type, exit earlier
  // You can remove this if condition if you don't have any specific post type to restrict to. 
  if ('district' != $current_screen->post_type) {
      return;
  }

  ?>
      <script type="text/javascript">
          document.addEventListener('DOMContentLoaded', () => {
            const wpHeadingInline = document.querySelector('.wp-heading-inline')
            const exportLink = document.createElement('a')
            exportLink.innerText = 'Export'
            exportLink.classList.add('page-title-action')
            exportLink.onclick = function(e){
              e.preventDefault()
              getDistrictDataCreateCSV()
            }

            wpHeadingInline.after(exportLink)
          })

          function getDistrictDataCreateCSV(){
            fetch('<?php echo site_url() . '/wp-json/schooldirectory/v1/districts/export' ?>')
              .then(data => data.json())
              .then(jsonToCSV)
          }

          function jsonToCSV(data){
            const replacer = (key, value) => value === null ? '' : value // specify how you want to handle null values here
            const header = Object.keys(data[0])
            const csv = [
              header.join(','), // header row first
              ...data.map(row => header.map(fieldName => JSON.stringify(row[fieldName], replacer)).join(','))
            ].join('\r\n')

            let blob = new Blob([csv], {type: 'text/csv;charset=utf-8;'})
            let exportedFilename = 'districts-export.csv'
            if (navigator.msSaveBlob) { // IE 10+
              navigator.msSaveBlob(blob, exportedFilename);
            } else {
                var link = document.createElement("a");
                if (link.download !== undefined) { // feature detection
                    // Browsers that support HTML5 download attribute
                    var url = URL.createObjectURL(blob);
                    link.setAttribute("href", url);
                    link.setAttribute("download", exportedFilename);
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            }
          }
      </script>
  <?php
}

add_action('admin_footer-edit.php','sd_export_schools_button');
function sd_export_schools_button(){
  global $current_screen;

  // Not our post type, exit earlier
  // You can remove this if condition if you don't have any specific post type to restrict to. 
  if ('school' != $current_screen->post_type) {
      return;
  }

  ?>
      <script type="text/javascript">
          document.addEventListener('DOMContentLoaded', () => {
            const wpHeadingInline = document.querySelector('.wp-heading-inline')
            const exportLink = document.createElement('a')
            exportLink.innerText = 'Export'
            exportLink.classList.add('page-title-action')
            exportLink.onclick = function(e){
              e.preventDefault()
              getSchoolsDataCreateCSV()
            }

            wpHeadingInline.after(exportLink)
          })

          function getSchoolsDataCreateCSV(){
            fetch('<?php echo site_url() . '/wp-json/schooldirectory/v1/schools/export' ?>')
              .then(data => data.json())
              .then(jsonToCSV)
          }

          function jsonToCSV(data){
            const replacer = (key, value) => value === null ? '' : value // specify how you want to handle null values here
            const header = Object.keys(data[0])
            const csv = [
              header.join(','), // header row first
              ...data.map(row => header.map(fieldName => JSON.stringify(row[fieldName], replacer)).join(','))
            ].join('\r\n')

            let blob = new Blob([csv], {type: 'text/csv;charset=utf-8;'})
            let exportedFilename = 'schools-export.csv'
            if (navigator.msSaveBlob) { // IE 10+
              navigator.msSaveBlob(blob, exportedFilename);
            } else {
                var link = document.createElement("a");
                if (link.download !== undefined) { // feature detection
                    // Browsers that support HTML5 download attribute
                    var url = URL.createObjectURL(blob);
                    link.setAttribute("href", url);
                    link.setAttribute("download", exportedFilename);
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            }
          }
      </script>
  <?php
}


add_filter('manage_district_posts_columns', 'add_aea_column_to_districts');

function add_aea_column_to_districts($columns) {
    // Insert the AEA column after the title column
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['aea'] = 'AEA';
        }
    }
    return $new_columns;
}

add_action('manage_district_posts_custom_column', 'display_aea_column_content', 10, 2);

function display_aea_column_content($column, $post_id) {
    if ($column === 'aea') {
        $aea_id = get_post_meta($post_id, 'aea', true);
        
        if ($aea_id) {
            $aea_post = get_post($aea_id);
            if ($aea_post) {
                $edit_link = get_edit_post_link($aea_id);
                echo '<a href="' . esc_url($edit_link) . '">' . esc_html($aea_post->post_title) . '</a>';
            } else {
                echo '—'; // Em dash for empty/invalid AEA
            }
        } else {
            echo '—'; // Em dash for no AEA assigned
        }
    }
}

add_filter('manage_edit-district_sortable_columns', 'make_aea_column_sortable');

function make_aea_column_sortable($columns) {
    $columns['aea'] = 'aea';
    return $columns;
}

add_action('pre_get_posts', 'handle_aea_column_sorting');

function handle_aea_column_sorting($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->get('orderby') === 'aea') {
        $query->set('meta_key', 'aea');
        $query->set('orderby', 'meta_value');
    }
}

add_action('restrict_manage_posts', 'add_aea_filter_to_districts');

function add_aea_filter_to_districts() {
    global $typenow;
    
    // Only show on the district post type admin page
    if ($typenow !== 'district') {
        return;
    }
    
    // Get all AEAs for the dropdown
    $aeas = get_posts(array(
        'post_type' => 'aea',
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    
    // Get the current filter value
    $selected_aea = isset($_GET['filter_aea']) ? $_GET['filter_aea'] : '';
    
    echo '<select name="filter_aea" id="filter_aea">';
    echo '<option value="">All AEAs</option>';
    
    foreach ($aeas as $aea) {
        printf(
            '<option value="%s"%s>%s</option>',
            $aea->ID,
            selected($selected_aea, $aea->ID, false),
            esc_html($aea->post_title)
        );
    }
    
    echo '</select>';
}

add_action('pre_get_posts', 'filter_districts_by_aea');

function filter_districts_by_aea($query) {
    global $pagenow, $typenow;
    
    // Only apply on the admin districts list page
    if (!is_admin() || $pagenow !== 'edit.php' || $typenow !== 'district' || !$query->is_main_query()) {
        return;
    }
    
    // Check if AEA filter is set
    if (isset($_GET['filter_aea']) && !empty($_GET['filter_aea'])) {
        $query->set('meta_key', 'aea');
        $query->set('meta_value', $_GET['filter_aea']);
    }
}

add_action('restrict_manage_posts', 'add_clear_aea_filter_link');

function add_clear_aea_filter_link() {
    global $typenow;
    
    if ($typenow !== 'district') {
        return;
    }
    
    if (isset($_GET['filter_aea']) && !empty($_GET['filter_aea'])) {
        $clear_url = remove_query_arg('filter_aea');
        echo '<a href="' . esc_url($clear_url) . '" class="button" style="margin-left: 10px;">Clear AEA Filter</a>';
    }
}

add_action('rest_api_init', function(){
  $meta_fields = array(
    'address' => 'District address',
    'city_state_zip' => 'City, State, ZIP',
    'phone_number' => 'Phone number',
    'fax_number' => 'Fax number',
    'website' => 'Website URL',
    'aea' => 'AEA'
  );

  foreach($meta_fields as $field_name => $description) {
    register_rest_field('district', $field_name, array(
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

// Increase the per_page limit for districts specifically
add_filter('rest_district_collection_params', function($params) {
  $params['per_page']['maximum'] = 500; // Set your desired maximum
  return $params;
});