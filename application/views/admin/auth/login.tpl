<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="<{$BASE_URL}>assets/common/960gs.css" />
	<title>登录</title>
</head>
<body>
	<div class="container_24">
		<form action="<{$BASE_URL}>admin/auth/login_post" method="POST">
			<div>用户名：<input type="text" name="username" /></div>
			<div>密　码：<input type="password" name="password" /></div>
			<div><input type="submit" value="登录" /></div>
		</form>
	</div>
</body>
</html>