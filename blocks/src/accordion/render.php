<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

	$context = array("attributes" => $attributes);

?>
<div <?php echo get_block_wrapper_attributes(); ?> >
	<?php foreach ( $context['attributes']['sections'] as $section ) : ?>
		<div class="accordion-section">
			<h3><?php echo esc_html( $section['title'] ); ?></h3>
			<p><?php echo esc_html( $section['content'] ); ?></p>
		</div>
	<?php endforeach; ?>
</div>
