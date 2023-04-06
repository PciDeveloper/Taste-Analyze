<?
include_once dirname(__FILE__)."/../_header.php";
include_once(dirname(__FIlE__)."/../../lib/class.Board.php");
$navi = "게시판관리 > 게시판 리스트";
include_once dirname(__FILE__)."/../_template.php";
$board = new Board($code);
$board->_write($wdata, $encData);
?>
<script type="text/javascript">
<!--
	function WriteFn()
{
	var f = document.frm;

	if(Common.checkFormHandler.checkForm(f))
	{
		//id가 smarteditor인 textarea에 에디터에서 대입
		editor_object.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
		f.submit();
	}
}
//-->
</script>
<div class="page-header">
	<h1>
		게시판관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			<?=$board->info['name']?>
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">
<?php if ($code == "1595387805"){?>
	<form name="frm" method="post" action="board.recontent.php" enctype="multipart/form-data" autocomplete="off" >
<?php }else{?>
	<form name="frm" method="post" action="board.act.php" enctype="multipart/form-data" autocomplete="off" >
<?php }?>

<input type="hidden" name="code" value="<?=$code?>"/>
<input type="hidden" name="encData" value="<?=$encData?>"/>
<? include_once(dirname(__FILE__)."/./skin/".$arr_skin[$board->info['part']]."/write.php"); ?>

	<p class="btnC">
		<button class="btn btn-white btn-info" type="button" onclick="WriteFn()"> <i class="icon-ok bigger-110"></i> 확인 </button>
		&nbsp; &nbsp;
		<button type="button" class="btn btn-white btn-inverse" onClick="javascript:location.href='./board.list.php?code=<?=$code?>';">목록으로</button>
	</p>

</form>
</div>
</div>
</div>
<? include_once dirname(__FILE__)."/../html_footer.php"; ?>
