<div class="operation-subview">
	<div class="desc">你确定要<strong>删除</strong>这条经验么？</div>
	<div class="clearfix">
		<span class="submit radius_all">确定</span>
		<span class="cancel radius_all">取消</span>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function () {
	var container	= $('.operation-subview'),
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
					container.append('<div class="msg-success">' + obj.message + '</div>');
					location.reload();
				} else {
					container.append('<div class="msg-error">' + obj.message + '</div>');
				}
			}, 'json');
	});

	cancel.click(function () {
		dxn.dataTable.btn.del.qtip('hide');
	});
});
</script>
