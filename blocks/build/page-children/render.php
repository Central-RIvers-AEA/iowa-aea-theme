<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

if(!function_exists('get_top_parent_id')){
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
				if ($child['page']->ID == $current_post_id) {
						return true;
				}
				// Recursively check grandchildren
				if (!empty($child['children']) && has_current_page_in_children($child['children'], $current_post_id)) {
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
			'orderby'     => 'title',
			'order'       => 'ASC'
		));
		
		$hierarchy = array();
		
		foreach ($children as $child) {
        $hierarchy[] = array(
            'page'     => $child,
            'children' => get_page_current_hierarchy($child->ID) // 👈 recursive call
        );
    }
    
		return $hierarchy;
	}

	function render_page_hierarchy($items, $current_post_id, $depth = 0) {
		if (empty($items)) return;
		$ul_class = $depth === 0 ? 'parent-pages' : 'child-pages';
		echo '<ul class="' . esc_attr($ul_class) . '">';
		foreach ($items as $item) {
			$page           = $item['page'];
			$children       = $item['children'];
			$is_current     = ($page->ID == $current_post_id);
			$has_current    = has_current_page_in_children($children, $current_post_id);
			$should_be_open = $is_current || $has_current;
			$li_class       = $depth === 0 ? 'parent-page-item' : 'child-page-item';
			$a_class        = $depth === 0 ? 'parent-page-link' : 'child-page-link';

			echo '<li class="' . esc_attr($li_class) . '">';

			if (!empty($children)) {
				echo '<div class="parent-dropdown' . ($should_be_open ? ' open' : '') . '">';
			} else {
				echo '<div class="parent-dropdown">';
			}

			echo '<a href="' . esc_url(get_permalink($page->ID)) . '" class="' . esc_attr($a_class) . ($is_current ? ' current-page' : '') . '">'
					. esc_html($page->post_title) . '</a>';

			if (!empty($children)) {
				if ($should_be_open) {
					echo '<button type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/></svg></button>';
				} else {
					echo '<button type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/></svg></button>';
				}
			}

			echo '</div>';

			if (!empty($children)) {
				render_page_hierarchy($children, $current_post_id, $depth + 1);
			}

			echo '</li>';
		}
		echo '</ul>';
	}
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
				<?php render_page_hierarchy($page_hierarchy, $current_post_id); ?>
		</nav>
	<?php else: ?>
		<?php if (!$is_current_page_in_section): ?>
			<p class="no-children">This page is not part of a navigation section.</p>
		<?php else: ?>
			<p class="no-children">No pages found in this section.</p>
		<?php endif; ?>
	<?php endif; ?>
</div>
