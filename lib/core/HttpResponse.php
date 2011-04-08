<?php
/**
 * Provides functionality for sending back a HTTP response.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
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
