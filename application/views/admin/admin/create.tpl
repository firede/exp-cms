<{include file="admin/base/header.tpl"}>
<{include file="admin/base/aside.tpl"}>
<div class="grid_21">
	<h2 class="form-title">新建管理员</h2>
	<div class="form-table-wrap">
		<form action="<{$BASE_URL}>admin/admin/create_post" method="POST">
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
