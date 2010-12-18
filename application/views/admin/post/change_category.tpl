<div class="ch-cate-wrap">
</div>

<script type="text/javascript">
$(document).ready(function () {
	var container	= $('.ch-cate-wrap'),
		baseUrl		= dxn.util.base,
		msg			= dxn.category.getTree();

	container.html(msg);
});
</script>
