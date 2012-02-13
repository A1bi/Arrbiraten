<!DOCTYPE html>
<html>
<head>
	<title>Arr Biraten 2012{if $title != ""} - {$title}{/if}</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="/css/main.css{fileVersion file="/css/main.css"}" />
	<!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="/css/iefix.css{fileVersion file="/css/iefix.css"}" /><![endif]-->
	<script src="http://system.albisigns.de/js/lib/jquery.js"></script>
	<script src="/js/main.js{fileVersion file="/js/main.js"}"></script>
{if $jsfile != ""}
	<script src="/js/{$jsfile}.js{fileVersion file="/js/{$jsfile}.js"}"></script>
{/if}
</head>

<body>
	<a href="/" class="headline">Arr Biraten 2012{if $title != ""} - {$title}{/if}</a>
	<div class="content">
		{if $_user.is_registered}
		<div class="userinfo">
			eingeloggt als {$_user.username|escape} | <a href="/forum/ucp.php?mode=logout&amp;sid={$_user.session_id}">ausloggen</a>
		</div>
		{/if}