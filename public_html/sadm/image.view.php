<?
include_once dirname(__FIlE__)."/./_header.php";

switch($path)
{
	case "board" :
		$path = "../upload/board/";
	break;
	case "big" :
		$path = "../upload/goods/big/";
	break;
	case "middle" :
		$path = "../upload/goods/middle/";
	break;
	case "small" :
		$path = "../upload/goods/small/";
	break;
	case "slide" :
		$path = "../upload/goods/slide/";
	break;
	case "member" :
		$path = "../upload/member/";
	break;
	case "design" :
		$path = "../upload/design/";
	break;
	case "comment" :
		$path = "../upload/board/";
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
	<a href="javascript:window.close();"><img src="<?=$path?><?=$img?>"></a>
</div>
</body>
</html>
