{include file="head.tpl"}
<div class="navigation">
	<div class="row">
		<div class="box">
			<a href="/forum" class="hl">Forum</a>
			Alles Organisatorische, u.A. Rubriken für die Abizeitung.
		</div>
		<div class="box">
			<a href="/lists/official" class="hl">Planung offizieller Teil</a>
			Verschiedene Infos, die zur Planung der offiziellen Verabschiedung benötigt werden.
		</div>
	</div>
	<div class="section">
		<div class="hl">Abgelaufene Aktionen</div>
	</div>
	<div class="row">
		<div class="box" style="float: right;">
			{if $smarty.cookies.update < $_vars.update}<div class="update">Update!</div>{/if}
			<a href="/profile" class="hl">Steckbrief</a>
			Hier kannst du deinen eigenen Steckbrief für die Abizeitung ausfüllen.
		</div>
		<div class="box">
			<a href="/pics" class="hl">Fotos für Collagen</a>
			Lade deine Fotos für die Collagen in der Abizeitung hoch.
		</div>
	</div>
	<div class="row">
		<div class="box" style="float: right;">
			<a href="/stories" class="hl">Kursberichte</a>
			Hier kannst du Kursberichte und die dazugehörigen Kursfotos hochladen.
		</div>
		<div class="box">
			<a href="/shirts" class="hl">Abi-Shirt bestellen</a>
			Bestelle hier dein Abi-Shirt.
		</div>
	</div>
	{if $_vars.admin}
	<div class="section">
		<div class="hl">Administration</div>
	</div>
	<div class="row">
		<div class="box">
			<a href="/people" class="hl">Abiturentia</a>
			Übersicht über alle Leute mit ihren Steckbriefen
		</div>
		<div class="box" style="float: right;">
			<a href="/link" class="hl">Daten verknüpfen</a>
			Forenuser mit Leuten und ihren Fotos verknüpfen
		</div>
	</div>
	{/if}
</div>
{include file="foot.tpl"}