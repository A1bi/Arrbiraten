<?php
include('include/main.php');
kickGuests();

$type = 2;
$_tpl->assign("type", $type);

loadComponent("pics");
$pics = new pics($type);

$pics->handleActions("pics");

$_tpl->assign("pics", $pics->getAll());
$_tpl->display("pics.tpl");

?>
