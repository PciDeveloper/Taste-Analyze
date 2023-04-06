<table class="table table-bordered">
<colgroup>
<col width="200" />
<col />
</colgroup>
<tbody>
<tr>
	<th>제 목</th>
	<td><input type="text" name="title"  class="input-xxlarge" value="<?=$wdata['title']?>" exp="제목을 "/></td>
</tr>
<tr>
	<th>작성자</th>
	<td><input type="text" name="name"  class="input-large" value="<?=$wdata['name']?>" exp="작성자를 "/></td>
</tr>
<?if($board->info['wAct'] < 10){?>
<tr>
	<th>비밀번호</th>
	<td><input type="password" name="pwd" size="20" class="input-large" maxlength="12" value="<?=$wdata['pwd']?>" exp="비밀번호를 " /></td>
</tr>
<?}?>
<?if($board->info['bemail']){?>
<tr>
	<th>E-mail</th>
	<td><input type="text" name="email" size="40" class="input-large" value="<?=$wdata['email']?>" /></td>
</tr>
<?}?>
<tr>
	<th>글옵션</th>
	<td>
		<input type="checkbox" name="notice" value="1" <?=($wdata['notice'] == "Y") ? "checked=\"checked\"" : "";?>/> 공지글
		&nbsp;&nbsp;&nbsp;
		<?=$wdata['secret_tag']?>
	</td>
</tr>
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
			<script type="text/javascript" src="/editor/js/HuskyEZCreator.js" charset="utf-8"></script>
			<textarea id="content" name="content"   rows="10" cols="100" style="width:100%; height:300px"><?=$wdata['content']?></textarea>
<script type="text/javascript">
<!--
	var editor_object = [];
nhn.husky.EZCreator.createInIFrame({
	oAppRef: editor_object,
	elPlaceHolder: "content",
	sSkinURI: "/editor/SmartEditor2Skin2.html",
	htParams : {
		// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseToolbar : true,
		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : true,
		// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : true,
	}
});
//-->
</script>
	</td>
</tr>
<?if($board->info[part] > 10){?>
<tr>
	<td>첨부파일</td>
	<td><input type="file" name="upfile" size="20" class="lbox" /></td>
</tr>
<?}?>
</tbody>
</table>
