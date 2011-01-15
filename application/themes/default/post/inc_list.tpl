<div class="mbox-wrap">
	<div class="mbox">
		<table class="list-table">
			<thead>
				<tr>
					<th style="width:450px;">标题</th>
					<th style="width:130px;">作者</th>
					<th>更新时间</th>
				</tr>
			</thead>
			<tbody>
				<{foreach from=$view_data.result item=item}>
				<tr>
					<td><a href="<{$item.cate_id}>" class="title"><{$item.title}></a><a href="<{$item.cate_id}>">[<{$item.cate_name}>]</a></td>
					<td><a href="http://zhaolei.info"><{$item.user_name}></a></td>
					<td><span class="date"><{$item.update_time|date_format:"%Y-%m-%d"}></span></td>
				</tr>
				<{/foreach}>
			</tbody>
		</table>
		<{$pagination}>
	</div>
</div>