{include file="head.tpl" title="Dein Steckbrief"}
{if $user.pic.id != ""}
<div class="section">
	<div class="hl">
		Dein piratiges Profilfoto
	</div>
	<div class="box profilepic">
		<img src="/gfx/cache/pics/medium/{$user.pic.pic}.jpg" alt="" height="400" />
	</div>
</div>
{/if}
<form action="/profile?user={$smarty.get.user|escape}" method="post">
<div class="section">
	<div class="hl">
		Hier kannst du deinen persönlichen Steckbrief für die Abizeitung ausfüllen.
	</div>
	<div class="box">
		<table>
			{if $user.firstname != ""}
			<tr>
				<td class="caption">
					Landratte:
					<div>(Name)</div>
				</td>
				<td class="value"><input type="text" name="name" value="{$user.firstname} {$user.lastname}" disabled="disabled" /></td>
			</tr>
			{/if}
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
	{if $_vars.blocked.$type}
	<div class="section hcen">
		<b>Keine Änderungen mehr möglich!</b>
	</div>
	{else}
	<div class="submit">
		<input type="submit" name="save" value="speichern" class="btn" />
	</div>
	{/if}
</div>
</form>
<form action="/profile?user={$user.id}" method="post" enctype="multipart/form-data">
<div class="section pics">
	<div class="hl">
		Hier kannst du Fotos hochladen, die unter deinem Steckbrief abgedruckt werden sollen. Besonders erwünscht sind dabei auch Kinderfotos ;)
		<br /><b>Zwei bis vier</b> Fotos sollten okay sein.
	</div>
	<div class="box">
		{include file="pics_upload.tpl" add="&amp;user={$user.id}"}
	</div>
</div>
</form>
{include file="foot.tpl"}