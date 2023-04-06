<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-bordered">

<colgroup>
	<col width="50"/>
	<col />
	<col span="2" width="100"/>
	<col width="80"/>
</colgroup> 
<tr>
	<th>번호</th>
	<th>제목</th>
	<th>작성자</th>
	<th>등록일</th>
	<th>조회</th>
</tr> 
<tbody>
<?
$notice_qry = $db->_execute("select * from sw_board where code='$code' AND notice='Y' order by idx desc");
$i = 1;
for($i=$i; $notice_row=mysql_fetch_array($notice_qry); $i++)
{
	$encData=getEncode64("idx=".$notice_row['idx']."&start=".$start."&skey=".$skey."&sstr=".$sstr);
	$bgcolor =  ($i % 2) ? "#ffffff" : "#fafafa";
?>
<tr height="25" align="center" bgcolor="<?=$bgcolor?>">
	<td><img src="/img/icon/icon_notice.gif" /></td>
	<td style="text-align:left;padding-left:5px;"><a href="<?=$board->getLink($encData);?>"><?=$notice_row['title']?></a> <?=$board->getIconNew($notice_row['regdt'])?></td>
	<td><?=$notice_row['name']?></td>
	<td><?=substr($notice_row['regdt'],0,10)?></td>
	<td><?=number_format($notice_row['hit'])?></td>
</tr>
<tr><td colspan="5" class="line"></td></tr>
<?
}

for($i=$i; $row=mysql_fetch_array($qry); $i++)
{
	$encData=getEncode64("idx=".$row['idx']."&start=".$start."&skey=".$skey."&sstr=".$sstr);
	$bgcolor =  ($i % 2) ? "#ffffff" : "#fafafa";
?>
<tr height="25" align="center" bgcolor="<?=$bgcolor?>">
	<td><?=$letter_no?></td>
	<td style="text-align:left;padding-left:5px;"><?=$board->getBoardLevel($row['re_level']);?><?=$board->getBoardLock($row['bLock'])?> <a href="<?=$board->getLink($encData);?>"><?=$row['title']?></a> <?=$board->getIconNew($row['regdt'])?> </td>
	<td><?=$row['name']?></td>
	<td><?=substr($row['regdt'],0,10)?></td>
	<td><?=number_format($row['hit'])?></td>
</tr> 

<?
	$letter_no--;
}

if($i < 2)
	echo("<tr><td colspan='6' align='center'>등록된 게시물이 없습니다.</td></tr>");

?>
</tbody>
</table>