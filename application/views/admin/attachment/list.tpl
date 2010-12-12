<{include file="admin/base/header.tpl"}>
<{include file="admin/base/aside.tpl"}>
<div class="grid_21">
<{debug}>
<div class="grid_18 alpha">
	<div class="breadcrumbs">
		<span class="icon-position"></span>
		<a href="<{$BASE_URL}>admin">后台首页</a> &raquo
		<a href="<{$BASE_URL}>admin/category">分类</a> &raquo
		<span>列表</span>
	</div>
</div>

<div class="clear"></div>

<div class="status-bar clearfix radius_top">
	<a id="useType-0" class="status-tab" href="?use_type=0">文章</a>
	<a id="useType-1" class="status-tab" href="?use_type=1">头像</a>
	<span class="list-search right">
		<span class="keyword radius_all">
			<input type="text" name="keyword" />
		</span>
		<span class="search radius_all">搜索</span>
	</span>
</div>

<{admintable data=$view_data.result conf=$conf}>

<div class="pagination-bar clearfix radius_bottom">
	<div class="grid_12"><{$pagination}></div>
	<div class="grid_8 right">
	共<{$view_data.total_page_count|default:0}>页, 共<{$view_data.total_items_count|default:0}>条
	</div>
</div>

</div>

<script type="text/javascript">
	<{* 页面环境变量&配置 *}>
	var dxn = window.dxn || {};
	dxn.PAGEENV = {
		"base": "<{$BASE_URL|escape:javascript}>",
		"param": <{$URL_PARAMS}>,
		"version": "<{$VERSION}>"
	};
	$(document).ready(function(){
		$('#useType-' + dxn.util.param.get('use_type')).addClass('status-tab-active');
	});
</script>

<script type="text/javascript" src="<{$BASE_URL}>assets/admin/js/admin.js"></script>

<{include file="admin/base/footer.tpl"}>
