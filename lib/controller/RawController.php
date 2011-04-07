<?php
require_once DIR_LIB.'core/content_type.php';

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
		// If the file resides on the file system
		if ($this->file['fs']) {
			// If it does not exist, throw a 404 HttpResponse
			if (!file_exists($this->file['path']))
				throw new HttpResponse(404);

			$path = $this->file['path'];
			header('Content-Type: '.content_type($path));

			readfile($path);
		} else {

		}
	}
}
