<table class="table table-bordered">
<colgroup>
<col width="100" />
<col />
</colgroup>
<tbody>
<tr>
	<th>제 목</th>
	<td><input type="text" name="title" class="input-xxlarge" value="<?=$wdata['title']?>" exp="제목을 "/></td>
</tr>
<tr>
	<th>작성자</th>
	<td><input type="text" name="name" class="input-large" value="<?=$wdata['name']?>" exp="작성자를 "/></td>
</tr>
<tr>
	<th>날짜</th>
	<td>
			<input type="text" name="sday" id="sday" class="date-picker"  value="<?=$wdata['sday']?>"/>
	</td>
</tr>
<?if($board->info['bemail']){?>
<tr>
	<th>E-mail</th>
	<td><input type="text" name="email" size="40" class="lbox" value="<?=$wdata['email']?>" /></td>
</tr>
<?}?> 
<?if($board->info['bcate'] && $board->info['scate']){?>
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