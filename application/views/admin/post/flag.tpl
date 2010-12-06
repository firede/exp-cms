<div class="operation-subview">
	<div class="desc">你想将这条经验<strong>标记</strong>为：</div>
	<div class="form">
		<label><input type="checkbox" name="flag" value="1" />精华</label>
		<label><input type="checkbox" name="flag" value="2" />置顶</label>
		<label><input type="checkbox" name="flag" value="3" />推荐</label>
	</div>
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
		target		= dxn.subView.curTarget.get(),
		id			= dxn.subView.curParam.get(),
		inputFlags	= container.find('input[name=flag]'),
		curFlags	= target.closest('tr').find('.js-flag'),
		baseUrl		= dxn.util.base;

	// 初始化checkbox的默认值
	inputFlags.each(function () {
		var cbox	= $(this),
			cboxVal	= cbox.val(),
			curFlag	= curFlags.filter('[val='+cboxVal+']').length;
		
			cbox.attr('checked', curFlag);
	});

	function getFlag() {
		var flagArr = [];
		
		inputFlags.each(function () {
			var el = $(this);
			if (el.attr('checked') == '1') {
				flagArr.push(el.val());
			}
		});

		return flagArr.join(',');
	}

	submit.click(function () {
		var flag = getFlag();

		$.post(
			baseUrl + 'admin/post/flag_post',
			{
				'id': id,
				'flag': flag
			},
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
