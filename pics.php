<?php
include('include/main.php');
kickGuests();

loadComponent("pics");
$pics = new pics("pics", "pics");

$pics->handleActions();

$_tpl->assign("pics", $pics->getAll());
$_tpl->display("pics.tpl");

?>
