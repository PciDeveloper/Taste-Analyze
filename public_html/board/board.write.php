<?php
$board = new Board($code);
$board->_write($wdata, $encData);
?>
<script type="text/javascript">
<!--
function Write()
{
	var f = document.frm;
	if(Common.checkFormHandler.checkForm(f))
 	{
 		f.submit();
 	}
}
//-->
</script> 
<form name="frm" method="post" action="/board/board.act.php" enctype="multipart/form-data" autocomplete="off" >
<input type="hidden" name="code" value="<?=$code?>"/>
<input type="hidden" name="encData" value="<?=$encData?>"/>
<input type="hidden" name="rurl" value="<?=$_SERVER['PHP_SELF']?>" />

<?
	include_once(dirname(__FILE__)."/skin/".$arr_skin[$board->info[part]]."/write.php");
?>


<div class="write_bt">
	<ul>
		<li><button type="button" onclick="Write()">등록</button></a></li>
		<li><button type="button" onclick="javascript:location.href='?';">취소</button></a></li>
	</ul>
</div>

</form>
