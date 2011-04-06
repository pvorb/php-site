<?php
require_once DIR_LIB.'core/HttpRequest.php';
require_once DIR_LIB.'core/HttpResponse.php';
require_once DIR_LIB.'core/HttpHandler.php';

/**
 * Initializes Database connection and HTTP handling.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */
function init_site() {
	// Create a new HttpRequest
	$req = new HttpRequest();

	// Initialize database connection
	$db = new PDO(
		DB_TYPE.':host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME, // DSN
		DB_USER, // Database user name
		DB_PWD   // Database user password
	);

	// Handle the request
	try {
		HttpHandler::handle($req, $db);
	}
	// Catch responses and send them to the client
	catch (HttpResponse $resp) {
		HttpHandler::send($resp);
	}
}

/**
 * Loads the required controller for a request.
 * @param HttpRequest $request
 * @param array $files
 * @param PDO $db
 * @throws HttpResponse
 */
function load_controller(HttpRequest $request, array $files, PDO $db) {
	$num_files = count($files);

	echo $_SERVER['HTTP_ACCEPT_LANGUAGE'];

	// No file found
	if ($num_files == 0) {
		throw new HttpResponse(404);
	}
	// Single file found
	elseif ($num_files == 1) {
		$file = $files[0];
	}
	// More than one file found
	else {
		$langs = array();
		foreach ($files as $file) {
			$langs[] = $file['locale'];
		}

		// Try to find the right language
		require_once DIR_LIB.'core/lang_neg.php';
		$file = $files[lang_neg($langs)];
	}

	// Controller name
	$cname = $file['view'].'Controller';
	// File name
	$fname = 'controller/'.$cname.'.php';

	// Include the right file
	if (file_exists(DIR_PROJECT.$fname))
		require_once DIR_PROJECT.$fname;
	else
		require_once DIR_LIB.$fname;

	// Create controller instance
	$c = new $cname($request, $file, $db);

	if ($_POST)
		$c->post();
	else
		$c->view();
}
