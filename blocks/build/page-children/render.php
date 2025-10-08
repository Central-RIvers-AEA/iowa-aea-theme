<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

function get_top_parent_id($post_id) {
	$ancestors = get_post_ancestors($post_id);
	if (!empty($ancestors)) {
		// Return the top-most ancestor (last in the array)
		return end($ancestors);
	}
	// If no ancestors, this is the top parent
	return $post_id;
}

function is_current_page_in_section($current_post_id, $top_parent_id) {
	// Check if current page is the top parent
	if ($current_post_id == $top_parent_id) {
		return true;
	}
	
	// Get all ancestors of current page
	$ancestors = get_post_ancestors($current_post_id);
	
	// Check if the top parent is in the ancestors
	return in_array($top_parent_id, $ancestors);
}

function has_current_page_in_children($children, $current_post_id) {
	foreach ($children as $child) {
		if ($child->ID == $current_post_id) {
			return true;
		}
	}
	return false;
}

function get_page_current_hierarchy($parent_id) {
	// Get direct children of the parent
	$children = get_children(array(
		'post_parent' => $parent_id,
		'post_type'   => 'page',
		'post_status' => 'publish',
		'orderby'     => 'menu_order',
		'order'       => 'ASC'
	));
	
	$hierarchy = array();
	
	foreach ($children as $child) {
		$child_data = array(
			'page' => $child,
			'children' => get_children(array(
				'post_parent' => $child->ID,
				'post_type'   => 'page',
				'post_status' => 'publish',
				'orderby'     => 'menu_order',
				'order'       => 'ASC'
			))
		);
		$hierarchy[] = $child_data;
	}
	
	return $hierarchy;
}

// Get the current post ID
$current_post_id = get_the_ID();

// Get the top-most parent
$top_parent_id = get_top_parent_id($current_post_id);

// Check if current page belongs to this section
$is_current_page_in_section = is_current_page_in_section($current_post_id, $top_parent_id);

// Only show navigation if current page is part of this section
if ($is_current_page_in_section) {
	// Get the page hierarchy starting from the top parent
	$page_hierarchy = get_page_current_hierarchy($top_parent_id);
} else {
	$page_hierarchy = null;
}

?>

<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php if ($page_hierarchy): ?>
			<nav class="page-hierarchy" aria-label="Page Navigation">
				<ul class="parent-pages">
					<?php foreach ($page_hierarchy as $parent_item): ?>
						<?php 
						// Check if current page is this parent or one of its children
						$is_current_parent = ($parent_item['page']->ID == $current_post_id);
						$has_current_child = has_current_page_in_children($parent_item['children'], $current_post_id);
						$should_be_open = $is_current_parent || $has_current_child;
						?>
						<li class="parent-page-item">
							<?php if ($parent_item['children']): ?>
								<div class='parent-dropdown<?php echo $should_be_open ? ' open' : ''; ?>'>
									<a href="<?php echo esc_url(get_permalink($parent_item['page']->ID)); ?>" 
										class="parent-page-link<?php echo $is_current_parent ? ' current-page' : ''; ?>">
										<?php echo esc_html($parent_item['page']->post_title); ?>
									</a>

									<button type='button'>
										<?php 
									    if($should_be_open) {
												echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
												<path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
												</svg>';
											} else {
												echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
												</svg>';
											}?></button>
								</div>
							<?php else: ?>
								<div class='parent-dropdown'>
									<a href="<?php echo esc_url(get_permalink($parent_item['page']->ID)); ?>" 
										class="parent-page-link<?php echo $is_current_parent ? ' current-page' : ''; ?>">
										<?php echo esc_html($parent_item['page']->post_title); ?>
									</a>
								</div>
							<?php endif; ?>
							<?php if ($parent_item['children']): ?>
								<ul class="child-pages">
									<?php foreach ($parent_item['children'] as $child): ?>
										<li class="child-page-item">
											<a href="<?php echo esc_url(get_permalink($child->ID)); ?>" 
												class="child-page-link<?php echo ($child->ID == $current_post_id) ? ' current-page' : ''; ?>">
												<?php echo esc_html($child->post_title); ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
	<?php else: ?>
		<?php if (!$is_current_page_in_section): ?>
			<p class="no-children">This page is not part of a navigation section.</p>
		<?php else: ?>
			<p class="no-children">No pages found in this section.</p>
		<?php endif; ?>
	<?php endif; ?>
</div>
