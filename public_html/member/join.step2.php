<?
include_once(dirname(__FILE__)."/../inc/html_header.php");

?>
   <div class="signin_wrap2">
     <div class="bg"></div>
     <div class="signin">
             <div>
               <form name="fm2" method="post" action="/member/member.act.php"  autocomplete="off" onSubmit="return Common.checkFormHandler.checkForm(this);">
               <input type="hidden" name="act" value="" />
               <input type="hidden" name="kakaoid" value="<?=$_SESSION['$user_info_json']['id']?>">
               <input type="hidden" name="referer" value="/member/join.php" />
                 <div class="view">
                     <a href="javascript:void(0);" class="bt_close" id="step2_close"></a>
                     <h1><img src="/img/icon/logo.png" alt="체험넷"></h1>
                     <div class="info_wrap">
                         <input type="text" placeholder="abc1234@abc.com" name="userid" value="" exp="아이디를" chktype="email" class="check" id="userid" tabindex="1">
                         <input type="password" placeholder="비밀번호를 입력하세요." name="pwd" value="" exp="비밀번호를" chktype="passchk" tabindex="2">
                         <input type="password" placeholder="비밀번호를 다시 입력하세요." name="pwd2" value="" exp="비밀번호 확인을" chktype="password" tabindex="3">
                         <input type="text" placeholder="닉네임을 입력하세요." name="nick" value="<?=$_SESSION['$user_info_json']['properties']['nickname']?>" exp="닉네임을" class="nick" id="nick" tabindex="4">
                         <input type="text" placeholder="연락처를 입력하세요." name="hp" value="" exp="연락처를" tabindex="5">
                     </div>
                     <div class="agree_wrap">
                         <input type="checkbox" id="info_agree" name="info_agree">
                         <label for="info_agree"><span>다양한 체험정보를 받아보고 싶어요.</span></label>
                     </div>
                     <div class="button_wrap">
                         <button class="next_bt">계정생성</button>
                     </div>
                 </div>
               </form>
             </div>
         </div>
   </div>

<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
