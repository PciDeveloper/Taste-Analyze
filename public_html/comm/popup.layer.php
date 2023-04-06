<script type="text/javascript">
function LPopCookieClose(id)
{
	Common.setCookie('<?=$cookie_name?>', 'Y', 1);
	$('#'+id).fadeOut();
}

function LPopClose(id)
{
	$('#'+id).fadeOut();
}
</script>

<div id="<?=$popup_id?>" style="border:3px solid #5b5b5b;position:absolute;z-index:999999999999;width:<?=$popup_row['width']?>px;height:<?=$popup_row['height']?>px;left:<?=$popup_row['pleft']?>px; top:<?=$popup_row['ptop']?>px;display:;" >
<form name="popupForm_<%=pop.getIdx()%>">

<table width="100%" height="<?=$popup_row['height']?>" border="0" cellspacing="0" cellpadding="0" <?=($popup_row['bgimg']) ? "style=\"background:url('/upload/design/".$popup_row['bgimg']."');\"" : "bgcolor=\"#ffffff\"";?>>
<tr>
	<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr><td height="10"></td></tr>
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="10"></td>
					<td class="board_list05"><?=$popup_row['content']?></td>
					<td width="10"></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr><td height="10"></td></tr>
		</table>
	</td>
</tr>
<tr height="26">
	<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="10"></td>
			<td>
				<input type="checkbox" name="recruit" style="vertical-align:middle;" class="hand" onclick="LPopCookieClose('<?=$popup_id?>');"  />
				<span class="board_list02">오늘 하루 이 창을 열지 않음</span>
			</td>
			<td align="right"><img src="/images/btn/close_btn.gif" border="0" class="hand" alt="닫기버튼" onClick="LPopClose('<?=$popup_id?>');" /></td>
		</tr>
		</table>
	</td>
</tr>
</table>
</form>
</div>
