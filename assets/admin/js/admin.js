$(".operation-btn").qtip({
	content: {
		title: {
			button: '关闭'
		},
		data: {id: 5},
		method: 'get',
		url: 'http://daxiniu.cms/welcome',
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
			color: '#0073B3'
		},
		width: 300
	},
	position: {
		corner: {
			target: 'bottomLeft',
			toolTip: 'bottomLeft'
		}
	}
});