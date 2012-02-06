<?php
include('include/main.php');

if ($_POST['login']) {
	$username = request_var('name', '', true);
	$password = request_var('pass', '', true);

	$result = $auth->login($username, $password);

	if ($result['status'] == LOGIN_SUCCESS)
	{
		redirectTo("index.php");
	}
	else
	{
		$_tpl->assign("msg", "Benutzername oder Passwort falsch.");
		$_tpl->display("login.tpl");
	}

} else {
	$_tpl->display("login.tpl");
}
	
?>
