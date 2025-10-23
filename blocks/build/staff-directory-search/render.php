<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$context = [
  'staff' => [],
  'staffEndpoint' => '/wp-json/staff-directory/v1/employees',
  'districts' => [],
  'buildings' => [],
  'contentAreas' => [],
  'positions' => []
];

$context['positions'] = StaffDirectory::get_positions();
$context['contentAreas'] = StaffDirectory::get_content_areas();

$employees = get_posts([
  'post_type' => 'employee',
  'numberposts' => 10,
  'orderby' => 'title',
  'order' => 'ASC'
]);

$staff = [];

foreach($employees as $employee) {
  $staff[] = StaffDirectory::format_employee_data($employee);
}

// Districts
$districts = get_posts([
  'post_type' => 'district',
  'numberposts' => -1,
  'orderby' => 'title',
  'order' => 'ASC'
]);

$context['districts'] = array_map(function ( $district ) {
  return [
    'id' => $district->ID,
    'name' => $district->post_title
  ];
}, $districts);

// Buildings with Districts
$buildings = get_posts([
  'post_type' => 'school',
  'numberposts' => -1,
  'orderby' => 'title',
  'order' => 'ASC'
]);

$context['buildings'] = array_map(function ( $building ) {
  return [
    'id' => $building->ID,
    'name' => $building->post_title,
    'district_id' => get_post_meta( $building->ID, 'district', true )
  ];
}, $buildings);

$context['staff'] = $staff;

?>

<div
  <?php echo get_block_wrapper_attributes(); ?>
  data-wp-interactive="iowa-aea-theme/staff-directory-search"
  <?php echo wp_interactivity_data_wp_context( $context ); ?>
  aria-live='polite'
  data-wp-watch="callbacks.renderStaffList"
>
  <form class='staff-directory-search' data-wp-on--submit='actions.searchStaff' data-wp-init='callbacks.fillFormOptions'>
    <div class='staff-directory-search-input'>
      <label for='staff-name'>Name</label>
      <input type='text' id='staff-name' placeholder='Search staff...' name='staff-name' />
    </div>

    <div class='staff-directory-search-input'>
      <label for='school-district'>School District</label>
      <select id='school-district' name='school-district' data-wp-on--change='actions.filterBuildings'>
        <option value=''>Select a School District...</option>
      </select>
    </div>

    <div class='staff-directory-search-input'>
      <label for='school-building'>School Building</label>
      <select id='school-building' name='school-building' disabled>
        <option value=''>Select a District to view Buildings</option>
      </select>
    </div>

    <div class='staff-directory-search-input'>
      <label for='content-area'>Content Area</label>
      <select id='content-area' name='content-area'>
        <option value=''>Select a Content Area...</option>
      </select>
    </div>

    <div class='staff-directory-search-input'>
      <label for='position'>Position</label>
      <select id='position' name='position'>
        <option value=''>Select a Position...</option>
      </select>
    </div>

    <button type='submit' class='staff-directory-search-btn staff-directory-search-submit'>Submit</button>
    <button type='button' class='staff-directory-search-btn staff-directory-search-reset'>Reset</button>
</form>

  <div class='staff-directory-results' data-wp-init='callbacks.initialStaff'>
    <ul></ul>
  </div>
</div>