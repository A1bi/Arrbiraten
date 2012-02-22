<?php
include('include/main.php');

// kick normal users
kickGuests(true);

$result = $_db->query('SELECT * FROM people ORDER BY firstname ASC');

$_tpl->assign("people", $result->fetchAll());
$_tpl->display("people.tpl");

?>
