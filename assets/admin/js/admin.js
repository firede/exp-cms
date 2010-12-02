document.write('<script type="text/javascript" src="/assets/admin/js/src/util.js"></script>');
document.write('<script type="text/javascript" src="/assets/admin/js/src/dataTable.js"></script>');
document.write('<script type="text/javascript" src="/assets/admin/js/src/tableSearch.js"></script>');
document.write('<script type="text/javascript" src="/assets/admin/js/src/mutiOperation.js"></script>');

$('#status-' + util.param.get('status')).addClass('status-tab-active');

(function( $ ) {

function initTooltip() {
	$('span[qtip=1]').qtip({
		style: {name: 'cream', tip: false},
		position: {target: 'mouse'},
		show: {effect: {type: 'fade', length:0}},
		hide: {effect: {type: 'fade', length:0}}
	});
}

var mutiConfig = {
	style: {
		tip: false,
		border: {width: 2, radius: 0, color: '#0073B3'},
		width: 300
	},
	show: {when: 'click', solo: true, effect: {type: 'fade', length:0}},
	hide: {when: 'click', effect: {type: 'fade', length:0}},
	position: {
		corner: {target: 'bottomLeft', tooltip: 'topLeft'},
		adjust: {x: -8, y: 0}
	}
}

$(".js-mutiopt-delete").each(function(){
	var el = $(this);

	el.hover(
		function() {
			el.addClass('operation-btn-hover');
		},
		function() {
			el.removeClass('operation-btn-hover');
		}
	);

	el.qtip({
		content: {
			data: {id: '1,2,3,7,9'},
			method: 'get',
			url: '/admin/post/m_del',
			text: 'Loading...'
		},
		api: {
			onShow: function(){
				el.addClass('operation-btn-active');
			},
			onHide: function(){
				el.removeClass('operation-btn-active');
			}
		},
		style: mutiConfig.style,
		show: mutiConfig.show,
		hide: mutiConfig.hide,
		position: mutiConfig.position
	});
});


var lineConfig = {
	style: {
		tip: false,
		border: {width: 2, radius: 0, color: '#0073B3'},
		width: 300
	},
	show: {when: 'click', solo: true, effect: {type: 'fade', length:0}},
	hide: {when: 'click', effect: {type: 'fade', length:0}},
	position: {
		corner: {target: 'rightBottom', tooltip: 'rightTop'},
		adjust: {x: 8, y: 0}
	}
}

$(".js-opt-delete").each(function(){
	var me = this;

	$(this).qtip({
		content: {
			method: 'get',
			url: '/admin/post/del',
			text: 'Loading...'
		},
		api: {
			onShow: function(){
				$(me).addClass('table-btn-active');
			},
			onRender: function() {
				var row_id = $(me).closest("tr").attr("row_id");
				this.loadContent('/admin/post/del', {id: row_id}, 'get');
			},
			onHide: function(){
				$(me).removeClass('table-btn-active');
			}
		},
		style: lineConfig.style,
		show: lineConfig.show,
		hide: lineConfig.hide,
		position: lineConfig.position
	});
});

initTooltip();


})( jQuery );