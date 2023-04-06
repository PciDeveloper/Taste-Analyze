<?
if(count($vdata['reply']) > 0)
{
?>
<?
for($r=0; $r < count($vdata['reply']); $r++)
{
?>
<li class="comment_view">
		<p class="name"><?=$vdata['reply'][$r]['name']?></p>
		<p class="date"><?=$vdata['reply'][$r]['regdt']?></p>
		<ul class="modify_bt">
			<li><button type="button" onclick="comment_box('<?php echo $vdata['reply'][$r]['idx'] ?>', 'cu'); return false;">수정</button></li>
			<?if(isLogin() && !strcmp($vdata['reply'][$r]['userid'], $_SESSION['SES_USERID'])){?>
				<li><button type="button" onclick="CmtDel('<?=$vdata['reply'][$r]['idx']?>')">삭제</button></li>
			<?}else if($vdata['reply'][$r]['pwd']){?>
			<li><button type="button" onclick="Common.layerReplyPass(this, '<?=$board->info['code']?>', '<?=$vdata['reply'][$r]['idx']?>')">삭제</button></li>
			<?}else{?>
				<li><button type="button" onclick="alert('본인이 작성한 댓글만 삭제가능합니다.');">삭제</button></li>
			<?}?>
		</ul>
		<p><?=nl2br($vdata['reply'][$r]['comment'])?></p>
		<input type="hidden" name="ori_comment" id="ori_comment_<?=$vdata['reply'][$r]['idx']?>" value="<?=nl2br($vdata['reply'][$r]['comment'])?>">
		<input type="hidden" name="ori_write" id="ori_write" value="<?=nl2br($vdata['reply'][$r]['name'])?>">
</li>

<?
}
?>
<form name="cmtfm" method="post" action="/board/board.act.php">
<input type="hidden" name="code" value="<?=$board->info['code']?>"/>
<input type="hidden" name="encData" value="<?=$encData?>"/>
<input type="hidden" name="num" />
<input type="hidden" name="act" />
<input type="hidden" name="idx" />
</form>

<script type="text/javascript">
function CmtDel(num)
{
	var f = document.cmtfm;

	if(confirm("댓글을 정말 삭제하시겠습니까?"))
	{
		f.target = "ifrm";
		f.idx.value = num;
		f.act.value = "cmtd";
		f.submit();
	}
}

function comment_box(comment_id, work)
{
	var f = document.cfrm;

	document.getElementById('bidx').value = comment_id;
	f.act.value = work;
	if(work =="cu")
	{
		document.getElementById('wcmt').innerHTML = $("#ori_comment_" + comment_id).val();
		document.getElementById('wcmt_write1').value = $("#ori_write").val();

	}
	else
	{
		document.getElementById('wcmt').innerHTML ="";
		document.getElementById('wcmt_write1').value ="";
	}
}
</script>
<?
}
?>
<form name="cfrm" method="post" action="/board/board.act.php" autocomplete="off"  enctype="multipart/form-data" onSubmit="return Common.checkFormHandler.checkForm(this);">
<input type="hidden" name="code" value="<?=$board->info['code']?>"/>
<input type="hidden" name="encData" value="<?=$encData?>"/>
<input type="hidden" name="act" value="acmt" id="act"/>
 <input type="hidden" name="bidx" value="" id="bidx">
<input type="hidden" name="name" size="15" class="lbox" value="<?=$_SESSION['SES_USERNM']?>"/>
<input type="hidden" name="name" size="15" class="lbox"  id="wcmt_write1"  value="<?=$_SESSION['SES_USERNM']?>" />
<li class="comment_wrap">
		<ul>
				<li class="comment_write"><textarea id="wcmt" name="comment" rows="4"  exp="댓글 내용을 "></textarea></li>
				<li class="comment_bt"><button>등 록</button></li>
		</ul>
</li>
</form>
