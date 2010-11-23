<div class="grid_18 alpha">
	<div class="breadcrumbs">
		<span class="icon-position"></span>
		<?php
		$breadcrumb = array(
			HTML::anchor('admin', '后台首页'),
			HTML::anchor('admin/post', '经验'),
			HTML::anchor('admin/post/list?category=12', '魔兽世界'),
			'<span>列表</span>'
		);
		echo implode(' &raquo ', $breadcrumb);
		?>
	</div>
</div>

<div class="grid_3 omega">
	<div class="exlink">
		<span class="icon-category"></span>
		<?php echo HTML::anchor('category/index', '切换分类'); ?>
	</div>
</div>

<div class="clear"></div>

<div class="operation-bar clearfix radius_top">
	<div class="grid_12">
		<a href="#" onclick="return false;" class="operation-btn"><span class="icon-select"></span>全选/取消</a>
		<a href="#" onclick="return false;" class="operation-btn"><span class="icon-inverse"></span>反选</a>
		<a href="#" onclick="return false;" class="operation-btn"><span class="icon-audit"></span>审核</a>
		<a href="#" onclick="return false;" class="operation-btn"><span class="icon-star"></span>精华</a>
		<a href="#" onclick="return false;" class="operation-btn"><span class="icon-del"></span>删除</a>
		<a href="#" onclick="return false;" class="operation-btn"><span class="icon-move"></span>移动</a>
	</div>
	<div class="grid_8 right">
	</div>
</div>

<table class="list-table">
	<tr>
		<th style="width:30px">选择</th>
		<th>标题</th>
		<th style="width:45px">状态</th>
		<th style="width:65px">日期</th>
		<th style="width:100px">作者</th>
		<th style="width:100px">分类</th>
		<th style="width:90px">操作</th>
	</tr>
	<?php foreach($items as $item): ?>
	<tr val="<?php echo $item['id']; ?>">
		<td><input type="checkbox" val="<?php echo $item['id']; ?>" /></td>
		<td><a href="#"><?php echo $item['title']; ?></a></td>
		<td><span class="status_<?php echo $item['status']; ?>"><?php echo $item['status_name']; ?></span></td>
		<td><?php echo $item['pub_time']; ?></td>
		<td><?php echo $item['user_name']; ?></td>
		<td><?php echo $item['cate_name']; ?></td>
		<td>
			<a href="#" onclick="return false;" class="table-btn icon-audit" title="审核"><span>审核</span></a>
			<a href="#" onclick="return false;" class="table-btn icon-star" title="精华"><span>精华</span></a>
			<a href="#" onclick="return false;" class="table-btn icon-del" title="删除"><span>删除</span></a>
			<a href="#" onclick="return false;" class="table-btn icon-preview" title="预览"><span>预览</span></a>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
<div class="operation-bar clearfix radius_bottom">
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-select"></span>全选/取消</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-inverse"></span>反选</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-audit"></span>审核</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-star"></span>精华</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-del"></span>删除</a>
	<a href="#" onclick="return false;" class="operation-btn"><span class="icon-move"></span>移动</a>
</div>

<div class="pagination-bar clearfix radius_all">
	<?php echo $pagination; ?>
</div>

<?php
// 后台管理JS
echo HTML::script('assets/admin/js/admin.js');
?>