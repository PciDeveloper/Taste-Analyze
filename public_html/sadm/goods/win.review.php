<?
include_once(dirname(__FILE__)."/../_header.php");

if($idx)
{
	$sqry = sprintf("select a.*, b.img3, b.name as gname, b.category as gcategory, b.gcode from %s a, %s b where a.gidx=b.idx and a.idx='%d'", SW_REVIEW, SW_GOODS, $idx);
	$row = $db->_fetch($sqry, 1);

//	$refile = extraCreateThumb("../..", $row['content'], '141', '93');
}
else
	msg("정상적인 접근이 아닙니다.", "C", true);


	$userinfo = getMember($row['userid']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>::: <?=$cfg['shopnm']?> 상품평 상세보기 :::</title>
<link rel="stylesheet" href="../css/css.css" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="/js/class.common.js"></script>
<script type="text/javascript">
function Edit()
{
	var f = document.fm;

	if(Common.checkFormHandler.checkForm(f))
	{
		f.submit();
	}
}
</script>
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
			<td><span class="bigtitle">상품평 상세보기</span></td>
		</tr>
		</table>

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr><td height="1" bgcolor="#ffffff" class="none">&nbsp;</td></tr>
		<tr><td height="1" bgcolor="#c8cdd2" class="none">&nbsp;</td></tr>
		</table>

		<div style="width:97%;margin:10px;border:3px solid #F8F8F8;">
		<div style="border:1px solid #eeeeee;padding:5px;background-color:#ffffff;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="100"><div style="width:67px;text-align:center;background-color:#fafafa; border:1px solid #e0e0e0;"><?=getImageTag("../../upload/goods/small", $row['img3'], 65, 65, 'img1');?></div></td>
			<td>
				<div><span class="category"><?=getCatePos($row['gcategory']);?></span></div>
				<div class="bold tp5" style="height:25px;"><?=$row['gname']?></div>
			</td>
		</tr>
		</table>
		</div>
		</div>

		<form name="fm" action="./common.act.php" method="post">
		<input type="hidden" name="mode" value="review" />
		<input type="hidden" name="act" value="edit" />
		<input type="hidden" name="idx" value="<?=$idx?>" />
		<div class="tit"><img src="../img/icon/icon_tit.gif" align="absmiddle" /> 상품평 내용보기</div>
		<table class="tb">
		<colgroup>
		<col width="130" />
		<col />
		</colgroup>
		<tbody>
		<tr>
			<th>메인노출</th>
			<td>
				<input type="checkbox" name="mview" value="Y" <?=($row['mview'] == "Y") ? "checked=\"checked\"" : "";?> />
				<span class="txt4">※ 체크시 메인에 최근순으로 노출 됩니다.</span>
			</td>
		</tr>
		<tr>
			<th>작성자</th>
			<td><?=$userinfo['name']?> <span class="help_subject">(<?=$row['userid']?>)</span></td>
		</tr>
		<tr>
			<th>제 목</th>
			<td><?=$row['title']?></td>
		</tr>
		<tr>
			<th>상품평</th>
			<td height="200" style="vertical-align:top;padding:5px 10px;"><?=nl2br($row['content'])?></td>
		</tr>
		<tr>
			<th>작성일</th>
			<td><?=$row['regdt']?></td>
		</tr>
		</tbody>
		</table>

		<p class="btnC">
			<img src="../img/btn/btn_edit.gif" class="pointer middle" onclick="Edit();" />
			<img src="../img/btn/btn_cancel.gif" class="pointer middle" onclick="javascript:window.close();" />
		</p>
		</form>

	</div>
</body>
</html>
