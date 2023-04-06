<?
$cmt_sqry = sprintf("select * from sw_comment where bidx='%d' order by idx desc", $encArr[idx]);

if($db->affected($cmt_sqry) > 0)
{
	$cmt_qry = $db->query($cmt_sqry);
?>
<div style="margin:10px 0 5px 0;">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<?
while($cmt_row = mysql_fetch_array($cmt_qry))
{
?>
<tr>
	<td style="padding:5px;">
		<div style="float:left; margin:2px 0 0 2px;">
			<b><?=$cmt_row[name]?></b> <span style="color:#888888; font-size:11px;">(<?=$cmt_row[ip]?>)</span>
		</div>
		<div style="float:right;">
		&nbsp;<span style="color:#B2B2B2; font-size:11px;"><?=str_replace("-",".", substr($cmt_row[regdt], 0, 10))?></span>
		<button type="button" class="btn btn-white btn-info btn-xs" onclick="CmtDel('<?=$cmt_row[idx]?>');">삭제</button> &nbsp;
		</div>

		<div style="line-height:20px; padding:7px; word-break:break-all; overflow:hidden; clear:both;">
		<?=nl2br($cmt_row[comment])?>
		</div>
					
	</td>
</tr>
<tr><td class="line"></td></tr>
<?
}
?>
</table>
<form name="cmtfm" method="post" action="board.act.php">
<input type="hidden" name="code" value="<?=$this->info[code]?>"/>
<input type="hidden" name="encData" value="<?=$encData?>"/>
<input type="hidden" name="idx" />
<input type="hidden" name="act" value="cmtd"/>
</form>

<script type="text/javascript">
function CmtDel(num)
{
	var f = document.cmtfm;

	if(confirm("댓글을 정말 삭제하시겠습니까?"))
	{
		f.target = "hiddenFrame";
		f.idx.value = num;
		f.submit();
	}
}
</script>
</div>
<?
}
?>
<div style="margin-top:10px;">
<form name="cfrm" method="post" action="./board.act.php" autocomplete="off" onsubmit="return chkForm(this);" target="hiddenFrame">
<input type="hidden" name="code" value="<?=$this->info['code']?>"/>
<input type="hidden" name="encData" value="<?=$encData?>"/>
<input type="hidden" name="bidx" value="<?=$encArr['idx']?>"/>
<input type="hidden" name="act" value="acmt" />

<table width="100%" cellpadding="0" cellspacing="1" border="0" bgcolor="#dddddd">
<tr>
	<td>
		
		<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border:1px solid #ffffff;">
		<tr>
			<td style="padding:5 0 0 5px;">
				
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="180">글쓴이 : <input type="text" name="name" size="15" class="lbox" value="<?=$_SESSION['ADMIN_NAME']?>" exp="글쓴이를 "/></td>
				</tr>
				</table>

			</td>
		</tr>
		<tr>
			<td style="padding:5px;">

				<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><textarea id="wcmt" name="comment" rows="4" style="width:100%; word-break:break-all;" exp="댓글 내용을 "></textarea></td>
					<td width="90" align="right"><input type="submit" value="댓글달기" style="width:80px;height:70px;"/></td>
				</tr>
				</table>

			</td>
		</tr>
		</table>

	</td>
</tr>
</table>
</div>