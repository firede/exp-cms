<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="<{$BASE_URL}>assets/common/960gs.css" />
	<link rel="stylesheet" href="<{$BASE_URL}>assets/admin/admin.css" />
	<script type="text/javascript" src="<{$BASE_URL}>assets/common/js/jquery.min.js"></script>
	<script type="text/javascript" src="<{$BASE_URL}>assets/admin/js/vendor/jquery.qtip.js"></script>
	<title><{if $title|default}>
		<{$title}> - 
	<{/if}>大犀牛体验版CMS</title>
</head>

<body>

<div class="container_24 clearfix">
	<div id="header">
		<div id="logo"><h1>大犀牛体验版CMS</h1></div>
		<div id="links">
			你好，火德
			- <a href="<{$BASE_URL}>admin">后台首页</a>
			- <a href="<{$BASE_URL}>">前台首页</a>
			- <a href="<{$BASE_URL}>admin/logout">注销</a>
		</div>
	</div>
