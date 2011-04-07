<?php
/**
 * Return the content type of a file according to its path.
 *
 * @param string $path
 * @return string
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */
function content_type($path) {
	$fragments = explode('.', $path);
	$ext = array_pop($fragments);

	$mime_types = array(
		'asc'  => 'text/plain',
		'bin'  => 'application/octet-stream',
		'css'  => 'text/css',
		'exe'  => 'application/octet-stream',
		'gif'  => 'image/gif',
		'htm'  => 'text/html',
		'html' => 'text/html',
		'ico'	 => 'image/x-icon',
		'jpg'  => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'js'   => 'text/javascript',
		'pdf'  => 'application/pdf',
		'php'  => 'text/html',
		'png'  => 'image/png',
		'svg'  => 'image/svg+xml',
		'txt'  => 'text/plain',
		'xml'  => 'text/xml'
	);

	if (isset($mime_types[$ext])) {
		return $mime_types[$ext];
	} else
		return 'text/plain';
}
