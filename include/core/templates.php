<?php
/**
 * initiates smarty template engine
 */

require('/usr/share/php/smarty/Smarty.class.php');

// init object
global $_tpl, $_config;
$_tpl = new Smarty();

$config = $_config;
// for security: remove access to database config
unset($config['db']);
$_tpl->assign("_config", $config);

// configure
$_tpl->setTemplateDir($_base.'/include/templates');
$_tpl->setCompileDir($_base.'/include/templates/compiled');
$_tpl->setCacheDir($_base.'/include/templates/cache');
$_tpl->setConfigDir($_base.'/include/templates/configs');

// register custom functions
function getFileTimestamp($params) {
	global $_base;
	return "?ver=" . @filemtime($_base . $params['file']);
}

$_tpl->registerPlugin("function", "fileVersion", "getFileTimestamp");

?>
