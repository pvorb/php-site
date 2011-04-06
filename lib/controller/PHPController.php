<?php
/**
 * Controller class for PHP files.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */
class PHPController {
	private $request, $file, $db;

	function __construct(HttpRequest $request, array $file, PDO $db) {
		$this->request = $request;
		$this->file = $file;
		$this->db = $db;
	}

	function view() {
		global $req, $file, $db;

		$req = $this->request;
		$file = $this->file;
		$db = $this->db;

		if (file_exists($this->file['path']))
			include $this->file['path'];
		else
			throw new HttpResponse(404);
	}

	function post() {
		$this->view();
	}
}
