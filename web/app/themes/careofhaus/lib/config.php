<?php

namespace Roots\Sage\Config;

/**
 * Enable theme features
 */
add_theme_support('soil-clean-up');         // Enable clean up from Soil
add_theme_support('soil-nav-walker');       // Enable cleaner nav walker from Soil
add_theme_support('soil-jquery-cdn');       // Enable to load jQuery from the Google CDN
add_theme_support('soil-disable-asset-versioning');
add_theme_support('soil-disable-trackbacks');
add_theme_support('soil-relative-urls');

add_filter('soil/relative-url-filters', function ($filters) {
  return array_diff($filters, ['wp_get_attachment_url']);
});

/**
 * Configuration values
 */
if (!defined('WP_ENV')) {
  // Fallback if WP_ENV isn't defined in your WordPress config
  // Used in lib/assets.php to check for 'development' or 'production'
  define('WP_ENV', 'production');
}

if (!defined('DIST_DIR')) {
  // Path to the build directory for front-end assets
  define('DIST_DIR', '/dist/');
}