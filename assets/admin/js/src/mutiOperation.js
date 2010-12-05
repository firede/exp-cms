/**
 * 多行操作栏组件
 */
dxn.mutiOperation = (function ($) {
	var wrap			= $('.operation-bar'),
		allBtns			= wrap.find('.operation-btn'),
		dialogBtns		= wrap.find('.operation-btn[action!=]'),
		btnSelect		= wrap.find('.js-mutiopt-select'),
		btnInverse		= wrap.find('.js-mutiopt-inverse'),
		btnDelete		= wrap.find('.js-mutiopt-del'),
		btnAudit		= wrap.find('.js-mutiopt-audit'),
		btnFlag			= wrap.find('.js-mutiopt-flag'),
		btnMove			= wrap.find('.js-mutiopt-move'),
		btnUndoPub		= wrap.find('.js-mutiopt-undo-pub'),
		btnUndoRej		= wrap.find('.js-mutiopt-undo-rej'),
		classActive		= 'operation-btn-active';

	// 整体设置
	allBtns.each(function () {
		var el				= $(this),
			classBtnHover	= 'operation-btn-hover';

		// 增加操作栏Hover效果
		el.hover(
			function () {
				el.addClass(classBtnHover);
			},
			function () {
				el.removeClass(classBtnHover);
			}
		);
	});

	// 全选
	btnSelect.click(dxn.dataTable.option.setAll);

	// 反选
	btnInverse.click(dxn.dataTable.option.setInverse);

	// 统一对批量操作的对话框初始化
	dialogBtns.each(function () {
		var el = $(this),
			elTitle = el.attr('title');

		el.qtip({
			show: { when: 'click', solo: true },
			hide: { when: 'click' },
			position: {
				corner: {target: 'bottomLeft', tooltip: 'topLeft'},
				adjust: {x: -20, y: 0}
			},
			style: { name: 'blue', width: 300 },
			content: {
				text: '载入中...',
				title: { text: '批量' + elTitle, button: '关闭' }
			},
			api: {
				beforeShow: function () {
					el.addClass(classActive);
				},
				beforeHide: function () {
					el.removeClass(classActive);
				},
				onShow: function () {
					var count = dxn.dataTable.option.getSelectedCount(),
						tpl = '批量{0}：选中<strong>{1}</strong>条数据';
					this.updateTitle(dxn.util.format(tpl, elTitle, count));
					this.loadContent(
						dxn.util.base + el.attr('action'),
						{ 'v': dxn.util.version }
					);
				}
			}
		});
	});

	return {
		'dialogBtns': dialogBtns
	};


}(jQuery));
