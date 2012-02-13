{include file="head.tpl"}
<div class="navigation">
	<div>
		<div class="box">
			<a href="/forum" class="hl">Forum</a>
			Alles Organisatorische, u.A. Rubriken für die Abizeitung.
		</div>
		<div class="box" style="float: right;">
			{if $smarty.cookies.update < $_config.update}<div class="update">Update!</div>{/if}
			<a href="/profile" class="hl">Steckbrief</a>
			Hier kannst du deinen eigenen Steckbrief für die Abizeitung ausfüllen.
		</div>
	</div>
	<div>
		<div class="box">
			<a href="/pics" class="hl">Fotos für Collagen</a>
			Lade deine Fotos für die Collagen in der Abizeitung hoch.
		</div>
		<div class="box" style="float: right;">
			<a href="/stories" class="hl">Kursberichte</a>
			Hier kannst du Kursberichte und die dazugehörigen Kursfotos hochladen.
		</div>
	</div>
</div>
{include file="foot.tpl"}