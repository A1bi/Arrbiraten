{include file="head.tpl" title="Abiturientia"}
<div class="section">
	<div class="hl">
		Übersicht aller Abiturienten
	</div>
	<div class="box">
		<table>
			{foreach $people as $user}
			<tr>
				<td class="name">
					{$user.firstname} {$user.lastname}
				</td>
				<td class="action">{if $user.user != 0}<a href="/profile?user={$user.user}">Steckbrief</a>{/if}</td>
			</tr>
			{/foreach}
		</table>
	</div>
</div>
{include file="foot.tpl"}