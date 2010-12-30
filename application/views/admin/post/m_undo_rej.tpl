<div id="subviewMUndoRej" class="subview">
	<div class="desc">你确定要将这些文章<strong>撤销驳回</strong>么？</div>
	<div class="clearfix">
		<span class="submit radius_all">确定</span>
		<span class="cancel radius_all">取消</span>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function () {
	var container	= $('#subviewMUndoRej'),
		submit		= container.find('.submit'),
		cancel		= container.find('.cancel'),
		target		= dxn.subView.curTarget.get(),
		id			= dxn.subView.curParam.get(),
		baseUrl		= dxn.util.base;

	if (id === '') {
		container.html('<div>请先钩选需要<strong>撤销驳回</strong>的文章再进行操作。</div>');
	}

	submit.click(function () {
		$.post(
			baseUrl + 'admin/post/m_undo_rej_post',
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
		target.qtip('hide');
	});
});
</script>