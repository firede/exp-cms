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
	layoutItem: '<div class="{1}" level="{2}" parent="{3}" style="line-height:20px;height:20px;margin:1px 0;">{0}</div>'
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
		var wrap		= $(this),
			data		= settings.data.result,
			levelMap	= {
				'0': wrap.find('.' + prefix.list + '[level=0]'),
				'1': wrap.find('.' + prefix.list + '[level=1]'),
				'2': wrap.find('.' + prefix.list + '[level=2]')
			};

		levelMap[level].html('haha');

		getChildData(data, '4', function(datas) {
			console.log(datas);
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
		} else if (dsObj[key]['child'] != []) {
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

/*
var treeExample = {
	"result":{
		"1":{
			"id":"1",
			"name":"\u5c11\u6797\u8db3\u7403",
			"short_name":"shaolinzuqiu",
			"parent_id":"-1",
			"sort":"0",
			"parent_name":null,
			"has_child":false,
			"child":[]
		},
		"2":{
			"id":"2",
			"name":"\u6e38\u620f",
			"short_name":"games",
			"parent_id":"-1",
			"sort":"0",
			"parent_name":null,
			"has_child":true,
			"child":{
				"6":{
					"id":"6",
					"name":"\u690d\u7269\u5927\u6218\u50f5\u5c38",
					"short_name":"pvz",
					"parent_id":"2",
					"sort":"0",
					"parent_name":"\u6e38\u620f",
					"has_child":false,
					"child":[]
				},
				"4":{
					"id":"4",
					"name":"\u9b54\u517d\u4e16\u754c",
					"short_name":"wow",
					"parent_id":"2",
					"sort":"50",
					"parent_name":"\u6e38\u620f",
					"has_child":true,
					"child":{
						"7":{
							"id":"7",
							"name":"\u5deb\u5996\u738b\u4e4b\u6012",
							"short_name":"dk",
							"parent_id":"4",
							"sort":"0",
							"parent_name":"\u9b54\u517d\u4e16\u754c",
							"has_child":false,
							"child":[]
						},
						"8":{
							"id":"8",
							"name":"\u71c3\u70e7\u7684\u8fdc\u5f81",
							"short_name":"fire",
							"parent_id":"4",
							"sort":"0",
							"parent_name":"\u9b54\u517d\u4e16\u754c",
							"has_child":false,
							"child":[]
						}
					}
				},
		"5":{
			"id":"5",
			"name":"\u9b54\u517d\u4e89\u9738",
			"short_name":"war3",
			"parent_id":"2",
			"sort":"51",
			"parent_name":"\u6e38\u620f",
			"has_child":false,
			"child":[]
		}
	}
},
"3":{
	"id":"3",
	"name":"\u7535\u5f71",
	"short_name":"movie",
	"parent_id":"-1",
	"sort":"0",
	"parent_name":null,
	"has_child":false,
	"child":[]
}
},
"success":true,
"message":"\u64cd\u4f5c\u6210\u529f"
}
*/