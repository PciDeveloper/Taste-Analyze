<?
include_once(dirname(__FILE__)."/../inc/_header.php");
include_once(dirname(__FILE__)."/../inc/html_header.php");
$userinfo = getUser($_SESSION['SES_USERIDX']);

if($userinfo['user_type'] == 0){
  $userid = $userinfo['userid'];
}else if($userinfo['user_type'] == 1){
  $userid = $userinfo['kakaoid'];
}else if($userinfo['user_type'] == 2){
  $userid = $userinfo['naverid'];
}
?>
<script>
function leaveFn(){
  var f = document.fm;

  if(confirm("정말 탈퇴 하시겠습니까?"))
  {
    f.act.value = "leave";
    f.submit();
  }
}

function Edit()
{
	var f = document.fm;

	if(Common.checkFormHandler.checkForm(f))
	{
		f.act.value = "edit";
		f.submit();
	}
}

function ImgDel()
{
	var f = document.fm;

	if(confirm("첨부파일을 삭제하시겠습니까?"))
	{
		f.act.value = "imgdel";
		f.submit();
	}
}
</script>
<!--계정정보 설정-->
<div id="content">
<div class="account_setting_wrap">
  <h1>계정정보설정</h1>
  <button class="account_leave" onclick="leaveFn()">회원탈퇴</button>
  <form name="fm" action="/mypage/common.act.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="idx" value="<?=$userinfo['idx']?>">
  <input type="hidden" name="act" value="">
  <div class="account_setting">
    <ul class="account_txt">
      <li>아이디(이메일)</li>
      <li>닉네임(이름)</li>
      <li>핸드폰번호</li>
      <li>현재비밀번호</li>
      <li>새 비밀번호</li>
      <li>비밀번호 확인</li>
      <li>프로필 이미지</li>
    </ul>
    <ul class="account_input">
      <li><input type="text" placeholder="<?=$userid?>" name="userid" value="<?=$userid?>" disabled></li>
      <li><input type="text" placeholder="<?=$userinfo['nick']?>" name="nick" value="<?=$userinfo['nick']?>" exp="닉네임(이름)"></li>
      <li><input type="tel" placeholder="<?=$userinfo['hp']?>" name="hp" value="<?=$userinfo['hp']?>" exp="핸드폰번호를"></li>
      <li><input type="text" placeholder="*********" name="oldpwd" value=""></li>
      <li><input type="text" placeholder="**********"  name="pwd" value=""></li>
      <li><input type="text" placeholder="**********"  name="pwd2" value=""></li>
      <li>

        <input type="hidden" name="old_pic1" value="<?=$userinfo['photo']?>">
        <?php
        if($userinfo['photo'])
        {
          if($userinfo['user_type'] == 0){
        ?>
        <img src="/upload/member/thum/thum_<?=$userinfo['photo']?>" alt="<?=$userinfo['name']?>" class="profile"> <button type="button" onclick="ImgDel();" class="hand">삭제</button>
        <?
        }else{
        ?>
          <img src="<?=$userinfo['photo']?>" alt="<?=$userinfo['name']?>" class="profile">
        <?
        }
      }else{
        ?>
        <input type="file" name="img1"  accept=".gif, .jpg, .png">
      <?php }?>
       </li>

    </ul>
  </div>
  <div class="account_align">
    <button class="account_bt" type="button" onclick="Edit()">회원정보 수정</button>
  </div>
</form> 
</div>
</div>
<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
