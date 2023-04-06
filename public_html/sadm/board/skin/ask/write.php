<table class="table table-bordered">
<colgroup>
<col width="200" />
<col />
</colgroup>
<tbody style="height:29px;">
<tr>
	<th>제 목</th>
	<td><input type="hidden" name="title" value="<?=$wdata['title']?>"><?=$wdata['title']?></td>
</tr>
<tr>
	<th>작성자</th>
	<td><input type="hidden" name="name" value="<?=$wdata['name']?>"><?=$wdata['name']?></td>
</tr>
<?if($board->info['bemail']){?>
<tr>
	<th>E-mail</th>
	<td><?=$wdata['email']?></td>
</tr>
<?}?>
<tr>
	<th>문의내용</th>
	<td>
		<input type="hidden" name="content" value="<?=$wdata['content']?>"><?=$wdata['content']?>
	</td>
</tr>
</tbody>
</table>
<?if($wdata[status]=="N"){?>
	<table class="table table-bordered">
	<colgroup>
	<col width="200" />
	<col />
	</colgroup>
<tr>
	<th class="lp10 bold">답변내용</th>
</tr>
<tr>
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
</table>
<?}else{?>
	<table class="table table-bordered">
	<colgroup>
	<col width="200" />
	<col />
	</colgroup>
<tr>
	<th class="lp10 bold">답변내용</th>
</tr>
<tr>
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
</table>
<?}?>
