	<ul class="solutionselect">
		<li><?=$wdata['cate_tags']?></li>
	</ul>
	<table cellpadding="0" cellspacing="0">
		<caption class="blind">견적 신청양식</caption>
		<colgroup>
			<col width="162px"/>
			<col width="*"/>
			<col width="132px"/>
			<col width="290px"/>
		</colgroup>
		<tbody>
			<tr>
				<th><label for="com">업체명</label></th>
				<td>
					<input type="hidden" name="bLock" value="Y">
					<input type="text" id="com" name="title"  value="<?=$wdata['title']?>" exp="업체명을" class="w240"/>
					<?=$wdata['secret_tag']?>
				</td>
				<th><label for="email">이메일</label></th>
				<td><input type="text" id="email" name="email" chktype="email" value="<?=$wdata['email']?>"  class="w240"/></td>
			</tr>
			<tr>
				<th><label for="master">담당자명</label></th>
				<td><input type="text" id="master" name="name" exp="담당자명을" value="<?=$wdata['name']?>" class="w240"/></td>
				<th><label for="tel1">담당자 연락처</label></th>
				<td>
				<?php
					$arr_hp = explode("-",$wdata['tel']);
				?>
					<input type="text" name="tel1" id="tel1" class="w50" maxlength="4" value="<?=$arr_hp[0]?>"/> - 
					<input type="text" name="tel2" class="w50" maxlength="4" value="<?=$arr_hp[1]?>"/> - 
					<input type="text" name="tel3" class="w50" maxlength="4"  value="<?=$arr_hp[2]?>"/> 
				</td>
			</tr>
			 <tr>
				<th><label for="chk1">제작어플</label></th>
				<td colspan="3">
					<input type="radio" id="chk1" name="add_1" value="1" <?php if($wdata['add_1'] == 1):?>checked ="checked"<?php endif?> />&nbsp;<label for="chk1">안드로이드 어플</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="chk2"  name="add_1" value="2" <?php if($wdata['add_1'] == 2):?>checked ="checked"<?php endif?>/>&nbsp;<label for="chk2">아이폰 어플</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="chk3"  name="add_1" value="3" <?php if($wdata['add_1'] == 3):?>checked ="checked"<?php endif?>/>&nbsp;<label for="chk3">하이브리드 어플</label>
				</td>
			</tr>   
			<tr>
				<th><label for="site">유사한어플</label></th>
				<td colspan="3"><input type="text" id="site" name="add_2" value="<?=$wdata['add_2']?>" class="w240"/>&nbsp;&nbsp;<em class="blue s">예)야놀자, 배달의민족</em></td>
			</tr>
			<tr>
				<th><label for="chk1">개발예산</label></th>
				<td colspan="3">
					<input type="radio" id="chk11" name="add_3" value="1" <?php if($wdata['add_3'] == 1):?>checked ="checked"<?php endif?>  />&nbsp;<label for="chk11">500만원 이하</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="chk22"  name="add_3" value="2" <?php if($wdata['add_3'] == 2):?>checked ="checked"<?php endif?> />&nbsp;<label for="chk22">1,000만원 이하</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="chk33"  name="add_3" value="3" <?php if($wdata['add_3'] == 3):?>checked ="checked"<?php endif?> />&nbsp;<label for="chk33">2,000만원 이하</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="chk44"  name="add_3" value="4" <?php if($wdata['add_3'] == 4):?>checked ="checked"<?php endif?> />&nbsp;<label for="chk44">3,000만원 이하</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="chk55"  name="add_3" value="5" <?php if($wdata['add_3'] == 5):?>checked ="checked"<?php endif?> />&nbsp;<label for="chk55">5,000만원 이하</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="chk66"  name="add_3" value="6" <?php if($wdata['add_3'] == 6):?>checked ="checked"<?php endif?> />&nbsp;<label for="chk66">1억원 이상</label>
				</td>				
			</tr>
			<!-- <tr>
				<th><label for="brandsite">참조 사이트</label></th>
				<td colspan="3">http://&nbsp;&nbsp;<input type="text" id="brandsite" name="add_3" value="<?=$wdata['add_3']?>"class="w240"/>&nbsp;&nbsp;<em class="blue s">http://제외하고입력</em></td>
			</tr>
			<tr>
				<th><label for="addimg">캡처이미지</label></th>
				<td colspan="3">
					<input type="button" class="inputbtn gray sm" value="입력란추가" id="add_img"/> 
					<div id="add_img_list">
					<?
					if(count($exImg) > 0)
					{
						for($k =0; $k < count($exImg); $k++)
						{
								printf("<div class='value'><input type=\"file\" name=\"etcimg[]\" class=\"lbox w300\" /> %s <a href=\"javascript:void(window.open('/board/image.view.php?path=board&img=%s', '', 'width=100, height=100, top=300, left=300'))\">%s</a> &nbsp; <img src=\"/image/btn/btn_delete_s.gif\" align=\"absmiddle\" class=\"hand\" onclick=\"DelEtcImg('%s' , '%s');\" /> </div>", $exImg[$k], $exImg[$k], getImageTag("../upload/board", $exImg[$k], 20, 20, "img1"), $k,$exImg[$k]);
						} 
					}
					else
					{
					?>
					<input type="text" id="imgurl" /> 
					<input type="button" class="inputbtn yellow sm" value="찾아보기" onclick="document.getElementById('addimg').click();"/>
					<input type="button" class="inputbtn gray sm" value="입력란추가" id="add_img"/>
					<input type="file" id="addimg" name="etcimg[]" style="width:0; height:0; filter:alpha(opacity=0);opacity:0" onchange="document.getElementById('imgurl').value=this.value;"/>
					<?php
					}
					?>
					</div>
					<p class="mt5">
						<em class="blue s">첨부파일은 jpg, gif ,png만 업로드가능합니다. (단, 용량은 2MByte 미만이어야 합니다.)</em>
					</p>
 				</td>
			</tr>   -->
		<?
		for($f=1; $f <= $board->info['upcnt']; $f++)
		{
		?>
		<tr>
			<th><label for="upfile<?=$f?>">첨부파일</label></th>
			<td colspan="3">
				<input type="text" id="txt" />
				<input type="button" class="inputbtn yellow sm" value="찾아보기" onclick="document.getElementById('upfile<?=$f?>').click();"/>

				<input type="file" id="upfile<?=$f?>" name="upfile<?=$f?>" style="width:0; height:0; filter:alpha(opacity=0);opacity:0" onchange="document.getElementById('txt').value=this.value;"/>
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
				<th><label for="content">내용</label></th>
				<td colspan="3">
 					<textarea id="content" name="content" id="content" cols="30" rows="10" class="contxt"><?=$wdata['content']?></textarea>
					<script type="text/javascript">
					var myeditor2 = new cheditor();             // 에디터 개체를 생성합니다.
					myeditor2.config.editorHeight = '300px';    // 에디터 세로폭입니다.
					myeditor2.config.editorWidth = '100%';       // 에디터 가로폭입니다.
					myeditor2.inputForm = 'content';           // textarea의 ID 이름입니다.
					myeditor2.run();                            // 에디터를 실행합니다.
					</script>
				</td>
			</tr> 
			<tr>
				<th><label for="pwd">비밀번호</label></th>
				<td colspan="3"><input type="password" id="pwd" name="pwd" class="w270" exp="비밀번호를"/>
				&nbsp;&nbsp;<em class="blue s">영문/숫자4글자 이상. 글을 확인하실때를 위해 필요하니 패스워드를 꼭 기억하세요.</em></td>
			</tr>
		</tbody>
	</table>
<style>
.valeu{position: relative;}
</style>
<script type="text/javascript">
<!--
		// 캡쳐이미지 추가
		var f="<?=count($exImg)?>";
	$(document).delegate("#add_img" , "click" , function(){ 

		if(f < 5)
		{
			$("#add_img_list").append("<div class='value'><input type='text' id='imgurl"+f+"'/> <input type='botton' class='inputbtn yellow sm' value='찾아보기' onclick='document.getElementById(\"addimg"+f+"\").click();'/> <input type='file' id='addimg"+f+"' name='etcimg[]' value='' style='width:0; height:0; filter:alpha(opacity=0);opacity:0' onchange='document.getElementById(\"imgurl"+f+"\").value=this.value;'/><button type='button' class='add_img_del inputbtn gray sm'> - 입력란삭제</button></div>");
			f++;
		}
		else
		{
			alert("캡처이미지는 5개까지만 첨부가능합니다.");
			return;
		}

	});
	// 캡쳐이미지 삭제
	$(document).delegate(".add_img_del" , "click" , function(){ 
		$("#add_img_list div").last().remove();
		f--;

	});
//-->
</script> 
  