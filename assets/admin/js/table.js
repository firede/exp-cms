(function( $ ){

	// 初始化表格
	$('.list-table tbody tr:odd').addClass('odd');
	$('#status-' + PAGEENV.param.status).addClass('status-tab-active');

})( jQuery );
