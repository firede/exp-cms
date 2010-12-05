/**
 * 数据表格组件
 */
dxn.dataTable = (function ($) {
	var wrap		= $('.list-table'),
		thSort		= wrap.find('.js-sort'),
		tbody		= wrap.find('tbody'),
		tooltips	= tbody.find('span[qtip=1]'),
		dialogBtns  = tbody.find('.table-btn[action!=]'),
		cbOptions	= tbody.find('input[name=select]'),
		classActive	= 'table-btn-active',
		btn			= {
			'del'		: tbody.find('.js-opt-del'),
			'audit'		: tbody.find('.js-opt-audit'),
			'move'		: tbody.find('.js-opt-move'),
			'flag'		: tbody.find('.js-opt-flag'),
			'undoRej'	: tbody.find('.js-opt-undo-rej'),
			'preview'	: tbody.find('.js-opt-preview')
		};

	// 给偶数行表格添加样式
	tbody.find('tr:odd').addClass('tr-odd');

	// 给表格行添加Hover样式
	tbody.find('tr').hover(
		function () {
			$(this).addClass('tr-hover');
		},
		function () {
			$(this).removeClass('tr-hover');
		}
	);

	// 表头排序设置
	thSort.each(function () {
		var el				= $(this),
			orderBy			= el.attr('order_by'),
			sortType		= 'asc',
			envOrderBy		= dxn.util.param.get('order_by'),
			envSortType		= dxn.util.param.get('sort_type'),
			classSortHover	= 'js-sort-hover';

		// 添加当前排序状态图标
		if (orderBy === envOrderBy) {
			if (envSortType === 'asc') {
				sortType = 'desc';
			}
			el.append('<span class="sort-' + envSortType + '"></span>');
		}

		// 排序点击事件
		el.click(function () {
			dxn.util.param.set({
				'order_by'	: orderBy,
				'sort_type'	: sortType,
				'page'		: '1'
			});
		});

		// 排序Hover样式
		el.hover(
			function () {
				el.addClass(classSortHover);
			},
			function () {
				el.removeClass(classSortHover);
			}
		);
	});

	// 为标记了qtip标志的字段启用tips
	tooltips.qtip({
		style: {name: 'blue'},
		position: {target: 'mouse'}
	});

	// 统一对行级操作的对话框初始化
	dialogBtns.each(function () {
		var el = $(this),
			elSizeX = el.attr('size_x'),
			dialogWidth = (elSizeX == '') ? 280 : parseInt(elSizeX);

		el.qtip({
			show: {when: 'click', solo: true},
			hide: {when: 'click'},
			position: {
				corner: {target: 'rightBottom', tooltip: 'rightTop'},
				adjust: {x: 20, y: 0}
			},
			style: {name: 'blue', width: dialogWidth },
			content: {
				text: '载入中...',
				title: {text: el.attr('title'), button: '关闭'}
			},
			api: {
				beforeShow: function () {
					el.addClass(classActive);
				},
				beforeHide: function () {
					el.removeClass(classActive);
					this.updateContent(this.options.content.text);
				},
				onShow: function () {
					dxn.subView.curTarget.set(el);
					dxn.subView.curParam.set(el.closest('tr[row_id]').attr('row_id'));
					
					this.loadContent(
						dxn.util.base + el.attr('action'),
						{ 'v': dxn.util.version }
					);
				}
			}
		});
	});

	// 当选项状态发生变化时隐藏多行操作的tips
	cbOptions.click(function () {
		dxn.mutiOperation.dialogBtns.each(function () {
			$(this).qtip("api").hide();
		});
	});

	/**
	 * 表格Checkbox选项操作
	 */
	var option = {
		/**
		 * 获取选中条目的值（数组格式）
		 *
		 * @return {Array}
		 */
		getSelected: function () {
			var valueList = [];

			cbOptions.filter('[checked!=]').each(function () {
				valueList.push($(this).val());
			});

			return valueList;
		},

		/**
		 * 获取选中条目的值（用逗号分隔的字符串）
		 *
		 * @param {string} separator 分隔符，默认为逗号
		 * @return {string}
		 */
		getSelectedString: function (separator) {
			if (!separator) {
				separator = ',';
			}

			return this.getSelected().join(separator);
		},

		/**
		 * 获取选中条目的个数
		 *
		 * @return {number}
		 */
		getSelectedCount: function () {
			return this.getSelected().length;
		},

		/**
		 * 全选
		 */
		setAll: function () {
			cbOptions.each(function () {
				this.checked = false;
				// 此处采用click，以触发绑定在checkbox上的事件
				$(this).click();
			});
		},

		/**
		 * 反选
		 */
		setInverse: function () {
			cbOptions.each(function () {
				$(this).click();
			});
		}
	};

	return {
		'option': option,
		'btn'	: btn
	};

}(jQuery));
