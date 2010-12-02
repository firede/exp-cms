(function( $ ){

	// 初始化表格
	$('.list-table tbody tr:odd').addClass('odd');
	$('#status-' + PAGEENV.param.status).addClass('status-tab-active');

	// 全选
	$('.js-mutiopt-select').click(function(){
		$('.list-table input[name=select]').each(function() {
			this.checked = true;
		});
	});

	// 反选
	$('.js-mutiopt-inverse').click(function(){
		$('.list-table input[name=select]').each(function() {
			this.checked = !this.checked;
		});
	});

})( jQuery );
