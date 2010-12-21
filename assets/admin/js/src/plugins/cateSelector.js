(function ($) {

/**
 * 默认配置
 */
var settings = {
		url: '/admin/category/tree',
		prefix: 'ui-cateselector'
	};

var prefix = {
	list: settings.prefix + '-list',
	item: settings.prefix + '-item'
}

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

var tpls = {
	layoutWrap: '<div class="clearfix" style="border:1px solid blue;">{0}</div>',
	layoutList: '<div class="{0}" level="{1}" style="border:1px solid red;float:left;width:100px;padding:5px;"></div>',
	layoutItem: '<div style="line-height:20px;height:20px;margin:1px 0;">{0}</div>'
};

/**
 * 初始化主区域html
 */
function initMainHtml(container) {
	$.getJSON(settings.url, function (data) {
		settings.data = data;

		if (data.success === true) {
			createLayout(container);
			createItem(container, '0');
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
				alert(item.attr('item'));
			}
		});
	});
}


function createItem(container, level) {
	container.each(function() {
		var data		= settings.data,
			wrap		= $(this),
			levelMap	= {
				'0': wrap.find('.' + prefix.list + '[level=0]'),
				'1': wrap.find('.' + prefix.list + '[level=1]'),
				'2': wrap.find('.' + prefix.list + '[level=2]')
			};

		levelMap[level].html('haha');
	});
}

function getData (args) {
	var argsDef = {
		level : '0',
		parent : '-1'
	},
	data = settings.data;
	
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
