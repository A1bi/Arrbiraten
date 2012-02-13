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
function createId($digits, $table = "", $column = "") {
	global $_db;
	$items = "abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXY";
	
	while (true) {
		$id = "";
		for ($i = 0; $i < $digits; $i++) {
			$item = mt_rand(1, strlen($items));
			$id .= $items{$item};
		}
		
		if (!empty($table)) {
			$row = $_db->query('SELECT '.$column.' FROM '.$table.' WHERE '.$column.' = ?', array($id))->fetch();
			if (empty($row[$column])) {
				break;
			}
		} else {
			break;
		}
	}
	
	return $id;
}

// redirects users who are not logged in to login page
function kickGuests() {
	global $_user;
	
	if (!$_user->data['is_registered']) {
		redirectTo("/login");
	}
}


// get config
require("./include/config.inc.php");
$_base = $_SERVER['DOCUMENT_ROOT'] . "/";


// phpBB stuff
// user management
define('IN_PHPBB', true);
$phpbb_root_path = $_base . 'forum/';
$phpEx = "php";
include($phpbb_root_path . 'common.' . $phpEx);

// start session
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// rename variables and close database connection so it doesn't interfere with other stuff
$_user = $user;

// get db config from phpbb config file in local scope
$getConfig = function() {
	global $_config, $phpbb_root_path;
	include($phpbb_root_path . "config.php");
	
	$_config['db'] = array(
		"host"	=>	$dbhost,
		"name"	=>	$dbname,
		"user"	=>	$dbuser,
		"pass"	=>	$dbpasswd
	);
};
$getConfig();
unset($getConfig);


$_config['update'] = 1;

// components to load
$comps = array("templates", "database");
foreach ($comps as $comp) {
	loadComponent($comp);
}

$_db = new database;

// assign user info for templates
$_tpl->assign("_user", $_user->data);

?>