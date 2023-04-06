<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-bordered">

<tr><td class="line"></td></tr>
<tr bgcolor="#f6f6f6" height="29">
	<td>
		<div style="float:left;" class="lp10 bold"><?=$vdata['title']?></div>
		<div style="float:right;" class="rp10"><?=$vdata['name']?></div>
	</td>
</tr>
<tr><td class="line"></td></tr>
<? if(count($vdata['file']) > 0){ ?>
<tr>
	<td style="padding:5px 0 0 10px;">
	<?
	for($f=0; $f < count($vdata['file']); $f++)
	{
		printf("<div style=\"height:22px;\">%s</div>", $vdata['file'][$f]['downlink']);
	}
	?>
	</td>
</tr>
<tr><td class="line"></td></tr>
<? } ?>
<tr height="29">
	<td class="rp10">
		Date : <?=str_replace("-",".",substr($vdata['regdt'], 0, 10))?> / IP : <?=$vdata['ip']?>
	</td>
</tr>
<tr>
	<td valign="top" height="150" style="padding:10px;">
		<?
		for($f=0; $f < count($vdata['file']); $f++)
			printf("%s", $vdata['file'][$f]['imgtag']);
		?>

		<?=$vdata['content']?>
	</td>
</tr>
<tr><td class="line"></td></tr>
</table>
