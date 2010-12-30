dxn.asideMenu = (function ($) {
	var container = $('.mainmenu'),
		menuBtns = container.find('.exbtn'),
		classBtnHover = 'title-hover';

	menuBtns.each(function () {
		var el = $(this),
			list = el.next('.sublist'),
			title = el.prev('.title');

		el.hover(
			function () {
				title.addClass(classBtnHover);
			},
			function () {
				title.removeClass(classBtnHover);
			}
		);

		el.click(function () {
			if (list.css('display') != 'block') {
				list.css('display', 'block');
			} else {
				list.css('display', 'none');
			}
			return false;
		});
	});

}(jQuery));