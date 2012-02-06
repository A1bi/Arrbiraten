{include file="head.tpl" title="Dein Steckbrief"}
<form action="/profile" method="post">
<div class="section">
	<div>
		Hier kannst du deinen persönlichen Steckbrief für die Abizeitung ausfüllen. Du kannst ihn auch später noch bis zum <b>8. Februar 2012</b> beliebig oft ändern.
	</div>
	<div class="box">
		<table>
			{foreach from=$fields item=field key=key}
			<tr>
				<td class="caption">
					{if $field.caption == ""}{$field.real}:{else}{$field.caption}:
					<div>({$field.real})</div>{/if}
				</td>
				<td class="value"><textarea name="{$key}">{$field.value|escape}</textarea></td>
			</tr>
			{/foreach}
		</table>
	</div>
	<div class="submit">
		<input type="submit" name="save" value="speichern" class="btn" />
	</div>
</div>
</form>
<form action="/pics" method="post" enctype="multipart/form-data">
<div class="section pics">
	<div>
		Hier kannst du Fotos hochladen, die unter deinem Steckbrief abgedruckt werden sollen. Besonders erwünscht sind dabei auch Kinderfotos ;)
	</div>
	{include file="pics_upload.tpl"}
</div>
</form>
{include file="foot.tpl"}