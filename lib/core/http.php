<?php
/**
 * Request handler.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */

/**
 * Provides a wrapper around an ordinary HTTP Request.
 */
class HttpRequest {
	private $uri = NULL;
	private $method;

	/**
	 * Creates a new HTTP request object.
	 */
	function __construct() {
		$this->uri = $_SERVER['REQUEST_URI'];
		$this->method = $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Returns the requested URI path.
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
}
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
}

/**
 * Provides handler methods for HTTP requests and HTTP responses.
 */
class HttpHandler {
	/**
	 * Handles a HttpRequest object by using a PDO database connection.
	 *
	 * @param HttpRequest $request
	 * @param PDO $db
	 */
	static function handle(HttpRequest $request) {
		// Get the requested URI
		$uri = $request->getUri();

		// If the URI is not set (e.g. by going to '/__init.php'), throw a 403
		// HttpResponse.
		if ($uri === NULL)
			throw new HttpResponse(404);

		// Delegate to another controller
		delegate($uri);
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
			echo 'The following HTTP response was sent: <i>'
				.$response->getMessage()."</i><br>\n<br>\n";

			echo 'HTTP status code: '.$response->getCode()."<br>\n";

			if ($response->getLocation()) echo 'You will get redirected to: '
				.$response->getLocation();

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
