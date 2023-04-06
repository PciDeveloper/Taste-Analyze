<?
include_once(dirname(__FILE__)."/../_header.php");

if($idx)
	$row = $db->_fetch("select * from sw_board_cnf where idx='$idx'", 1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>::: <?=$cfg['shopnm']?> 아이콘 설정 :::</title>
<link rel="stylesheet" href="../common/css.css" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="/js/class.common.js"></script>
</head>
<body>
	<div class="contents_box">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr><td height="1" bgcolor="#d7d7d8" class="none">&nbsp;</td></tr>
		<tr><td height="1" bgcolor="#eeeeef" class="none">&nbsp;</td></tr>
		</table>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="title_bg2">
		<tr>
			<td width="26" align="center"><img src="../img/layout/position_arrow.gif" class="up1" /></td>
			<td class="bigtitle">상품 아이콘 <?=($idx) ? "수정" : "추가";?></td>
		</tr>
		</table>

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr><td height="1" bgcolor="#ffffff" class="none">&nbsp;</td></tr>
		<tr><td height="1" bgcolor="#c8cdd2" class="none">&nbsp;</td></tr>
		</table>

		<form name="fm" method="post" action="./common.act.php" enctype="multipart/form-data" onSubmit="return Common.checkFormHandler.checkForm(this);">
		<input type="hidden" name="mode" value="icon" />
		<input type="hidden" name="act" value="<?=($idx) ? 'edit' : '';?>" />
		<input type="hidden" name="idx" value="<?=$idx?>" />
		<table class="tb">
		<colgroup>
		<col width="120" />
		<col />
		</colgroup>
		<tbody> 
		<tr>
			<th>아이콘명</th>
			<td><input type="text" name="name" class="lbox w200" value="<?=$row['name']?>" exp="아이콘명을" /></td>
		</tr>
		<tr>
			<th>아이콘 파일</th>
			<td><input type="file" name="img" class="lbox w300" <? if(!$idx){?> exp="아이콘 파일을" filetype="image"<?}?> /></td>
		</tr>
		</tbody>
		</table>

		<p class="btnC"><input type="submit" value="아이콘 <?=($idx) ? "수정" : "추가";?>" class="botton" style="width:150px;height:30px;" /></p>
		</form>

	</div>
</body>
</html>