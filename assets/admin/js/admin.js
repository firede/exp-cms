document.write('<script type="text/javascript" src="/assets/admin/js/src/util.js"></script>');
document.write('<script type="text/javascript" src="/assets/admin/js/src/dataTable.js"></script>');
document.write('<script type="text/javascript" src="/assets/admin/js/src/tableSearch.js"></script>');
document.write('<script type="text/javascript" src="/assets/admin/js/src/mutiOperation.js"></script>');

$(document).ready(function(){

$('#status-' + util.param.get('status')).addClass('status-tab-active');

//var mutiConfig = {
//	show: {when: 'click', solo: true},
//	hide: {when: 'click'},
//	position: {
//		corner: {target: 'bottomLeft', tooltip: 'topLeft'},
//		adjust: {x: -8, y: 0}
//	}
//}
//
//$(".js-mutiopt-delete").each(function(){
//	var el = $(this);
//
//	el.hover(
//		function() {
//			el.addClass('operation-btn-hover');
//		},
//		function() {
//			el.removeClass('operation-btn-hover');
//		}
//	);
//
//	el.qtip({
//		content: {
//			data: {id: '1,2,3,7,9'},
//			method: 'get',
//			url: '/admin/post/m_del',
//			text: 'Loading...',
//			title: {
//				text: '批量操作：选中11项',
//				button: '关闭'
//			}
//		},
//		api: {
//			onShow: function(){
//				el.addClass('operation-btn-active');
//			},
//			onHide: function(){
//				el.removeClass('operation-btn-active');
//			}
//		},
//		style: {
//			name: 'blue',
//			width: 300
//		},
//		show: mutiConfig.show,
//		hide: mutiConfig.hide,
//		position: mutiConfig.position
//	});
//});
//
//
//var lineConfig = {
//	show: {when: 'click', solo: true},
//	hide: {when: 'click'},
//	position: {
//		corner: {target: 'rightBottom', tooltip: 'rightTop'},
//		adjust: {x: 8, y: 0}
//	}
//}
//
//$(".js-opt-delete").each(function(){
//	var me = this;
//
//	$(this).qtip({
//		content: {
//			text: 'Loading...',
//			title: {
//				text: '删除',
//				button: '关闭'
//			}
//		},
//		api: {
//			onShow: function(){
//				$(me).addClass('table-btn-active');
//			},
//			onRender: function() {
//				var row_id = $(me).closest("tr").attr("row_id");
//				this.loadContent('/admin/post/del', {id: row_id}, 'get');
//			},
//			onHide: function(){
//				$(me).removeClass('table-btn-active');
//			}
//		},
//		style: {
//			name: 'blue',
//			width: 300
//		},
//		show: lineConfig.show,
//		hide: lineConfig.hide,
//		position: lineConfig.position
//	});
//});

});