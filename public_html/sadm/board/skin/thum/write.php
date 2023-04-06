
<table class="table table-bordered">
<colgroup>
<col width="200" />
<col />
</colgroup>
<tbody style="height:29px;">
 <tr>
	<th>게시물노출여부</th>
	<td>
		<div class="radio">
			<label>
				<input type="radio" class="ace" name="buse" id="buse1" value="Y" checked>
				<span class="lbl"> 노출</span>
			</label>
			<label>
				<input type="radio" class="ace" name="buse" id="buse2" value="N">
				<span class="lbl"> 비노출</span>
			</label>
		</div>
 	</td>
</tr>
<tr>
	<th>제 목</th>
	<td><input type="text" name="title" class="input-xxlarge" value="<?=$wdata['re_title']?>" exp="제목을 "/></td>
</tr>

<tr>
	<th>작성자</th>
	<td>
    <input type="text" name="userid" class="input-large" value="<?=$wdata['userid']?>" exp="작성자를 "/>

		<!-- <select name="userid" exp="작성자를">
		<option value="">::: 선택 :::</option>
		<?php
		$sql = "select * from sw_member order by idx asc";
		$rs = $db->_execute($sql);
		while($area = mysql_fetch_array($rs))
		{
			if($wdata['userid'] == $area['userid'])
				printf("<option value='%s' selected>%s</option>", $area['userid'], $area['nick']);
			else
				printf("<option value='%s'>%s</option>", $area['userid'], $area['nick']);
		}

		?>
		</select>  -->
	</td>
</tr>
<?if($board->info['wAct'] < 10){?>
<tr>
	<th>비밀번호</th>
	<td><input type="password" name="pwd" class="input-large" maxlength="12" value="<?=($wdata['bLock'] == "Y") ? $wdata['pwd'] : '';?>"  exp="비밀번호를" /></td>
</tr>
<?}?>
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
  <tr>
	<th>글옵션</th>
	<td>
		<input type="checkbox" name="notice" value="Y" />공지글
		<?=$wdata['secret_tag']?>
	</td>
</tr>
  <!-- <tr>
	<th>글옵션</th>
	<td>
		<input type="checkbox" name="notice2" value="Y" />안내글
	</td>
</tr>  -->
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
			<script type="text/javascript" src="/editor/js/HuskyEZCreator.js" charset="utf-8"></script>
			<textarea id="content" name="content" rows="10" cols="100" style="width:100%; height:300px"><?=$wdata['re_content']?></textarea>
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
   <?
for($f=1; $f <= $board->info['upcnt']; $f++)
{
?>
<tr>
	<th>첨부파일<?=$f?></th>
	<td><input type="file" name="upfile<?=$f?>" class="w300 lbox" /></td>
</tr>
<?}?>
</tbody>
</table>
