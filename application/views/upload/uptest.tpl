<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="<{$BASE_URL}>assets/common/960gs.css" />
	<title>文件上传测试</title>
</head>
<body>
	<div class="container_24">
		<form action="<{$BASE_URL}>upload/up_img" method="POST"  enctype="multipart/form-data">
                    <div>选择文件：<input type="file" name="file" /></div>
			
			<div><input type="submit" value="上传" /></div>
		</form>
	</div>
</body>
</html>