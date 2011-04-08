<?php
/**
 * These functions are necessary for initiating the framework.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */
require_once DIR_LIB.'core/http.php';

/**
 * Initializes Database connection and HTTP handling.
 */
function init_site() {
	// Create a new HttpRequest
	$req = new HttpRequest();

	// Handle the request
	try {
		HttpHandler::handle($req);
	}
	// Catch responses and send them to the client
	catch (HttpResponse $resp) {
		HttpHandler::send($resp);
	}
}

/**
 * Passes the request to the first mapper that exists in the URL.
 *
 * Example: $uri = '/path/to/file'
 *  1. look for '/path/to/__mapper.php'
 *  2. look for '/path/__mapper.php'
 *  3. look for '/__mapper.php'
 *
 * @param string $uri
 */
function delegate($uri) {
	// copy string
	$uri_part = $uri;
	// While the length of the URI part is greater than one
	while (($uri_part_len = strlen($uri_part)) >= 1) {
		// Get position of the last slash in URI
		$last_slash_pos = strrpos($uri_part, '/') + 1;

		// If URI is a directory, look for its mapper
		if ($last_slash_pos == $uri_part_len) {
			// path of the mapper
			$mapper = DIR_WWW.$uri_part.MAPPER_FILE;
			// Require mapper if it exists
			if (file_exists($mapper)) {
				// Remove $uri_part from beginning of $uri
				$uri = substr($uri, $uri_part_len);
				require $mapper;
				return;
			} else {
				// Otherwise remove last slash
				$uri_part = substr($uri_part, 0, $uri_part_len - 1);
			}
		} else {
			// Otherwise remove file from URI
			$uri_part = substr($uri_part, 0, $last_slash_pos);
		}
	}

	// If no MAPPER_FILE exists, throw a HTTP 500 Internal Server Error.
	throw new HttpResponse(500, 'No mapper found.');
}
