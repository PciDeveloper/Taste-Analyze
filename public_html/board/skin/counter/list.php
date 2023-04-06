<table cellpadding="0" cellspacing="0">
<caption>고객문의 실시간 처리 현황</caption>
<colgroup>
	<col width="62px"/>
	<col width="*"/>
	<col width="95px"/>
	<col width="104px"/>
	<col width="68px"/>
</colgroup>
<thead>
	<tr>
		<th>번호</th>
		<th>글제목</th>
		<th>작성자</th>
		<th>작성일</th>
		<th>진행상황</th>
	</tr>
</thead> 
<tbody>
<?
$notice_qry = $db->_execute("select * from sw_board where code='$code' AND notice='Y' order by idx desc");
$i = 1;
for($i=$i; $notice_row=mysql_fetch_array($notice_qry); $i++)
{
	$encData = getEncode64("idx=".$notice_row['idx']."&start=".$start."&".$pg->getparm);
?>
<tr>
	<td><img src="/image/icon/icon_notice.gif" /></td>
	<td><a href="<?=$board->getLink($encData);?>" class="tit"><?=$board->getCateView($notice_row['cate'])?> <?=getCutString($notice_row['title'], $board->info['cutstr'])?></a> <?=$board->getIconNew($notice_row['regdt'])?></td>
	<td><?=$notice_row['name']?></td>
	<td><?=substr($notice_row['regdt'],0,10)?></td>
	<td><?=number_format($notice_row['hit'])?></td>
</tr>
<?
}

for($i=$i; $row=mysql_fetch_array($qry); $i++)
{
	$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);

?>
<tr>
	<td><?=$letter_no?></td>
	<td><?=$board->getBoardLevel($row['re_level']);?><?=$board->getBoardLock($row['bLock'])?> <a href="<?=$board->getLink($encData);?>" class="tit"><?=$board->getCateView($row['cate'])?> <?=getCutString($row['title'], $board->info['cutstr'])?>&nbsp;&nbsp;<?=$board->getIconNew($row['regdt'])?> <?=$board->getCommentCnt($row['idx'])?></a> </td>
	<td><?=$row['name']?></td>
	<td><?=substr($row['regdt'],0,10)?></td>
	<td><?=number_format($row['hit'])?></td>
</tr>
<?
	$letter_no--;
}

if($i < 2)
	echo("<tr><td colspan='5'>등록된 게시물이 없습니다.</td></tr>");
?>
</tbody>
</table>