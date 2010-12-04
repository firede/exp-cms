<div class="operation-content">
	<p>你确定要删除文章么？</p>
	<div>
		<input id="operationOk" type="button" value="确定" />
		<input type="button" value="取消" onclick="$('.js-opt-delete').qtip('hide')" />
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	var id = dxn.subView.curParam.get();

	$('.operation-content').append('<strong>ID是：' + id + '</strong>');
});
</script>
