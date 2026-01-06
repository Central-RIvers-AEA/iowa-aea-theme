<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$context = array("attributes" => $attributes);
?>

<div
  <?php echo get_block_wrapper_attributes(); ?>
  data-wp-interactive="iowa-aea-theme/header-slide"
  <?php echo wp_interactivity_data_wp_context( $context ); ?>
  aria-live='polite'
  data-wp-init='init.setup'
>
</div>