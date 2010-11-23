<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php
		// 整个后台需要全局调用的资源文件
		echo HTML::style('assets/common/reset.css');
		echo HTML::style('assets/common/text.css');
		echo HTML::style('assets/common/960.css');
		echo HTML::style('assets/admin/main.css');
		echo HTML::script('assets/common/js/jquery.min.js');
		echo HTML::script('assets/admin/js/jquery.qtip.min.js');
	?>
	<title><?php if(isset ($title)) { echo $title.' - '; } ?>大犀牛体验版CMS</title>
</head>

<body>

<div class="container_24 clearfix">
	<div id="header">
		<div id="logo"><h1>大犀牛体验版CMS</h1></div>
		<div id="links">
			你好，火德
			- <?php echo HTML::anchor('/admin', '后台首页')?>
			- <?php echo HTML::anchor('/', '前台首页')?>
			- <?php echo HTML::anchor('/admin/logout', '注销')?>
		</div>
	</div>
	<?php echo $layout_aside; ?>
	<div class="grid_21"><?php echo $layout_main ?></div>
</div>

</body>
</html>