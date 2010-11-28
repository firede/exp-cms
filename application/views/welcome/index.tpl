<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>测试Smarty模板</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	</head>
	<body>
		<h1><{$hello}></h1>
		<p><em>这是一个Smarty模板，如果你看到上面有个大标题，说明测试成功了。</em></p>
		<{basetpl data=$data conf=$conf prefix=$prefix tpl="link"}>
		<p>测试日期底层模板：<{basetpl data=$data conf='date' prefix=$prefix tpl="date"}></p>
	</body>
</html>


<{debug}>