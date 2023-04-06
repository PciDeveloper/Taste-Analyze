<table cellspacing="0" class="boardHL2" border="0">
<tbody>
<tr>
<?
for($i=1; $row=mysql_fetch_array($qry); $i++)
{
	$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
	$fdata = $board->getFileOneData($row['idx']);
?>
	<td align="center" valign="top">
		<div class="img"><a href="<?=$board->getLink($encData);?>"><?=getImageTag("../upload/board/", "thum_".$fdata, $board->info['thumW'], $board->info['thumH'],"img")?></a></div>

		<div class="list">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
			<tr><td class="title"><a href="<?=$board->getLink($encData);?>"><?=getCutString($row['title'], $board->info['cutstr'])?> <?=$board->getIconNew($row['regdt'])?></a></td></tr>
			<tr><td class="date"><?=substr($row['regdt'], 0, 10)?></td></tr>
			</table>
		</div>
	</td>
<?
	if($i % 2) 
		echo("<td width='20' class='none'>&nbsp;</td>");
	else if(!($i%2))
		echo("</tr><tr><td colspan='9' height='5'></td></tr><tr>");
}

setEmptyTd(2, ($i-1), $board->info['thumW']+10, "<td width='20' class='none'>&nbsp;</td>");

if($numrows < 1)
	echo("<tr><td colspan='5' align='center'>등록된 게시물이 없습니다.</td></tr>");

?>
</tr>
</tbody>
</table>