{include file="head.tpl"}
<div class="navigation">
	<div class="box">
		<a href="/forum" class="hl">zum Forum</a>
		Alles Organisatorische, u.A. Rubriken für die Abizeitung.
	</div>
	<div class="box" style="float: right;">
		{if $smarty.cookies.update < $_config.update}<div class="update">Update!</div>{/if}
		<a href="/profile" class="hl">zu deinem Steckbrief</a>
		Hier kannst du deinen eigenen Steckbrief für die Abizeitung ausfüllen.
	</div>
</div>
{include file="foot.tpl"}