<?php
include('include/main.php');
kickGuests();

switch ($_GET['list']) {
	
	case "official":
		$type = 6;

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


		$people = array("sum" => 0, "all" => array());

		$result = $_db->query('SELECT p.firstname, p.lastname, l.* FROM lists AS l, people AS p WHERE p.user = l.user ORDER BY p.firstname ASC');
		$people['all'] = $result->fetchAll();

		$_tpl->assign("type", $type);
		$_tpl->assign("info", $info);
		$_tpl->assign("people", $people);
		$_tpl->display("lists_official.tpl");
		break;
		
	default:
		redirectTo("/");
}

?>