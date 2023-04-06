<table class="table table-bordered">
<colgroup>
<col width="200" />
<col />
</colgroup>
<tbody>
<tr>
	<th>제 목</th>
	<td><input type="text" name="title" class="input-xxlarge" value="<?=$wdata['title']?>" exp="제목을 "/></td>
</tr>
<tr>
	<th>작성자</th>
	<td>
		<input type="text" name="userid" class="input-large" value="<?=$wdata['userid']?>" exp="작성자를 "/>
		<input type="hidden" name="pwd" size="20" class="lbox" maxlength="12" value="<?=$wdata['pwd']?>"  />
	</td>
</tr>
 <tr>
	<th>게시물노출여부</th>
	<td>
		<div class="radio">
			<label>
				<input type="radio" class="ace" name="buse" id="buse1" value="Y" <?php if($wdata['buse'] == "Y"):?>checked<?php endif?>>
				<span class="lbl"> 노출</span>
			</label>
			<label>
				<input type="radio" class="ace" name="buse" id="buse2" value="N" <?php if($wdata['buse'] == "N"):?>checked<?php endif?>>
				<span class="lbl"> 비노출</span>
			</label>
		</div>
 	</td>
</tr>

<?if($board->info['bemail']){?>
<tr>
	<th>E-mail</th>
	<td><input type="text" name="email" size="40" class="lbox" value="<?=$wdata['email']?>" /></td>
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
 <!-- <tr>
	<th>글옵션</th>
	<td>
		<input type="checkbox" name="notice2" value="1" <?=($wdata['notice2'] == "Y") ? "checked=\"checked\"" : "";?>/> 안내글
	</td>
</tr> -->
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
  <?for($f=1; $f <= $board->info[upcnt]; $f++){?>
<tr>
	<th>첨부파일<?=$f?></th>
 	<td>
		<input type="file" name="upfile<?=$f?>" class="lbox w300" />
		<?
		if($wdata['file'][$f-1]['upfile'])
		{
			printf("&nbsp; <a href=\"/sadm/board/download.php?file=%s&org=%s\">%s %s</a> <img src=\"/sadm/img/icon/icon_x.gif\" style=\"vertical-align:middle;\" class=\"hand\" onclick=\"ImgDel('%d');\" />",$wdata['file'][$f-1]['upfile'], $wdata['file'][$f-1]['upreal'], FileTypeImg($wdata['file'][$f-1]['upfile']), $wdata['file'][$f-1]['upreal'], $wdata['file'][$f-1]['idx']);
		}
		?>
	</td>
</tr>
<?}?>
</tbody>
</table>
