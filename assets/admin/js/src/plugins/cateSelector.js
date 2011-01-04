(function ($) {

	/**
	 * 默认配置
	 */
	var settings = {
			url: '/admin/category/tree',
			prefix: 'ui-cateselector'
		},
		prefix = {
			list: settings.prefix + '-list',
			item: settings.prefix + '-item'
		},
		tpls = {
			layoutWrap: '<div class="clearfix" style="border:1px solid blue;">{0}</div>',
			layoutList: '<div class="{0}" level="{1}" style="border:1px solid red;float:left;width:100px;padding:5px;"></div>',
			layoutItem: '<div class="{1}" level="{2}" item="{3}" style="line-height:20px;height:20px;margin:1px 0;">{0}</div>'
		};

	/**
	 * 方法
	 */
	var methods = {
		/**
		 * 初始化控件
		 *
		 * @param {Object} options 自定义配置
		 */
		init: function (options) {
			if (options) {
				$.extend(settings, options);
			}

			// 初始化主视图
			initMainHtml(this);
			initMainEvent(this);
		},

		/**
		 * 销毁控件
		 */
		destroy: function () {

		},

		/**
		 * 获取选中分类
		 */
		getSelected: function () {
			return 'test';
		}
	};

	/**
	 * 初始化主区域html
	 */
	function initMainHtml(container) {
		$.getJSON(settings.url, function (data) {
			settings.data = data;

			if (data.success === true) {
				createLayout(container);
				createItem(container, '0', '-1');
			}
		});
	}

	function createLayout(container) {
		var listMap = [], i;

		for (i=0; i<3; i++) {
			listMap.push(
				dxn.util.format(
					tpls.layoutList,
					prefix.list,
					i
				));
		}

		container.each(function () {
			container.html(
				dxn.util.format(
					tpls.layoutWrap,
					listMap.join('')
				));
		});
	}

	/**
	 * 初始化主区域事件
	 */
	function initMainEvent(container) {
		container.each(function () {
			$(this).click(function (e) {
				e = e || window.event;
				var tar = e.target || e.srcElement,
					item = $(tar).closest('[item]', this);

				if (item.length > 0) {
					createItem(container, item.attr('level'), item.attr('item'));
				}
			});
		});
	}


	function createItem(container, level, curId) {
		container.each(function() {
			var wrap		= $(this),
				data		= settings.data.result,
				levelMap	= {
					'0': wrap.find('.' + prefix.list + '[level=0]'),
					'1': wrap.find('.' + prefix.list + '[level=1]'),
					'2': wrap.find('.' + prefix.list + '[level=2]')
				};

			if (parseInt(level, 10) > 2) {
				return;
			}

			getChildData(data, curId, function(dataList) {
				var key, listArr = [];

				for (key in dataList) {
					listArr.push(dxn.util.format(
						tpls.layoutItem,
						dataList[key]['name'],
						prefix.item,
						(parseInt(level, 10) + 1).toString(),
						dataList[key]['id']
					));
				}
				levelMap[level].html(listArr.join(''));
			});

		});
	}

	/**
	 * 递归获取子分类数据
	 *
	 * @param {Object} dsObj 数据对象
	 * @param {string} curId 想获取的分类ID
	 * @param {Function} callback 回掉函数，第一个参数是返回的数据对象
	 */
	function getChildData (dsObj, curId, callback) {
		var key;

		if (curId === '-1') {
			callback(dsObj);
			return;
		}

		for(key in dsObj) {
			if (key === curId) {
				callback(dsObj[key]['child']);
			} else if (dsObj[key]['has_child'] === true) {
				getChildData(dsObj[key]['child'], curId, callback);
			}
		}
	}

	/**
	 * 分类选择器插件
	 *
	 * @param {string} method 方法（可选，不存在时自动走init方法）
	 * @param {Object} 配置
	 */
	$.fn.cateSelector = function (method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error( 'Method "' + method + '" does not exist!');
		}
	};

}(jQuery));
