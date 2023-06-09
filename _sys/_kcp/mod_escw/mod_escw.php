<?
    /* ============================================================================== */
    /* =   PAGE : 에스크로 상태 변경 PAGE                                           = */
    /* = -------------------------------------------------------------------------- = */
    /* =   아래의 ※ 주의 ※ 부분을 꼭 참고하시어 연동을 진행하시기 바랍니다.       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://kcp.co.kr/technique.requestcode.do                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2016   NHN KCP Inc.   All Rights Reserverd.               = */
    /* ============================================================================== */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>*** NHN KCP [AX-HUB Version] ***</title>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <link href="css/style.css" rel="stylesheet" type="text/css"/>

    <script language="javascript">
    function  jsf__go_mod( form )
    {
        if(form.mod_type.value=="mod_type_not_sel")
        {
          alert( "상태변경 구분을 선택하십시오.");
        }
        else if ( form.tno.value.length < 14 )
        {
            alert( "KCP 거래 번호를 입력하세요." );
            form.tno.focus();
            form.tno.select();
        }

        else if(form.mod_type.selectedIndex == 1 && form.deli_numb.value=="")
        {
            alert( "운송장 번호를 입력하세요." );
            form.deli_numb.focus();
            form.deli_numb.select();
        }
        else if(form.mod_type.selectedIndex == 1 && form.deli_corp.value=="")
        {
            alert( "택배 업체명을 입력하세요." );
            form.deli_corp.focus();
            form.deli_corp.select();
        }
        else if((form.mod_type.selectedIndex == 2 || form.mod_type.selectedIndex == 4) && form.vcnt_use_yn.checked && form.mod_account.value=="")
        {
            alert( "환불 수취 계좌번호를 입력하세요." );
            form.mod_account.focus();
            form.mod_account.select();
        }
        else if((form.mod_type.selectedIndex == 2 || form.mod_type.selectedIndex == 4) && form.vcnt_use_yn.checked && form.mod_depositor.value=="")
        {
            alert( "환불 수취 계좌주명을 입력하세요." );
            form.mod_depositor.focus();
            form.mod_depositor.select();
        }
        else if((form.mod_type.selectedIndex == 2 || form.mod_type.selectedIndex == 4) && form.vcnt_use_yn.checked && form.mod_bankcode.value=="mod_bankcode_not_sel")
        {
            alert( "환불 수취 은행코드를 선택해 주세요." );
        }
        else
        {
            return true ;
        }
        return false;
    }
    function typeChk( form )
    {
        if (form.mod_type.selectedIndex == 1)
        {
            type_STE2N4.style.display = "none";
            type_STE5.style.display = "none";
            type_STE1.style.display = "block";
            type_STE9.style.display = "none";
            type_STE9_1.style.display = "none";
            type_STE9_2.style.display = "none";
            type_STE9_3.style.display = "none";
            type_STE9_4.style.display = "none";
        }
        else if (form.mod_type.selectedIndex == 2 || form.mod_type.selectedIndex == 4)
        {
            type_STE1.style.display = "none";
            type_STE5.style.display = "none";
            type_STE2N4.style.display = "block";
            type_STE9.style.display = "none";
            type_STE9_1.style.display = "none";
            type_STE9_2.style.display = "none";
            type_STE9_3.style.display = "none";
            type_STE9_4.style.display = "none";
        }
        else if (form.mod_type.selectedIndex == 5)
        {
            type_STE1.style.display = "none";
            type_STE2N4.style.display = "none";
            type_STE5.style.display = "block";
            type_STE9.style.display = "none";
            type_STE9_1.style.display = "none";
            type_STE9_2.style.display = "none";
            type_STE9_3.style.display = "none";
            type_STE9_4.style.display = "none";
        }
        else if (form.mod_type.selectedIndex == 6 )
        {
            type_STE1.style.display = "none";
            type_STE2N4.style.display = "none";
            type_STE5.style.display = "none";
            type_STE9_1.style.display = "none";
            type_STE9_2.style.display = "none";
            type_STE9_3.style.display = "none";
            type_STE9_4.style.display = "none";
            type_STE9.style.display = "block";
        }
        else if (form.mod_type.selectedIndex == 7 )
        {
            type_STE1.style.display = "none";
            type_STE2N4.style.display = "none";
            type_STE5.style.display = "none";
            type_STE9_1.style.display = "block";
            type_STE9_2.style.display = "block";
            type_STE9_3.style.display = "block";
            type_STE9_4.style.display = "none";
            type_STE9.style.display = "block";
        }
        else if (form.mod_type.selectedIndex == 8 )
        {
            type_STE1.style.display = "none";
            type_STE2N4.style.display = "none";
            type_STE5.style.display = "none";
            type_STE9_1.style.display = "none";
            type_STE9_2.style.display = "none";
            type_STE9_3.style.display = "none";
            type_STE9_4.style.display = "none";
            type_STE9.style.display = "block";
        }
        else if (form.mod_type.selectedIndex == 9 )
        {
            type_STE1.style.display = "none";
            type_STE2N4.style.display = "none";
            type_STE5.style.display = "none";
            type_STE9_1.style.display = "block";
            type_STE9_2.style.display = "block";
            type_STE9_3.style.display = "block";
            type_STE9_4.style.display = "none";
            type_STE9.style.display 	= "block";
        }
        else if (form.mod_type.selectedIndex == 10 )
        {
            type_STE1.style.display = "none";
            type_STE2N4.style.display = "none";
            type_STE5.style.display = "none";
            type_STE9_1.style.display = "none";
            type_STE9_2.style.display = "block";
            type_STE9_3.style.display = "none";
            type_STE9_4.style.display = "block";
            type_STE9.style.display = "block";
        }
        else if (form.mod_type.selectedIndex == 11 )
        {
            type_STE1.style.display = "none";
            type_STE2N4.style.display = "none";
            type_STE5.style.display = "none";
            type_STE9_1.style.display = "none";
            type_STE9_2.style.display = "none";
            type_STE9_3.style.display = "none";
            type_STE9_4.style.display = "block";
            type_STE9.style.display = "block";
        }
        else if (form.mod_type.selectedIndex == 12 )
        {
            type_STE1.style.display = "none";
            type_STE2N4.style.display = "none";
            type_STE5.style.display = "none";
            type_STE9_1.style.display = "block";
            type_STE9_2.style.display = "block";
            type_STE9_3.style.display = "block";
            type_STE9_4.style.display = "block";
            type_STE9.style.display = "block";
        }
        else
        {
            type_STE1.style.display = "none";
            type_STE2N4.style.display = "none";
            type_STE5.style.display = "none";
        }
    }

    function selfDeliChk( form )
    {
        if (form.self_deli_yn.checked)
        {
            form.deli_numb.value = "0000";
            form.deli_corp.value = "자가배송";
        }
        else
        {
            form.deli_numb.value = "";
            form.deli_corp.value = "";
        }
    }

    function vcntUseChk( form )
    {
        if (form.vcnt_use_yn.checked)
        {
            type_RFND.style.display = "block";
            form.vcnt_yn.value = "Y";
        }
        else
        {
            type_RFND.style.display = "none";
            form.vcnt_yn.value = "N";
        }
    }
    </script>
