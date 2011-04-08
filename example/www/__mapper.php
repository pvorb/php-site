<?php
/**
 * General Mapper.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */

// Check if $uri is the init script or a mapper and throw a 404 response.
$uri = $request->getUri();
if ($uri == '__init.php' || $uri == MAPPER_FILE) {
	throw new HttpResponse(404);
}

// Define current directory as DIR_MAPPER.
define('DIR_MAPPER', dirname(__FILE__));
