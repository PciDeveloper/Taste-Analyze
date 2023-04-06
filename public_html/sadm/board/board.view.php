<?
include_once dirname(__FILE__)."/../_header.php";
include_once(dirname(__FIlE__)."/../../lib/class.Board.php");
$navi = "게시판관리 > 상세내용보기";
include_once dirname(__FILE__)."/../_template.php";
if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

$board = new Board($code);
$board->_view($vdata, $encData);
$db->_execute("update sw_board set hit = hit + 1 where idx='".$vdata['idx']."'");


if($board->info[part] > 30 && count($vdata['file']) > 0)
{
	for($i=0; $i < count($vdata['file']); $i++)
	{
		if($vdata['file'][$i]['imgtag'])
			$img_list .= $vdata['file'][$i]['imgtag'];
	}

}

?>

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


<form name="frm" method="post" action="board.act.php">
<input type="hidden" name="code" value="<?=$code?>" />
<input type="hidden" name="encData" value="<?=$encData?>" />
<input type="hidden" name="imgidx" />
<input type="hidden" name="act" />
</form>

<?
include_once(dirname(__FILE__)."/./skin/".$arr_skin[$board->info['part']]."/view.php");

/// 댓글 /////////////////////////////////////////////////////////////////////////////
if($board->info['bCom'])
	include_once("./board.reply.php");
?>

<p class="btnC">
	<? if($board->info['breply']){ ?>
	<button type="button" class="btn btn-white btn-inverse" onclick="javascript:location.href='./board.write.php?code=<?=$code?>&encData=<?=$encData?>';" >답변</button> 
	<? } ?>
	<button type="button" class="btn btn-white btn-info" onClick="javascript:location.href='./board.edit.php?code=<?=$code?>&encData=<?=$encData?>';">수정하기</button>
	<button type="button" class="btn btn-white btn-danger" onClick="Del();">삭제하기</button>
	<button type="button" class="btn btn-white btn-inverse" onClick="javascript:location.href='./board.list.php?code=<?=$code?>';">목록으로</button>
</p>


</div>
</div>
</div>
<? include_once dirname(__FILE__)."/../html_footer.php"; ?>
