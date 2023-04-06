<?
include_once(dirname(__FILE__)."/../inc/html_header.php");
$sqry = sprintf("select * from sw_member where idx= '%s'", $_REQUEST['idx']);
$row = $db->_fetch($sqry,1);
?>
<div id="pass_modify_wrap">
    <div class="pass_modify">
        <h1>아이디 확인</h1>
  <div>
    <p>가입된 아이디는 아래와 같습니다.<br>
    이제 로그인하시고 체험넷을 즐겨보세요.</p>
  </div>
        <form>
            <input type="text" placeholder="<?=$row['userid']?>" >
        </form>
        <button onclick="javascript:location.href='/member/login.php'">로그인</button>
    </div>
</div>

<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
