<?
include_once dirname(__FILE__)."/../_header.php";
include_once(dirname(__FIlE__)."/../../lib/class.Board.php");
$navi = "게시판관리 > 게시판 수정";
include_once dirname(__FILE__)."/../_template.php";

$board = new Board($code);
$board->_write($wdata, $encData, "edit");
?>
<script type="text/javascript">
function Edit()
{
	var f = document.frm;

	if(Common.checkFormHandler.checkForm(f))
	{
		editor_object.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
		f.act.value = "edit";
		f.submit();
	}
}
function ImgDel(idx)
{
	var f = document.frm;

	if(confirm("첨부파일을 삭제하시겠습니까?"))
	{
		f.act.value = "imgdel";
		f.imgidx.value = idx;

		f.submit();
	}
}
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



<form name="frm" method="post" action="board.act.php" enctype="multipart/form-data" autocomplete="off" >
<input type="hidden" name="code" value="<?=$code?>"/>
<input type="hidden" name="encData" value="<?=$encData?>"/>
<input type="hidden" name="imgidx" />
<input type="hidden" name="act" />

<? include_once(dirname(__FILE__)."/./skin/".$arr_skin[$board->info['part']]."/edit.php"); ?>

<p class="btnC">
	<button type="button" class="btn btn-white btn-info" onClick="Edit();">수정하기</button>
	<button type="button" class="btn btn-white btn-inverse" onClick="javascript:location.href='./board.list.php?code=<?=$code?>';">목록으로</button>
 
</p>

</form>
</div>
</div>
</div>
<? include_once dirname(__FILE__)."/../html_footer.php"; ?>
