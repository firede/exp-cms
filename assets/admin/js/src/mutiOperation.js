/**
 * 多行操作栏组件
 */
var mutiOperation = (function( $ ){
	var wrap			= $('.operation-bar'),
		allBtns			= wrap.find('.operation-btn'),
		dialogBtns		= wrap.find('span[action]'),
		btnSelect		= wrap.find('.js-mutiopt-select'),
		btnInverse		= wrap.find('.js-mutiopt-inverse'),
		btnDelete		= wrap.find('.js-mutiopt-delete'),
		btnAudit		= wrap.find('.js-mutiopt-audit'),
		btnFlag			= wrap.find('.js-mutiopt-flag'),
		btnMove			= wrap.find('.js-mutiopt-move'),
		btnUndoPub		= wrap.find('.js-mutiopt-undo-pub'),
		btnUndoRej		= wrap.find('.js-mutiopt-undo-rej'),
		classActive		= 'operation-btn-active';

	// 整体设置
	allBtns.each(function() {
		var el				= $(this),
			classBtnHover	= 'operation-btn-hover';

		// 增加操作栏Hover效果
		el.hover(
			function() { el.addClass(classBtnHover); },
			function() { el.removeClass(classBtnHover); }
		);
	});

	// 全选
	btnSelect.click(function(){
		$('.list-table input[name=select]').each(function() {
			this.checked = true;
		});
	});

	// 反选
	btnInverse.click(function() {
		$('.list-table input[name=select]').each(function() {
			this.checked = !this.checked;
		});
	});

	// 统一对批量操作的对话框初始化
	dialogBtns.each(function() {
		var el = $(this);

		el.qtip({
			show: {when: 'click', solo: true},
			hide: {when: 'click'},
			position: {
				corner: {target: 'bottomLeft', tooltip: 'topLeft'},
				adjust: {x: -20, y: 0}
			},
			style: { name: 'blue', width: 280 },
			content: {
				text: '载入中...',
				title: { text: '批量' + el.attr('title'), button: '关闭' }
			},
			api: {
				beforeShow: function(){
					el.addClass(classActive);
				},
				beforeHide: function(){
					el.removeClass(classActive);
				}
			}
		});
	});

	btnDelete.qtip('api').onShow = function() {
		this.loadContent(
			PAGEENV.base + btnDelete.attr('action'),
			{ id: '1,6,9,52' }
		);
	}

	// 批量删除

})( jQuery );
