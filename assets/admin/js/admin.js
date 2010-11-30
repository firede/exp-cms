$(".operation-btn").each(function(){
	var me = this;

	$(this).qtip({
		content: {
			data: {id: 5},
			method: 'get',
			url: '/welcome/index',
			text: 'Loading...'
		},
		show: {
			when: 'click',
			solo: true
		},
		hide: 'click',
		style: {
			tip: false,
			border: {
				width: 2,
				radius: 3,
				color: '#0073B3'
			},
			width: 300
		},
		api: {
			onShow: function() {
				$(me).addClass('operation-btn-active');
			},
			onHide: function() {
				$(me).removeClass('operation-btn-active');
			}
		},
		position: {
			corner: {
				target: 'bottomLeft',
				toolTip: 'bottomLeft'
			}
		}
	});
});