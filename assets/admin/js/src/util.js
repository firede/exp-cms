/**
 * 通用工具
 */
dxn.util = (function ($) {
	var env			= dxn.PAGEENV,
		base		= env.base,
		paramSource	= env.param,
		version		= env.version;

	/**
	 * 参数管理器
	 */
	var param = {
		/**
		 * 设置参数并自动跳转页面
		 *
		 * @param {Object} obj 需要添加/修改的参数对象
		 */
		set: function (obj) {
			$.extend(paramSource, obj);
			window.location.search = $.param(paramSource);
		},
		/**
		 * 获取指定参数的值
		 *
		 * @param {string} index 参数的索引
		 * @return {string} 当index不存在时返回空字符串
		 */
		get: function (index) {
			return paramSource[index] || "";
		}
	};

	/**
	 * 格式化字符串（简易模板）
	 *
	 * @param {string}			source	目标字符串
	 * @param {Object|string*}	opts	提供相应数据的对象
	 * @return {string} 格式化后的字符串
	 * @author 原版来自erik
	 */
	function format (source, opts) {
		source = String(source);

		if ('undefined' != typeof opts) {
			if ('[object Object]' == Object.prototype.toString.call(opts)) {
				return source.replace(/\$\{(.+?)\}/g,
					function (match, key) {
						var replacer = opts[key];
						if ('function' == typeof replacer) {
							replacer = replacer(key);
						}
						return ('undefined' == typeof replacer ? '' : replacer);
					});
			} else {
				var data = Array.prototype.slice.call(arguments, 1),
				len = data.length;
				return source.replace(/\{(\d+)\}/g,
					function (match, index) {
						index = parseInt(index, 10);
						return (index >= len ? match : data[index]);
					});
			}
		}

		return source;
	}
	
	/**
	 * 外部可访问的接口
	 */
	return {
		'base'		: base,
		'param'		: param,
		'version'	: version,
		'format'	: format
	};
}(jQuery));
