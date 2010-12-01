(function( $ ) {

// 初始化提示层
$('a[title]').qtip({ style: { name: 'blue', tip: false }, position: { target: 'mouse' } })
$('span[title]').qtip({ style: { name: 'blue', tip: false }, position: { target: 'mouse' } })

var mutiConfig = {
	style: {
		tip: false,
		border: {
			width: 2,
			radius: 0,
			color: '#0073B3'
		},
		width: 300
	},
	show: {
		when: 'click',
		solo: true
	},
	hide: 'click',
	position: {
		corner: {
			target: 'bottomLeft',
			tooltip: 'topLeft'
		},
		adjust: {
			x: -8,
			y: 0
		}
	}
}

$(".js-mutiopt-delete").each(function(){
	var me = this;
	
	$(this).qtip({
		content: {
			data: { id: '1,2,3,7,9'},
			method: 'get',
			url: '/admin/post/m_del',
			text: 'Loading...'
		},
		api: {
			onShow: function(){
				$(me).addClass('operation-btn-active');
			},
			onHide: function(){
				$(me).removeClass('operation-btn-active');
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
		border: {
			width: 2,
			radius: 0,
			color: '#0073B3'
		},
		width: 300
	},
	show: {
		when: 'click',
		solo: true
	},
	hide: 'click',
	position: {
		corner: {
			target: 'rightBottom',
			tooltip: 'rightTop'
		},
		adjust: {
			x: 10,
			y: 2
		}
	}
}

$(".js-opt-delete").each(function(){
	var me = this;

	$(this).qtip({
		content: {
			data: { id: '1,2,3,7,9'},
			method: 'get',
			url: '/admin/post/m_del',
			text: 'Loading...'
		},
		api: {
			onShow: function(){
				$(me).addClass('table-btn-active');
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


})( jQuery );