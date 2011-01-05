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
	<{/if}>大犀牛内容分享系统</title>
</head>

<body>

<div class="container_24 clearfix">
	<div id="header">
		<a id="logo" href="<{$BASE_URL}>admin"><h1>大犀牛内容分享系统</h1></a>
		<div id="links">
			<{if $ADMIN_DATA.username|default}>
				你好，<{$ADMIN_DATA.username}> -
				<a href="<{$BASE_URL}>admin">后台首页</a> -
			<{/if}>
			<a href="<{$BASE_URL}>">前台首页</a> -
			<{if $ADMIN_DATA.username|default}>
				<a href="<{$BASE_URL}>admin/auth/login_out">注销</a>
			<{else}>
				<a href="<{$BASE_URL}>admin/auth/login">登录</a>
			<{/if}>
		</div>
	</div>
