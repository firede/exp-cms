/**
 * 数据表格组件
 */
var dataTable = (function( $ ){
	var wrap		= $('.list-table'),
		thSort		= wrap.find('.js-sort'),
		tbody		= wrap.find('tbody'),
		tooltips	= wrap.find('span[qtip=1]'),
		btnsDelete	= tbody.find('.js-opt-delete'),
		btnsAudit	= tbody.find('.js-opt-audit'),
		btnsMove	= tbody.find('.js-opt-move'),
		btnsFlag	= tbody.find('.js-opt-flag'),
		btnUndoRej	= tbody.find('.js-opt-undo-rej'),
		btnsPreview	= tbody.find('.js-opt-preview'),
		btnsAll		= tbody.find('.table-btn'),
		// 对话框基本参数设置，所有单行操作对话框都基于此设置创建
		dialogCfg	= {
			show: {when: 'click', solo: true},
			hide: {when: 'click'},
			position: {
				corner: {target: 'rightBottom', tooltip: 'rightTop'},
				adjust: {x: 8, y: 0}
			},
			style: { name: 'blue', width: 280 },
			content: {
				text: 'Loading...',
				title: { button: 'Close' }
			}
		};

	// 给偶数行表格添加样式
	tbody.find('tr:odd').addClass('tr-odd');

	// 给表格行添加Hover样式
	tbody.find('tr').hover(
		function(){ $(this).addClass('tr-hover'); },
		function(){ $(this).removeClass('tr-hover'); }
	);

	// 表头排序设置
	thSort.each(function(){
		var el				= $(this),
			orderBy			= el.attr('order_by'),
			sortType		= 'asc',
			envOrderBy		= util.param.get('order_by'),
			envSortType		= util.param.get('sort_type'),
			classSortHover	= 'js-sort-hover';

		// 添加当前排序状态图标
		if (orderBy === envOrderBy) {
			if (envSortType === 'asc') {
				sortType = 'desc';
			}
			el.append('<span class="sort-' + envSortType + '"></span>');
		}

		// 排序点击事件
		el.click(function(){
			util.param.set({
				'order_by'	: orderBy,
				'sort_type'	: sortType,
				'page'		: '1'
			});
		});

		// 排序Hover样式
		el.hover(
			function(){ el.addClass(classSortHover); },
			function(){ el.removeClass(classSortHover); }
		);
	});

	// 为标记了qtip标志的字段启用tips
	tooltips.qtip({
		style: {name: 'blue'},
		position: {target: 'mouse'}
	});

	btnsAll.each(function(){
		$(this).qtip(dialogCfg);
	});

	btnsDelete.each(function(){
		$(this).qtip('api').onRender = function() {
			alert('haha')
		}
	});

})( jQuery );
