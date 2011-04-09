<?php
/**
 * Routing.
 *
 * @license MIT <http://vorb.de/license/mit>
 * @author Paul Vorbach <paul@vorb.de>
 */

class SingleRoute {
	private $uri;
	private $path;
	private $controller;
	private $locale;

	function __construct($uri, $path, $controller, $locale = NULL) {
		$this->uri = $uri;
		$this->path = $path;
		$this->controller = $controller;
		$this->locale = $locale;
	}

	function getUri() {
		return $this->uri;
	}

	function getPath() {
		return $this->path;
	}

	function getController() {
		return $this->controller;
	}

	function getLocale() {
		return $this->locale;
	}
}

class PatternRoute {
	private $pattern;
	private $isFunction;
	private $call;
	private $conditions;

	function __construct($pattern, $call, array $conditions = array()) {
		$this->pattern = $pattern;

		// Split $call at '::'
		$this->call = explode('::', $call);
		$this->isFunction = sizeof($this->call) == 1;

		$this->conditions = $conditions;
	}

	function getPattern() {
		return $this->pattern;
	}

	function isFunction() {
		return $this->isFunction;
	}

	function getController() {
		return $this->call[0];
	}

	function getMethod() {
		return $this->call[1];
	}

	function getFunction() {
		return $this->call[0];
	}

	function getConditions() {
		return $this->conditions;
	}

	function match($uri, &$params) {
		// Split the pattern at slashes into subpatterns
		$patterns = explode('/', $this->getPattern());
		$params = array();
		$cond = $this->getConditions();

		// For each subpattern
		for ($i = 0; $i < sizeof($patterns); $i++)
			// check, if it starts with an '@'
			if (strlen($patterns[$i]) > 0 && $patterns[$i][0] == '@') {
				// The pattern name without the '@'
				$pattern_name = substr($patterns[$i], 1);

				// If a condition for the subpattern is set, use it
				if (isset($cond[$pattern_name]))
					$patterns[$i] = '('.$cond[$pattern_name].')';
				else
				// Otherwise use the general condition
					$patterns[$i] = '([^/]+)';
					// Matches every string, that does not contain a slash

				// Extend $params
				$params[$pattern_name] = NULL;
			}

		// Combine the subpatterns to the main pattern
		$pattern = ':^'.implode('/', $patterns).'$:';

		// Match it against $uri
		if (preg_match($pattern, $uri, $matches)) {
			// Create the associative $params array
			$i = 1;
			foreach ($params as &$value) {
				$value = $matches[$i++];
			}
			// Return TRUE on match
			return TRUE;
		} else
			// Otherwise FALSE
			return FALSE;
	}
}

class Router {
	/**
	 * Resolves the entries in $routes.
	 *
	 * @param string $uri
	 * @param array $routes
	 * @throws HttpResponse
	 */
	static function resolve($uri, array &$routes) {
		// For each route
		foreach ($routes as $route) {
			// If it is a pattern route
			if ($route instanceof PatternRoute) {
				if ($route->match($uri, $params)) {
					// Either function or controller
					if ($route->isFunction()) {
						$fn = $route->getFunction();

						// TODO Load function file

						// Run function
						$fn($params);
					} else {
						$controller = $route->getController();
						$method = $route->getMethod();

						// TODO Load controller class

						// Create controller object
						$ctrl = new $controller();
						// Run method
						$ctrl->$method($params);
					}
				}
			}
		}

		// If no route has matched the URI, throw a 404 HttpResponse
		throw new HttpResponse(404, 'No matching route');
	}

	/**
	 * Throws HTTP redirects according to the given $redirects array.
	 *
	 * @param string $uri
	 * @param array $redirects
	 * @throws HttpResponse
	 */
	static function redirect($uri, array &$redirects) {
		foreach ($redirects as $from => $to) {
			if (strpos($uri, $from) === 0) {
				$goto = str_replace($from, $to, $uri);
				throw new HttpResponse(301, 'Redirect', $goto);
			}
		}
	}
}
