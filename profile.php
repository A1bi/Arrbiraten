<?php
include('include/main.php');
kickGuests();

// uploaded photos ?
if ($_POST['upload']) {

	loadComponent("resize");
	$resize = new resize;

	$id = createId(6);
	$filename = $_base."gfx/cache/pics/full/".$id.".jpg";

	if (move_uploaded_file($_FILES['file']['tmp_name'], $filename)) {
		chmod($filename, 0777);

		$_db->query('INSERT INTO profile_pics VALUES (null, ?, ?, ?)', array($id, $_user->data['user_id'], time()));
		$resize->resizepic($id, "pics", "medium");
	}

	redirectTo();
}

// deleted photo ?
if ($_GET['action'] == "del") {
	$result = $_db->query('SELECT id, pic FROM profile_pics WHERE id = ? AND user = ?', array($_GET['id'], $_user->data['user_id']));
	$row = $_db->fetchAssoc($result);

	// correct id ?
	if (!empty($row['pic'])) {
		$_db->query('DELETE FROM profile_pics WHERE id = ?', array($row['id']));

		loadComponent("resize");
		$resize = new resize;
		$resize->del_pic("pics", "medium", $row['pic']);
	}

	redirectTo("?page=profile");
}

// prepare all fields
$fields = array(
	"name" => array(
		"caption" => "Landratte", "real" => "Name", "value" => ""
	),
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
		"caption" => "Schatzinsel", "real" => "Lebensziele", "value" => ""
	),
	"hobbies" => array(
		"caption" => "Rum und...", "real" => "Hobbys", "value" => ""
	),
	"top" => array(
		"caption" => "", "real" => "Top", "value" => ""
	),
	"flop" => array(
		"caption" => "", "real" => "Flop", "value" => ""
	),
	"saying" => array(
		"caption" => "Seemannsgarn", "real" => "Spruch, Motto", "value" => ""
	),
	"greetings" => array(
		"caption" => "Flaschenpost", "real" => "Grüße", "value" => ""
	)
);

foreach ($fields as $key => $field) {
	$result = $_db->query('SELECT id, value FROM profile_fields WHERE field = ? AND user = ?', array($key, $_user->data['user_id']));
	$row = $_db->fetchAssoc($result);
	$fields[$key]['value'] = $row['value'];

	if (empty($row['id'])) {
		$_db->query('INSERT INTO profile_fields VALUES (null, ?, ?, "", 0)', array($key, $_user->data['user_id']));
	} else if ($_POST['save'] && $_POST[$key] != $row['value']) {
		$_db->query('UPDATE profile_fields SET value = ?, lastchange = ? WHERE id = ?', array($_POST[$key], time(), $row['id']));
	}
}

if ($_POST['save']) {
	redirectTo();
}

setcookie("update", $_config['update'], time()+31536000, "/");

// fetch pics
$result = $_db->query('SELECT id, pic FROM profile_pics WHERE user = ?', array($_user->data['user_id']));
$pics = $_db->fetchAll($result);

$_tpl->assign("fields", $fields);
$_tpl->assign("pics", $pics);
$_tpl->display("profile.tpl");

?>
