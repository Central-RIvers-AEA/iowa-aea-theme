<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

  $context = [
    'apiKey' => get_option('google_calendar_api_key', ''),
    'calendarIds' => get_option('google_calendar_ids', array()),
    'today' => date( 'Y-m-d' ), 
    'visible-events' => 3 
  ];

?>

<div
  <?php echo get_block_wrapper_attributes(); ?>
  data-wp-interactive="iowa-aea-theme/events-list"
  <?php echo wp_interactivity_data_wp_context( $context ); ?>
  aria-live='polite'
>
  <ul class='events-list' data-wp-init="actions.loadEvents"></ul>
  <button class='btn-control load-previous' data-wp-on--click="callbacks.scrollBackEvents" disabled=true aria-label='Show Previous Event'>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
    </svg>
  </button>
  <button class='btn-control load-next' data-wp-on--click="callbacks.scrollEvents" aria-label='Show Next Event'>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
    </svg>
  </button>
</div>