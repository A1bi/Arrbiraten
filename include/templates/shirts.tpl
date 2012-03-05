{include file="head.tpl" title="Abi-Shirt bestellen"}
<form action="/shirts" method="post">
<div class="section">
	<div class="hl">
		Hier kannst du dein Abi-Shirt bestellen.
	</div>
	<div class="box">
		<table>
			<tr>
				<td class="caption">
					Shirt bestellen:
					<div>Wenn du ein Shirt bestellen möchtest, hake das Kästchen ab.</div>
				</td>
				<td class="value"><input type="checkbox" name="order"{if $shirt.order} checked="checked"{/if} /></td>
			</tr>
			<tr>
				<td class="caption">
					Größe:
				</td>
				<td class="value"><select name="size">{foreach $sizes as $size}<option value="{$size@key}"{if $shirt.size == $size@key} selected="selected"{/if}>{$size}</option>{/foreach}</select></td>
			</tr>
			<tr>
				<td class="caption">
					Geschlecht:
				</td>
				<td class="value"><select name="gender"><{foreach $genders as $gender}<option value="{$gender@key}"{if $shirt.gender == $gender@key} selected="selected"{/if}>{$gender}</option>{/foreach}</select></td>
			</tr>
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
{if $_vars.admin || $_user.user_id == 57}
<div class="section">
	<div class="hl">
		Übersicht über die Bestellungen
	</div>
	<div class="box">
		<table>
			<tr style="font-weight: bold;">
				<td>Geschlecht</td>
				{foreach $sizes as $size}
				<td class="hcen">{$size}</td>
				{/foreach}
			</tr>
			{foreach $genders as $gender}
			<tr>
				<td>{$gender}</td>
				{foreach $sizes as $size}
				<td class="hcen">{$orders.$gender@key.$size@key|default:0}</td>
				{/foreach}
			</tr>
			{/foreach}
		</table>
		<div style="margin: 15px;">
			T-Shirts insgesamt: {$orders.sum}
		</div>
	</div>
</div>
{/if}
{include file="foot.tpl"}