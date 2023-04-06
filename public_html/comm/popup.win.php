<?
include_once dirname(__FILE__)."/../inc/_header.php";
$sqry = sprintf("select * from %s where idx='%d'", SW_POPUP, $idx);
$row = $db->_fetch($sqry);

$cookie_name = "ck_popup_".$row['idx'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv='imagetoolbar' content='no'>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>::: <?=$row['title']?> :::</title>
<script language="javascript" type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/js/jquery.cookie.js" ></script>
<script type="text/JavaScript" src="/js/class.common.js" ></script>

<script type="text/javascript">
$(function() {
	$('.popup_close').css({"cursor" : "pointer"});

	$('.popup_chk').each(function(i){
		$(this).click(function(){
			var id = "<?=$cookie_name?>";

			//$.cookie(id, 'Y',{ expires: 1});
			Common.setCookie(id, 'Y', 1);
			window.close();
		});
	});

	$('.popup_close').each(function(i) {
		$(this).click(function(){
			window.close();
		});
	});
});
</script>
</head>
<body <?=($row['bgimg']) ? "style=\"margin:0px;padding:0px; background:url('/upload/design/".$row['bgimg']."');\"" : "style=\"margin:0;padding:0;\"";?>>

<table width="100%" height="500" border="0" cellspacing="5" cellpadding="0">
<tr>
	<td align="center" valign="top">

		<table width="100%" height="500" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top" style="padding:10px 20px 10px 20px;">

				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" align="left"><?=$row['content']?></td>
				</tr>
				</table>

			</td>
		</tr>
		</table>

	</td>
</tr>
</table>

<table width="100%"  height="25" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000">
<tr>
	<td height="25">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
		<tr>
			<td style="font-size:8pt;color:#ffffff;">&nbsp;&nbsp;<input type="checkbox" name="recruit" class="popup_chk"> 오늘하루 열지 않음</td>
			<td align="right">
				<span class="popup_close" style="font-size:8pt;color:#ffffff;">CLOSE</span>&nbsp;&nbsp;
			</td>
		</tr>
		</table>

	</td>
</tr>
</table>
</body>
</html>
