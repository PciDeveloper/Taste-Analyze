
<table class="table table-bordered">
<colgroup>
<col width="100" />
<col />
</colgroup>
<tbody style="height:29px;">
<tr>
	<th>제 목</th>
	<td><input type="text" name="title" class="input-xxlarge" value="<?=$wdata['re_title']?>" exp="제목을 "/></td>
</tr>
<tr>
	<th>작성자</th>
	<td><input type="text" name="name" class="input-large" value="<?=$_SESSION['SES_ADMNM']?>" exp="작성자를 "/></td>
</tr>
<?if($board->info['wAct'] < 10){?>
<tr>
	<th>비밀번호</th>
	<td><input type="password" name="pwd" class="w100 lbox" maxlength="12" value="<?=($wdata['bLock'] == "Y") ? $wdata['pwd'] : '';?>"  exp="비밀번호를" /></td>
</tr>
<?}?>
<tr>
	<th>날짜</th>
	<td>
			<input type="text" name="sday" id="sday" class="date-picker"  />
	</td>
</tr>
<?if($board->info['bemail']){?>
<tr>
	<th>E-mail</th>
	<td><input type="text" name="email" class="w250 lbox" /></td>
</tr>
<?}?>
<?if($board->info['bhome']){?>
<tr>
	<th>홈페이지</th>
	<td><input type="text" name="home" class="w300 lbox" /></td>
</tr>
<?}?> 
<?if(count($wdata['acate']) > 0){?>
<tr>
	<th>분류</th>
	<td>
		<?=$wdata['cate_tags']?>
	</td>
</tr>
<?}?>
<tr>
	<th>내용</th>
	<td bgcolor="#ffffff" style="padding:5px;" align="center"> 
		 <textarea name="content" class="autosize-transition form-control"><?=$wdata['content']?></textarea>
	</td>
</tr> 
</tbody>
</table>