<html>
<head>
	<title>產生中...</title>
	<meta charset="UTF-8">
</head>
<body>
<center>
<?php
$error=true;
if($_FILES["word"]["error"] != 0){
	echo "Word上傳失敗<br>";
	$error=false;
}else{
	$exname=pathinfo($_FILES["word"]["name"], PATHINFO_EXTENSION);
	$wordname="word.".$exname;
	if(!in_array($exname,array("htm","html"))){
		echo "Word 格式錯誤<br>";
		$error=false;
	}
	move_uploaded_file($_FILES["word"]["tmp_name"],$wordname);
}
if($_FILES["csv"]["error"] != 0){
	echo "CSV上傳失敗<br>";
}else{
	$exname=pathinfo($_FILES["csv"]["name"], PATHINFO_EXTENSION);
	$csvname="csv.".$exname;
	if(!in_array($exname,array("csv","txt"))){
		echo "CSV 格式錯誤<br>";
	}
	move_uploaded_file($_FILES["csv"]["tmp_name"],$csvname);
}
if($error){
	$newpagehtml="<span lang=EN-US style='mso-font-kerning:0pt'><br clear=all style='page-break-before:always'></span>";
	
	$wordfile=file($wordname);
	$csvfile=file($csvname);
	foreach($wordfile as $index => $temp){
		if(substr($temp,0,4)=="<div")$start=$index;
		if(substr($temp,0,6)=="</div>")$end=$index;
	}
	$html="";
	for($i=0;$i<=$start;$i++){
		$html.=$wordfile[$i];
	}
	$html_temp="";
	for($i=$start+1;$i<$end;$i++){
		$html_temp.=$wordfile[$i];
	}
	foreach($csvfile as $line){
		$line=str_replace("\r\n","",$line);
		$line=explode(",",$line);
		if($line[0]=="newpage"&&$line[1]==""){
			$html.=$html_temp.$newpagehtml;
			$html_temp="";
			for($i=$start+1;$i<$end;$i++){
				$html_temp.=$wordfile[$i];
			}
		}else {
			$count=substr_count($html_temp,$line[0]);
			for($i=1;$i<=$count;$i++){
				$html_temp=preg_replace("/".$line[0]."/",$line[$i],$html_temp,1);
			}
		}
	}
	$html.=$html_temp;
	for($i=$end;$i<count($wordfile);$i++){
		$html.=$wordfile[$i];
	}
	
	file_put_contents("produce.html",$html);
	
	include("word.php");
	$word=new word; 
	$word->start();
	echo $html;
	$word->save("produce.doc");
	
	unlink($wordname);
	unlink($csvname);
?>
	<a href="produce.doc">下載連結</a>
	<script>document.title="Word產生完成"</script>
<?php
}else {
?>
	<script>document.title="Word產生失敗"</script>
<?php
}
?>
</center>
</body>
</html>

