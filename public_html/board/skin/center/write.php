<table cellpadding="0" cellspacing="0">
	<caption class="blind">제휴문의 글 쓰기</caption>
	<colgroup>
		<col width="162px"/>
		<col width="*"/>
	</colgroup>
	<tbody>
		<tr>
			<th><label for="title">제목</label></th>
			<td><input type="text" name="title" class="input_Type" style="width:250px;" value="<?=$wdata['re_title']?>" exp="제목을" />
				<?=$wdata['secret_tag']?>
			</td>
		</tr>
			<tr>
			<th><label for="name">이름</label></th>
			<td><input type="text" id="name" name="name"  class="input_Type" style="width:150px;" title="작성자(이름)을 입력하세요"  value="<?=$_SESSION['SES_USERNM']?>" /></td>
		</tr>
		<?if($board->info['btel']){?>
		<tr>
			<th><label for="tel">전화번호</label></th>
			<td style="padding-left:10px;">
				<input type="text" name="tel1" class="w70" /> - 
				<input type="text" name="te2" class="w70" /> - 
				<input type="text" name="te3" class="w70" /> 
			</td>
		</tr>
		<tr>
			<th><label for="hp1">휴대폰번호</label></th>
			<td style="padding-left:10px;">
				<input type="text" name="hp1" class="w70" /> - 
				<input type="text" name="hp2" class="w70" /> - 
				<input type="text" name="hp3" class="w70" /> 
			</td>
		</tr>
		<?}?> 
		<?if($board->info['bemail']){?>
		<tr>
			<th><label for="mail">이메일</label></th>
			<td style="padding-left:10px;"><input type="text" name="email" id="mail" class="input_Type" chktype="email" style="width:250px"/></td>
		</tr>
		<? } ?> 
		<?
		if($board->info['upcnt'] > 0)
		{
			for($f=1; $f <= $board->info['upcnt']; $f++)
			{
		?>
		<tr>
			<th><label for="addfile">첨부파일<?=($board->info['upcnt'] > 1) ? $f : "";?></label></th>
			<td>
			<input type="text" id="txt" />
			<input type="button" class="inputbtn yellow sm" value="파일선택" onclick="document.getElementById('addfile').click();"/>
			<input type="file" id="addfile" name="upfile<?=$f?>" style="width:0; height:0; filter:alpha(opacity=0);opacity:0" onchange="document.getElementById('txt').value=this.value;"/>
			</td>
		</tr>
		<?
			}
		}
		?>
			<tr>
			<th><label for="content">내용</label></th>
			<td>
				<textarea id="content" name="content" class="contxt"><?=$wdata['re_content']?></textarea>
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
			<th><label for="spam">스팸방지</label></th>
			<td> 
			 <img src="/cap/zmSpamFree/zmSpamFree.php?zsfimg=<?php echo time();?>" id="zsfImg" alt="아래 새로고침을 클릭해 주세요." title="SpamFree.kr" style="vertical-align: inherit;"> 
			 <button type="button" style="width:75px;height:30px;cursor:pointer;" onclick="document.getElementById('zsfImg').src='/cap/zmSpamFree/zmSpamFree.php?re&zsfimg=' + new Date().getTime(); return false;">새로고침</button>
             <input placeholder="숫자입력" type="text" name="zsfCode" id="zsfCode" style="padding-top:10px;" exp="자동입력방지코드를" >	
			</td>
		</tr>
		<!--<tr>
			<th>개인정보 수집 및<br>이용안내</th>
			<td>
				<textarea name="" id="" cols="30" rows="10" readonly="readonly" class="info">개인정보 수집 및 이용안내
'원데이넷'은 (이하 '회사'는) 고객님의 개인정보를 중요시하며, "정보통신망 이용촉진 및 정보보호"에 관한 법률을 준수하고 있습니다. 회사는 개인정보취급방침을 통하여 고객님께서 제공하시는 개인정보가 어떠한 용도와 방식으로 이용되고 있으며, 개인정보보호를 위해 어떠한 조치가 취해지고 있는지 알려드립니다. 회사는 개인정보취급방침을 개정하는 경우 웹사이트 공지사항(또는 개별공지)을 통하여 공지할 것입니다.

