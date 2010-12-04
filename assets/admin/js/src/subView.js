/**
 * 子视图控件
 */
var subView = (function( $ ){
	var curViewParam;

	/**
	 * 当前视图参数操作
	 */
	var curParam = {
		/**
		 * 设置当前视图参数
		 *
		 * @param {string|Object} param 要设置的参数
		 */
		set: function( param ) {
			curViewParam = param;
		},

		/**
		 * 返回当前视图参数
		 */
		get: function() {
			return curViewParam;
		},

		clean: function() {
			curViewParam = null;
		}
	};

	return {
		'curParam': curParam
	};

})( jQuery );