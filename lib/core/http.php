<?php
/**
 * Request handler.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */

/**
 * Provides functionality for sending back a HTTP response.
 */
class HttpResponse extends Exception {
	private $location;

	const OK = 200;
	const MOVED_PERMANENTLY = 301;
	const TEMP_REDIRECT = 302;
	const FORBIDDEN = 403;
	const NOT_FOUND = 404;

	/**
	 * Creates an HttpResponse object.
	 *
	 * @param int $code
	 * @param string $location [optional]
	 */
	function __construct($code, $message = '', $location = NULL) {
		// TODO only allow valid codes

		// $this->code is inherited from Exception
		$this->code = $code;
		$this->location = $location;
		$this->message = $message;
	}

	/**
	 * Returns the location of the HttpResponse destination.
	 *
	 * @return string
	 */
	function getLocation() {
		return $this->location;
	}

	/**
	 * Returns the HTTP status message as a string or FALSE if the message was
	 * not defined for the current code.
	 *
	 * (e.g. "HTTP/1.1 200 OK")
	 *
	 * @return string
	 */
	function getStatus() {
		$protocol = $_SERVER['SERVER_PROTOCOL'];
		switch ($this->code) {
			case self::OK:
				return $protocol.' 200 OK';
				break;
			case self::MOVED_PERMANENTLY:
				return $protocol.' 301 Moved Permanently';
				break;
			case self::TEMP_REDIRECT:
				return $protocol.' 307 Temporary Redirect';
				break;
			case self::FORBIDDEN:
				return $protocol.' 403 Forbidden';
				break;
			case self::NOT_FOUND:
				return $protocol.' 404 Not Found';
				break;
			default:
				return FALSE;
				break;
		}
	}

	/**
	 * Sends HTTP headers according to a HttpResonse object.
	 *
	 * @param HttpResponse $response
	 */
	function send() {
		// If DEBUG_MODE is set to TRUE
		if (defined('DEBUG_MODE') && DEBUG_MODE) {
			// Trace the response
			echo 'The following HTTP response was sent: <i>'
				.$this->getMessage()."</i><br>\n<br>\n";

			echo 'HTTP status code: '.$this->getCode()."<br>\n";

			if ($this->getLocation()) echo 'You will get redirected to: '
				.$this->getLocation();

			$trace_lines = explode("\n", $this->getTraceAsString());

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

/**
 * Provides a wrapper around an ordinary HTTP Request.
 */
class HttpRequest {
	private $uri = NULL;
	private $method;

	/**
	 * Creates a new HTTP request object.
	 */
	private function __construct() {
		$this->uri = $_SERVER['REQUEST_URI'];
		$this->method = $_SERVER['REQUEST_METHOD'];
	}

	private function __clone() {}

	/**
	 * Sets the given URI.
	 *
	 * @param string $uri
	 */
	function setUri($uri) {
		$this->uri = $uri;
	}

	/**
	 * Returns the Request URI.
	 *
	 * @return string
	 */
	function getUri() {
		return $this->uri;
	}

	/**
	 * Returns the request method.
	 *
	 * @return string
	 */
	function getMethod() {
		return $this->method;
	}

	/**
	 * Handles the HTTP request.
	 */
	static function handle() {
		$request = new HttpRequest();
		try {
			// Delegate to a URI mapper
			self::dispatch($request);
		} catch (HttpResponse $response) {
			// Catch every HttpResponse and send it.
			$response->send();
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
	 * @param HttpRequest $uri
	 */
	private static function dispatch(HttpRequest &$request) {
		// copy string
		$uri_part = $request->getUri();
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
					$request->setUri(substr($request->getUri(), $uri_part_len));
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
}
