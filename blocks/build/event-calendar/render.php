<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$context = [
  'today' => date( 'Y-m-d' ),
  'google_calendar_ids' => get_option('google_calendar_ids', array()),
  'google_calendar_api_key' => get_option('google_calendar_api_key', '')
];

?>

<div
  <?php echo get_block_wrapper_attributes(); ?>
  data-wp-interactive="iowa-aea-theme/events-calendar"
  <?php echo wp_interactivity_data_wp_context( $context ); ?>
  aria-live='polite'
>
  <div class='event-calendar-list' data-wp-watch="actions.loadEvents">
    <div class="event-calendar-list-item">Loading Events...</div>
  </div>
  <div class='event-calendar'>
    <div class="event-calendar-header">
      <button data-wp-on--click='actions.previousMonth'>Previous</button>
      <h3>Loading Calendar...</h3>
      <button data-wp-on--click='actions.nextMonth'>Next</button>
    </div>
    <a href='/events' class='event-calendar-view-all'>View All Events</a>
    <div class="event-calendar-days"></div>
  </div>
</div>