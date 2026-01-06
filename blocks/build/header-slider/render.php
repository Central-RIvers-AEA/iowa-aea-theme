<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$context = [
   "slides" => [],
];

$inner_blocks = $block->parsed_block['innerBlocks'] ?? array();

foreach ($inner_blocks as $inner_block) {
    $context['slides'][] = array(
        'title' => $inner_block['attrs']['title'] ?? '',
        'image' => $inner_block['attrs']['image'] ?? '',
        'content' => $inner_block['attrs']['content'] ?? '',
        'buttonText' => $inner_block['attrs']['buttonText'] ?? '',
        'buttonUrl' => $inner_block['attrs']['buttonUrl'] ?? '',
        'slideLabel' => $inner_block['attrs']['slide_label'] ?? '',
        // Add other attributes you need
    );
}

?>

<div
  <?php echo get_block_wrapper_attributes(); ?>
  data-wp-interactive="iowa-aea-theme/header-slider"
  <?php echo wp_interactivity_data_wp_context( $context ); ?>
  aria-live='polite'
  data-wp-init='init.setup'
>
</div>