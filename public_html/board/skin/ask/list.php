<ul>
		<li class="head">
				<div class="num">번호</div>
				<div class="title">제목</div>
				<div class="writer">작성자</div>
				<div class="date">작성일</div>
				<div class="date">답변여부</div>
		</li>
<?
$notice_qry = $db->_execute("select * from sw_board where code='$code' AND notice='Y' order by idx desc");
$i = 1;
for($i=$i; $notice_row=mysql_fetch_array($notice_qry); $i++)
{
	$encData = getEncode64("idx=".$notice_row['idx']."&start=".$start."&".$pg->getparm);
	if($notice_row['status']=="Y")
	{
		$reply = "<font color='red'>답변완료</font>";
	}else{
		$reply = "답변전";
	}
?>

<li>
		<div class="num"><img src="/img/icon/notice _bt.png" /></div>
		<div class="title"><a href="<?=$board->getLink($encData);?>"><?=$board->getCateView($notice_row['cate'])?> <?=getCutString($notice_row['title'], $board->info['cutstr'])?> <?=$board->getIconNew($notice_row['regdt'])?></a></div>
		<div class="writer"><?=$notice_row['name']?></div>
		<div class="date"><?=substr($notice_row['regdt'],0,10)?></div>
		<div class="date">&nbsp;</div>
</li>
<?
}

for($i=$i; $row=mysql_fetch_array($qry); $i++)
{
	$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
	if($row['status']=="Y")
	{
		$reply = "<font color='red'>답변완료</font>";
	}else{
		$reply = "답변전";
	}

?>
<li>
		<div class="num"><?=$letter_no?></div>
		<div class="title"><a href="<?=$board->getLink($encData);?>"><?=$board->getCateView($row['cate'])?> <?=getCutString($row['title'], $board->info['cutstr'])?> <?=$board->getIconNew($row['regdt'])?></a></div>
		<div class="writer"><?=$row['name']?></div>
		<div class="date"><?=substr($row['regdt'],0,10)?></div>
		<div class="date"><?=$reply?></div>
</li>
<?
	$letter_no--;
}

if($i < 2)
	echo("<li style='text-align:center;'>등록된 게시물이 없습니다.</li>");
?>
</ul>
