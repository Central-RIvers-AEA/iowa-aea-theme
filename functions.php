<?php
/** Functions for custom theme */

add_action( 'wp_enqueue_scripts', 'iowa_aea_child_theme_enqueue_styles' );
function iowa_aea_child_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'), wp_get_theme()->get('Version') );
}

add_action('wp_head', 'iowa_aea_child_theme_fonts');
function iowa_aea_child_theme_fonts() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <?php
}

// Add editor styles to make block editor match frontend
add_action( 'after_setup_theme', 'iowa_aea_editor_styles' );
function iowa_aea_editor_styles() {
    // Add support for editor styles
    add_theme_support( 'editor-styles' );
    
    // Enqueue editor styles
    add_editor_style( 'editor-style.css' );
    
    // Add Open Sans to editor font sizes
    add_theme_support( 'editor-font-sizes', array(
        array(
            'name' => 'Small',
            'size' => 14,
            'slug' => 'small'
        ),
        array(
            'name' => 'Normal',
            'size' => 16,
            'slug' => 'normal'
        ),
        array(
            'name' => 'Medium',
            'size' => 20,
            'slug' => 'medium'
        ),
        array(
            'name' => 'Large',
            'size' => 24,
            'slug' => 'large'
        ),
        array(
            'name' => 'Extra Large',
            'size' => 32,
            'slug' => 'extra-large'
        )
    ));
}

// Enqueue fonts for the block editor
add_action( 'enqueue_block_editor_assets', 'iowa_aea_editor_fonts' );
function iowa_aea_editor_fonts() {
    wp_enqueue_style( 
        'iowa-aea-editor-fonts', 
        'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap',
        array(),
        null
    );
}

// Register custom table block styles
add_action( 'init', 'iowa_aea_register_block_styles' );
function iowa_aea_register_block_styles() {
    // Register custom table style
    register_block_style(
        'core/table',
        array(
            'name'  => 'aea-styled-table',
            'label' => 'AEA Styled Table',
        )
    );

    // Register custom button style
    register_block_style(
        'core/button',
        array(
            'name'  => 'alt-one-button',
            'label' => 'Alt One Button',
        )
    );
    register_block_style(
        'core/button',
        array(
            'name'  => 'alt-two-button',
            'label' => 'Alt Two Button',
        )
    );
    register_block_style(
        'core/button',
        array(
            'name'  => 'alt-three-button',
            'label' => 'Alt Three Button',
        )
    );
    register_block_style(
        'core/button',
        array(
            'name'  => 'alt-four-button',
            'label' => 'Alt Four Button',
        )
    );
}

// Hide unwanted templates from Site Editor
add_filter( 'get_block_templates', 'hide_unwanted_block_templates', 10, 3 );
function hide_unwanted_block_templates( $query_result, $query, $template_type ) {
    // Only filter templates, not template parts
    if ( $template_type !== 'wp_template' ) {
        return $query_result;
    }
    
    // Templates to hide from Site Editor
    $templates_to_hide = array(
        'archive',           // Archive template
        'category',          // Category template
        'tag',              // Tag template
        'author',           // Author template
        'date',             // Date template
        'search',           // Search results template
        'single',           // Single post template
        '404',              // 404 error template
        'front-page',       // Front page template
        'home',             // Blog home template
        'privacy-policy',   // Privacy policy template
        'singular',         // Singular template
        'attachment'        // Attachment template
        // Note: 'page' template is NOT hidden so it appears in the page editor
    );
    
    // Filter out unwanted templates
    foreach ( $query_result as $key => $template ) {
        if ( in_array( $template->slug, $templates_to_hide ) ) {
            unset( $query_result[ $key ] );
        }
    }
    
    return array_values( $query_result );
}

// Hide unwanted template parts from Site Editor
add_filter( 'get_block_templates', 'hide_unwanted_template_parts', 10, 3 );
function hide_unwanted_template_parts( $query_result, $query, $template_type ) {
    // Only filter template parts
    if ( $template_type !== 'wp_template_part' ) {
        return $query_result;
    }
    
    // Template parts to hide (if you have any you don't want visible)
    $parts_to_hide = array(
        'sidebar',          // If you don't want sidebar as a standalone part
        'comments',         // Comments template part
        'post-meta'         // Post meta template part
    );
    
    // Filter out unwanted template parts
    foreach ( $query_result as $key => $template_part ) {
        if ( in_array( $template_part->slug, $parts_to_hide ) ) {
            unset( $query_result[ $key ] );
        }
    }
    
    return array_values( $query_result );
}

// Debug: Check what templates are being loaded
add_action( 'wp_footer', 'debug_current_template' );
function debug_current_template() {
    if ( current_user_can( 'administrator' ) && isset( $_GET['debug_template'] ) ) {
        echo '<div style="position:fixed;bottom:0;left:0;background:#000;color:#fff;padding:10px;z-index:9999;">';
        echo 'Current template: ' . get_page_template_slug();
        echo '<br>Available templates: ';
        $templates = wp_get_theme()->get_page_templates();
        print_r( $templates );
        echo '</div>';
    }
}

/* Blocks */
function iowa_aea_theme_custom_blocks_init() {
	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` and registers the block type(s)
	 * based on the registered block metadata.
	 * Added in WordPress 6.8 to simplify the block metadata registration process added in WordPress 6.7.
	 *
	 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
	 */
	if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
		wp_register_block_types_from_metadata_collection( __DIR__ . '/blocks/build', __DIR__ . '/blocks/build/blocks-manifest.php' );
		return;
	}

	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` file.
	 * Added to WordPress 6.7 to improve the performance of block type registration.
	 *
	 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
	 */
	if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
		wp_register_block_metadata_collection( __DIR__ . '/blocks/build', __DIR__ . '/blocks/build/blocks-manifest.php' );
	}
	/**
	 * Registers the block type(s) in the `blocks-manifest.php` file.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	$manifest_data = require __DIR__ . '/blocks/build/blocks-manifest.php';
	foreach ( array_keys( $manifest_data ) as $block_type ) {
		register_block_type( __DIR__ . "/blocks/build/{$block_type}" );
	}
}
add_action( 'init', 'iowa_aea_theme_custom_blocks_init' );


/* Staff / School Directory */
include_once __DIR__ . '/directory/staff-directory.php';

/* Include News */
include_once __DIR__ . '/news/news.php';

/* Include Events */
include_once __DIR__ . '/events/events.php';

/* Include Weather Alerts */
include_once __DIR__ . '/weather-alerts/weather-alerts.php';


/* Add Skip to main content */
function iowa_aea_theme_skip_to_content() {
  ?>
  <a href="#main" class="skip-to-content">Skip to main content</a>
  <?php
}

add_action('wp_head', 'iowa_aea_theme_skip_to_content', 9);

/** Google Translation Setup and enqueue */
function iowa_aea_google_translate_enqueue() {
    wp_enqueue_script( 'google-translate-init', get_stylesheet_directory_uri() . '/assets/js/translate_script.js', array(), null, true );
    wp_enqueue_script( 'google-translate', '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit', array('google-translate-init'), null, true );
}

add_action( 'wp_enqueue_scripts', 'iowa_aea_google_translate_enqueue' );

/* End of functions.php */