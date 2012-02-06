{include file="head.tpl" title="Dein Steckbrief"}
<form action="?page=profile" method="post">
<div class="profile">
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
				<td class="value"><input type="text" name="{$key}" value="{$field.value|escape}" /></td>
			</tr>
			{/foreach}
		</table>
	</div>
	<div class="submit">
		<input type="submit" name="save" value="speichern" class="btn" />
	</div>
</div>
</form>
<form action="?page=profile" method="post" enctype="multipart/form-data">
<div class="profile pics" style="margin-top: 30px;">
	<div>
		Hier kannst du Fotos hochladen, die unter deinem Steckbrief abgedruckt werden sollen. Besonders erwünscht sind dabei auch Kinderfotos ;)
	</div>
	{include file="pics_upload.tpl"}
</div>
</form>
{include file="foot.tpl"}