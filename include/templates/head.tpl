<!DOCTYPE html>
<html>
<head>
	<title>Arr Biraten 2012{if $title != ""} - {$title}{/if}</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="/css/main.css{fileVersion file="/css/main.css"}" />
	<!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="/css/iefix.css{fileVersion file="/css/iefix.css"}" /><![endif]-->
</head>

<body>
	<a href="/" class="headline">Arr Biraten 2012{if $title != ""} - {$title}{/if}</a>
	<div class="content">
		{if $username != ""}
		<div class="userinfo">
			eingeloggt als {$username|escape} | <a href="/forum/ucp.php?mode=logout&amp;sid={$sid}">ausloggen</a>
		</div>
		{/if}