<{include file='base/header.tpl'}>
<div id="main" class="clearfix">
	<div class="grid_18">
		<div class="mbox-wrap">
			<div class="mbox">
				<div class="mbox-title"><h3>魔兽世界</h3></div>
				<div class="mbox-content">
					<div class="mbox-cate-item"><strong>魔兽世界</strong></div>
					<div class="mbox-cate-item"><a href="#">地下城与勇士</a></div>
					<div class="mbox-cate-item"><a href="#">龙之谷</a></div>
					<div class="mbox-cate-item"><a href="#">梦幻西游</a></div>
					<div class="mbox-cate-item"><a href="#">诸仙</a></div>
				</div>
			</div>
		</div>
		<{part type="Post" action="list" param="array('status'=>1)" tpl="smarty:post/inc_list"}>
	</div>
	<div class="grid_6">
		<div class="mbox-wrap">
			<div class="mbox">
				test
			</div>
		</div>
	</div>
</div>
<{include file='base/footer.tpl'}>