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
	<a class="status-tab status-tab-active" href="<{$BASE_URL}>admin/category/list">分类列表</a>
	<span class="list-search right">
		<span class="keyword radius_all">
			<input type="text" name="keyword" />
		</span>
		<span class="search radius_all">搜索</span>
	</span>
</div>
<{admintable data=$view_data.result conf=$conf}>

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
