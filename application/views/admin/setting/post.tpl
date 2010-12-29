<{include file="admin/base/header.tpl"}>
<{include file="admin/base/aside.tpl"}>
<div class="grid_21">
	<ul class="setting-menu clearfix radius_all">
		<li><a href="<{$BASE_URL}>admin/setting/site">网站设置</a></li>
		<li><a href="<{$BASE_URL}>admin/setting/cache">缓存设置</a></li>
		<li><a href="<{$BASE_URL}>admin/setting/up_img">图片上传设置</a></li>
		<li><a href="<{$BASE_URL}>admin/setting/up_file">文件上传设置</a></li>
		<li><a href="<{$BASE_URL}>admin/setting/user">用户设置</a></li>
		<li class="selected"><a href="<{$BASE_URL}>admin/setting/post">文章设置</a></li>
		<li><a href="<{$BASE_URL}>admin/setting/advanced">高级选项设置</a></li>
	</ul>
	<h2 class="form-title">文章设置</h2>
	<div class="form-table-wrap">
		<form action="<{$BASE_URL}>admin/setting/post_post" method="POST">
			<table class="form-table">
				<{form data=$form}>
			</table>
			<div><input type="submit" value="提交" /></div>
		</form>
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
