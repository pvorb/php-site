<?php
require_once DIR_LIB.'Http/HttpRequest.php';
require_once DIR_LIB.'Http/HttpResponse.php';

/**
 * Provides handler methods for HTTP requests and HTTP responses.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */
class HttpHandler {
	/**
	 * Handles a HttpRequest object by using a PDO database connection.
	 *
	 * @param HttpRequest $request
	 * @param PDO $db
	 */
	static function handle(HttpRequest $request, PDO $db) {
		$uri = $request->getUri();

		// If the URI is not set (e.g. by going to 'http://example.com/init.php'),
		// throw a 403 HttpResponse.
		if ($uri === NULL)
			throw new HttpResponse(403);
	}

	/**
	 * Sends HTTP headers according to a HttpResonse object.
	 *
	 * @param HttpResponse $response
	 */
	static function send(HttpResponse $response) {
		// If DEBUG_MODE is set to TRUE
		if (defined('DEBUG_MODE') && DEBUG_MODE) {
			// Trace the response
			echo '<i>The following HTTP response was sent:</i>'."<br>\n<br>\n";
			echo 'HTTP status code: '.$response->getCode()."<br>\n";
			$trace_lines = explode("\n", $response->getTraceAsString());
			echo "<ul>\n";
			foreach ($trace_lines as $line) {
				echo "\t<li>".$line."\n";
			}
			echo "</ul>\n";
		} else {
			// TODO Send the response headers
		}
	}
}
