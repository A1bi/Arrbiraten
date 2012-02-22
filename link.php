<?php
include('include/main.php');

// kick normal users
kickGuests(true);

// someone linked ?
if (!empty($_GET['user'])) {
	$_db->query('UPDATE people SET user = ? WHERE topic = ?', array($_GET['user'], $_GET['topic']));
	redirect("/link");
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
$_tpl->display("link.tpl");

?>
