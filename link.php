<?php
include('include/main.php');

// kick normal users
kickGuests(true);

loadComponent("pics");
$pics = new pics(4, "profile");

// someone linked ?
if (!empty($_GET['user'])) {
	$_db->query('UPDATE people SET user = ? WHERE topic = ?', array($_GET['user'], $_GET['topic']));
	redirect("/link");
}

// picture linked ?
if ($_POST['save']) {
	foreach ($_POST['user'] as $pic => $user) {
		if (!$user) continue;
		
		$pics->updateOwner($pic, $user);
		$_db->query('UPDATE people SET pic = 1 WHERE user = ?', array($user));
	}
	
	redirectTo();
}


// get all real names from the required profile field
$result = $_db->query('	SELECT		pf.pf_realname AS realname,
									pf.user_id AS id,
									u.username AS name
						FROM		phpbb_profile_fields_data AS pf,
									phpbb_users AS u
						WHERE		pf.user_id = u.user_id
						ORDER BY	pf.pf_realname ASC
						');
$names = array();
while ($name = $result->fetch()) {
	$result2 = $_db->query('SELECT user FROM people WHERE user = ?', array($name['id']));
	$row = $result2->fetch();
	if ($row['user']) continue;
	
	$names[] = $name;
}
$_tpl->assign("names", $names);


// go through forum which contains all threads about the people
$result = $_db->query('SELECT topic_id AS id, topic_title AS title FROM phpbb_topics WHERE forum_id = ?', array($_config['aboutForum']));

$missing = array();
while ($topic = $result->fetch()) {
	$name = explode(", ", $topic['title']);
	
	$result2 = $_db->query('SELECT * FROM people WHERE topic = ?', array($topic['id']));
	$person = $result2->fetch();
	if (empty($person['topic'])) {
		$_db->query('INSERT INTO people VALUES (0, ?, ?, ?)', array($name[1], $name[0], $topic['id']));
	}
	
	if (empty($person['user'])) {
		$missing[] = array("topic" => $topic['id'], "name" => $name[1]." ".$name[0]);
	}
	
}
$_tpl->assign("missing", $missing);


// import profile pictures
$importDir = $_base."gfx/cache/pics/import/";

if ($handle = opendir($importDir)) {
	while (false !== ($file = readdir($handle))) {
		if (substr($file, 0, 1) == ".") continue;

		$pics->importFile($importDir.$file, 0);
	}

	closedir($handle);
}
$allPics = $pics->getAll(0);

// get people without pictures
if (count($allPics)) {
	$result = $_db->query('SELECT user, firstname, lastname FROM people WHERE pic = 0 AND user != 0 ORDER BY firstname ASC');
	$_tpl->assign("names2", $result->fetchAll());
}


// get all profile pictures which are not assigned to anyone
$_tpl->assign("pics", $allPics);

$_tpl->display("link.tpl");

?>
