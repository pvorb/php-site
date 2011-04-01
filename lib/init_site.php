<?php
require_once DIR_LIB.'Http/HttpRequest.php';
require_once DIR_LIB.'Http/HttpResponse.php';
require_once DIR_LIB.'Http/HttpHandler.php';

/**
 * Initializes Database connection and HTTP handling.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */
function init_site() {
	// Create a new HttpRequest
	$request = new HttpRequest();

	// Initialize database connection
	$db_connection = new PDO(
		DB_TYPE.':host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME, // DSN
		DB_USER, // Database user name
		DB_PWD   // Database user password
	);

	// Handle the request
	try {
		HttpHandler::handle($request, $db_connection);
	}
	// Catch responses and send them to the client
	catch (HttpResponse $response) {
		HttpHandler::send($response);
	}
}
