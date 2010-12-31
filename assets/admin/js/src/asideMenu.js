dxn.asideMenu = (function ($) {
	var container = $('.mainmenu'),
		menuBtns = container.find('.exbtn'),
		classTitleHover = 'title-hover',
		classBtnHover = 'exbtn-hover',
		cookieName = 'mainmenuStatus',
		openStatusArr,
		openStatus = {
			init: function () {
				var btnLen = menuBtns.length,
					i = 0,
					str = $.cookie(cookieName) || '';

				if (str.length !== btnLen) {
					str = '';
				}
				
				if (str === '') {
					for (i; i<btnLen; i++) {
						str += '0';
					}
					$.cookie(cookieName, str);
				}

				openStatusArr = str.split('');
			},
			modify: function (i, flag) {
				if (flag) {
					openStatusArr[i] = flag;
				} else {
					openStatusArr[i] = (openStatusArr[i] === '0') ? '1' : '0';
				}
				$.cookie(cookieName, openStatusArr.join(''));
			}
		};

	openStatus.init();
	
	menuBtns.each(function (i) {
		var el = $(this),
			list = el.next('.sublist'),
			title = el.prev('.title');

		if (openStatusArr[i] === '1') {
			list.slideDown('fast');
		}

		el.hover(
			function () {
				title.addClass(classTitleHover);
				el.addClass(classBtnHover);
			},
			function () {
				title.removeClass(classTitleHover);
				el.removeClass(classBtnHover);
			}
		);

		el.click(function () {
			list.slideToggle('fast');
			openStatus.modify(i);
		});

		title.click(function() {
			openStatus.modify(i, '1');
		});
	});

}(jQuery));