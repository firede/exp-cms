<div class="operation-subview">
	<div class="desc">请选择您想要进行批量操作的<strong>标记</strong>种类：</div>
	<div class="form">
		<label><input type="checkbox" name="flag" value="1" />精华</label>
		<label><input type="checkbox" name="flag" value="2" />置顶</label>
		<label><input type="checkbox" name="flag" value="3" />推荐</label>
	</div>
	<div class="clearfix">
		<span class="submit js-btn-flag radius_all">标记</span>
		<span class="submit js-btn-unflag radius_all">取消标记</span>
		<span class="cancel radius_all">取消</span>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function () {
	var container	= $('.operation-subview'),
		cancel		= container.find('.cancel'),
		btnFlag		= container.find('.js-btn-flag'),
		btnUnFlag	= container.find('.js-btn-unflag'),
		inputFlags	= container.find('input[name=flag]'),
		target		= dxn.subView.curTarget.get(),
		id			= dxn.subView.curParam.get(),
		baseUrl		= dxn.util.base;

	if (id === '') {
		container.html('<div>请先钩选需要更改<strong>标记</strong>的经验再进行操作。</div>');
	}
	
	// 初始化checkbox的默认值
	inputFlags.each(function () {
		$(this).attr('checked', 0);
	});

	// 获得选中的checkbox
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

	/**
	 * 发送请求
	 *
	 * @param {string} type 类型：0为取消标记，1为标记
	 */
	function postAction(type) {
		var flag = getFlag();

		$.post(
			baseUrl + 'admin/post/m_flag_post',
			{
				'id': id,
				'flag': flag,
				'type': type
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

	// 取消标记
	btnUnFlag.click(function () {
		postAction('0');
	});

	// 标记
	btnFlag.click(function () {
		postAction('1');
	});

	cancel.click(function () {
		target.qtip('hide');
	});
});
</script>