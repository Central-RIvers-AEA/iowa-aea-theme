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

/* Plugin Update Checker */
require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

// For themes, point to the theme's main file (usually style.css or the main theme file)
$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/Central-RIvers-AEA/iowa-aea-theme/',
	get_stylesheet_directory() . '/style.css',
	'iowa-aea-theme'
);

// Set the branch that contains the stable release
$myUpdateChecker->setBranch('main');

// Optional: Enable release assets if you want to use GitHub releases instead of just commits
// $myUpdateChecker->getVcsApi()->enableReleaseAssets();

// Add manual update check functionality
add_action('admin_post_check_theme_updates', 'iowa_aea_handle_manual_update_check');
function iowa_aea_handle_manual_update_check() {
    // Check if user has permission
    if (!current_user_can('update_themes')) {
        wp_die('You do not have permission to check for theme updates.');
    }
    
    // Check nonce for security
    if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'check_theme_updates')) {
        wp_die('Security check failed.');
    }
    
    global $myUpdateChecker;
    
    // Clear any cached update info to force a fresh check
    $myUpdateChecker->resetUpdateState();
    
    // Force check for updates
    $myUpdateChecker->checkForUpdates();
    
    // Get the update info
    $update = $myUpdateChecker->getUpdate();
    
    // Add detailed debugging information
    $current_version = wp_get_theme()->get('Version');
    
    // Try to get more detailed info for debugging
    $debug_info = '';
    if (current_user_can('administrator')) {
        $debug_info = sprintf(
            ' [Debug: Local: %s, Checking: %s]',
            $current_version,
            'https://github.com/Central-RIvers-AEA/iowa-aea-theme/'
        );
    }
    
    if ($update !== null) {
        $message = sprintf(
            'Update available! Version %s is available. Current version: %s%s',
            $update->version,
            $current_version,
            $debug_info
        );
        $type = 'success';
    } else {
        $message = sprintf(
            'No updates available. Current version: %s. Your theme is up to date!%s',
            $current_version,
            $debug_info
        );
        $type = 'info';
    }
    
    // Redirect back with message
    $redirect_url = add_query_arg(
        array(
            'update_check_message' => urlencode($message),
            'update_check_type' => $type
        ),
        admin_url('themes.php')
    );
    
    wp_redirect($redirect_url);
    exit;
}

// Add the check for updates button to the theme actions
// We need to use the correct filter hook based on the theme's stylesheet directory
add_action('init', 'iowa_aea_setup_theme_action_links');
function iowa_aea_setup_theme_action_links() {
    $theme_slug = get_option('stylesheet'); // Gets the current theme's directory name
    add_filter("theme_action_links_{$theme_slug}", 'iowa_aea_theme_action_links');
}

function iowa_aea_theme_action_links($actions) {
    // Only show for administrators
    if (!current_user_can('update_themes')) {
        return $actions;
    }
    
    $check_updates_url = wp_nonce_url(
        admin_url('admin-post.php?action=check_theme_updates'),
        'check_theme_updates'
    );
    
    $actions['check_updates'] = sprintf(
        '<a href="%s" class="check-theme-updates">%s</a>',
        esc_url($check_updates_url),
        __('Check for Updates')
    );
    
    return $actions;
}

// Alternative method: Add update button to themes page via JavaScript
add_action('admin_footer-themes.php', 'iowa_aea_add_update_button_js');
function iowa_aea_add_update_button_js() {
    if (!current_user_can('update_themes')) {
        return;
    }
    
    $check_updates_url = wp_nonce_url(
        admin_url('admin-post.php?action=check_theme_updates'),
        'check_theme_updates'
    );
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Find the current theme (active theme)
        var currentTheme = $('.theme.active .theme-actions, .theme.current .theme-actions');
        if (currentTheme.length > 0) {
            var updateButton = '<a href="<?php echo esc_js($check_updates_url); ?>" class="button button-secondary check-theme-updates">' +
                'Check for Updates</a>';
            currentTheme.append(updateButton);
        }
        
        // Also add to theme details modal if it exists
        $(document).on('click', '.theme-overlay .theme-actions .button-primary', function() {
            setTimeout(function() {
                var modal = $('.theme-overlay .theme-actions');
                if (modal.length > 0 && !modal.find('.check-theme-updates').length) {
                    var updateButton = '<a href="<?php echo esc_js($check_updates_url); ?>" class="button button-secondary check-theme-updates">' +
                        'Check for Updates</a>';
                    modal.append(updateButton);
                }
            }, 100);
        });
    });
    </script>
    <style>
    .check-theme-updates {
        margin-left: 10px !important;
    }
    .check-theme-updates .dashicons {
        font-size: 16px;
        width: 16px;
        height: 16px;
    }
    </style>
    <?php
}

// Display update check messages
add_action('admin_notices', 'iowa_aea_display_update_check_message');
function iowa_aea_display_update_check_message() {
    if (isset($_GET['update_check_message']) && isset($_GET['update_check_type'])) {
        $message = urldecode($_GET['update_check_message']);
        $type = $_GET['update_check_type'];
        
        printf(
            '<div class="notice notice-%s is-dismissible"><p>%s</p></div>',
            esc_attr($type),
            esc_html($message)
        );
    }
}

// Add some basic styling for the update check button
add_action('admin_head', 'iowa_aea_update_check_styles');
function iowa_aea_update_check_styles() {
    ?>
    <style>
    .check-theme-updates {
        color: #2271b1 !important;
        text-decoration: none;
    }
    .check-theme-updates:hover {
        color: #135e96 !important;
    }
    .check-theme-updates:before {
        content: "\f463";
        font-family: dashicons;
        margin-right: 5px;
    }
    </style>
    <?php
}

// Add update check to admin bar
add_action('admin_bar_menu', 'iowa_aea_admin_bar_update_check', 100);
function iowa_aea_admin_bar_update_check($wp_admin_bar) {
    // Only show for administrators
    if (!current_user_can('update_themes')) {
        return;
    }
    
    global $myUpdateChecker;
    
    // Check if there are pending updates
    $update = $myUpdateChecker->getUpdate();
    $has_update = ($update !== null);
    
    $title = $has_update ? 'Theme Update Available!' : 'Check Theme Updates';
    $class = $has_update ? 'update-available' : '';
    
    $check_updates_url = wp_nonce_url(
        admin_url('admin-post.php?action=check_theme_updates'),
        'check_theme_updates'
    );
    
    $wp_admin_bar->add_node(array(
        'id'    => 'iowa-aea-theme-updates',
        'title' => $title,
        'href'  => $check_updates_url,
        'meta'  => array(
            'class' => $class,
            'title' => $has_update ? 'Click to update your theme' : 'Click to check for theme updates'
        )
    ));
    
    // Add some styling for the admin bar item
    if ($has_update) {
        echo '<style>
        #wpadminbar .update-available > .ab-item {
            background-color: #d63638 !important;
            color: white !important;
        }
        #wpadminbar .update-available:hover > .ab-item {
            background-color: #c92d2f !important;
        }
        </style>';
    }
}