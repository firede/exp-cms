/**
 * 多行操作栏组件
 */
var mutiOperation = (function( $ ){
	var wrap			= $('.operation-bar'),
		btnAll			= wrap.find('.operation-btn'),
		btnSelect		= wrap.find('.js-mutiopt-select'),
		btnInverse		= wrap.find('.js-mutiopt-inverse'),
		btnDelete		= wrap.find('.js-mutiopt-delete'),
		btnAudit		= wrap.find('.js-mutiopt-audit'),
		btnFlag			= wrap.find('.js-mutiopt-flag'),
		btnMove			= wrap.find('.js-mutiopt-move'),
		btnUndoPub		= wrap.find('.js-mutiopt-undo-pub'),
		btnUndoRej		= wrap.find('.js-mutiopt-undo-rej');

	// 整体设置
	btnAll.each(function() {
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

})( jQuery );
