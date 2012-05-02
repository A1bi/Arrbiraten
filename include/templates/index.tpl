{include file="head.tpl"}
<div class="navigation">
	<div class="row">
		<div class="box photos">
			<a href="/forum" class="hl">Fotos Download</a>
			<table>
				<tr class="head">
					<td>Offizielle Feier</td>
					<td>Abikonzert</td>
				</tr>
				<tr>
					<td>
						<p><a href="/download/1">Kirche und Verabschiedung</a> <span class="size">(1,81 GB)</span></p>
						<p><a href="/download/2">Gesamtfotos der Stufe</a> <span class="size">(49,2 MB)</span></p>
						<p><a href="/download/3">Gruppenfotos</a> <span class="size">(2,51 GB)</span></p>
					</td>
					<td class="concert">
						<p><a href="/download/4">Proben</a> <span class="size">(1,02 GB)</span></p>
						<p><a href="/download/5">Konzert</a> <span class="size">(2,81 GB)</span></p>
					</td>
				</tr>
			</table>
			<p>Danke an Christian Weiß (C.Weiß | Photo)!</p>
		</div>
	</div>
	<div class="section">
		<div class="hl">Abgelaufene Aktionen</div>
	</div>
	<div class="row">
		<div class="box">
			<a href="/forum" class="hl">Forum</a>
			Alles Organisatorische, u.A. Rubriken für die Abizeitung.
		</div>
		<div class="box right">
			<a href="/lists/official" class="hl">Planung offizieller Teil</a>
			Verschiedene Infos, die zur Planung der offiziellen Verabschiedung benötigt werden.
		</div>
	</div>
	<div class="row">
		<div class="box">
			<a href="/lists/song" class="hl">Einlauflied</a>
			Sende dein persönliches Lied für die Zeugnisvergabe ein.
		</div>
		<div class="box right">
			<a href="/shirts" class="hl">Abi-Shirt bestellen</a>
			Bestelle hier dein Abi-Shirt.
		</div>
	</div>
	<div class="row">
		<div class="box">
			{if $smarty.cookies.update < $_vars.update}<div class="update">Update!</div>{/if}
			<a href="/profile" class="hl">Steckbrief</a>
			Hier kannst du deinen eigenen Steckbrief für die Abizeitung ausfüllen.
		</div>
		<div class="box right">
			<a href="/pics" class="hl">Fotos für Collagen</a>
			Lade deine Fotos für die Collagen in der Abizeitung hoch.
		</div>
	</div>
	<div class="row">
		<div class="box">
			<a href="/stories" class="hl">Kursberichte</a>
			Hier kannst du Kursberichte und die dazugehörigen Kursfotos hochladen.
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