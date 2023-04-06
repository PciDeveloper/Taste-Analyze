<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-bordered center"> 
<tr>
	<th class="center"><input type="checkbox" name="allchk" value="1" onclick="allCheck('chk[]');" /></td>
	<th class="center">번호</th>
	<th class="center">제목</th>
	<th class="center">작성자</th>
	<th class="center">등록일</th>
	<th class="center">조회</th>
	<th class="center">좋아요</th>
	<th class="center">노출여부</th>
	<th class="center">push</th>
</tr>
 <tbody>
<?
$notice_qry = $db->_execute("select * from sw_board where code='$code' AND notice='Y'  order by idx desc");
$i = 1;
for($i=$i; $notice_row=mysql_fetch_array($notice_qry); $i++)
{
	$encData=getEncode64("idx=".$notice_row['idx']."&start=".$start."&skey=".$skey."&sstr=".$sstr);
	$bgcolor =  ($i % 2) ? "#ffffff" : "#fafafa";
	$notice2 = ($notice_row['notice2'] == 'Y'  ? "[안내]" : "[공지]");
?>
<tr>
	<td><input type="checkbox" name="chk[]" value="<?=$notice_row['idx']?>" /></td>
	<td> <img src="/sadm/img/icon/icon_notice.gif" /> </td>
	<td style="text-align:left;padding-left:5px;"><a href="<?=$board->getLink($encData);?>"> <?=$board->getCateView($notice_row['cate'])?><?=$notice_row['title']?></a> <?=$board->getIconNew($notice_row['regdt'])?></td>
	<td><?=$notice_row['name']?></td>
	<td><?=substr($notice_row['regdt'],0,10)?></td>
	<td><?=number_format($notice_row['hit'])?></td>
	<td><?=number_format($notice_row['goods'])?></td>
	<td><img src="../img/icon/<?=($notice_row['buse'] == 'Y') ? 'icon_yes.gif' : 'icon_no.gif';?>" /></td>
	<td><button type="button" onclick="pushFn('<?=$notice_row['idx']?>')" class="btn btn-white btn-info btn-xs">push</button></td>
</tr>
 <?
}


for($i=$i; $row=mysql_fetch_array($qry); $i++)
{
	$encData=getEncode64("idx=".$row['idx']."&start=".$start."&skey=".$skey."&sstr=".$sstr);
	$bgcolor =  ($i % 2) ? "#ffffff" : "#fafafa";
	$notice2 = ($row['notice2'] == 'Y'  ? "[안내]&nbsp;&nbsp;" : "");
?>
<tr>
	<td><input type="checkbox" name="chk[]" value="<?=$row['idx']?>" /></td>
	<td><?=$letter_no?></td>
	<td style="text-align:left;padding-left:5px;"><?=$board->getBoardLevel($row['re_level']);?><?=$board->getBoardLock($row['bLock'])?> <a href="<?=$board->getLink($encData);?>"><?=$board->getCateView($row['cate'])?>  <?=$row['title']?></a> <?=$board->getIconNew($row['regdt'])?> <?=$board->getCommentCnt($row['idx'])?> </td>
	<td><?=$row['name']?></td>
	<td><?=substr($row['regdt'],0,10)?></td>
	<td><?=number_format($row['hit'])?></td>
	<td><?=number_format($row['goods'])?></td>
	<td><img src="../img/icon/<?=($row['buse'] == 'Y') ? 'icon_yes.gif' : 'icon_no.gif';?>" /></td>
	<td><button type="button" onclick="pushFn('<?=$row['idx']?>')" class="btn btn-white btn-info btn-xs">push</button></td>
</tr>

<?
	$letter_no--;
}

if($i < 2)
	echo("<tr><td colspan='8' align='center'>등록된 게시물이 없습니다.</td></tr>");

?>
</tbody>
</table>