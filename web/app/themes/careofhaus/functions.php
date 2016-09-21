<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
    'lib/init.php',                  // Initial theme setup and constants
    'lib/wrapper.php',               // Theme wrapper class
    'lib/config.php',                // Configuration
    'lib/assets.php',                // Scripts and stylesheets
    'lib/extras.php',                // Custom functions
    'lib/wordpress-clean-up.php',    // Custom cleanup of the admin interface
    'lib/cache-control.php',
    'lib/register-option-pages.php',
];

foreach ($sage_includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'components'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);

// Include wp-cli commands
if (defined('WP_CLI') && WP_CLI) {
    foreach (glob(__DIR__.'/commands/*.php') as $file) {
        require_once $file;
    }

    unset($file);
}

// Include classes
foreach (glob(__DIR__.'/classes/*.php') as $file) {
    require_once $file;
}
unset($file);
