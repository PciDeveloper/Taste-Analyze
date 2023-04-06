<?
if(count($vdata['reply']) > 0)
{
?>
<div style="width:98%;margin:10px 0;">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<?
for($r=0; $r < count($vdata['reply']); $r++)
{
        $cmt_depth = ""; // 댓글단계
        $cmt_depth = strlen($vdata['reply'][$r]['wr_comment_reply']) * 20;
?>
<tr>
	<td>
		<div style="float:left; margin:2px 0 0 2px;">
			<?php if ($cmt_depth) { ?><img src="/sadm/img/icon/icon_re.gif" class="icon_reply" alt="댓글의 댓글"><?php } ?>
			<b><?=$vdata['reply'][$r]['name']?></b> <span style="color:#888888; font-size:11px;">(<?=$vdata['reply'][$r]['ip']?>)</span>
			<?php if($vdata['reply'][$r]['photo']){?>
				<img src="/sadm/img/icon/file.gif">&nbsp;:&nbsp;<a href="./download.php?file=<?=$vdata['reply'][$r]['photo']?>&org=<?=$vdata['reply'][$r]['photo']?>"><?=$vdata['reply'][$r]['photo']?></a>
			<?php }?>
		</div>
		<div style="float:right;">
		&nbsp;<span style="color:#B2B2B2; font-size:11px;"><?=str_replace("-",".", substr($vdata['reply'][$r]['regdt'], 0, 10))?></span>
		<!-- <button type="button" class="btn btn-white btn-info btn-xs" onclick="comment_box('<?php echo $vdata['reply'][$r]['idx'] ?>', 'acmt'); return false;"> 댓글</button>  &nbsp; -->
		<button type="button" class="btn btn-white btn-info btn-xs" onclick="comment_box('<?php echo $vdata['reply'][$r]['idx'] ?>', 'cu'); return false;">수정</button>  &nbsp;
		<button type="button" class="btn btn-white btn-info btn-xs" onclick="CmtDel('<?=$vdata['reply'][$r]['idx']?>');">삭제 </button>  &nbsp;
		</div>

		<div style="line-height:20px; padding:7px; word-break:break-all; overflow:hidden; clear:both;">
		<?=nl2br($vdata['reply'][$r]['comment'])?>
		<?
		if($vdata['reply'][$r]['photo'])
			printf(" <a href=\"javascript:void(window.open('../image.view.php?path=comment&img=%s', '', 'width=100, height=100, top=300, left=300'))\">%s</a>",   $vdata['reply'][$r]['photo'], getImageTag("../../upload/board", $vdata['reply'][$r]['photo'], 50, 50, "img1"));
		?>
		<input type="hidden" name="ori_comment" id="ori_comment_<?=$vdata['reply'][$r]['idx']?>" value="<?=nl2br($vdata['reply'][$r]['comment'])?>">
		<input type="hidden" name="ori_write" id="ori_write" value="<?=nl2br($vdata['reply'][$r]['name'])?>">
		</div>

	</td>
</tr>
<tr><td class="line"></td></tr>
<?
}
?>
</table>
<form name="cmtfm" method="post" action="board.act.php">
<input type="hidden" name="code" value="<?=$board->info['code']?>"/>
<input type="hidden" name="encData" value="<?=$encData?>"/>
<input type="hidden" name="num" />
<input type="hidden" name="act" />
</form>

<script type="text/javascript">

function comment_box(comment_id, work)
{
	var f = document.cfrm;

	document.getElementById('bidx').value = comment_id;
	f.act.value = work;
	if(work =="cu")
	{
		document.getElementById('wcmt').innerHTML = $("#ori_comment_" + comment_id).val();
		document.getElementById('wcmt_write1').value = $("#ori_write").val();
		document.getElementById('wcmt_write2').value = $("#ori_write").val();
		$("#wcmt_div1").css("display","none");
		$("#wcmt_div2").css("display","block");
	}
	else
	{
		document.getElementById('wcmt').innerHTML ="";
		document.getElementById('wcmt_write1').value ="";
		document.getElementById('wcmt_write2').value ="";
		$("#wcmt_div1").css("display","block");
		$("#wcmt_div2").css("display","none");
	}
}


function CmtDel(num)
{
	var f = document.cmtfm;

	if(confirm("댓글을 정말 삭제하시겠습니까?"))
	{
		f.target = "hiddenFrame";
		f.num.value = num;
		f.act.value = "cmtd";
		f.submit();
	}
}
</script>
</div>
<?
}
?>
<div style="width:98%;margin:10px 0px;border:3px solid #F8F8F8;">
<div style="border:1px solid #eeeeee;padding:5px;background-color:#ffffff;">

<form name="cfrm" method="post" action="./board.act.php" autocomplete="off"  enctype="multipart/form-data" onSubmit="return Common.checkFormHandler.checkForm(this);">
<input type="hidden" name="code" value="<?=$board->info['code']?>"/>
<input type="hidden" name="encData" value="<?=$encData?>"/>
<input type="hidden" name="act" value="acmt" id="act"/>
 <input type="hidden" name="bidx" value="" id="bidx">
<table class="table table-bordered">
<tr>
	<td style="padding:5 0 0 5px;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr  id="wcmt_div2" style="display:none;">
				<td width="180">글쓴이 : <input type="text" name="name" size="15" class="lbox" id="wcmt_write2" value="" disabled  /></td>
			</tr>
			<tr  id="wcmt_div1">
				<td width="180">글쓴이 : <input type="text" name="name" size="15" class="lbox"  id="wcmt_write1"  value="<?=$_SESSION['ADMIN_NAME']?>" exp="글쓴이를 "/></td>
			</tr>
			</table>

	</td>
<!-- </tr>
<tr>
	<td style="padding:5 0 0 5px;">

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input type="file" name="photo"></td>
		</tr>
		</table>

	</td>
</tr> -->
<tr>
	<td style="padding:5 0 0 5px;">

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><textarea id="wcmt" name="comment" rows="4" style="width:100%;height:60px;word-break:break-all;" exp="댓글 내용을 "></textarea></td>
			<td width="90" align="right"><input type="image" src="../img/btn/btn_board_comment.gif" /></td>
		</tr>
		</table>

	</td>
</tr>
</table>
</div>
</div>
