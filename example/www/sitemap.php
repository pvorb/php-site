<?php
/**
 * A sitemap.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */

header('Content-Type: text/plain');

$res = $db->query("SELECT DISTINCT `uri` FROM `file` WHERE `public` = 1;");
$files = $res->fetchAll(PDO::FETCH_ASSOC);

foreach ($files as $file) {
	echo URI_PREFIX.$file['uri']."\n";
}
