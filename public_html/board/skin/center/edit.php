<div class="notice_ListArea">
<table cellspacing="0" cellpadding="0" class="table_Write" summary="공통게시판 쓰기 테이블입니다.">
	<colgroup>
		<col width="20%" /><col width="80%" />
	</colgroup>

	<tbody>
		<tr>
			<th><label for="title">제목</label></th>
			<td class="input">
				<input type="text" name="title" class="input_Type" style="width:250px;" value="<?=$wdata['title']?>" exp="제목을" />
				<?=$wdata['secret_tag']?>
			</td>
		</tr>
		<tr>
			<th><label for="name">작성자</label></th>
			<td class="input">
				<input type="text" id="name" name="name" class="input_Type" style="width:150px;" title="작성자(이름)을 입력하세요"  value="<?=$wdata['name']?>" />
			</td>
		</tr> 
		<?if($board->info['wAct'] < 10){?>
		<tr>
			<th>비밀번호</th>
			<td><input type="password" name="pwd" class="input_Type" style="width:150px;"/></td>
		</tr>
		<? } ?>
		<?if(count($wdata['acate']) > 0){?>
		<tr>
			<th>문의분류</th>
			<td style="padding-left:10px;"><?=$wdata['cate_tags']?></td>
		</tr>
		<? } ?>
		<?if($board->info['bemail']){?>
		<tr>
			<th>E-mail주소</th>
			<td style="padding-left:10px;"><input type="text" name="email" class="input_Type" chktype="email" style="width:250px" value="<?=$wdata['email']?>"/></td>
		</tr>
		<? } ?>
		<?if($board->info['btel']){
			$arr_hp = explode("-",$wdata['hp']);
		?>
		<tr>
			<th><label for="hp1">휴대폰번호</label></th>
			<td style="padding-left:10px;">
				<input type="text" name="hp1" class="w50 input_Type" value="<?=$arr_hp[0]?>"/> - 
				<input type="text" name="hp2" class="w50 input_Type" value="<?=$arr_hp[1]?>"/> - 
				<input type="text" name="hp3" class="w50 input_Type" value="<?=$arr_hp[2]?>"/> 
			</td>
		</tr>
		<?}?>
		<?
		for($f=1; $f <= $board->info['upcnt']; $f++)
		{
		?>
		<tr>
			<th>첨부파일<?=$f?></th>
			<td>
				<input type="file" name="upfile<?=$f?>" class="input_Type" />
				<?
				if($wdata['file'][$f-1]['upfile'])
				{
					printf("&nbsp; <a href=\"/board/download.php?file=%s&org=%s\">%s %s</a> <img src=\"/image/icon/icon_x.gif\" style=\"vertical-align:middle;\" class=\"hand\" onclick=\"ImgDel('%d');\" />",$wdata['file'][$f-1]['upfile'], $wdata['file'][$f-1]['upreal'], FileTypeImg($wdata['file'][$f-1]['upfile']), $wdata['file'][$f-1]['upreal'], $wdata['file'][$f-1]['idx']);
				}
				?>
			</td>
		</tr>
		<?
		}
		?>
		<tr>
			<th>내용</th>
			<td class="editer_Layer">
				<textarea id="content" name="content"><?=$wdata['content']?></textarea>
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

 