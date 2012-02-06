<?php

// enable error reporting
ini_set('display_errors','on');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * redirects to given url
 *
 * @param string $url
 */
function redirectTo($url = "") {
	if (empty($url)) $url = $_SERVER['REQUEST_URI'];
	header("Location: " . $url);
	exit();
}

/**
 * includes the given component
 *
 * @param string $core
 */
function loadComponent($component) {
	global $_base;

	$component = "./include/core/" . $component . ".php";
	// component exists?
	if (file_exists($component)) {
		require_once($component);
	}
}

/**
 * creates a random id with the given amount of digits
 *
 * @param int $digits
 * @return string
 */
function createId($digits) {
	$items = "abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXY";
	for ($i = 0; $i < $digits; $i++) {
		$item = mt_rand(1, strlen($items));
		$id .= $items{$item};
	}
	return $id;
}

// get config
require("./include/config.inc.php");
$_base = $_SERVER['DOCUMENT_ROOT'] . "/";

$_config['update'] = 1;

// components to load
$comps = array("templates", "database");
foreach ($comps as $comp) {
	loadComponent($comp);
}

if ($_COOKIE['admin'] == $_config['pass']) {
	$_vars['admin'] = true;
}

?>