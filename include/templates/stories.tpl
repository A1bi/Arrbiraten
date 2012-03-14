{include file="head.tpl" title="Kursberichte" jsfile="stories"}
<form action="/stories" method="post" enctype="multipart/form-data">
<div class="section">
	<div class="hl">
		Hier kannst du Kursberichte hochladen. Bitte lade Bericht und Kursfotos separat hoch. Das funktioniert so:
		<br />Lade deinen Bericht als Dokument (Format egal) hoch. Nach dem Hochladen erscheint der Bericht unten in der Liste, wo du dann auch die Fotos hochladen kannst.
	</div>
	{if $_vars.blocked.$type}
	<div class="section hcen">
		<b>Es werden keine Kursberichte mehr angenommen!</b>
	</div>
	{else}
	<div class="box newStory">
		<table>
			<tr>
				<td>Kurs:</td>
				<td><input type="text" name="subject" /></td>
			</tr>
			<tr>
				<td>Lehrer:</td>
				<td><input type="text" name="teacher" /></td>
			</tr>
			<tr>
				<td>Bericht:</td>
				<td><input type="file" name="file" /></td>
			</tr>
		</table>
		<div class="submit">
			<input type="submit" name="create" value="Bericht hochladen" class="btn" />
		</div>
	</div>
	{/if}
</div>
</form>
<div class="section">
	<div class="hl">
		Deine hochgeladenen Berichte
	</div>
	{if $stories|@count < 1}noch keine Berichte hochgeladen{else}
	{foreach $stories as $story}
	<form action="/stories" method="post" enctype="multipart/form-data">
	<input type="hidden" name="story" value="{$story.id}" />
	<div class="box story">
		<div class="top">
			<div class="subject">{$story.subject|escape} {$story.teacher|escape}</div>
			<div class="filename">{$story.filename|escape}{if $_vars.admin} - von {$story.firstname} {$story.lastname}{/if}</div>
		</div>
		{if !$_vars.blocked.$type}
		<div class="actions">
			<span class="s_pics">Kursfotos anzeigen/hochladen</span> - <span class="s_reupload">Bericht neu hochladen</span> - <a href="?action=del&amp;story={$story.id}" onclick="return confirm('Bericht wirklich löschen?');">Bericht löschen</a>{if $_vars.admin} - <a href="/download?action=story&amp;id={$story.id}">Download</a> ({if $story.downloaded < 1}-{elseif $story.updated > $story.downloaded}!!!{else}ok{/if}) <a href="?action=resetDownloaded&amp;story={$story.id}">R</a>{/if}
		</div>
		{/if}
		<div class="reupload newStory">
			<div class="hl">
				Du kannst den Bericht hier neu hochladen. Dabei wird die alte Datei ersetzt.
			</div>
			<div class="hcen">
				<input type="file" name="newFile" />
			</div>
			<div class="submit">
				<input type="submit" name="upload" value="Bericht ersetzen" class="btn" />
			</div>
		</div>
		{include file="pics_upload.tpl" pics=$story.pics add="&amp;story={$story.id}"}
	</div>
	</form>
	{/foreach}
	{/if}
</div>
{include file="foot.tpl"}