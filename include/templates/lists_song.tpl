<form action="/lists/song" method="post" enctype="multipart/form-data">
<div class="section">
	<div class="hl">
		Sende hier bitte dein persönliches Einlauflied für die Zeugnisvergabe ein. Dies gilt auch, falls du Simon schon etwas geschickt hast.
		<p>Es sollte ein etwa 20 Sekunden langer Ausschnitt sein. Falls du das Stück selbst schneiden möchtest, lass noch genug Zeit dahinter übrig, falls der Weg zur Bühne länger dauern sollte.<br />
		Wenn du es nicht selber schneidest, gib einfach den Link zum Lied zusammen mit der entsprechenden Stelle an.</p>
		<b>Es sollte auch vermieden werden, dass ein Lied mehrmals vorkommt. Schau dazu unten einfach in die Liste.</b>
	</div>
	{if $sent}
	<div class="section hcen">
		<b>Danke fürs Einsenden!</b>
	</div>
	{elseif $_vars.blocked.$type}
	<div class="section hcen">
		<b>Keine Einsendungen mehr möglich!</b>
	</div>
	{else}
	<div class="box">
		<table>
			<tr>
				<td class="caption">
					Name des Liedes mit Interpret:
					<div>z.B. Justin Bieber - Baby</div>
				</td>
				<td class="value"><input type="text" name="title" /></td>
			</tr>
			<tr>
				<td class="caption">
					
				</td>
				<td class="value" id="method"><input type="radio" name="method" value="0" /> direkt hochladen<br /><input type="radio" name="method" value="1" /> Link zum Lied angeben</td>
			</tr>
		</table>
		<div class="hidden">	
			<table>
				<tr>
					<td class="caption">
						MP3-Datei:
					</td>
					<td class="value"><input type="file" name="file" /></td>
				</tr>
				<tr>
					<td class="caption">
						Abschnitt ab:
						<div>Minute und Sekunde<br />z.B. 01:29<br />nur falls es noch nicht von dir geschnitten ist</div>
					</td>
					<td class="value"><select name="min">{for $i=0 to 10}<option>{if $i < 10}0{/if}{$i}</option>{/for}</select> : <select name="sec">{for $i=0 to 59}<option>{if $i < 10}0{/if}{$i}</option>{/for}</select></td>
				</tr>
			</table>
		</div>
		<div class="hidden">
			<table>
				<tr>
					<td class="caption">
						Link zum Lied:
					</td>
					<td class="value"><input type="text" name="url" /></td>
				</tr>
				<tr>
					<td class="caption">
						Abschnitt ab:
						<div>Minute und Sekunde<br />z.B. 01:29</div>
					</td>
					<td class="value"><select name="min2">{for $i=0 to 10}<option>{if $i < 10}0{/if}{$i}</option>{/for}</select> : <select name="sec2">{for $i=0 to 59}<option>{if $i < 10}0{/if}{$i}</option>{/for}</select></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="submit">
		<input type="submit" name="save" value="einsenden" class="btn" />
		<div><em>nach dem Einsenden kann nichts mehr geändert werden!</em></div>
	</div>
	{/if}
</div>
</form>