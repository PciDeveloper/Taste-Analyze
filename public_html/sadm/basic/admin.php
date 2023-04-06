<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "기본설정 > 관리자정보";
include_once dirname(__FILE__)."/../_template.php";
if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);

	$sqry = sprintf("select * from %s where idx='%d'", "sw_member", $idx);
	$row = $db->_fetch($sqry, 1);

	//$exhp = explode("-", $row['hp']);
}
?>
<div class="page-header">
	<h1>
		기본설정
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			관리자정보
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<script type="text/javascript">
		function openPassword()
		{
			if($("input:checkbox[name='chgpass']").is(":checked"))
				$("#pass").css("display","block");
			else
				$("#pass").css("display","none");
		}

		function ImgDel(idx)
		{
			var f = document.fm;

			if(confirm("첨부파일을 삭제하시겠습니까?"))
			{
				f.act.value = "imgdel";
				f.submit();
			}
		}
		</script>
		<script type="text/javascript" src="./admin.js"></script>
		<form name="fm" method="post" action="./admin.act.php" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onSubmit="return Common.checkFormHandler.checkForm(this);">
		<input type="hidden" name="act" value="<?=($row['idx'] ? "edit" : "")?>" />
		<input type="hidden" name="idx" value="<?=$row['idx']?>" />
		<table class="table  table-bordered">
		<colgroup>
		<col width="130" />
		<col />
		</colgroup>
		<tbody>
		<?php if($row['idx']){?>
		<tr>
			<th>관리자 아이디</th>
			<td colspan="3"><input type="text" name="admid" id="admid" class="input-large" value="<?=$row['userid']?>" /></td>
		</tr>
		<tr>
			<th>관리자 비밀번호</th>
			<td>
				<div style="float:left;"><input type="checkbox" name="chgpass" value="Y" onclick="openPassword();" /> 변경 </div>
				<div id="pass" style="float:left;margin-left:10;display:none;">새비밀번호 : <input type="password" name="admpw" class="input-large" /></div>
			</td>
		</tr>
		<?php }else{?>
		<tr>
			<th>관리자 아이디</th>
			<td colspan="3">
				<input type="text" name="admid" id="admid" class="input-large" exp="아이디를" value="" chktype="id"/>
				<input type="hidden" name="chk_userid" exp="아이디 중복검사를 해주세요." />
				<button type="button" class="btn btn-white btn-info btn-xs" onclick="Member.checkHandler.chkUserId();" />아이디 중복체크</button>
				<span id="use_message"></span>
			</td>
		</tr>
		<tr>
			<th>관리자 비밀번호</th>
			<td>
				<input type="password" name="admpw" value="" class="input-large">
			</td>
		</tr>
		<?php }?>
		<tr>
			<th>관리자명</th>
			<td><input type="text" name="name" class="input-large" value="<?=$row['name']?>" /></td>
		</tr>
		<tr>
			<th>닉네임</th>
			<td><input type="text" name="nick" class="input-large" value="<?=$row['nick']?>" /></td>
		</tr>
		<tr>
			<th>휴대폰번호</th>
			<td>
				<input type="text" name="hp" class="input-large" value="<?=$row['hp']?>" chktype="number" />
			</td>
		</tr>
		<tr>
				<th>메모</th>
				<td>
					<textarea id="memo" name="memo" class="autosize-transition form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 112px;"><?=$row['memo']?></textarea>
				</td>
		</tr>
		</tbody>
		</table>

		<p class="btnC">
			<button type="button" onclick="javascript:location.href='./admin.list.php?encData=<?=$encData?>'" class="btn btn-white btn-danger">목록</button>
			<button type="submit"  class="btn btn-white btn-info"><?=($row['idx'] ? "수정" : "등록")?></button>
		</p>
	</form>
 		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->

<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
