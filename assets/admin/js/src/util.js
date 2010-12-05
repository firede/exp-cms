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
	 * 外部可访问的接口
	 */
	return {
		'base'		: base,
		'param'		: param,
		'version'	: version
	};
}(jQuery));
