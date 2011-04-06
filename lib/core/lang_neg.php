<?php
/**
 * Provides language negotiation according to the HTTP_ACCEPT_LANGUAGE header
 * and returns the position of the most matching language in $available.
 *
 * @param array $available
 * @return int
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */
function lang_neg(array $available) {
	// If there's only one language available, return it
	if (count($available) <= 1)
		return 0;

	// Get the HTTP accept language header
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		$langs = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	else
		$langs = 'en';

	// Match the header against a pattern
	preg_match_all("#(([[:alpha:]]+)-[[:alpha:]-]+)( ?;q=(\d+.\d+))?#i",
		$langs, $hits, PREG_SET_ORDER);

		var_dump($hits);

	$best_lang = 0;
	$q_max = 0;

	// Determine best language
	foreach ($hits as $hit) {
		if (sizeof($hit) >= 5)
			$q = floatval($hit[4]);
		else
			$q = 1;

		$locale = $hit[1];
		$lang = $hit[2];

		$i = 0;
		// If the qualifier is greater than the maximum
		if ($q > $q_max) {
			// Look, if it is in available
			foreach ($available as $lang_a) {
				if ($lang_a == $locale || strpos($lang_a, $lang) === 0) {
					$q_max = $q;
					$best_lang = $i;
				}

				$i++;
			}
		}
	}

	return $best_lang;
}
