<table cellspacing="0" class="boardW">
<colgroup>
<col width="120" />
<col />
</colgroup>
<tr>
	<th>제 목</th>
	<td>
		<input type="text" name="title" class="lbox" style="width:500px;" value="<?=$wdata['title']?>" exp="제목을" />
		<?=$wdata['secret_tag']?>
	</td>
</tr>
<tr>
	<th>작성자</th>
	<td><input type="text" name="name" class="lbox w100" value="<?=$wdata['name']?>" /></td>
</tr>
<?if($board->info['wAct'] < 10){?>
<tr>
	<th>비밀번호</th>
	<td><input type="password" name="pwd" class="lbox w150" value="<?=$wdata['pwd']?>" /></td>
</tr>
<? } ?>
<?if($board->info['btel']){?>
<tr>
	<th>전화번호</th>
	<td>
		<input type="text" name="tel1" class="lbox w50" maxlength="4" value="<?=$wdata['extel'][0]?>" />
		-
		<input type="text" name="tel2" class="lbox w50" maxlength="4" value="<?=$wdata['extel'][1]?>" />
		-
		<input type="text" name="tel3" class="lbox w50" maxlength="4" value="<?=$wdata['extel'][2]?>" />
	</td>
</tr>
<? } ?>
<?if($board->info['bemail']){?>
<tr>
	<th>E-mail주소</th>
	<td><input type="text" name="email" class="lbox w300" chktype="email" value="<?=$wdata['email']?>" /></td>
</tr>
<? } ?>
<?if(count($wdata['acate']) > 0){?>
<tr>
	<th>분 류</th>
	<td><?=$wdata['cate_tags']?></td>
</tr>
<? } ?>
<tr>
	<td colspan="2" style="padding:5px 10px;">
		<textarea id="content" name="content" style="width:95%;height:300px;text-align:left;padding:10px;"><?=$wdata['content']?></textarea>
		<?=$board->_webeditor('myeditor');?>
	</td>
</tr>
<?
if($board->info['upcnt'] > 0)
{
	for($f=1; $f <= $board->info['upcnt']; $f++)
	{
?>
<tr>
	<th>첨부파일<?=($board->info['upcnt'] > 1) ? $f : "";?></th>
	<td><input type="file" name="upfile<?=$f?>" class="lbox w300" /></td>
</tr>
<?
	}
}
?>
</table>