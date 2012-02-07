{include file="head.tpl" title="Schüler-Infos verbinden"}
<div class="section">
	<div class="box">
		<div class="hl">
			noch nicht verbundene Schüler
		</div>
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
{include file="foot.tpl"}