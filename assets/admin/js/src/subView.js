/**
 * 子视图控件
 */
dxn.subView = (function ($) {
	var curViewParam,
		curViewTarget;

	/**
	 * 当前视图参数操作
	 */
	var curParam = {
		/**
		 * 设置当前视图参数
		 *
		 * @param {string|Object} param 要设置的参数
		 */
		set: function (param) {
			curViewParam = param;
		},

		/**
		 * 返回当前视图参数
		 */
		get: function () {
			return curViewParam;
		}
	};

	/**
	 * 当前视图目标元素操作（绑定弹窗的按钮）
	 */
	var curTarget = {
		/**
		 * 设置当前视图目标元素
		 *
		 * @param {jQueryElement} 要设置的对象
		 */
		set: function (el) {
			curViewTarget = el;
		},

		/**
		 * 返回当前视图目标元素
		 */
		get: function () {
			return curViewTarget;
		}
	};

	return {
		'curParam'	: curParam,
		'curTarget'	: curTarget
	};

}(jQuery));