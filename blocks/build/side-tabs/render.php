<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$context = array("attributes" => $attributes);

?>
<div <?php echo get_block_wrapper_attributes(); ?> <?php echo wp_interactivity_data_wp_context($context) ?>>
	Hallo
	<?php if (!empty($attributes['titleOne'])): ?>
		<h3><?php echo wp_kses_post($attributes['titleOne']); ?></h3>
	<?php endif; ?>
	
	<?php if (!empty($attributes['tabContentOne'])): ?>
		<div class="tab-content"><?php echo wp_kses_post($attributes['tabContentOne']); ?></div>
	<?php endif; ?>
</div>
