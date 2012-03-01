<?php
include('include/main.php');
kickGuests();

if ($_vars['admin'] && !empty($_GET['user'])) {
	$user = $_GET['user'];
} else {
	$user = $_user->data['user_id'];
}

loadComponent("pics");
$pics = new pics(1);

$pics->handleActions("profile?user=".$user, $user);

// prepare all fields
$fields = array(
	"nick" => array(
		"caption" => "", "real" => "Spitzname", "value" => ""
	),
	"birthday" => array(
		"caption" => "Segelt seit", "real" => "Geburtsdatum", "value" => ""
	),
	"location" => array(
		"caption" => "Heimathafen", "real" => "Wohnort", "value" => ""
	),
	"tutor" => array(
		"caption" => "Captain", "real" => "Tutor", "value" => ""
	),
	"lks" => array(
		"caption" => "Flagschiffe", "real" => "LKs", "value" => ""
	),
	"goals" => array(
		"caption" => "Nehme Kurs auf", "real" => "Lebensziele", "value" => ""
	),
	"hobbies" => array(
		"caption" => "Rum und...", "real" => "Hobbys", "value" => ""
	),
	"top" => array(
		"caption" => "", "real" => "Top", "value" => ""
	),
	"flop" => array(
		"caption" => "Hoher Wellengang", "real" => "Flop", "value" => ""
	),
	"saying" => array(
		"caption" => "Seemannsgarn", "real" => "Spruch, Motto", "value" => ""
	),
	"greetings" => array(
		"caption" => "Flaschenpost", "real" => "Grüße", "value" => ""
	)
);

foreach ($fields as $key => $field) {
	$result = $_db->query('SELECT id, value FROM profile_fields WHERE field = ? AND user = ?', array($key, $user));
	$row = $_db->fetchAssoc($result);
	$fields[$key]['value'] = $row['value'];

	if (empty($row['id'])) {
		$_db->query('INSERT INTO profile_fields VALUES (null, ?, ?, "", 0)', array($key, $user));
	} else if ($_POST['save'] && $_POST[$key] != $row['value']) {
		$_db->query('UPDATE profile_fields SET value = ?, lastchange = ? WHERE id = ?', array($_POST[$key], time(), $row['id']));
	}
}

if ($_POST['save']) {
	redirectTo();
}

$_tpl->assign("fields", $fields);

// get all normal pics
$_tpl->assign("pics", $pics->getAll($user));

// user info
$result = $_db->query('SELECT firstname, lastname FROM people WHERE user = ?', array($user));
$userInfo = $result->fetch();
$userInfo['id'] = $user;

// get the main profile picture
$pics->setType(4);
$userInfo['pic'] = current($pics->getAll($user));
$_tpl->assign("user", $userInfo);

setcookie("update", $_vars['update'], time()+31536000, "/");

$_tpl->display("profile.tpl");

?>
