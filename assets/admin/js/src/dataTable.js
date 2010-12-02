/**
 * 数据表格组件
 */
var dataTable = (function( $ ){
	var wrap		= $('.list-table'),
		tbody		= wrap.find('tbody'),
		thSort		= wrap.find('.js-sort');

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

})( jQuery );
