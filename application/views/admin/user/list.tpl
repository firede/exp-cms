<{include file="admin/base/header.tpl"}>
<{include file="admin/base/aside.tpl"}>
<div class="grid_21">

<div class="grid_18 alpha">
	<div class="breadcrumbs">
		<span class="icon-position"></span>
		<a href="<{$BASE_URL}>admin">后台首页</a> &raquo
		<a href="<{$BASE_URL}>admin/user">用户</a> &raquo
		<span>列表</span>
	</div>
</div>
<div class="grid_3 omega">
	<a href="<{$BASE_URL}>admin/user/create" class="exlink">
		<span class="icon-user-add"></span>
		创建用户
	</a>
</div>

<div class="clear"></div>

<div class="status-bar clearfix radius_top">
	<a class="status-tab status-tab-active" href="<{$BASE_URL}>admin/user/list">用户列表</a>
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
</script>

<script type="text/javascript" src="<{$BASE_URL}>assets/admin/js/admin.js"></script>

<{include file="admin/base/footer.tpl"}>
