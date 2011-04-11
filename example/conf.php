<?php
/**
 * The project specific configuration file.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */

require '../../lib/conf.php';
define('DIR_PROJ', dirname(__FILE__).'/');
define('DIR_PROJ_CTRL', DIR_PROJ.'ctrl/');
define('DIR_WWW', DIR_PROJ.'www/');

// Enable or disable debug mode
define('DEBUG_MODE', TRUE);

// Define URI prefix
define('URI_PREFIX', 'http://example.org');

// Mapper name
define('MAPPER_FILE', '__mapper.php');
