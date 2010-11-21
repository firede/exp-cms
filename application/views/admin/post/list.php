<div class="grid_18 alpha">
	<div class="breadcrumbs">
		<span class="icon-position"></span>
		<?php echo HTML::anchor('admin', '后台首页') ?> &raquo;
		<?php echo HTML::anchor('admin/post/list', '经验列表') ?> &raquo;
		<?php echo HTML::anchor('admin/post/list?category=12', '魔兽世界') ?>
	</div>
</div>

<div class="grid_3 omega">
	<div class="exlink">
		<span class="icon-category"></span>
		<?php echo HTML::anchor('category/index', '切换分类'); ?>
	</div>
</div>

<div class="clear"></div>

<div class="operation-bar clearfix">
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-select"></span>全选/取消</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-inverse"></span>反选</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-audit"></span>审核</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-star"></span>精华</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-del"></span>删除</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-move"></span>移动</a>
</div>
<table class="list-table">
	<tr>
		<th>选择</th>
		<th>标题</th>
		<th>状态</th>
		<th>日期</th>
		<th>作者</th>
		<th>分类</th>
		<th>操作</th>
	</tr>
<?php
for($i=0; $i<20; $i++) {
	$odd = ($i%2) ? '' : ' style="background:#F5FAFC;"';
?>
	<tr<?php echo $odd; ?>>
		<td><input type="checkbox" /></td>
		<td><a href="#">怎么为Yii Framework的应用程序划分前后台结构？</a></td>
		<td>审核中</td>
		<td>2010-11-16</td>
		<td>火德</td>
		<td>Yii Framework</td>
		<td>
			<a href="#" onclick="return false;" class="table-btn icon-audit" title="审核"><span>审核</span></a>
			<a href="#" onclick="return false;" class="table-btn icon-star" title="精华"><span>精华</span></a>
			<a href="#" onclick="return false;" class="table-btn icon-del" title="删除"><span>删除</span></a>
			<a href="#" onclick="return false;" class="table-btn icon-preview" title="预览"><span>预览</span></a>
		</td>
	</tr>
<?php } ?>
</table>
<div class="operation-bar clearfix">
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-select"></span>全选/取消</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-inverse"></span>反选</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-audit"></span>审核</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-star"></span>精华</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-del"></span>删除</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-move"></span>移动</a>
</div>

<div class="pagination-bar clearfix">
	<?php echo $pagination; ?>
</div>

<script type="text/javascript">
$(".operation-btn").qtip({
	content: {
		title: {
			text: '批量操作',
			button: '关闭'
		},
		data: {id: 5},
		method: 'get',
		url: 'http://daxiniu.cms/welcome'
	},
	show: {
		when: 'click',
		solo: true
	},
	hide: false,
	api: {
		beforeShow: function() {
			$('#qtip-blanket').fadeIn(this.options.show.effect.length);
		},
		beforeHide: function() {
			$('#qtip-blanket').fadeOut(this.options.show.effect.length);
		}
	},
	style: {
		name: 'light',
		tip: true,
		border: {
			width: 5,
			radius: 3
		}
	},
	position: {
		type: 'fixed',
		adjust: {
			screen: true
		},
		corner: {
			target: 'bottomMiddle',
			tooltip: 'topMiddle'
		}
	}
});

$('<div id="qtip-blanket">')
	.css({
		position: 'absolute',
		top: $(document).scrollTop(), // Use document scrollTop so it's on-screen even if the window is scrolled
		left: 0,
		height: $(document).height(), // Span the full document height...
		width: '100%', // ...and full width

		opacity: 0.6, // Make it slightly transparent
		backgroundColor: 'black',
		zIndex: 5000  // Make sure the zIndex is below 6000 to keep it below tooltips!
	})
	.appendTo(document.body) // Append to the document body
	.hide(); // Hide it initially
</script>
