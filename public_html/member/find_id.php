<?
include_once(dirname(__FILE__)."/../inc/html_header.php");
?>
<div id="pass_modify_wrap">
<div class="pass_modify">
        <h1>아이디 찾기</h1>
        <div>
          <p>본인 확인을 통해 아이디를 찾을 수 있습니다.정보를 입력해주세요.</p>
        </div>
        <form name="fm2" action="/member/find.act.php" method="post" autocomplete="off" onsubmit="return Common.checkFormHandler.checkForm(this);">
        <input type="hidden" name="act" value="id" />
            <input type="text" placeholder="이름을 입력하세요." name="name" exp="이름을" >
            <input type="text" placeholder="전화번호를 입력하세요." name="hp" exp="전화번호를" >
        </form>
        <button>인증번호 전송</button>
    </div>
</div>

<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
