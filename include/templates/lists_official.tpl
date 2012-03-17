<form action="/lists/official" method="post">
<div class="section">
	<div class="hl">
		Damit alles richtig geplant werden kann, bitten wir dich hier anzugeben, was du an Essen für die offizielle Verabschiedung zur Verfügung stellen kannst.
	</div>
	{if $_vars.blocked.$type}
	<div class="section hcen">
		<b>Keine Änderungen mehr möglich!</b>
	</div>
	{else}
	<div class="box">
		<table>
			<tr>
				<td class="caption">
					Essen, das du mitbringen kannst:
					<div>z.B. Salate, Nachtisch</div>
				</td>
				<td class="value"><textarea name="dish">{$info['dish']|escape}</textarea></td>
			</tr>
		</table>
	</div>
	<div class="submit">
		<input type="submit" name="save" value="speichern" class="btn" />
	</div>
	{/if}
</div>
</form>