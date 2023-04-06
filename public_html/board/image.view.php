<?
include_once dirname(__FIlE__)."/../inc/_header.php";

switch($path)
{
	case "board" :
		$path = "../upload/board/";
	case "design" :
		$path = "../upload/design/";
	break;
}

$imgpath = $path.$img;
$imginfo = @getImageSize($imgpath);
$width = ($width) ? $width : $imginfo[0];
$height = ($height) ? $height : $imginfo[1];

?>
<html>
<head>
<title> ::: 이미지 확대보기 ::: </title>
<link href="./css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/js/common.js"></script>

<script type="text/javascript">
<!--
window.resizeTo('<?=$width?>', '<?=$height + 80?>');
//-->
</script>

</head>
<body bgcolor="E6E6E6" text="#666666" leftmargin="0" topmargin="0">
<div align="center">
	<a href="javascript:window.close();"><?=getImageTag($path, $img, $width, $height);?></a>
</div>
</body>
</html>
