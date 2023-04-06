<?
include_once(dirname(__FILE__)."/../inc/_header.php");
include_once(dirname(__FILE__)."/../inc/html_header.php");
$code = setValue($code, '1595387805');
$board = new Board($code);
$cateArr = $board->getCateArr();
$act = setValue($act, 'write');
$board->setBoardAct($act, $encData);

$strInclude = sprintf("../board/board.%s.php", $act);
?>
<!--컨텐츠-->
<div id="content">
    <div id="cheheom_info">
      <div class="cheheom_menu">
        <ul>
          <li><a href="/company/company.php">회사소개</a></li>
          <li>|</li>
          <li><a href="/common/agreement.php">이용약관</a></li>
          <li>|</li>
          <li  style="color:#93CFCF"><a href="/common/private.php">개인정보 처리방침</a></li>
          <li>|</li>
          <li <?php if($getCurPage == "requests.php"){?>style="color: #7e7e7e"<?}?>><a href="/common/requests.php">가맹문의</a></li>
        </ul>
      </div>
      <div class="cheheom_privacy">
        <div style="text-align:center;">
          <img src="/img/icon/loading.png" >
          <p style="font-size:20px; color:#7e7e7e; margin:10px 0 30px 0;">컨텐츠를 준비중입니다.</p>
        </div>
      </div>
      </div>
</div>
<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
