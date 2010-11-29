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

<{admintable data=$view_data.result conf=$conf}>

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
