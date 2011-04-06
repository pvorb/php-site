<?php
/**
 * Controller class for raw files.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */
class RawController {
	private $file;

	/**
	 * Creates a new RawController object.
	 *
	 * @param HttpRequest $request
	 * @param array $file
	 * @param PDO $db
	 * @throws HttpResponse
	 */
	function __construct(HttpRequest $request, array $file, PDO $db) {
		$this->file = $file;
	}

	/**
	 * View the raw file.
	 */
	function view() {
		if (file_exists($this->file['path']))
			readfile($this->file['path']);
		else
			throw new HttpResponse(404);
	}
}
