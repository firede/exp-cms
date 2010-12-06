<div class="operation-subview">
	<div class="desc"><strong>审核</strong>批注：</div>
	<div class="form">
		<textarea name="operation_desc" cols="26" rows="2"></textarea>
	</div>
	<div class="clearfix">
		<span class="submit js-btn-pub radius_all">全部通过</span>
		<span class="submit js-btn-rej radius_all">全部驳回</span>
		<span class="cancel radius_all">取消</span>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function () {
	var container	= $('.operation-subview'),
		btnPub		= container.find('.js-btn-pub'),
		btnRej		= container.find('.js-btn-rej'),
		cancel		= container.find('.cancel'),
		taDesc		= container.find('[name=operation_desc]'),
		target		= dxn.subView.curTarget.get(),
		id			= dxn.subView.curParam.get(),
		baseUrl		= dxn.util.base;

	function getDesc() {
		return taDesc.val();
	}

	function postAction(status) {
		var desc = getDesc();

		$.post(
			baseUrl + 'admin/post/m_audit_post',
			{
				'id': id,
				'status': status,
				'operation_desc': desc
			},
			function(obj){
				if (obj.success == true) {
					container.append('<div class="msg-success">' + obj.message + '</div>');
					location.reload();
				} else {
					container.append('<div class="msg-error">' + obj.message + '</div>');
				}
			}, 'json');
	}

	btnPub.click(function () {
		postAction('1');
	});

	btnRej.click(function () {
		postAction('3');
	});

	cancel.click(function () {
		target.qtip('hide');
	});
});
</script>
