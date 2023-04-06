<?
include_once(dirname(__FILE__)."/../inc/html_header.php");
?>
<div id="pass_modify_wrap">
    <div class="pass_modify">
        <h1>비밀번호 찾기</h1>
  <div>

    <p>비밀번호를 찾으시려는 계정(이메일)을 입력해 주세요.<br>
    체험넷에 가입된 계정 이메일을 정확히 기입해주시길 바랍니다.</p>
  </div>
        <form name="fm2" action="/member/find.act.php" method="post" autocomplete="off" onsubmit="return Common.checkFormHandler.checkForm(this);">
        <input type="hidden" name="act" value="pwd" />
        <div>
            <input type="text" placeholder="이름을 입력하세요." name="name" exp="이름을" >
            <input type="text" placeholder="가입시 계정(이메일)을 입력하세요." name="userid" exp="계정(이메일)을" chktype="email">
        </div>
        <button>비밀번호 찾기</button>
      </form>
    </div>
</div>
<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
