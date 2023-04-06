<table cellpadding="0" cellspacing="0">
	<caption class="blind">견적신청 현황</caption>
	<colgroup>
		<col width="93px"/>
		<col width="160px"/>
		<col width="185px"/>
		<col width="*"/>
		<col width="131px"/>
		<col width="139px"/>
	</colgroup>
	<thead>
		<tr>
			<th>번호</th>
			<th>신청자</th>
			<th>신청일</th>
			<th>제작어플</th>
			<th>처리상태</th>
			<th>상담내용</th>
		</tr>
	</thead>
	<tbody>
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
			$reply = "답변대기";
		}
	?>
	<tr>
		<td><img src="/img/icon/notice.gif" /></td>
		<td class="title"><a href="<?=$board->getLink($encData);?>" class="tit"><?=$board->getCateView($notice_row['cate'])?> <?=getCutString($notice_row['title'], $board->info['cutstr'])?><?=$board->getIconNew($notice_row['regdt'])?></a> </td>
		<td><?=$notice_row['name']?></td>
		<td><?=substr($notice_row['regdt'],0,10)?></td>
		<td><?=$reply?></td>
	</tr>
	<?
	}
	for($i=$i; $row=mysql_fetch_array($qry); $i++)
	{
		$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
		if($row['status']=="Y")
		{
			$reply = "<font color='red'>답변완료</font>";
		}else{
			$reply = "답변대기";
		}
	?>
		<tr>
			<td><?=$letter_no?></td>
			<td> <?=getCutString($row['name'], $board->info['cutstr'])?><?=$board->getIconNew($row['regdt'])?> <?=$board->getCommentCnt($row['idx'])?></td>
			<td><?=substr($row['regdt'],0,10)?></td>
			<td>
			<?php
				switch($row['add_1'])
				{
					case "1" : echo "안드로이드 어플"; break;
					case "2" : echo "아이폰 어플"; break;
					case "3" : echo "하이브리드 어플"; break; 
				}
			?>				
			</td>
			<td><em class="org"><?=$reply?></em></td>
			<td>
				<a href="<?=$board->getLink($encData);?>"  class="btn_made black sm">
					<span class="lt"></span>
					<span class="ce">상세보기</span>
					<span class="rt"></span>
				</a>
			</td>
		</tr> 
	<?
		$letter_no--;
	}

	if($i < 2)
		echo("<tr><td colspan='6'>등록된 게시물이 없습니다.</td></tr>");
	?>
	</tbody>
</table>
