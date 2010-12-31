dxn.asideMenu = (function ($) {
	var container = $('.mainmenu'),
		menuBtns = container.find('.exbtn'),
		classTitleHover = 'title-hover',
		classBtnHover = 'exbtn-hover';

	menuBtns.each(function (i) {
		var el = $(this),
			list = el.next('.sublist'),
			title = el.prev('.title');

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
			return false;
		});
	});

}(jQuery));