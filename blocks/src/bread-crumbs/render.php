<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
function get_breadcrumb_trail() {
    $breadcrumbs = array();
    
    // Add home page
    $breadcrumbs[] = array(
        'title' => 'Home',
        'url' => home_url('/')
    );
    
    // Get current post
    $current_post = get_post();
    
    if ($current_post && $current_post->post_parent) {
        // Get all ancestors
        $ancestors = get_post_ancestors($current_post->ID);
        $ancestors = array_reverse($ancestors);
        
        // Add each ancestor to breadcrumbs
        foreach ($ancestors as $ancestor_id) {
            $breadcrumbs[] = array(
                'title' => get_the_title($ancestor_id),
                'url' => get_permalink($ancestor_id)
            );
        }
    }
    
    // Add current page (without link)
    if ($current_post) {
        $breadcrumbs[] = array(
            'title' => get_the_title($current_post->ID),
            'url' => null // No link for current page
        );
    }
    
    return $breadcrumbs;
}

$breadcrumbs = get_breadcrumb_trail();
?>

<div <?php echo get_block_wrapper_attributes(); ?>>
    <nav aria-label="Breadcrumb">
        <ol class="breadcrumb">
            <?php foreach ($breadcrumbs as $index => $crumb): ?>
                <li class="breadcrumb-item<?php echo ($crumb['url'] === null) ? ' active' : ''; ?>">
                    <?php if ($crumb['url']): ?>
                        <a href="<?php echo esc_url($crumb['url']); ?>">
                            <?php echo esc_html($crumb['title']); ?>
                        </a>
                    <?php else: ?>
                        <?php echo esc_html($crumb['title']); ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </nav>
</div>