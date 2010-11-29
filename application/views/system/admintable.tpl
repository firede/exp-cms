<{if $_muti_operation|default}>
<div class="operation-bar clearfix">
	<{foreach from=$_muti_operation item=item key=key}>
	<span class="operation-btn" title="<{$item}>"><span class="icon-<{$key}>"></span><{$item}></span>
	<{/foreach}>
</div>
<{/if}>
<table class="list-table">
	<thead>
		<tr>
			<{foreach from=$_column item=column key=key}>
			<th col_id="<{$key}>"><{$column.label}></th>
			<{/foreach}>
			<{* 判断是否添加操作列表头 *}>
			<{if $_operation|default}>
			<th>操作</th>
			<{/if}>
		</tr>
	</thead>
	<tbody>
		<{foreach from=$_data item=item key=key}>
		<tr row_id="<{$key}>">
			<{foreach from=$_column item=column}>
			<td><{basetpl data=$item conf=$column.data tpl=$column.template prefix=$column.prefix|default}></td>
			<{/foreach}>
			<{* 判断是否添加操作列 *}>
			<{if $_operation|default}>
			<td>
				<{foreach from=$_operation item=item key=key}>
				<span class="table-btn icon-<{$key}>" title="<{$item}>">
					<span><{$item}></span>
				</span>
				<{/foreach}>
			</td>
			<{/if}>
		</tr>
		<{/foreach}>
	</tbody>
</table>