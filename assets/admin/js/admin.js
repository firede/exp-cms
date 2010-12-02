(function( $ ) {

function initSearch() {
	var searchBox = $(".list-search"),
		searchBtn = searchBox.find(".search"),
		keywordBox = searchBox.find(".keyword"),
		keywordInput = searchBox.find("input"),
		searchHoverClass = 'search-hover',
		keywordFocusClass = 'keyword-focus',
		keywordValue = PAGEENV.param.keyword || "";
	
	if (searchBox.length === 0) {
		return;
	}

	keywordInput.val(keywordValue);
	
	searchBtn.hover(
		function(){
			$(this).addClass(searchHoverClass);
		},
		function(){
			$(this).removeClass(searchHoverClass);
		});
	keywordBox.focusin(
		function(){
			$(this).addClass(keywordFocusClass);
		});
	keywordBox.focusout(
		function(){
			$(this).removeClass(keywordFocusClass);
		});

	searchBtn.click(function(){
		PAGEENV.param.keyword = keywordInput.val();
		window.location.search = $.param(PAGEENV.param);
	});
}

function initSort() {
	$('.list-table .js-sort').each(function(){
		var el = $(this),
			orderBy = el.attr('order_by'),
			envType = PAGEENV.param.sort_type,
			sortType = 'asc';
		
		if (orderBy === PAGEENV.param.order_by) {
			if (PAGEENV.param.sort_type === 'asc') {
				sortType = 'desc';
			}

			el.append('<span class="sort-' + envType + '"></span>');
		}

		el.click(function(){
			PAGEENV.param.order_by = orderBy;
			PAGEENV.param.sort_type = sortType;
			PAGEENV.param.page = '1';
			window.location.search = $.param(PAGEENV.param);
		});

		el.hover(
			function(){
				el.addClass('js-sort-hover');
			},
			function(){
				el.removeClass('js-sort-hover');
			}
		);
	});
}

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

initSearch();
initSort();
initTooltip();


})( jQuery );