</head>

<body>

<div id="sample_wrap">
<?
    /* ============================================================================== */
    /* =    상태변경 요청 입력 폼(mod_escrow_form)                                  = */
    /* = -------------------------------------------------------------------------- = */
    /* =   상태변경 요청에 필요한 정보를 설정합니다.                                = */
    /* = -------------------------------------------------------------------------- = */
?>
    <form name="mod_escrow_form" method="post" action="pp_cli_hub.php">

                 <!-- 타이틀 Start-->
                    <h1>[변경요청] <span>이 페이지는 에스크로 상태변경을 요청하는 샘플(예시) 페이지입니다.</span></h1>
                 <!-- 타이틀 End -->

                 <!-- 상단 테이블 Start -->
                    <div class="sample">
                    <p>
                    소스 수정시 소스 안에 <span>※ 주의 ※</span>표시가 포함된 문장은 가맹점의 상황에 맞게 적절히 수정</br>
                    적용하시기 바랍니다.</br>
                    <span>이 페이지는 에스크로로 결제된 건에 대한 상태변경을 요청하는 페이지 입니다.</span></br>
                    결제가 승인되면 결과값으로 KCP 거래번호(tno)값을 받을 수 있습니다.<br/>
                    가맹점에서는 이 KCP 거래번호(tno)값으로 에스크로 상태변경 요청 할 수 있습니다.
                    </p>
                  <!-- 상단 테이블 End -->
                <!-- 취소 요청 정보 입력 테이블 Start -->
                    <h2>&sdot; 에스크로 상태변경 요청</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                <!-- 요청 구분 : 에스크로 상태변경 요청 -->
                <!-- 요청 구분 : 배송시작, 즉시취소, 정산보류, 취소, 발급계좌해지 -->
                    <tr>
                        <th>상태변경 구분</th>
                        <td>
                          <select name="mod_type" onChange="javascript:typeChk(this.form);">
                            <option value="mod_type_not_sel" selected>선택하십시오</option>
                            <option value="STE1">배송시작</option>
                            <option value="STE2">즉시취소</option>
                            <option value="STE3">정산보류</option>
                            <option value="STE4">취소</option>
                            <option value="STE5">발급계좌해지</option>
                            <option value="STE9_C">구매확인후취소카드</option>
                            <option value="STE9_CP">구매확인후부분취소카드</option>
                            <option value="STE9_A">구매확인후취소계좌</option>
                            <option value="STE9_AP">구매확인후부분취소계좌</option>
                            <option value="STE9_AR">구매확인후환불 계좌</option>
                            <option value="STE9_V">구매확인후환불 가상</option>
                            <option value="STE9_VP">구매확인후부분환불 가상</option>
                          </select>
                        </td>
                    </tr>
                    <!-- KCP 거래번호(tno) -->
                    <tr>
                        <th>KCP 거래번호</th>
                        <td><input type="text" name="tno" value=""  class="frminput" size="20" maxlength="14"/></td>
                    </tr>
              </table>
              <span id="type_STE1" style="display:none">
              <table class="tbl" cellpadding="0" cellspacing="0">
                  <tr>
                      <th>자가배송여부</th>
                      <td>&nbsp;&nbsp;&nbsp;자가배송의 경우 체크&nbsp;<input type='checkbox' name='self_deli_yn' onClick='selfDeliChk(this.form)'></td>
                  </tr>
                  <tr>
                      <th>운송장번호</th>
                      <td><input type='text' name='deli_numb' value='' class="frminput" size='20' maxlength='25'></td>
                  </tr>
                  <tr>
                      <th>택배 업체명</th>
                      <td><input type='text' name='deli_corp' value='' class="frminput" size='20' maxlength='25'></td>
                  </tr>
              </table>
              </span>
              <span id="type_STE2N4" style="display:none">
              <table class="tbl" cellpadding="0" cellspacing="0">
                  <tr>
                      <th>가상계좌 거래</th>
                      <td>
                          &nbsp;&nbsp;&nbsp;가상계좌 취소&nbsp;<input type='checkbox' name='vcnt_use_yn' onClick='vcntUseChk(this.form)'>
                      </td>
                  </tr>
              </table>
              <div id="type_RFND" style="display:none">
              <table class="tbl" cellpadding="0" cellspacing="0">
                  <tr>
                      <th>환불수취계좌번호</th>
                      <td>
                          <input type='text' name='mod_account' class="frminput" value='' size='23' maxlength='50'>
                      </td>
                  </tr>
                  <tr>
                      <th>환불수취계좌주명</th>
                      <td>
                          <input type='text' name='mod_depositor' value='' class="frminput" size='23' maxlength='50'>
                      </td>
                  </tr>
                  <tr>
                      <th>환불수취은행코드</th><!-- 기타 합병된 은행이나 증권사는 매뉴얼을 참고하시기 바랍니다 -->
                      <td>
                          <select name='mod_bankcode'>
                              <option value="mod_bankcode_not_sel" selected>선택</option>
                              <option value="BK39">경남은행</option>
                              <option value="BK34">광주은행</option>
                              <option value="BK04">국민은행</option>
                              <option value="BK03">기업은행</option>
                              <option value="BK11">농협</option>
                              <option value="BK31">대구은행</option>
                              <option value="BK32">부산은행</option>
                              <option value="BK45">새마을금고</option>
                              <option value="BK07">수협</option>
                              <option value="BK88">신한은행</option>
                              <option value="BK48">신협</option>
                              <option value="BK05">외환은행</option>
                              <option value="BK20">우리은행</option>
                              <option value="BK71">우체국</option>
                              <option value="BK35">제주은행</option>
                              <option value="BK81">하나은행</option>
                              <option value="BK27">한국시티은행</option>
                              <option value="BK54">HSBC</option>
                              <option value="BK23">SC제일은행</option>
                              <option value="BK02">산업은행</option>
                              <option value="BK37">전북은행</option>
                          </select>
                      </td>
                  </tr>
              </table>
              </div>
              </span>
              <span id="type_STE5" style="display:none">
              <table class="tbl" cellpadding="0" cellspacing="0">
                  <tr>
                      <td><center>발급계좌해지 요청은 가상계좌 결제에 대해서만 이용하시기 바랍니다.</center></td>
                  </tr>
              </table>
              </span>
              <span id="type_STE9_1" style="display:none">
              <table class="tbl" cellpadding="0" cellspacing="0">
                  <tr>
                      <th>남아있는금액</th>
                          <td>
                              <input type='text' name='rem_mny' value='' size='20' maxlength='20'>원
                          </td>
                  </tr>
              </table>
              </span>
              <span id="type_STE9_2" style="display:none">
              <table class="tbl" cellpadding="0" cellspacing="0">
                  <tr>
                      <th>취소요청금액</th>
                          <td>
                              <input type='text' name='mod_mny' value='' size='20' maxlength='20'>원
                          </td>
                  </tr>
              </table>
              </span>

              <span id="type_STE9_3" style="display:none">
              <table class="tbl" cellpadding="0" cellspacing="0">
                  <tr>
                      <th>과세 취소 요청금액</th>
                          <td>
                              <input type='text' name='tax_mny' value='' size='20' maxlength='20'>원
                          </td>
                  </tr>
                  <tr>
                      <th>비과세 취소 요청금액</th>
                          <td>
                              <input type='text' name='free_mod_mny' value='' size='20' maxlength='20'>원
                          </td>
                  </tr>
                  <tr>
                      <th>부과세 취소 요청금액</th>
                          <td>
                              <input type='text' name='add_tax_mny' value='' size='20' maxlength='20'>원
                          </td>
                  </tr>
              </table>
              </span>

              <span id="type_STE9_4" style="display:none">
              <table class="tbl" cellpadding="0" cellspacing="0">
                  <tr>
                      <th>환불계좌번호</th>
                          <td>
                              <input type='text' name='a_refund_account' value='' size='23' maxlength='50'>
                          </td>
                  </tr>
                  <tr>
                      <th>환불계좌주명</th>
                          <td>
                              <input type='text' name='a_refund_nm' value='' size='23' maxlength='50'>
                          </td>
                  </tr>
                  <tr>
                      <th>환불은행코드</th>
                          <td>
                              <select name='a_bank_code'>
                              <option value="bank_code_not_sel" selected>선택</option>
                              <option value="BK39">경남은행</option>
                              <option value="BK34">광주은행</option>
                              <option value="BK04">국민은행</option>
                              <option value="BK03">기업은행</option>
                              <option value="BK11">농협</option>
                              <option value="BK31">대구은행</option>
                              <option value="BK32">부산은행</option>
                              <option value="BK45">새마을금고</option>
                              <option value="BK07">수협</option>
                              <option value="BK88">신한은행</option>
                              <option value="BK48">신협</option>
                              <option value="BK05">외환은행</option>
                              <option value="BK20">우리은행</option>
                              <option value="BK71">우체국</option>
                              <option value="BK35">제주은행</option>
                              <option value="BK81">하나은행</option>
                              <option value="BK27">한국시티은행</option>
                              <option value="BK54">HSBC</option>
                              <option value="BK23">SC제일은행</option>
                              <option value="BK02">산업은행</option>
                              <option value="BK37">전북은행</option>
                              </select>
                          </td>
                  </tr>
              </table>
              </span>
              <span id="type_STE9" style="display:none">
              <table class="tbl" cellpadding="0" cellspacing="0">
                  <tr>
                      <th>승인취소사유</th>
                          <td>
                              <select name='mod_desc_cd'>
                              <option value="" selected>선택</option>
                              <option value="CA06">기타</option>
                              </select>
                          </td>
                  </tr>
                  <tr>
                      <th>취소사유</th>
                          <td>
                              <input type='text' name='mod_desc' value='' size='40' maxlength='40'>
                          </td>
                  </tr>
              </table>
              </span>
                <!-- 에스크로 상태변경 요청/처음으로 -->
                    <!-- 변경 버튼 테이블 Start -->
                    <div class="btnset">
                    <input name="" type="submit" class="submit" value="변경요청" onclick="return jsf__go_mod(this.form);" alt="에스크로 구매확인을 요청합니다"/>
					<a href="../index.html" class="home">처음으로</a>
                    </div>
                    <!-- 변경 버튼 테이블 End -->
                </div>
            <div class="footer">
                Copyright (c) NHN KCP INC. All Rights reserved.
            </div>
        </table>
<?
    /* ============================================================================== */
    /* =   1-1. 취소 요청 필수 정보 설정                                            = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수 - 반드시 필요한 정보입니다.                                      = */
    /* = ---------------------------------------------------------------------------= */
?>
        <input type="hidden" name="req_tx"   value="mod_escrow" />
        <input type="hidden" name="vcnt_yn"  value="N" />
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   1. 취소 요청 정보 END                                                    = */
    /* ============================================================================== */
?>
    </form>
</div>
</body>
</html>

