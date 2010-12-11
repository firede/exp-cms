<{include file="admin/base/header.tpl"}>
<{include file="admin/base/aside.tpl"}>
<div class="grid_21">
	<h2>系统设置</h2>
	<div class="form-table-wrap">
		<form action="<{$BASE_URL}>admin/setting/system_post" method="POST">
			<table class="form-table">
				<tr>
					<th>站点标题</th>
					<td><input type="text" /></td>
				</tr>
				<tr>
					<th>站点地址</th>
					<td>
						<input type="text" />
						<span style="color:#CCC;">这里是一些说明文字</span>
						<div style="color:red;">请输入正确的URL</div>
					</td>
				</tr>
				<tr>
					<th>站点描述</th>
					<td><textarea cols="40" rows="4"></textarea></td>
				</tr>
				<tr>
					<th>关键词</th>
					<td><input type="text" /></td>
				</tr>
				<tr>
					<th>注册选项</th>
					<td>
						<select>
							<option value="1">开放注册</option>
							<option value="0">关闭注册</option>
						</select>
					</td>
				</tr>
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
