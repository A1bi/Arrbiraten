<?php
include('include/main.php');
kickGuests();

loadComponent("pics");
$pics = new pics(2);

$pics->handleActions("pics");

$_tpl->assign("pics", $pics->getAll());
$_tpl->display("pics.tpl");

?>
