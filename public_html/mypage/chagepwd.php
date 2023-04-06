<?
include_once(dirname(__FILE__)."/../inc/_header.php");
include_once(dirname(__FILE__)."/../inc/html_header.php");
$userinfo = getUser($_SESSION['SES_USERIDX']);
?>
<script>
function chagepwd(){
  var f = document.fm;
   if ($("#pwd").val() == ""){
    alert("비밀번호를 입력해주세요.");
    $("#pwd").focus();
  }else if ($("#pwd2").val() == ""){
    alert("비밀번호확인을 입력해주세요.");
    $("#pwd2").focus();
  }else if ($("#pwd").val() != $("#pwd2").val()){
    alert("비밀번호가 일치하지 않습니다.");
    $("#pwd").focus();
  }else if ($("#pwd").val() != "" && $("#pwd2").val() != ""){
    if(!/^[a-zA-Z0-9]{10,20}$/.test($("#pwd").val()) || $("#pwd").indexOf(' ') > -1)
    {
      alert('비밀번호는 숫자와 영문자 조합으로 10~20자리를 사용해야 합니다.');
      $("#pwd").val("");
      $("#pwd").focus();
    }
  }else{
    if(Common.checkFormHandler.checkForm(f))
    {
      f.act.value = "changepwd";
      f.submit();
    }
  }
}
</script>
<form name="fm" action="/mypage/common.act.php" method="post">
  <input type="hidden" name="idx" value="">
  <input type="hidden" name="act" value="">
</form>
<!--컨텐츠-->
<div id="pass_modify_wrap">
    <div class="pass_modify">
        <h1>비밀번호변경</h1>
  <div>
    <p class="new">새 비밀번호</p>
    <p>영어, 숫자, 특수문자가 조합된 10자리 이상 비밀번호를 입력해주세요.</p>
  </div>
        <div>
            <input type="password" placeholder="*********" name="pwd" id="pwd" value="" exp="비밀번호를">
            <input type="password" placeholder="*********" name="pwd2" id="pwd2" value="" exp="비밀번호를">
        </div>
        <button type="button" onclick="chagepwd()">비밀번호변경</button>
    </div>
</div>
<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
