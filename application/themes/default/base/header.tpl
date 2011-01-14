<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><{$SITE.webname}></title>
		<meta name="keywords" content="<{$SITE.keywords}>">
		<meta name="description" content="<{$SITE.description}>">
		<link rel="stylesheet" href="<{$BASE_URL}>assets/common/960gs.css" />
		<link rel="stylesheet" href="<{$BASE_URL}>assets/default/main.css" />
		<script src="<{$BASE_URL}>assets/default/js/jquery.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="container_24 clearfix">
			<div id="header" class="clearfix">
				<div class="grid_8" id="logo">
					<a href="<{$BASE_URL}>">
						<img alt="<{$SITE.webname}>" src="/assets/admin/img/logo.png">
					</a>
				</div>
				<div class="grid_16 clearfix">
					<{include file="base/inc_userinfo.tpl"}>
				</div>
				<div class="clear"></div>
				<div class="navbar">
					<div class="mainmenu">
						<li><a href="#">首页</a></li>
						<li><a href="#">反恐精英</a></li>
						<li><a href="#">穿越火线</a></li>
						<li><a href="#">魔兽世界</a></li>
						<li><a href="#">魔兽争霸</a></li>
						<li><a href="#">星际争霸</a></li>
						<li><a href="#">龙之谷</a></li>
					</div>
					<div class="quicklink">我的快捷通道</div>
				</div>
			</div>
