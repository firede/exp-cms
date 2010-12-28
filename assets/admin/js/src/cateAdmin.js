dxn.cateAdmin = (function ($) {
	var btns = $('.ch-cate-btn'),
		classBtnActive = 'exlink-active';

	btns.each(function () {
		var el = $(this);

		el.qtip({
			show: { when: 'click', solo: true },
			hide: { when: 'click' },
			position: {
				corner: {target: 'bottomRight', tooltip: 'topRight'},
				adjust: {x: 5, y: 0}
			},
			style: { name: 'blue', width: 400 },
			content: {
				text: '载入中...',
				url: dxn.util.base + 'admin/post/change_category',
				data: { 'v': dxn.util.version }
			},
			api: {
				beforeShow: function () {
					el.addClass(classBtnActive);
				},
				beforeHide: function () {
					el.removeClass(classBtnActive);
				},
				onRender: function () {
					dxn.subView.curTarget.set(el);
				}
			}
		});
	});

}(jQuery));