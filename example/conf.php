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

// Define URI prefix
define('URI_PREFIX', 'http://example.org');

// Mapper name
define('MAPPER_FILE', '__mapper.php');
