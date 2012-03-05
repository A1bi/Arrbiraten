<?php
include('include/main.php');
kickGuests();

$sizes = array("S", "M", "L", "XL", "XXL", "XXXL");
$genders = array("weiblich", "männlich");

$result = $_db->query('SELECT * FROM shirts WHERE user = ?', array($_user->data['user_id']));
$shirt = $result->fetch();

if (empty($shirt['id'])) {
	$_db->query('INSERT INTO shirts VALUES (null, ?, 0, 0, 0)', array($_user->data['user_id']));
}

if ($_POST['save']) {
	$size = min(count($sizes), max($_POST['size'], 0));
	$gender = min(1, max($_POST['gender'], 0));
	$_db->query('UPDATE shirts SET `order` = ?, size = ?, gender = ? WHERE user = ?', array(!empty($_POST['order']), $size, $gender, $_user->data['user_id']));
	
	redirectTo();
}


if ($_vars['admin'] || $_user->data['user_id'] == 57) {
	$orders = array(0 => array(), 1 => array(), "sum" => 0);

	$result = $_db->query('SELECT size, gender FROM shirts WHERE `order` = 1');
	while ($order = $result->fetch()) {
		$orders[$order['gender']][$order['size']]++;
		$orders['sum']++;
	}
	
	$_tpl->assign("orders", $orders);
}


$_tpl->assign("shirt", $shirt);
$_tpl->assign("sizes", $sizes);
$_tpl->assign("genders", $genders);
$_tpl->display("shirts.tpl");

?>