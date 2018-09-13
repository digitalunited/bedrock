<?php
/* Development */
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost');

define('WP_HOME', getenv('WP_HOME'));
define('WP_SITEURL', getenv('WP_SITEURL'));

define('MAILTRAP', getenv('MAILTRAP'));
define('MAILTRAP_USERNAME', getenv('MAILTRAP_USERNAME'));
define('MAILTRAP_PASSWORD', getenv('MAILTRAP_PASSWORD'));

define('SAVEQUERIES', false);
define('WP_DEBUG', true);
define('SCRIPT_DEBUG', true);

define( 'WP_POST_REVISIONS', 10 );
define('WP_MEMORY_LIMIT', '256M');