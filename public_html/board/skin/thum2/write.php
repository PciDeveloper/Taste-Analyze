<table cellspacing="0" class="boardW">
<colgroup>
<col width="120" />
<col />
</colgroup>
<tr>
	<th>제 목</th>
	<td>
		<input type="text" name="title" class="lbox" style="width:500px;" value="<?=$wdata['re_title']?>" exp="제목을" />
		<?=$wdata['secret_tag']?>
	</td>
</tr>
<tr>
	<th>작성자</th>
	<td><input type="text" name="name" class="lbox w100" value="<?=$_SESSION['SES_USERNM']?>" /></td>
</tr>
<?if($board->info['wAct'] < 10){?>
<tr>
	<th>비밀번호</th>
	<td><input type="password" name="pwd" class="lbox w150" /></td>
</tr>
<? } ?>
<?if($board->info['btel']){?>
<tr>
	<th>전화번호</th>
	<td>
		<input type="text" name="tel1" class="lbox w50" maxlength="4" value="<?=$wdata['extel'][0]?>" chktype="number" />
		-
		<input type="text" name="tel2" class="lbox w50" maxlength="4" value="<?=$wdata['extel'][1]?>" chktype="number" />
		-
		<input type="text" name="tel3" class="lbox w50" maxlength="4" value="<?=$wdata['extel'][2]?>" chktype="number" />
	</td>
</tr>
<? } ?>
<?if($board->info['bemail']){?>
<tr>
	<th>E-mail주소</th>
	<td><input type="text" name="email" class="lbox w300" chktype="email" /></td>
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
		<textarea id="content" name="content" style="width:95%;height:300px;text-align:left;padding:10px;"><?=$wdata['re_content']?></textarea>
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
<? if(!strcmp($board->info['bspam'], "Y")){ ?>
<tr>
	<th>자동입력방지</th>
	<td>
		<img src="/lib/zm_crypt_img.php?zCode=<?=$zEncrypt?>" id="crypt_img" align="absmiddle" />
		<input type="button" value="새로고침" style="width:75px;height:30px;cursor:pointer;" onclick="Common.getNewCrypt();" />
		<input type="text" name="spamCode" class="lbox w150" exp="자동입력방지코드를" />
	</td>
</tr>
<? } ?>
</table>