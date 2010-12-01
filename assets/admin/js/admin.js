(function( $ ) {

var mutiConfig = {
	style: {
		tip: false,
		border: {
			width: 2,
			radius: 3,
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

//$(".operation-btn").each(function(){
//	var me = this;
//
//	$(this).qtip({
//		content: {
//			data: {id: 5},
//			method: 'get',
//			url: '/welcome/index',
//			text: 'Loading...'
//		},
//		show: {
//			when: 'click',
//			solo: true
//		},
//		hide: 'click',
//		style: {
//			tip: false,
//			border: {
//				width: 2,
//				radius: 3,
//				color: '#0073B3'
//			},
//			width: 300
//		},
//		api: {
//			onShow: function() {
//				$(me).addClass('operation-btn-active');
//			},
//			onHide: function() {
//				$(me).removeClass('operation-btn-active');
//			}
//		},
//		position: {
//			corner: {
//				target: 'bottomLeft',
//				toolTip: 'bottomLeft'
//			}
//		}
//	});
//});

})( jQuery );