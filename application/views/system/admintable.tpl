<table class="list-table">
	<thead>
		<tr>
			<{foreach from=$_column item=column key=key}>
			<th col_id="<{$key}>"><{$column.label}></th>
			<{/foreach}>
		</tr>
	</thead>
	<tbody>
		<{foreach from=$_data item=item key=key}>
		<tr row_id="<{$key}>">
			<{foreach from=$_column item=column}>
			<td><{basetpl data=$item conf=$column.data tpl=$column.template prefix=$column.prefix|default}></td>
			<{/foreach}>
		</tr>
		<{/foreach}>
	</tbody>
</table>