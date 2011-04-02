<?php
/**
 * Provides a wrapper around an ordinary HTTP Request.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */
class HttpRequest {
	private $uri = NULL;

	/**
	 * Creates a new HTTP request object.
	 */
	function __construct() {
		if (isset($_GET['uri']))
			$this->uri = $_GET['uri'];
	}

	/**
	 * Returns the requested URI path.
	 *
	 * @return string
	 */
	function getUri() {
		return $this->uri;
	}
}
