<?
include_once(dirname(__FILE__)."/../inc/html_header.php");
?>
<!--login-->
<div class="signup_wrap">
  <div class="signup">
          <div>
            <form name="fmLogin" method="post" action="/member/login.act.php"  autocomplete="off" onSubmit="return Common.checkFormHandler.checkForm(this);">
            <input type="hidden" name="act" value="" /> 
              <div class="view">
                  <a href="javascript:void(0);" class="bt_close" id="login_close"></a>
                  <h1><img src="/img/icon/logo.png" alt="체험넷"></h1>
                  <div class="info_wrap">
                      <input type="text" placeholder="abc1234@abc.com" name="userid" tabindex="1" exp="아이디를" chktype="email">
                      <input type="password" placeholder="비밀번호를 입력하세요." name="pwd" tabindex="2" exp="비밀번호를" chktype="passchk">
                  </div>
                  <div class="agree_wrap">
                      <input type="checkbox" id="pass_log">
                      <label for="pass_log"><span>자동로그인</span></label>
                  <div class="account_wrap">
                      <ul>
                        <li><a href="/member/find_id.php">아이디찾기</a></li>
                        <li>|</li>
                        <li><a href="/member/find_password.php">비밀번호 찾기</a></li>
                      </ul>
                  </div>
                  </div>
                  <div class="button_wrap">
                      <button class="next_bt" value="로그인" type="submit">로그인</button>
                      <button class="kakao_bt" onclick="JavaScript:kakaologin()" type="button">카카오로 로그인</button>
                      <button class="naver_bt" onclick="javascript:naverlogin();" type="button">네이버로 로그인</button>
                  </div>
              </div>
            </form>
          </div>
      </div>
</div>
<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
