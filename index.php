<?php
include('include/main.php');

define('IN_PHPBB', true);
$phpbb_root_path = './forum/';
$phpEx = "php";
include($phpbb_root_path . 'common.php');

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();


if($user->data['is_registered'])
{
	// assign user info for templates
	$_tpl->assign("username", $user->data['username']);
	$_tpl->assign("sid", $user->session_id);
	
	// which page is requested ?
	if ($_GET['page'] == "profile") {
		// profile page
		
		// uploaded photos ?
		if ($_POST['upload']) {
			
			loadComponent("resize");
			$resize = new resize;
			
			$id = createId(6);
			$filename = $_base."gfx/cache/pics/full/".$id.".jpg";
			
			if (move_uploaded_file($_FILES['file']['tmp_name'], $filename)) {
				chmod($filename, 0777);

				$db->sql_query('INSERT INTO profile_pics VALUES (null, "'.$id.'", "'.$user->data['user_id'].'",'.time().')');
				$resize->resizepic($id, "pics", "medium");
			}
			
			redirectTo();
		}
		
		// deleted photo ?
		if ($_GET['action'] == "del") {
			$result = $db->sql_query('SELECT id, pic FROM profile_pics WHERE id = '.intval($_GET['id']).' AND user = '.$user->data['user_id']);
			$row = $db->sql_fetchrow($result);
			
			
			// correct id ?
			if (!empty($row['pic'])) {
				$db->sql_query('DELETE FROM profile_pics WHERE id = '.$row['id']);
				
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
			$result = $db->sql_query('SELECT id, value FROM profile_fields WHERE field = "'.$key.'" AND user = '.$user->data['user_id']);
			$row = $db->sql_fetchrow($result);
			$fields[$key]['value'] = $row['value'];
			
			if (empty($row['id'])) {
				$db->sql_query('INSERT INTO profile_fields VALUES (null, "'.$key.'", '.$user->data['user_id'].', "", 0)');
			} else if ($_POST['save'] && $_POST[$key] != $row['value']) {
				$db->sql_query('UPDATE profile_fields SET value = "'.$db->sql_escape($_POST[$key]).'", lastchange = '.time().' WHERE id = '.$row['id']);
			}
		}
		
		if ($_POST['save']) {
			redirectTo();
		}
		
		setcookie("update", $_config['update'], time()+31536000, "/");
		
		// fetch pics
		$result = $db->sql_query('SELECT id, pic FROM profile_pics WHERE user = '.$user->data['user_id']);
		$pics = $db->sql_fetchrowset($result);
		
		$_tpl->assign("fields", $fields);
		$_tpl->assign("pics", $pics);
		$_tpl->display("profile.tpl");
		
	} else {
		$_tpl->display("index.tpl");
	}
}
else
{
	if ($_POST['login']) {
		$username = request_var('name', '', true);
		$password = request_var('pass', '', true);

		$result = $auth->login($username, $password);

		if ($result['status'] == LOGIN_SUCCESS)
		{
			redirectTo();
		}
		else
		{
			$_tpl->assign("msg", "Benutzername oder Passwort falsch.");
			$_tpl->display("login.tpl");
		}
	
	} else {
		$_tpl->display("login.tpl");
	}
}
?>