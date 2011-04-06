<?php
/**
 * The project specific configuration file.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */

require '../../lib/conf.php';
define('DIR_PROJECT', dirname(__FILE__).'/');
define('DIR_WWW', DIR_PROJECT.'www/');

define('DEBUG_MODE', TRUE);

// Define the current DIR_WWW as site 1
define('SITE', 1);
define('URI_PREFIX', 'http://example.org');

// Define details for the connection to the database
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'site');
define('DB_USER', 'root');
define('DB_PWD', '');
