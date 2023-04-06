<?
include_once(dirname(__FILE__)."/../inc/html_header.php");
include_once(dirname(__FILE__)."/../lib/class.FileHandler.php");
$fhan = new FileHandler();
$agreement = $fhan->read("../conf/agreement.txt");
?>
<script>
$(document).ready(function(){

  $("#step1").click(function(){
    if($("input:checkbox[name='agree_info']").is(":checked") != true)
    {
      alert("회원가입 이용약관에 동의해 주세요.");
      $("input:checkbox[name='agree_info']").focus();
    }
    else{
       location.href='/member/join.step2.php'
    }

  });
});
  </script>
<!--가입스텝1-->
  <div class="signin_wrap">
      <div class="bg"></div>
      <div class="signin">
          <div>
              <div class="view">
                  <h1><img src="/img/icon/logo.png" alt="체험넷"></h1>
                  <div class="info_agree">
                      <p><?=$agreement?></p>
                  </div>
                  <div>
                      <input type="checkbox" id="agree_info" name="agree_info">
                      <label for="agree_info"><span>이용약관 및 개인정보이용 안내를 확인하였고 이에 동의합니다.</span></label>
                  </div>
                  <div class="button_wrap">
                      <button class="next_bt" id="step1" type="button">다음</button>
                      <button class="kakao_bt" onclick="javascript:kakaologin();" type="button">카카오로 로그인</button>
                      <button class="naver_bt" onclick="javascript:naverlogin();" type="button">네이버로 로그인</button>
                  </div>
              </div>

          </div>
      </div>
  </div>
<!--가입스텝2-->
<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
