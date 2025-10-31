<?php

/* Custom Theme Update Checker */

class IowaAEAThemeUpdater {
  private $theme_slug;
  private $github_user;
  private $github_repo;
  private $version;
  
  public function __construct() {
    $this->theme_slug = get_option('stylesheet');
    $this->github_user = 'Central-RIvers-AEA';
    $this->github_repo = 'iowa-aea-theme';
    $this->version = wp_get_theme()->get('Version');
    
    add_filter('pre_set_site_transient_update_themes', array($this, 'check_for_update'));
    add_filter('themes_api', array($this, 'themes_api_call'), 10, 3);
  }
  
  public function check_for_update($transient) {
    if (empty($transient->checked)) {
      return $transient;
    }
    
    // Get remote version
    $remote_version = $this->get_remote_version();
    
    if (version_compare($this->version, $remote_version, '<')) {
      $transient->response[$this->theme_slug] = array(
        'theme' => $this->theme_slug,
        'new_version' => $remote_version,
        'url' => "https://github.com/{$this->github_user}/{$this->github_repo}",
        'package' => "https://github.com/{$this->github_user}/{$this->github_repo}/archive/refs/heads/main.zip"
      );
    }
    
    return $transient;
  }
  
  public function get_remote_version() {
    $request = wp_remote_get("https://api.github.com/repos/{$this->github_user}/{$this->github_repo}/contents/style.css");
    
    if (!is_wp_error($request) && wp_remote_retrieve_response_code($request) === 200) {
      $body = json_decode(wp_remote_retrieve_body($request), true);
      if (isset($body['content'])) {
        $style_content = base64_decode($body['content']);
        if (preg_match('/Version:\s*(.+)/i', $style_content, $matches)) {
          return trim($matches[1]);
        }
      }
    }
    
    return $this->version;
  }
    
  public function themes_api_call($result, $action, $args) {
    if ($action !== 'theme_information' || $args->slug !== $this->theme_slug) {
      return $result;
    }
    
    $remote_version = $this->get_remote_version();
    
    return (object) array(
      'name' => 'Iowa AEA Theme',
      'slug' => $this->theme_slug,
      'version' => $remote_version,
      'author' => 'Iowa AEAs',
      'homepage' => "https://github.com/{$this->github_user}/{$this->github_repo}",
      'description' => 'A custom AEA theme based on twentytwentyfive.',
      'download_link' => "https://github.com/{$this->github_user}/{$this->github_repo}/archive/refs/heads/main.zip"
    );
  }
}

// Initialize the custom updater
new IowaAEAThemeUpdater();

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
  
  // Clear the theme update transient to force a fresh check
  delete_site_transient('update_themes');
  
  // Force WordPress to check for theme updates
  wp_update_themes();
  
  // Get the current version and remote version
  $current_version = wp_get_theme()->get('Version');
  
  // Get remote version manually
  $github_version = 'Unknown';
  $api_url = 'https://api.github.com/repos/Central-RIvers-AEA/iowa-aea-theme/contents/style.css';
  $response = wp_remote_get($api_url);
  
  if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (isset($body['content'])) {
      $style_content = base64_decode($body['content']);
      if (preg_match('/Version:\s*(.+)/i', $style_content, $matches)) {
        $github_version = trim($matches[1]);
      }
    }
  }
  
  // Check if WordPress detected an update
  $update_themes = get_site_transient('update_themes');
  $theme_slug = get_option('stylesheet');
  $has_update = isset($update_themes->response[$theme_slug]);
  
  if ($has_update) {
    $available_version = $update_themes->response[$theme_slug]['new_version'];
    $message = sprintf(
      'Update available! Version %s is available. Current version: %s',
      $available_version,
      $current_version
    );
    $type = 'success';
  } else {
    $manual_check = version_compare($github_version, $current_version, '>');
    $message = sprintf(
      'WordPress update system: %s. Manual version check: Local %s vs GitHub %s (%s)',
      $has_update ? 'Update detected' : 'No update detected',
      $current_version,
      $github_version,
      $manual_check ? 'Update available' : 'Up to date'
    );
    $type = $manual_check ? 'warning' : 'info';
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
  
  // Check if there are pending updates using WordPress's update system
  $update_themes = get_site_transient('update_themes');
  $theme_slug = get_option('stylesheet');
  $has_update = isset($update_themes->response[$theme_slug]);
  
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