<div id="subviewPreview" class="subview">
	<h2 class="title"></h2>
	<div class="content"></div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	var container	= $('#subviewPreview'),
		target		= dxn.subView.curTarget.get(),
		id			= dxn.subView.curParam.get(),
		baseUrl		= dxn.util.base;

	function getContent(status, preContent, content) {
		if (status == '1') {
			return content;
		} else {
			return preContent;
		}
	}

	$.get(
		baseUrl + 'admin/post/get/' + id,
		function(obj){
			if (obj.success == true) {
				var rs = obj.result[0],
					content = getContent(
								rs.status,
								rs.pre_content,
								rs.content);

				container.find('.title').html(rs.title);
				container.find('.content').html(content);

			} else {
				container.html('<div class="msg-error">' + obj.message + '</div>');
			}
		}, 'json');
});
</script>