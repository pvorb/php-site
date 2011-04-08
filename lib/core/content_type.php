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

	global $mime_types;

	if (isset($mime_types[$ext])) {
		return $mime_types[$ext];
	} else
		return 'text/plain';
}
