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
	<div class="box">
		<div class="upload">
			<input type="file" name="file" /> <input type="submit" name="upload" value="hochladen" class="btn" />
		</div>
		<div class="hl">
			Deine hochgeladenen Fotos:
		</div>
		{if $pics|@count < 1}noch nix hochgeladen{else}
		{foreach $pics as $pic}
		{if ($pic@iteration is div by 4) || ($pic@first)}
		<div class="row">
		{/if}
			<div class="pic">
				<div class="del"><a href="/?page=profile&amp;action=del&amp;id={$pic.id}" onclick="return confirm('Foto wirklich löschen?');" title="Foto löschen">x</a></div>
				<img src="/gfx/cache/pics/medium/{$pic.pic}.jpg" alt="" />
			</div>
		{if ($pic@iteration is div by 3) || ($pic@last)}
		</div>
		{/if}
		{/foreach}
		{/if}
	</div>
</div>
</form>
{include file="foot.tpl"}