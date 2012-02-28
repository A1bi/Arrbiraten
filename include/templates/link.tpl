{include file="head.tpl" title="Schüler-Infos verbinden"}
<div class="section">
	<div class="hl">
		noch nicht verbundene Schüler
	</div>
	<div class="box">
		<table>
			{foreach $missing as $person}
			<form action="/link" method="get">
			<input type="hidden" name="topic" value="{$person.topic}" />
			<tr>
				<td>{$person.name}</td>
				<td><select name="user">{foreach $names as $name}<option value="{$name.id}">{$name.realname} ({$name.name})</option>{/foreach}</select></td>
				<td><input type="submit" name="link" value="verbinden" /></td>
			</tr>
			</form>
			{/foreach}
		</table>
	</div>
</div>
<div class="section">
	<div class="hl">
		Profilfotos
	</div>
	<div class="box">
		<div class="pics">
			{if $pics|@count < 1}keine Fotos gefunden{else}
			<form action="#" method="post">
			<div class="row">
			{foreach $pics as $pic}
				<div class="pic">
					<img src="/gfx/cache/pics/medium/{$pic.pic}.jpg" alt="" width="150" /><br />
					<select name="user[{$pic.id}]" style="width: 150px;"><option value="0">---</option>{foreach $names2 as $name}<option value="{$name.user}">{$name.firstname} {$name.lastname}</option>{/foreach}</select>
				</div>
			{if ($pic@iteration is div by 3)}
			</div>
			<div class="row">
			{/if}
			{/foreach}
			</div>
			<div class="submit">
				<input type="submit" name="save" value="speichern" class="btn" />
			</div>
			</form>
			{/if}
		</div>
	</div>
</div>
{include file="foot.tpl"}