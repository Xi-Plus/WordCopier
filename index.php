<html>
<head>
	<title>Word產生器</title>
	<meta charset="UTF-8">
</head>
<body>
<center>
<form action="upload.php" method="post" enctype="multipart/form-data">
上傳:<br>
Word:<input type="file" name="word" id="file">(.htm .html only)<br>
CSV:<input type="file" name="csv" id="file">(.csv .txt only)<br>
<input name="" type="submit" value="送出">
</form>
Example File<br>
<a href="example.html">example.html</a><br>
<a href="example.csv">example.csv</a>
<hr>
<?php
@include("../function/developer.php");
?>
</center>
</body>
</html>