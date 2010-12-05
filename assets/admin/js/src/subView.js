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
		},

		clean: function () {
			curViewParam = null;
		}
	};

	var curTarget = {
		set: function (el) {
			curViewTarget = el;
		},
		get: function () {
			return curViewTarget;
		},
		clean: function () {
			curViewTarget = null;
		}
	}

	return {
		'curParam'	: curParam,
		'curTarget'	: curTarget
	};

}(jQuery));