<table cellpadding="0" cellspacing="0">
<caption class="blind">견적 신청양식</caption>
<colgroup>
	<col width="162px"/>
	<col width="*"/>
	<col width="132px"/>
	<col width="290px"/>
</colgroup>
<tbody>
	<tr>
		<th><label for="com">업체명</label></th>
		<td><?=$vdata['title']?></td>
		<th><label for="email">제작어플</label></th>
		<td>
			<?php
				switch($vdata['add_1'])
				{
					case "1" : echo "안드로이드 어플"; break;
					case "2" : echo "아이폰 어플"; break;
					case "3" : echo "하이브리드 어플"; break; 
				}
			?>		
		</td>
	</tr>
	<tr>
		<th><label for="com">담당자명</label></th>
		<td><?=$vdata['name']?></td>
		<th><label for="email">담당자 연락처</label></th>
		<td><?=$vdata['tel']?></td>
	</tr>
	<tr>
		<th><label for="com">이메일</label></th>
		<td><?=$vdata['email']?></td>
		<th><label for="email">개발예산</label></th>
		<td>
			<?php
				switch($vdata['add_3'])
				{
					case "1" : echo "500만원 이하"; break;
					case "2" : echo "1,000만원 이하"; break;
					case "3" : echo "2,000만원 이하"; break;
					case "4" : echo "3,000만원 이하"; break;
					case "5" : echo "5,000만원 이하"; break;
					case "6" : echo "1억원 이하"; break;
				}
			?>
		</td>

	</tr>
	<tr>
		<th><label for="com">유사한어플</label></th>
		<td><?=$vdata['add_2']?></td>
		<th><label for="com">첨부파일</label></th>
		<td>
		<? 
		if(count($vdata['file']) > 0)
		{
			for($f=0, $g=1; $f < count($vdata['file']); $f++, $g++)
			{
		?>
		<p class="viewSpan">
			<span class="name"><?=$vdata['file'][$f]['downlink']?></span>   
		</p> 
		<?
			}
		}
		?>
		</td>
	</tr> 
	<tr>
	<th><label for="content">내용</label></th>
	<td colspan="3"><?=$vdata['content']?></td>
</tr>
</tbody>
</table>
<?if($vdata['status']=="Y"){?>
<div style="height:20px;">&nbsp;</div>
<table cellpadding="0" cellspacing="0">
<tr>
	<td>답변내용</td>
</tr>
<tr>
	<td>
		<div class="txt_Area">
			<?=stripslashes($vdata['recomment'])?>
		</div>
	</td>
</tr>
</table>
<?}?>

 