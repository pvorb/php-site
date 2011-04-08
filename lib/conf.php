<?php
/**
 * The system wide configuration file.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */

define('DIR_LIB', dirname(__FILE__).'/');

// Define default content types
$mime_types = array(
		'bin'  => 'application/octet-stream',
		'css'  => 'text/css',
		'gif'  => 'image/gif',
		'html' => 'text/html',
		'ico'  => 'image/x-icon',
		'jpg'  => 'image/jpeg',
		'js'   => 'text/javascript',
		'pdf'  => 'application/pdf',
		'php'  => 'text/html',
		'png'  => 'image/png',
		'svg'  => 'image/svg+xml',
		'txt'  => 'text/plain',
		'xml'  => 'text/xml'
	);

require DIR_LIB.'core/http.php';
