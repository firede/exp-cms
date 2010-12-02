(function( $ ){

	var optHoverClass = 'operation-btn-hover';

	// 初始化表格
	$('.list-table tbody tr:odd').addClass('odd');
	$('#status-' + PAGEENV.param.status).addClass('status-tab-active');

	// 全选
	$('.js-mutiopt-select').click(function(){
		$('.list-table input[name=select]').each(function() {
			this.checked = true;
		});
	})
	.hover(
		function() {
			$(this).addClass(optHoverClass);
		},
		function() {
			$(this).removeClass(optHoverClass);
		}
	);

	// 反选
	$('.js-mutiopt-inverse').click(function(){
		$('.list-table input[name=select]').each(function() {
			this.checked = !this.checked;
		});
	})
	.hover(
		function() {
			$(this).addClass(optHoverClass);
		},
		function() {
			$(this).removeClass(optHoverClass);
		}
	);

})( jQuery );
