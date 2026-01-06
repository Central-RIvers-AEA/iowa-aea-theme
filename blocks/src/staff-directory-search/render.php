<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$context = [
  'staff' => [],
  'staffEndpoint' => '/wp-json/staff-directory/v1/employees',
  'searchablesEndpoint' => '/wp-json/staff-directory/v1/searchables',
  'districts' => [],
  'buildings' => [],
  'contentAreas' => [],
  'positions' => [],
  'loading' => true,
];

$context['positions'] = StaffDirectory::get_positions();
$context['contentAreas'] = StaffDirectory::get_content_areas();
$context['districts'] = StaffDirectory::get_districts();
$context['buildings'] = StaffDirectory::get_buildings();

$staff = [];

$context['staff'] = $staff;

?>

<div
  <?php echo get_block_wrapper_attributes(); ?>
  data-wp-interactive="iowa-aea-theme/staff-directory-search"
  <?php echo wp_interactivity_data_wp_context( $context ); ?>
  aria-live='polite'
  data-wp-watch="callbacks.renderStaffList"
  data-wp-init="callbacks.loadStaffData"
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

    <div style='display: flex; gap: 1rem; margin-top: 1rem;'>
      <div class='wp-block-button is-style-aea-styled-button'>
        <button type='submit' class='staff-directory-search-btn staff-directory-search-submit wp-block-button__link wp-element-button'>Submit</button>
      </div>
      <div class='wp-block-button is-style-aea-styled-button'>
        <button type='button' class='staff-directory-search-btn staff-directory-search-reset wp-block-button__link wp-element-button' data-wp-on--click='actions.formReset'>Reset</button>
      </div>
    </div>
</form>

  <div class='staff-directory-results' data-wp-init='callbacks.initialStaff'>
    <ul aria-live='polite'></ul>
    <div class='staff-directory-search-spinner' data-wp-class--hidden="!context.loading">
      <span class='spinner'>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle fill="var(--wp--preset--color--primary)" stroke="var(--wp--preset--color--primary)" stroke-width="15" r="15" cx="40" cy="65"><animate attributeName="cy" calcMode="spline" dur="2" values="65;135;65;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4"></animate></circle><circle fill="var(--wp--preset--color--primary)" stroke="var(--wp--preset--color--primary)" stroke-width="15" r="15" cx="100" cy="65"><animate attributeName="cy" calcMode="spline" dur="2" values="65;135;65;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2"></animate></circle><circle fill="var(--wp--preset--color--primary)" stroke="var(--wp--preset--color--primary)" stroke-width="15" r="15" cx="160" cy="65"><animate attributeName="cy" calcMode="spline" dur="2" values="65;135;65;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0"></animate></circle></svg>
      </span>
    </div>
  </div>
</div>