{include file="head.tpl"}
<form action="/login" method="post">
<div class="box login">
	<div class="alert{if $msg != ""} msg{/if}">{$msg|default:"Bitte logge dich mit deinem Account aus dem Forum ein!"}</div>
	<table>
		<tr>
			<td>Benutzername:</td>
			<td><input type="text" name="name" /></td>
		</tr>
		<tr>
			<td>Passwort:</td>
			<td><input type="password" name="pass" /></td>
		</tr>
	</table>
	<div style="margin-top: 10px;">
		<input type="submit" name="login" value="login" class="btn" />
	</div>
	<div class="actions">
		<a href="/forum/ucp.php?mode=sendpassword">Passwort vergessen</a> | <a href="/forum/ucp.php?mode=register">registrieren</a>
	</div>
</div>
</form>
{include file="foot.tpl"}