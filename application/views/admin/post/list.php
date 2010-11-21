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

<?php echo $pagination; ?>