<?
//$board = new Board($code);
$board->_view($vdata, $encData);
if($vdata['imgetc'])
	$exImg = explode(",", $vdata['imgetc']);
?>
<link href="/kor/css/notice.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function Del()
{
	var f = document.frm;

	if(confirm("게시물을 정말 삭제하시겠습니까?"))
	{
		f.act.value = "del";
		f.submit();
	}
}

function Edit()
{
	var f = document.frm;
	if(Common.checkFormHandler.checkForm(f))
 	{
		f.act.value="edit";
 		f.submit();
 	}
}
</script>
<div class="notice_view_wrap">
<ul>
<form name="frm" method="post" action="/board/board.act.php">
<input type="hidden" name="code" value="<?=$code?>"/>
<input type="hidden" name="encData" value="<?=$encData?>"/>
<input type="hidden" name="rurl" value="<?=$_SERVER['PHP_SELF']?>" />
<input type="hidden" name="act" />
</form>
<div class="notice_view">
		<?
			include_once(dirname(__FILE__)."/skin/".$arr_skin[$board->info[part]]."/view.php");
		?>

		<?
		/// 댓글 ////////////////////////////////////////////////////////////////////////////////
		if($board->info['bCom'])
			include_once(dirname(__FILE__)."/./board.comment.php");
		?>

</div>
	<div class="bt_wrap">
		<?php if ($_SESSION['SES_USERLV'] == '100'){?>
		<input type="button" onClick="javascript:location.href='?act=edit&code=<?=$code?>&encData=<?=$encData?>';" value="수정">
	<?php }?>
		<input type="button" onclick="javascript:location.href='?encData=<?=$encData?>';" value="목록">
  </div>

  </form>
</ul>
</div>

<script type="text/javascript">
$(document).ready(function(){
	Common.loadImgResize(800);
});
</script>
