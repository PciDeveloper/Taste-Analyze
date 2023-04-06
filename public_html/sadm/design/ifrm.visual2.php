<?
include_once(dirname(__FILE__)."/../_header.php");
if($idx) $row = $db->_fetch("select * from ".SW_VISUAL." where idx='".$idx."'", 1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>::: <?=$cfg['shopnm']?> 출석배너 이미지 설정 :::</title>
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
			<td class="bigtitle">출석배너 이미지 <?=($idx) ? "수정" : "추가";?></td>
		</tr>
		</table>

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr><td height="1" bgcolor="#ffffff" class="none">&nbsp;</td></tr>
		<tr><td height="1" bgcolor="#c8cdd2" class="none">&nbsp;</td></tr>
		</table>

		<form name="fm" method="post" action="./common.act.php" enctype="multipart/form-data" onsubmit="return Common.checkFormHandler.checkForm(this);">
		<input type="hidden" name="mode" value="visual" />
		<input type="hidden" name="act" value="<?=($idx) ? 'edit' : '';?>" />
		<input type="hidden" name="idx" value="<?=$idx?>" />
		<input type="hidden" name="gubun" value="M" />
		<table class="tb">
		<colgroup>
		<col width="120" />
		<col />
		</colgroup>
		<tbody> 
		<tr>
			<th>제 목</th>
			<td><input type="text" name="title" class="lbox w200" value="<?=$row['title']?>" exp="제목을" /></td>
		</tr>
		<tr>
			<th>사용여부</th>
			<td>
				<label><input type="radio" name="buse" value="Y" <?=($row['buse'] == "Y" || !$row) ? "checked=\"checked\"" : "";?> /> 노출 </label> &nbsp;&nbsp; 
				<label><input type="radio" name="buse" value="N" <?=($row['buse'] == "N") ? "checked=\"checked\"" : "";?> /> 비노출 </label> &nbsp;&nbsp;
			</td>
		</tr>
		<!-- <tr>
			<th>타켓</th>
			<td> 
				<label><input type="radio" name="target" value="_blank" <?=($row['target'] == "_blank") ? "checked=\"checked\"" : "";?> /> 새창 </label> &nbsp;&nbsp;
				<label><input type="radio" name="target" value="nolink" <?=($row['target'] == "nolink") ? "checked=\"checked\"" : "";?> /> 링크없음 </label>
			</td>
		</tr>
		<tr>
			<th>링크주소(URL)</th>
			<td><input type="text" name="url" class="lbox w400" value="<?=$row['url']?>" /></td>
		</tr> -->
		<tr>
			<th>이미지</th>
			<td>
				<input type="file" name="img" class="lbox w200" />
				<?
				if($row['img'])
					printf("<input type=\"checkbox\" name=\"imgdel\" value=\"1\" /> 삭제 (%s) <a href=\"javascript:void(window.open('../image.view.php?path=design&img=%s', '', 'width=100, height=100, top=300, left=300'))\">%s</a>", $row['img'], $row['img'], getImageTag("../../upload/design", $row['img'], 20, 20, "img1"));
				?>
			</td>
		</tr>
		</tbody>
		</table>

		<p class="btnC"><input type="submit" value="이미지 <?=($idx) ? "수정" : "등록";?>" class="botton" style="width:150px;height:30px;" /></p>
		</form>

	</div>
<script type="text/javascript">
$(document).ready(function(){
	chgTarget();

	$(":radio[name='target']").click(function(){
		chgTarget();
	});
});

function chgTarget()
{
	if($(":radio[name='target']:checked").val() == "nolink")
	{
		$("input[name='url']").val("");
		$(this).css("border", "1px solid #ccc");
		$("input[name='url']").css("backgroundColor", "#f1f1f1");
		$("input[name='url']").attr("disabled", true);
	}
	else
	{
		$("input[name='url']").css("backgroundColor", "#ffffff");
		$("input[name='url']").attr("disabled", false);
	}
}
</script>

</body>
</html>