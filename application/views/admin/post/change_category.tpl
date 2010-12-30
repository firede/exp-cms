<div id="subviewChangeCategory" class="subview">
	<div class="desc">请选择要切换的分类：</div>
	<div class="form js-cate-selector"></div>
	<div class="clearfix">
		<span class="submit radius_all">确定</span>
		<span class="cancel radius_all">取消</span>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function () {
	var container	= $('#subviewChangeCategory'),
		submit		= container.find('.submit'),
		cancel		= container.find('.cancel'),
		selector	= container.find('.js-cate-selector'),
		target		= dxn.subView.curTarget.get(),
		baseUrl		= dxn.util.base,
		treeData;

	selector.cateSelector({
		url: dxn.util.base + 'admin/category/tree'
	});

	submit.click(function () {
		console.log(selector.cateSelector('getSelected'));
	});

	cancel.click(function () {
		target.qtip('hide');
	});
});
</script>
