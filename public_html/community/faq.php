<?php
include_once(dirname(__FILE__)."/../inc/_header.php");
include_once(dirname(__FILE__)."/../inc/html_header.php");
$code = setValue($code, '1595387795');
$board = new Board($code);
$cateArr = $board->getCateArr();
$act = setValue($act, 'list');
$board->setBoardAct($act, $encData);

$strInclude = sprintf("../board/board.%s.php", $act);
?>
<!--컨텐츠-->
<div id="content">
  <div class="reservation_detail_wrap">
      <? include_once($strInclude); ?>
    </div>
</div>
<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
