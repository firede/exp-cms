<div class="operation-container">
	<p>你确定要删除文章么？</p>
	<div>
		<input type="submit" value="确定" class="submit" />
		<input type="button" value="取消" class="cancel" />
	</div>
</div>

<script type="text/javascript">
$(document).ready(function () {
	var container	= $('.operation-container'),
		submit		= container.find('.submit'),
		cancel		= container.find('.cancel'),
		id			= dxn.subView.curParam.get(),
		baseUrl		= dxn.util.base;

	submit.click(function () {
		$.post(
			baseUrl + 'admin/post/del_post',
			{ 'id': id },
			function(obj){
				if (obj.success == true) {
					container.append('<div style="color:green;">' + obj.message + '</div>');
					location.reload();
				} else {
					container.append('<div style="color:red;">' + obj.message + '</div>');
				}
			}, 'json');
	});

	cancel.click(function () {
		$('.js-opt-delete').qtip('hide');
	});
});
</script>
