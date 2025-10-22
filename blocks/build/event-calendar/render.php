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
>
  <section class='event-calendar-list' data-wp-watch="actions.loadEvents" aria-live='polite' aria-label='Upcoming Events'>
    <div class="event-calendar-list-item">Loading Events...</div>
  </section>
  <section class='event-calendar' aria-label='Calendar Navigation'>
    <header class="event-calendar-header">
      <button data-wp-on--click='actions.previousMonth' 
              aria-label='View previous month' 
              type='button'>Previous</button>
      <h3 id='calendar-month-year'>Loading Calendar...</h3>
      <button data-wp-on--click='actions.nextMonth' 
              aria-label='View next month' 
              type='button'>Next</button>
    </header>
    <a href='/events' class='event-calendar-view-all' aria-label='View all events on separate page'>View All Events</a>
    <div class="event-calendar-days" role='grid' aria-labelledby='calendar-month-year'></div>
  </section>
</div>