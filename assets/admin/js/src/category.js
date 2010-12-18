dxn.category = (function ($) {
	var btns = $('.ch-cate-btn');

	btns.each(function () {
		var btn = $(this);

		btn.qtip({
			show: { when: 'click', solo: true },
			hide: { when: 'click' },
			position: {
				corner: {target: 'bottomRight', tooltip: 'topRight'},
				adjust: {x: 0, y: 0}
			},
			style: { name: 'blue', width: 300 },
			content: {
				text: '载入中...',
				title: { text: '切换分类', button: '关闭' }
			},
			api: {
				beforeShow: function () {
					// el.addClass(classActive);
				},
				beforeHide: function () {
					// el.removeClass(classActive);
				},
				onShow: function () {
					this.loadContent(
						dxn.util.base + 'admin/post/change_category',
						{ 'v': dxn.util.version }
					);
				}
			}
		});
	});

	function getData(callback) {
		$.get(dxn.util.base + 'admin/category/tree', function (data) {
			callback($.parseJSON(data));
		});
	}

	function getTree() {
		getData(function(data){
			var j = data;
			return typeof j;
		});
	}

	return {
		'getTree': getTree,
		'getData': getData
	}
}(jQuery));