	<div class="agreement">
		<textarea name="" id="" cols="30" rows="10" readonly="readonly"><?=$row[3]?></textarea>
		<p>
			<input type="checkbox" id="agree" name="chk" value="1"/>&nbsp;
			<label for="agree">위 관련내용을 읽었으며 정책 및 약관에 동의합니다.</label>
		</p>
	</div>

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
					<input type="text" id="com" name="title"  exp="업체명을" class="w240"/>
					<?=$wdata['secret_tag']?>
				</td>
				<th><label for="email">이메일</label></th>
				<td><input type="text" id="email" name="email" chktype="email" class="w240"/></td>
			</tr>
			<tr>
				<th><label for="master">담당자명</label></th>
				<td><input type="text" id="master" name="name" exp="담당자명을" class="w240"/></td>
				<th><label for="tel1">담당자 연락처</label></th>
				<td>
					<input type="text" name="tel1" id="tel1" class="w50 input_Type"  style="width:50px;"  maxlength="4"/> - 
					<input type="text" name="tel2" class="w50 input_Type" style="width:50px;"  maxlength="4"/> - 
					<input type="text" name="tel3" class="w50 input_Type"  style="width:50px;"  maxlength="4"/> 
				</td>
			</tr>
			 <tr>
				<th><label for="chk1">제작어플</label></th>
				<td colspan="3">
					<input type="radio" id="chk1" name="add_1" value="1" checked />&nbsp;<label for="chk1">안드로이드 어플</label>&nbsp;&nbsp;&nbsp;&nbsp
					<input type="radio" id="chk2"  name="add_1" value="2"/>&nbsp;<label for="chk2">아이폰 어플</label>&nbsp;&nbsp;&nbsp;&nbsp
					<input type="radio" id="chk3"  name="add_1" value="3"/>&nbsp;<label for="chk3">하이브리드 어플</label>
				</td>
			</tr>  
			<tr>
				<th><label for="site">유사한어플</label></th>
				<td colspan="3"><input type="text" id="site" name="add_2" class="w240"/>&nbsp;&nbsp;<em class="blue s">예)야놀자, 배달의민족</em></td>
			</tr>
			<tr>
				<th><label for="chk1">개발예산</label></th>
				<td colspan="3">
					<input type="radio" id="chk11" name="add_3" value="1" checked />&nbsp;<label for="chk11">500만원 이하</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="chk22"  name="add_3" value="2"/>&nbsp;<label for="chk22">1,000만원 이하</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="chk33"  name="add_3" value="3"/>&nbsp;<label for="chk33">2,000만원 이하</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="chk44"  name="add_3" value="4"/>&nbsp;<label for="chk44">3,000만원 이하</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="chk55"  name="add_3" value="5"/>&nbsp;<label for="chk55">5,000만원 이하</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="chk66"  name="add_3" value="6"/>&nbsp;<label for="chk66">1억원 이상</label>
				</td>				
			</tr>
			<!-- <tr>
				<th><label for="brandsite">참조 사이트</label></th>
				<td colspan="3">http://&nbsp;&nbsp;<input type="text" id="brandsite" name="add_3" class="w240"/>&nbsp;&nbsp;<em class="blue s">http://제외하고입력</em></td>
			</tr> 
			<tr>
				<th><label for="addimg">캡처이미지</label></th>
				<td colspan="3">
					
					<input type="text" id="imgurl" /> 
					<input type="button" class="inputbtn yellow sm" value="찾아보기" onclick="document.getElementById('addimg').click();"/>
					<input type="button" class="inputbtn gray sm" value="입력란추가" id="add_img"/>
					<input type="file" id="addimg" name="etcimg1" style="width:0; height:0; filter:alpha(opacity=0);opacity:0" onchange="document.getElementById('imgurl').value=this.value;"/>
					<div id="add_img_list"></div>
					<p class="mt5">
						<em class="blue s">첨부파일은 jpg, gif ,png만 업로드가능합니다. (단, 용량은 2MByte 미만이어야 합니다.)</em>
					</p>

				</td>
			</tr> -->
		<?
		if($board->info['upcnt'] > 0)
		{
			for($f=1; $f <= $board->info['upcnt']; $f++)
			{
		?> 
			<tr>
				<th><label for="upfile<?=$f?>">첨부파일</label></th>
				<td colspan="3">
					<input type="text" id="txt" />
					<input type="button" class="inputbtn yellow sm" value="찾아보기" onclick="document.getElementById('upfile<?=$f?>').click();"/>
					<input type="file" id="upfile<?=$f?>" name="upfile<?=$f?>" style="width:0; height:0; filter:alpha(opacity=0);opacity:0" onchange="document.getElementById('txt').value=this.value;"/>
					<p class="mt5">
						<em class="blue s">첨부파일은 zip파일만 업로드가능합니다. (단, 용량은 2MByte 미만이어야 합니다.)</em>
					</p>
				</td>
			</tr>
			<?
				}
			}
			?>
				<tr>
				<th><label for="content">내용</label></th>
				<td colspan="3">
 					<textarea id="content" name="content" id="content" cols="30" rows="10" class="contxt"><?=$wdata['re_content']?></textarea>
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
				<th>스팸방지</th>
				<td colspan="3">
					 <img src="/cap/zmSpamFree/zmSpamFree.php?zsfimg=<?php echo time();?>" id="zsfImg" alt="아래 새로고침을 클릭해 주세요." title="SpamFree.kr" style="vertical-align: inherit;"> 
					 <button type="button" style="width:75px;height:30px;cursor:pointer;" onclick="document.getElementById('zsfImg').src='/cap/zmSpamFree/zmSpamFree.php?re&zsfimg=' + new Date().getTime(); return false;">새로고침</button>
					 <input placeholder="숫자입력" type="text" name="zsfCode" id="zsfCode" style="padding-top:10px;" exp="자동입력방지코드를" >	
				</td>
			</tr>
			<tr>
				<th><label for="pwd">비밀번호</label></th>
				<td colspan="3"><input type="password" id="pwd" name="pwd" class="w270"/>
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
		var f=0;
	$(document).delegate("#add_img" , "click" , function(){ 

		if(f <4)
		{
			$("#add_img_list").append("<div class='value'><input type='text' id='imgurl"+f+"'/> <input type='botton' class='inputbtn yellow sm' value='찾아보기' onclick='document.getElementById(\"addimg"+f+"\").click();'/> <input type='file' id='addimg"+f+"' name='etcimg"+f+"' value='' style='width:0; height:0; filter:alpha(opacity=0);opacity:0' onchange='document.getElementById(\"imgurl"+f+"\").value=this.value;'/><button type='button' class='add_img_del inputbtn gray sm'> - 입력란삭제</button></div>");
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