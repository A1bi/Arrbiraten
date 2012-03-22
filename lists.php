<?php
include('include/main.php');
kickGuests();

switch ($_GET['list']) {
	
	case "official":
		$type = 6;
		$title = "Planung offizieller Teil";
		$list = array(
			"title" => "Übersicht über die Teilnehmer",
			"columns" => array(
				"Name", "Essen"
			),
			"rows" => array()
		);

		$result = $_db->query('SELECT * FROM lists WHERE user = ?', array($_user->data['user_id']));
		$info = $result->fetch();

		if ($_POST['save'] && !$_vars['blocked'][$type]) {
			$attendees = min(2, max($_POST['attendees'], 0));
			if (empty($info['id'])) {
				$_db->query('INSERT INTO lists VALUES (null, ?, ?)', array($_user->data['user_id'], $_POST['dish']));
			} else {
				$_db->query('UPDATE lists SET dish = ? WHERE user = ?', array($_POST['dish'], $_user->data['user_id']));
			}
			redirectTo();
		}

		$result = $_db->query('SELECT p.firstname, p.lastname, l.* FROM lists AS l, people AS p WHERE p.user = l.user AND l.dish != "" ORDER BY p.firstname ASC');
		while ($person = $result->fetch()) {
			$list['rows'][] = array($person['firstname']." ".$person['lastname'], $person['dish']);
		}

		$_tpl->assign("info", $info);
		
		break;
		
	case "song":
		$type = 7;
		$title = "Einlauflied";
		$list = array(
			"title" => "Übersicht aller bereits eingesandten Einlauflieder",
			"columns" => array(
				"Interpret und Titel"
			),
			"rows" => array()
		);
		$_tpl->assign("head", "lists_song_head.tpl");

		$result = $_db->query('SELECT id FROM lists_song WHERE user = ?', array($_user->data['user_id']));
		$sent = $result->rowCount();
		$_tpl->assign("sent", $sent);

		if ($_POST['save'] && !$_vars['blocked'][$type] && !$sent) {
			if ($_POST['method'] == 0) {
				$start = $_POST['min'].":".$_POST['sec'];
				$file = createId(6, "lists_song", "file").$_FILES['file']['name'];
				if (move_uploaded_file($_FILES['file']['tmp_name'], $_base."/media/".$file)) {
					$_db->query('INSERT INTO lists_song VALUES (null, ?, ?, 1, "", ?, ?, "")', array($_user->data['user_id'], $_POST['title'], $start, $file));
				}
			} else {
				$start = $_POST['min2'].":".$_POST['sec2'];
				$_db->query('INSERT INTO lists_song VALUES (null, ?, ?, 0, ?, ?, "", "")', array($_user->data['user_id'], $_POST['title'], $_POST['url'], $start));
			}
			redirectTo();
		}

		$result = $_db->query('SELECT title FROM lists_song ORDER BY title ASC');
		while ($person = $result->fetch()) {
			$list['rows'][] = array($person['title']);
		}
		
		break;
		
	default:
		redirectTo("/");
}

$_tpl->assign("type", $type);
$_tpl->assign("title", $title);
$_tpl->assign("list", $list);
$_tpl->display("lists.tpl");

?>