<table cellpadding="0" cellspacing="0">
	<caption class="blind">세금계산서 신청양식</caption>
	<colgroup>
		<col width="162px"/>
		<col width="*"/>
		<col width="132px"/>
		<col width="290px"/>
	</colgroup>
	<tbody>
		<tr>
			<th><label for="title">사업자 상호</label></th>
			<td colspan="3">
				<input type="text" name="title" id="title" class="input_Type" style="width:250px;"  exp="사업자 상호를" />
				<?=$wdata['secret_tag']?>			
			</td>
		</tr>
		<tr>
			<th><label for="add_1">사업자등록번호</label></th>
			<td><input type="text" name="add_1" id="add_1" class="input_Type" style="width:250px;" exp="사업자등록번호를" /></td>
			<th><label for="add_2">대표자명</label></th>
			<td><input type="text" name="add_2" id="add_2" class="input_Type" style="width:250px;"  exp="대표자명을" /></td>
		</tr>
		<tr>
			<th><label for="add_3">업태</label></th>
			<td><input type="text" name="add_3" id="add_3" class="input_Type" style="width:250px;"  exp="업태를" /></td>
			<th><label for="add_4">종목</label></th>
			<td><input type="text" name="add_4" id="add_4" class="input_Type" style="width:250px;"  exp="종목을" /></td>
		</tr>
		<tr>
			<th><label for="mail">이메일</label></th>
			<td colspan="3"><input type="text" name="email" id="mail" class="input_Type" style="width:250px;"  /></td> 
		</tr>  
		<?
		if($board->info['upcnt'] > 0)
		{
			for($f=1; $f <= $board->info['upcnt']; $f++)
			{
		?>
			<tr>
			<th><label for="addfile">사업자등록증 사본</label></th>
			<td colspan="3">
			<input type="text" id="txt" />
			<input type="button" class="inputbtn yellow sm" value="파일선택" onclick="document.getElementById('addfile').click();"/>
			<input type="file" id="addfile" name="upfile<?=$f?>"  style="width:0; height:0; filter:alpha(opacity=0);opacity:0" onchange="document.getElementById('txt').value=this.value;"/></td>
		</tr>
		<?
			}
		}
		?>
			<tr>
			<th><label for="content">내용</label></th>
			<td colspan="3">
				<textarea id="content" name="content" class="contxt"></textarea>
				<script type="text/javascript">
				var myeditor2 = new cheditor();             // 에디터 개체를 생성합니다.
				myeditor2.config.editorHeight = '300px';    // 에디터 세로폭입니다.
				myeditor2.config.editorWidth = '100%';       // 에디터 가로폭입니다.
				myeditor2.inputForm = 'content';           // textarea의 ID 이름입니다.
				myeditor2.run();                            // 에디터를 실행합니다.
				</script>
			</td>
		</tr>
	</tbody>
</table>

 