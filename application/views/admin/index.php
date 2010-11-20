<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?= $assets_common ?>reset.css" />
	<link rel="stylesheet" href="<?= $assets_common ?>text.css" />
	<link rel="stylesheet" href="<?= $assets_common ?>960.css" />
	<link rel="stylesheet" href="<?= $assets_admin ?>main.css" />
	<title><?= $title ?></title>
</head>

<body>

<div class="container_16">
	<div id="header">
		<div id="logo"><h1><?= $title ?></h1></div>
		<div id="links">
			你好，火德
			- <?= HTML::anchor('/admin', '后台首页')?>
			- <?= HTML::anchor('/', '前台首页')?>
			- <?= HTML::anchor('/admin/logout', '注销')?>
		</div>
	</div>
	<div class="grid_2 sidebar">
		<ul class="mainmenu">
			<li><?= HTML::anchor('/admin/post', '经验')?></li>
			<li><?= HTML::anchor('/admin/category', '分类')?></li>
			<li><?= HTML::anchor('/admin/attachment', '附件')?></li>
			<li><?= HTML::anchor('/admin/user', '用户')?></li>
			<li><?= HTML::anchor('/admin/admin', '管理员')?></li>
			<li><?= HTML::anchor('/admin/setting', '设置')?></li>
		</ul>
		<div class="sidebox">
			<h5>帮助</h5>
			<ul class="content">
				<li><a href="" target="_blank">插件开发指南</a></li>
				<li><a href="" target="_blank">模板开发指南</a></li>
				<li><a href="" target="_blank">系统整合说明</a></li>
				<li><a href="" target="_blank">官方论坛</a></li>
			</ul>
		</div>
		<div class="sidebox">
			<h5>关于</h5>
			<div class="content">大犀牛经验<br>版本：1.0<br><a href="http://daxiniu.com" target="_blank">DAXINIU.COM</a></div>
		</div>
	</div>
	<div class="grid_14">内容</div>
</div>

</body>
</html>