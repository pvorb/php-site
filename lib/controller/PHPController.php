<?php
/**
 * Controller class for PHP files.
 *
 * The PHPController allows to add PHP scripts to the site.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */
class PHPController {
	private $request, $file, $db;

	/**
	 * Creates a new PHP controller object.
	 *
	 * @param HttpRequest $request
	 * @param array $file
	 * @param PDO $db
	 */
	function __construct(HttpRequest $request, array $file, PDO $db) {
		$this->request = $request;
		$this->file = $file;
		$this->db = $db;
	}

	/**
	 * View the requested PHP file.
	 */
	function view() {
		global $req, $file, $db;

		// Make $reg, $file and $db global for use in the requested PHP script
		$req = $this->request;
		$file = $this->file;
		$db = $this->db;

		if (file_exists($this->file['path']))
			include $this->file['path'];
		else
			throw new HttpResponse(404);
	}

	/**
	 * POST to the requested PHP file.
	 */
	function post() {
		$this->view();
	}
}
