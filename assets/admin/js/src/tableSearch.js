/**
 * 表格搜索组件
 */
var tableSearch = (function( $ ) {
	var wrap				= $('.list-search'),
		btn					= wrap.find('.search'),
		keywordBox			= wrap.find('.keyword'),
		keywordInput		= wrap.find('input'),
		classBtnHover		= 'search-hover',
		classKeywordFocus	= 'keyword-focus',
		envKeyword			= util.param.get('keyword');

	// 回填关键词
	keywordInput.val(envKeyword)
	// 绑定回车事件
	.keypress(function(event){
		if (event.keyCode === 13) {
			btn.click();
		}
	});

	// 绑定按钮点击事件进行搜索
	btn.click(function(){
		util.param.set({
			'keyword': keywordInput.val()
		})
	});

	// 设置按钮Hover样式
	btn.hover(
		function(){ btn.addClass(classBtnHover); },
		function(){ btn.removeClass(classBtnHover);}
	);

	// 设置搜索框获得焦点时的样式
	keywordBox.focusin(function(){
		keywordBox.addClass(classKeywordFocus);
	})
	// 设置搜索框失去焦点时的样式
	.focusout(function(){
		keywordBox.removeClass(classKeywordFocus);
	});

})( jQuery );
