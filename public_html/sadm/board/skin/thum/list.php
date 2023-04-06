
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
<tr>
<?
for($i=1; $row=mysql_fetch_array($qry); $i++)
{
	$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
	$fdata = $board->getFileOneData($row['idx']);
	$notice2 = ($row['notice2'] == 'Y'  ? "[안내]&nbsp;&nbsp;" : "");
?>
	<td width="<?=$board->info['thumW']?>" align="center" valign="top">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr align="center"><td><a href="<?=$board->getLink($encData);?>"><?=getImageTag("../../upload/board/thum/", "thum_".$fdata, $board->info['thumW'], $board->info['thumH'],"img","","/sadm/img/common/no_image.gif");?></a></td></tr>
		<tr align="center"><td height="30" bgcolor="#f1f1f1" class="bold"><input type="checkbox" name="chk[]" value="<?=$row['idx']?>" /><a href="<?=$board->getLink($encData);?>"><?=getCutString($row['title'], $board->info['cutstr'])?> <?=$board->getIconNew($row['regdt'])?> <?=$board->getCommentCnt($row['idx'])?></a></td></tr>
		<tr><td class="line"></td></tr>
  		<tr><td bgcolor="#f1f1f1" height="20" class="rp10"><?=str_replace("-", ".", substr($row['regdt'], 0, 10));?></td></tr>
		</table>
	</td>
<?
	if($i % 4)
		echo("<td width='15'>&nbsp;</td>");
	else
		echo("</tr><tr><td colspan='9' height='25'></td></tr><tr>");
}

setEmptyTd(4, $i, $board->info['thumW'], "<td width='15'>&nbsp;</td>");
?>
</tr>
</table>