ο 본 방침은 : 2009 년 12 월 01 일 부터 시행됩니다.

■ 수집하는 개인정보 항목
회사는 회원가입, 상담, 서비스 신청 등등을 위해 아래와 같은 개인정보를 수집하고 있습니다.
ο 수집항목 : 이름 , 로그인ID , 비밀번호 , 자택 전화번호 , 자택 주소 , 휴대전화번호 
ο 개인정보 수집방법 : 홈페이지(회원가입) 

■ 개인정보의 수집 및 이용목적
(1) 서비스 제공에 관한 계약 이행 및 서비스 제공에 따른 요금정산 
서비스 및 콘텐츠 제공, 물품배송 또는 청구서 등 발송, 본인인증, 구매 및 요금 결제, 요금추심 
(2) 회원관리 
회원제 서비스 이용에 따른 본인확인, 개인식별, 불량회원의 부정이용 방지와 비인가 사용방지, 가입의사 확인, 가입 및 가입횟수 제한, 만14세 미만 아동의 개인정보 수집 시 법정대리인 동의여부 확인, 추후 법정대리인 본인확인, 분쟁조정을 위한 기록 보존, 불만처리 등 민원처리, 고지사항 전달 
(3) 신규서비스 개발 및 마케팅, 광고 
신규서비스(제품) 개발 및 특화, 인구통계학적 특성에 따른 서비스 제공 및 광고 게재, 접속빈도 파악, 회원의 서비스 이용에 대한 통계, 이벤트 등 광고성 정보 전달

■ 개인정보의 보유 및 이용기간
원칙적으로 개인정보 수집 및 이용목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 다음의 정보에 대해서는 아래의 이유로 명시한 기간 동안 보존합니다. 
(1) 회사 내부방침에 의한 정보보유 사유 
회원이 탈퇴한 경우에도 회사는 원활한 서비스의 제공 및 부정한 서비스의 이용을 방지하기 위하여 아래와 같이 회원정보를 보관합니다. 
아이디(ID)
- 보존이유 : 서비스 이용의 혼선방지, 분쟁해결 및 수사기관의 요청에 따른 협조 
- 보존기간 : 1 년 
부정/불량이용기록 (부정/불량이용자의 개인정보 포함) 
- 보존이유 : 서비스의 부정 및 불량 이용 방지 및 부정/불량이용자의 재가입 방지 
- 보존기간 : 1 년 
(2) 관련 법령에 의한 정보보유 사유 
상법, 전자상거래 등에서의 소비자보호에 관한 법률 등 관계 법령의 규정에 의하여 보존할 필요가 있는 경우 회사는 관계 법령에서 정한 일정한 기간 동안 회원정보를 보관합니다. 이 경우 회사는 보관하는 정보를 그 보관의 목적으로만 이용하며 보존기간은 아래와 같습니다. 
계약 또는 청약철회 등에 관한 기록 
- 보존이유 : 전자상거래 등에서의 소비자보호에 관한 법률 
- 보존기간 : 5년 
대금결제 및 재화 등의 공급에 관한 기록 
- 보존이유 : 전자상거래 등에서의 소비자보호에 관한 법률 
- 보존기간 : 5년 
소비자의 불만 및 분쟁처리에 관한 기록 
- 보존이유 : 전자상거래 등에서의 소비자보호에 관한 법률 
- 보존기간 : 3년 
로그기록 
- 보존이유 : 통신비밀보호법 
- 보존기간 : 3개월</textarea>
				<p>
					<input type="checkbox" id="chk" name="chk" value="Y"/>
					<label for="chk">위의 "개인정보 수집 및 이용"에 동의하십니까?</label>
				</p>
			</td>
		</tr>-->
	</tbody>
</table>
