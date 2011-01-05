<div id="subviewRestoreAll" class="subview">
	<div class="desc">你确定要<strong>还原</strong>回收站中的所有文章么？</div>
	<div class="clearfix">
		<span class="submit radius_all">确定</span>
		<span class="cancel radius_all">取消</span>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function () {
	var container	= $('#subviewRestoreAll'),
		submit		= container.find('.submit'),
		cancel		= container.find('.cancel'),
		target		= dxn.subView.curTarget.get(),
		id			= dxn.subView.curParam.get(),
		baseUrl		= dxn.util.base;

	submit.click(function () {
		$.post(
			baseUrl + 'admin/post/restore_all_post',
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
		target.qtip('hide');
	});
});
</script>