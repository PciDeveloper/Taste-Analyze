<?
include_once(dirname(__FILE__)."/../inc/_header.php");
include_once(dirname(__FILE__)."/../inc/html_header.php");
$row = $db->_fetch("select * from sw_text_info");
?>
<!--컨텐츠-->
<div id="content">
    <div id="cheheom_info">
      <div class="cheheom_menu">
        <ul>
          <li><a href="/company/company.php">회사소개</a></li>
          <li>|</li>
          <li <?php if($getCurPage == "agreement.php"){?>style="color: #7e7e7e"<?}?>><a href="/common/agreement.php">이용약관</a></li>
          <li>|</li>
          <li  style="color:#93CFCF"><a href="/common/private.php">개인정보 처리방침</a></li>
          <li>|</li>
          <li <?php if($getCurPage == "requests.php"){?>style="color: #7e7e7e"<?}?>><a href="/common/requests.php">가맹문의</a></li>
        </ul>
      </div>
      <div class="cheheom_privacy">
        <p><?=$row['use_info']?></p>
      </div>
      </div>
</div>
<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
