<{include file="admin/base/header.tpl"}>
<{include file="admin/base/aside.tpl"}>
<div class="grid_21">

<div class="grid_18 alpha">
	<div class="breadcrumbs">
		<span class="icon-position"></span>
		<a href="<{$base_url}>admin">后台首页</a> &raquo
		<a href="<{$base_url}>admin/post">经验</a> &raquo
		<a href="<{$base_url}>admin/post?cate_id=12">魔兽世界</a> &raquo
		<span>列表</span>
	</div>
</div>

<div class="grid_3 omega">
	<div class="exlink">
		<span class="icon-category"></span>
		<a href="<{$base_url}>category">切换分类</a>
	</div>
</div>

<div class="clear"></div>

<div class="status-bar clearfix radius_top">
	<a id="status-0" class="status-tab" href="?status=0">创建待审核</a>
	<a id="status-2" class="status-tab" href="?status=2">修改待审核</a>
	<a id="status-1" class="status-tab" href="?status=1">已发布</a>
	<a id="status-5" class="status-tab" href="?status=5">草稿</a>
	<a id="status-3" class="status-tab" href="?status=3">驳回</a>
</div>

<div class="operation-bar clearfix">
	<div class="grid_12">
		<a href="#" onclick="return false;" class="operation-btn"><span class="icon-select"></span>全选/取消</a>
		<a href="#" onclick="return false;" class="operation-btn"><span class="icon-inverse"></span>反选</a>
		<a href="#" onclick="return false;" class="operation-btn"><span class="icon-audit"></span>审核</a>
		<a href="#" onclick="return false;" class="operation-btn"><span class="icon-star"></span>精华</a>
		<a href="#" onclick="return false;" class="operation-btn"><span class="icon-del"></span>删除</a>
		<a href="#" onclick="return false;" class="operation-btn"><span class="icon-move"></span>移动</a>
	</div>
	<div class="grid_8 right">
	</div>
</div>

<table class="list-table">
	<thead>
		<tr>
			<th style="width:30px">选择</th>
			<th>标题</th>
			<th style="width:45px">点击</th>
			<th style="width:75px">日期</th>
			<th style="width:100px">作者</th>
			<th style="width:100px">分类</th>
			<th style="width:90px">操作</th>
		</tr>
	</thead>
	<tbody>
		<{assign var=items value=$view_data.result}>
		<{section name=i loop=$items}>
		<tr val="<{$items[i].id}>">
			<td><input type="checkbox" val="<{$items[i].id}>" /></td>
			<td><a href="#"><{$items[i].title}></a></td>
			<td><{$items[i].read_count}></td>
			<td><{$items[i].pub_time|date_format:"%Y-%m-%d"}></td>
			<td><{$items[i].user_id}></td>
			<td><{$items[i].cate_id}></td>
			<td>
				<a href="#" onclick="return false;" class="table-btn icon-audit" title="审核"><span>审核</span></a>
				<a href="#" onclick="return false;" class="table-btn icon-star" title="精华"><span>精华</span></a>
				<a href="#" onclick="return false;" class="table-btn icon-del" title="删除"><span>删除</span></a>
				<a href="#" onclick="return false;" class="table-btn icon-preview" title="预览"><span>预览</span></a>
			</td>
		</tr>
		<{sectionelse}>
		<tr><td colspan="7">木有数据...</td></tr>
		<{/section}>
	</tbody>
</table>
<div class="pagination-bar clearfix radius_bottom">
	<div class="grid_12"><{$pagination}></div>
	<div class="grid_8 right">
	共<{$view_data.total_page_count|default:0}>页/<{$view_data.total_items_count|default:0}>条
	</div>
</div>

</div>

<script type="text/javascript" src="<{$base_url}>assets/admin/js/admin.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$('#status-<{$view_data.status}>').addClass('status-tab-active');
	$('.list-table tbody tr:odd').addClass('odd');
});
</script>

<{include file="admin/base/footer.tpl"}>

<{debug}>
