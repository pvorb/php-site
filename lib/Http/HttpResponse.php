<?php
/**
 * Provides functionality for sending back a HTTP response.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */
class HttpResponse extends Exception {
	private $location;

	/**
	 * Creates an HttpResponse object.
	 *
	 * @param int $code
	 * @param string $location [optional]
	 */
	function __construct($code, $location = NULL) {
		$this->code = $code;
		$this->location = $location;
	}

	/**
	 * Returns the location of the HttpResponse destination.
	 */
	function getLocation() {
		return $this->location;
	}
}
