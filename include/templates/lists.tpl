{include file="head.tpl"}
{include file="lists_{$smarty['get']['list']}.tpl"}
<div class="section">
	<div class="hl">
		{$list['title']}
	</div>
	<div class="box">
		<table>
			<tr style="font-weight: bold;">
				{foreach $list['columns'] as $column}
				<td>{$column}</td>
				{/foreach}
			</tr>
			{foreach $list['rows'] as $row}
			<tr>
				{foreach $list['columns'] as $column}
				<td>{$row[$column@key]}</td>
				{/foreach}
			</tr>
			{/foreach}
		</table>
	</div>
</div>
{include file="foot.tpl"}