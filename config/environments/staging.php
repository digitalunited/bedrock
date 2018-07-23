<?php
/* Staging */
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost');

define('WP_HOME', getenv('WP_HOME'));
define('WP_SITEURL', getenv('WP_SITEURL'));

define('MAILTRAP', getenv('MAILTRAP'));
define('MAILTRAP_USERNAME', getenv('MAILTRAP_USERNAME'));
define('MAILTRAP_PASSWORD', getenv('MAILTRAP_PASSWORD'));

ini_set('display_errors', 0);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);
define('DISALLOW_FILE_MODS', true); // this disables all file modifications including updates and update notifications
define('FS_METHOD', 'direct');

define( 'WP_POST_REVISIONS', 10 );