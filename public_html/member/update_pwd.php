<?
include_once(dirname(__FILE__)."/../inc/html_header.php");
$sqry = sprintf("select * from sw_member where idx= '%s'", $_REQUEST['idx']);
$row = $db->_fetch($sqry,1);
?>
<div id="pass_modify_wrap">
    <div class="pass_modify">
        <h1>비밀번호 찾기</h1>
  <div>

    <p>비밀번호를 찾으시려는 계정(이메일)을 입력해 주세요.<br>
    체험넷에 가입된 계정 이메일을 정확히 기입해주시길 바랍니다.</p>
  </div>
        <div>
            임시 비밀번호 : <?=$row['pwd']?>
        </div>
        <button onclick="javascript:location.href='/member/login.php'">로그인</button>
    </div>
</div>
<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
