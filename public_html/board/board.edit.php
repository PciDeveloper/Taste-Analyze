<?
$board->_write($wdata, $encData, "edit");
?>
<script type="text/javascript">
function Edit()
{
	var f = document.fm;

	if(Common.checkFormHandler.checkForm(f))
	{
		editor_object.getById["notice_write"].exec("UPDATE_CONTENTS_FIELD", []);
		f.act.value = "edit";
		f.submit();
	}
}
function ImgDel(num)
{
	var f = document.fm;

	if(confirm("첨부파일을 정말 삭제 하시겠습니까?"))
	{
		f.act.value = "imgdel";
		f.imgidx.value = num;
		f.submit();
	}
}

function DelEtcImg(etcnum , etcurl)
{
	var f = document.fm;

	if(confirm("첨부파일을 정말 삭제 하시겠습니까?"))
	{
		f.act.value = "etcimgdel";
		f.etcidx.value = etcnum;
		f.etcurl.value = etcurl;
		f.submit();
	}
}

</script>
<form name="fm" method="post" action="/board/board.act.php" enctype="multipart/form-data" autocomplete="off" >
<input type="hidden" name="code" value="<?=$code?>"/>
<input type="hidden" name="encData" value="<?=$encData?>"/>
<input type="hidden" name="rurl" value="<?=$_SERVER['PHP_SELF']?>" />
<input type="hidden" name="imgidx" />
<input type="hidden" name="etcidx" />
<input type="hidden" name="etcurl" />
<input type="hidden" name="act" />


<?
	include_once(dirname(__FILE__)."/skin/".$arr_skin[$board->info[part]]."/edit.php");
?>

<div class="write_bt">
	<ul>
		<li><button type="button" onclick="Edit()">수정</button></a></li>
		<li><button type="button" onclick="javascript:location.href='?code=<?=$code?>&encData=<?=$encData?>';">목록</button></a></li>
	</ul>
</div>


</form>
