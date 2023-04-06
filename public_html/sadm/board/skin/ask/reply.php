<table class="tb">
<colgroup>
<col width="100" />
<col />
</colgroup>
<tbody style="height:29px;">
<tr>
	<th>제 목</th>
	<td><?=$wdata['title']?></td>
</tr>
<tr>
	<th>작성자</th>
	<td><?=$wdata['name']?></td>
</tr>
<?if($board->info['bemail']){?>
<tr>
	<th>E-mail</th>
	<td><?=$wdata['email']?></td>
</tr>
<?}?>
</tbody>
</table>
<?if($wdata[status]=="N"){?>
<table class="tb">
<tr>
	<th class="lp10 bold">답변내용</th>
</tr>
<tr>
	<td class="pd10" valign="top" height="150">
		<textarea id="fm_post1" name="recomment"></textarea>
		<script type="text/javascript">
		var myeditor1 = new cheditor();
		myeditor1.config.editorHeight = '300px';
		myeditor1.config.editorWidth = '100%';
		myeditor1.inputForm = 'fm_post1';
		myeditor1.run();
		</script>
	</td>
</tr>
</table>
<?}else{?>
<table class="tb">
<tr>
	<th class="lp10 bold">답변내용</th>
</tr>
<tr>
	<td class="pd10" valign="top" height="150">
		<textarea id="fm_post1" name="recomment"><?=stripslashes($wdata[recomment]);?></textarea>
		<script type="text/javascript">
		var myeditor1 = new cheditor();
		myeditor1.config.editorHeight = '300px';
		myeditor1.config.editorWidth = '100%';
		myeditor1.inputForm = 'fm_post1';
		myeditor1.run();
		</script>
	</td>
</tr>
</table>
<?}?>
