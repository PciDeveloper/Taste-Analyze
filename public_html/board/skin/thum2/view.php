<table cellspacing="0" class="boardV">
<colgroup>
<col width="120" />
<col />
<col width="120" />
<col />
</colgroup>
<thead>
<tr>
	<th colspan="4">
		<?=$board->getCateView($vdata['cate'])?> <?=$vdata['title']?>
	</th>
</tr>
</thead>
<tbody>
<tr>
	<th>작성자</th>
	<td><?=$vdata['name']?></td>
	<th>작성일</th>
	<td><?=substr($vdata['regdt'], 0, 10)?></td>
</tr>
<tr>
	<td colspan="4" height="300" style="vertical-align:top;">
		<?
		if(!$board->info['lsimg'])
		{
			for($f=0; $f < count($vdata['file']); $f++)
				printf("%s", $vdata['file'][$f]['imgtag']);
		}
		?>
		<?=$vdata['content']?>
	</td>
</tr>
<? 
if($board->info['bdown'])
{
	if(count($vdata['file']) > 0)
	{
		for($f=0, $g=1; $f < count($vdata['file']); $f++, $g++)
		{
?>
<tr>
	<th>첨부파일<?=$g?></th>
	<td colspan="3"><?=$vdata['file'][$f]['downlink']?></td>
</tr>
<?
		}
	}
}
?>
<? if($board->info['vip']){ ?>
<tr>
	<td colspan="4" style="text-align:right;" class="nonline"><?=getipAddress($vdata['ip'])?></td>
</tr>
<? } ?>
</tbody>
</table>